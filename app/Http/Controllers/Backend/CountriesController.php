<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Continent;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\Facades\DataTables;

class CountriesController extends Controller
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
    public function setPublicVar()
    {
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
        if (is_null($this->user) || !$this->user->can('country.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view Country !');
        }

        $dataArr = Cache::remember('dataArr', 10, function () {
            return Country::with('continent')->select('id', 'continent_id', 'name', 'iso2', 'iso3', 'numeric_code', 'capital', 'currency', 'currency_symbol', 'latitude', 'longitude', 'status', 'updated_at')->get();
        });

        return view('backend.pages.countries.index', compact('dataArr'));
    }

    public function ajaxIndex(Request $request)
    {

        $this->setPublicVar();

        $query = Country::query();

        if (!$this->is_assign_super_admin) {
            $query->where('admin_id', $this->admin_id);
        }

        $query->select('id', 'name', 'continent_id', 'currency', 'iso3', 'iso2', 'numeric_code', 'capital', 'currency_symbol', 'latitude', 'longitude', 'status', 'updated_at');

        return DataTables::eloquent($query)
            ->addColumn('id', function (Country $ar) {
                return $ar->id;
            })
            ->addColumn('name', function (Country $ar) {
                return $ar->name;
            })
            // Continent Name (FROM ID)
            ->addColumn('continent', function (Country $ar) {
                return $ar->continent ? $ar->continent->name : '-';
            })

            // ISO
            ->addColumn('iso', function (Country $ar) {
                return $ar->iso3 . ', ' . $ar->iso2;
            })

            // Numeric Code
            ->addColumn('numeric_code', function (Country $ar) {
                return $ar->numeric_code;
            })

            // Capital
            ->addColumn('capital', function (Country $ar) {
                return $ar->capital . ' (' . $ar->currency_symbol . ')';
            })

            // Lat Long
            ->addColumn('lat_long', function (Country $ar) {
                return round($ar->latitude, 3) . ', ' . round($ar->longitude, 3);
            })
            ->addColumn('status', function (Country $dt) {
                $status = "";
                if (true) {
                    $status = '<i class="fa fa-' . ($dt->status == 0 ? 'times' : 'check') . ' update-status" data-status="' . $dt->status . '" data-id="' . $dt->id . '" aria-hidden="true" data-table="countries"></i>';
                } else {
                    $status = '<select class="form-control update-status badge ' . ($dt->status == 0 ? 'bg-warning' : 'bg-success') . ' text-white" name="status" data-id="' . $dt->id . '" data-table="countries">
                            <option value="1" ' . ($dt->status == 1 ? 'selected' : '') . '>Active</option>
                            <option value="0" ' . ($dt->status == 0 ? 'selected' : '') . '>De-Active</option>
                        </select>';
                }

                return $status;
            })

            ->addColumn('updated_at', function (Country $ar) {
                return formatDate("Y-m-d H:i", $ar->updated_at);
            })

            ->addColumn('action', function (Country $ar) {

                $action = '
                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="action_menu_' . $ar->id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        &#x22EE;
                    </button>
                    <div class="dropdown-menu" aria-labelledby="action_menu_' . $ar->id . '">
                    ';

                if ($this->user->can('country.edit')) {
                    $action .= '<a class="btn btn-edit text-white dropdown-item" href="' . route('admin.country.edit', $ar->id) . '">
                            <i class="fa fa-pencil"></i> Edit
                        </a>';
                }

                if ($this->user->can('country.delete')) {
                    $action .= '<button class="btn btn-edit text-white delete-record dropdown-item" data-id="' . $ar->id . '" data-title="' . $ar->name . '" data-segment="countries">
                    <i class="fa fa-trash fa-sm" aria-hidden="true"></i> Delete
                    </button>';
                }

                $action .= '
                    </div>
                ';

                return $action;
            })
            ->rawColumns(['id', 'name', 'continent_id', 'currency', 'iso3', 'iso2', 'numeric_code', 'capital', 'currency_symbol', 'latitude', 'longitude', 'status', 'updated_at', 'action']) 
            
            // Specify the columns that contain HTML
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
        if (is_null($this->user) || !$this->user->can('country.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create Country !');
        }

        $continentArr  = Continent::all();
        return view('backend.pages.countries.create', compact('continentArr'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('country.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create Country !');
        }

        // Validation Data
        $request->validate([
            'continent_id' => 'required',
            'name' => 'required',
            'iso3' => 'required',
            'numeric_code' => 'required',
            'iso2' => 'required',
            'phone_code' => 'required',
            'capital' => 'required',
            'currency' => 'required',
            'currency_name' => 'required',
            'currency_symbol' => 'required',
            'tld' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        // // Create New Server Record
        // $dataObj = new Country();
        // $dataObj->continent_id  = $request->continent_id;
        // $dataObj->name = $request->name;
        // $dataObj->iso3 = $request->iso3;
        // $dataObj->numeric_code = $request->numeric_code;
        // $dataObj->iso2 = $request->iso2;
        // $dataObj->phone_code  = $request->phone_code;
        // $dataObj->capital = $request->capital;
        // $dataObj->currency = $request->currency;
        // $dataObj->currency_name = $request->currency_name;
        // $dataObj->currency_symbol = $request->currency_symbol;
        // $dataObj->tld  = $request->tld;
        // $dataObj->latitude = $request->latitude;
        // $dataObj->longitude = $request->longitude;
        // $dataObj->status = $request->status;
        // $dataObj->save();

        $dataObj = $this->StoreUpdateData($request);

        session()->flash('success', $dataObj->name . ' Record has been created !!');
        return redirect()->route('admin.country.index');
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
        if (is_null($this->user) || !$this->user->can('country.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit Country !');
        }

        $data = Country::find($id);
        $continentArr  = Continent::all();
        return view('backend.pages.countries.edit', compact('data', 'continentArr'));
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
        if (is_null($this->user) || !$this->user->can('country.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit Country !');
        }

        // Validation Data
        $request->validate([
            'continent_id' => 'required',
            'name' => 'required',
            'iso3' => 'required',
            'numeric_code' => 'required',
            'iso2' => 'required',
            'phone_code' => 'required',
            'capital' => 'required',
            'currency' => 'required',
            'currency_name' => 'required',
            'currency_symbol' => 'required',
            'tld' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        // // Create New Server Record
        // $dataObj = Country::find($id);
        // $dataObj->continent_id  = $request->continent_id;
        // $dataObj->name = $request->name;
        // $dataObj->iso3 = $request->iso3;
        // $dataObj->numeric_code = $request->numeric_code;
        // $dataObj->iso2 = $request->iso2;
        // $dataObj->phone_code  = $request->phone_code;
        // $dataObj->capital = $request->capital;
        // $dataObj->currency = $request->currency;
        // $dataObj->currency_name = $request->currency_name;
        // $dataObj->currency_symbol = $request->currency_symbol;
        // $dataObj->tld  = $request->tld;
        // $dataObj->latitude = $request->latitude;
        // $dataObj->longitude = $request->longitude;
        // $dataObj->status = $request->status;
        // $dataObj->save();

        $dataObj = $this->StoreUpdateData($request, $id);

        session()->flash('success', $dataObj->name . ' Records has been updated !!');
        return redirect()->route('admin.country.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        if (is_null($this->user) || !$this->user->can('country.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete Country !');
        }

        $record = Country::find($id);
        if (!is_null($record)) {
            $record->delete();
        }

        // session()->flash('success', $record->name.' record has been deleted !!');
        return response()->json(['data' => ['message' => "'" . $record->name . '" has been successfully deleted.']], 200);
    }

    public function StoreUpdateData(Request $request, int $id = null)
    {
        // ✅ Find or create model
        $dataObj = $id ? Country::findOrFail($id) : new Country(); 
        
    
        $dataObj->continent_id  = $request->continent_id;
        $dataObj->name = $request->name;
        $dataObj->iso3 = $request->iso3;
        $dataObj->numeric_code = $request->numeric_code;
        $dataObj->iso2 = $request->iso2;
        $dataObj->phone_code  = $request->phone_code;
        $dataObj->capital = $request->capital;
        $dataObj->currency = $request->currency;
        $dataObj->currency_name = $request->currency_name;
        $dataObj->currency_symbol = $request->currency_symbol;
        $dataObj->tld  = $request->tld;
        $dataObj->latitude = $request->latitude;
        $dataObj->longitude = $request->longitude;
        $dataObj->status = $request->status;
        $dataObj->save();
        return $dataObj;
    }

}
