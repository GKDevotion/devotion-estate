<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Religion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ReligionsController extends Controller
{
    public $user;
    public $is_assign_super_admin = 0;
    public $admin_id = 0;

    /**
     *
     */
    public function setPublicVar()
    {
        $this->is_assign_super_admin = $this->user->is_assign_super_admin;
        $this->admin_id = $this->user->id;
    }

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
        if (is_null($this->user) || !$this->user->can('religion.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view Religions !');
        }

        $dataArr = Religion::select('id', 'name', 'status', 'updated_at')->get();
        return view('backend.pages.religions.index', compact('dataArr'));
    }


    public function ajaxIndex(Request $request)
    {

        $this->setPublicVar();

        $query = Religion::query();

        if (!$this->is_assign_super_admin) {
            $query->where('admin_id', $this->admin_id);
        }

        $query->select('id', 'name', 'status', 'updated_at');

        return DataTables::eloquent($query)
            ->addColumn('id', function (Religion $ar) {
                return $ar->id;
            })
            ->addColumn('name', function (Religion $ar) {
                return $ar->name;
            })


            ->addColumn('status', function (Religion $dt) {
                $status = "";
                if (true) {
                    $status = '<i class="fa fa-' . ($dt->status == 0 ? 'times' : 'check') . ' update-status" data-status="' . $dt->status . '" data-id="' . $dt->id . '" aria-hidden="true" data-table="religions"></i>';
                } else {
                    $status = '<select class="form-control update-status badge ' . ($dt->status == 0 ? 'bg-warning' : 'bg-success') . ' text-white" name="status" data-id="' . $dt->id . '" data-table="religions">
                            <option value="1" ' . ($dt->status == 1 ? 'selected' : '') . '>Active</option>
                            <option value="0" ' . ($dt->status == 0 ? 'selected' : '') . '>De-Active</option>
                        </select>';
                }

                return $status;
            })

            ->addColumn('updated_at', function (Religion $ar) {
                return formatDate("Y-m-d H:i", $ar->updated_at);
            })
            ->addColumn('action', function (Religion $ar) {

                $action = '
                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="action_menu_' . $ar->id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        &#x22EE;
                    </button>
                    <div class="dropdown-menu" aria-labelledby="action_menu_' . $ar->id . '">
                    ';

                if ($this->user->can('religion.edit')) {
                    $action .= '<a class="btn btn-edit text-white dropdown-item" href="' . route('admin.religion.edit', $ar->id) . '">
                            <i class="fa fa-pencil"></i> Edit
                        </a>';
                }

                if ($this->user->can('religion.delete')) {
                    $action .= '<button class="btn btn-edit text-white delete-record dropdown-item" data-id="' . $ar->id . '" data-title="' . $ar->name . '" data-segment="religions">
                    <i class="fa fa-trash fa-sm" aria-hidden="true"></i> Delete
                    </button>';
                }

                $action .= '
                    </div>
                ';

                return $action;
            })
            ->rawColumns(['id', 'name', 'status', 'updated_at', 'action'])  // Specify the columns that contain HTML
            ->filter(function ($query) {
                if (request()->has('search')) {
                    $searchValue = request('search')['value'];
                    if ($searchValue != "") {
                        $query->where('display_name', 'like', "%{$searchValue}%");
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
        if (is_null($this->user) || !$this->user->can('religion.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create Religions !');
        }

        return view('backend.pages.religions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('religion.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create Religions !');
        }

        // Validation Data
        $request->validate([
            'name' => 'required|max:50',
        ]);

        // // Create New Server Record
        // $dataObj = new Religion();
        // $dataObj->name = $request->name;
        // $dataObj->status = $request->status;
        // $dataObj->save();
        $this->StoreUpdateData($request);

        session()->flash('success', 'Record has been created !!');
        return redirect()->route('admin.religion.index');
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
        if (is_null($this->user) || !$this->user->can('religion.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit Religions !');
        }

        $data = Religion::find($id);
        return view('backend.pages.religions.edit', compact('data'));
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
        if (is_null($this->user) || !$this->user->can('religion.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit Religions !');
        }

        // Validation Data
        $request->validate([
            'name' => 'required|max:50',
        ]);

        // // Create New Server Record
        // $dataObj = Religion::find($id);
        // $dataObj->name = $request->name;
        // $dataObj->status = $request->status;
        // $dataObj->save();
         $this->StoreUpdateData($request, $id);
        session()->flash('success', 'Records has been updated !!');
        return redirect()->route('admin.religion.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        if (is_null($this->user) || !$this->user->can('religion.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete Religions !');
        }

        $dataObj = Religion::find($id);
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
        $dataObj = $id ? Religion::findOrFail($id) : new Religion();


        // Create New Server Record 
        $dataObj->name = $request->name;
        $dataObj->status = $request->status;
        $dataObj->save();

        return $dataObj;
    }
}
