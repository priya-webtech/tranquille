<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\VendorService;
use App\Models\VendorTreatment;
use App\Models\Address;
use App\Models\VendorTeam;
use App\Models\Booking;
use App\Models\VendorProduct;
use App\Models\VendorDemo;
use App\Models\VendorDetail;
use App\Models\BusinessHours;
use App\Models\Services;
use App\Models\Feedback;
use App\Models\Membership;
use App\Models\Notification;
use App\Models\Offer;
use App\Models\Payment;
use App\Models\Country;
use App\Models\Language;
use App\Models\ReferralEarn;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Hash;


class VendorController extends Controller
{
    public function index()
    {
        //dd(User::with('vendordetails')->where('type', '=', 'Provider')->select('*')->where('active', '=', 'Y'));
        if (request()->ajax()) {

            $response =  datatables()->of(User::with('vendordetails')->select('*')->where('type', '=', 'Provider')->where('active', '=', 'Y'))
                ->addIndexColumn()
                ->editColumn('name', function ($query) {
                    if(!empty($query['vendordetails'])) {

                        return '<a href="' . url("vendors/" . encrypt($query->id)) . '">
                                    <img src="' . asset(isset($query['vendordetails']['logo']) ? $query['vendordetails']['logo'] : "assets/image/dummy.png") . '" alt="" class="img-fluid wid-40 m-r-15 rounded">' . $query['vendordetails']['firm_name'] . '
                                </a>';
                    }
                })
                ->editColumn('firstname', function ($query) {
                    return '<a href="' . url("vendors/" . encrypt($query->id)) . '">
                                <img src="' . asset(isset($query['profile']) ? $query['profile'] : 'assets/image/dummy.png') . '" alt="" class="img-fluid wid-40 m-r-15 rounded">' . $query['firstname'] . ' ' . $query['lastname'] . ';
                            </a>';
                })
                ->addColumn('action', function ($query) {
                    $active = ($query->active == 'N') ? 'checked="" value="' . $query->active . '"' : 'value="' . $query->active . '"';
                    return '<div class="d-flex align-items-center">
                        <div class="form-check">
                            <input class="form-check-input input-light-success box-size m-r-15 vendoractive" type="checkbox" ' . $active . ' id="' . $query->id . '">
                        </div>
                        <div class="dropdown-primary dropdown open">
                            <button class="btn btn-light arrow-none dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <div class="dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                <a href="javascript:void(0)" class="dropdown-item vendorDetail" value="' . encrypt($query->id) . '">View</a>
                                <a href="javascript:void(0)" class="dropdown-item editCategoryRow" value="' . encrypt($query->id) . '">Edit</a>
                                <a href="javascript:void(0)" class="dropdown-item deleteUserRow" value="' . encrypt($query->id) . '">Delete</a>
                            </div>
                        </div>
                        </div>';
                })
                ->rawColumns(['action', 'name', 'firstname'])
                ->make(true);

                // dd($response);

                return $response;
        }
        return view('vendors.index');
        // <a href="javascript:void(0)" class="btn btn-icon btn-success vendoractive" id="'.encrypt($query->id).'" value="'.$query->active.'"><i class="fa fa-check"></i></a>
        // <a href="javascript:void(0)" class="btn btn-icon btn-success vendoractive" id="' . $query->id . '"  value="'.encrypt($query->id).'"><i class="fa fa-check"></i></a>

    }

    public function active(Request $request)
    {
        try {
            // dd($request['active']);
            if (User::where('id', $request['id'])->update(['active' => ($request['active'] == 'N') ? 'Y' : 'N'])) {
                $message = ($request['active'] == 'N') ? 'Inactive' : 'Active';
                return response()->json(['status' => 'success', 'message' => 'Vendor ' . $message . ' Successfully!']);
            }
            // dd($request['active']);
            return response()->json(['status' => 'error', 'message' => 'Error in vendor activation']);
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }
    }

    public function create()
    {
        $data['service'] = Services::select('*')->get();
        $data['country'] = Country::select('*')->get();
        $data['language'] = Language::select('*')->get();
        // $data['service'] = DB::table('services')->where('id', '=', 1)->first();
        return view('vendors.create', $data);
    }

    public function store(Request $request)
    {
        // try {
        //     if (!empty($request['id'])) {
        //         $user = User::where('id', $request['id'])->first();
        //         $user->firstname = isset($request->firstname) ? $request->firstname : '';
        //         $user->lastname = isset($request->lastname) ? $request->lastname : '';
        //         $user->email = isset($request->email) ? $request->email : '';
        //         $user->phone = isset($request->phone) ? $request->phone : '';
        //         if ($request->password) {
        //             $user->password = Hash::make($request->password);
        //         }
        //         $user->save();
        //     } else {
        //         $request['name'] = $request['firstname'] . ' ' . $request['lastname'];
        //         $request['type'] = 'Provider';
        //         $request['password'] = Hash::make($request['password']);
        //         $user = User::create($request->except(['_token']));
        //     }
        //     if ($user) {
        //         return redirect()->to('vendors')->with('message_success', 'Vendor Store Successfully');
        //     }
        //     return redirect()->back()->with('message_danger', 'Error in Vendor Store')->withInput();
        // } catch (\Exception $e) {
        //     return redirect()->back()->withErrors($e->getMessage())->withInput();
        // }
        try {
            if ($request->file('image') != null) {
                $request['logo'] = uploadImageToPath($request->image, 'logo');
            }
            if ($request->file('image1') != null) {
                $request['demo_image'] = productUploadImageToPath($request->image1, 'demo_image');
            }
            $request['name'] = $request['firstname'] . ' ' . $request['lastname'];
            $request['type'] = 'Provider';
            $request['password'] = Hash::make($request['password']);
            $request['language'] = implode(', ', $request->language);

            if ($user = User::create($request->except(['_token']))) {

                if ($user['vender_details'] = VendorDetail::create([
                    'vendor_id' => $user->id,
                    'firm_name' => isset($request->firm_name) ? $request->firm_name : '',
                    'website' => isset($request->website) ? $request->website : '',
                    'country' => isset($request->country) ? $request->country : '',
                    'service_type' => isset($request->service_type) ? $request->service_type  : '',
                    'latitude' => isset($request->latitude) ? $request->latitude : '',
                    'longitude' => isset($request->longitude) ? $request->longitude : '',
                    'why_you' => isset($request->why_you) ? $request->why_you : '',
                    'logo' => isset($request['logo']) ? $request['logo'] : null,
                ])) {
                    if ($user['service'] = VendorService::create([
                        'vendor_id' => $user->id,
                        'service_id' => isset($request->service_id) ? $request->service_id : null,
                    ])) {
                        if ($user['address'] = Address::create([
                            'user_id' => $user->id,
                            'address_line1' => isset($request->address_line1) ? $request->address_line1 : '',
                            'address_line2' => isset($request->address_line2) ? $request->address_line2 : '',
                            'location_address' => isset($request->location_address) ? $request->location_address : '',
                            'latitude' => isset($request->latitude) ? $request->latitude : '',
                            'longitude' => isset($request->longitude) ? $request->longitude : '',
                            'state' => isset($request->state) ? $request->state : '',
                            'city' => isset($request->city) ? $request->city : '',
                            'postcode' => isset($request->postcode) ? $request->postcode : '',

                        ])) {
                            if ($user['vendordemo'] = VendorDemo::create([
                                'vendor_id' => $user->id,
                                'demo_image' => isset($request->demo_image) ? $request->demo_image : null,
                            ])) {
                                $user['businesshours'] = BusinessHours::create([
                                    'vendor_id' => $user->id,
                                    'timeMonStart' => isset($request->timeMonStart) ? $request->timeMonStart : null,
                                    'timeMonEnd' => isset($request->timeMonEnd) ? $request->timeMonEnd : null,
                                    'dayMondayStatus' => isset($request->dayMondayStatus) ? $request->dayMondayStatus : null,
                                    'timeTueStart' => isset($request->timeTueStart) ? $request->timeMonStart : null,
                                    'timeTueEnd' => isset($request->timeTueEnd) ? $request->timeTueEnd : null,
                                    'dayTuesdayStatus' => isset($request->dayTuesdayStatus) ? $request->dayTuesdayStatus : null,
                                    'timeWedStart' => isset($request->timeWedStart) ? $request->timeWedStart : null,
                                    'timeWedEnd' => isset($request->timeWedEnd) ? $request->timeWedEnd : null,
                                    'dayWednesdayStatus' => isset($request->dayWednesdayStatus) ? $request->dayWednesdayStatus : null,
                                    'timeThuStart' => isset($request->timeThuStart) ? $request->timeThuStart : null,
                                    'timeThuEnd' => isset($request->timeThuEnd) ? $request->timeThuEnd : null,
                                    'dayThursdayStatus' => isset($request->dayThursdayStatus) ? $request->dayThursdayStatus : null,
                                    'timeFriStart' => isset($request->timeFriStart) ? $request->timeFriStart : null,
                                    'timeFriEnd' => isset($request->timeFriEnd) ? $request->timeFriEnd : null,
                                    'dayFridayStatus' => isset($request->dayFridayStatus) ? $request->dayFridayStatus : null,
                                    'timeSatStart' => isset($request->timeSatStart) ? $request->timeSatStart : null,
                                    'timeSatEnd' => isset($request->timeSatEnd) ? $request->timeSatEnd : null,
                                    'daySaturdayStatus' => isset($request->daySaturdayStatus) ? $request->daySaturdayStatus : null,
                                    'timeSunStart' => isset($request->timeSunStart) ? $request->timeSunStart : null,
                                    'timeSunEnd' => isset($request->timeSunEnd) ? $request->timeSunEnd : null,
                                    'daySundayStatus' => isset($request->daySundayStatus) ? $request->daySundayStatus : null,
                                    'timeMonFriStart' => isset($request->timeMonFriStart) ? $request->timeMonFriStart : null,
                                    'timeMonFriEnd' => isset($request->timeMonFriEnd) ? $request->timeMonFriEnd : null,
                                    'dayMonFriStatus' => isset($request->dayMonFriStatus) ? $request->dayMonFriStatus : null,
                                ]);
                            }
                        }
                    }
                }
            }
            if ($user) {
                return redirect()->to('vendors')->with('message_success', 'Vendor Store Successfully');
            }
            return redirect()->back()->with('message_danger', 'Error in Vendor Store')->withInput();
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }
    }

    public function show($id)
    {
        $id = decrypt($id);
        $data['address'] = Address::select('*')->where('user_id', $id)->first();
        $data['service'] = VendorService::with('serviceinfo')->select('*')->where('vendor_id', $id)->get();
        $data['treatment'] = VendorTreatment::with('treatmentinfo')->select('*')->where('vendor_id', $id)->get();
        $data['treatmentcount'] = VendorTreatment::where('vendor_id', $id)->count();
        $data['product'] = VendorProduct::with('productbrandinfo')->select('*')->where('vendor_id', $id)->get();
        $data['team'] = VendorTeam::select('*')->where('vendor_id', $id)->get();
        $data['demo'] = VendorDemo::select('*')->where('vendor_id', $id)->get();
        $data['booking'] = Booking::select('*')->where('vendor_id', $id)->get();
        $data['user'] = User::with('vendordetails')->select('*')->where('id', $id)->first();
        $data['vendor'] = VendorDetail::select('*')->where('vendor_id', $id)->first();
        $data['hours'] = BusinessHours::select('*')->where('vendor_id', $id)->first();
        $data['review'] = Feedback::select('*')->where('reviewto', $id)->avg('rating');
        $data['demologo'] = VendorDemo::select('*')->where('vendor_id', $id)->first();
        return view('vendors.details', $data);
    }

    public function edit($id)
    {
        // $id = decrypt($id);
        // $user = User::find($id);
        // return response()->json($user);
        $id = decrypt($id);
        $data['service'] = DB::table('services')->select('*')->get();
        // $data['servicename'] = DB::table('vendor_services')->with('serviceinfo')->where('vendor_id', '=', $id)->first();
        $data['servicename'] = VendorService::with('serviceinfo')->where('vendor_id', '=', $id)->first();
        $data['vendor'] = User::where('id', '=', $id)->first();
        $data['vendorservice'] = DB::table('vendor_details')->where('vendor_id', '=', $id)->first();
        $data['address'] = DB::table('addresses')->where('user_id', '=', $id)->first();
        $data['business'] = DB::table('business_hours')->where('vendor_id', '=', $id)->first();
        $data['country'] = Country::select('*')->get();
        $data['language'] = Language::select('*')->get();
        return view('vendors.edit', $data);
    }


    public function update(Request $request, $id)
    {
        $id = decrypt($id);
        try {
            $language = implode(', ', $request->language);
            $user = User::where('id', $id)->first();
            $user->firstname = isset($request->firstname) ? $request->firstname : '';
            $user->lastname = isset($request->lastname) ? $request->lastname : '';
            $user->email = isset($request->email) ? $request->email : '';
            $user->phone = isset($request->phone) ? $request->phone : null;
            $user->language = isset($language) ? $language : '';
            $user->country = isset($request->country) ? $request->country : '';

            if ($request->password) {
                $user->password = Hash::make($request->password);
            } else {
                unset($request['password']);
            }
            if ($user->save()) {

                if ($request->file('image') != null) {
                    $request['logo'] = uploadImageToPath($request->image, 'logo');
                }
                $user = VendorDetail::where('vendor_id', $id)->first();
                if (!empty($request['logo'])) {
                    removeFileFromPath($user['logo']);
                }
                $user->firm_name = isset($request->firm_name) ? $request->firm_name : '';
                $user->website = isset($request->website) ? $request->website : '';
                $user->country = isset($request->country) ? $request->country : '';
                $user->service_type = isset($request->service_type) ? $request->service_type  : '';
                // $user->latitude = isset($request->latitude) ? $request->latitude : '';
                // $user->longitude = isset($request->longitude) ? $request->longitude : '';
                $user->why_you = isset($request->why_you) ? $request->why_you : '';
                $user->logo = isset($request['logo']) ? $request['logo'] : $user->logo;
                if ($user->save()) {

                    $user = VendorService::where('vendor_id', $id)->first();
                    $user->service_id = isset($request->service_id) ? $request->service_id : '';
                    if ($user->save()) {

                        $user = Address::where('user_id', $id)->first();
                        $user->address_line1 = isset($request->address_line1) ? $request->address_line1 : '';
                        $user->address_line2 = isset($request->address_line2) ? $request->address_line2 : '';
                        $user->location_address = isset($request->location_address) ? $request->location_address : '';
                        $user->latitude = isset($request->latitude) ? $request->latitude : '';
                        $user->longitude = isset($request->longitude) ? $request->longitude : '';
                        $user->state = isset($request->state) ? $request->state : '';
                        $user->city = isset($request->city) ? $request->city : '';
                        $user->postcode = isset($request->postcode) ? $request->postcode : '';
                        if ($user->save()) {

                            if ($request->file('image1') != null) {
                                $request['demo_image'] = productUploadImageToPath($request->image1, 'demo_image');
                            }
                            $user = VendorDemo::where('vendor_id', $id)->first();
                            if (!empty($request['demo_image'])) {
                                removeFileFromPath($user['demo_image']);
                            }
                            $user->demo_image = isset($request['demo_image']) ? $request['demo_image'] : $user->demo_image;
                            if ($user->save()) {

                                $user = BusinessHours::where('vendor_id', $id)->first();
                                if ($request['dayMondayStatus'] == null) {
                                    $request['dayMondayStatus'] = 0;
                                }else{
                                    $request['dayMondayStatus'] = 1;
                                }
                                if ($request['dayTuesdayStatus'] == null) {
                                    $request['dayTuesdayStatus'] = 0;
                                }else{
                                    $request['dayTuesdayStatus'] = 1;
                                }
                                if ($request['dayWednesdayStatus'] == null) {
                                    $request['dayWednesdayStatus'] = 0;
                                }else{
                                    $request['dayWednesdayStatus'] = 1;
                                }
                                if ($request['dayThursdayStatus'] == null) {
                                    $request['dayThursdayStatus'] = 0;
                                }else{
                                    $request['dayThursdayStatus'] = 1;
                                }
                                if ($request['dayFridayStatus'] == null) {
                                    $request['dayFridayStatus'] = 0;
                                }else{
                                    $request['dayFridayStatus'] = 1;
                                }
                                if ($request['daySaturdayStatus'] == null) {
                                    $request['daySaturdayStatus'] = 0;
                                }else{
                                    $request['daySaturdayStatus'] = 1;
                                }
                                if ($request['daySundayStatus'] == null) {
                                    $request['daySundayStatus'] = 0;
                                }else{
                                    $request['daySundayStatus'] = 1;
                                }
                                if ($request['dayMonFriStatus'] == null) {
                                    $request['dayMonFriStatus'] = 0;
                                }else{
                                    $request['dayMonFriStatus'] = 1;
                                }
                                $user->timeMonStart = isset($request->timeMonStart) ? $request->timeMonStart : null;
                                $user->timeMonEnd = isset($request->timeMonEnd) ? $request->timeMonEnd : null;
                                $user->dayMondayStatus = isset($request->dayMondayStatus) ? $request->dayMondayStatus : null;
                                $user->timeTueStart = isset($request->timeTueStart) ? $request->timeMonStart : null;
                                $user->timeTueEnd = isset($request->timeTueEnd) ? $request->timeTueEnd : null;
                                $user->dayTuesdayStatus =  isset($request->dayTuesdayStatus) ? $request->dayTuesdayStatus : null;
                                $user->timeWedStart = isset($request->timeWedStart) ? $request->timeWedStart : null;
                                $user->timeWedEnd = isset($request->timeWedEnd) ? $request->timeWedEnd : null;
                                $user->dayWednesdayStatus = isset($request->dayWednesdayStatus) ? $request->dayWednesdayStatus : null;
                                $user->timeThuStart = isset($request->timeThuStart) ? $request->timeThuStart : null;
                                $user->timeThuEnd = isset($request->timeThuEnd) ? $request->timeThuEnd : null;
                                $user->dayThursdayStatus = isset($request->dayThursdayStatus) ? $request->dayThursdayStatus : null;
                                $user->timeFriStart = isset($request->timeFriStart) ? $request->timeFriStart : null;
                                $user->timeFriEnd = isset($request->timeFriEnd) ? $request->timeFriEnd : null;
                                $user->dayFridayStatus = isset($request->dayFridayStatus) ? $request->dayFridayStatus : null;
                                $user->timeSatStart = isset($request->timeSatStart) ? $request->timeSatStart : null;
                                $user->timeSatEnd = isset($request->timeSatEnd) ? $request->timeSatEnd : null;
                                $user->daySaturdayStatus = isset($request->daySaturdayStatus) ? $request->daySaturdayStatus : null;
                                $user->timeSunStart = isset($request->timeSunStart) ? $request->timeSunStart : null;
                                $user->timeSunEnd = isset($request->timeSunEnd) ? $request->timeSunEnd : null;
                                $user->daySundayStatus = isset($request->daySundayStatus) ? $request->daySundayStatus : null;
                                $user->timeMonFriStart = isset($request->timeMonFriStart) ? $request->timeMonFriStart : null;
                                $user->timeMonFriEnd = isset($request->timeMonFriEnd) ? $request->timeMonFriEnd : null;
                                $user->dayMonFriStatus = isset($request->dayMonFriStatus) ? $request->dayMonFriStatus : null;
                                $user->save();
                            }
                        }
                    }
                }
            }
            if ($user) {
                return redirect()->to('vendors')->with('message_success', 'Vendor Store Successfully');
            }
            return redirect()->back()->with('message_danger', 'Error in Vendor Store')->withInput();
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $id = decrypt($id);
            VendorDetail::where('vendor_id', '=', $id)->delete();
            VendorService::where('vendor_id', '=', $id)->delete();
            Address::where('user_id', '=', $id)->delete();
            VendorDemo::where('vendor_id', '=', $id)->delete();
            BusinessHours::where('vendor_id', '=', $id)->delete();
            VendorTreatment::where('vendor_id', '=', $id)->delete();
            Booking::where('user_id', '=', $id)->delete();
            VendorTeam::where('vendor_id', '=', $id)->delete();
            Notification::where('user_id', '=', $id)->delete();
            Membership::where('user_id', '=', $id)->delete();
            Offer::where('vendor_id', '=', $id)->delete();
            Payment::where('user_id', '=', $id)->where('Vendor_id', '=', $id)->delete();
            VendorProduct::where('vendor_id', '=', $id)->delete();
            ReferralEarn::where('referralby', '=', $id)->delete();
            ReferralEarn::where('referralto', '=', $id)->delete();
            $user = User::find($id);
            if ($user->delete()) {
                return response()->json(['status' => 'success', 'message' => 'Vendor deleted successfully!']);
            }
            // $user = User::find($id);
            // if ($user->delete()) {
            //     return response()->json(['status' => 'success', 'message' => 'Product deleted successfully!']);
            // }
            return response()->json(['status' => 'error', 'message' => 'Error in Product Delete!']);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }
    }

    public function vendorBooking(Request $request)
    {
        if (request()->ajax()) {
            return datatables()->of(Booking::with('userinfo', 'vendorinfo', 'serviceinfo', 'treatmentinfo', 'statusinfo')->where('vendor_id', '=', $request['vendor_id'])->select('*'))
                ->addIndexColumn()
                ->editColumn('username', function ($query) {
                    return '<img src="' . asset(isset($query['userinfo']['profile']) ? $query['userinfo']['profile'] : 'assets/image/dummy.png') . '" alt="" class="img-fluid wid-40 m-r-15 rounded">' . $query['userinfo']['firstname'] . ' ' . $query['userinfo']['lastname'];
                })
                ->editColumn('saloonname', function ($query) {
                    return '<img src="' . asset(isset($query['vendorinfo']['logo']) ? $query['vendorinfo']['logo'] : 'assets/image/dummy.png') . '" alt="" class="img-fluid wid-40 m-r-15 rounded">' . $query['vendorinfo']['firm_name'];
                })
                ->addColumn('action', function ($query) {
                    return '<div class="d-flex align-items-center btn-page">
                            <button type="button" class="btn  btn-danger deleteBooking" value="' . encrypt($query->id) . '"><i class="fas fa-trash-alt"></i></button>
                            </div>';
                })
                ->rawColumns(['action', 'username', 'saloonname'])
                ->make(true);
        }
    }

    public function vendorNotification(Request $request)
    {
        if (request()->ajax()) {
            return datatables()->of(Notification::with('userinfo')->where('user_id', '=', $request['user_id'])->select('*'))
                // return datatables()->of(User::with('vendordetails')->select('*')->where('id', $id->user_id))
                ->addIndexColumn()
                ->editColumn('username', function ($query) {
                    return '<img src="' . asset(isset($query['userinfo']['profile']) ? $query['userinfo']['profile'] : 'assets/image/dummy.png') . '" alt="" class="img-fluid wid-40 m-r-15 rounded">' . $query['userinfo']['firstname'] . ' ' . $query['userinfo']['lastname'];
                })
                ->addColumn('action', function ($query) {
                    return '<div class="d-flex align-items-center">
                    <div class="dropdown-primary dropdown open">
                        <button class="btn btn-light arrow-none dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="feather icon-more-vertical"></i>
                        </button>
                        <div class="dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                            <a href="javascript:void(0)" class="dropdown-item deleteNotification" value="' . encrypt($query->id) . '">Delete</a>
                        </div>
                    </div>
                    </div>';
                })
                ->rawColumns(['action', 'username'])
                ->make(true);
        }
    }

    public function vendorMembership(Request $request)
    {
        if (request()->ajax()) {
            return datatables()->of(Membership::with('subscriptioninfo')->where('user_id', '=', $request['user_id'])->select('*'))
                ->addIndexColumn()
                ->addColumn('plan_id', function ($query) {
                    return isset($query['subscriptioninfo']['plan_name']) ? $query['subscriptioninfo']['plan_name'] : 'Free Membership';
                })
                ->addColumn('action', function ($query) {
                    return '<div class="d-flex align-items-center">
                        <div class="dropdown-primary dropdown open">
                            <button class="btn btn-light arrow-none dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="feather icon-more-vertical"></i>
                            </button>
                            <div class="dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                <a href="javascript:void(0)" class="dropdown-item deleteMembershipRow" value="' . encrypt($query->id) . '">Delete</a>
                            </div>
                        </div>
                        </div>';
                })
                ->rawColumns(['action', 'plan_id'])
                ->make(true);
        }
    }

    public function vendorReview(Request $request)
    {
        if (request()->ajax()) {
            return datatables()->of(Feedback::with('userinfo', 'vendorinfo', 'bookinginfo')->where('reviewto', '=', $request['user_id'])->select('*'))
                ->addIndexColumn()
                ->editColumn('username', function ($query) {
                    return '<img src="' . asset(isset($query['userinfo']['profile']) ? $query['userinfo']['profile'] : 'assets/image/dummy.png') . '" alt="" class="img-fluid wid-40 m-r-15 rounded">' . $query['userinfo']['firstname'] . ' ' . $query['userinfo']['lastname'];
                })
                ->editColumn('ratings', function ($query) {
                    return  isset($query['rating']) . '.' . 0 ? $query['rating'] . '.' . 0 : 0;
                })
                ->addColumn('action', function ($query) {
                    return '<div class="d-flex align-items-center">
                        <div class="dropdown-primary dropdown open">
                            <button class="btn btn-light arrow-none dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="feather icon-more-vertical"></i>
                            </button>
                            <div class="dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                <a href="javascript:void(0)" class="dropdown-item deleteMembershipRow" value="' . encrypt($query->id) . '">Delete</a>
                            </div>
                        </div>
                        </div>';
                })
                ->rawColumns(['action', 'username'])
                ->make(true);
        }
    }

    public function teamMember(Request $request)
    {
        if (request()->ajax()) {
            return datatables()->of(VendorTeam::where('vendor_id', '=', $request['vendor_id'])->select('*'))
                ->addIndexColumn()
                ->editColumn('name', function ($query) {
                    return '<img src="' . url('/') . '/' . asset(isset($query['profile_pic']) ? $query['profile_pic'] : 'assets/image/dummy.png') . '" alt="" class="img-fluid wid-40 m-r-15 rounded">' . $query['employee_name'];
                })
                ->addColumn('action', function ($query) {
                    return '<div class="d-flex align-items-center">
                        <div class="dropdown-primary dropdown open">
                            <button class="btn btn-light arrow-none dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="feather icon-more-vertical"></i>
                            </button>
                            <div class="dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                <a href="javascript:void(0)" class="dropdown-item deleteTeam" value="' . encrypt($query->id) . '">Delete</a>
                            </div>
                        </div>
                        </div>';
                })
                ->rawColumns(['action', 'name'])
                ->make(true);
        }
    }

    public function deleteTeam($id)
    {
        try {
            $id = decrypt($id);
            Booking::where('employee_id', '=', $id)->update(['employee_id' => null]);
            if (VendorTeam::where('id', '=', $id)->delete()) {
                return response()->json(['status' => 'success', 'message' => 'Team member deleted successfully!']);
            }
            return response()->json(['status' => 'error', 'message' => 'Error in Team member deleted!']);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }
    }

    public function deleteGallery($id)
    {
        try {
            $id = decrypt($id);
            // Booking::where('employee_id', '=', $id)->update(['employee_id' => null]);
            if (VendorDemo::where('id', '=', $id)->delete()) {
                return response()->json(['status' => 'success', 'message' => 'Demo deleted successfully!']);
            }
            return response()->json(['status' => 'error', 'message' => 'Error in demo deleted!']);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }
    }

    public function deleteProduct($id)
    {
        try {
            $id = decrypt($id);
            // Booking::where('employee_id', '=', $id)->update(['employee_id' => null]);
            if (VendorProduct::where('id', '=', $id)->delete()) {
                return response()->json(['status' => 'success', 'message' => 'product deleted successfully!']);
            }
            return response()->json(['status' => 'error', 'message' => 'Error in product deleted!']);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }
    }

    public function vendorOffer(Request $request)
    {
        if (request()->ajax()) {
            return datatables()->of(Offer::with('vendorinfo')->where('vendor_id', '=', $request['vendor_id'])->select('*'))
                ->addIndexColumn()
                ->editColumn('vendor_id', function ($query) {
                    return '<img src="' . asset(isset($query['vendorinfo']['profile']) ? $query['vendorinfo']['profile'] : 'assets/image/dummy.png') . '" alt="" class="img-fluid wid-40 m-r-15 rounded">' . $query['vendorinfo']['firstname'];
                })
                ->editColumn('offer', function ($query) {
                    return '<img src="' . asset($query['offer_image']) . '" alt="" class="img-fluid wid-40 m-r-15 rounded">' . $query['offer_title'];
                })
                ->addColumn('action', function ($query) {
                    return '<div class="d-flex align-items-center">
                        <div class="dropdown-primary dropdown open">
                            <button class="btn btn-light arrow-none dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="feather icon-more-vertical"></i>
                            </button>
                            <div class="dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                <a href="javascript:void(0)" class="dropdown-item editCategoryRow" value="' . encrypt($query->id) . '">Edit</a>
                                <a href="javascript:void(0)" class="dropdown-item deleteCategoryRow" value="' . encrypt($query->id) . '">Delete</a>
                            </div>
                        </div>
                        </div>';
                })
                ->rawColumns(['action', 'vendor_id','offer'])
                ->make(true);
        }
    }
}
