<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Treatment;
use App\Models\User;
use App\Models\Services;
use App\Models\VendorTeam;
use Twilio\TwiML\Voice\Reject;
use PDF;
class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(Booking::with('userinfo', 'vendorinfo', 'serviceinfo', 'treatmentinfo', 'statusinfo')->select('*'))
                ->addIndexColumn()
                ->editColumn('user_id', function ($query) {
                    if(!empty($query['userinfo'])) {
                        return '<img src="' . asset(isset($query['userinfo']['profile']) ? $query['userinfo']['profile'] : 'assets/image/dummy.png') . '" alt="" class="img-fluid wid-40 m-r-15 rounded">' . $query['userinfo']['firstname'] . ' ' . $query['userinfo']['lastname'];
                    }
                })
                ->editColumn('logo', function ($query) {
                    if(!empty($query['vendorinfo'])) {
                        return '<img src="' . asset($query['vendorinfo']['logo']) . '" alt="" class="img-fluid wid-40 m-r-15 rounded">' . $query['vendorinfo']['firm_name'];
                    }
                })
                ->editColumn('status', function ($query) {
                    if(!empty($query['statusinfo'])) {
                        $classname = "";
                        switch ($query['statusinfo']['status']) {
                            case 'Open':
                                $classname = "badge bg-light-primary";
                                break;
                            case 'Canceled':
                                $classname = "badge bg-light-danger";
                                break;
                            case 'Pending':
                                $classname = "badge bg-light-secondary";
                                break;
                            case 'Processing':
                                $classname = "badge bg-light-warning";
                                break;
                            case 'Payment Done':
                                $classname = "badge bg-light-success";
                                break;
                            case 'Accepted':
                                $classname = "badge bg-light-info";
                                break;
                            case 'Closed':
                                $classname = "badge bg-light-dark";
                                break;
                            case 'Rejected':
                                $classname = "badge bg-light-primary";
                                break;
                            case 'Refunded':
                                $classname = "badge bg-light-success";
                                break;
                            case 'Reschedule':
                                $classname = "badge bg-light-secondary";
                                break;
                            case 'Completed':
                                $classname = "badge bg-light-info";
                                break;
                            case 'Payment Hold':
                                $classname = "badge bg-light-warning";
                                break;
                            case 'Payment Failed':
                                $classname = "badge bg-light-danger";
                                break;
                            default:
                                # code...
                                break;
                        }
                    }
                    return  '<div  class="' . $classname . '">' . $query['statusinfo']['status'] . '
                    </div>';
                })
                ->addColumn('action', function ($query) {
                    return '<div class="d-flex align-items-center">
                        <div class="dropdown-primary dropdown open">
                            <button class="btn btn-light arrow-none dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="feather icon-more-vertical"></i>
                            </button>
                            <div class="dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                <a href="javascript:void(0)" class="dropdown-item editBooking" value="' . encrypt($query->id) . '">Edit</a>
                                <a href="javascript:void(0)" class="dropdown-item deleteBooking" value="' . encrypt($query->id) . '">Delete</a>
                            </div>
                        </div>
                        </div>';
                })
                ->rawColumns(['action', 'user_id', 'logo', 'status'])
                ->make(true);
        }
        $data['users'] = User::select('id', 'firstname', 'lastname')->where('type', '=', 'User')->get();
        $data['vendors'] = User::select('id', 'firstname', 'lastname')->where('type', '=', 'Provider')->get();
        $data['services'] = Services::select('id', 'service_name')->get();
        $data['treatments'] = Treatment::select('id', 'treatment_name')->get();
        $data['employee'] = VendorTeam::select('id', 'employee_name')->get();
        return view('booking.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            if (!empty($request['id'])) {
                $booking = Booking::where('id', $request['id'])->first();
                $booking->user_id  = isset($request->user_id) ? $request->user_id  : null;
                $booking->vendor_id  = isset($request->vendor_id) ? $request->vendor_id  : null;
                $booking->booking_date = isset($request->booking_date) ? $request->booking_date : '';
                $booking->address = isset($request->address) ? $request->address : null;
                $booking->orderid = isset($request->orderid) ? $request->orderid : '';
                $booking->final_amount = isset($request->final_amount) ? $request->final_amount : '';
                $booking->service_id = isset($request->service_id) ? $request->service_id : '';
                $booking->treatment_id = isset($request->treatment_id) ? $request->treatment_id : '';
                $booking->save();
            } else {
                $booking = Booking::create($request->except(['_token']));
            }
            if ($booking) {
                return redirect()->to('booking')->with('message_success', 'Data Store Successfully');
            }
            return redirect()->back()->with('message_danger', 'Error in Data Store')->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = decrypt($id);
        $user = Booking::find($id);
        $user['treatments'] = Treatment::where('service_id', $user->service_id)->select('id', 'treatment_name')->get();
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $id = decrypt($id);
            Payment::where('booking_id', $id)->delete();
            $user = Booking::find($id);
            if ($user->delete()) {
                return response()->json(['status' => 'success', 'message' => 'Booking deleted successfully!']);
            }
            return response()->json(['status' => 'error', 'message' => 'Error in Booking Delete!']);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }
    }

    public function createPDF() {
      // retreive all records from db
      $user = User::find(1);
      $pdf = PDF::loadView('pdf', compact('user'));
      return $pdf->download('invoice.pdf');
    }

    public function redirectUrl(Request $request)
    {
      return view('payment.responseview', compact('request'));
    }

    public function webhookUrl(Request $request)
    {
      return view('payment.responseview', compact('request'));
    }
}
