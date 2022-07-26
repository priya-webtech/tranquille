<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Models\Treatment;
use App\Models\User;
use App\Models\Booking;
use App\Models\VendorTreatment;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(Feedback::with('userinfo','vendor', 'vendorinfo', 'bookinginfo')->select('*')->get());
        if (request()->ajax()) {
            return datatables()->of(Feedback::with('userinfo','vendor', 'vendorinfo', 'bookinginfo')->select('*'))
                ->addIndexColumn()
                ->editColumn('username', function ($query) {
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
                                <a href="javascript:void(0)" class="dropdown-item editReviewRow" value="' . encrypt($query->id) . '">Edit</a>
                                <a href="javascript:void(0)" class="dropdown-item deleteReview" value="' . encrypt($query->id) . '">Delete</a>
                            </div>
                        </div>
                        </div>';
                })
                ->rawColumns(['action', 'username', 'ownername'])
                ->make(true);
        }
        $data['user'] = User::select('id', 'firstname', 'lastname')->where('type', '=', 'User')->get();
        $data['vendor'] = User::select('id', 'firstname', 'lastname')->where('type', '=', 'Provider')->get();
        $data['treatment'] = Treatment::select('id', 'treatment_name')->get();
        // $data['treatment'] = VendorTreatment::with('treatmentinfo')->where('treatment_id', $query->id)->get();
        $data['booking'] = Booking::with('userinfo' , 'treatmentinfo')->where('status_id', '=', 11)->get();
        return view('feedback.index',$data);
    }
    // , 'vendorinfo', 'serviceinfo', 'treatmentinfo', 'statusinfo'
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
                $booking = Feedback::where('id', $request['id'])->first();
                // $booking->reviewby  = isset($request->reviewby) ? $request->reviewby  : null;
                // $booking->reviewto  = isset($request->reviewto) ? $request->reviewto  : null;
                // $booking->booking_id = isset($request->booking_id) ? $request->booking_id : null;
                // $booking->treatment_id = isset($request->treatment_id) ? $request->treatment_id : null;
                $booking->rating = isset($request->rating) ? $request->rating : null;
                $booking->review = isset($request->review) ? $request->review : '';
                $booking->save();
            } else {
                $booking = Feedback::create($request->except(['_token']));
            }
            if ($booking) {
                return redirect()->to('feedback')->with('message_success', 'Data Store Successfully');
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
        $user = Feedback::find($id);
        $user['username'] = Feedback::with('userinfo')->where('booking_id', $user->booking_id)->select('*')->get();

        // $user['treatments'] = Feedback::where('service_id', $user->service_id)->select('id', 'treatment_name')->get();
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
            $user = Feedback::find($id);
            if ($user->delete()) {
                return response()->json(['status' => 'success', 'message' => 'Review deleted successfully!']);
            }
            return response()->json(['status' => 'error', 'message' => 'Error in Review Delete!']);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }
    }
}
