<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductBrand;
use App\Models\Treatment;
use App\Models\Services;

class ProductBrandController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(ProductBrand::with('serviceinfo','treatmentinfo')->select('*'))
                ->addIndexColumn()
                ->editColumn('brand_image', function ($query) {
                    return '<img src="' . asset(isset($query['brand_image']) ? $query['brand_image'] : 'assets/image/dummy.png') . '" alt="" class="img-fluid wid-50 m-r-15 rounded">' . $query['brand_name'];
                })
                ->editColumn('service_id', function ($query) {
                    return '<img src="' . asset(isset($query['serviceinfo']['service_image']) ? $query['serviceinfo']['service_image'] : 'assets/image/dummy.png') . '" alt="" class="img-fluid wid-50 m-r-15 rounded">' . $query['serviceinfo']['service_name'];
                })
                ->editColumn('treatment_id', function ($query) {
                    return '<img src="' . asset(isset($query['treatmentinfo']['treatment_image']) ? $query['treatmentinfo']['treatment_image'] : 'assets/image/dummy.png') . '" alt="" class="img-fluid wid-40 m-r-15 rounded">' . $query['treatmentinfo']['treatment_name'];
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
                ->rawColumns(['action', 'brand_image','service_id','treatment_id'])
                ->make(true);
        }
        $data['service'] = Services::select('*')->get();
        $data['treatment'] = Treatment::select('*')->get();

        return view('product.index', $data);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {
            if ($request->file('image') != null) {
                $request['brand_image'] = productUploadImageToPath($request->image, 'brand_image');
            }

            if (!empty($request['id'])) {
                $category = ProductBrand::where('id', $request['id'])->first();
                if (!empty($request['brand_image'])) {
                    productRemoveImageFromPath($category['brand_image']);
                }
                $category->update($request->except(['_token', 'id', 'image']));
            } else {
                $category = ProductBrand::create($request->except(['_token', 'image']));
            }
            if ($category) {
                return redirect()->to('product')->with('message_success', 'Product Store Successfully');
            }
            return redirect()->back()->with('message_danger', 'Error in Product Store')->withInput();
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
        $user = ProductBrand::find($id);
        $user['treatments'] = Treatment::where('service_id', $user->service_id)->select('id', 'treatment_name')->get();
        return response()->json($user);

    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $id = decrypt($id);
        $user = ProductBrand::find($id);
        if ($user->delete()) {
            return response()->json(['status' => 'success', 'message' => 'Product deleted successfully!']);
        }
        return response()->json(['status' => 'error', 'message' => 'Error in Product Delete!']);
    }
}
