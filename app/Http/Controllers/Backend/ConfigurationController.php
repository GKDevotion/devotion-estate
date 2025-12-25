<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Configuration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ConfigurationController extends Controller
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
        $dataArr = Configuration::get();
        return view('backend.pages.configurations.index', compact('dataArr'));
    }

    public function ajaxIndex(Request $request)
    {

        $this->setPublicVar();

        $query = Configuration::query();

        if (!$this->is_assign_super_admin) {
            $query->where('admin_id', $this->admin_id);
        }

        $query->select('id', 'display_name', 'key', 'value', 'updated_at');

        return DataTables::eloquent($query)
            ->addColumn('id', function (Configuration $ar) {
                return $ar->id;
            })
            ->addColumn('display_name', function (Configuration $ar) {
                return $ar->display_name;
            })
            ->addColumn('key', function (Configuration $ar) {
                return $ar->key;
            })

            ->addColumn('value', function (Configuration $ar) {
                return $ar->value;
            })


            ->addColumn('updated_at', function (Configuration $ar) {
                return formatDate("Y-m-d H:i", $ar->updated_at);
            })
            ->addColumn('action', function (Configuration $ar) {

                $action = '
                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="action_menu_' . $ar->id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        &#x22EE;
                    </button>
                    <div class="dropdown-menu" aria-labelledby="action_menu_' . $ar->id . '">
                    ';

                if ($this->user->can('configurations.edit')) {
                    $action .= '<a class="btn btn-edit text-white dropdown-item" href="' . route('admin.configurations.edit', $ar->id) . '">
                            <i class="fa fa-pencil"></i> Edit
                        </a>';
                }

                if ($this->user->can('configurations.delete')) {
                    $action .= '<button class="btn btn-edit text-white delete-record dropdown-item" data-id="' . $ar->id . '" data-title="' . $ar->display_name . '" data-segment="configurations">
                    <i class="fa fa-trash fa-sm" aria-hidden="true"></i> Delete
                    </button>';
                }

                $action .= '
                    </div>
                ';

                return $action;
            })
            ->rawColumns(['id', 'display_name', 'key', 'value', 'updated_at', 'action'])  // Specify the columns that contain HTML
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
        return view('backend.pages.configurations.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validation Data
        $request->validate([
            'display_name' => 'required',
            'key' => 'required',
            'value' => 'required',
        ]);

        $dataObj = new Configuration();
        $dataObj->display_name = $request->display_name;
        $dataObj->key = $request->key;
        $dataObj->value = $request->value;
        $dataObj->save();

        session()->flash('success', $dataObj->key . ' has been created !!');
        return redirect()->route('admin.configurations.index');
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
        $data = Configuration::find($id);
        return view('backend.pages.configurations.edit', compact('data'));
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
        $request->validate([
            'display_name' => 'required',
            'key' => 'required',
            'value' => 'required',
        ]);

        $dataObj = Configuration::find($id);
        $dataObj->display_name = $request->display_name;
        $dataObj->key = $request->key;
        $dataObj->value = $request->value;
        $dataObj->save();

        session()->flash('success', $dataObj->key . ' has been updated !!');
        return redirect()->route('admin.configurations.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $dataObj = Configuration::find($id);
        if (!is_null($dataObj)) {
            $dataObj->delete();
        }

        // session()->flash('success', $dataObj->name.' menu has been deleted !!');
        return response()->json(['data' => ['message' => "'" . $dataObj->key . '" has been successfully deleted.']], 200);
    }
}
