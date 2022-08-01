<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\VendorDetail;
use App\Models\Booking;
use App\Models\BusinessHours;
use App\Models\Payment;
use App\Models\Status;
use App\Models\Feedback;
use App\Models\Notification;
use App\Models\Address;
use App\Models\VendorTeam;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;
use PDF;
use Illuminate\Support\Facades\Storage;
class BookingController extends Controller
{
    public function __construct()
    {
       $this->cancelstatus = collect([ '1' , '3', '5' , '10' ]);
       $this->donestatus = collect([ '5' , '10']);
       $this->rejectedstatus = collect([ '1' , '3', '5']);
       $this->ratestatus = collect(['11']);
       $this->reschedulestatus = collect([ '5' , '8' , '10' ]);
    }

    public function availableVendorSlot(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(), [
                'vendor_id' 	=> 'required|exists:vendor_details,vendor_id',
                'booking_date'  => "required",
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 201, 'message' =>  implode(', ',$validator->messages()->all())], 200);
            }
            $slots = BusinessHours::where('vendor_id', $request->vendor_id)->first();
            $bookings = Booking::where('vendor_id', $request->vendor_id)
              						->where('employee_id','=',$request->employee_id)
              						->whereDate('booking_date',$request->booking_date)
              						->select('id','booking_time','status_id')
              						->get();

            $blocktimes =DB::table('blocktime')->where('vendor_id', $request->vendor_id)
                                        ->where('employee_id','=',$request->employee_id)
                                        ->whereDate('booking_date',$request->booking_date)
                                        ->select('id','booking_time','expct_end_time')->get();

            if ($slots) {
            	$data = collect([]);
				$day = date('D', strtotime($request->booking_date));
				$start = '';
				$end = '';
                $isworking = true;

                switch ($day) {
                    case 'Mon':
                        $start = strtotime($slots->timeMonStart);
                        $end =  strtotime($slots->timeMonEnd) ;
                        $isworking = ($slots->dayMondayStatus == 1) ? true : false;
                        break;
                    case 'Tue':
                        $start =  strtotime($slots->timeTueStart);
                        $end =  strtotime($slots->timeTueEnd) ;
                        $isworking = ($slots->dayTuesdayStatus == 1) ? true : false;
                        break;
                    case 'Wed':
                        $start =  strtotime($slots->timeWedStart);
                        $end =  strtotime($slots->timeWedEnd) ;
                        $isworking = ($slots->dayWednesdayStatus == 1) ? true : false;
                    break;
                    case 'Thu':
                        $start =  strtotime($slots->timeThuStart);
                        $end =  strtotime($slots->timeThuEnd);
                        $isworking = ($slots->dayThursdayStatus == 1) ? true : false;
                    break;
                    case 'Fri':
                        $start =  strtotime($slots->timeFriStart);
                        $end =  strtotime($slots->timeFriEnd) ;
                        $isworking = ($slots->dayFridayStatus == 1) ? true : false;
                    break;
                    case 'Sat':
                        $start =  strtotime($slots->timeSatStart);
                        $end =  strtotime($slots->timeSatEnd);
                        $isworking = ($slots->daySaturdayStatus == 1) ? true : false;
                    break;
                    case 'Sun':
                        $start =  strtotime($slots->timeSunStart);
                        $end =  strtotime($slots->timeSunEnd) ;
                        $isworking = ($slots->daySundayStatus == 1) ? true : false;
                    break;
                    default:
                    	$start =  strtotime($slots->timeMonFriStart);
                        $end =  strtotime($slots->timeMonFriEnd);
                        $isworking = ($slots->dayMonFriStatus == 1) ? true : false;
                    break;
                }

                if($isworking) {


                    while ($start < $end)
    				{
                        $blocktime = $blocktimes->where('booking_time','<',date('H:i:s',strtotime('+15 minutes',$start)))->where('expct_end_time', '>', date('Y-m-d H:i:s',strtotime($request->booking_date.' '.date('H:i:s',$start))))->first();


                        if(empty($blocktime))
                        {

                            $existbooking = $bookings->where('booking_time','=',date('H:i:s',$start))->first() ;

                            $timebefore =  getCurrentTime() > date('Y-m-d H:i:s',strtotime($request->booking_date.' '.date('H:i:s',$start)));
        					$data->push([
        						'time' => date('H:i',$start),
        						'is_booked' =>  ($existbooking || $timebefore) ? true : false ,
        			        ]);
                        }

    					$start = strtotime('+15 minutes',$start);
    				}
                }
                return response()->json(['status' => 200, 'message' => 'Data successfully retrieved','data' => $data ], 200);
            }
            return response()->json(['status' => 201, 'message' => 'Error in Data retrieved' ], 200);
        }
        catch(\Exception $e)
        {
            return response()->json(['status' => 201, 'message' => $e->getMessage() ], 500);
        }
    }

    public function booking(Request $request)
    {
        try
        {
        	$userid = $request->user()->id;
            $validator = Validator::make($request->all(), [
                'vendor_id' 	=> 'required|exists:vendor_details,vendor_id',
                'service_id' 	=> 'required|exists:services,id',
                'status_id' 	=> 'required|exists:statuses,id',
                'treatment_id' 	=> 'required|exists:treatments,id',
                'employee_id' 	=> 'required|exists:vendor_teams,id',
                'address_id' 	=> 'nullable|exists:addresses,id',
                'booking_date'  => "required",
                'booking_time'  => "required",
                'expct_amount'  => "required",
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 201, 'message' =>  implode(', ',$validator->messages()->all())], 200);
            }
            $booking_time = date('H:i',strtotime($request->booking_time));
            $expct_end_time =strtotime('+15 minutes', strtotime($request->booking_date.' '.$request->booking_time));
            $vendoraddress = '';
            $address = Address::where('user_id',$request->vendor_id)->select('id','address_line1','address_line2','state','city','location_address')->first();
            $vendoraddress = isset($address->location_address) ? $address->location_address : $address->address_line1.' '. $address->address_line2.' '.$address->city ;


            if (availableBookingSlot($request->vendor_id, $request->employee_id, $request->booking_date.' '.$request->booking_time )) {

            	$booking = Booking::create([
	            	'user_id' => $userid,
	                'vendor_id' => $request->vendor_id,
	                'service_id' => $request->service_id,
	                'treatment_id' => $request->treatment_id,
	               	'employee_id' => $request->employee_id,
	               	'address_id' => isset($request->address_id) ? $request->address_id : null,
	               	'orderid' => $request->vendor_id.'_'.date('YmdHis'),
	                'booking_date' => $request->booking_date,
	                'booking_time' => $booking_time,
                    'full_amount' => $request->discount ? $request->expct_amount - (($request->discount / 100) * $request->expct_amount) : $request->expct_amount ,
                    //'full_amount' => $request->discount ? $request->expct_amount - $request->discount : $request->expct_amount ,
                    'final_amount' => $request->discount ? $request->expct_amount - (($request->discount / 100) * $request->expct_amount) : $request->expct_amount,
                    //'final_amount' => $request->discount ? $request->expct_amount - $request->discount : $request->expct_amount,
                    'discount_amount' => $request->discount ? ($request->discount / 100) * $request->expct_amount : 0.00 ,
                    //'discount_amount' => $request->discount ? $request->discount : 0.00 ,
	                'expct_amount' => $request->expct_amount,
	                'expct_end_time' => date('Y-m-d H:i',$expct_end_time),
	                // 'address' => isset($request->address) ? $request->address : '',
                    'address' => isset($vendoraddress) ? $vendoraddress : '',
	                'latitude' => isset($request->latitude) ? $request->latitude : '',
	                'longitude' => isset($request->longitude) ? $request->longitude : '',
	            ]);
	            $data = bookingInfoData($booking->id);
                $data['cancel'] = ($this->cancelstatus->contains($data->status_id) && $data->user_id == $userid) ? true : false ;
                $data['done'] = ($this->donestatus->contains($data->status_id)) ? true : false ;
                $data['rejected'] = ($this->rejectedstatus->contains($data->status_id) && $data->vendor_id == $userid) ? true : false ;
                $data['rate'] = ($this->ratestatus->contains($data->status_id) && $data->user_id == $userid) ? true : false ;
                $data['reschedule'] =($this->reschedulestatus->contains($data->status_id) && $data->user_id == $userid) ? true : false ;
                $user = User::find($booking->user_id);
                $notification = new Notification();
                $notification->title = 'Booking Request';
                $notification->message = 'New request from '.$user->name;
                $notification->type = 'Appointment';
                $notification->user_id  = $booking->vendor_id;
                $notification->type_id  = $booking->id;
                $notification->booking_id   = $booking->id;
                $notification->created_at = date('d-m-Y H:i:s');
                $notification->save();
                $notifydata = array('title' => 'Hey, “'.$request->user()->name.'” made a booking at “'.$request->booking_date.' '.$request->booking_time .'”? Just more appealing to eye and easier to check if user calls vendor for any reasons', 'message' => date('d-m-Y',strtotime($request->booking_date)), 'status' =>  'Open', 'booking_id' =>  $booking->id);
                sendPushNotification($notifydata, $request->vendor_id);

                return response()->json(['status' => 200, 'message' => 'Data successfully retrieved','data' => $data ], 200);
            }
            return response()->json(['status' => 201, 'message' => 'Error in Booking' ], 200);
        }
        catch(\Exception $e)
        {
            return response()->json(['status' => 201, 'message' => $e->getMessage() ], 500);
        }
    }

    public function bookingActiveStatus(Request $request)
    {
        try
        {
        	$userid = $request->user()->id;
            $validator = Validator::make($request->all(), [
                'booking_id' 	=> 'required|exists:bookings,id',
                'status'    => 'required|exists:statuses,status',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 201, 'message' =>  implode(', ',$validator->messages()->all())], 200);
            }
            $status = Status::where('status','=',$request->status)->pluck('id')->first();
            $booking = Booking::where('id', $request->booking_id)->first();
            if($request->amount)
            {
                $booking->full_amount = $request->amount ;
            }
            $booking->status_id = $status;
            if ($booking->save()) {

                return response()->json(['status' => 200, 'message' => 'Booking status updated successfully','data' => $booking ], 200);
            }
            return response()->json(['status' => 201, 'message' => 'Error in Booking' ], 200);
        }
        catch(\Exception $e)
        {
            return response()->json(['status' => 201, 'message' => $e->getMessage() ], 500);
        }
    }

    public function bookingInfo(Request $request)
    {
        try
        {
        	$userid = $request->user()->id;
            $validator = Validator::make($request->all(), [
                'booking_id' 	=> 'required|exists:bookings,id',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 201, 'message' =>  implode(', ',$validator->messages()->all())], 200);
            }
            $data = bookingInfoData($request->booking_id);
            $data['cancel'] = ($this->cancelstatus->contains($data->status_id) && $data->user_id == $userid) ? true : false ;
            $data['done'] = ($this->donestatus->contains($data->status_id)) ? true : false ;
            $data['rejected'] = ($this->rejectedstatus->contains($data->status_id) && $data->vendor_id == $userid) ? true : false ;
            $data['rate'] = ($this->ratestatus->contains($data->status_id) && $data->user_id == $userid) ? true : false ;
            $data['reschedule'] =($this->reschedulestatus->contains($data->status_id) && $data->user_id == $userid) ? true : false ;
            if ($data) {
                return response()->json(['status' => 200, 'message' => 'Booking is available','data' => $data ], 200);
            }
            return response()->json(['status' => 201, 'message' => 'Booking not available' ], 200);
        }
        catch(\Exception $e)
        {
            return response()->json(['status' => 201, 'message' => $e->getMessage() ], 500);
        }
    }
    public function bookingPaymentStatus(Request $request)
    {
        try
        {
        	$userid = $request->user()->id;
            $validator = Validator::make($request->all(), [
                'booking_id' 	=> 'required|exists:bookings,id',
                'amount' => 'required',
                'status'    => 'required|exists:statuses,status',
                // 'transaction_id' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 201, 'message' =>  implode(', ',$validator->messages()->all())], 200);
            }
            $data = bookingInfoData($request->booking_id);
            $data['cancel'] = ($this->cancelstatus->contains($data->status_id) && $data->user_id == $userid) ? true : false ;
            $data['done'] = ($this->donestatus->contains($data->status_id)) ? true : false ;
            $data['rejected'] = ($this->rejectedstatus->contains($data->status_id) && $data->vendor_id == $userid) ? true : false ;
            $data['rate'] = ($this->ratestatus->contains($data->status_id) && $data->user_id == $userid) ? true : false ;
            $data['reschedule'] =($this->reschedulestatus->contains($data->status_id) && $data->user_id == $userid) ? true : false ;

            $status = Status::where('status','=',$request->status)->pluck('id')->first();
            if ($payment = Payment::create([
	            	'user_id' => $userid,
	                'vendor_id' => $data->vendor_id,
	                'booking_id' => $request->booking_id,
	                'amount' => $request->amount,
	               	'transaction_id' => isset($request->transaction_id) ? $request->transaction_id :null,
	               	'transaction_at' => date('Y-m-d H:i:s'),
	               	'description' => isset($request->description) ? $request->description : '',
	               	'response' => isset($request->response) ? $request->response : null,
	                'status' => $status,
	            ])) {
            	$booking = Booking::where('id', $request->booking_id)->update([
            		'status_id'  => $status,
            		'transaction_id'  => $request->transaction_id,
            		'payment_id'  => $payment->id,
            	]);
                if(Payment::where('user_id',$userid)->where('status','=','5')->count() == 1)
                {
                    updateReferralEarnAmount($userid);
                }
                if(Payment::where('vendor_id',$data->vendor_id)->where('status','=','5')->count() == 1)
                {
                    updateReferralEarnAmount($data->vendor_id);
                }
                return response()->json(['status' => 200, 'message' => 'Payment is available','data' => $data ], 200);
            }
            return response()->json(['status' => 201, 'message' => 'Booking not available' ], 200);
        }
        catch(\Exception $e)
        {
            return response()->json(['status' => 201, 'message' => $e->getMessage() ], 500);
        }
    }

    public function getstripeToken(Request $request)
    {
        $userid = $request->user()->id;
        $validator = Validator::make($request->all(), [
            'amount' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 201, 'message' =>  implode(', ',$validator->messages()->all())], 200);
        }
        $token = generatestripeToken($request->amount);

        return response()->json(['status' => 200,'message' => 'Payment succesfull','data' => $token ], 200);
    }

    public function customerUpcomingBooking(Request $request)
    {
        try {
            $userid = $request->user()->id;
            $bookings = Booking::with('vendorinfo','employeeinfo','statusinfo','serviceinfo' ,'treatmentinfo')
                        ->where('user_id', $userid)
                        ->whereIn('status_id', ['1','3','4','5','6','10','14'])
                        ->whereDate('booking_date', '>=', date('Y-m-d'))
                        ->select('id','user_id','vendor_id','employee_id','service_id','treatment_id','booking_date','booking_time','orderid','start_time','status_id','address','latitude','longitude','expct_amount','final_amount','discount_amount','full_amount')
                        ->orderBy('booking_date', 'ASC')
                        ->orderBy('booking_time', 'ASC')
                        ->orderBy('id', 'ASC')
                        ->paginate(70);
            if ($bookings) {
                $bookings->getCollection()->transform(function ($value) use($userid) {
                    $value['pending'] = ($value->status_id == 3) ? true : false ;
                    $value['cancel'] = ($value->status_id == 2) ? true : false ;
                    $value['done'] =    ($value->status_id == 11) ? true : false ;
                    $value['rejected'] = ($value->status_id == 8) ? true : false ;
                    $value['rate'] = ($value->status_id ==7) ? true : false ;
                    $value['reschedule'] = ($value->status_id == 10) ? true : false ;
                    $value['booking_time'] = date('H:i', strtotime($value['booking_time']));
                    return $value;
                });
                return response()->json(['status' => 200, 'message' => 'Data successfully retrieved', 'data' => $bookings ], 200);
            }
            return response()->json(['status' => 201, 'message' => 'Error in data retrieved'], 404);
        } catch (\Exception $e) {
            return response()->json(['status' => 201, 'message' => $e->getMessage()], 500);
        }
    }

    public function customerPreviousBooking(Request $request)
    {
        try {
            $userid = $request->user()->id;
            $bookings = Booking::with('vendorinfo','employeeinfo','statusinfo','serviceinfo' ,'treatmentinfo')
                        ->where('user_id', $userid)
                        ->whereIn('status_id', ['2','7','8','9','11','12','13'])
                        // ->whereDate('booking_date', '<', date('Y-m-d'))
                        ->select('id','user_id','vendor_id','employee_id','service_id','treatment_id','booking_date','booking_time','orderid','start_time','status_id','address','latitude','longitude','expct_amount','final_amount','discount_amount','full_amount')
                        ->orderBy('booking_date', 'DESC')
                        ->orderBy('booking_time', 'DESC')
                        ->orderBy('id', 'DESC')
                        ->paginate(70);
            if ($bookings) {
                $bookings->getCollection()->transform(function ($value) use($userid) {
                    $value['pending'] = ($value->status_id == 3) ? true : false ;
                    $value['cancel'] = ($value->status_id == 2) ? true : false ;
                    $value['done'] =    ($value->status_id == 11) ? true : false ;
                    $value['rejected'] = ($value->status_id == 8) ? true : false ;
                    $value['rate'] = ($value->status_id ==7) ? true : false ;
                    $value['reschedule'] = ($value->status_id == 10) ? true : false ;
                    $value['booking_time'] = date('H:i', strtotime($value['booking_time']));
                    return $value;
                });
                return response()->json(['status' => 200, 'message' => 'Data successfully retrieved', 'data' => $bookings ], 200);
            }
            return response()->json(['status' => 201, 'message' => 'Error in data retrieved'], 404);
        } catch (\Exception $e) {
            return response()->json(['status' => 201, 'message' => $e->getMessage()], 500);
        }
    }

    public function vendorRequestBooking(Request $request)
    {
        try {
            $userid = $request->user()->id;
            $bookings = Booking::with('userinfo','employeeinfo','statusinfo','serviceinfo' ,'treatmentinfo')
                        ->where('vendor_id', $userid)
                        ->whereIn('status_id', ['5','10','14'])
                        ->select('id','user_id','vendor_id','employee_id','service_id','treatment_id','booking_date','booking_time','orderid','start_time','status_id','address','latitude','longitude','expct_amount','final_amount','discount_amount','full_amount')
                        ->orderBy('booking_date', 'DESC')
                        ->orderBy('booking_time', 'DESC')
                        ->orderBy('id', 'DESC')
                        ->paginate(70);
            if ($bookings) {
                $bookings->getCollection()->transform(function ($value) use($userid) {
                    $value['pending'] = ($value->status_id == 3) ? true : false ;
                    $value['cancel'] = ($value->status_id == 2) ? true : false ;
                    $value['done'] =    ($value->status_id == 11) ? true : false ;
                    $value['rejected'] = ($value->status_id == 8) ? true : false ;
                    $value['rate'] = ($value->status_id ==7) ? true : false ;
                    $value['reschedule'] = ($value->status_id == 10) ? true : false ;
                    $value['booking_time'] = date('H:i', strtotime($value['booking_time']));
                    return $value;
                });

                return response()->json(['status' => 200, 'message' => 'Data successfully retrieved', 'data' => $bookings ], 200);
            }
            return response()->json(['status' => 201, 'message' => 'Error in data retrieved'], 404);
        } catch (\Exception $e) {
            return response()->json(['status' => 201, 'message' => $e->getMessage()], 500);
        }
    }

    public function vendorUpcomingBooking(Request $request)
    {
        try {
            $userid = $request->user()->id;
            $bookings = Booking::with('userinfo','employeeinfo','statusinfo','serviceinfo' ,'treatmentinfo')
                        ->where('vendor_id', $userid)
                        ->whereIn('status_id', ['6'])
                        // ->whereDate('booking_date', '>=', date('Y-m-d'))
                        ->select('id','user_id','vendor_id','employee_id','service_id','treatment_id','booking_date','booking_time','orderid','start_time','status_id','address','latitude','longitude','expct_amount','final_amount','discount_amount','full_amount')
                        ->orderBy('booking_date', 'DESC')
                        ->orderBy('booking_time', 'DESC')
                        ->orderBy('id', 'DESC')
                        ->paginate(70);
            if ($bookings) {
                $bookings->getCollection()->transform(function ($value) use($userid) {
                    $value['pending'] = ($value->status_id == 3) ? true : false ;
                    $value['cancel'] = ($value->status_id == 2) ? true : false ;
                    $value['done'] =    ($value->status_id == 11) ? true : false ;
                    $value['rejected'] = ($value->status_id == 8) ? true : false ;
                    $value['rate'] = ($value->status_id ==7) ? true : false ;
                    $value['reschedule'] = ($value->status_id == 10) ? true : false ;
                    $value['booking_time'] = date('H:i', strtotime($value['booking_time']));
                    return $value;
                });
                return response()->json(['status' => 200, 'message' => 'Data successfully retrieved', 'data' => $bookings ], 200);
            }
            return response()->json(['status' => 201, 'message' => 'Error in data retrieved'], 404);
        } catch (\Exception $e) {
            return response()->json(['status' => 201, 'message' => $e->getMessage()], 500);
        }
    }
    public function vendorPreviousBooking(Request $request)
    {
        try {
            $userid = $request->user()->id;
            $bookings = Booking::with('userinfo','employeeinfo','statusinfo','serviceinfo' ,'treatmentinfo')
                        ->where('vendor_id', $userid)
                        ->whereIn('status_id', ['2','3','7','8','9','11'])
                        // ->whereDate('booking_date', '<', date('Y-m-d'))
                        ->select('id','user_id','vendor_id','employee_id','service_id','treatment_id','booking_date','booking_time','orderid','start_time','status_id','address','latitude','longitude','expct_amount','final_amount','discount_amount','full_amount')
                        ->orderBy('booking_date', 'DESC')
                        ->orderBy('booking_time', 'DESC')
                        ->orderBy('id', 'DESC')
                        ->paginate(70);
            if ($bookings) {
                $bookings->getCollection()->transform(function ($value) use($userid) {
                    $value['pending'] = ($value->status_id == 3) ? true : false ;
                    $value['cancel'] = ($value->status_id == 2) ? true : false ;
                    $value['done'] =    ($value->status_id == 11) ? true : false ;
                    $value['rejected'] = ($value->status_id == 8) ? true : false ;
                    $value['rate'] = ($value->status_id ==7) ? true : false ;
                    $value['reschedule'] = ($value->status_id == 10) ? true : false ;
                    $value['booking_time'] = date('H:i', strtotime($value['booking_time']));
                    return $value;
                });
                return response()->json(['status' => 200, 'message' => 'Data successfully retrieved', 'data' => $bookings ], 200);
            }
            return response()->json(['status' => 201, 'message' => 'Error in data retrieved'], 404);
        } catch (\Exception $e) {
            return response()->json(['status' => 201, 'message' => $e->getMessage()], 500);
        }
    }

    public function vendorTransectionList(Request $request)
    {
        try {
            $userid = $request->user()->id;
            $payments = Payment::with('userinfo','vendorinfo','bookinginfo')
                        ->where('vendor_id', $userid)
                        ->where('status','=','5')
                        ->select('id','user_id', 'vendor_id', 'booking_id', 'amount', 'transaction_id', 'transaction_at', 'description', 'response', 'status', 'created_at')
                        ->latest()
                        ->paginate(70);
            if($payments) {
                $monthly = Payment::where('vendor_id','=', $userid)->where('status','=', 5)->whereBetween('transaction_at',
                            [Carbon::now()->subYear(), Carbon::now()]
                        )->select( DB::raw('sum(amount) as earning'), DB::raw("DATE_FORMAT(transaction_at,'%M') as month"), DB::raw("DATE_FORMAT(transaction_at,'%Y') as year"))->groupBy('year','month')->get();

                $yearly = Payment::where('vendor_id','=', $userid)->where('status','=', 5)->select( DB::raw('sum(amount) as earning'), DB::raw("DATE_FORMAT(transaction_at,'%Y') as year"))->groupBy('year')->get();
                $thismonth = $monthly->where('month','=',date('F'))->where('year','=',date('Y'))->first();
                $thisyear = $yearly->where('year','=',date('Y'))->first();
                $total_earning = collect([
                    "monthly" => isset($thismonth['earning']) ? $thismonth['earning'] : 0,
                    "yearly" => isset($thisyear['earning']) ? $thisyear['earning'] : 0,
                    "total_earning" => $yearly->sum('earning'),
                ]);
                $collection = collect([ 'earning_monthly' =>  $monthly , 'earning_yearly' =>  $yearly, 'total_earning' =>  $total_earning]);
                $data = $collection->merge($payments);
                return response()->json(['status' => 200, 'message' => 'Data successfully retrieved', 'data' => $data], 200);
                // return response()->json(['status' => 200, 'message' => 'Data successfully retrieved', 'data' => $payments, 'earnings' => $transectons ], 200);
            }
            return response()->json(['status' => 201, 'message' => 'Error in data retrieved'], 404);
        } catch (\Exception $e) {
            return response()->json(['status' => 201, 'message' => $e->getMessage()], 500);
        }
    }

    public function deleteTransection(Request $request)
    {
        try
        {
            $userid = $request->user()->id;
            $validator = Validator::make($request->all(), [
                'payment_id'    => 'required|exists:payments,id',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 201, 'message' =>  implode(', ',$validator->messages()->all())], 200);
            }
            Booking::where('payment_id',$request->payment_id)->withTrashed()->update(['payment_id' => null]);
            if(Payment::where('id', $request->payment_id)->delete()) {
                return response()->json(['status' => 200, 'message' => 'Data deleted successfully'], 200);
            }
            return response()->json(['status' => 201, 'message' => 'Error in data deleted'], 404);
        } catch (\Exception $e) {
            return response()->json(['status' => 201, 'message' => $e->getMessage()], 500);
        }
    }

    public function customerTransectionList(Request $request)
    {
        try {
            $userid = $request->user()->id;
            $payments = Payment::with('userinfo','vendorinfo','bookinginfo')
                        ->where('user_id', $userid)
                        ->where('status','=','5')
                        ->select('id','user_id', 'vendor_id', 'booking_id', 'amount', 'transaction_id', 'transaction_at', 'description', 'response', 'status', 'created_at')
                        ->latest()
                        ->paginate(70);
            if($payments) {
                return response()->json(['status' => 200, 'message' => 'Data successfully retrieved', 'data' => $payments ], 200);
            }
            return response()->json(['status' => 201, 'message' => 'Error in data retrieved'], 404);
        } catch (\Exception $e) {
            return response()->json(['status' => 201, 'message' => $e->getMessage()], 500);
        }
    }

    public function cancelBooking(Request $request)
    {
        try
        {
            $userid = $request->user()->id;
            $validator = Validator::make($request->all(), [
                'booking_id'        => 'required|exists:bookings,id',
                // 'canceled_reson'    => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 201, 'message' =>  implode(', ',$validator->messages()->all())], 200);
            }
            $status = Status::where('status','=','Canceled')->pluck('id')->first();
            if ($booking = Booking::where('id', $request->booking_id)->update([
                    'status_id'  => $status,
                    'canceled'  => true,
                    'canceled_reson'  => isset($request->canceled_reson) ? $request->canceled_reson : '',
                ])) {

                $data = bookingInfoData($request->booking_id);
                $data['pending'] = ($data->status_id == 3) ? true : false ;
                $data['cancel'] = ($data->status_id == 2) ? true : false ;
                $data['done'] =    ($data->status_id == 11) ? true : false ;
                $data['rejected'] = ($data->status_id == 8) ? true : false ;
                $data['rate'] = ($data->status_id ==7) ? true : false ;
                $data['reschedule'] = ($data->status_id == 10) ? true : false ;
                // $notifydata = array('title' => 'Your Booking has been canceled', 'message' => date('d-m-Y',strtotime($data->booking_date)), 'status' =>  'Open', 'booking_id' =>  $data->id);
                // sendPushNotification($notifydata, $data->user_id);
                return response()->json(['status' => 200, 'message' => 'Booking Cancel successfully','data' => $data ], 200);
            }
            return response()->json(['status' => 201, 'message' => 'Error in Booking Cancel' ], 200);
        }
        catch(\Exception $e)
        {
            return response()->json(['status' => 201, 'message' => $e->getMessage() ], 500);
        }
    }
    public function doneBooking(Request $request)
    {
        try
        {
            $userid = $request->user()->id;
            $validator = Validator::make($request->all(), [
                'booking_id'  => 'required|exists:bookings,id',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 201, 'message' =>  implode(', ',$validator->messages()->all())], 200);
            }
            $status = Status::where('status','=','Completed')->pluck('id')->first();
            if ($booking = Booking::where('id', $request->booking_id)->update([
                    'status_id'  => $status,
                ])) {
                $data = bookingInfoData($request->booking_id);
                $data['pending'] = ($data->status_id == 3) ? true : false ;
                $data['cancel'] = ($data->status_id == 2) ? true : false ;
                $data['done'] =    ($data->status_id == 11) ? true : false ;
                $data['rejected'] = ($data->status_id == 8) ? true : false ;
                $data['rate'] = ($data->status_id ==7) ? true : false ;
                $data['reschedule'] = ($data->status_id == 10) ? true : false ;

                $booking = Booking::find($request->booking_id);
                $notification = new Notification();
                $notification->type = 'Review and Rating';
                $notification->type_id = $booking->id;
                $notification->user_id = $booking->user_id;
                $notification->title = "Review & Rating";
                $notification->message = "Please Rate & Review for the your last booking ". $booking->id;
                $notification->created_at = date('d-m-Y H:i:s');
                $notification->save();

                return response()->json(['status' => 200, 'message' => 'Booking Completed successfully','data' => $data ], 200);
            }
            return response()->json(['status' => 201, 'message' => 'Error in Booking Completed' ], 200);
        }
        catch(\Exception $e)
        {
            return response()->json(['status' => 201, 'message' => $e->getMessage() ], 500);
        }
    }
    public function rejectBooking(Request $request)
    {
        try
        {
            $userid = $request->user()->id;
            $validator = Validator::make($request->all(), [
                'booking_id'        => 'required|exists:bookings,id',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 201, 'message' =>  implode(', ',$validator->messages()->all())], 200);
            }
            $status = Status::where('status','=','Rejected')->pluck('id')->first();
            if ($booking = Booking::where('id', $request->booking_id)->update([
                    'status_id'  => $status,
                ])) {
                $data = bookingInfoData($request->booking_id);
                $data['pending'] = ($data->status_id == 3) ? true : false ;
                $data['cancel'] = ($data->status_id == 2) ? true : false ;
                $data['done'] =    ($data->status_id == 11) ? true : false ;
                $data['rejected'] = ($data->status_id == 8) ? true : false ;
                $data['rate'] = ($data->status_id ==7) ? true : false ;
                $data['reschedule'] = ($data->status_id == 10) ? true : false ;
                $notification = new Notification();

                $notification->title = 'Booking Cancel';
                $notification->message = 'Your booking has been cancelled.';
                $notification->type = 'My Appointment';
                $notification->user_id = $booking->user_id;
                $notification->type_id = $booking->id;
                $notification->booking_id = $booking->id;
                $notification->created_at = date('d-m-Y H:i:s');
                $notification->save();
                $notification->title = 'Booking Cancel';
                $notification->message = 'A Booking has been cancelled.';
                $notification->type = 'Appointment';
                $notification->user_id = $booking->vendor_id;
                $notification->type_id = $booking->id;
                $notification->booking_id = $booking->id;
                $notification->created_at = date('d-m-Y H:i:s');
                $notification->save();
                $notifydata = array('title' => 'Your Booking has been canceled', 'message' => date('d-m-Y',strtotime($data->booking_date)), 'status' =>  'Open', 'booking_id' =>  $data->id);
                sendPushNotification($notifydata, $data->vendor_id);
                return response()->json(['status' => 200, 'message' => 'Booking Rejected successfully','data' => $data ], 200);
            }
            return response()->json(['status' => 201, 'message' => 'Error in Booking Rejected' ], 200);
        }
        catch(\Exception $e)
        {
            return response()->json(['status' => 201, 'message' => $e->getMessage() ], 500);
        }
    }

    public function acceptBooking(Request $request)
    {
        try
        {
            $userid = $request->user()->id;
            $validator = Validator::make($request->all(), [
                'booking_id'        => 'required|exists:bookings,id',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 201, 'message' =>  implode(', ',$validator->messages()->all())], 200);
            }
            $status = Status::where('status','=','Accepted')->pluck('id')->first();
            if ($booking = Booking::where('id', $request->booking_id)->where('vendor_id', '=', $userid)->update([
                    'status_id'  => $status,
                ])) {
                $data = bookingInfoData($request->booking_id);
                $data['pending'] = ($data->status_id == 3) ? true : false ;
                $data['cancel'] = ($data->status_id == 2) ? true : false ;
                $data['done'] =    ($data->status_id == 11) ? true : false ;
                $data['rejected'] = ($data->status_id == 8) ? true : false ;
                $data['rate'] = ($data->status_id ==7) ? true : false ;
                $data['reschedule'] = ($data->status_id == 10) ? true : false ;
                $vendor = VendorDetail::find($booking->vendor_id);
                $notification = new Notification();

                $notification->title = 'Booking accepted';
                $notification->message = $vendor->firm_name . 'has accepted your booking.';
                $notification->type = 'My Appointment';
                $notification->user_id = $booking->user_id;
                $notification->type_id = $booking->id;
                $notification->booking_id = $booking->id;
                $notification->created_at = date('d-m-Y H:i:s');
                $notification->save();
                $notifydata = array('title' => 'Hey, Your booking has been Accepted ', 'message' => date('d-m-Y',strtotime($data->booking_date)), 'status' =>  'Accepted', 'booking_id' =>  $data->id);
                sendPushNotification($notifydata, $data->user_id);
                return response()->json(['status' => 200, 'message' => 'Booking Rejected successfully','data' => $data ], 200);
            }
            return response()->json(['status' => 201, 'message' => 'Error in Booking Rejected' ], 200);
        }
        catch(\Exception $e)
        {
            return response()->json(['status' => 201, 'message' => $e->getMessage() ], 500);
        }
    }

    public function rescheduleBooking(Request $request)
    {
        try
        {
            $userid = $request->user()->id;
            $validator = Validator::make($request->all(), [
                'booking_id'        => 'required|exists:bookings,id',
                'booking_date'  => "required",
                'booking_time'  => "required",
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 201, 'message' =>  implode(', ',$validator->messages()->all())], 200);
            }
            $status = Status::where('status','=','Reschedule')->pluck('id')->first();
            $booking_time = date('H:i',strtotime($request->booking_time));
            $expct_end_time =strtotime('+60 minutes', strtotime($request->booking_date.' '.$request->booking_time));

            if ($booking = Booking::where('id', $request->booking_id)->update([
                    'status_id'  => $status,
                    'booking_date' => $request['booking_date'] ? $request['booking_date'] : null,
                    'booking_time' => $booking_time,
                    'expct_end_time' => date('Y-m-d H:i',$expct_end_time),
                ])) {
                $data = bookingInfoData($request->booking_id);
                $data['pending'] = ($data->status_id == 3) ? true : false ;
                $data['cancel'] = ($data->status_id == 2) ? true : false ;
                $data['done'] =    ($data->status_id == 11) ? true : false ;
                $data['rejected'] = ($data->status_id == 8) ? true : false ;
                $data['rate'] = ($data->status_id ==7) ? true : false ;
                $data['reschedule'] = ($data->status_id == 10) ? true : false ;
                $user = User::find($booking->user_id);
                $notification = new Notification();
                $notification->title = 'Customer rescheduled booking';
                $notification->message = $user->name.'has a reschedule request.';
                $notification->type = 'Appointment';
                $notification->user_id  = $booking->vendor_id;
                $notification->type_id  = $booking->id;
                $notification->booking_id  = $booking->id;
                $notification->created_at = date('d-m-Y H:i:s');
                $notification->save();
                return response()->json(['status' => 200, 'message' => 'Booking Reschedule successfully','data' => $data ], 200);
            }
            return response()->json(['status' => 201, 'message' => 'Error in Booking Reschedule' ], 200);
        }
        catch(\Exception $e)
        {
            return response()->json(['status' => 201, 'message' => $e->getMessage() ], 500);
        }
    }

    public function ratingBooking(Request $request)
    {
        try
        {
            $userid = $request->user()->id;
            $validator = Validator::make($request->all(), [
                'booking_id'        => 'required|exists:bookings,id',
                'rating'  => "required",
                'review'  => "required",
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 201, 'message' =>  implode(', ',$validator->messages()->all())], 200);
            }
            $status = Status::where('status','=','Closed')->pluck('id')->first();
            if ($booking = Booking::where('id', $request->booking_id)->update([
                    'status_id'  => $status,
                ])) {
                $data = bookingInfoData($request->booking_id);
                $data['cancel'] = ($this->cancelstatus->contains($data->status_id) && $data->user_id == $userid) ? true : false ;
                $data['done'] = ($this->donestatus->contains($data->status_id)) ? true : false ;
                $data['rejected'] = ($this->rejectedstatus->contains($data->status_id) && $data->vendor_id == $userid) ? true : false ;
                $data['rate'] = ($this->ratestatus->contains($data->status_id) && $data->user_id == $userid) ? true : false ;
                $data['reschedule'] =($this->reschedulestatus->contains($data->status_id) && $data->user_id == $userid) ? true : false ;
                Feedback::create([
                    'reviewby' => $userid,
                    'reviewto' => $data['vendor_id'] ? $data['vendor_id'] : null,
                    'booking_id' => $request->booking_id ? $request->booking_id : null,
                    'treatment_id' => $data['treatment_id'] ? $data['treatment_id'] : null,
                    'rating' => $request->rating ? $request->rating : null,
                    'ambiance' => $request->ambiance ? $request->ambiance : null,
                    'hygiene' => $request->hygiene ? $request->hygiene : null,
                    'medewerkers' => $request->medewerkers ? $request->medewerkers : null,
                    'review' => $request->review ? $request->review : null,
                ]);
                return response()->json(['status' => 200, 'message' => 'Booking Closed successfully','data' => $data ], 200);
            }
            return response()->json(['status' => 201, 'message' => 'Error in Booking Closed' ], 200);
        }
        catch(\Exception $e)
        {
            return response()->json(['status' => 201, 'message' => $e->getMessage() ], 500);
        }
    }

    public function rescheduleVendorBooking(Request $request)
    {
        try
        {
            $userid = $request->user()->id;
            $validator = Validator::make($request->all(), [
                'booking_id'        => 'required|exists:bookings,id',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 201, 'message' =>  implode(', ',$validator->messages()->all())], 200);
            }
            if ($booking = Booking::where('id', $request->booking_id)->update([
                    'status_id'  => 3,
                ])) {
                $data = bookingInfoData($request->booking_id);
                $data['cancel'] = ($this->cancelstatus->contains($data->status_id) && $data->user_id == $userid) ? true : false ;
                $data['done'] = ($this->donestatus->contains($data->status_id)) ? true : false ;
                $data['rejected'] = ($this->rejectedstatus->contains($data->status_id) && $data->vendor_id == $userid) ? true : false ;
                $data['rate'] = ($this->ratestatus->contains($data->status_id) && $data->user_id == $userid) ? true : false ;
                $data['reschedule'] =($this->reschedulestatus->contains($data->status_id) && $data->user_id == $userid) ? true : false ;

                return response()->json(['status' => 200, 'message' => 'Booking Reschedule successfully','data' => $data ], 200);
            }
            return response()->json(['status' => 201, 'message' => 'Error in Booking Reschedule' ], 200);
        }
        catch(\Exception $e)
        {
            return response()->json(['status' => 201, 'message' => $e->getMessage() ], 500);
        }
    }

    public function getVendorRatings(Request $request)
    {
        try {
            $userid = $request->user()->id;
            $ratings = Feedback::with('userinfo')
                        ->where('reviewto', $userid)
                        ->select('id','reviewby', 'reviewto', 'booking_id', 'treatment_id', 'rating', 'ambiance', 'hygiene','medewerkers', 'review', 'created_at')
                        ->latest()
                        ->paginate(70);
            if($ratings) {
                $avgrating = Feedback::where('reviewto', $userid)->groupBy( 'reviewto' )->select( 'reviewto', DB::raw( 'AVG( rating ) as avgrating' ), DB::raw( 'AVG( ambiance ) as avgambiance' ), DB::raw( 'AVG( hygiene ) as avghygiene' ), DB::raw( 'AVG( medewerkers ) as avgmedewerkers' ) )->get();
                $collection = collect([
                    'avgrating' => isset($avgrating[0]['avgrating']) ? number_format((float)$avgrating[0]['avgrating'], 1, '.', '') : '0.0',
                    'avgambiance' => isset($avgrating[0]['avgambiance']) ? number_format((float)$avgrating[0]['avgambiance'], 1, '.', '') : '0.0',
                    'avghygiene' => isset($avgrating[0]['avghygiene']) ? number_format((float)$avgrating[0]['avghygiene'], 1, '.', '') : '0.0',
                    'avgmedewerkers' => isset($avgrating[0]['avgmedewerkers']) ? number_format((float)$avgrating[0]['avgmedewerkers'], 1, '.', '') : '0.0',
                ]);
                $data = $collection->merge($ratings);
                return response()->json(['status' => 200, 'message' => 'Data successfully retrieved', 'data' => $data], 200);

                // return response()->json(['status' => 200, 'message' => 'Data successfully retrieved', 'data' => $ratings, 'avgrating' => $collection ], 200);
            }
            return response()->json(['status' => 201, 'message' => 'Error in data retrieved'], 404);
        } catch (\Exception $e) {
            return response()->json(['status' => 201, 'message' => $e->getMessage()], 500);
        }
    }

    public function deleteBooking(Request $request)
    {
        try
        {
            $userid = $request->user()->id;
            $validator = Validator::make($request->all(), [
                'booking_id'        => 'required|exists:bookings,id',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 201, 'message' =>  implode(', ',$validator->messages()->all())], 200);
            }
            // Payment::where('booking_id', $request->booking_id)->where('user_id','=',$userid)->delete();
            Notification::where('booking_id', $request->booking_id)->delete();
            if (Booking::where('id', $request->booking_id)->delete()) {
                return response()->json(['status' => 200, 'message' => 'Booking Deleted successfully'], 200);
            }
            return response()->json(['status' => 201, 'message' => 'Error in Booking Delete' ], 200);
        }
        catch(\Exception $e)
        {
            return response()->json(['status' => 201, 'message' => $e->getMessage() ], 500);
        }
    }
    public function deleteNotification(Request $request)
    {
        try
        {
            $userid = $request->user()->id;
            $validator = Validator::make($request->all(), [
                'notification_id'        => 'required|exists:notifications,id',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 201, 'message' =>  implode(', ',$validator->messages()->all())], 200);
            }
            if (Notification::where('id', $request->notification_id)->where('user_id','=',$userid)->delete()) {
                $data = Notification::where('user_id', $userid)
                        ->select('id','type', 'title', 'message', 'is_seen', 'created_at', 'booking_id', 'status')
                        ->paginate(100);
                return response()->json(['status' => 200, 'message' => 'Notification Deleted successfully', 'data' => $data], 200);
            }
            return response()->json(['status' => 201, 'message' => 'Error in Notification Delete' ], 200);
        }
        catch(\Exception $e)
        {
            return response()->json(['status' => 201, 'message' => $e->getMessage() ], 500);
        }
    }
    public function bookingPaymentMethodUpdate(Request $request)
    {
        try
        {
            $userid = $request->user()->id;
            $validator = Validator::make($request->all(), [
                'booking_id'    => 'required|exists:bookings,id',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 201, 'message' =>  implode(', ',$validator->messages()->all())], 200);
            }
            if (Booking::where('id', $request->booking_id)->update([ 'status_id'  => 14 ])) {
                $data = bookingInfoData($request->booking_id);
                return response()->json(['status' => 200, 'message' => 'Payment is available','data' => $data ], 200);
            }
            return response()->json(['status' => 201, 'message' => 'Booking not available' ], 200);
        }
        catch(\Exception $e)
        {
            return response()->json(['status' => 201, 'message' => $e->getMessage() ], 500);
        }
    }

    public function earningReportDownload(Request $request)
    {
        try {

            $userid = $request->user()->id;
            $year = $request->year ? $request->year : date('Y') ;
            $month = $request->month ;
            $week = $request->week;
            $payments = Payment::with('userinfo')
                        ->where(function ($query) use ($request) {
                            if(!empty($request->year))
                            {
                                $query->whereYear('transaction_at', $request->year);
                            }
                            if(!empty($request->month))
                            {
                                $query->whereMonth('transaction_at', $request->month);
                            }
                            if(!empty($request->week))
                            {
                                $query->whereBetween('transaction_at', [date("Y-m-d", strtotime($request->week." sunday ".$request->year.'-'.$request->month)), date("Y-m-d", strtotime($request->week." saturday ".$request->year.'-'.$request->month))]);
                            }
                        })
                        ->where('vendor_id', $userid)
                        ->where('status','=','5')
                        ->select('id','user_id', 'amount', 'transaction_id', 'transaction_at', 'description', 'response', 'status', 'created_at')
                        ->latest()
                        ->get();
            if($payments) {
                $filename = date('Ymdhms').'.pdf';
                $pdf = PDF::loadView('pdf',  compact('payments'));
                Storage::disk('public')->put('pdf/'.$userid.'/'.$filename, $pdf->output());
                // return $pdf->download($filename);
                $path = url('/').'/public/pdf/'.$userid.'/'.$filename ;
                return response()->json(['status' => 200, 'message' => 'File Link retrieved','data' => $path ], 200);
            }
            return response()->json(['status' => 201, 'message' => 'Error in data retrieved'], 404);
        } catch (\Exception $e) {
            return response()->json(['status' => 201, 'message' => $e->getMessage()], 500);
        }
    }
    public function getYearsList(Request $request)
    {
        $data = collect([ ["year" => 2021], ["year" => 2022]]);
        return response()->json(['status' => 200, 'message' => 'Data successfully retrieved','data' => $data ], 200);
    }

    public function calendarBooking(Request $request)
    {
        try {
            $userid = $request->user()->id;
            $bookings = Booking::with('userinfo','serviceinfo' ,'treatmentinfo','employeeinfo')
                        ->where('vendor_id', $userid)
                        ->whereIn('status_id', ['6'])
                        ->whereDate('booking_date', '>=', date( "Y-m-d"))
                        ->whereDate('booking_date', '<=', date( "Y-m-d", strtotime( date('Y-m-d')." +7 day" ) ))
                        ->select('id','user_id','employee_id','service_id','treatment_id','booking_date','booking_time as startHour','orderid','expct_amount','final_amount','discount_amount','full_amount')
                        ->orderBy('booking_date', 'DESC')
                        ->orderBy('booking_time', 'DESC')
                        ->orderBy('id', 'DESC')
                        ->paginate(70);
            if ($bookings) {
                $bookings->getCollection()->transform(function ($value) use($userid) {
                    $startDay = 0;
                    $day = date("D", strtotime($value->booking_date));
                    switch ($day) {
                        case 'Mon':
                           $startDay = 1 ;
                            break;
                        case 'Tue':
                           $startDay = 2 ;
                            break;
                        case 'Wed':
                           $startDay = 3 ;
                            break;
                        case 'Thu':
                           $startDay = 4 ;
                            break;
                        case 'Fri':
                           $startDay = 5 ;
                            break;
                        case 'Sat':
                           $startDay = 6 ;
                            break;
                        case 'Sun':
                           $startDay = 7 ;
                            break;
                        default:
                            $startDay = 0;
                            break;
                    }

                    $value['startDay'] = $startDay;
                    // $value['cancel'] = ($value->status_id == 2) ? true : false ;
                    // $value['done'] =    ($value->status_id == 11) ? true : false ;
                    // $value['rejected'] = ($value->status_id == 8) ? true : false ;
                    // $value['rate'] = ($value->status_id ==7) ? true : false ;
                    // $value['reschedule'] = ($value->status_id == 10) ? true : false ;
                    // $value['booking_time'] = date('H:i', strtotime($value['booking_time']));
                    return $value;
                });
                return response()->json(['status' => 200, 'message' => 'Data successfully retrieved', 'data' => $bookings ], 200);
            }
            return response()->json(['status' => 201, 'message' => 'Error in data retrieved'], 404);
        } catch (\Exception $e) {
            return response()->json(['status' => 201, 'message' => $e->getMessage()], 500);
        }
    }
    public function bookingPayment(Request $request)
    {
        try {

            $userid = $request->user()->id;
            $validator = Validator::make($request->all(), [
                'booking_id'        => 'required|exists:bookings,id',
                'amount' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 201, 'message' =>  implode(', ',$validator->messages()->all())], 200);
            }
            if ($payment = mollieCreatePayment($request)) {
                return response()->json(['status' => 200, 'message' => 'Payment successfully', 'data' => $payment ], 200);
            }
            return response()->json(['status' => 201, 'message' => 'Error in Payment '], 404);
        } catch (\Exception $e) {
            return response()->json(['status' => 201, 'message' => $e->getMessage()], 500);
        }
    }
    public function getbookingPaymentStatus(Request $request)
    {
        try {

            $userid = $request->user()->id;
            $validator = Validator::make($request->all(), [
                'transectionid' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 201, 'message' =>  implode(', ',$validator->messages()->all())], 200);
            }
            if ($payment = molliePaymentStatus($request->transectionid)) {
                return response()->json(['status' => 200, 'message' => 'Payment successfully', 'data' => $payment ], 200);
            }
            return response()->json(['status' => 201, 'message' => 'Error in Payment '], 404);
        } catch (\Exception $e) {
            return response()->json(['status' => 201, 'message' => $e->getMessage()], 500);
        }
    }

    public function getCalendarSchedule(Request $request)
    {
        try {
            $userid = $request->user()->id;
            $start_date = $request->start_date ;
            $end_date = $request->end_date ;
            $employee_id = $request->employee_id ;
            $workinghours = BusinessHours::where('vendor_id', $userid)->select('timeMonStart', 'timeMonEnd', 'dayMondayStatus', 'timeTueStart', 'timeTueEnd', 'dayTuesdayStatus', 'timeWedStart', 'timeWedEnd', 'dayWednesdayStatus', 'timeThuStart', 'timeThuEnd', 'dayThursdayStatus', 'timeFriStart', 'timeFriEnd', 'dayFridayStatus', 'timeSatStart', 'timeSatEnd', 'daySaturdayStatus', 'timeSunStart', 'timeSunEnd', 'daySundayStatus', 'timeMonFriStart', 'timeMonFriEnd', 'dayMonFriStatus')->first();

            $workings = collect([]);
            $current = strtotime($start_date);
            $date2 = strtotime($end_date);
            $stepVal = '+1 day';
            while( $current <= $date2 ) {
                $dates = date('Y-m-d', $current);
                $current = strtotime($stepVal, $current);
                $day = date("D", strtotime($dates));
                switch ($day) {
                    case 'Mon':
                        $workings->push([
                            'date' => $dates,
                            'start_time' => isset($workinghours['timeMonStart']) ? $workinghours['timeMonStart'] :'',
                            'end_time' => isset($workinghours['timeMonEnd']) ? $workinghours['timeMonEnd'] : '',
                            'is_working' => isset($workinghours['dayMondayStatus']) ? $workinghours['dayMondayStatus'] : '',
                        ]);
                        break;
                    case 'Tue':
                        $workings->push([
                            'date' => $dates,
                            'start_time' => isset($workinghours['timeTueStart']) ? $workinghours['timeTueStart'] :'',
                            'end_time' => isset($workinghours['timeTueEnd']) ? $workinghours['timeTueEnd'] : '',
                            'is_working' => isset($workinghours['dayTuesdayStatus']) ? $workinghours['dayTuesdayStatus'] : '',
                        ]);
                        break;
                    case 'Wed':
                        $workings->push([
                            'date' => $dates,
                            'start_time' => isset($workinghours['timeWedStart']) ? $workinghours['timeWedStart'] :'',
                            'end_time' => isset($workinghours['timeWedEnd']) ? $workinghours['timeWedEnd'] : '',
                            'is_working' => isset($workinghours['dayWednesdayStatus']) ? $workinghours['dayWednesdayStatus'] : '',
                        ]);
                        break;
                    case 'Thu':
                        $workings->push([
                            'date' => $dates,
                            'start_time' => isset($workinghours['timeThuStart']) ? $workinghours['timeThuStart'] :'',
                            'end_time' => isset($workinghours['timeThuEnd']) ? $workinghours['timeThuEnd'] : '',
                            'is_working' => isset($workinghours['dayThursdayStatus']) ? $workinghours['dayThursdayStatus'] : '',
                        ]);
                        break;
                    case 'Fri':
                        $workings->push([
                            'date' => $dates,
                            'start_time' => isset($workinghours['timeFriStart']) ? $workinghours['timeFriStart'] :'',
                            'end_time' => isset($workinghours['timeFriEnd']) ? $workinghours['timeFriEnd'] : '',
                            'is_working' => isset($workinghours['dayFridayStatus']) ? $workinghours['dayFridayStatus'] : '',
                        ]);
                        break;
                    case 'Sat':
                        $workings->push([
                            'date' => $dates,
                            'start_time' => isset($workinghours['timeSatStart']) ? $workinghours['timeSatStart'] :'',
                            'end_time' => isset($workinghours['timeSatEnd']) ? $workinghours['timeSatEnd'] : '',
                            'is_working' => isset($workinghours['daySaturdayStatus']) ? $workinghours['daySaturdayStatus'] : '',
                        ]);
                        break;
                    case 'Sun':
                        $workings->push([
                            'date' => $dates,
                            'start_time' => isset($workinghours['timeSunStart']) ? $workinghours['timeSunStart'] :'',
                            'end_time' => isset($workinghours['timeSunEnd']) ? $workinghours['timeSunEnd'] : '',
                            'is_working' => isset($workinghours['daySundayStatus']) ? $workinghours['daySundayStatus'] : '',
                        ]);
                        break;
                    default:
                        $workings->push([
                            'date' => $dates,
                            'start_time' => isset($workinghours['timeMonFriStart']) ? $workinghours['timeMonFriStart'] :'',
                            'end_time' => isset($workinghours['timeMonFriEnd']) ? $workinghours['timeMonFriEnd'] : '',
                            'is_working' => isset($workinghours['dayMonFriStatus']) ? $workinghours['dayMonFriStatus'] : '',
                        ]);
                        break;
                }
            }




            $blocktime = DB::table('blocktime')->where('vendor_id', $userid)
                        ->where(function ($query) use($start_date, $end_date, $employee_id) {
                            if($employee_id)
                            {
                                $query->where('employee_id','=', $employee_id);
                            }
                            $query->whereDate('booking_date', '>=', $start_date);
                            $query->whereDate('booking_date', '<=', $end_date);
                            $query->orderBy('booking_date', 'ASC');
                            $query->orderBy('booking_time', 'ASC');
                        })->get();
            $bookings = VendorTeam::with(['appointments.serviceinfo' ,'appointments.treatmentinfo','appointments' => function ($query) use ($start_date, $end_date, $employee_id) {
                                if($employee_id)
                                {
                                    $query->where('employee_id','=', $employee_id);
                                }
                                $query->whereDate('booking_date', '>=', $start_date);
                                $query->whereDate('booking_date', '<=', $end_date);
                                $query->orderBy('booking_date', 'ASC');
                                $query->orderBy('booking_time', 'ASC');
                            }
                        ])
                        ->where('vendor_id', $userid)
                        ->select('id','vendor_id','employee_name',DB::raw('CONCAT("'.URL::to('/').'", "/public/", profile_pic) AS profile_pic'))
                        ->paginate(70);
            if ($bookings) {
                $bookings->getCollection()->transform(function ($value) use($workings, $start_date, $blocktime) {
                            $appointments = collect([]);
                            foreach ($value->appointments as $key => $bookingrows) {
                                $collection = collect(['id' => $bookingrows->id,
                                    'employee_id' => $bookingrows->employee_id,
                                    'booking_date' => $bookingrows->booking_date,
                                    'booking_time' => $bookingrows->booking_time,
                                    'final_amount' => $bookingrows->final_amount,
                                    'full_amount' => $bookingrows->full_amount,
                                    'expct_end_time' => $bookingrows->expct_end_time,
                                    'service_name' => $bookingrows['serviceinfo']['service_name'],
                                    'treatment_name' => $bookingrows['treatmentinfo']['treatment_name'],
                                    'type' => 'Booking'
                                ]);
                                $appointments->push($collection);
                            }
                            foreach ($blocktime->where('employee_id',$value->id) as $row => $blockrows) {
                               $collection2 = collect(['id' => $blockrows->id,
                                    'employee_id' => $blockrows->employee_id,
                                    'booking_date' => $blockrows->booking_date,
                                    'booking_time' => $blockrows->booking_time,
                                    'final_amount' => $blockrows->final_amount,
                                    'full_amount' => $blockrows->full_amount,
                                    'expct_end_time' => $blockrows->expct_end_time,
                                    'service_name' => '',
                                    'treatment_name' => '',
                                    'type' => 'Blocked'
                                ]);
                                $appointments->push($collection2);
                            }
                            $sorted = $appointments->sortBy([
                                fn ($a, $b) => $a['booking_date'] <=> $b['booking_date'],
                                fn ($a, $b) => $b['booking_time'] <=> $a['booking_time'],
                            ]);
                            unset($value['appointments']);
                    $value['workings'] = $workings ;
                    $value['appointments'] = $sorted->values()->all();
                    return $value;
                });
                return response()->json(['status' => 200, 'message' => 'Data successfully retrieved', 'data' => $bookings ], 200);
            }
            return response()->json(['status' => 201, 'message' => 'Error in data retrieved'], 404);
        } catch (\Exception $e) {
            return response()->json(['status' => 201, 'message' => $e->getMessage()], 500);
        }
        // try {
        //     $userid = $request->user()->id;
        //     $date = $request->date ;
        //     $employee_id = $request->employee_id ;
        //     $bookings = Booking::with('employeeinfo','serviceinfo' ,'treatmentinfo')
        //                 ->where('vendor_id', $userid)
        //                 ->where(function ($query) use($date, $employee_id) {
        //                     if($employee_id)
        //                     {
        //                         $query->where('employee_id','=', $employee_id);
        //                     }
        //                     if($date)
        //                     {
        //                         $query->whereDate('booking_date','=', date('Y-m-d',strtotime($date)));
        //                     }
        //                     else
        //                     {
        //                         $query->whereDate('booking_date', '>=', date( "Y-m-d"));
        //                         $query->whereDate('booking_date', '<=', date( "Y-m-d", strtotime( date('Y-m-d')." +7 day" )));
        //                     }
        //                 })
        //                 ->select('id','employee_id','booking_date','booking_time','final_amount','full_amount','service_id','treatment_id','expct_end_time')
        //                 ->orderBy('booking_date', 'DESC')
        //                 ->orderBy('booking_time', 'DESC')
        //                 ->orderBy('id', 'DESC')
        //                 ->paginate(70);
        //     if ($bookings) {
        //         return response()->json(['status' => 200, 'message' => 'Data successfully retrieved', 'data' => $bookings ], 200);
        //     }
        //     return response()->json(['status' => 201, 'message' => 'Error in data retrieved'], 404);
        // } catch (\Exception $e) {
        //     return response()->json(['status' => 201, 'message' => $e->getMessage()], 500);
        // }
    }

    public function blockBookingTime(Request $request)
    {
        try
        {
            $userid = $request->user()->id;
            $validator = Validator::make($request->all(), [
                'vendor_id'     => 'required|exists:vendor_details,vendor_id',
                // 'employee_id'   => 'required|exists:vendor_teams,id',
                'booking_date'  => "required",
                'booking_time'  => "required",
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 201, 'message' =>  implode(', ',$validator->messages()->all())], 200);
            }
            if(empty($request->employee_id))
            {
                $employees = VendorTeam::where('vendor_id',$request->vendor_id)->pluck('id');
            }
            else if(gettype($request->employee_id)==='string')
            {
                $employees =explode(',', $request->employee_id);
            }
            else
            {
                $employees = $request->employee_id ;
            }

            $booking_time = date('H:i',strtotime($request->booking_time));
            $expct_end_time = strtotime($request->booking_date.' '.$request->end_time);
            $data = collect([]);
            $bookings = Booking::where('vendor_id', $request->vendor_id)
                                        ->whereDate('booking_date',$request->booking_date)
                                        ->where('booking_time', '>=', date('H:i',strtotime($request->booking_time)))
                                        ->where('booking_time', '<',  date('H:i',strtotime($request->end_time)))
                                        ->select('id','employee_id','status_id', 'vendor_id','booking_time')
                                        ->get();
                                        // dd($bookings);

            foreach ($employees as $key => $rows) {

                $existbooking = $bookings->where('employee_id','=',$rows)->first();

                if(!empty($existbooking)) {
                    return response()->json(['status' => 201, 'message' => 'Can\'t block, Appointment is there' ], 200);

                }

                $data->push([
                    'user_id' => $userid,
                    'vendor_id' => $request->vendor_id,
                    'employee_id' => $rows,
                    'booking_date' => $request->booking_date,
                    'booking_time' => $booking_time,
                    'full_amount' => 0.00,
                    'final_amount' => 0.00,
                    'expct_end_time' => date('Y-m-d H:i',$expct_end_time),
                    'created_at' => date('Y-m-d h:m:s'),
                    'updated_at' => date('Y-m-d h:m:s'),
                ]);
            }
            $booking = DB::table('blocktime')->insert($data->toArray());
            if ($booking)
            {
                return response()->json(['status' => 200, 'message' => 'Data successfully retrieved', 'data' => $booking ], 200);
            }
            return response()->json(['status' => 201, 'message' => 'Error in Booking' ], 200);

            //return response()->json(['status' => 200, 'message' => 'Data successfully retrieved', 'data' => array() ], 200);
        }
        catch(\Exception $e)
        {
            return response()->json(['status' => 201, 'message' => $e->getMessage() ], 500);
        }
    }
}
