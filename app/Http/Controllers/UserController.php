<?php

namespace App\Http\Controllers;

use App\Models\Admin\Corporate;
use App\Models\Admin\Student;
use App\Models\Contactus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Booking;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Hash;
use App\Models\VendorService;
use App\Models\Address;
use App\Models\VendorDemo;
use App\Models\VendorDetail;
use App\Models\BusinessHours;
use App\Models\Language;
use App\Models\Country;
use App\Models\Notification;
use App\Models\VendorTeam;
use App\Models\VendorTreatment;
use App\Models\Membership;
use App\Models\Offer;
use App\Models\Payment;
use App\Models\VendorProduct;
use App\Models\Feedback;
use App\Models\ReferralEarn;


class UserController extends Controller
{

    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(User::select('*')->where('type', '=', 'User'))
                ->addIndexColumn()
                ->editColumn('firstname', function ($query) {
                    return '<a href="' . url("users/" . encrypt($query->id)) . '">
                            <img src="' . asset(isset($query['profile']) ? $query['profile'] : "assets/image/dummy.png") . '" alt="" class="img-fluid wid-40 m-r-15 rounded">' . $query['firstname'] . ' ' . $query['lastname'] . '
                            </a>';
                })
                ->addColumn('action', function ($query) {
                    return '<div class="d-flex align-items-center">
                        <div class="dropdown-primary dropdown open">
                            <button class="btn btn-light arrow-none dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="feather icon-more-vertical"></i>
                            </button>
                            <div class="dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                <a href="javascript:void(0)" class="dropdown-item editUserRow" value="' . encrypt($query->id) . '">Edit</a>
                                <a href="javascript:void(0)" class="dropdown-item deleteUserRow" value="' . encrypt($query->id) . '">Delete</a>
                            </div>
                        </div>
                        </div>';
                })
                ->rawColumns(['action', 'firstname'])
                ->make(true);
        }
        // <a href="javascript:void(0)" class="dropdown-item userDetail" value="' . encrypt($query->id) . '">View</a>
        $data['language'] = Language::select('id', 'name')->get();
        $data['country'] = Country::select('id', 'country_name')->get();
        return view('users.index', $data);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {
            $language = $request->language ;
            unset($request->language);
            $request['language'] = !empty($language) ? implode(', ', $language) : '';
            if (!empty($request['id'])) {
                $user = User::where('id', $request['id'])->first();
                $user->firstname = isset($request->firstname) ? $request->firstname : '';
                $user->lastname = isset($request->lastname) ? $request->lastname : '';
                $user->email = isset($request->email) ? $request->email : '';
                $user->phone = isset($request->phone) ? $request->phone : '';
                $user->country = isset($request->country) ? $request->country : '';
                $user->language = isset($request->language) ? $request->language : '';
                if ($request->password) {
                    $user->password = Hash::make($request->password);
                }
                $user->save();
            } else {
                $request['name'] = $request['firstname'] . ' ' . $request['lastname'];
                $request['type'] = 'User';
                $request['password'] = Hash::make($request['password']);
                $user = User::create($request->except(['_token']));
            }
            if ($user) {
                return redirect()->to('users')->with('message_success', 'Data Store Successfully');
            }
            return redirect()->back()->with('message_danger', 'Error in Data Store')->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }
    }

    public function show($id)
    {
        $id = decrypt($id);
        $user = User::with('addressdetails')->where('id', $id)->first();
        // $data['booking'] = Booking::where('user_id', $id)->paginate(5);
        return view('users.show', compact('user'));
    }

    public function edit($id)
    {
        $id = decrypt($id);
        $user = User::find($id);
        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        try {
            $id = decrypt($id);
            VendorDetail::where('vendor_id', '=', $id)->delete();
            VendorService::where('vendor_id', '=', $id)->delete();
            VendorTreatment::where('vendor_id', '=', $id)->delete();
            Address::where('user_id', '=', $id)->delete();
            VendorDemo::where('vendor_id', '=', $id)->delete();
            BusinessHours::where('vendor_id', '=', $id)->delete();
            Payment::where('user_id', '=', $id)->where('vendor_id', '=', $id)->delete();
            Notification::where('user_id', '=', $id)->delete();
            VendorTeam::where('vendor_id', '=', $id)->delete();
            Membership::where('user_id', '=', $id)->delete();
            Offer::where('vendor_id', '=', $id)->delete();
            VendorProduct::where('vendor_id', '=', $id)->delete();
            Booking::where('user_id', '=', $id)->delete();
            ReferralEarn::where('referralby', '=', $id)->delete();
            ReferralEarn::where('referralto', '=', $id)->delete();
            $user = User::find($id);
            if ($user->delete()) {
                return response()->json(['status' => 'success', 'message' => 'User deleted successfully!']);
            }
            return response()->json(['status' => 'error', 'message' => 'Error in Product Delete!']);
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }
    }

    public function approval(Request $request)
    {
        if (request()->ajax()) {
            return datatables()->of(User::with('vendordetails')->select('*')->where('type', '=', 'Provider')->where('active', '=', 'N'))
                ->addIndexColumn()
                ->editColumn('firstname', function ($query) {
                    return '<img src="' . asset(isset($query['profile']) ? $query['profile'] : 'assets/image/dummy.png') . '" alt="" class="img-fluid wid-40 m-r-15 rounded">' . $query['firstname'] . ' ' . $query['lastname'];
                })
                ->addColumn('shopname', function ($query) {
                    return '<img src="' . asset(isset($query['vendordetails']['logo']) ? $query['vendordetails']['logo'] : 'assets/image/dummy.png') . '" alt="" class="img-fluid wid-40 m-r-15 rounded">' . $query['vendordetails']['firm_name'];
                })

                ->addColumn('action', function ($query) {
                    $active = ($query->active == 'N') ? 'checked="" value="' . $query->active . '"' : 'value="' . $query->active . '"';
                    return '<div class="d-flex align-items-center">
                        <div class="form-check">
                            <input class="form-check-input input-light-success box-size m-r-15 vendoractive" type="checkbox" ' . $active . ' id="' . $query->id . '">
                        </div>
                        <div class="dropdown-primary dropdown open">
                            <button class="btn btn-light arrow-none dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="feather icon-more-vertical"></i>
                            </button>
                            <div class="dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                <a href="javascript:void(0)" class="dropdown-item deleteUserRow" value="' . encrypt($query->id) . '">Delete</a>
                            </div>
                        </div>
                        </div>';
                })
                ->rawColumns(['action', 'shopname', 'firstname'])
                ->make(true);
        }
        return view('users.approval');
    }

    public function bookinglist(Request $request)
    {
        //     // dd(Booking::latest()->where('user_id','=',$request->user_id)->get());
        //     // $data = Booking::latest()->get();
        if (request()->ajax()) {
            return datatables()->of(Booking::with('userinfo', 'vendorinfo', 'serviceinfo', 'treatmentinfo', 'statusinfo')->where('user_id', '=', $request->user_id)->select('*'))
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
                                <a href="javascript:void(0)" class="dropdown-item deleteBooking" value="' . encrypt($query->id) . '">Delete</a>
                            </div>
                        </div>
                        </div>';
                })
                ->rawColumns(['action', 'username'])
                ->make(true);
        }
    }

    public function ratinglist(Request $request)
    {
        if (request()->ajax()) {
            return datatables()->of(Feedback::with('userinfo', 'vendorinfo', 'bookinginfo')->where('reviewby', '=', $request->user_id)->select('*'))
                ->addIndexColumn()->editColumn('username', function ($query) {
                    return '<img src="' . asset(isset($query['userinfo']['profile']) ? $query['userinfo']['profile'] : 'assets/image/dummy.png') . '" alt="" class="img-fluid wid-40 m-r-15 rounded">' . $query['userinfo']['firstname'] . ' ' . $query['userinfo']['lastname'];
                })
                ->editColumn('ownername', function ($query) {
                    return '<img src="' . asset(isset($query['vendorinfo']['logo']) ? $query['vendorinfo']['logo'] : 'assets/image/dummy.png') . '" alt="" class="img-fluid wid-40 m-r-15 rounded">' . $query['vendorinfo']['firm_name'];
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
                                <a href="javascript:void(0)" class="dropdown-item deleteReview" value="' . encrypt($query->id) . '">Delete</a>
                            </div>
                        </div>
                        </div>';
                })
                ->rawColumns(['action', 'username', 'ownername'])
                ->make(true);
        }
    }

    public function userNotification(Request $request)
    {
        //     // dd(Booking::latest()->where('user_id','=',$request->user_id)->get());
        //     // $data = Booking::latest()->get();
        if (request()->ajax()) {
            return datatables()->of(Notification::with('userinfo')->where('user_id', '=', $request->user_id)->select('*'))
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
                                <a href="javascript:void(0)" class="dropdown-item deleteNotificationRow" value="' . encrypt($query->id) . '">Delete</a>
                            </div>
                        </div>
                        </div>';
                })
                ->rawColumns(['action','username'])
                ->make(true);
        }
    }

    public function userReffer(Request $request)
    {
        if (request()->ajax()) {
            return datatables()->of(ReferralEarn::with('byinfo', 'toinfo')->where('referralby', '=', $request->user_id)->select('*'))
                ->addIndexColumn()
                ->addColumn('byname', function ($query) {
                    return $query['byinfo']['firstname'];
                })
                ->addColumn('toname', function ($query) {
                    return $query['toinfo']['firstname'];
                })
                ->addColumn('action', function ($query) {
                    return '<div class="d-flex align-items-center">
                        <div class="dropdown-primary dropdown open">
                            <button class="btn btn-light arrow-none dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="feather icon-more-vertical"></i>
                            </button>
                            <div class="dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                <a href="javascript:void(0)" class="dropdown-item deleteRefferRow" value="' . encrypt($query->id) . '">Delete</a>
                            </div>
                        </div>
                        </div>';
                })
                ->rawColumns(['action','byname', 'toname'])
                ->make(true);
        }
    }

    public function userTransection(Request $request)
    {
        if (request()->ajax()) {
            return datatables()->of(Payment::with('userinfo', 'vendorinfo', 'bookinginfo', 'vendorname', 'statusinfo')->where('user_id', '=', $request->user_id)->select('*'))
                ->addIndexColumn()
                ->addColumn('username', function ($query) {
                    return $query['userinfo']['firstname'];
                })
                ->addColumn('vendor', function ($query) {
                    return $query['vendorname']['firstname'];
                })
                ->addColumn('status', function ($query) {
                    return $query['statusinfo']['status'];
                })
                ->addColumn('action', function ($query) {
                    return '<div class="d-flex align-items-center">
                        <div class="dropdown-primary dropdown open">
                            <button class="btn btn-light arrow-none dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="feather icon-more-vertical"></i>
                            </button>
                            <div class="dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                <a href="javascript:void(0)" class="dropdown-item deletePaymentRow" value="' . encrypt($query->id) . '">Delete</a>
                            </div>
                        </div>
                        </div>';
                })
                ->rawColumns(['action','username', 'vendor', 'status'])
                ->make(true);
        }
    }

    public function notifications()
    {
        if(Auth::user()->type == 'Admin'){

           // return $user->unreadNotifications()->orderBy('created_at', 'desc')->limit(5)->get()->toArray();
            $a = Contactus::select('id','name','created_at', DB::raw("'Contactus' AS `type`"));
            $b = Membership::select('id','user_id','created_at', DB::raw("'Membership' AS `type`"));
            $cont = VendorDetail::select('id','firm_name','created_at', DB::raw("'Vendor' AS `type`"))
                ->union($a)
                ->union($b)
                ->orderBy('created_at', 'desc')->limit(5)->get();
           foreach ($cont as $key=>$c){
               if($c->type == "Contactus"){
                  $msg= 'New Request for Support from '.$c->firm_name;
                  // $cont[$key]['name']= "<a href='{{route('contactus')}}'>'New Request for Support from '.$c->firm_name</a>";
                   $cont[$key]['name']= '<a href="'.route('contactus.index') .'">' .$msg . '</a>';
               }elseif ($c->type == "Membership"){
                   $user = VendorDetail::where('vendor_id',$c->firm_name)->first();
                   $name = $user->firm_name ?? "N/A";
                   $msg =  $name.' has purchased a new membership Plan';
                   $cont[$key]['name']= '<a href="'.route('membership.index') .'">' .$msg . '</a>';
               }elseif ($c->type == 'Vendor'){
                   $msg =  $c->firm_name.' has requested for approval for Salon Registration';
                   $cont[$key]['name']= '<a href="'.route('vendorApproval.index') .'">' .$msg . '</a>';
               }
           }
            return $cont->toArray();
        }
    }
    public function get_latest_notification()
    {
        if(Auth::user()->type == 'Admin'){
            $a = Contactus::select('id','name','created_at', DB::raw("'Contactus' AS `type`"));
            $b = Membership::select('id','user_id','created_at', DB::raw("'Membership' AS `type`"));
            $query = VendorDetail::select('id','firm_name','created_at', DB::raw("'Vendor' AS `type`"))
                ->union($a)
                ->union($b)
                ->orderBy('created_at', 'desc')->first();

            if($query->type == "Contactus"){
                $msg= 'New Request for Support from '.$query->firm_name;
                $query['name']= '<a href="'.route('contactus.index') .'">' .$msg . '</a>';
            }elseif ($query->type == "Membership"){
                $user = VendorDetail::where('vendor_id',$query->firm_name)->first();
                $name = $user->firm_name ?? "N/A";
                $msg= $name.' has purchased a new membership Plan';
                $query['name']= '<a href="'.route('membership.index') .'">' .$msg . '</a>';
            }elseif ($query->type == 'Vendor'){
                $msg= $query->firm_name.' has requested for approval for Salon Registration';
                $query['name']= '<a href="'.route('vendorApproval.index') .'">' .$msg . '</a>';
            }
            return $query->toArray();
            //return $user->unreadNotifications()->orderBy('created_at', 'desc')->first();
        }

    }

}
