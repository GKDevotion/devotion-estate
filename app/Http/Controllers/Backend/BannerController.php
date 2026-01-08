<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class BannerController extends Controller
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
        if (is_null($this->user) || !$this->user->can('banner.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view City !');
        }

        // $dataArr = City::limit(1000)->get();
        return view('backend.pages.banner.index');
    }


    public function ajaxIndex()
    {

        $query = Banner::query();
        $query->select('id', 'image', 'name', 'sub_title', 'status', 'created_at', 'updated_at');

        return DataTables::eloquent($query)
            ->addColumn('id', function (Banner $city) {
                return $city->id;
            })
            ->addColumn('image', function (Banner $city) {
                $url = $city->image ? asset('storage/app/banner/' . $city->image) : url('public/img/devotion-group-favicon.png');
                return '<img src="' . $url . '" width="100" height="100" style="object-fit:cover;">';
            })

            ->addColumn('name', function (Banner $city) {
                return $city->name; // Display the country name
            })
            ->addColumn('sub_title', function (Banner $city) {
                return $city->sub_title; // Display the country name
            })

            ->addColumn('status', function (Banner $city) {
                $status = "";
                if (true) {
                    $status = '<i class="fa fa-' . ($city->status == 0 ? 'times' : 'check') . ' update-status" data-status="' . $city->status . '" data-id="' . $city->id . '" aria-hidden="true" data-table="banners"></i>';
                } else {
                    $status = '<select class="form-control update-status badge ' . ($city->status == 0 ? 'bg-warning' : 'bg-success') . ' text-white" name="status" data-id="' . $city->id . '" data-table="banners">
                            <option value="1" ' . ($city->status == 1 ? 'selected' : '') . '>Active</option>
                            <option value="0" ' . ($city->status == 0 ? 'selected' : '') . '>De-Active</option>
                        </select>';
                }

                return $status;
            })
            ->addColumn('updated_at', function (Banner $city) {
                return formatDate("Y-m-d H:i", $city->updated_at);
            })
            ->addColumn('action', function (Banner $city) {

                $action = '
                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="action_menu_' . $city->id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        &#x22EE;
                    </button>
                    <div class="dropdown-menu" aria-labelledby="action_menu_' . $city->id . '">
                    ';

                if ($this->user->can('banner.edit')) {
                    $action .= '<a class="btn btn-edit text-white dropdown-item" href="' . route('admin.banner.edit', $city->id) . '">
                            <i class="fa fa-pencil"></i> Edit
                        </a>';
                }

                if ($this->user->can('banner.delete')) {
                    $action .= '<button class="btn btn-edit text-white delete-record dropdown-item" data-id="' . $city->id . '" data-title="' . $city->name . '" data-segment="banner">
                    <i class="fa fa-trash fa-sm" aria-hidden="true"></i> Delete
                    </button>';
                }

                $action .= '
                    </div>
                ';


                return $action;
            })
            ->rawColumns(['id',  'image', 'name', 'sub_title', 'status', 'created_at', 'updated_at', 'action'])  // Specify the columns that contain HTML
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
        if (is_null($this->user) || !$this->user->can('banner.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create City !');
        }


        return view('backend.pages.banner.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('banner.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create Brochure !');
        }

        // ✅ Validate input
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'required|in:0,1',
        ]);


        // // ✅ Save to database
        // $dataObj = new Banner();
        // $dataObj->name = $request->name;
        // $dataObj->sub_title = $request->sub_title;
        // $dataObj->link = $request->link;
        // $dataObj->status = $request->status;

        // // Handle Image Upload
        // if ($request->hasFile('image')) {

        //     // Create folder if not exists
        //     if (!file_exists(storage_path('app/banner'))) {
        //         mkdir(storage_path('app/banner'), 0777, true);
        //     }

        //     $file = $request->file('image');
        //     $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

        //     // Save in storage/app/banner
        //     $file->storeAs('banner', $fileName);

        //     // Save filename in DB
        //     $dataObj->image = $fileName;
        // }


        // $dataObj->save();

        $dataObj = $this->StoreUpdateData( $request );

        session()->flash('success', $dataObj->name . ' record has been created successfully!');
        return redirect()->route('admin.banner.index');
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
        if (is_null($this->user) || !$this->user->can('banner.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit City !');
        }

        $data = Banner::find($id);

        return view('backend.pages.banner.edit', compact('data'));
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
        if (is_null($this->user) || !$this->user->can('banner.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit Banner !');
        }

        // Validate input
        $request->validate([
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'required|in:0,1',
        ]);

        // // Fetch existing record
        // $dataObj = Banner::findOrFail($id);

        // $dataObj->name = $request->name;
        // $dataObj->sub_title = $request->sub_title;
        // $dataObj->link = $request->link;
        // $dataObj->status = $request->status;

        // // Handle image update
        // if ($request->hasFile('image')) {

        //     // Ensure folder exists
        //     if (!file_exists(storage_path('app/banner'))) {
        //         mkdir(storage_path('app/banner'), 0777, true);
        //     }

        //     // Delete old image if exists
        //     if (!empty($dataObj->image) && file_exists(storage_path('app/banner/' . $dataObj->image))) {
        //         unlink(storage_path('app/banner/' . $dataObj->image));
        //     }

        //     $file = $request->file('image');
        //     $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

        //     // Save new file
        //     $file->storeAs('banner', $fileName);

        //     // Update DB with new file
        //     $dataObj->image = $fileName;
        // }

        // $dataObj->save();
        $dataObj = $this->StoreUpdateData( $request, $id );
        session()->flash('success', $dataObj->name . ' record has been updated successfully!');
        return redirect()->route('admin.banner.index');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        if (is_null($this->user) || !$this->user->can('banner.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete City !');
        }

        $dataObj = Banner::find($id);
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
        $dataObj = $id ? Banner::findOrFail($id) : new Banner();


        $dataObj->name = $request->name;
        $dataObj->sub_title = $request->sub_title;
        $dataObj->link = $request->link;
        $dataObj->status = $request->status;

        // Handle Image Upload
        if ($request->hasFile('image')) {

            if ($id) {
              // Delete old image if exists
            if (!empty($dataObj->image) && file_exists(storage_path('app/banner/' . $dataObj->image))) {
                unlink(storage_path('app/banner/' . $dataObj->image));
            }
            }

            // Create folder if not exists
            if (!file_exists(storage_path('app/banner'))) {
                mkdir(storage_path('app/banner'), 0777, true);
            }

            $file = $request->file('image');
            // $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $fileName = $originalName.'.'.$extension;

            // Save in storage/app/banner
            $file->storeAs('banner', $fileName);

            // Save filename in DB
            $dataObj->image = $fileName;
        }


        $dataObj->save(); 
        return $dataObj;
    }
}
