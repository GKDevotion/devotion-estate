<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\RoleGuard;
use App\Models\RoleHasPermission;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;

class RolesController extends Controller
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
        if (is_null($this->user) || !$this->user->can('role.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view Role !');
        }

        $roles = Role::all();
        return view('backend.pages.roles.index', compact('roles'));
    }

    public function ajaxIndex(Request $request)
    {

        $this->setPublicVar();

        $query = Role::query();

        if (!$this->is_assign_super_admin) {
            $query->where('admin_id', $this->admin_id);
        }

        $query->select('id', 'name', 'status', 'updated_at');

        return DataTables::eloquent($query)
            ->addColumn('id', function (Role $ar) {
                return $ar->id;
            })
            ->addColumn('name', function (Role $ar) {
                return $ar->name;
            })

            ->addColumn('permissions', function ($role) {

                $checkGroup = [];
                $html = '';

                foreach ($role->permissions as $perm) {
                    if (!in_array($perm->group_name, $checkGroup)) {

                        $title = pgTitle(substr($perm->name, 0, strpos($perm->name, '.')));

                        $html .= '<span class="badge badge-info mr-1">'
                            . e($title)
                            . '</span>';

                        $checkGroup[] = $perm->group_name;
                    }
                }

                return $html;
            })


            ->addColumn('status', function (Role $dt) {
                $status = "";
                if (true) {
                    $status = '<i class="fa fa-' . ($dt->status == 0 ? 'times' : 'check') . ' update-status" data-status="' . $dt->status . '" data-id="' . $dt->id . '" aria-hidden="true" data-table="religions"></i>';
                } else {
                    $status = '<select class="form-control update-status badge ' . ($dt->status == 0 ? 'bg-warning' : 'bg-success') . ' text-white" name="status" data-id="' . $dt->id . '" data-table="roles">
                            <option value="1" ' . ($dt->status == 1 ? 'selected' : '') . '>Active</option>
                            <option value="0" ' . ($dt->status == 0 ? 'selected' : '') . '>De-Active</option>
                        </select>';
                }

                return $status;
            })

            ->addColumn('updated_at', function (Role $ar) {
                return formatDate("Y-m-d H:i", $ar->updated_at);
            })
            ->addColumn('action', function (Role $ar) {

                $action = '
                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="action_menu_' . $ar->id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        &#x22EE;
                    </button>
                    <div class="dropdown-menu" aria-labelledby="action_menu_' . $ar->id . '">
                    ';

                if ($this->user->can('role.edit')) {
                    $action .= '<a class="btn btn-edit text-white dropdown-item" href="' . route('admin.role.edit', $ar->id) . '">
                            <i class="fa fa-pencil"></i> Edit
                        </a>';
                }

                if ($this->user->can('role.delete')) {
                    $action .= '<button class="btn btn-edit text-white delete-record dropdown-item" data-id="' . $ar->id . '" data-title="' . $ar->name . '" data-segment="roles">
                    <i class="fa fa-trash fa-sm" aria-hidden="true"></i> Delete
                    </button>';
                }

                $action .= '
                    </div>
                ';

                return $action;
            })
            ->rawColumns(['id', 'name','permissions', 'status', 'updated_at', 'action'])  // Specify the columns that contain HTML
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
        if (is_null($this->user) || !$this->user->can('role.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create Role !');
        }

        $all_permissions  = Permission::all();
        $permission_groups = User::getpermissionGroups();
        $role_guardObj = RoleGuard::where('status', 1)->get();

        return view('backend.pages.roles.create', compact('all_permissions', 'permission_groups', 'role_guardObj'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('role.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create Role !');
        }

        // Validation Data
        $request->validate([
            'name' => 'required|max:100|unique:roles'
        ], [
            'name.requried' => 'Please give a role name',
        ]);

        $slug = convertStringToSlug($request->name);

        // Process Data
        $role = Role::create(['name' => $request->name, 'slug' => $slug, 'guard_name' => $request->guard_name]);

        $permissions = $request->input('permissions');

        if (!empty($permissions)) {
            foreach ($permissions as $per) {
                $group_nameArr = explode(".", $per);
                Permission::create([
                    'name' => $per,
                    'guard_name' => $request->guard_name, // Use the appropriate guard name
                    'group_name' => $group_nameArr[0]
                ]);
            }

            $role->syncPermissions($permissions);
        }

        session()->flash('success', $request->name . ' role has been created !!');
        return redirect()->route('admin.role.index');
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
        if (is_null($this->user) || !$this->user->can('role.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit Role !');
        }

        $role = Role::find($id);
        $all_permissions = Permission::where('guard_name', $role->guard_name)->get();
        $permission_groups = User::getpermissionGroups($role->guard_name);
        $role_guardObj = RoleGuard::where('status', 1)->get();
        return view('backend.pages.roles.edit', compact('role', 'all_permissions', 'permission_groups', 'role_guardObj'));
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
        if (is_null($this->user) || !$this->user->can('role.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit Role !');
        }

        // Validation Data
        $request->validate([
            'name' => 'required|max:100|unique:roles,name,' . $id
        ], [
            'name.requried' => 'Please give a role name'
        ]);

        $role = Role::find($id);
        $permissions = $request->input('permissions');

        if (!empty($permissions)) {
            $role->name = $request->name;
            $role->slug = convertStringToSlug($request->name);
            $role->guard_name = $request->guard_name;
            $role->save();

            // foreach( $permissions as $per ){
            //     $group_nameArr = explode( ".", $per );
            //     Permission::updateOrCreate(
            //         [
            //             'name' => $per,
            //             'guard_name' => $request->guard_name, // Use the appropriate guard name
            //             'group_name' => $group_nameArr[0]
            //         ],
            //         [
            //             'name' => $per,
            //         ]
            //     );
            // }

            $role->syncPermissions($permissions);
        }

        session()->flash('success', $request->name . ' role has been updated !!');
        return redirect()->route('admin.role.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        if (is_null($this->user) || !$this->user->can('role.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete Role !');
        }

        $role = Role::find($id);
        if (!is_null($role)) {

            Permission::where([
                'guard_name' => $role->guard_name
            ])
                ->delete();

            RoleHasPermission::where([
                'role_id' => $role->id
            ])
                ->delete();

            DB::table('Roles')->where('id', $role->id)->delete();
        }

        return response()->json(['data' => ['message' => 'Record has been successfully deleted.']], 200);
    }
}
