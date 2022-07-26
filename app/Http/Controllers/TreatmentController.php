<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Treatment;
use App\Models\Services;


class TreatmentController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(Treatment::with('serviceinfo')->select('*'))
                ->addIndexColumn()
                ->editColumn('treatment_name', function ($query) {
                    return '<img src="' . asset(isset($query['treatment_image']) ? $query['treatment_image'] : 'assets/image/dummy.png') . '" alt="" class="img-fluid wid-40 m-r-15 rounded">' . $query['treatment_name'];
                })
                ->editColumn('service_id', function ($query) {
                    return '<img src="' . asset($query['serviceinfo']['service_image']) . '" alt="" class="img-fluid wid-40 m-r-15 rounded">' . $query['serviceinfo']['service_name'];
                })
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
                ->rawColumns(['action', 'service_id', 'treatment_name'])
                ->make(true);
        }
        $data['service'] = Services::select('*')->get();

        return view('treatment.index', $data);
    }
    // return '<div class="d-flex align-items-center btn-page">
    // <button type="button"  class="btn  btn-info editCategoryRow" value="' . encrypt($query->id) . '"><i class="fas fa-pen"></i></button>
    // <button type="button" class="btn  btn-danger deleteCategoryRow" value="' . encrypt($query->id) . '"><i class="fas fa-trash-alt"></i></button>
    // </div>';
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {
            // dd($request);
            if ($request->hasFile('image')) {
                $profileimage = time() . '.' . $request->image->getClientOriginalExtension();
                $upload = $request->image->move(public_path('treatment'), $profileimage);
                $request['treatment_image'] = '/treatment/' . $profileimage;
            }
            if ($request->hasFile('image1')) {
                $profileimage = time() . '.' . $request->image1->getClientOriginalExtension();
                $upload = $request->image1->move(public_path('treatment'), $profileimage);
                $request['small_image'] = '/treatment/' . $profileimage;
            }
            if ($request['feature'] == null) {
                $request['feature'] = 0;
            }

            if (!empty($request['id'])) {
                $category = Treatment::where('id', $request['id'])->first();
                if (!empty($request['treatment_image'])) {
                    removeFileFromPath($category['treatment_image']);
                }
                if (!empty($request['small_image'])) {
                    removeFileFromPath($category['small_image']);
                }
                $category->update($request->except(['_token', 'id', 'image', 'image1']));
            } else {
                $category = Treatment::create($request->except(['_token', 'image', 'image1']));
            }
            if ($category) {
                return redirect()->to('treatments')->with('message_success', 'Data Store Successfully');
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
        $user = Treatment::find($id);
        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        $id = decrypt($id);
        $user = Treatment::find($id);
        if ($user->delete()) {
            return response()->json(['status' => 'success', 'message' => 'Treatment deleted successfully!']);
        }
        return response()->json(['status' => 'error', 'message' => 'Error in Treatment Delete!']);
    }
}
