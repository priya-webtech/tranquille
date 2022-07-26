<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;


class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(Payment::with('userinfo', 'vendorinfo', 'bookinginfo', 'vendorname', 'statusinfo')->select('*'))
                ->addIndexColumn()
                // ->editColumn('vendor_id', function ($query) {
                //     return '<img src="' . asset($query['offer_image']) . '" alt="" class="img-fluid wid-40 m-r-15 rounded">' . $query['offer_title'];
                // })
                // ->editColumn('vendor_image', function ($query) {
                //     return '<img src="' . asset(isset($query['vendorinfo']['profile']) ? $query['vendorinfo']['profile'] : 'assets/image/dummy.png') . '" alt="" class="img-fluid wid-40 m-r-15 rounded">' . $query['vendorinfo']['firstname'];
                // })
                ->editColumn('username', function ($query) {
                    return $query['userinfo']['firstname'];
                })
                ->editColumn('vendor', function ($query) {
                    return $query['vendorname']['firstname'];
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
                ->rawColumns(['action', 'username', 'vendor'])
                ->make(true);
        }
        return view('payment.index');
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
        try {
            // if ($request->file('image') != null) {
            //     $request['offer_image'] = UploadImageToPath($request->image, 'offer_image');
            // }

            if (!empty($request['id'])) {
                $category = Payment::where('id', $request['id'])->first();
                // if (!empty($request['offer_image'])) {
                //     RemoveFileFromPath($category['offer_image']);
                // }
                $category->update($request->except(['_token', 'id', 'image']));
            } else {
                $category = Payment::create($request->except(['_token', 'image']));
            }
            if ($category) {
                return redirect()->to('payment')->with('message_success', 'Payment Store Successfully');
            }
            return redirect()->back()->with('message_danger', 'Error in Payment Store')->withInput();
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
        $user = Payment::find($id);
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
        $id = decrypt($id);
        $user = Payment::find($id);
        if ($user->delete()) {
            return response()->json(['status' => 'success', 'message' => 'Payment deleted successfully!']);
        }
        return response()->json(['status' => 'error', 'message' => 'Error in Payment Delete!']);
    }
}
