<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contactus;

class ContactUsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(Contactus::select('*'))
                ->addIndexColumn()
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
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('contactus.index');
    }

    //     return '<div class="d-flex align-items-center btn-page">
    //     <button type="button"  class="btn  btn-info editCategoryRow" value="' . encrypt($query->id) . '"><i class="fas fa-pen"></i></button>
    //     <button type="button" class="btn  btn-danger deleteCategoryRow" value="' . encrypt($query->id) . '"><i class="fas fa-trash-alt"></i></button>
    //     </div>';
    // })
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
                $user = Contactus::where('id', $request['id'])->first();
                $user->name = isset($request->name) ? $request->name : '';
                $user->message = isset($request->message) ? $request->message : '';
                $user->email = isset($request->email) ? $request->email : '';
                $user->phone = isset($request->phone) ? $request->phone : '';
                $user->save();
                $data = $user;

            } else {
                $user = Contactus::create($request->except(['_token']));
                $data = $user;
                broadcast(new \App\Events\SendNotification($data))->toOthers();
            }
            if ($user) {
                return redirect()->to('contactus')->with('message_success', 'Data Store Successfully');

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
        $user = Contactus::find($id);
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
        $user = Contactus::find($id);
        if ($user->delete()) {
            return response()->json(['status' => 'success', 'message' => 'Contact Us deleted successfully!']);
        }
        return response()->json(['status' => 'error', 'message' => 'Error in Contact Us Delete!']);
    }
}
