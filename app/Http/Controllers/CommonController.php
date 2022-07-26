<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Booking;
use App\Models\Membership;
use App\Models\Service;
use App\Models\Treatment;
use App\Models\Feedback;

use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class CommonController extends Controller
{

    public function index()
    {
        $users = User::select('type', 'active')->get();
        $data['users'] = $users->where('type', '=', 'User')->count();
        $data['vendors'] = $users->where('type', '=', 'Provider')->count();
        $data['activevendors'] = $users->where('type', '=', 'Provider')->where('active', '=', 'N')->count();
        $data['todaybooking'] = Booking::whereDate('created_at', '=', Carbon::today())->count();
        // $data['todaybooking'] = Booking::whereDate('created_at', DB::raw('CURDATE()'))->count();
        $data['totalbooking'] = Booking::count();
        $data['membershipamount'] = Membership::where('status', '=', 1)->sum('amount');
        // $data['topvendor'] = User::where('type', '=', 'Provider')->get();
        // // $data['users'] = User::groupBy('type')->select('type', DB::raw('count(*) as total'))->get();
        // // $data['booking'] = Booking::groupBy('status_id')->select('status_id', DB::raw('count(*) as total'))->where('status_id','=', 1)->get();
        // $data['bookingamount'] = Booking::sum('full_amount');
        // $data['booking'] = Booking::count();
        // $data['topbooking'] = Booking::with('vendorinfo')->orderBy('updated_at')->get();
        // // $data['membership'] = Membership::where('status_id','=',1)->sum('full_amount');
        // $data['userdata'] = User::with('vendordetails')->select('*')->where('type', '=', 'Provider')->where('active', '=', 'N')->take(6)->get(); //table view
        $data['bookingdata'] = Booking::with('userinfo', 'vendorinfo', 'serviceinfo', 'treatmentinfo', 'statusinfo')->select('*')->take(6)->get(); //table view

        return view('dashboard', $data);
    }

    public function showChangePasswordGet()
    {
        return view('auth.changepassword');
    }

    public function changePasswordPost(Request $request)
    {
        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error", "Your current password does not matches with the password.");
        }

        if (strcmp($request->get('current-password'), $request->get('new-password')) == 0) {
            // Current password and new password same
            return redirect()->back()->with("error", "New Password cannot be same as your current password.");
        }

        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:8|confirmed',
        ]);

        //Change Password
        $user = Auth::user();
        $user->password = Hash::make($request->get('new-password'));
        if ($user->save()) {
            return redirect()->back()->with("success", "Password successfully changed!");
        }
        return redirect()->back()->with("success", "Password Not changed!");
    }

    public function serviceDropdown(Request $request)
    {
        $service = Service::select('*')->get();
        // return view('product.index', ["categoris" => $categoris]);
    }
    public function treatmentDropdown(Request $request)
    {
        $treatment = Treatment::select('id', 'treatment_name')->where('service_id', $request->service_id)->get();
        return response()->json($treatment);
    }

    public function userDropdown(Request $request)
    {
        $username = Feedback::with('userinfo')->where('booking_id', $request->booking_id)->get();
        return response()->json($username);
    }

    public function vendorDropdown(Request $request)
    {
        $vendorname = Feedback::with('vendor')->where('reviewby', $request->reviewby)->get();
        return response()->json($vendorname);
    }
    

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
