<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Continent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ContinentsController extends Controller
{
    public $user;
    public $is_assign_super_admin = 0;
    public $admin_id = 0;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('admin')->user();
            return $next($request);
        });
    }

    /**
     *
     */
    public function setPublicVar()
    {
        $this->is_assign_super_admin = $this->user->is_assign_super_admin;
        $this->admin_id = $this->user->id;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (is_null($this->user) || !$this->user->can('continent.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any continent !');
        }

        $dataArr = Continent::select('id', 'name', 'status', 'updated_at')->get();
        return view('backend.pages.continents.index', compact('dataArr'));
    }

    public function ajaxIndex(Request $request)
    {

        $this->setPublicVar();

        $query = Continent::query();

        if (!$this->is_assign_super_admin) {
            $query->where('admin_id', $this->admin_id);
        }

        $query->select('id', 'name', 'status', 'updated_at');

        return DataTables::eloquent($query)
            ->addColumn('id', function (Continent $ar) {
                return $ar->id;
            })
            ->addColumn('name', function (Continent $ar) {
                return $ar->name;
            })
            ->addColumn('status', function (Continent $dt) {
                $status = "";
                if (true) {
                    $status = '<i class="fa fa-' . ($dt->status == 0 ? 'times' : 'check') . ' update-status" data-status="' . $dt->status . '" data-id="' . $dt->id . '" aria-hidden="true" data-table="continents"></i>';
                } else {
                    $status = '<select class="form-control update-status badge ' . ($dt->status == 0 ? 'bg-warning' : 'bg-success') . ' text-white" name="status" data-id="' . $dt->id . '" data-table="continents">
                            <option value="1" ' . ($dt->status == 1 ? 'selected' : '') . '>Active</option>
                            <option value="0" ' . ($dt->status == 0 ? 'selected' : '') . '>De-Active</option>
                        </select>';
                }

                return $status;
            })
            ->addColumn('updated_at', function (Continent $ar) {
                return formatDate("Y-m-d H:i", $ar->updated_at);
            })
            ->addColumn('action', function (Continent $ar) {

                $action = '
                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="action_menu_' . $ar->id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        &#x22EE;
                    </button>
                    <div class="dropdown-menu" aria-labelledby="action_menu_' . $ar->id . '">
                    ';

                if ($this->user->can('continent.edit')) {
                    $action .= '<a class="btn btn-edit text-white dropdown-item" href="' . route('admin.continent.edit', $ar->id) . '">
                            <i class="fa fa-pencil"></i> Edit
                        </a>';
                }

                if ($this->user->can('continent.delete')) {
                    $action .= '<button class="btn btn-edit text-white delete-record dropdown-item" data-id="' . $ar->id . '" data-title="' . $ar->name . '" data-segment="continents">
                    <i class="fa fa-trash fa-sm" aria-hidden="true"></i> Delete
                    </button>';
                }

                $action .= '
                    </div>
                ';

                return $action;
            })
            ->rawColumns(['id', 'name',  'status', 'updated_at', 'action'])  // Specify the columns that contain HTML
            ->filter(function ($query) {
                if (request()->has('search')) {
                    $searchValue = request('search')['value'];
                    if ($searchValue != "") {
                        $query->where('name', 'like', "%{$searchValue}%");
                    }
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
        if (is_null($this->user) || !$this->user->can('continent.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any continent !');
        }

        return view('backend.pages.continents.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('continent.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any continent !');
        }

        // Validation Data
        $request->validate([
            'name' => 'required|max:20',
        ]);

        // // Create New Server Record
        // $dataObj = new Continent();
        // $dataObj->name = $request->name;
        // $dataObj->status = $request->status;
        // $dataObj->save();

        $dataObj = $this->StoreUpdateData($request);

        session()->flash('success', $dataObj->name . ' Record has been created !!');
        return redirect()->route('admin.continent.index');
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
        if (is_null($this->user) || !$this->user->can('continent.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any continent !');
        }

        $data = Continent::find($id);
        return view('backend.pages.continents.edit', compact('data'));
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
        if (is_null($this->user) || !$this->user->can('continent.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any continent !');
        }

        // Validation Data
        $request->validate([
            'name' => 'required|max:20',
        ]);

        // // Create New Server Record
        // $dataObj = Continent::find($id);
        // $dataObj->name = $request->name;
        // $dataObj->status = $request->status;
        // $dataObj->save();

        $dataObj = $this->StoreUpdateData($request, $id);

        session()->flash('success', $dataObj->name . ' Records has been updated !!');
        return redirect()->route('admin.continent.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        if (is_null($this->user) || !$this->user->can('continent.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete any continent !');
        }

        $dataObj = Continent::find($id);
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
        $dataObj = $id ? Continent::findOrFail($id) : new Continent(); 
        
        $dataObj->name = $request->name;
        $dataObj->status = $request->status;
        $dataObj->save();

        return $dataObj;
    }
}
