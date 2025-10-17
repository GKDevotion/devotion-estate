<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\City;
use App\Models\Continent;
use App\Models\Country;
use App\Models\State;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class ClientsController extends Controller
{

    public $user;
    public $is_assign_super_admin = 0;
    public $admin_id = 0;
    public $user_type = 3; //	1: User, 2: Owner, 3: Client, 4: Vendor

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
    public function index( Request $request )
    {
        if (is_null($this->user) || !$this->user->can('clients.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view Client !');
        }

        return view('backend.pages.clients.index', compact( 'request' ) );
    }

    /**
     *
     */
    public function ajaxIndex( Request $request ){

        $this->setPublicVar();

        $query = User::query();

        $query->where( 'type', $this->user_type );

        return DataTables::eloquent($query)
            ->addColumn('id', function(User $dt) {
                return $dt->id;
            })
            ->addColumn('name', function(User $dt) {
                return $dt->first_name." ".$dt->last_name;
            })
            ->addColumn('email', function(User $dt) {
                return $dt->email;
            })
            ->addColumn('login_by', function(User $dt) {
                return $dt->login_by;
            })
            ->addColumn('mobile_no', function(User $dt) {
                return $dt->mobile_no;
            })
            ->addColumn('status', function(User $dt) {
                $status = "";
                if( true ){
                    $status = '<i class="fa fa-'.( $dt->status == 0 ? 'times' : 'check').' update-status" data-status="'.$dt->status.'" data-id="'.$dt->id.'" aria-hidden="true" data-table="users"></i>';
                } else {
                 $status = '<select class="form-control update-status badge '.( $dt->status == 0 ? 'bg-warning' : 'bg-success').' text-white" name="status" data-id="'.$dt->id.'" data-table="users">
                            <option value="1" '.($dt->status == 1 ? 'selected' : '').'>Active</option>
                            <option value="0" '.($dt->status == 0 ? 'selected' : '').'>De-Active</option>
                        </select>';
                }

                return $status;
            })
            ->addColumn('login', function(User $dt) {

                return '<i class="fa fa-'.( $dt->login == 0 ? 'times' : 'check').' update-field-status" data-field="login" data-status="'.$dt->login.'" data-id="'.$dt->id.'" aria-hidden="true" data-table="users"></i>';
            })
            ->addColumn('created_at', function(User $dt) {
                return formatDate( "Y-m-d H:i", $dt->created_at );
            })
            ->addColumn('updated_at', function(User $dt) {
                return formatDate( "Y-m-d H:i", $dt->updated_at );
            })
            ->addColumn('action', function(User $dt ) {

                $action = '
                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="action_menu_'.$dt->id.'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        &#x22EE;
                    </button>
                    <div class="dropdown-menu" aria-labelledby="action_menu_'.$dt->id.'">
                    ';

                    if ($this->user->can('clients.edit')) {
                        $action.= '<a class="btn btn-edit text-white dropdown-item" href="'.route('admin.clients.edit', $dt->id).'">
                            <i class="fa fa-pencil"></i> Edit
                        </a>';
                    }

                    if ($this->user->can('city.edit')) {
                        $action.= '<button class="btn btn-edit text-white dropdown-item delete-record" data-id="'.$dt->id.'" data-title="'.$dt->name.'" data-segment="users">
                                        <i class="fa fa-trash fa-sm" aria-hidden="true"></i> Delete
                                    </button>';
                    }

                    $action.= '
                    </div>
                ';

                return $action;
            })
            ->rawColumns(['id', 'name', 'email', 'login_by', 'mobile_no', 'login', 'created_at', 'updated_at', 'status', 'action'])  // Specify the columns that contain HTML
            ->filter(function ($query) {
                if (request()->has('search')) {
                    $searchValue = request('search')['value'];
                    if( $searchValue != "" ){
                        $query->where('name', 'like', "%{$searchValue}%")
                            ->orWhereHas('industry', function($q) use ($searchValue) {
                                $q->where('name', 'like', "%{$searchValue}%");
                            })
                            ->orWhereHas('company', function($q) use ($searchValue) {
                                $q->where('name', 'like', "%{$searchValue}%");
                            });
                            // ->orWhere('email', 'like', "%{$searchValue}%");
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
        if (is_null($this->user) || !$this->user->can('clients.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create Client!');
        }

        $continentArr  = Continent::select( 'id', 'name' )->get();
        $countryArr  = Country::select( 'id', 'name', 'continent_id' )->get();
        $stateArr  = State::select( 'id', 'name', 'continent_id', 'country_id' )->get();
        return view('backend.pages.clients.create', compact( 'continentArr', 'countryArr', 'stateArr' ) );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('clients.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create Client!');
        }

        // Validation Data
        $request->validate([
            'login_by' => 'required|max:20',
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'email_id' => 'required|max:100|email',//|unique:users',
            'password' => 'required|min:6|confirmed',
            'continent_id' => 'required',
            'country_id' => 'required',
            'state_id' => 'required',
            'city_id' => 'required',
            'zipcode' => 'required',
            'address' => 'required',
        ]);

        // Create New User
        $user = new User();
        $user->login_by = $request->login_by;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->admin_id = $this->user->id;
        $user->email_id = $request->email_id;
        $user->password = Hash::make($request->password);
        $user->mobile_no = $request->mobile_no;
        $user->login = $request->login;
        $user->status = $request->status;
        $user->type = $this->user_type;
        $user->save();

        $userAddress = new Address();
        $userAddress->admin_id  = $this->user->id;
        $userAddress->person_id = $user->id;
        $userAddress->name = $user->first_name." ".$user->last_name;
        $userAddress->continent_id = $request->continent_id;
        $userAddress->country_id = $request->country_id;
        $userAddress->state_id = $request->state_id;
        $userAddress->city_id = $request->city_id;
        $userAddress->zipcode = $request->zipcode;
        $userAddress->address = $request->address;
        $userAddress->person_type = $this->user_type;
        $userAddress->save();

        session()->flash('success', $user->first_name." ".$user->last_name.' has been created !!');
        return redirect()->route('admin.clients.index');
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
    public function edit($id)
    {
        if (is_null($this->user) || !$this->user->can('clients.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit Client !');
        }

        $dataObj = User::find($id);
        $addressDataObj = Address::where( [
            'person_id' => $dataObj->id,
            'person_type' => $this->user_type
        ] )
        ->first();

        $continentObj  = Continent::select( 'id', 'name' )->get();
        $countryObj  = Country::select( 'id', 'name', 'continent_id' )->where( [ 'continent_id' => $addressDataObj->continent_id, 'status' => 1] )->get();
        $stateObj  = State::select( 'id', 'name', 'continent_id', 'country_id' )->where( [ 'country_id' => $addressDataObj->country_id, 'status' => 1] )->get();
        $cityObj  = City::select( 'id', 'name', 'continent_id', 'country_id' )->where( [ 'state_id' => $addressDataObj->state_id, 'status' => 1] )->get();

        return view('backend.pages.clients.edit', compact('dataObj', 'addressDataObj', 'continentObj', 'countryObj', 'stateObj', 'cityObj'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (is_null($this->user) || !$this->user->can('clients.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit Client !');
        }

        // Create New User
        $user = User::find($id);

        // Validation Data
        $request->validate([
            'login_by' => 'required|max:20',
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'email_id' => 'required|max:100|email',//|unique:users',
            'password' => 'required|min:6|confirmed',
            'continent_id' => 'required',
            'country_id' => 'required',
            'state_id' => 'required',
            'city_id' => 'required',
            'zipcode' => 'required',
            'address' => 'required',
        ]);

        $user->login_by = $request->login_by;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->admin_id = $this->user->id;
        $user->email_id = $request->email_id;
        $user->mobile_no = $request->mobile_no;
        $user->login = $request->login;
        $user->status = $request->status;
        $user->type = $this->user_type;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        $userAddress = Address::find( $request->address_id );
        $userAddress->admin_id  = $this->user->id;
        $userAddress->person_id = $user->id;
        $userAddress->name = $user->first_name." ".$user->last_name;
        $userAddress->continent_id = $request->continent_id;
        $userAddress->country_id = $request->country_id;
        $userAddress->state_id = $request->state_id;
        $userAddress->city_id = $request->city_id;
        $userAddress->zipcode = $request->zipcode;
        $userAddress->address = $request->address;
        $userAddress->person_type = $this->user_type;
        $userAddress->save();

        // session()->flash('success', 'User has been updated !!');
        session()->flash('success', $user->first_name." ".$user->last_name.' has been updated !!');
        return redirect()->route('admin.clients.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (is_null($this->user) || !$this->user->can('clients.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete Client !');
        }

        $user = User::find( $id );
        if ( !is_null( $user ) ) {

            $addressDataObj = Address::where( [
                'person_id' => $id,
                'person_type' => $this->user_type
            ] )
            ->first();

            if ( !is_null( $addressDataObj ) ) {
                $addressDataObj->delete();
                $user->delete();
            }
        }

        // session()->flash('success', 'User has been deleted !!');
        return response()->json( ['data' => ['message' => "'".$user->name.'" has been successfully deleted.' ] ], 200);
    }
}
