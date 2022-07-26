<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Status;

class StatusController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(Status::select('*'))
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
        return view('status.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {
            if (!empty($request['id'])) {
                $user = Status::where('id', $request['id'])->first();
                $user->active = isset($request->active) ? $request->active : '';
                $user->status = isset($request->status) ? $request->status : '';
                $user->save();
            } else {

                $user = Status::create($request->except(['_token']));
            }
            if ($user) {
                return redirect()->to('status')->with('message_success', 'Data Store Successfully');
            }
            return redirect()->back()->with('message_danger', 'Error in Data Store')->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }
    }

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $id = decrypt($id);
        $user = Status::find($id);
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
            $user = Status::find($id);
            if ($user->delete()) {
                return response()->json(['status' => 'success', 'message' => 'Status deleted successfully!']);
            }
            return response()->json(['status' => 'error', 'message' => 'Error in Status Delete!']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Error in Status Delete!']);
        }
    }
}
