<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AdminLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class AdminLogController extends Controller
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
    public function setPublicVar(){
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
        if (is_null($this->user) || !$this->user->can('admin-log.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any payroll !');
        }

        $this->setPublicVar();
        return view('backend.pages.admin-log.index');
    }

    /**
     * 
     */
    public function ajaxIndex(){

        $this->setPublicVar();
        
        $where = [];
        if( !$this->is_assign_super_admin ){
            $where['admin_id'] = $this->admin_id;
        }

        $query = AdminLog::query();

        $query->where( $where );
        $query->select('id', 'admin_id', 'table_name', 'parent_table_pk_id', 'action', 'log_ip', 'primary_id', 'description', 'created_at');
        return DataTables::eloquent($query)
            ->addColumn('id', function(AdminLog $obj) {
                return $obj->id;
            })
            ->addColumn('name', function(AdminLog $obj) {
                return $obj->admin->username;
            })
            ->addColumn('table', function(AdminLog $obj) {
                return $obj->table_name;
            })
            ->addColumn('field', function(AdminLog $obj) {
                return $obj->table_field;
            })
            ->addColumn('action', function(AdminLog $obj) {
                return $obj->action;
            })
            ->addColumn('ip_address', function(AdminLog $obj) {
                return $obj->log_ip;
            })
            ->addColumn('pk_table_id', function(AdminLog $obj) {
                return $obj->parent_table_pk_id;
            })
            ->addColumn('child_table_id', function(AdminLog $obj) {
                return $obj->primary_id;
            })
            ->addColumn('description', function(AdminLog $obj) {
                return $obj->description;
            })
            ->addColumn('created_at', function(AdminLog $obj) {
                return formatDate( "Y-m-d H:i", $obj->created_at );
            })
            ->rawColumns(['id', 'name', 'pk_table_id', 'child_table_id', 'created_at'])  // Specify the columns that contain HTML
            ->filter(function ($query) {
                if (request()->has('search')) {
                    $searchValue = request('search')['value'];
                    $query
                        ->orWhereHas('user', function($q) use ($searchValue) {
                            $q->where('name', 'like', "%{$searchValue}%");
                        });
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
        if (is_null($this->user) || !$this->user->can('admin-log.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any payroll !');
        }

        return response()->json(['message' => 'has been created!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // return view('backend.pages.admin-log.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        if (is_null($this->user) || !$this->user->can('admin-log.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any payroll !');
        }

        // return view('backend.pages.admin-log.edit');
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
        if (is_null($this->user) || !$this->user->can('admin-log.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any payroll !');
        }

        session()->flash('success', 'has been updated !!');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        if (is_null($this->user) || !$this->user->can('admin-log.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete any payroll !');
        }

        return response()->json( ['data' => ['message' => 'Record already deleted.' ] ], 200);
    }
}
