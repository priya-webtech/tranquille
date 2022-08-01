<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Offer;
use App\Models\Treatment;
use App\Models\Services;
use App\Models\Notification;
use App\Models\Booking;
use App\Models\VendorDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\URL;

class UserController extends Controller
{
    public function userDashboard(Request $request)
    {
        try {
            $serviceid = $request->service_id ;
            $data = collect([]);
            $data['offers'] = Offer::where('active','=','Y')
                            	->select('id','offer_title', 'discount',DB::raw('CONCAT("'.URL::to('/').'/public/", offer_image) AS offer_image '))
                            	->get();


            $data['treatments'] = Treatment::where('active','=','Y')
                            ->where(function ($query) use($serviceid) {
                                if(!empty($serviceid))
                                {
                                    $query->where('service_id', '=', $serviceid);
                                }
                            })
                            ->select('id','service_id', 'treatment_name',DB::raw('CONCAT("'.URL::to('/').'/public/", treatment_image) AS treatment_image '), DB::raw('CONCAT("'.URL::to('/').'/public/", small_image) AS small_image '))
                            ->get();
            $data['featuretreatments'] = Treatment::where('active','=','Y')
                            ->where(function ($query) use($serviceid) {
                                if(!empty($serviceid))
                                {
                                    $query->where('service_id', '=', $serviceid);
                                }
                                $query->where('feature', '=', 1);
                            })
                            ->select('id','service_id', 'treatment_name',DB::raw('CONCAT("'.URL::to('/').'/public/", treatment_image) AS treatment_image '), DB::raw('CONCAT("'.URL::to('/').'/public/", small_image) AS small_image '))
                            ->get();

            if($data)
            {
                return response()->json(['status' => 200, 'message' => 'Data retrieved successfully', 'data' => $data], 200);
            }
            return response()->json(['status' => 201, 'message' => 'Error in Data retrieved'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 201, 'message' => $e->getMessage()], 500);
        }
    }

    public function notificationList(Request $request)
    {
        try {
            $userid = $request->user()->id;
            $data = Notification::where('user_id', $userid)->where('is_seen', 0)
                        ->select('id','type', 'type_id', 'title', 'message', 'is_seen', 'created_at', 'booking_id', 'status')
                        ->paginate(25);
            if ($data) {
                return response()->json(['status' => 200, 'message' => 'Data retrieved successfully', 'data' => $data ], 200);
            }
            return response()->json(['status' => 201, 'message' => 'Error in data retrieved'], 404);
        } catch (\Exception $e) {
            return response()->json(['status' => 201, 'message' => $e->getMessage()], 500);
        }
    }

    public function notificationSeen(Request $request)
    {
        try {
            $userid = $request->user()->id;
            if ($userid) {
                Notification::where('user_id',$userid)->update(['is_seen'=>1]);
                return response()->json(['status' => 200, 'message' => 'Notification Seen'], 200);
            }
            return response()->json(['status' => 201, 'message' => 'Error in data retrieved'], 404);
        } catch (\Exception $e) {
            return response()->json(['status' => 201, 'message' => $e->getMessage()], 500);
        }
     }
    public function dashboardServices(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                // 'latitude' => 'required',
                // 'longitude' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 201, 'message' =>  implode(', ', $validator->messages()->all())], 400);
            }
            $latitude = isset($request->latitud) ? $request->latitud : 15.8497;
            $longitude = isset($request->longitude) ? $request->longitude : 74.4977;
            // $distance = isset($request->distance) ? $request->distance : 20 ;
            // $userid = $request->user_id ;
            // $serviceid = $request->service_id ;
            $papularcategory = Booking::with('serviceinfo')->select('service_id')
                                        ->groupBy('service_id')
                                        ->selectRaw('count(service_id) as total_bookings')
                                        ->orderBy('total_bookings', 'DESC')
                                        ->limit(4)->get();


            $hairvendors = VendorDetail::where(function ($query) use($request) {
                    $query->where('membershipvalid','>=', date('Y-m-d'));
                    $query->whereHas('vendorservices', function($query) use ($request){
                        $query->where('service_id', '=', 1);
                    });
                })
                ->select(DB::raw('vendor_id, firm_name, about_us, '.DB::raw('CONCAT("'.URL::to('/').'", "/public/", logo) AS logo').', ( 6367 * acos( cos( radians('.$latitude.') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians('.$longitude.') ) + sin( radians('.$latitude.') ) * sin( radians( latitude ) ) ) ) AS distance'))
                ->withCount(['vendorrating as average_rating' => function($query) {
                                $query->select(DB::raw('coalesce(avg(rating),0)'));
                            }])->orderByDesc('average_rating')
                ->limit(10)
                ->get();
            $hairsalons = collect([]);
            if ($hairvendors) {
                foreach ($hairvendors as $key => $rows) {
                    $address = !empty($rows->vendoraddress) ? $rows->vendoraddress->first() : array();
                    $hairsalons->push([
                        'vendor_id' => $rows->vendor_id,
                        'firm_name' => $rows->firm_name,
                        'about_us' => isset($rows->about_us) ? $rows->about_us : '',
                        'logo' => isset($rows->logo) ? $rows->logo : '',
                        'distance' => $rows->distance,
                        'rating' => !empty($rows->average_rating) ? $rows->average_rating: 0,
                        'vendoraddress' => isset($address['address_line1']) ? $address['address_line1'].' '.$address['city'].' '.$address['state'].' '.$address['postcode'] : '',
                        'demo_images' => isset($rows['vendorDemos']['demo_image']) ? URL::to('/').'/public'.$rows['vendorDemos']['demo_image'] : '',
                    ]);
                }
            }

            $beautyvendors = VendorDetail::where(function ($query) use($request) {
                    $query->where('membershipvalid','>=', date('Y-m-d'));
                    $query->whereHas('vendorservices', function($query) use ($request){
                        $query->where('service_id', '=', 2);
                    });
                })
                ->select(DB::raw('vendor_id, firm_name, about_us, '.DB::raw('CONCAT("'.URL::to('/').'", "/public/", logo) AS logo').', ( 6367 * acos( cos( radians('.$latitude.') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians('.$longitude.') ) + sin( radians('.$latitude.') ) * sin( radians( latitude ) ) ) ) AS distance'))
                ->withCount(['vendorrating as average_rating' => function($query) {
                                $query->select(DB::raw('coalesce(avg(rating),0)'));
                            }])->orderByDesc('average_rating')
                 ->limit(10)
                ->get();
            $beautysalons = collect([]);
            if ($beautyvendors) {
                foreach ($beautyvendors as $key => $rows) {
                    $address = !empty($rows->vendoraddress) ? $rows->vendoraddress->first() : array();
                    $beautysalons->push([
                        'vendor_id' => $rows->vendor_id,
                        'firm_name' => $rows->firm_name,
                        'about_us' => isset($rows->about_us) ? $rows->about_us : '',
                        'logo' => isset($rows->logo) ? $rows->logo : '',
                        'distance' => $rows->distance,
                        'rating' => !empty($rows->average_rating) ? $rows->average_rating: 0,
                        'vendoraddress' => isset($address['address_line1']) ? $address['address_line1'].' '.$address['city'].' '.$address['state'].' '.$address['postcode'] : '',
                        'demo_images' => isset($rows['vendorDemos']['demo_image']) ? URL::to('/').'/public'.$rows['vendorDemos']['demo_image'] : '',
                    ]);
                }
            }
            $spavendors = VendorDetail::where(function ($query) use($request) {
                    $query->where('membershipvalid','>=', date('Y-m-d'));
                    $query->whereHas('vendorservices', function($query) use ($request){
                        $query->where('service_id', '=', 3);
                    });
                })
                ->select(DB::raw('vendor_id, firm_name, about_us, '.DB::raw('CONCAT("'.URL::to('/').'", "/public/", logo) AS logo').', ( 6367 * acos( cos( radians('.$latitude.') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians('.$longitude.') ) + sin( radians('.$latitude.') ) * sin( radians( latitude ) ) ) ) AS distance'))
                ->withCount(['vendorrating as average_rating' => function($query) {
                                $query->select(DB::raw('coalesce(avg(rating),0)'));
                            }])->orderByDesc('average_rating')
                 ->limit(10)
                ->get();
            $spasalons = collect([]);
            if ($spavendors) {
                foreach ($spavendors as $key => $rows) {
                    $address = !empty($rows->vendoraddress) ? $rows->vendoraddress->first() : array();
                    $spasalons->push([
                        'vendor_id' => $rows->vendor_id,
                        'firm_name' => $rows->firm_name,
                        'about_us' => isset($rows->about_us) ? $rows->about_us : '',
                        'logo' => isset($rows->logo) ? $rows->logo : '',
                        'distance' => $rows->distance,
                        'rating' => !empty($rows->average_rating) ? $rows->average_rating: 0,
                        'vendoraddress' => isset($address['address_line1']) ? $address['address_line1'].' '.$address['city'].' '.$address['state'].' '.$address['postcode'] : '',
                        'demo_images' => isset($rows['vendorDemos']['demo_image']) ? URL::to('/').'/public'.$rows['vendorDemos']['demo_image'] : '',
                    ]);
                }
            }

            $viewedvendors = VendorDetail::where(function ($query) use($request) {
                    $query->where('membershipvalid','>=', date('Y-m-d'));
                })
                ->select(DB::raw('vendor_details.vendor_id, firm_name, about_us, '.DB::raw('CONCAT("'.URL::to('/').'", "/public/", logo) AS logo').', ( 6367 * acos( cos( radians('.$latitude.') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians('.$longitude.') ) + sin( radians('.$latitude.') ) * sin( radians( latitude ) ) ) ) AS distance'))
                ->join('recently_view', function ($join) {
                           $join->on('recently_view.vendor_id', '=', 'vendor_details.vendor_id');
                           if(Auth::check()) {
                               $join->where('recently_view.user_id', Auth::id());
                           } else {
                               $join->where('recently_view.guest_ip', request()->ip());
                           }
                       })
                ->withCount(['vendorrating as average_rating' => function($query) {
                                $query->select(DB::raw('coalesce(avg(rating),0)'));
                            }])
                ->orderBy('recently_view.view_time', 'DESC')
                ->limit(10)
                ->get();
            $viewedsalons = collect([]);
            if ($viewedvendors) {
                foreach ($viewedvendors as $key => $rows) {
                    $address = !empty($rows->vendoraddress) ? $rows->vendoraddress->first() : array();
                    $viewedsalons->push([
                        'vendor_id' => $rows->vendor_id,
                        'firm_name' => $rows->firm_name,
                        'about_us' => isset($rows->about_us) ? $rows->about_us : '',
                        'logo' => isset($rows->logo) ? $rows->logo : '',
                        'distance' => $rows->distance,
                        'rating' => !empty($rows->average_rating) ? $rows->average_rating: 0,
                        'vendoraddress' => isset($address['address_line1']) ? $address['address_line1'].' '.$address['city'].' '.$address['state'].' '.$address['postcode'] : '',
                        'demo_images' => isset($rows['vendorDemos']['demo_image']) ? URL::to('/').'/public'.$rows['vendorDemos']['demo_image'] : '',
                    ]);
                }
            }

            $offers = Offer::where('active','=','Y')
                            	->select('id','offer_title', 'discount',DB::raw('CONCAT("'.URL::to('/').'/public/", offer_image) AS offer_image '))
                            	->get();
            $categories = Services::where('active','=','Y')->select('id','service_name',DB::raw('CONCAT("'.URL::to('/').'/public/", service_image) AS service_image '), DB::raw('CONCAT("'.URL::to('/').'/public/", small_image) AS small_image '))
                            ->get();

            $top_rated = VendorDetail::where(function ($query) use($request) {
                    $query->where('membershipvalid','>=', date('Y-m-d'));
                })
                ->select(DB::raw('vendor_id, firm_name, about_us, '.DB::raw('CONCAT("'.URL::to('/').'", "/public/", logo) AS logo').', ( 6367 * acos( cos( radians('.$latitude.') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians('.$longitude.') ) + sin( radians('.$latitude.') ) * sin( radians( latitude ) ) ) ) AS distance'))
                ->withCount(['vendorrating as average_rating' => function($query) {
                                $query->select(DB::raw('coalesce(avg(rating),0)'));
                            }])
                ->orderByDesc('average_rating')
                ->limit(10)
                ->get();

            $data = collect([
                'papularcategory' => $papularcategory,
                'recently_viewed' => $viewedsalons,
                'beauty_salon' => $beautysalons,
                'hair_salon' => $hairsalons,
                'spa_salon' => $spasalons,
                'offers' => $offers,
                'morecategories' => $categories,
                'top_rated' => $top_rated
            ]);
            if ($data) {
                return response()->json(['status' => 200, 'message' => 'Data retrieved successfully', 'data' => $data ], 200);
            }
            return response()->json(['status' => 201, 'message' => 'Error in data retrieved', 'data' => $data ], 404);
        } catch (\Exception $e) {
            return response()->json(['status' => 201, 'message' => $e->getMessage()], 500);
        }
    }

}
