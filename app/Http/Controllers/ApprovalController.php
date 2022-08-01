<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\BusinessHours;
use App\Models\VendorService;
use App\Models\Address;
use App\Models\VendorDemo;
use App\Models\VendorDetail;

class ApprovalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        if (request()->ajax()) {
            return datatables()->of(User::with('vendordetails')->select('*')->where('type', '=', 'Provider')->where('active', '=', 'N'))
                ->addIndexColumn()
                ->editColumn('logo', function ($query) {
                    if(!empty($query['vendordetails'])) {
                        return '<img src="' . asset(isset($query['vendordetails']['logo']) ? $query['vendordetails']['logo'] : 'assets/image/dummy.png') . '" alt="" class="img-fluid wid-40 m-r-15 rounded">' . $query['vendordetails']['firm_name'];
                    }
                })
                ->editColumn('ownername', function ($query) {
                    return  $query['firstname'] . ' ' . $query['lastname'];
                })
                ->addColumn('action', function ($query) {
                    $active = ($query->active == 'N') ? 'checked="" value="' . $query->active . '"' : 'value="' . $query->active . '"';
                    return '<div class="d-flex align-items-center">
                        <div class="form-check">
                            <input class="form-check-input input-light-success box-size m-r-15 vendorInactive" type="checkbox" ' . $active . ' id="' . $query->id . '">
                        </div>
                        <div class="dropdown-primary dropdown open">
                            <button class="btn btn-light arrow-none dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <div class="dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                <a href="javascript:void(0)" class="dropdown-item deactiveUser" value="' . encrypt($query->id) . '">View</a>
                                <a href="javascript:void(0)" class="dropdown-item deleteUserRow" value="' . encrypt($query->id) . '">Delete</a>
                            </div>
                        </div>
                        </div>';
                })
                ->rawColumns(['action', 'logo', 'owenername'])
                ->make(true);
        }
        // return view('dashboard');
    }

    // public function active(Request $request)
    // {
    //     try {
    //         if (User::where('id', $request['id'])->update(['active' => ($request['active'] == 'N') ? 'Y' : 'N'])) {
    //             $message = ($request['active'] == 'N') ? 'Inactive' : 'Active';
    //             return response()->json(['status' => 'success', 'message' => 'Vendor ' . $message . ' Successfully!']);
    //         }
    //         return response()->json(['status' => 'error', 'message' => 'Error in vendor activation']);
    //     } catch (\Exception $e) {
    //         return redirect()->back()->withErrors($e->getMessage())->withInput();
    //     }
    // }

    // public function activation(Request $request)
    // {
    //     if (User::where('id', $request['id'])->update(['active' => ($request['active'] == 'N') ? 'Y' : 'N'])) {
    //         $message = ($request['active'] == 'N') ? 'Inactive' : 'Active';
    //         return response()->json(['status' => 'success', 'message' => 'Vendor ' . $message . ' Successfully!']);
    //     }
    //     return response()->json(['status' => 'error', 'message' => 'Error in vendor activation']);
    // }

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
        //
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
        //
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
            VendorDetail::where('vendor_id', '=', $id)->delete();
            VendorService::where('vendor_id', '=', $id)->delete();
            Address::where('user_id', '=', $id)->delete();
            VendorDemo::where('vendor_id', '=', $id)->delete();
            BusinessHours::where('vendor_id', '=', $id)->delete();
            $user = User::find($id);
            if ($user->delete()) {
                return response()->json(['status' => 'success', 'message' => 'Vendor deleted successfully!']);
            }
            return response()->json(['status' => 'error', 'message' => 'Error in Product Delete!']);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }
    }
}
