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

class MenuController extends Controller
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
        if( is_null($this->user) || !fetchSinglePermission( $this->user, 'admin.menu', 'view') ){
        // if (is_null($this->user) || !$this->user->can('menu.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view this !');
        }

        $dataArr = AdminMenu::select('id', 'parent_id', 'name', 'slug', 'group_name', 'class_name', 'sort_order', 'status', 'updated_at')->get();
        return view('backend.pages.menu.index', compact('dataArr'));
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
        return view('backend.pages.menu.create');//, compact('menuArr'));
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
        $adminMenu->slug = convertStringToSlug( $request->name );
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

        foreach( $permissionArr as $permission ){

            $guardNameArr = [
                // 'employee',
                // 'customer',
                // 'client',
                // 'user',
                'admin',
                // 'hr'
            ];

            foreach( $guardNameArr as $guard_name ){
                $permission = Permission::create(
                    [
                        'name' => $request->group_name.".".$permission,
                        'group_name' => $request->group_name,
                        'guard_name' => $guard_name
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

        session()->flash('success', $adminMenu->name.' menu has been created !!');
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

        $menuArr  = AdminMenu::select( 'id', 'name' )->get();
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

        $adminMenu = AdminMenu::find( $id );
        $adminMenu->class_name = $request->class_name;
        $adminMenu->parent_id = $request->parent_id;
        $adminMenu->name = $request->name;
        $adminMenu->slug = convertStringToSlug( $request->name );
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

        session()->flash('success', $adminMenu->name.' menu has been updated !!');
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
        return response()->json( ['data' => ['message' => "'".$adminMenu->name.'" has been successfully deleted.' ] ], 200);
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
