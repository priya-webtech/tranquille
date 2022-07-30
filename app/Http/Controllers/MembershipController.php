<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;
use App\Models\Membership;
use App\Models\Subscription;
use App\Models\User;
use Datatables;

class MembershipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // //abort_if(Gate::denies('membership_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if (request()->ajax()) {
            return datatables()->of(Membership::with('userinfo', 'subscriptioninfo')->select('*'))
                ->addIndexColumn()
                ->editColumn('profile', function ($query) {
                    return '<img src="' . asset(isset($query['userinfo']['profile']) ? $query['userinfo']['profile'] : 'assets/image/dummy.png') . '" alt="" class="img-fluid wid-40 m-r-15 rounded">' . $query['userinfo']['firstname'].' '. $query['userinfo']['lastname'];
                })
                ->editColumn('plan_id', function ($query) {
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
                ->rawColumns(['action','profile'])
                ->make(true);
        }
        $data['plan'] = Subscription::select('id','plan_name')->get();
        $data['vendor'] = User::select('id','firstname')->where('active','=','N')->get();

        return view('membership.index', $data);
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
            // $permission = !empty($request['id']) ? 'membership_edit' : 'membership_create';
            // //abort_if(Gate::denies($permission), Response::HTTP_FORBIDDEN, '403 Forbidden');
            if (!empty($request['id'])) {
                $membership = Membership::where('id', $request['id'])->update($request->except(['_token', '_method']));
            } else {
                $membership = Membership::create($request->except(['_token']));
                $data = $membership;
                broadcast(new \App\Events\SendNotification($data))->toOthers();
            }
            if ($membership) {
                return redirect()->to('membership')->with('message_success', 'Data Store Successfully');
            }
            return redirect()->back()->with('message_danger', 'Error in Data Store')->withInput();
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }

        // try {
        //     if (!empty($request['id'])) {
        //         $category = ProductBrand::where('id', $request['id'])->first();
        //         if (!empty($request['brand_image'])) {
        //             productRemoveImageFromPath($category['brand_image']);
        //         }
        //         $category->update($request->except(['_token', 'id', 'image']));
        //     } else {
        //         $category = ProductBrand::create($request->except(['_token', 'image']));
        //     }
        //     if ($category) {
        //         return redirect()->to('product')->with('message_success', 'Product Store Successfully');
        //     }
        //     return redirect()->back()->with('message_danger', 'Error in Product Store')->withInput();
        // } catch (\Exception $e) {
        //     return redirect()->back()->withErrors($e->getMessage())->withInput();
        // }
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
        $user = Membership::find($id);
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
        // //abort_if(Gate::denies('membership_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $id = decrypt($id);
        $user = Membership::find($id);
        if ($user->delete()) {
            return response()->json(['status' => 'success', 'message' => 'Membership deleted successfully!']);
        }
        return response()->json(['status' => 'error', 'message' => 'Error in Membership Delete!']);
    }
}
