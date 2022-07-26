<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Country;
use Datatables;

class CountryController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(Country::select('*'))
                ->addIndexColumn()
                ->editColumn('flag', function ($query) {
                    return '<img src="' . asset($query->flag) . '" class="rounded-lg mr-1" width="50" alt="">';
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
                ->rawColumns(['action', 'flag'])
                ->make(true);
        }
        return view('country.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {
            if ($request->file('image') != null) {
                $request['flag'] = UploadImageToPath($request->image, 'country_flag');
            }

            if (!empty($request['id'])) {
                $category = Country::where('id', $request['id'])->first();
                if (!empty($request['flag'])) {
                    RemoveFileFromPath($category['flag']);
                }
                $category->update($request->except(['_token', 'id', 'image']));
            } else {
                $category = Country::create($request->except(['_token', 'image']));
            }
            if ($category) {
                return redirect()->to('country')->with('message_success', 'Country Store Successfully');
            }
            return redirect()->back()->with('message_danger', 'Error in Country Store')->withInput();
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
        $user = Country::find($id);
        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $id = decrypt($id);
        $user = Country::find($id);
        if ($user->delete()) {
            return response()->json(['status' => 'success', 'message' => 'Country deleted successfully!']);
        }
        return response()->json(['status' => 'error', 'message' => 'Error in Country Delete!']);
    }
}
