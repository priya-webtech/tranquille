<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Payment;

class BookingDashboardController extends Controller
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
                ->editColumn('username', function ($query) {
                    if(!empty($query['userinfo'])) {
                        return '<img src="' . asset(isset($query['userinfo']['profile']) ? $query['userinfo']['profile'] : 'assets/image/dummy.png') . '" alt="" class="img-fluid wid-40 m-r-15 rounded">' . $query['userinfo']['firstname'] . ' ' . $query['userinfo']['lastname'];
                    }
                })
                ->editColumn('logo', function ($query) {
                    if(!empty($query['vendorinfo'])) {
                        return '<img src="' . asset(isset($query['vendorinfo']['logo']) ? $query['vendorinfo']['logo'] : 'assets/image/dummy.png') . '" alt="" class="img-fluid wid-40 m-r-15 rounded">' . $query['vendorinfo']['firm_name'];
                    }
                        
                })
                ->editColumn('status', function ($query) {
                    if(!empty($query['statusinfo']))
                    {
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
                    return  '<div  class="' . $classname . '">' . $query['statusinfo']['status'] . '
                    </div>';
                    }
                })
                ->addColumn('action', function ($query) {
                    $active = ($query->active == 'N') ? 'checked="" value="' . $query->active . '"' : 'value="' . $query->active . '"';
                    return '<div class="d-flex align-items-center">
                        <div class="dropdown-primary dropdown open">
                            <button class="btn btn-light arrow-none dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <div class="dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                <a href="javascript:void(0)" class="dropdown-item deleteBooking" value="' . encrypt($query->id) . '">Delete</a>
                            </div>
                        </div>
                        </div>';
                })
                // ->addColumn('profile', function ($query) {
                //     return '<img src="' . asset($query['userinfo']['profile']) . '" class="rounded-lg mr-1" width="50" alt="">';
                // })
                // ->addColumn('logo', function ($query) {
                //     return '<img src="' . asset($query['vendorinfo']['logo']) . '" class="rounded-lg mr-1" width="50" alt="">';
                // })
                ->rawColumns(['action', 'username', 'logo', 'status'])
                ->make(true);
        }
        // return view('dashboard');
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
}
