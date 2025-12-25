<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;

class MenuController extends Controller
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
        if (is_null($this->user) || !fetchSinglePermission($this->user, 'admin.menu', 'view')) {
            // if (is_null($this->user) || !$this->user->can('menu.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view this !');
        }

        $dataArr = AdminMenu::select('id', 'parent_id', 'name', 'slug', 'group_name', 'class_name', 'sort_order', 'status', 'updated_at')->get();
        return view('backend.pages.menu.index', compact('dataArr'));
    }

    public function ajaxIndex(Request $request)
    {

        $this->setPublicVar();

        $query = AdminMenu::query();

        if (!$this->is_assign_super_admin) {
            $query->where('admin_id', $this->admin_id);
        }

        $query->select('id', 'name', 'slug', 'group_name', 'class_name', 'sort_order', 'status', 'updated_at');

        return DataTables::eloquent($query)
            ->addColumn('id', function (AdminMenu $ar) {
                return $ar->id;
            })
            ->addColumn('name', function (AdminMenu $ar) {
                return $ar->name;
            })
            ->addColumn('slug', function (AdminMenu $ar) {
                return $ar->slug;
            })
            ->addColumn('group_name', function (AdminMenu $ar) {
                return $ar->group_name;
            })
            ->addColumn('class_name', function (AdminMenu $ar) {
                return $ar->class_name;
            })
            ->addColumn('sort_order', function (AdminMenu $ar) {
                return $ar->sort_order;
            })
            ->addColumn('status', function (AdminMenu $dt) {
                $status = "";
                if (true) {
                    $status = '<i class="fa fa-' . ($dt->status == 0 ? 'times' : 'check') . ' update-status" data-status="' . $dt->status . '" data-id="' . $dt->id . '" aria-hidden="true" data-table="admin_menus"></i>';
                } else {
                    $status = '<select class="form-control update-status badge ' . ($dt->status == 0 ? 'bg-warning' : 'bg-success') . ' text-white" name="status" data-id="' . $dt->id . '" data-table="admin_menus">
                            <option value="1" ' . ($dt->status == 1 ? 'selected' : '') . '>Active</option>
                            <option value="0" ' . ($dt->status == 0 ? 'selected' : '') . '>De-Active</option>
                        </select>';
                }

                return $status;
            })
            ->addColumn('updated_at', function (AdminMenu $ar) {
                return formatDate("Y-m-d H:i", $ar->updated_at);
            })
            ->addColumn('action', function (AdminMenu $ar) {

                $action = '
                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="action_menu_' . $ar->id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        &#x22EE;
                    </button>
                    <div class="dropdown-menu" aria-labelledby="action_menu_' . $ar->id . '">
                    ';

                if ($this->user->can('menu.edit')) {
                    $action .= '<a class="btn btn-edit text-white dropdown-item" href="' . route('admin.menu.edit', $ar->id) . '">
                            <i class="fa fa-pencil"></i> Edit
                        </a>';
                }

                if ($this->user->can('menu.delete')) {
                    $action .= '<button class="btn btn-edit text-white delete-record dropdown-item" data-id="' . $ar->id . '" data-title="' . $ar->name . '" data-segment="menu">
                    <i class="fa fa-trash fa-sm" aria-hidden="true"></i> Delete
                    </button>';
                }

                $action .= '
                    </div>
                ';

                return $action;
            })
            ->rawColumns(['id', 'name',  'slug', 'group_name', 'class_name', 'sort_order', 'status', 'updated_at', 'action'])  // Specify the columns that contain HTML
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
        if (is_null($this->user) || !$this->user->can('admin.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any menu !');
        }

        // $menuArr  = AdminMenu::select( 'id', 'name' )->get();
        return view('backend.pages.menu.create'); //, compact('menuArr'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('admin.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any menu !');
        }

        // Validation Data
        $request->validate([
            'name' => 'required',
            'class_name' => 'required',
            'parent_id' => 'required',
            'status' => 'required',
        ]);

        $adminMenu = new AdminMenu();
        $adminMenu->class_name = $request->class_name;
        $adminMenu->parent_id = $request->parent_id;
        $adminMenu->name = $request->name;
        $adminMenu->slug = convertStringToSlug($request->name);
        $adminMenu->group_name = $request->group_name;
        $adminMenu->icon = $request->icon;
        $adminMenu->status = $request->status;
        $adminMenu->sort_order = $request->sort_order;
        $adminMenu->save();

        /**
         * Add Menu Permission
         */
        $permissionArr = [
            'create',
            'view',
            'edit',
            'delete'
        ];

        $admin = Admin::where('username', 'superadmin')->first();
        $roleSuperAdmin = $this->maybeCreateSuperAdminRole($admin);

        foreach ($permissionArr as $permission) {

            $guardNameArr = [
                // 'employee',
                // 'customer',
                // 'client',
                // 'user',
                'admin',
                // 'hr'
            ];

            foreach ($guardNameArr as $guard_name) {
                // $permission = Permission::create(
                //     [
                //         'name' => $request->group_name.".".$permission,
                //         'group_name' => $request->group_name,
                //         'guard_name' => $guard_name
                //     ]
                // );
                $permission = Permission::updateOrCreate(
                    [
                        // These columns are used to find the existing record
                        'name' => $request->group_name . "." . $permission,
                    ],
                    [
                        // These columns are updated or set when creating
                        'group_name' => $request->group_name,
                        'guard_name' => $guard_name,
                    ]
                );

                $roleSuperAdmin->givePermissionTo($permission);
                $permission->assignRole($roleSuperAdmin);
            }
        }

        //clear all cookie cache
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        Artisan::call('config:cache');

        session()->flash('success', $adminMenu->name . ' menu has been created !!');
        return redirect()->route('admin.menu.index');
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
        if (is_null($this->user) || !$this->user->can('admin.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any menu !');
        }

        $menuArr  = AdminMenu::select('id', 'name')->get();
        $data = AdminMenu::find($id);
        return view('backend.pages.menu.edit', compact('data', 'menuArr'));
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
        if (is_null($this->user) || !$this->user->can('admin.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to update any menu !');
        }

        $request->validate([
            'name' => 'required',
            'class_name' => 'required',
            'parent_id' => 'required',
            'status' => 'required',
        ]);

        $adminMenu = AdminMenu::find($id);
        $adminMenu->class_name = $request->class_name;
        $adminMenu->parent_id = $request->parent_id;
        $adminMenu->name = $request->name;
        $adminMenu->slug = convertStringToSlug($request->name);
        $adminMenu->group_name = $request->group_name;
        $adminMenu->icon = $request->icon;
        $adminMenu->status = $request->status;
        $adminMenu->sort_order = $request->sort_order;
        $adminMenu->save();

        //clear all cookie cache
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        Artisan::call('config:cache');

        session()->flash('success', $adminMenu->name . ' menu has been updated !!');
        return redirect()->route('admin.menu.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        if (is_null($this->user) || !$this->user->can('admin.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete any menu !');
        }

        $adminMenu = AdminMenu::find($id);
        if (!is_null($adminMenu)) {
            $adminMenu->delete();
        }

        // session()->flash('success', $adminMenu->name.' menu has been deleted !!');
        return response()->json(['data' => ['message' => "'" . $adminMenu->name . '" has been successfully deleted.']], 200);
    }

    public function maybeCreateSuperAdminRole($admin): Role
    {
        if (is_null($admin)) {
            $roleSuperAdmin = Role::create(['name' => 'superadmin', 'guard_name' => 'admin']);
        } else {
            $roleSuperAdmin = Role::where('name', 'superadmin')->where('guard_name', 'admin')->first();
        }

        if (is_null($roleSuperAdmin)) {
            $roleSuperAdmin = Role::create(['name' => 'superadmin', 'guard_name' => 'admin']);
        }

        return $roleSuperAdmin;
    }
}
