<?php

use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use App\Models\VendorTreatment;
use App\Models\Treatment;
use App\Models\Booking;
use App\Models\Membership;
use App\Models\Feedback;
use App\Models\ReferralEarn;
use Illuminate\Support\Facades\DB;

function userInfoResponse($userid)
{
    $data = User::with('vendorservices','vendordetails','useraddress','vendorBusinessHours','demoimages','vendortreatments','vendorteams','vendorproducts','vendorproducts.productbrandinfo')->where('id', $userid)->first();
    $vendorservice = collect([]);
    if(!empty($data['vendorservices']))
    {
        foreach ($data['vendorservices'] as $key => $value) {
            $treatmentid = Treatment::where('service_id','=',$value['service_id'])->pluck('id');
            $vendoretretment = VendorTreatment::with('treatmentinfo')->where('vendor_id',$userid)->select('id','treatment_id','description','price','discount','no_of_person')->whereIn('treatment_id',$treatmentid)->get();
            $vendorservice->push([
                'service_id' => $value->service_id ,
                'service_name' => isset($value->serviceinfo->service_name) ? $value->serviceinfo->service_name :'' ,
                'treatments' => $vendoretretment,
            ]);
        }
    }
    $vendorteams = collect([]);
    if(!empty($data['vendorteams']))
    {
        foreach ($data['vendorteams'] as $key => $team) {
            $vendorteams->push([
                'employee_id' => $team->id ,
                'active' => $team->active ,
                'employee_name' => isset($team->employee_name) ? $team->employee_name :'' ,
                'designation' => isset($team->designation) ? $team->designation :'' ,
                'skills' => isset($team->skills) ? $team->skills :'' ,
                'profile_pic' => isset($team->profile_pic) ? URL::to('/').'/public/'.$team->profile_pic : '' ,
            ]);
        }
    }

    $useraddres = collect([]);
    if(!empty($data['useraddress']))
    {
        foreach ($data['useraddress'] as $key => $rows) {
            $useraddres->push([
                'address_id' => isset($rows->id) ? $rows->id : 0 ,
                'is_main' => isset($rows->is_main) ? $rows->is_main : 0 ,
                'address_line1' => isset($rows->address_line1) ? $rows->address_line1 :'' ,
                'address_line2' => isset($rows->address_line2) ? $rows->address_line2 :'' ,
                'state'     => isset($rows->state) ? $rows->state :'' ,
                'city' => isset($rows->city) ? $rows->city :'' ,
                'postcode' => isset($rows->postcode) ? $rows->postcode :'' ,
                'latitude' => isset($rows->latitude) ? $rows->latitude :'' ,
                'longitude' => isset($rows->longitude) ? $rows->longitude :'' ,
                'location_address' => isset($rows->location_address) ? $rows->location_address :'' ,
            ]);
        }
    }
    $businesshours = collect([]);
    if(!empty($data->vendorBusinessHours))
    {
        $businesshours->push([
            'timeMonStart' => isset($data->vendorBusinessHours->timeMonStart) ? $data->vendorBusinessHours->timeMonStart :'',
            'timeMonEnd' => isset($data->vendorBusinessHours->timeMonEnd) ? $data->vendorBusinessHours->timeMonEnd :'',
            'dayMondayStatus' => isset($data->vendorBusinessHours->dayMondayStatus) ? $data->vendorBusinessHours->dayMondayStatus :false,
            'timeTueStart' => isset($data->vendorBusinessHours->timeTueStart) ? $data->vendorBusinessHours->timeTueStart :'',
            'timeTueEnd' => isset($data->vendorBusinessHours->timeTueEnd) ? $data->vendorBusinessHours->timeTueEnd :'',
            'dayTuesdayStatus' => isset($data->vendorBusinessHours->dayTuesdayStatus) ? $data->vendorBusinessHours->dayTuesdayStatus :false,
            'timeWedStart' => isset($data->vendorBusinessHours->timeWedStart) ? $data->vendorBusinessHours->timeWedStart :'',
            'timeWedEnd' => isset($data->vendorBusinessHours->timeWedEnd) ? $data->vendorBusinessHours->timeWedEnd :'',
            'dayWednesdayStatus' => isset($data->vendorBusinessHours->dayWednesdayStatus) ? $data->vendorBusinessHours->dayWednesdayStatus :false,
            'timeThuStart' => isset($data->vendorBusinessHours->timeThuStart) ? $data->vendorBusinessHours->timeThuStart :'',
            'timeThuEnd' => isset($data->vendorBusinessHours->timeThuEnd) ? $data->vendorBusinessHours->timeThuEnd :'',
            'dayThursdayStatus' => isset($data->vendorBusinessHours->dayThursdayStatus) ? $data->vendorBusinessHours->dayThursdayStatus :false,
            'timeFriStart' => isset($data->vendorBusinessHours->timeFriStart) ? $data->vendorBusinessHours->timeFriStart :'',
            'timeFriEnd' => isset($data->vendorBusinessHours->timeFriEnd) ? $data->vendorBusinessHours->timeFriEnd :'',
            'dayFridayStatus' => isset($data->vendorBusinessHours->dayFridayStatus) ? $data->vendorBusinessHours->dayFridayStatus :false,
            'timeSatStart' => isset($data->vendorBusinessHours->timeSatStart) ? $data->vendorBusinessHours->timeSatStart :'',
            'timeSatEnd' => isset($data->vendorBusinessHours->timeSatEnd) ? $data->vendorBusinessHours->timeSatEnd :'',
            'daySaturdayStatus' => isset($data->vendorBusinessHours->daySaturdayStatus) ? $data->vendorBusinessHours->daySaturdayStatus :false,
            'timeSunStart' => isset($data->vendorBusinessHours->timeSunStart) ? $data->vendorBusinessHours->timeSunStart :'',
            'timeSunEnd' => isset($data->vendorBusinessHours->timeSunEnd) ? $data->vendorBusinessHours->timeSunEnd :'',
            'daySundayStatus' => isset($data->vendorBusinessHours->daySundayStatus) ? $data->vendorBusinessHours->daySundayStatus :false,
            'timeMonFriStart' => isset($data->vendorBusinessHours->timeMonFriStart) ? $data->vendorBusinessHours->timeMonFriStart :'',
            'timeMonFriEnd' => isset($data->vendorBusinessHours->timeMonFriEnd) ? $data->vendorBusinessHours->timeMonFriEnd :'',
            'dayMonFriStatus' => isset($data->vendorBusinessHours->dayMonFriStatus) ? $data->vendorBusinessHours->dayMonFriStatus :false,
        ]);
    }

    $vendordemos = collect([]);
    if(!empty($data['demoimages']))
    {
        foreach ($data['demoimages'] as $key => $demo) {
            $vendordemos->push([
                'demo_id' => $demo->id ,
                'demo_image' => isset($demo->demo_image) ? URL::to('/').'/public/'.$demo->demo_image :'' ,
            ]);
        }
    }

    $vendorproduct = collect([]);
    if(!empty($data['vendorproducts']))
    {
        foreach ($data['vendorproducts'] as $product) {
            $vendorproduct->push([
                'productbrand_id' => $product->productbrand_id ,
                'brand_name' => isset($product['productbrandinfo']['brand_name']) ? $product['productbrandinfo']['brand_name'] :'' ,
                'brand_image' => isset($product['productbrandinfo']['brand_image']) ? URL::to('/').'/public/'.$product['productbrandinfo']['brand_image'] : '' ,
            ]);
        }
    }

    $membership = Membership::where('user_id', $data->id)->where('status','=',1)->whereDate('end_date', '>=', date('Y-m-d'))->select('id','plan_id', 'amount', 'txn_status', 'transaction_id', 'description', 'start_date', 'end_date', 'status')->latest()->first();

    $reviewsdata = Feedback::with('userinfo')
                        ->where('reviewto', $data->id)
                        ->select('id','reviewby', 'reviewto', 'booking_id', 'treatment_id', 'rating', 'ambiance', 'hygiene','medewerkers', 'review', 'created_at')
                        ->latest()
                        ->get();
    $avgrating = Feedback::where('reviewto', $data->id)->groupBy( 'reviewto' )->select( 'reviewto', DB::raw( 'AVG( rating ) as avgrating' ), DB::raw( 'AVG( ambiance ) as avgambiance' ), DB::raw( 'AVG( hygiene ) as avghygiene' ), DB::raw( 'AVG( medewerkers ) as avgmedewerkers' ) )->get();
    $reviews = collect([
        'avgrating' => isset($avgrating[0]['avgrating']) ? number_format((float)$avgrating[0]['avgrating'], 1, '.', '') : '0.0',
        'avgambiance' => isset($avgrating[0]['avgambiance']) ? number_format((float)$avgrating[0]['avgambiance'], 1, '.', '') : '0.0',
        'avghygiene' => isset($avgrating[0]['avghygiene']) ? number_format((float)$avgrating[0]['avghygiene'], 1, '.', '') : '0.0',
        'avgmedewerkers' => isset($avgrating[0]['avgmedewerkers']) ? number_format((float)$avgrating[0]['avgmedewerkers'], 1, '.', '') : '0.0',
        'reviews' => $reviewsdata
    ]);
    $user = collect([
        'user_id' => $data->id,
        'email' => isset($data->email) ? $data->email :'',
        'firstname' => isset($data->firstname) ? $data->firstname :'',
        'lastname' => isset($data->lastname) ? $data->lastname :'',
        'profile' => isset($data->profile) ? URL::to('/').'/public/'.$data->profile :'',
        'phone' => isset($data->phone) ? $data->phone :'',
        'dob' => isset($data->dob) ? $data->dob :'',
        'type' => isset($data->type) ? $data->type :'',
        'email_verified' => isset($data->email_verified) ? $data->email_verified :false,
        'phone_verified' => isset($data->phone_verified) ? $data->phone_verified :false,
        'is_notify' => isset($data->is_notify) ? $data->is_notify :false,
        'language' => isset($data->language) ? $data->language :'',
        'profile_status' => isset($data->profile_status) ? $data->profile_status :1,
        'firm_name' => isset($data->vendordetails->firm_name) ? $data->vendordetails->firm_name :'',
        'about_us' => isset($data->vendordetails->about_us) ? $data->vendordetails->about_us :'',
        'service_type' => isset($data->vendordetails->service_type) ? $data->vendordetails->service_type :'',
        'website' => isset($data->vendordetails->website) ? $data->vendordetails->website :'',
        'referral_code' => isset($data->vendordetails->referral_code) ? $data->vendordetails->referral_code :'',
        'logo' => isset($data->vendordetails->logo) ? $data->vendordetails->logo :'',
        'why_you' => isset($data->vendordetails->why_you) ? $data->vendordetails->why_you :'',
        'vatnumber' => isset($data->vendordetails->vatnumber) ? $data->vendordetails->vatnumber :'',
        'latitude' => isset($data->vendordetails->latitude) ? $data->vendordetails->latitude :'',
        'longitude' => isset($data->vendordetails->longitude) ? $data->vendordetails->longitude :'',
        'country' => isset($data->country) ? $data->country : '',
        'token' => request()->bearerToken(),
        'vendorservices' => $vendorservice ,
        'useraddres' => $useraddres ,
        'businesshours' => $businesshours,
        'vendordemos' => $vendordemos,
        // 'vendortreatment' => $vendortreatment,
        'vendorteams' => $vendorteams,
        'vendorproduct' => $vendorproduct,
        'membership' => !empty($membership) ? $membership : collect([ 
            'id' => 0,
            'plan_id' => 0, 
            'amount' => 0.00, 
            'txn_status' => '', 
            'transaction_id' => '', 
            'description' => '', 
            'start_date' => '', 
            'end_date' => '', 
            'status' => '']),
        'reviews' => $reviews
    ]);
    return $user;
}
function uploadImageToPath($image='', $path= '')
{

    if (!file_exists(public_path($path))) {
        File::makeDirectory($path, 0775, true);
    }
    $imageName = time().'.'.$image->getClientOriginalExtension();
    $upload = $image->move(public_path($path), $imageName);
    return $path.'/'.$imageName;
}
function removeFileFromPath($path)
{
    if (File::exists(public_path($path))) {
        File::delete(public_path($path));
    }
}
function removeImageFromPath($path)
{
    if (File::exists(public_path($path))) {
        File::delete(public_path($path));
    }
}
function productUploadImageToPath($image='', $path= '', $filename='')
{
    if (!file_exists(public_path($path))) {
        File::makeDirectory($path, 0777, true);
    }
    $imageName = time().'_1.'.$image->getClientOriginalExtension();
    $upload = $image->move(public_path($path), $imageName);
    return $path.'/'.$imageName;
}
function productRemoveImageFromPath($image)
{
    if(file_exists(public_path($image)))
    {
        unlink(public_path($image));
    }
}

function availableBookingSlot($vendor_id, $employee_id, $datetime)
{
    $booking = Booking::where('vendor_id', $vendor_id)->where('employee_id', $employee_id)->whereDate('booking_date',date('Y-m-d',strtotime($datetime)))->where('booking_time',date('H:i:s',strtotime($datetime)))->first();
    if($booking)
    {

        return false ;
    }
    return true ;
}

function bookingInfoData($booking_id)
{
    $booking =  Booking::with('userinfo','vendorinfo','serviceinfo','treatmentinfo','addressinfo','employeeinfo','paymentinfo','statusinfo')
                            ->where('id', $booking_id)
                            ->select('id','active', 'user_id', 'vendor_id', 'employee_id', 'service_id', 'treatment_id', 'address_id', 'booking_date', 'booking_time', 'orderid', 'start_time', 'expct_end_time', 'end_time', 'expct_amount', 'full_amount', 'discount_amount', 'final_amount', 'canceled', 'canceled_reson', 'user_name', 'address', 'latitude', 'longitude', 'status_id','created_at')
                            ->first();
    $booking['booking_time'] = date('H:i', strtotime($booking['booking_time']));
    return $booking ;

}

function generatestripeToken($amount)
{
    \Stripe\Stripe::setApiKey('sk_test_51Jwl0dBnA5poLFqVvqtN2M7WeKRZst3fKjzIkByX5Gvjo9FPYYwFwKRWgTeVJ2jsSI7cTzb5fjUvaGzMAshBMRkl00nsCsCqY9');
    $intent = \Stripe\PaymentIntent::create([
      'amount' => intval($amount * 100),
      'currency' => 'usd',
      'payment_method_types' => ['card'],
    ]);

    return $intent->client_secret ;
}

function sendPushNotification($data, $users)
{
    $url = 'https://fcm.googleapis.com/fcm/send';
    $serverKey = 'AAAAoA7KyOI:APA91bFrQE0jwYNk2PhGhPAGDzArCR638qLLLcVHSeOCyeXMXP8a9jpvFF0xrpbA8j5bTqrVKkBkOSEYq0o3a4MoVbQ7-G27Zz1fZtsd5hfGGrTqzDgC3cOYeGsFG7bvA4S2g5Yp389m';
    $notifications = collect([]);
    if(is_array($users))
    {
        foreach ($users as $key => $user) {
           $notifications->push([
                'user_id'       =>   $user, 
                'title'         =>   $data['title'], 
                'message'       =>   $data['message'], 
                'status'        =>   $data['status'], 
                'booking_id'    =>   isset($data['booking_id']) ? $data['booking_id'] : null, 
                'is_seen'       =>   false, 
                'created_at'    =>   date('Y-m-d h:m:s'), 
                'updated_at'    =>   date('Y-m-d h:m:s') 
           ]);
        }
        DB::table('notifications')->insert($notifications->toArray());
    }
    else
    {
        DB::table('notifications')->insert([ 
            'user_id'     =>   $users, 
            'title'     =>   $data['title'], 
            'message'     =>   $data['message'], 
            'status'     =>   $data['status'], 
            'booking_id'    =>   isset($data['booking_id']) ? $data['booking_id'] : null, 
            'is_seen'     =>   false, 
            'created_at'     =>   date('Y-m-d h:m:s'), 
            'updated_at'     =>   date('Y-m-d h:m:s') 
        ]);
        $users = array($users);
    }
    
    $FcmToken = User::whereNotNull('device_token')->whereIn('id',$users)->pluck('device_token')->all();    
    $data = [
        "registration_ids" => $FcmToken,
        "data" => [
            "title" => $data['title'],
            "body" => $data['message'],  
            "key_1" => "notification",
            "key_2" => "Value for key_2"
        ]
    ];
    $encodedData = json_encode($data);
    
    $headers = [
            'Authorization:key=' .$serverKey,
            'Content-Type: application/json',
    ];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    // Disabling SSL Certificate support temporarly
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);        
    curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);

    // Execute post
    $result = curl_exec($ch);

    if ($result === FALSE) {
        die('Curl failed: ' . curl_error($ch));
    }        
    // Close connection
    curl_close($ch);
    // FCM response
    // return $result ;      
    return $result ;    
}

function updateReferralEarnAmount($userid)
{
    if(ReferralEarn::where('referralto',$userid)->count() == 1)
    {
        ReferralEarn::where('referralto', $userid)->update(['amount' => 50.00]);
    }
}

function getCurrentTime()
{
    // date_default_timezone_set('Europe/Belgrade');
    return date('Y-m-d H:i');
}

function mollieCreatePayment($data)
{
    $mollie = new \Mollie\Api\MollieApiClient();
    $mollie->setApiKey("test_uz9Wm5VU9v2urzay3Pz8wBVQKbw6Bz");
    $payment = $mollie->payments->create([
        "amount" => [
            "currency" => "EUR",
            "value" => number_format($data->amount, 2),// You must send the correct number of decimals, thus we enforce the use of strings
        ],
        "description" => "Order #{$data->booking_id}",
        "redirectUrl" => "https://pixbrand.agency/tranquille/redirectUrl/".$data->booking_id,
        "webhookUrl" => "https://pixbrand.agency/tranquille/webhookUrl/".$data->booking_id,
        "metadata" => [
            "order_id" => $data->booking_id,
        ],
    ]);
    return $payment;
}

function molliePaymentStatus($transectionid)
{
    $mollie = new \Mollie\Api\MollieApiClient();
    $mollie->setApiKey("test_uz9Wm5VU9v2urzay3Pz8wBVQKbw6Bz");
    $payment = $mollie->payments->get($transectionid);
    return $payment;
}







