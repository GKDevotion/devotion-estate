<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use App\Models\Designations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class DesignationsController extends Controller
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
        if (is_null($this->user) || !$this->user->can('designations.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view Designation !');
        }

        // $dataArr = City::limit(1000)->get();
        return view('backend.pages.designations.index');
    }


    public function ajaxIndex()
    {
        $query = Designations::query();
        $query->select('id', 'name', 'sort_order', 'status', 'created_at', 'updated_at');

        return DataTables::eloquent($query)
            ->addColumn('id', function (Designations $dt) {
                return $dt->id;
            })
            ->addColumn('name', function (Designations $dt) {
                return $dt->name;
            })
            ->addColumn('sort_order', function (Designations $dt) {
                return $dt->sort_order; // Display the country name
            })
            ->addColumn('status', function (Designations $dt) {
                $status = "";
                if (true) {
                    $status = '<i class="fa fa-' . ($dt->status == 0 ? 'times' : 'check') . ' update-status" data-status="' . $dt->status . '" data-id="' . $dt->id . '" aria-hidden="true" data-table="brochures"></i>';
                } else {
                    $status = '<select class="form-control update-status badge ' . ($dt->status == 0 ? 'bg-warning' : 'bg-success') . ' text-white" name="status" data-id="' . $dt->id . '" data-table="brochures">
                            <option value="1" ' . ($dt->status == 1 ? 'selected' : '') . '>Active</option>
                            <option value="0" ' . ($dt->status == 0 ? 'selected' : '') . '>De-Active</option>
                        </select>';
                }

                return $status;
            })
            ->addColumn('updated_at', function (Designations $dt) {
                return formatDate("Y-m-d H:i", $dt->updated_at);
            })
            ->addColumn('action', function (Designations $dt) {

                $action = '
                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="action_menu_' . $dt->id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        &#x22EE;
                    </button>
                    <div class="dropdown-menu" aria-labelledby="action_menu_' . $dt->id . '">
                    ';

                if ($this->user->can('designations.edit')) {
                    $action .= '<a class="btn btn-edit text-white dropdown-item" href="' . route('admin.designations.edit', $dt->id) . '">
                            <i class="fa fa-pencil"></i> Edit
                        </a>';
                }

                if ($this->user->can('designations.delete')) {
                    $action .= '<button class="btn btn-edit text-white delete-record dropdown-item" data-id="' . $dt->id . '" data-title="' . $dt->name . '" data-segment="brochures">
                                        <i class="fa fa-trash fa-sm" aria-hidden="true"></i> Delete
                                    </button>';
                }
                $action .= '
                    </div>
                ';


                return $action;
            })
            ->rawColumns(['id',  'name', 'sort_order', 'status', 'created_at', 'updated_at', 'action'])  // Specify the columns that contain HTML
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
        if (is_null($this->user) || !$this->user->can('designations.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create Designations !');
        }

        return view('backend.pages.designations.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('designations.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create Designation !');
        }

        // Validation Data
        $request->validate([
            'name' => 'required',
        ]);

        // Create New Server Record
        $dataObj = new Designations();
        $dataObj->name = $request->name;
        $dataObj->admin_id = $this->user->id;
        $dataObj->slug = convertStringToSlug( $request->name );
        $dataObj->sort_order  = $request->sort_order;
        $dataObj->status = $request->status;
        $dataObj->save();

        session()->flash('success', $dataObj->name . ' record has been created !!');
        return redirect()->route('admin.designations.index');
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
        if (is_null($this->user) || !$this->user->can('designations.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit Designation !');
        }

        $data = Designations::find($id);
        return view('backend.pages.designations.edit', compact('data'));
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
        if (is_null($this->user) || !$this->user->can('designations.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit City !');
        }

        // Validation Data
        $request->validate([
            'name' => 'required',
        ]);

        // Create New Server Record
        $dataObj = Designations::find($id);
        $dataObj->name = $request->name;
        $dataObj->admin_id = $this->user->id;
        $dataObj->slug = convertStringToSlug( $request->name );
        $dataObj->sort_order  = $request->sort_order;
        $dataObj->save();

        session()->flash('success', $dataObj->name . ' records has been updated !!');
        return redirect()->route('admin.designations.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        if (is_null($this->user) || !$this->user->can('designations.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete Designations !');
        }

        $dataObj = Designations::find($id);
        if ($dataObj) {
            $dataObj->delete();
            return response()->json(['data' => ['message' => $dataObj->name . ' record has been successfully deleted.']], 200);
        } else {
            return response()->json(['data' => ['message' => 'Record already deleted.']], 200);
        }
    }
}
