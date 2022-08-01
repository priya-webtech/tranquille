<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\VendorDetail;
use App\Models\VendorService;
use App\Models\Country;
use App\Models\Address;
use App\Models\BusinessHours;
use App\Models\VendorDemo;
use App\Models\VendorTreatment;
use App\Models\VendorTeam;
use App\Models\Treatment;
use App\Models\Feedback;
use App\Models\VendorProduct;
use App\Models\Offer;
use App\Models\Membership;
use App\Models\Subscription;
use App\Models\ReferralEarn;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\URL;
use App\Models\RecentlyView;

class VendorController extends Controller
{
    public function venderRegisterFirst(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(), [
                'firstname'     => 'required',
                'lastname'      => 'required',
                'phone'     => "required|unique:users,phone",
                'email'         => "required|email|unique:users,email",
                'password'      => 'required',
                'firm_name'     => "required",
                'country'  => 'required',
                'language'  => 'required',
                'vatnumber'     => "required",
            ]);
            if ($validator->fails()) {
                //return response()->json(['status' => 201, 'message' =>  implode(', ',$validator->messages()->all())], 200);
                return response()->json(['status' => 201, 'message' =>  $validator->errors()->first()], 200);
            }
             $code = $this->generateUniqueReferralCode();
            if ($user = User::create([
                'name' => isset($request->firm_name) ? $request->firm_name : '',
                'firstname' => isset($request->firstname) ? $request->firstname : '',
                'lastname' => isset($request->lastname) ? $request->lastname : '',
                'email' => isset($request->email) ? $request->email : null,
                'password' => isset($request->password) ? Hash::make($request->password) : '',
                'phone' => isset($request->phone) ? $request->phone : null,
                'dob' => isset($request->dob) ? $request->dob : null,
                'type' => isset($request->type) ? $request->type : 'Provider',
                'device_token' => isset($request->device_token) ? $request->device_token : '',
                'language' => isset($request->language) ? $request->language : '',
                 'country' => isset($request->country) ? $request->country : '',
                'profile_status' => 1,
                'referral_code' => $code,
            ])) {

            	$membership = Membership::create([
                    'user_id' => $user->id,
                    'plan_id' => null,
                    'amount' => 0.00,
                    'description' => 'Free Membership',
                    'txn_status' => 'succees',
                    'status' => true,
                    'start_date'  => date('Y-m-d'),
                    'end_date'  => date('Y-m-d', strtotime('+ 30 day')),
                ]);

                $user['vender_details'] = VendorDetail::create([
                    'vendor_id' => $user->id,
                    'firm_name' => isset($request->firm_name) ? $request->firm_name : '',
                    'website' => isset($request->website) ? $request->website : null,
                    // 'country' => isset($request->country) ? $request->country : '',
                    'service_type ' => isset($request->service_type) ? $request->service_type  : null,
                    'latitude' => isset($request->latitude) ? $request->latitude : null,
                    'longitude' => isset($request->longitude) ? $request->longitude : null,
                    'membershipvalid' => date('Y-m-d', strtotime('+ 30 day')),
                ]);
                $notification = new Notification();
                $notification->title = 'Membership expire';
                $notification->message = 'Your Membership will expire at '.date('Y-m-d', strtotime('+ 30 day'));
                $notification->type = 'Membership Plan';
                $notification->user_id  = $user['vender_details']['vendor_id'];
                $notification->type_id  = $membership->id;
                $notification->created_at = date('d-m-Y H:i:s');
                $notification->save();
                $admin = User::where('type','Admin')->first();
                $notification = new Notification();
                $notification->title = 'New Vendor Registration';
                $notification->message = $user['vender_details']['firm_name'].' has requested for approval for Salon Registration.';
                $notification->type = 'Approval List';
                $notification->user_id  = $admin->id;
                $notification->type_id  =  $user['vender_details']['vendor_id'];
                $notification->created_at = date('d-m-Y H:i:s');
                $notification->save();
                broadcast(new \App\Events\SendNotification($notification))->toOthers();
                $notifydata = array('title' => 'Membership will expire ', 'message' => 'Your Membership will expire at '.date('Y-m-d', strtotime('+ 30 day')), 'status' =>  'Open', 'booking_id' =>  null);
                sendPushNotification($notifydata, $user->id);
                $token = $user->createToken('94b2f892-2c7c-4bf4-8043-cf9cf6cc4c70')->accessToken;
                $user->assignRole('Provider');
                $data = userInfoResponse($user->id);
                $data['token'] = $token;
                if($request->referral_code)
                {
                    $referralby = DB::table('users')->where('referral_code', $request->referral_code)->pluck('id')->first();
                    ReferralEarn::updateOrCreate(['referralto'   => $user->id],[
                            'referralby'    => $referralby,
                            'referralto'    => $user->id,
                            'referral_code' => $request->referral_code,
                            'email'         => $request->email,
                            'phone'         => $request->phone,
                            'referral_date' => date('Y-m-d'),
                    ]);
                }
                return response()->json(['status' => 200, 'message' => 'Registered succesfull','data' => $data ], 200);
            }
            return response()->json(['status' => 201, 'message' => 'Error in user registertion' ], 200);
        }
        catch(\Exception $e)
        {
            return response()->json(['status' => 201, 'message' => $e->getMessage() ], 500);
        }
    }

    public function vendorService(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'services' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 201, 'message' =>  implode(', ', $validator->messages()->all())], 400);
            }
            $userid = $request->user()->id;
            $categories = collect([]);
            foreach ($request->services as $row)
            {
                VendorService::updateOrCreate(['vendor_id' => $userid, 'service_id' => $row],[
                    'vendor_id' => $userid,
                    'service_id' => $row,
                    'created_at' => date("Y-m-d H:i:s", time()),
                ]);
            }
            if($request->user()->profile_status == 2)
            {
                User::where('id', $userid)->update([ 'profile_status' => 3]);
            }
            $data = userInfoResponse($userid);
            return response()->json(['status' => 200, 'message' => 'Vender Service Save', 'data'=> $data], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 201, 'message' => $e->getMessage()], 500);
        }
    }

    public function venderRegisterThree(Request $request)
    {
        try {
            $userid = $request->user()->id;
            $validator = Validator::make($request->all(), [
                'address_line1'     => "required",
                // 'address_line2'     => "required",
                'state'             => "required",
                'city'              => "required",
                'postcode'          => "required",
                'service_type'      => "required",
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 201, 'message' =>  implode(', ', $validator->messages()->all())], 400);
            }
            if($request['service_type'])
            {
                VendorDetail::where('vendor_id',$userid)->update([
                    'service_type' => $request['service_type'],
                    'latitude' => isset($request->latitude) ? $request->latitude : null,
                    'longitude' => isset($request->longitude) ? $request->longitude : null,
                ]);
            }
            if(Address::where('user_id', $userid)->updateOrCreate(['user_id' => $userid, 'id' => $request['address_id']], [
                'user_id' => $userid,
                'address_line1' => isset($request->address_line1) ? $request->address_line1 : '',
                'address_line2' => isset($request->address_line2) ? $request->address_line2 : '',
                'state' => isset($request->state) ? $request->state : '',
                'city' => isset($request->city) ? $request->city : '',
                'postcode' => isset($request->postcode) ? $request->postcode : '',
                'latitude' => isset($request->latitude) ? $request->latitude : null,
                'longitude' => isset($request->longitude) ? $request->longitude : null,
                'location_address' => isset($request->location_address) ? $request->location_address : '',
            ])) {
                if($request->user()->profile_status == 1)
                {
                    User::where('id', $userid)->update([ 'profile_status' => 2]);
                }
                $data = userInfoResponse($userid);
                return response()->json(['status' => 200, 'message' => 'Vender Details Save', 'data' => $data], 200);
            }
            return response()->json(['status' => 201, 'message' => 'Error in Vender Details'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 201, 'message' => $e->getMessage()], 500);
        }
    }

    public function venderRegisterLocation(Request $request)
    {
        try {
            $userid = $request->user()->id;
            $validator = Validator::make($request->all(), [
                'latitude'     => "required",
                'longitude'     => "required",
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 201, 'message' =>  implode(', ', $validator->messages()->all())], 400);
            }

            if(VendorDetail::where('vendor_id',$userid)->update([
                'vendor_id' => $userid,
                'latitude' => isset($request->latitude) ? $request->latitude : null,
                'longitude' => isset($request->longitude) ? $request->longitude : null,
            ]))
            {
                if($request->user()->profile_status == 3)
                {
                    User::where('id', $userid)->update([ 'profile_status' => 4]);
                }
                $data = userInfoResponse($userid);
                return response()->json(['status' => 200, 'message' => 'Vender Location Save', 'data' => $data], 200);
            }
            return response()->json(['status' => 201, 'message' => 'Error in Vender Location'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 201, 'message' => $e->getMessage()], 500);
        }
    }
    public function venderLocationUpdate(Request $request)
    {
        try {
            $userid = $request->user()->id;
            $validator = Validator::make($request->all(), [
                'latitude'     => "required",
                'longitude'     => "required",
                'location_address'  => "required",
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 201, 'message' =>  implode(', ', $validator->messages()->all())], 400);
            }

            if(VendorDetail::where('vendor_id',$userid)->update([
                'vendor_id' => $userid,
                'latitude' => isset($request->latitude) ? $request->latitude : null,
                'longitude' => isset($request->longitude) ? $request->longitude : null,
            ]))
            {
                Address::where('user_id', '=',$userid)->update([
                    'latitude' => isset($request->latitude) ? $request->latitude : null,
                    'longitude' => isset($request->longitude) ? $request->longitude : null,
                    'location_address' => isset($request->location_address) ? $request->location_address : '',
                ]);
                $data = userInfoResponse($userid);
                return response()->json(['status' => 200, 'message' => 'Vender Location Save', 'data' => $data], 200);
            }
            return response()->json(['status' => 201, 'message' => 'Error in Vender Location'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 201, 'message' => $e->getMessage()], 500);
        }
    }
    public function venderRegisterWhyChooseYou(Request $request)
    {
        try {
            $userid = $request->user()->id;
            $validator = Validator::make($request->all(), [
                'why_you'     => "required",
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 201, 'message' =>  implode(', ', $validator->messages()->all())], 400);
            }
            if(VendorDetail::where('vendor_id', $userid)->updateOrCreate(['vendor_id' => $userid], [
                'vendor_id' => $userid,
                'why_you' => isset($request->why_you) ? $request->why_you : '',
            ]))
            {
                if($request->user()->profile_status == 5)
                {
                    User::where('id', $userid)->update([ 'profile_status' => 6]);
                }
                $data = userInfoResponse($userid);
                return response()->json(['status' => 200, 'message' => 'Vender Why Choose Save', 'data' => $data], 200);
            }
            return response()->json(['status' => 201, 'message' => 'Error in Vender Why Choose'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 201, 'message' => $e->getMessage()], 500);
        }
    }

    public function venderRegisterLogo(Request $request)
    {
        try {
            $userid = $request->user()->id;
            // $validator = Validator::make($request->all(), [
            //     'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5048',
            // ]);
            // if ($validator->fails()) {
            //     return response()->json(['status' => 201, 'message' =>  implode(', ', $validator->messages()->all())], 400);
            // }
            $imagename = time() . '.' . $request->logo->getClientOriginalExtension();
            $upload = $request->logo->move(public_path('logo'), $imagename);
            if(VendorDetail::where('vendor_id', $userid)->updateOrCreate(['vendor_id' => $userid], [
                'vendor_id' => $userid,
                'logo' => isset($imagename) ? 'logo/'.$imagename : '',
            ]) )
            {
                if($request->user()->profile_status == 4)
                {
                    User::where('id', $userid)->update([ 'profile_status' => 5]);
                }
                $data = userInfoResponse($userid);
                return response()->json(['status' => 200, 'message' => 'Vender Logo Save', 'data' => $data], 200);
            }
            return response()->json(['status' => 201, 'message' => 'Error in Vender Logo'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 201, 'message' => $e->getMessage()], 500);
        }
    }

    public function venderRegisterBusineesHours(Request $request)
    {
        try {
            $userid = $request->user()->id;
            $validator = Validator::make($request->all(), [
                'timeMonStart' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 201, 'message' =>  implode(', ', $validator->messages()->all())], 400);
            }
            if(BusinessHours::where('vendor_id', $userid)->updateOrCreate(['vendor_id' => $userid], [
                'vendor_id' => $userid,
                'timeMonStart' => isset($request->timeMonStart) ? $request->timeMonStart : '',
                'timeMonEnd' => isset($request->timeMonEnd) ? $request->timeMonEnd : '',
                'timeTueStart' => isset($request->timeTueStart) ? $request->timeTueStart : '',
                'timeTueEnd' => isset($request->timeTueEnd) ? $request->timeTueEnd : '',
                'timeWedStart' => isset($request->timeWedStart) ? $request->timeWedStart : '',
                'timeWedEnd' => isset($request->timeWedEnd) ? $request->timeWedEnd : '',
                'timeThuStart' => isset($request->timeThuStart) ? $request->timeThuStart : '',
                'timeThuEnd' => isset($request->timeThuEnd) ? $request->timeThuEnd : '',
                'timeFriStart' => isset($request->timeFriStart) ? $request->timeFriStart : '',
                'timeFriEnd' => isset($request->timeFriEnd) ? $request->timeFriEnd : '',
                'timeSatStart' => isset($request->timeSatStart) ? $request->timeSatStart : '',
                'timeSatEnd' => isset($request->timeSatEnd) ? $request->timeSatEnd : '',
                'timeSunStart' => isset($request->timeSunStart) ? $request->timeSunStart : '',
                'timeSunEnd' => isset($request->timeSunEnd) ? $request->timeSunEnd : '',
                'timeMonFriStart' => isset($request->timeMonFriStart) ? $request->timeMonFriStart : '',
                'timeMonFriEnd' => isset($request->timeMonFriEnd) ? $request->timeMonFriEnd : '',
                'dayMondayStatus' => isset($request->dayMondayStatus) ? $request->dayMondayStatus : false,
                'dayTuesdayStatus' => isset($request->dayTuesdayStatus) ? $request->dayTuesdayStatus : false,
                'dayWednesdayStatus' => isset($request->dayWednesdayStatus) ? $request->dayWednesdayStatus : false,
                'dayThursdayStatus' => isset($request->dayThursdayStatus) ? $request->dayThursdayStatus : false,
                'dayFridayStatus' => isset($request->dayFridayStatus) ? $request->dayFridayStatus : false,
                'daySaturdayStatus' => isset($request->daySaturdayStatus) ? $request->daySaturdayStatus : false,
                'daySundayStatus' => isset($request->daySundayStatus) ? $request->daySundayStatus : false,
                'dayMonFriStatus' => isset($request->dayMonFriStatus) ? $request->dayMonFriStatus : false,
            ]) )
            {
                if($request->user()->profile_status == 6)
                {
                    User::where('id', $userid)->update([ 'profile_status' => 7]);
                }
                $data = userInfoResponse($userid);
                return response()->json(['status' => 200, 'message' => 'Vender business hours save', 'data' => $data], 200);
            }
            return response()->json(['status' => 201, 'message' => 'Error in Vender business hours'], 200);

        } catch (\Exception $e) {
            return response()->json(['status' => 201, 'message' => $e->getMessage()], 500);
        }
    }

    public function venderRegisterWorkDemos(Request $request)
    {
        try {
            $userid = $request->user()->id;
            $validator = Validator::make($request->all(), [
                'demo_image' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 201, 'message' =>  implode(', ', $validator->messages()->all())], 400);
            }

            if ($request->file('demo_image') != null) {
                $demo_image = collect([]);
                $images = $request->file('demo_image');
                $path = public_path() . '/demo_image/' . $userid;
                $existcount = VendorDemo::where('vendor_id', '=', $userid)->count() ;
                $postexistcount = $existcount + count($images);
                if($postexistcount > 6){
                    return response()->json(['status' => 201, 'message' => "Demo images should not be greater then 6"], 400);
                }
                // !exist code here
                foreach ($images as $key => $item) {
                    $imageName = time() . rand(1000, 9999) . '_' . $key . '.' . $item->getClientOriginalExtension();
                    $upload = $item->move($path, $imageName);
                    $demo_image->push([
                        'vendor_id' => $userid,
                        'demo_image' => '/demo_image/' . $userid . '/' . $imageName,
                        'created_at' => date('Y-m-d h:m:s'),
                        'updated_at' => date('Y-m-d h:m:s'),
                    ]);
                }
                if ($demo_image->isNotEmpty()) {
                    VendorDemo::insert($demo_image->toArray());
                    if($request->user()->profile_status == 7)
                    {
                        User::where('id', $userid)->update([ 'profile_status' => 8]);
                    }
                    $data = userInfoResponse($userid);
                    return response()->json(['status' => 200, 'message' => 'Vender Demo Images Save', 'data' => $data], 200);
                }
                return response()->json(['status' => 201, 'message' => 'Error in Vender Demo Images'], 200);
            }
            return response()->json(['status' => 201, 'message' => 'File not set'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 201, 'message' => $e->getMessage()], 500);
        }
    }
    public function vendorTreatments(Request $request)
    {
        try {
            $userid = $request->user()->id;
            $validator = Validator::make($request->all(), [
                'treatment_id' => "required|exists:treatments,id",
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 201, 'message' =>  implode(', ', $validator->messages()->all())], 400);
            }
            if(VendorTreatment::updateOrCreate(['vendor_id' => $userid, 'treatment_id' => $request->treatment_id],[
                'vendor_id' => $userid,
                'treatment_id' => $request->treatment_id,
                'description' => isset($request->description) ? $request->description :'',
                'price' => isset($request->price) ? $request->price :0.00,
                'discount' => isset($request->discount) ? $request->discount :null,
                'no_of_person' => isset($request->no_of_person) ? $request->no_of_person :1,
                'created_at' => date("Y-m-d H:i:s", time()),
            ]))
            {
                if(!empty($request['products']))
                {
                    $brandproduct = collect([]);
                    $products = explode(',', $request->products);
                    $products = array_filter($products, 'strlen');
                    foreach ($products as $rows) {
                        VendorProduct::updateOrCreate(['vendor_id' => $userid, 'productbrand_id' => $rows],[
                            'vendor_id'         => $userid,
                            'treatment_id' => $request->treatment_id,
                            'productbrand_id'   => $rows,
                            'created_at' => date("Y-m-d H:i:s", time()),
                        ]);
                    }
                }
                $data = userInfoResponse($userid);
                return response()->json(['status' => 200, 'message' => 'Vendor Treatment added successfully', 'data'=> $data], 200);
            }
            return response()->json(['status' => 201, 'message' => 'Error in Vendor Treatment'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 201, 'message' => $e->getMessage()], 500);
        }
    }
    public function updateVendorInfo(Request $request)
    {
        try
        {
            $userid = $request->user()->id;
            $validator = Validator::make($request->all(), [
                'firm_name'     => "required",
                'firstname'     => 'required',
                'lastname'      => 'required',
                'phone'         => "required|unique:users,phone,".$userid,
                'email'         => "required|email|unique:users,email,".$userid,
                'website'       => "required",
                'country'       => 'required',
                'why_you'       => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 201, 'message' =>  implode(', ',$validator->messages()->all())], 200);
            }

            if (User::where('id', $userid)->update([
                'name' => isset($request->firm_name) ? $request->firm_name : '',
                'firstname' => isset($request->firstname) ? $request->firstname : '',
                'lastname' => isset($request->lastname) ? $request->lastname : '',
                'email' => isset($request->email) ? $request->email : null,
                'phone' => isset($request->phone) ? $request->phone : null,
                'country' => isset($request->country) ? $request->country : '',
                'language' => isset($request->language) ? $request->language : '',
            ])) {
                VendorDetail::where('vendor_id', $userid)->update([
                    'firm_name' => isset($request->firm_name) ? $request->firm_name : '',
                    'website' => isset($request->website) ? $request->website : null,
                    // 'country' => isset($request->country) ? $request->country : '',
                    'why_you' => isset($request->why_you) ? $request->why_you : '',
                    'service_type' => isset($request->service_type) ? $request->service_type  : null,
                ]);
                $data = userInfoResponse($userid);
                return response()->json(['status' => 200, 'message' => 'Registered succesfull','data' => $data ], 200);
            }
            return response()->json(['status' => 201, 'message' => 'Error in user registertion' ], 200);
        }
        catch(\Exception $e)
        {
            return response()->json(['status' => 201, 'message' => $e->getMessage() ], 500);
        }
    }
    public function updateVendorAddress(Request $request)
    {
        try {
            $userid = $request->user()->id;
            $validator = Validator::make($request->all(), [
                'address_line1'     => "required",
                'address_line2'     => "required",
                'state'             => "required",
                'city'              => "required",
                'postcode'          => "required",
                'latitude'          => "required",
                'longitude'          => "required",
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 201, 'message' =>  implode(', ', $validator->messages()->all())], 400);
            }
            if($request['latitude'] && $request['longitude'] && $request->user()->type == "Provider")
            {
                VendorDetail::where('vendor_id',$userid)->update([
                    'latitude' => isset($request->latitude) ? $request->latitude : null,
                    'longitude' => isset($request->longitude) ? $request->longitude : null,
                ]);
            }
            if(Address::updateOrCreate(['user_id' => $userid, 'id' => $request['address_id']], [
                'user_id' => $userid,
                'address_line1' => isset($request->address_line1) ? $request->address_line1 : '',
                'address_line2' => isset($request->address_line2) ? $request->address_line2 : '',
                'state' => isset($request->state) ? $request->state : '',
                'city' => isset($request->city) ? $request->city : '',
                'postcode' => isset($request->postcode) ? $request->postcode : '',
                'latitude' => isset($request->latitude) ? $request->latitude : null,
                'longitude' => isset($request->longitude) ? $request->longitude : null,
                'location_address' => isset($request->location_address) ? $request->location_address : '',
            ])) {
                if($request->user()->profile_status == 1)
                {
                    User::where('id', $userid)->update([ 'profile_status' => 2]);
                }
                $data = userInfoResponse($userid);
                return response()->json(['status' => 200, 'message' => 'Vender Details Save', 'data' => $data], 200);
            }
            return response()->json(['status' => 201, 'message' => 'Error in Vender Details'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 201, 'message' => $e->getMessage()], 500);
        }
    }
    public function deleteVendorGallery(Request $request)
    {
        try {
            $userid = $request->user()->id;
            $validator = Validator::make($request->all(), [
                'image_id' => 'exists:vendor_demos,id'
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 201, 'message' =>  implode(', ', $validator->messages()->all())], 400);
            }
            $demoimage = VendorDemo::where('vendor_id', $userid)->where('id', $request->image_id)->first();
            if (file_exists("public" . $demoimage->demo_image)) {
                unlink("public" . $demoimage->demo_image);
                // File::delete(public_path("public".$user->demo_image));
            }
            if ($demoimage->delete()) {
                $data = userInfoResponse($userid);
                return response()->json(['status' => 200, 'message' => 'Image delete succesfully', 'data' => $data], 200);
            }
            return response()->json(['status' => 201, 'message' => 'Error in Image delete'], 404);
        } catch (\Exception $e) {
            return response()->json(['status' => 201, 'message' => $e->getMessage()], 500);
        }
    }
    public function vendorAddNewTeamMember(Request $request)
    {
        try {
            $userid = $request->user()->id;
            $validator = Validator::make($request->all(), [
                'employee_name'     => "required",
                'designation'     => "required",
                'skills'             => "required",
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 201, 'message' =>  implode(', ', $validator->messages()->all())], 400);
            }
            if ($request->file('profile_pic')!=null)
            {
                $request['profile_image'] = uploadImageToPath($request->profile_pic, 'teams');
            }
            $defaultimage = VendorTeam::where('id',$request['employee_id'])->pluck('profile_pic')->first();
            if (VendorTeam::updateOrCreate(['vendor_id' => $userid, 'id' => $request['employee_id']], [
               'vendor_id'      =>  $userid,
               'employee_name'  =>  isset($request->employee_name) ? $request->employee_name : '',
               'designation'  =>  isset($request->designation) ? $request->designation : '',
               'skills'  =>  isset($request->skills) ? $request->skills : '',
               'profile_pic'  =>  isset($request->profile_image) ? $request->profile_image : $defaultimage,
            ])) {
                $data = userInfoResponse($userid);
                return response()->json(['status' => 200, 'message' => 'Team Member added succesfully', 'data' => $data], 200);
            }
            return response()->json(['status' => 201, 'message' => 'Error in Team Member'], 404);
        } catch (\Exception $e) {
            return response()->json(['status' => 201, 'message' => $e->getMessage()], 500);
        }
    }
    public function getVendorTeamMember(Request $request)
    {
        try {
            $userid = $request->user()->id;
            if ($teams = VendorTeam::where('vendor_id',$userid)->select('id', 'id as employee_id', 'active','vendor_id', 'employee_name', 'designation', 'skills',DB::raw('CONCAT("'.URL::to('/').'/public/", profile_pic) AS profile_pic '))->get()) {
                return response()->json(['status' => 200, 'message' => 'Data successfully retrieved', 'data' => $teams], 200);
            }
            return response()->json(['status' => 201, 'message' => 'Error in data retrieved'], 404);
        } catch (\Exception $e) {
            return response()->json(['status' => 201, 'message' => $e->getMessage()], 500);
        }
    }
    public function statusChangeTeamMember(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'employee_id' => 'exists:vendor_teams,id',
                'active' => "required",
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 201, 'message' =>  implode(', ', $validator->messages()->all())], 400);
            }
            $userid = $request->user()->id;
            if ($teams = VendorTeam::where('vendor_id',$userid)->where('id',$request['employee_id'])->update(['active' => $request['active']])) {
                $data = userInfoResponse($userid);
                $message = ($request['active'] == 'N') ? 'Inactive' : 'Active';
                return response()->json(['status' => 200, 'message' => 'Employee '.$message.' successfully', 'data' => $data], 200);
            }
            return response()->json(['status' => 201, 'message' => 'Error in employee delete'], 404);
        } catch (\Exception $e) {
            return response()->json(['status' => 201, 'message' => $e->getMessage()], 500);
        }
    }
    public function vendorDeleteTeamMember(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'employee_id' => 'exists:vendor_teams,id'
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 201, 'message' =>  implode(', ', $validator->messages()->all())], 400);
            }
            $userid = $request->user()->id;
            if ($teams = VendorTeam::where('vendor_id',$userid)->where('id',$request['employee_id'])->delete()) {
                $data = userInfoResponse($userid);
                return response()->json(['status' => 200, 'message' => 'Employee successfully deleted', 'data' => $data], 200);
            }
            return response()->json(['status' => 201, 'message' => 'Error in employee delete'], 404);
        } catch (\Exception $e) {
            return response()->json(['status' => 201, 'message' => $e->getMessage()], 500);
        }
    }

    public function searchVendorFilter(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'latitude' => 'required',
                'longitude' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 201, 'message' =>  implode(', ', $validator->messages()->all())], 400);
            }
            $latitude = $request->latitude;
            $longitude = $request->longitude;
            $distance = isset($request->distance) ? $request->distance : 25 ;

            $rawquery = VendorDetail::leftJoin('vendor_treatments', 'vendor_treatments.vendor_id', '=', 'vendor_details.vendor_id')
                ->leftJoin('feedback', 'feedback.reviewto', '=', 'vendor_details.vendor_id')
                ->with('vendorrating','vendortreatments','vendoraddress','vendorproducts')
                ->where(function ($query) use($request) {
                    $query->where('membershipvalid','>=', date('Y-m-d'));
                    if(!empty($request->service_id))
                    {
                        $query->whereHas('vendorservices', function($query) use ($request){
                            $query->where('service_id', '=', $request->service_id);
                        });
                    }
                    if(!empty($request->treatment_id))
                    {
                        $query->whereHas('vendortreatments', function($query) use ($request){
                            $query->where('treatment_id', '=', $request->treatment_id);
                        });
                    }
                    if(!empty($request->product_id))
                    {
                        $products = explode(',', $request->product_id);
                        $query->whereHas('vendorproducts', function($query) use ($products){
                           $query->whereIn('productbrand_id', $products);
                        });
                    }
                    if(!empty($request->priceMin))
                    {
                        $query->whereHas('vendortreatments', function($query) use ($request){
                            // if(!empty($request->treatment_id)){
                            //    $query->where('treatment_id', '=', $request->treatment_id);
                            // }
                            $query->where('price', '>=', $request->priceMin);
                        });
                    }
                    if(!empty($request->priceMax))
                    {
                        $query->whereHas('vendortreatments', function($query) use ($request){
                            // if(!empty($request->treatment_id)){
                            //    $query->where('treatment_id', '=', $request->treatment_id);
                            // }
                            $query->where('price', '<=', $request->priceMax);
                        });
                    }
                    if(!empty($request->rating))
                    {
                        $query->whereHas('vendorrating', function($query) use ($request){
                            $query->where('rating', '>=', $request->rating);
                        });
                    }
                    if(!empty($request->search))
                    {
                       $query->where('firm_name', 'like', "%$request->search%");
                    }
                    if(!empty($request->date))
                    {
                        $query->whereHas('vendorBusinessHours', function($query) use ($request){
                            $day = date('D', strtotime($request->date));
                            switch ($day) {
                                case 'Mon':
                                    $query->where('dayMondayStatus', '=', 1);
                                    break;
                                case 'Tue':
                                    $query->where('dayTuesdayStatus', '=', 1);
                                    break;
                                case 'Wed':
                                    $query->where('dayWednesdayStatus', '=', 1);
                                break;
                                case 'Thu':
                                    $query->where('dayThursdayStatus', '=', 1);
                                break;
                                case 'Fri':
                                    $query->where('dayFridayStatus', '=', 1);
                                break;
                                case 'Sat':
                                    $query->where('daySaturdayStatus', '=', 1);
                                break;
                                case 'Sun':
                                    $query->where('daySundayStatus', '=', 1);
                                break;
                                default:
                                    $query->where('dayMonFriStatus', '=', 1);
                                break;
                            }
                        });
                    }
                })
                ->select(DB::raw('profile_viewed,vendor_details.vendor_id, firm_name, about_us, '.DB::raw('CONCAT("'.URL::to('/').'", "/public/", logo) AS logo').', ( 6367 * acos( cos( radians('.$latitude.') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians('.$longitude.') ) + sin( radians('.$latitude.') ) * sin( radians( latitude ) ) ) ) AS distance'))
                ->having('distance', '<=', $distance);
            if($request->shortBy == 'Highest Rated')
            {
                $rawquery->orderBy('rating', 'DESC');
            }
            else if ($request->shortBy == 'Lowest Price')
            {
                $rawquery->orderBy('price', 'ASC');
            }
            else if ($request->shortBy == 'Highest Price')
            {
                $rawquery->orderBy('price', 'DESC');
            }
            else if($request->shortBy == 'Discount')
            {
                $rawquery->orderBy('discount', 'DESC');
            }
            else if($request->shortBy == 'Distance')
            {
                $rawquery->orderBy('distance', 'ASC');
            }
            else if($request->shortBy == 'Most Popular')
            {
                $rawquery->orderBy('profile_viewed', 'DESC');
            }

            $vendors = $rawquery->get();


            if ($vendors) {
                $datalist = collect([]);
                foreach ($vendors as $key => $rows) {
                    $address = !empty($rows->vendoraddress) ? $rows->vendoraddress->first() : array();
                    $datalist->push([
                        'vendor_id' => $rows->vendor_id,
                        'firm_name' => $rows->firm_name,
                        'about_us' => isset($rows->about_us) ? $rows->about_us : '',
                        'logo' => isset($rows->logo) ? $rows->logo : '',
                        'distance' => $rows->distance,
                        'rating' => !empty($rows->vendorrating) ? $rows->vendorrating->avg('rating') : 0 ,
                        'vendoraddress' => isset($address['address_line1']) ? $address['address_line1'].', '.$address['city'].', '.$address['state'].', '.$address['postcode'] : '',
                    ]);
                }
                $offers = Offer::where('active','=','Y')
                                ->select('id','offer_title', 'discount',DB::raw('CONCAT("'.URL::to('/').'/public/", offer_image) AS offer_image '))
                                ->get();

                $data = collect([
                    'vendors' => $datalist,
                    'offers' => $offers
                ]);
                return response()->json(['status' => 200, 'message' => 'Data successfully retrieved', 'data' => $data ], 200);
            }
            return response()->json(['status' => 201, 'message' => 'Error in data retrieved'], 404);
        } catch (\Exception $e) {
            return response()->json(['status' => 201, 'message' => $e->getMessage()], 500);
        }
    }

    public function getVendorServiceTreatment(Request $request)
    {
        try {
            $userid = $request->user()->id;
            if ($services = VendorService::with('serviceinfo')->where('vendor_id',$userid)->select('id', 'service_id', 'discount')->get()) {
                $data = collect([]);
                if(!empty($services))
                {
                    foreach ($services as $key => $value) {
                        $treatments = collect([]);
                        $treatmentid = Treatment::where('service_id','=',$value['service_id'])->pluck('id');
                        $vendoretretment = VendorTreatment::with('treatmentinfo')->where('vendor_id',$userid)->select('id','treatment_id','description','price','discount','no_of_person')->whereIn('treatment_id',$treatmentid)->get();
                        $data->push([
                            'service_id' => $value['service_id'],
                            'discount' => $value['discount'],
                            'service_name' => isset($value['serviceinfo']['service_name']) ? $value['serviceinfo']['service_name'] : '' ,
                            'service_image' => isset($value['serviceinfo']['service_image']) ? URL::to('/').'/public/'.$value['serviceinfo']['service_image'] :''  ,
                            'small_image' => isset($value['serviceinfo']['small_image']) ? URL::to('/').'/public/'.$value['serviceinfo']['small_image'] : '' ,
                            'treatments' => $vendoretretment,
                        ]);
                    }
                }
                return response()->json(['status' => 200, 'message' => 'Data successfully retrieved', 'data' => $data], 200);
            }
            return response()->json(['status' => 201, 'message' => 'Error in data retrieved'], 404);
        } catch (\Exception $e) {
            return response()->json(['status' => 201, 'message' => $e->getMessage()], 500);
        }
    }
    public function vendorDeleteService(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'service_id' => 'exists:services,id'
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 201, 'message' =>  implode(', ', $validator->messages()->all())], 400);
            }
            $userid = $request->user()->id;
            if (VendorService::where('vendor_id',$userid)->where('service_id',$request->service_id)->delete()) {
                $treatmentid = Treatment::where('service_id','=',$request->service_id)->pluck('id');
                VendorTreatment::where('vendor_id',$userid)->whereIn('treatment_id',$treatmentid)->delete();
                $data = userInfoResponse($userid);
                return response()->json(['status' => 200, 'message' => 'Data successfully retrieved', 'data' => $data], 200);
            }
            return response()->json(['status' => 201, 'message' => 'Error in data retrieved'], 404);
        } catch (\Exception $e) {
            return response()->json(['status' => 201, 'message' => $e->getMessage()], 500);
        }

    }
    public function vendorDeleteTreatment(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'treatment_id' => 'exists:treatments,id'
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 201, 'message' =>  implode(', ', $validator->messages()->all())], 400);
            }
            $userid = $request->user()->id;
            if (VendorTreatment::where('vendor_id',$userid)->where('treatment_id',$request->treatment_id)->delete()) {
                $data = userInfoResponse($userid);
                return response()->json(['status' => 200, 'message' => 'Data successfully retrieved', 'data' => $data], 200);
            }
            return response()->json(['status' => 201, 'message' => 'Error in data retrieved'], 404);
        } catch (\Exception $e) {
            return response()->json(['status' => 201, 'message' => $e->getMessage()], 500);
        }
    }

    public function getVendorInfo(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'vendor_id' => 'required|exists:vendor_details,vendor_id'
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 201, 'message' =>  implode(', ', $validator->messages()->all())], 400);
            }
            DB::table('vendor_details')->where('vendor_id',$request->vendor_id)->increment('profile_viewed', 1);


            $viewData = ['vendor_id'=> $request->vendor_id];

            if(Auth::check()) {

                $viewData['user_id'] = Auth::id();
            } else {
                $viewData['guest_ip'] = request()->ip();
            }

            $view = RecentlyView::where($viewData);

            if($view->exists()){

                $view->update(['view_time' => now()]);

            } else {
                $viewData['view_time'] = now();
                RecentlyView::create($viewData);
            }

            $data = userInfoResponse($request->vendor_id);
            if ($data) {
                unset($data['token']);
                return response()->json(['status' => 200, 'message' => 'Data successfully retrieved', 'data' => $data], 200);
            }
            return response()->json(['status' => 201, 'message' => 'Error in data retrieved'], 404);
        } catch (\Exception $e) {
            return response()->json(['status' => 201, 'message' => $e->getMessage()], 500);
        }
    }

    public function searchVendorList(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'latitude' => 'required',
                'longitude' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 201, 'message' =>  implode(', ', $validator->messages()->all())], 400);
            }
            $latitude = $request->latitude;
            $longitude = $request->longitude;
            $distance = isset($request->distance) ? $request->distance : 25 ;

            $vendors = VendorDetail::with('vendorrating','vendortreatments','vendoraddress')

                ->where(function ($query) use($request) {
                    if(!empty($request->search))
                    {
                        $query->where('firm_name', 'like', "%$request->search%")
                            ->orWhereHas('vendortreatments', function ($q) use ($request) {
                                $q->whereHas('treatmentinfo', function($qp) use ($request)
                                {
                               $qp->where('treatment_name', 'like', "%$request->search%");
                                });
                            });
                    }
                })
                ->select(DB::raw('vendor_id, firm_name, about_us, latitude, longitude, membershipvalid ,'.DB::raw('CONCAT("'.URL::to('/').'", "/public/", logo) AS logo').', FLOOR( 6367 * acos( cos( radians('.$latitude.') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians('.$longitude.') ) + sin( radians('.$latitude.') ) * sin( radians( latitude ) ) ) ) AS distance'))
                ->havingRaw("distance < $distance")
                ->where('membershipvalid','>=', date('Y-m-d'))
//               // ->having('distance', '<', $distance)->orderBy('distance')->get();
                ->orderBy('distance')->get();

            if ($vendors) {
                $datalist = collect([]);
                foreach ($vendors as $key => $rows) {
                    $address = !empty($rows->vendoraddress) ? $rows->vendoraddress->first() : array();
                    $treatment = !empty($rows->vendortreatments) ? $rows->vendortreatments->first() : array();
                    $avgrating = $rows->vendorrating->avg('rating') ;
                    $datalist->push([
                        'vendor_id' => $rows->vendor_id,
                        'firm_name' => $rows->firm_name,
                        'latitude' => isset($rows->latitude) ? $rows->latitude : '',
                        'longitude' => isset($rows->longitude) ? $rows->longitude : '',
                        'treatment_name' => isset($treatment['treatmentinfo']['treatment_name']) ? $treatment['treatmentinfo']['treatment_name'] : '',
                        'about_us' => isset($rows->about_us) ? $rows->about_us : '',
                        'logo' => isset($rows->logo) ? $rows->logo : '',
                        'distance' => $rows->distance,
                        'rating' => isset($avgrating) ? $avgrating : 0,
                        'vendoraddress' => isset($address['address_line1']) ? $address['address_line1'].' '.$address['city'].' '.$address['state'].' '.$address['postcode'] : '',
                    ]);
                }
                return response()->json(['status' => 200, 'message' => 'Data successfully retrieved', 'data' => $datalist ], 200);
            }
            return response()->json(['status' => 201, 'message' => 'Error in data retrieved'], 404);
        } catch (\Exception $e) {
            return response()->json(['status' => 201, 'message' => $e->getMessage()], 500);
        }
    }

    public function renewMembership(Request $request)
    {
        try {
            $userid = $request->user()->id;
            $validator = Validator::make($request->all(), [
                'plan_id' => 'required|exists:subscriptions,id',
                'amount'  => 'required',
                'txn_status'  => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 201, 'message' =>  implode(', ', $validator->messages()->all())], 400);
            }
            $plan = Subscription::where('id', $request->plan_id)->select('id','days')->first();
            if ($membership = Membership::create([
                    'user_id' => $userid,
                    'plan_id' => $request->plan_id,
                    'amount' => $request->amount,
                    'transaction_id' => isset($request->transaction_id) ? $request->transaction_id :null,
                    'txn_status' => isset($request->txn_status) ? $request->txn_status : '',
                    'description' => isset($request->description) ? $request->description : '',
                    'response' => isset($request->response) ? $request->response : null,
                    'status' => ($request->txn_status == 'succeeded') ? true : false,
                    'start_date'  => date('Y-m-d'),
                    'end_date'  => date('Y-m-d', strtotime('+'.$plan->days.' day')),
                ])) {
                VendorDetail::where('vendor_id',$userid)->update(['membershipvalid' => date('Y-m-d', strtotime('+'.$plan->days.' day'))]);
                return response()->json(['status' => 200, 'message' => 'Membership Renewed successfully', 'data' => $membership], 200);
            }
            return response()->json(['status' => 201, 'message' => 'Error in Membership Renewed'], 404);
        } catch (\Exception $e) {
            return response()->json(['status' => 201, 'message' => $e->getMessage()], 500);
        }
    }

    public function purchaseMembership(Request $request)
    {
        try {
            $userid = $request->user()->id;
            $validator = Validator::make($request->all(), [
                'plan_id' => 'required|exists:subscriptions,id',
                'amount'  => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 201, 'message' =>  implode(', ', $validator->messages()->all())], 400);
            }
            $plan = Subscription::where('id', $request->plan_id)->select('id','days')->first();
            if ($membership = Membership::create([
                    'user_id' => $userid,
                    'plan_id' => $request->plan_id,
                    'amount' => $request->amount,
                    'description' => isset($request->description) ? $request->description : '',
                    'txn_status' => isset($request->txn_status) ? $request->txn_status : '',
                    'status' => false,
                    'start_date'  => date('Y-m-d'),
                    'end_date'  => date('Y-m-d', strtotime('+'.$plan->days.' day')),
                ])) {

                $notification = new Notification();
                $notification->title = 'Membership purchased';
                $notification->message = 'Congratulations, You have successfully purchased the membership.';
                $notification->type = 'Membership Plan';
                $notification->user_id  = $membership->vendor_id;
                $notification->type_id  = $membership->id;
                $notification->created_at = date('d-m-Y H:i:s');
                $notification->save();
                $AsminId = User::where('type','Admin')->first();
                $vendor = VendorDetail::where('vendor_id',$userid)->first();
                $notification = new Notification();
                $notification->title = 'Membership purchased';
                $notification->message = $vendor->firm_name.' has purchased a new membership Plan ';
                $notification->type = 'Membership';
                $notification->user_id  = $AsminId->id;
                $notification->type_id  =  $membership->id;
                $notification->created_at = date('d-m-Y H:i:s');
                $notification->save();
                $data = $notification;
                broadcast(new \App\Events\SendNotification($data))->toOthers();
                return response()->json(['status' => 200, 'message' => 'Membership Renewed successfully', 'data' => $membership], 200);
            }
            return response()->json(['status' => 201, 'message' => 'Error in Membership Renewed'], 404);
        } catch (\Exception $e) {
            return response()->json(['status' => 201, 'message' => $e->getMessage()], 500);
        }
    }

    // public function purchaseMembershipResponse(Request $request)
    // {
    //     try {
    //         $userid = $request->user()->id;
    //         $validator = Validator::make($request->all(), [
    //             'membership_id' => 'required|exists:memberships,id',
    //             'txn_status'  => 'required',
    //         ]);
    //         if ($validator->fails()) {
    //             return response()->json(['status' => 201, 'message' =>  implode(', ', $validator->messages()->all())], 400);
    //         }
    //         if ($membership = Membership::where('id', $request->membership_id)->where('user_id', $userid)->update([
    //                 'transaction_id' => isset($request->transaction_id) ? $request->transaction_id :null,
    //                 'response' => isset($request->response) ? $request->response : null,
    //                 'txn_status' => isset($request->txn_status) ? $request->txn_status : '',
    //                 'status' => ($request->txn_status == 'succeeded') ? true : false,
    //             ])) {
    //             if($request->txn_status == 'succeeded')
    //             {
    //                 $enddate = Membership::where('id', $request->membership_id)->where('user_id', $userid)->pluck('end_date')->first();
    //                 VendorDetail::where('vendor_id',$userid)->update(['membershipvalid' => $enddate]);
    //             }
    //             $data = userInfoResponse($userid);
    //             return response()->json(['status' => 200, 'message' => 'Membership Renewed successfully', 'data' => $data], 200);
    //         }
    //         return response()->json(['status' => 201, 'message' => 'Error in Membership Renewed'], 404);
    //     } catch (\Exception $e) {
    //         return response()->json(['status' => 201, 'message' => $e->getMessage()], 500);
    //     }
    // }
    public function purchaseMembershipResponse(Request $request)
    {
        try {
            $userid = $request->user()->id;
            $validator = Validator::make($request->all(), [
                'plan_id' => 'required|exists:subscriptions,id',
                'amount'  => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 201, 'message' =>  implode(', ', $validator->messages()->all())], 400);
            }
            $plan = Subscription::where('id', $request->plan_id)->select('id','days')->first();
            $request->booking_id = date('YmdHis');
            if ($payment = mollieCreatePayment($request)) {
                Membership::create([
                    'user_id' => $userid,
                    'plan_id' => $request->plan_id,
                    'amount' => $request->amount,
                    'transaction_id'=> $payment->id,
                    'description' => isset($request->description) ? $request->description : '',
                    'txn_status' => isset($request->txn_status) ? $request->txn_status : '',
                    'status' => false,
                    'start_date'  => date('Y-m-d'),
                    'end_date'  => date('Y-m-d', strtotime('+'.$plan->days.' day')),
                ]);
                return response()->json(['status' => 200, 'message' => 'Membership Renewed successfully', 'data' => $payment], 200);
            }

            // if ($membership = Membership::create([
            //         'user_id' => $userid,
            //         'plan_id' => $request->plan_id,
            //         'amount' => $request->amount,
            //         'description' => isset($request->description) ? $request->description : '',
            //         'txn_status' => isset($request->txn_status) ? $request->txn_status : '',
            //         'transaction_id' => isset($request->transaction_id) ? $request->transaction_id :null,
            //         'response' => isset($request->response) ? $request->response : null,
            //         'status' => ($request->txn_status == 'succeeded') ? true : false,
            //         'start_date'  => date('Y-m-d'),
            //         'end_date'  => date('Y-m-d', strtotime('+'.$plan->days.' day')),
            //     ])) {
            //    if($request->txn_status == 'succeeded')
            //     {
            //         VendorDetail::where('vendor_id',$userid)->update(['membershipvalid' =>date('Y-m-d', strtotime('+'.$plan->days.' day'))]);
            //     }
            //     $data = userInfoResponse($userid);
            //     return response()->json(['status' => 200, 'message' => 'Membership Renewed successfully', 'data' => $data], 200);
            // }
            return response()->json(['status' => 201, 'message' => 'Error in Membership Renewed'], 404);
        } catch (\Exception $e) {
            return response()->json(['status' => 201, 'message' => $e->getMessage()], 500);
        }
    }


    public function generateUniqueReferralCode()
    {
        $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $code = substr(str_shuffle($permitted_chars), 0, 10);
        if (User::where('referral_code', '=', $code)->exists()) {
            $this->generateUniqueReferralCode();
        }
        return $code ;
    }

    public function purchaseMembershipStatus(Request $request)
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
                $membership = Membership::where('user_id',$userid)->where('transaction_id',$request->transectionid)->first();
                $membership->status = ($payment->status === 'paid') ? 1 : 0 ;
                $membership->txn_status = ($payment->status === 'paid') ? 'succeeded' : 'error' ;
                $membership->save();
                if($payment->status === 'paid')
                {
                    VendorDetail::where('vendor_id',$userid)->update(['membershipvalid' => $membership->end_date]);
                }
                $data = userInfoResponse($userid);
                return response()->json(['status' => 200, 'message' => 'Payment successfully', 'data' => $data ], 200);
            }
            return response()->json(['status' => 201, 'message' => 'Error in Payment '], 404);
        } catch (\Exception $e) {
            return response()->json(['status' => 201, 'message' => $e->getMessage()], 500);
        }
    }
}
