<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BusinessType;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Continent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SampleController extends Controller
{
    public $user;

    public function __construct()
    {
        // $this->middleware(function ($request, $next) {
        //     $this->user = Auth::guard('admin')->user();
        //     return $next($request);
        // });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $resultArr = BusinessType::orderBy( 'name', 'ASC' )->get();
        return view('backend.pages.sample.industry', compact( 'resultArr' ) );
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
        return redirect()->route('admin.corporate-emails.index');
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
        return redirect()->route('admin.corporate-emails.index');
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
            return $this->sendResponse( [], $dataObj->name.' record has been successfully deleted.' );
        } else {
            return $this->sendResponse([], 'Record already deleted.');
        }
    }
}
