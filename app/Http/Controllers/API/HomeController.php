<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Company;
use App\Models\CorporateEmail;
use App\Models\LaptopRecord;
use App\Models\MobileRecord;
use App\Models\Permission;
use App\Models\Person;
use App\Models\RoleHasPermission;
use App\Models\ServerRecord;
use App\Models\SimRecord;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class HomeController extends BaseController
{
    protected $typeArr = [
        '',
        "employee",
        "customer",
        "client",
        "user"
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): JsonResponse
    {
        $dataObjs = LaptopRecord::all();
    
        return $this->sendResponse(LaptopRecordResource::collection($dataObjs), 'Records retrieved successfully.');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function sideListMenu(): JsonResponse
    {
        $sideMenuArr = [];

        $user = Auth::user();
        $roleObj = Role::where( 'slug', $this->typeArr[$user->type] )->first();

        foreach( getAdminSideMenu() as $menu ){
            
            $permissionIdObj = Permission::where( [
                                'guard_name' => $this->typeArr[$user->type],
                                'group_name' => $menu['group_name']
                                ] )
                                ->select( 'id' )
                                ->first();
            
            if( ( $permissionIdObj || $menu['class_name'] == "/" ) && COUNT( $menu['childArr'] ) > 0 ){
                
                $childArr = $this->sideChildListMenu( $menu['childArr'], $this->typeArr[$user->type], $roleObj );

                if( $childArr ){
                    $menuArr['id'] = $menu['id'];
                    $menuArr['title'] = $menu['name'];
                    $menuArr['sort_order'] = $menu['sort_order'];
                    $menuArr['child'] = $childArr;
                    $menuArr['slug'] = $menu['slug'];
                    $menuArr['group_name'] = $menu['group_name'];
                    $menuArr['function'] = pgTitle( $menu['group_name'] );
                    $menuArr['icon'] = $this->getImages( $menu['icon'] );

                    $sideMenuArr[] = $menuArr;
                }
            } 
        }

        return $this->sendResponse( $sideMenuArr, 'Records retrieved successfully.');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function sideChildListMenu( $childArr, $permissionGroupNameArr, $permissionIdArr, $roleObj )
    public function sideChildListMenu( $childArr, $guard_name, $roleObj )
    {
        $sideMenuArr = [];
        foreach( $childArr as $menu ){

            $permissionIdObj = Permission::where([
                                'guard_name' => $guard_name,
                                'group_name' => $menu['group_name'],
                                'name' => $menu['group_name'].".view"
                            ])
                            ->select( 'id' )
                            ->first();

            if( $permissionIdObj ){
                $roleHasPermission = RoleHasPermission::where( [
                                        'role_id' => $roleObj->id,
                                        'permission_id' => $permissionIdObj->id
                                    ] )
                                    ->first();
                                    
                if( $roleHasPermission ){
                    $menuArr['id'] = $menu['id'];
                    $menuArr['title'] = $menu['name'];
                    $menuArr['sort_order'] = $menu['sort_order'];
                    $menuArr['slug'] = $menu['slug'];
                    $menuArr['group_name'] = $menu['group_name'];
                    $menuArr['function'] = pgTitle( $menu['group_name'] );
                    $menuArr['icon'] = $this->getImages( $menu['icon'] );

                    $menuArr['view'] = $menuArr['create'] = $menuArr['edit'] = $menuArr['delete'] = 0;

                    $role = Role::find( $roleObj->id );

                    $permissions = User::getpermissionsByGroupName( $menu['group_name'], $role->guard_name);
                    foreach ($permissions as $permission){
                        if( $role->hasPermissionTo($permission->name) && $permission->name === $menu['group_name'].".view" ){
                            $menuArr['view'] = 1;
                        }

                        if( $role->hasPermissionTo($permission->name) && $permission->name === $menu['group_name'].".create" ){
                            $menuArr['create'] = 1;
                        }

                        if( $role->hasPermissionTo($permission->name) && $permission->name === $menu['group_name'].".edit" ){
                            $menuArr['edit'] = 1;
                        }

                        if( $role->hasPermissionTo($permission->name) && $permission->name === $menu['group_name'].".delete" ){
                            $menuArr['delete'] = 1;
                        }
                    }

                    $sideMenuArr[] = $menuArr;
                }
            }
        }

        return $sideMenuArr;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard(): JsonResponse
    {
        $user = Auth::user();
        $guard_name = $this->typeArr[$user->type];
        $role = Role::where( 'slug', $guard_name )->first();
        // $role = Role::find( $roleObj->id );

        $dataObjs = [
            [
                'id' => 1,
                'title' => 'Companies',
                'total' => Company::where( 'status', 1 )->count(),
                'sort_order' => 1,
                'icon' => 'keyboard_arrow_up_rounded',
                'image' => url('public/backend/assets/images/icon/app/company.png'),
                'slug' => 'company',
                'function' => "Company",
                'permission' => $this->dashboardPermission( $role, 'company' ),
            ],
            [
                'id' => 2,
                'title' => 'Corporate Emails',
                'total' => CorporateEmail::where( 'status', 1 )->count(),
                'sort_order' => 5,
                'icon' => 'keyboard_arrow_up_rounded',
                'image' => url('public/backend/assets/images/icon/app/email.png'),
                'slug' => 'corporate-emails',
                'function' => "CorporateEmail",
                'permission' => $this->dashboardPermission( $role, 'corporate-email' ),
            ],
            [
                'id' => 3,
                'title' => 'Employee',
                'total' => Person::select('id')->where('type',1)->count(),
                'sort_order' => 15,
                'icon' => 'keyboard_arrow_up_rounded',
                'image' => url('public/backend/assets/images/icon/app/employee.png'),
                'slug' => 'employee',
                'function' => 'Employee',
                'permission' => $this->dashboardPermission( $role, 'employee' ),
            ],
            [
                'id' => 4,
                'title' => 'Laptop Records',
                'total' => LaptopRecord::where( 'status', 1 )->count(),
                'sort_order' => 20,
                'icon' => 'keyboard_arrow_up_rounded',
                'image' => url('public/backend/assets/images/icon/app/laptop.png'),
                'slug' => 'laptop-records',
                'function' => 'LaptopRecord',
                'permission' => $this->dashboardPermission( $role, 'laptop-record' ),
            ],
            [
                'id' => 5,
                'title' => 'Mobile Records',
                'total' => MobileRecord::where( 'status', 1 )->count(),
                'sort_order' => 25,
                'icon' => 'keyboard_arrow_up_rounded',
                'image' => url('public/backend/assets/images/icon/app/mobile.png'),
                'slug' => 'mobile-records',
                'function' => 'MobileRecord',
                'permission' => $this->dashboardPermission( $role, 'mobile-record' ),
            ],
            [
                'id' => 6,
                'title' => 'Server Records',
                'total' => ServerRecord::where( 'status', 1 )->count(),
                'sort_order' => 30,
                'icon' => 'keyboard_arrow_up_rounded',
                'image' => url('public/backend/assets/images/icon/app/server.png'),
                'slug' => 'server-records',
                'function' => 'ServerRecord',
                'permission' => $this->dashboardPermission( $role, 'server-record' ),
            ],
            [
                'id' => 7,
                'title' => 'Sim Records',
                'total' => SimRecord::where( 'status', 1 )->count(),
                'sort_order' => 35,
                'icon' => 'keyboard_arrow_up_rounded',
                'image' => url('public/backend/assets/images/icon/app/sim-card.png'),
                'slug' => 'sim-records',
                'function' => 'SimRecord',
                'permission' => $this->dashboardPermission( $role, 'sim-record' ),
            ]
        ];
    
        return $this->sendResponse( $dataObjs, 'Records retrieved successfully.');
    }

    /**
     * 
     */
    public function dashboardPermission( $role, $group_name ){

        $menuArr['view'] = $menuArr['create'] = $menuArr['edit'] = $menuArr['delete'] = 0;

        $permissions = User::getpermissionsByGroupName( $group_name, $role->guard_name);
        if( $permissions ){
            foreach ($permissions as $permission){
                if( $role->hasPermissionTo($permission->name) && $permission->name === $group_name.".view" ){
                    $menuArr['view'] = 1;
                }

                if( $role->hasPermissionTo($permission->name) && $permission->name === $group_name.".create" ){
                    $menuArr['create'] = 1;
                }

                if( $role->hasPermissionTo($permission->name) && $permission->name === $group_name.".edit" ){
                    $menuArr['edit'] = 1;
                }

                if( $role->hasPermissionTo($permission->name) && $permission->name === $group_name.".delete" ){
                    $menuArr['delete'] = 1;
                }
            }
        }

        return $menuArr;
    }

    /**
     * @param [type] $imagesObject
     * @return void
     */
    public function getImages($image)
    {
        return url('public/backend/assets/images/icon/'.str_ireplace( " ", "-", $image ).'.png');
    }

    
}