<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use App\Models\Developer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class DeveloperController extends Controller
{
    public $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('admin')->user();
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (is_null($this->user) || !$this->user->can('developer.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view City !');
        }

        // $dataArr = City::limit(1000)->get();
        return view('backend.pages.developer.index');
    }


    public function ajaxIndex()
    {

        $query = Developer::query();
        $query->select('id', 'image', 'name', 'status', 'sort_order', 'created_at', 'updated_at');

        return DataTables::eloquent($query)
            ->addColumn('id', function (Developer $ar) {
                return $ar->id;
            })

            ->addColumn('image', function ($dt) {
                $defaultImagePath = url('public/img/devotion-group-favicon.png');
                $userImageUrl = $dt->image
                    ? asset('storage/app/developer/' . $dt->image)
                    : $defaultImagePath;
                $imageStyle = 'width: 100%; height: 100%; object-fit: fill; border-radius: 8px;';

                return '<img src="' . $userImageUrl . '" alt="User Profile Image" style="' . $imageStyle . '">';
            })

            ->addColumn('name', function (Developer $ar) {
                return $ar->name; // Display the country name
            })
            ->addColumn('sort_order', function (Developer $dt) {
                return $dt->sort_order; // Display the country name
            })
            ->addColumn('sub_title', function (Developer $ar) {
                return $ar->sub_title; // Display the country name
            })
            ->addColumn('status', function (Developer $ar) {
                $status = "";
                if (true) {
                    $status = '<i class="fa fa-' . ($ar->status == 0 ? 'times' : 'check') . ' update-status" data-status="' . $ar->status . '" data-id="' . $ar->id . '" aria-hidden="true" data-table="developers"></i>';
                } else {
                    $status = '<select class="form-control update-status badge ' . ($ar->status == 0 ? 'bg-warning' : 'bg-success') . ' text-white" name="status" data-id="' . $ar->id . '" data-table="developers">
                            <option value="1" ' . ($ar->status == 1 ? 'selected' : '') . '>Active</option>
                            <option value="0" ' . ($ar->status == 0 ? 'selected' : '') . '>De-Active</option>
                        </select>';
                }

                return $status;
            })
            ->addColumn('updated_at', function (Developer $ar) {
                return formatDate("Y-m-d H:i", $ar->updated_at);
            })
            ->addColumn('action', function (Developer $ar) {

                $action = '
                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="action_menu_' . $ar->id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        &#x22EE;
                    </button>
                    <div class="dropdown-menu" aria-labelledby="action_menu_' . $ar->id . '">
                    ';

                if ($this->user->can('developer.edit')) {
                    $action .= '<a class="btn btn-edit text-white dropdown-item" href="' . route('admin.developer.edit', $ar->id) . '">
                            <i class="fa fa-pencil"></i> Edit
                        </a>';
                }

                if ($this->user->can('developer.delete')) {
                    $action .= '<button class="btn btn-edit text-white delete-record dropdown-item" data-id="' . $ar->id . '" data-title="' . $ar->name . '" data-segment="developer">
                    <i class="fa fa-trash fa-sm" aria-hidden="true"></i> Delete
                    </button>';
                }

                $action .= '
                    </div>
                ';


                return $action;
            })
            ->rawColumns(['id', 'image', 'name', 'sort_order', 'status', 'created_at', 'updated_at', 'action'])  // Specify the columns that contain HTML
            ->filter(function ($query) {
                if (request()->has('search')) {
                    $searchValue = request('search')['value'];
                    $query->where('name', 'like', "%{$searchValue}%");
                }
            })
            ->order(function ($query) {
                if (request()->has('order')) {
                    $orderColumn = request('order')[0]['column'];
                    $orderDirection = request('order')[0]['dir'];
                    $columns = request('columns');
                    $query->orderBy($columns[$orderColumn]['data'], $orderDirection);
                }
            })
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (is_null($this->user) || !$this->user->can('developer.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create Developer !');
        }


        return view('backend.pages.developer.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('developer.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create Brochure !');
        }

        // ✅ Validate input
        $request->validate([
            'name' => 'required',
        ]);

        //  $imageName = null;

        // if ($request->hasFile('image')) {

        //     $file = $request->file('image');

        //     if ($file->isValid()) {

        //         if (!Storage::exists('developer/')) {
        //             Storage::makeDirectory('developer/', 0777, true);
        //         }
        //         $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        //         $extension = $file->getClientOriginalExtension();
        //         $imageName = $originalName.'.'.$extension;

        //         $file->storeAs('developer/', $imageName);
        //     } else {
        //         return back()->withErrors(['image' => 'The image failed to upload properly.']);
        //     }
        // }



        // // ✅ Save to database
        // $dataObj = new Developer();
        // $dataObj->name = $request->name;
        // $dataObj->image = $imageName;
        // $dataObj->description = $request->description;
        // $dataObj->short_description = $request->short_description;
        // $dataObj->sort_order  = $request->sort_order;
        // $dataObj->status = $request->status;
        // $dataObj->save();
        $dataObj = $this->StoreUpdateData($request);
        session()->flash('success', $dataObj->name . ' record has been created successfully!');
        return redirect()->route('admin.developer.index');
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
    public function edit(int $id)
    {
        if (is_null($this->user) || !$this->user->can('developer.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit Developer !');
        }

        $data = Developer::find($id);

        return view('backend.pages.developer.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        if (is_null($this->user) || !$this->user->can('developer.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit Banner !');
        }
        // Create New Developer
        $developer = Developer::find($id);

        // Validate input
        $request->validate([
            'name' => 'required',
        ]);

        // $imageName = $developer->image; // keep old image

        // if ($request->hasFile('image')) {
        //     $file = $request->file('image');

        //     if ($file->isValid()) {

        //         // Make folder if missing
        //         if (!Storage::exists('developer/')) {
        //             Storage::makeDirectory('developer/');
        //         }

        //         // Delete old image
        //         if ($developer->image && Storage::exists('developer/' . $developer->image)) {
        //             Storage::delete('developer/' . $developer->image);
        //         }

        //         // Upload new image
        //             $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        //             $extension = $file->getClientOriginalExtension();
        //             $imageName = $originalName.'.'.$extension;

        //         $file->storeAs('developer/', $imageName);
        //     }
        // }

        // // Fetch existing record
        // $dataObj = Developer::findOrFail($id);
        // $dataObj->image = $imageName;
        // $dataObj->name = $request->name;
        // $dataObj->short_description = $request->short_description;
        // $dataObj->description = $request->description;
        // $dataObj->sort_order  = $request->sort_order;
        // $dataObj->status = $request->status;
        // $dataObj->save();
        $dataObj = $this->StoreUpdateData($request, $id);
        session()->flash('success', $dataObj->name . ' record has been updated successfully!');
        return redirect()->route('admin.developer.index');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        if (is_null($this->user) || !$this->user->can('developer.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete City !');
        }

        $dataObj = Developer::find($id);
        if ($dataObj) {
            $dataObj->delete();
            return response()->json(['data' => ['message' => $dataObj->name . ' record has been successfully deleted.']], 200);
        } else {
            return response()->json(['data' => ['message' => 'Record already deleted.']], 200);
        }
    }

    public function StoreUpdateData(Request $request, int $id = null)
    {
        // ✅ Find or create model
        $dataObj = $id ? Developer::findOrFail($id) : new Developer();

        // ✅ Keep old image by default
        $imageName = $dataObj->image ?? null;

        // ✅ Image upload
        if ($request->hasFile('image')) {

            $file = $request->file('image');

            if ($file->isValid()) {

                // Delete old image on update
                if ($id && $dataObj->image && Storage::exists('developer/' . $dataObj->image)) {
                    Storage::delete('developer/' . $dataObj->image);
                }

                // Ensure directory exists
                if (!Storage::exists('developer')) {
                    Storage::makeDirectory('developer', 0777, true);
                }

                // ✅ Unique filename (important)
                // $imageName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $imageName = $originalName.'.'.$extension;

                $file->storeAs('developer', $imageName);
            } else {
                return back()->withErrors(['image' => 'The image failed to upload properly.']);
            }
        }

        // ✅ Save data (update OR insert)
        $dataObj->name = $request->name;
        $dataObj->image = $imageName;
        $dataObj->description = $request->description;
        $dataObj->short_description = $request->short_description;
        $dataObj->sort_order = $request->sort_order;
        $dataObj->status = $request->status;
        $dataObj->save();

        return $dataObj;
    }

}
