<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Services;
use App\Models\Treatment;

class ServiceController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(Services::select('*'))
                ->addIndexColumn()
                ->editColumn('service_image', function ($query) {
                    return '<img src="' . asset(isset($query['service_image']) ? $query['service_image'] : 'assets/image/dummy.png') . '" alt="" class="img-fluid wid-50 m-r-15 rounded">';
                })
                // ->editColumn('small_image', function ($query) {
                //     return '<img src="' . asset($query->small_image) . '" class="rounded-lg mr-1" width="50" alt="">';
                // })
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
                ->rawColumns(['action', 'service_image', 'small_image'])
                ->make(true);
        }

        return view('service.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {
            if ($request->file('image') != null) {
                $request['service_image'] = uploadImageToPath($request->image, 'service_image');
            }
            if ($request->file('image1') != null) {
                $request['small_image'] = productUploadImageToPath($request->image1, 'service_image'); //folder name
            }
            if (!empty($request['id'])) {
                $category = Services::where('id', $request['id'])->first();
                if (!empty($request['service_image'])) {
                    removeFileFromPath($category['service_image']);
                }
                if (!empty($request['small_image'])) {
                    removeFileFromPath($category['small_image']);
                }
                $category->update($request->except(['_token', 'id', 'image', 'image1']));
            } else {
                $category = Services::create($request->except(['_token', 'image', 'image1']));
            }
            if ($category) {
                return redirect()->to('service')->with('message_success', 'Data Store Successfully');
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
        $user = Services::find($id);
        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $id = decrypt($id);
        Treatment::where('service_id', '=', $id)->delete();
        $user = Services::find($id);
        if ($user->delete()) {
            return response()->json(['status' => 'success', 'message' => 'Service deleted successfully!']);
        }
        return response()->json(['status' => 'error', 'message' => 'Error in Service Delete!']);
    }
}
