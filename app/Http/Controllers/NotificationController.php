<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;
use App\Models\Notification;
use App\Models\User;
use Datatables;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // abort_if(Gate::denies('notification_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // $a = Notification::select('*')->get();
        // foreach ($a as $id){
        //     // dd($id['user_id']);
        // }
        if (request()->ajax()) {
            return datatables()->of(Notification::with('userinfo')->select('*'))
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
                            <a href="javascript:void(0)" class="dropdown-item editNotificationRow" value="' . encrypt($query->id) . '">Edit</a>
                                <a href="javascript:void(0)" class="dropdown-item deleteNotificationRow" value="' . encrypt($query->id) . '">Delete</a>
                            </div>
                        </div>
                        </div>';
                })
                ->rawColumns(['action', 'username'])
                ->make(true);
        }
        $data['users'] = User::select('id', 'firstname', 'lastname')->get();
        return view('notification.index', $data);
        // <a href="javascript:void(0)" class="dropdown-item editNotificationRow" value="' . encrypt($query->id) . '">Edit</a>
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

            // $permission = !empty($request['id']) ? 'notification_edit' : 'notification_create' ;
            // abort_if(Gate::denies($permission), Response::HTTP_FORBIDDEN, '403 Forbidden');

            if (!empty($request['id'])) {
                $notification = Notification::where('id', $request['id'])->first();
                $notification->update($request->except(['_token', 'id', 'image']));
            } else {
                $notification = Notification::create($request->except(['_token', 'image']));
            }
            if ($notification) {
                return redirect()->to('notification')->with('message_success', 'Data Store Successfully');
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
        $user = Notification::find($id);
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
        // abort_if(Gate::denies('notification_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $id = decrypt($id);
        $user = Notification::find($id);
        if ($user->delete()) {
            return response()->json(['status' => 'success', 'message' => 'Notification deleted successfully!']);
        }
        return response()->json(['status' => 'error', 'message' => 'Error in Notification Delete!']);
    }
}
