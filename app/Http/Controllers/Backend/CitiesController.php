<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Continent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class CitiesController extends Controller
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
        if (is_null($this->user) || !$this->user->can('city.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view City !');
        }

        // $dataArr = City::limit(1000)->get();
        return view('backend.pages.cities.index');
    }

    /**
     *
     */
    public function ajaxIndex(){

        $query = City::query();
        $query->select('id', 'name', 'latitude', 'longitude','updated_at', 'continent_id', 'country_id', 'state_id', 'status');

        return DataTables::eloquent($query)
            ->addColumn('id', function(City $city) {
                return $city->id;
            })
            ->addColumn('name', function(City $city) {
                return $city->name;
            })
            ->addColumn('state_name', function(City $city) {
                return $city->state->name; // Display the state name
            })
            ->addColumn('country_name', function(City $city) {
                return $city->country->name; // Display the country name
            })
            ->addColumn('continent_name', function(City $city) {
                return $city->continent->name; // Display the continent name
            })
            ->addColumn('latitude', function(City $city) {
                return number_format( $city->latitude, 4 );
            })
            ->addColumn('longitude', function(City $city) {
                return number_format( $city->longitude, 4 );
            })
            ->addColumn('status', function(City $city) {
                $status = "";
                if( true ){
                    $status = '<i class="fa fa-'.( $city->status == 0 ? 'times' : 'check').' update-status" data-status="'.$city->status.'" data-id="'.$city->id.'" aria-hidden="true" data-table="cities"></i>';
                } else {
                 $status = '<select class="form-control update-status badge '.( $city->status == 0 ? 'bg-warning' : 'bg-success').' text-white" name="status" data-id="'.$city->id.'" data-table="cities">
                            <option value="1" '.($city->status == 1 ? 'selected' : '').'>Active</option>
                            <option value="0" '.($city->status == 0 ? 'selected' : '').'>De-Active</option>
                        </select>';
                }

                return $status;
            })
            ->addColumn('updated_at', function(City $city) {
                return formatDate( "Y-m-d H:i", $city->updated_at );
            })
            ->addColumn('action', function(City $city ) {

                $action = '
                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="action_menu_'.$city->id.'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        &#x22EE;
                    </button>
                    <div class="dropdown-menu" aria-labelledby="action_menu_'.$city->id.'">
                    ';

                    if ($this->user->can('city.edit')) {
                        $action.= '<a class="btn btn-edit text-white dropdown-item" href="'.route('admin.city.edit', $city->id).'">
                            <i class="fa fa-pencil"></i> Edit
                        </a>';
                    }

                    if ($this->user->can('city.delete')) {
                        $action.= '<button class="btn btn-edit text-white delete-record dropdown-item" data-id="'.$city->id.'" data-title="'.$city->name.'" data-segment="city">
                                        <i class="fa fa-trash fa-sm" aria-hidden="true"></i> Delete
                                    </button>';
                    }
                    $action.= '
                    </div>
                ';

                return $action;
            })
            ->rawColumns(['id', 'name', 'latitude', 'longitude','updated_at', 'continent_name', 'country_name', 'state_name', 'status', 'action'])  // Specify the columns that contain HTML
            ->filter(function ($query) {
                if (request()->has('search')) {
                    $searchValue = request('search')['value'];
                    $query->where('name', 'like', "%{$searchValue}%")
                        ->orWhereHas('continent', function($q) use ($searchValue) {
                            $q->where('name', 'like', "%{$searchValue}%");
                        })
                        ->orWhereHas('country', function($q) use ($searchValue) {
                            $q->where('name', 'like', "%{$searchValue}%");
                        })
                        ->orWhereHas('state', function($q) use ($searchValue) {
                            $q->where('name', 'like', "%{$searchValue}%");
                        });
                        // ->orWhere('email', 'like', "%{$searchValue}%");
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
        if (is_null($this->user) || !$this->user->can('city.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create City !');
        }

        $continentArr  = Continent::select( 'id', 'name' )->get();
        $countryArr  = Country::select( 'id', 'name', 'continent_id' )->get();
        $stateArr  = State::select( 'id', 'name', 'continent_id', 'country_id' )->get();
        return view('backend.pages.cities.create', compact( 'continentArr', 'countryArr', 'stateArr' ) );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('city.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create City !');
        }

        // Validation Data
        $request->validate([
            'continent_id' => 'required',
            'country_id' => 'required',
            'state_id' => 'required',
            'name' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        // Create New Server Record
        $dataObj = new City();
        $dataObj->continent_id = $request->continent_id;
        $dataObj->country_id  = $request->country_id ;
        $dataObj->state_id  = $request->state_id ;
        $dataObj->name = $request->name;
        $dataObj->latitude = $request->latitude;
        $dataObj->longitude = $request->longitude;
        $dataObj->status = $request->status;
        $dataObj->save();

        session()->flash('success', $dataObj->name.' record has been created !!');
        return redirect()->route('admin.city.index');
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
        if (is_null($this->user) || !$this->user->can('city.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit City !');
        }

        $data = City::find($id);
        $continentArr  = Continent::select( 'id', 'name' )->get();
        $countryArr  = Country::select( 'id', 'name', 'continent_id' )->get();
        $stateArr  = State::select( 'id', 'name', 'continent_id', 'country_id' )->get();
        return view('backend.pages.cities.edit', compact('data', 'continentArr', 'countryArr', 'stateArr'));
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
        if (is_null($this->user) || !$this->user->can('city.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit City !');
        }

        // Validation Data
        $request->validate([
            'continent_id' => 'required',
            'country_id' => 'required',
            'state_id' => 'required',
            'name' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        // Create New Server Record
        $dataObj = City::find( $id );
        $dataObj->continent_id = $request->continent_id;
        $dataObj->country_id  = $request->country_id ;
        $dataObj->state_id  = $request->state_id ;
        $dataObj->name = $request->name;
        $dataObj->latitude = $request->latitude;
        $dataObj->longitude = $request->longitude;
        $dataObj->status = $request->status;
        $dataObj->save();

        session()->flash('success', $dataObj->name.' records has been updated !!');
        return redirect()->route('admin.city.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        if (is_null($this->user) || !$this->user->can('city.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete City !');
        }

        $dataObj = City::find($id);
        if ( $dataObj ) {
            $dataObj->delete();
            return response()->json( ['data' => ['message' => $dataObj->name.' record has been successfully deleted.' ] ], 200);
        } else {
            return response()->json( ['data' => ['message' => 'Record already deleted.'] ], 200);
        }
    }
}
