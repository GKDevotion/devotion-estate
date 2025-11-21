<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Award;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class AwardController extends Controller
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
        if (is_null($this->user) || !$this->user->can('award.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view Award !');
        }

        // $dataArr = City::limit(1000)->get();
        return view('backend.pages.award.index');
    }


    public function ajaxIndex()
    {

        $query = Award::query();
        $query->select('id', 'image', 'name', 'sub_title', 'status', 'created_at', 'updated_at');

        return DataTables::eloquent($query)
            ->addColumn('id', function (Award $city) {
                return $city->id;
            })
            ->addColumn('image', function (Award $city) {
                return $city->image;
            })
           ->addColumn('name', function (Award $city) {
                return $city->name; // Display the country name
            })
            ->addColumn('sub_title', function (Award $city) {
                return $city->sub_title; // Display the country name
            })
            ->addColumn('status', function (Award $city) {
                $status = "";
                if (true) {
                    $status = '<i class="fa fa-' . ($city->status == 0 ? 'times' : 'check') . ' update-status" data-status="' . $city->status . '" data-id="' . $city->id . '" aria-hidden="true" data-table="awards"></i>';
                } else {
                    $status = '<select class="form-control update-status badge ' . ($city->status == 0 ? 'bg-warning' : 'bg-success') . ' text-white" name="status" data-id="' . $city->id . '" data-table="awards">
                            <option value="1" ' . ($city->status == 1 ? 'selected' : '') . '>Active</option>
                            <option value="0" ' . ($city->status == 0 ? 'selected' : '') . '>De-Active</option>
                        </select>';
                }

                return $status;
            })
            ->addColumn('updated_at', function (Award $city) {
                return formatDate("Y-m-d H:i", $city->updated_at);
            })
            ->addColumn('action', function (Award $city) {

                $action = '
                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="action_menu_' . $city->id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        &#x22EE;
                    </button>
                    <div class="dropdown-menu" aria-labelledby="action_menu_' . $city->id . '">
                    ';

                    if ($this->user->can('award.edit')) {
                        $action .= '<a class="btn btn-edit text-white dropdown-item" href="' . route('admin.award.edit', $city->id) . '">
                                <i class="fa fa-pencil"></i> Edit
                            </a>';
                    }

                    if ($this->user->can('award.delete')) {
                        $action .= '<button class="btn btn-edit text-white delete-record dropdown-item" data-id="' . $city->id . '" data-title="' . $city->name . '" data-segment="award">
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
        if (is_null($this->user) || !$this->user->can('award.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create Award !');
        }


        return view('backend.pages.award.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('award.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create Award !');
        }

        // ✅ Validate input
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'required|in:0,1',
        ]);


        // ✅ Save to database
        $dataObj = new Award();
        $dataObj->name = $request->name;
        $dataObj->sub_title = $request->sub_title;
        $dataObj->status = $request->status;

        // Handle Image Upload
        if ($request->hasFile('image')) {

            // Create folder if not exists
            if (!file_exists(storage_path('app/award'))) {
                mkdir(storage_path('app/award'), 0777, true);
            }

            $file = $request->file('image');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            // Save in storage/app/award
            $file->storeAs('award', $fileName);

            // Save filename in DB
            $dataObj->image = $fileName;
        }


        $dataObj->save();

        session()->flash('success', $dataObj->name.' record has been created successfully!');
        return redirect()->route('admin.award.index');
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
        if (is_null($this->user) || !$this->user->can('award.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit Award !');
        }

        $data = Award::find($id);

        return view('backend.pages.award.edit', compact('data'));
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
        if (is_null($this->user) || !$this->user->can('award.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit Award !');
        }

        // Validate input
        $request->validate([
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'required|in:0,1',
        ]);

        // Fetch existing record
        $dataObj = Award::findOrFail($id);

        $dataObj->name = $request->name;
        $dataObj->sub_title = $request->sub_title;
        $dataObj->status = $request->status;

        // Handle image update
        if ($request->hasFile('image')) {

            // Ensure folder exists
            if (!file_exists(storage_path('app/award'))) {
                mkdir(storage_path('app/award'), 0777, true);
            }

            // Delete old image if exists
            if (!empty($dataObj->image) && file_exists(storage_path('app/award/' . $dataObj->image))) {
                unlink(storage_path('app/award/' . $dataObj->image));
            }

            $file = $request->file('image');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            // Save new file
            $file->storeAs('award', $fileName);

            // Update DB with new file
            $dataObj->image = $fileName;
        }

        $dataObj->save();

        session()->flash('success', $dataObj->name.' record has been updated successfully!');
        return redirect()->route('admin.award.index');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        if (is_null($this->user) || !$this->user->can('award.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete Award !');
        }

        $dataObj = Banner::find($id);
        if ($dataObj) {
            $dataObj->delete();
            return response()->json(['data' => ['message' => $dataObj->name . ' record has been successfully deleted.']], 200);
        } else {
            return response()->json(['data' => ['message' => 'Record already deleted.']], 200);
        }
    }
}
