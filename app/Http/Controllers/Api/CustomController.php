<?php

namespace App\Http\Controllers\Api;

use App\Events\SendNotification;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Services;
use App\Models\Country;
use App\Models\Language;
use App\Models\Treatment;
use App\Models\Contactus;
use App\Models\ProductBrand;
use App\Models\ReferralEarn;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\URL;
use App\Models\Membership;

class CustomController extends Controller
{
    public function getCountry(Request $request){
        try {
            $country = Country::select('id','country_name as name','phone_code','country_code','code',DB::raw('CONCAT("'.URL::to('/').'", "/public/assets/flags/", flag,".png") AS flag'))->get();
            if(count($country) > 0)
            {
                return response()->json(['status' => 200,'message' => 'Country successfully retrieved','data' => $country ], 200);
            }
            return response()->json(['status' => 201,'message' => 'Error in Country retrieved' ], 200);

        } catch(\Exception $e) {
            return response()->json(['status' => 201,'message' => $e->getMessage() ], 200);
        }
    }

    public function getLanguage(Request $request){
        try {
            $language = Language::select('id','name', 'status')->get();
            if(count($language) > 0)
            {
                return response()->json(['status' => 200,'message' => 'Language successfully retrieved','data' => $language ], 200);
            }
            return response()->json(['status' => 201,'message' => 'Error in Language retrieved' ], 200);

        } catch(\Exception $e) {
            return response()->json(['status' => 201,'message' => $e->getMessage() ], 200);
        }
    }

    public function getServices(Request $request){
        try {
            $services = Services::where('active','=','Y')->select('id','service_name',DB::raw('CONCAT("'.URL::to('/').'/public/", service_image) AS service_image '), DB::raw('CONCAT("'.URL::to('/').'/public/", small_image) AS small_image '))->get();
            if(count($services) > 0)
            {
                return response()->json(['status' => 200,'message' => 'Services successfully retrieved','data' => $services ], 200);
            }
            return response()->json(['status' => 201,'message' => 'Error in Services retrieved' ], 200);

        } catch(\Exception $e) {
            return response()->json(['status' => 201,'message' => $e->getMessage() ], 200);
        }
    }

    public function getProductBrand(Request $request){
        try {
            $serviceid = $request->service_id;
            $treatment_id = $request->treatment_id ;
            $products = ProductBrand::where('active','=','Y')
                                        ->where(function ($query) use($serviceid, $treatment_id) {
                                            if(!empty($serviceid))
                                            {
                                                $query->where('service_id', '=', $serviceid);
                                            }
                                            if(!empty($treatment_id))
                                            {
                                                $query->where('treatment_id', '=', $treatment_id);
                                            }
                                        })
                                        ->select('id','brand_name',DB::raw('CONCAT("'.URL::to('/').'/public/", brand_image) AS brand_image '))
                                        ->get();
//            if(count($products) > 0)
//            {
                return response()->json(['status' => 200,'message' => 'Product successfully retrieved','data' => $products ], 200);
//            }
//            return response()->json(['status' => 201,'message' => 'Error in Product retrieved' ], 200);

        } catch(\Exception $e) {
            return response()->json(['status' => 201,'message' => $e->getMessage() ], 200);
        }
    }

    public function getServiceTreatments(Request $request){
        try {
            $serviceid = $request->service_id ;
            $treatments = Treatment::where('active','=','Y')
                            ->where(function ($query) use($serviceid) {
                                if(!empty($serviceid))
                                {
                                    $query->where('service_id', '=', $serviceid);
                                }
                            })
                            ->select('id','service_id', 'treatment_name',DB::raw('CONCAT("'.URL::to('/').'/public/", treatment_image) AS treatment_image '), DB::raw('CONCAT("'.URL::to('/').'/public/", small_image) AS small_image '))
                            ->get();
            if(count($treatments) > 0)
            {
                return response()->json(['status' => 200,'message' => 'Services successfully retrieved','data' => $treatments ], 200);
            }
            return response()->json(['status' => 201,'message' => 'Error in Services retrieved' ], 200);

        } catch(\Exception $e) {
            return response()->json(['status' => 201,'message' => $e->getMessage() ], 200);
        }
    }

    public function contactUs(Request $request)
    {
         try
        {
            $validator = Validator::make($request->all(), [
                'name'     => 'required',
                'message'      => 'required',
                'email'         => "required",
                'phone'     => "required",
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 201, 'message' =>  implode(', ',$validator->messages()->all())], 200);
            }
            if ($data = Contactus::create([
                'name' => isset($request->name) ? $request->name : '',
                'message' => isset($request->message) ? $request->message : '',
                'email' => isset($request->email) ? $request->email : '',
                'phone' => isset($request->phone) ? $request->phone : null,
            ])) {

                broadcast(new \App\Events\SendNotification($data))->toOthers();
                return response()->json(['status' => 200, 'message' => 'Contact us Added succesfully','data' => $data ], 200);
//                "Vendor_Name" or "Customer_Name"

            }
            return response()->json(['status' => 201, 'message' => 'Error in Contact us' ], 200);
        }
        catch(\Exception $e)
        {
            return response()->json(['status' => 201, 'message' => $e->getMessage() ], 500);
        }
    }

    public function getServiceFilterDate(Request $request)
    {
        try {
            $services = Services::with('treatments','treatments.productbrands')->where('active','=','Y')->select('id','service_name')->get();
            if(count($services) > 0)
            {
                return response()->json(['status' => 200,'message' => 'Services successfully retrieved','data' => $services ], 200);
            }
            return response()->json(['status' => 201,'message' => 'Error in Services retrieved' ], 200);

        } catch(\Exception $e) {
            return response()->json(['status' => 201,'message' => $e->getMessage() ], 200);
        }
    }

    public function referralEarn(Request $request)
    {
         try
        {
            $userid = $request->user()->id;
            $validator = Validator::make($request->all(), [
                'referral_code'     => 'required',
                'share_via'      => 'required',
                'email'     => "nullable|email|unique:referral_earns,email",
                'phone'     => "nullable|unique:referral_earns,phone",
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 201, 'message' =>  implode(', ',$validator->messages()->all())], 200);
            }
            if ($data = ReferralEarn::create([
                'referralby' => $userid,
                'referral_code' => isset($request->referral_code) ? $request->referral_code : null,
                'share_via' => isset($request->share_via) ? $request->share_via : '',
                'email'     => isset($request->email) ? $request->email : null,
                'phone'     => isset($request->phone) ? $request->phone : null,
                'referral_date' => date('Y-m-d'),
            ])) {
                return response()->json(['status' => 200, 'message' => 'Referral succesfully','data' => $data ], 200);
            }
            return response()->json(['status' => 201, 'message' => 'Error in Referral' ], 200);
        }
        catch(\Exception $e)
        {
            return response()->json(['status' => 201, 'message' => $e->getMessage() ], 500);
        }
    }
    public function subscriptionPlan(Request $request){
        try {
            $serviceid = $request->service_id ;
            $activemembership = Membership::where('user_id','=',$request->user_id)->where('status', '=', '1')
                        ->whereDate('start_date', '<=', date("Y-m-d"))
                        ->whereDate('end_date', '>=', date("Y-m-d"))
                        ->latest()->first();

            $plans = Subscription::where('active','=','Y')
                            ->select('id','plan_name', 'plan_type', 'amount', 'monthly_price', 'yearly_price', 'days', 'description', 'portfolio', 'calendar', 'available', 'long_bio', 'profile_bg', 'performance', 'account_data', 'liability', 'dbs_option', 'created_at')
                            ->get();
            if(count($plans) > 0)
            {
                $subscription = $plans->map(function($item) use($activemembership) {
                                $end_date = !empty($activemembership) ? strtotime($activemembership['end_date']) : strtotime(date("Y-m-d")) ;
                                $start_date = !empty($activemembership) ? strtotime($activemembership['start_date']) : strtotime(date("Y-m-d")) ;
                                $plandays = ($end_date - $start_date) / (60 * 60 * 24);
                                $item['quarterly_monthly'] =  number_format(($item->monthly_price / 3), 2);
                                $item['yearly_monthly'] = number_format(($item->yearly_price / 12), 2);
                                $item['quarterly'] = (!empty($activemembership) && $activemembership['plan_id'] === $item['id'] && $plandays >= 80 && $plandays <= 100) ? true : false;
                                $item['yearly'] =  (!empty($activemembership) && $activemembership['plan_id'] === $item['id'] && $plandays >= 200 && $plandays <= 370) ? true : false;
                                return $item;
                            });
                return response()->json(['status' => 200,'message' => 'SubscriptionPlan successfully retrieved','data' => $subscription ], 200);
            }
            return response()->json(['status' => 201,'message' => 'Error in SubscriptionPlan retrieved' ], 200);

        } catch(\Exception $e) {
            return response()->json(['status' => 201,'message' => $e->getMessage() ], 200);
        }
    }

    public function getuserEarnList(Request $request)
    {
        $userid = $request->user()->id;
        $referdata = ReferralEarn::select('referralby', DB::raw('SUM(amount) as total_earning'), DB::raw('count(referralby) as total_refer'))->groupBy('referralby')->where('referralby','=',$userid)->first();
        $referlist = ReferralEarn::select('referral_date','amount')->where('referralby','=',$userid)->get();
        if ($data = collect([
                'referralby' => $userid,
                'referral_code' => isset($request->user()->referral_code) ? $request->user()->referral_code : null,
                'total_earning' => isset($referdata['total_earning']) ? $referdata['total_earning'] : 0,
                'total_refer' => isset($referdata['total_refer']) ? $referdata['total_refer'] : 0,
                'referlist'     => $referlist,
            ])) {
            return response()->json(['status' => 200, 'message' => 'Referral succesfully','data' => $data ], 200);
        }
        return response()->json(['status' => 201, 'message' => 'Error in Referral' ], 200);
    }

    public function checkMembership(Request $request)
    {
        try {
            $userid = $request->user()->id;
            //$membership = Membership::where('user_id', '=', $userid)->where('status', '=', 1)->whereDate('end_date', '>=', date("Y-m-d"))->first();
            if (Membership::where('user_id', '=', $userid)->where('status', '=', 1)->whereDate('end_date', '>=', date("Y-m-d"))->exists()) {
                return response()->json(['status' => 200, 'message' => true]);
            }
            return response()->json(['status' => 201, 'message' => false ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 201, 'message' => $e->getMessage()], 500);
        }
    }

    public function updateNotifySetting(Request $request)
    {
         try
        {
            $userid = $request->user()->id;
            $validator = Validator::make($request->all(), [
                'is_notify'     => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 201, 'message' =>  implode(', ',$validator->messages()->all())], 200);
            }
            if ($data = User::where('id', '=', $userid)->update(['is_notify' => isset($request->is_notify) ? $request->is_notify : 1])) {
                return response()->json(['status' => 200, 'message' => 'Notify Setting succesfully','data' => $data ], 200);
            }
            return response()->json(['status' => 201, 'message' => 'Error in Notify Setting' ], 200);
        }
        catch(\Exception $e)
        {
            return response()->json(['status' => 201, 'message' => $e->getMessage() ], 500);
        }
    }
    public function searchClient(Request $request)
    {
        try
        {
            $userid = $request->user()->id;
            $validator = Validator::make($request->all(), [
                'search'     => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 201, 'message' =>  implode(', ',$validator->messages()->all())], 200);
            }
            if ($data = User::where('type','=','User')
                ->where(function ($query) use($request) {
                    $query->where('name', 'LIKE', '%'.$request->search.'%')->orWhere('firstname', 'LIKE', '%'.$request->search.'%')->orWhere('lastname', 'LIKE', '%'.$request->search.'%');
                })->select('id','name','firstname','lastname',DB::raw('CONCAT("'.URL::to('/').'/public/", profile) AS profile '),'phone','email')->get()) {
                return response()->json(['status' => 200, 'message' => 'Data retrieved successfully','data' => $data ], 200);
            }
            return response()->json(['status' => 201, 'message' => 'Error in Data retrieved' ], 200);
        }
        catch(\Exception $e)
        {
            return response()->json(['status' => 201, 'message' => $e->getMessage() ], 500);
        }
    }
}
