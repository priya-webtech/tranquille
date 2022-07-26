<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Language;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(Language::select('*'))
                ->addIndexColumn()
                ->addColumn('action', function ($query) {
                    return '<div class="d-flex align-items-center">
                        <div class="dropdown-primary dropdown open">
                            <button class="btn btn-light arrow-none dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="feather icon-more-vertical"></i>
                            </button>
                            <div class="dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                <a href="javascript:void(0)" class="dropdown-item editLanguageRow" value="' . encrypt($query->id) . '">Edit</a>
                                <a href="javascript:void(0)" class="dropdown-item deleteLanguageRow" value="' . encrypt($query->id) . '">Delete</a>
                            </div>
                        </div>
                        </div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('language.index');
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
            // if ($request->file('image') != null) {
            //     $request['offer_image'] = UploadImageToPath($request->image, 'offer_image');
            // }

            if (!empty($request['id'])) {
                $category = Language::where('id', $request['id'])->first();
                // if (!empty($request['offer_image'])) {
                //     RemoveFileFromPath($category['offer_image']);
                // }
                $category->update($request->except(['_token', 'id', 'image']));
            } else {
                $category = Language::create($request->except(['_token', 'image']));
            }
            if ($category) {
                return redirect()->to('language')->with('message_success', 'Language Store Successfully');
            }
            return redirect()->back()->with('message_danger', 'Error in Language Store')->withInput();
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
        $user = Language::find($id);
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
        $user = Language::find($id);
        if ($user->delete()) {
            return response()->json(['status' => 'success', 'message' => 'Language deleted successfully!']);
        }
        return response()->json(['status' => 'error', 'message' => 'Error in Language Delete!']);
    }
}
