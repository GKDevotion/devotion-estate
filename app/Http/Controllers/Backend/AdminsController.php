<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\City;
use App\Models\Company;
use App\Models\Continent;
use App\Models\Country;
use App\Models\Religion;
use App\Models\ScheduleList;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminsController extends Controller
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
    public function index( Request $request )
    {
        if (is_null($this->user) || !$this->user->can('admin.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any admin !');
        }

        $where = [];

        $admins = Cache::remember('admins', 10, function () use ($where) {
            return Admin::where( $where )->get();
        });
        return view('backend.pages.admins.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (is_null($this->user) || !$this->user->can('admin.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any admin !');
        }

        $roles  = Role::all();
        $companies  = Company::select('id', 'name')->where(['status' => 1])->get();
        $religionArr  = Religion::select('id', 'name')->where(['status' => 1])->get();
        $continentArr = Continent::select('id', 'name')->where( [ 'status' => 1] )->get();
        return view('backend.pages.admins.create', compact('roles', 'companies', 'religionArr', 'continentArr'));
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
            abort(403, 'Sorry !! You are Unauthorized to create any admin !');
        }

        // Validation Data
        $request->validate([
            'first_name' => 'required|max:25',
            'middle_name' => 'required|max:25',
            'last_name' => 'required|max:25',
            'username' => 'required|max:100|unique:admins',
            'email' => 'required|max:100|email|unique:admins',
            'password' => 'required|min:6|confirmed',
            'mobile_number' => 'required',
            'continent_id' => 'required',
            'country_id' => 'required',
            'state_id' => 'required',
            'city_id' => 'required',
            'address' => 'required',
            'zipcode' => 'required',
            'company_id' => 'required',
        ]);

        // Create New Admin
        $admin = new Admin();
        $admin->password = Hash::make($request->password);
        $admin->first_name = $request->first_name;
        $admin->middle_name = $request->middle_name;
        $admin->last_name = $request->last_name;
        $admin->username = $request->username;
        $admin->email = $request->email;
        $admin->mobile_number = $request->mobile_number;
        $admin->continent_id = $request->continent_id;
        $admin->country_id = $request->country_id;
        $admin->city_id = $request->city_id;
        $admin->address = $request->address;
        $admin->zipcode = $request->zipcode;

        $isSuperadmin = 0;

        if( $request->roles[0] === "superadmin" ){
            $isSuperadmin = 1;
        }

        $admin->is_assign_super_admin = $isSuperadmin;
        $admin->company_id = $request->company_id;
        $admin->industry_id = getField( 'companies', 'id', 'industry_id', $request->company_id );
        $admin->status = $request->status;
        $admin->save();

        if ($request->roles) {
            $admin->assignRole($request->roles);
        }

        session()->flash('success', $admin->username.' has been created !!');
        return redirect()->route('admin.admin.index');
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
            abort(403, 'Sorry !! You are Unauthorized to edit any admin !');
        }

        $admin = Admin::find($id);
        $roles  = Role::all();
        $companies  = Company::select('id', 'name')->where(['status' => 1])->get();
        $religionArr  = Religion::select('id', 'name')->where(['status' => 1])->get();
        $continentArr = Continent::select('id', 'name')->where( [ 'status' => 1 ] )->get();
        $countryArr = Country::select('id', 'name')->where( [ 'status' => 1, 'continent_id' => $admin->continent_id ] )->get();
        $stateArr = State::select('id', 'name')->where( [ 'status' => 1, 'country_id' => $admin->country_id, 'continent_id' => $admin->continent_id ] )->get();
        $cityArr = City::select('id', 'name')->where( [ 'status' => 1, 'state_id' => $admin->state_id, 'continent_id' => $admin->continent_id ] )->get();
        return view('backend.pages.admins.edit', compact('admin', 'roles', 'companies', 'religionArr', 'continentArr', 'countryArr', 'stateArr', 'cityArr'));
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
            abort(403, 'Sorry !! You are Unauthorized to edit any admin !');
        }

        // TODO: You can delete this in your local. This is for heroku publish.
        // This is only for Super Admin role,
        // so that no-one could delete or disable it by somehow.
        // if ($id === 1) {
        //     session()->flash('error', 'Sorry !! You are not authorized to update this Admin as this is the Super Admin. Please create new one if you need to test !');
        //     return back();
        // }

        // Create New Admin
        $admin = Admin::find($id);

        // Validation Data
        $request->validate([
            'email' => 'required|max:100|email|unique:admins,email,'.$id,
            'password' => 'nullable|min:6|confirmed',
            'first_name' => 'required|max:25',
            'middle_name' => 'required|max:25',
            'last_name' => 'required|max:25',
            'username' => 'required|max:100|unique:admins,username,'.$id,
            'mobile_number' => 'required',
            'continent_id' => 'required',
            'country_id' => 'required',
            'state_id' => 'required',
            'city_id' => 'required',
            'address' => 'required',
            'zipcode' => 'required',
            'company_id' => 'required',
        ]);

        $admin->first_name = $request->first_name;
        $admin->middle_name = $request->middle_name;
        $admin->last_name = $request->last_name;
        $admin->username = $request->username;
        $admin->email = $request->email;
        $admin->mobile_number = $request->mobile_number;
        $admin->continent_id = $request->continent_id;
        $admin->country_id = $request->country_id;
        $admin->city_id = $request->city_id;
        $admin->address = $request->address;
        $admin->zipcode = $request->zipcode;

        $isSuperadmin = 0;

        if( $request->roles[0] === "superadmin" ){
            $isSuperadmin = 1;
        }

        $admin->is_assign_super_admin = $isSuperadmin;
        $admin->company_id = $request->company_id;
        $admin->industry_id = getField( 'companies', 'id', 'industry_id', $request->company_id );
        $admin->status = $request->status;

        if ($request->password) {
            $admin->password = Hash::make($request->password);
        }
        $admin->save();

        $admin->roles()->detach();
        if ($request->roles) {
            $admin->assignRole($request->roles);
        }

        session()->flash('success', $request->username.' has been updated !!');
        return redirect()->route('admin.admin.index');
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
            abort(403, 'Sorry !! You are Unauthorized to delete any admin !');
        }

        // TODO: You can delete this in your local. This is for heroku publish.
        // This is only for Super Admin role,
        // so that no-one could delete or disable it by somehow.
        if ($id === 1) {
            session()->flash('error', 'Sorry !! You are not authorized to delete this Admin as this is the Super Admin. Please create new one if you need to test !');
            return back();
        }

        $admin = Admin::find($id);
        if (!is_null($admin)) {
            $admin->delete();
        }

        session()->flash('success', 'Admin has been deleted !!');
        return back();
    }

    /**
     *
     */
    public function updateFieldStatus( Request $request, $table, $id, $status, $field='status'  )
    {
        DB::table($table)->where('id', $id)->update([
            $field => $status
        ]);

        $response = [
            'success' => true,
            'data'    => "",
            'message' => $table." status update successfully.",
        ];

        return response()->json($response, 200);
    }

    /**
     *
     */
    public function deleteEvent( $title, $id )
    {
        ScheduleList::where( 'id', $id )->delete();

        $response = [
            'success' => true,
            'data'    => ScheduleList::where( 'type', 3 )->count(),//1: Employee, 2: Customer, 3: Client
            'message' => $title." event delete successfully.",
        ];

        return response()->json( $response, 200 );
    }

    /**
     *
     */
    public function changePassword(){

        if ( is_null( $this->user )  ) {
            abort(403, 'Sorry !! You are Unauthorized to change your password !');
        }
        return view('backend.layouts.partials.change-password');
    }
}
