<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Offer;
use App\Models\User;

class OfferController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(Offer::with('vendorinfo')->select('*'))
                ->addIndexColumn()
                ->editColumn('vendor_id', function ($query) {
                    return '<img src="' . asset(isset($query['vendorinfo']['profile']) ? $query['vendorinfo']['profile'] : 'assets/image/dummy.png') . '" alt="" class="img-fluid wid-40 m-r-15 rounded">' . $query['vendorinfo']['firstname'];
                })
                ->editColumn('offer', function ($query) {
                    return '<img src="' . asset($query['offer_image']) . '" alt="" class="img-fluid wid-40 m-r-15 rounded">' . $query['offer_title'];
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
                ->rawColumns(['action', 'vendor_id','offer'])
                ->make(true);
        }
        $data['user'] = User::select('*')->where('type', '=', 'Provider')->where('active', '=', 'Y')->get();
        return view('offer.index', $data);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {
            if ($request->file('image') != null) {
                $request['offer_image'] = UploadImageToPath($request->image, 'offer_image');
            }

            if (!empty($request['id'])) {
                $category = Offer::where('id', $request['id'])->first();
                if (!empty($request['offer_image'])) {
                    RemoveFileFromPath($category['offer_image']);
                }
                $category->update($request->except(['_token', 'id', 'image']));
            } else {
                $category = Offer::create($request->except(['_token', 'image']));
            }
            if ($category) {
                return redirect()->to('offer')->with('message_success', 'Offer Store Successfully');
            }
            return redirect()->back()->with('message_danger', 'Error in Offer Store')->withInput();
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
        $user = Offer::find($id);
        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $id = decrypt($id);
        $user = Offer::find($id);
        if ($user->delete()) {
            return response()->json(['status' => 'success', 'message' => 'Offer deleted successfully!']);
        }
        return response()->json(['status' => 'error', 'message' => 'Error in Offer Delete!']);
    }
}
