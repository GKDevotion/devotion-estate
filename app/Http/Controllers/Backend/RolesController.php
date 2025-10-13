<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\RoleGuard;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesController extends Controller
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
        if (is_null($this->user) || !$this->user->can('role.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view Role !');
        }

        $roles = Role::all();
        return view('backend.pages.roles.index', compact('roles'));
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
        $role_guardObj = RoleGuard::where( 'status', 1 )->get();

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

        $slug = convertStringToSlug( $request->name );
        
        // Process Data
        $role = Role::create( ['name' => $request->name, 'slug' => $slug, 'guard_name' => $request->guard_name] );

        $permissions = $request->input('permissions');

        if (!empty($permissions)) {
            foreach( $permissions as $per ){
                $group_nameArr = explode( ".", $per );
                Permission::create([
                    'name' => $per,
                    'guard_name' => $request->guard_name, // Use the appropriate guard name
                    'group_name' => $group_nameArr[0]
                ]);
            }

            $role->syncPermissions($permissions);
        }

        session()->flash('success', $request->name.' role has been created !!');
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
        $all_permissions = Permission::where( 'guard_name', $role->guard_name )->get();
        $permission_groups = User::getpermissionGroups( $role->guard_name );
        $role_guardObj = RoleGuard::where( 'status', 1 )->get();
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

        $role = Role::find( $id );
        $permissions = $request->input('permissions');
        
        if (!empty($permissions)) {
            $role->name = $request->name;
            $role->slug = convertStringToSlug( $request->name );
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

        session()->flash('success', $request->name.' role has been updated !!');
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

        return response()->json( ['data' => ['message' => 'Record has been successfully deleted.' ] ], 200);
    }
}
