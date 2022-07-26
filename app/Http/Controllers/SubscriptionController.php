<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;
use App\Models\Subscription;
use Datatables;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        // if (request()->ajax()) {
        //     return datatables()->of(Subscription::select('*'))
        //         ->addIndexColumn()
        //         ->addColumn('action', function ($query) {
        //             return '<div class="d-flex align-items-center">
        //                 <div class="dropdown-primary dropdown open">
        //                     <button class="btn btn-light arrow-none dropdown-toggle" type="button" data-bs-toggle="dropdown">
        //                         <i class="feather icon-more-vertical"></i>
        //                     </button>
        //                     <div class="dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
        //                         <a href="javascript:void(0)" class="dropdown-item editCategoryRow" value="' . encrypt($query->id) . '">Edit</a>
        //                         <a href="javascript:void(0)" class="dropdown-item deleteSubscriptionRow" value="' . encrypt($query->id) . '">Delete</a>
        //                     </div>
        //                 </div>
        //                 </div>';
        //         })
        //         ->rawColumns(['action'])
        //         ->make(true);
        // }
        $data['subscription'] = Subscription::select('*')->get();
        return view('subscription.index',$data);
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
            if ($request['portfolio'] == null) {
                $request['portfolio'] = 0;
            }
            if ($request['calendar'] == null) {
                $request['calendar'] = 0;
            }
            if ($request['available'] == null) {
                $request['available'] = 0;
            }
            if ($request['long_bio'] == null) {
                $request['long_bio'] = 0;
            }
            if ($request['profile_bg'] == null) {
                $request['profile_bg'] = 0;
            }
            if ($request['performance'] == null) {
                $request['performance'] = 0;
            }
            if ($request['account_data'] == null) {
                $request['account_data'] = 0;
            }
            if ($request['liability'] == null) {
                $request['liability'] = 0;
            }
            if ($request['dbs_option'] == null) {
                $request['dbs_option'] = 0;
            }
            if (!empty($request['id'])) {
                $subscription = Subscription::where('id', $request['id'])->first();
                $subscription->update($request->except(['_token', 'id']));
            } else {
                $subscription = Subscription::create($request->except(['_token']));
            }
            if ($subscription) {
                return redirect()->to('subscription')->with('message_success', 'Data Store Successfully');
            }
            return redirect()->back()->with('message_danger', 'Error in Data Store')->withInput();
        } catch (\Exception $e) {
            dd($e->getMessage());
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
        // $id = decrypt($id);
        // $data['subscription'] = Subscription::select('*')->where('id','=',$id)->first();
        // return view('subscription.edit',$data);

        $id = decrypt($id);
        $user = Subscription::find($id);
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
        // abort_if(Gate::denies('subscription_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $id = decrypt($id);
        $user = Subscription::find($id);
        if ($user->delete()) {
            return response()->json(['status' => 'success', 'message' => 'Subscription deleted successfully!']);
        }
        return response()->json(['status' => 'error', 'message' => 'Error in Subscription Delete!']);
    }
}
