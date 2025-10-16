<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class CurrencyController extends Controller
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
        if (is_null($this->user) || !$this->user->can('currency.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view City !');
        }

        // $dataArr = City::limit(1000)->get();
        return view('backend.pages.currency.index');
    }

    /**
     *
     */
    // public function ajaxIndex(){

    //     $query = Currency::query();
    //     $query->select('id', 'name', 'currency_code', 'currency_value','status','updated_at');

    //     return DataTables::eloquent($query)
    //         ->addColumn('id', function(Currency $currency) {
    //             return $currency->id;
    //         })
    //         ->addColumn('name', function(Currency $currency) {
    //             return $currency->name;
    //         })
    //             ->addColumn('currency_code', function(Currency $currency) {
    //             return $currency->currency_code;
    //         })
    //             ->addColumn('currency_value', function(Currency $currency) {
    //             return $currency->name;
    //         })

    //         ->addColumn('status', function(Currency $currency) {
    //             $status = "";
    //             if( true ){
    //                 $status = '<i class="fa fa-'.( $currency->status == 0 ? 'times' : 'check').' update-status" data-status="'.$currency->status.'" data-id="'.$currency->id.'" aria-hidden="true" data-table="currencies"></i>';
    //             } else {
    //              $status = '<select class="form-control update-status badge '.( $currency->status == 0 ? 'bg-warning' : 'bg-success').' text-white" name="status" data-id="'.$currency->id.'" data-table="currencies">
    //                         <option value="1" '.($currency->status == 1 ? 'selected' : '').'>Active</option>
    //                         <option value="0" '.($currency->status == 0 ? 'selected' : '').'>De-Active</option>
    //                     </select>';
    //             }

    //             return $status;
    //         })
    //         ->addColumn('updated_at', function(Currency $currency) {
    //             return formatDate( "Y-m-d H:i", $currency->updated_at );
    //         })
    //         ->addColumn('action', function(Currency $currency ) {

    //             $action = '
    //                 <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="action_menu_'.$currency->id.'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    //                     &#x22EE;
    //                 </button>
    //                 <div class="dropdown-menu" aria-labelledby="action_menu_'.$currency->id.'">
    //                 ';

    //                 if ($this->user->can('currency.edit')) {
    //                     $action.= '<a class="btn btn-edit text-white dropdown-item" href="'.route('admin.currency.edit', $currency->id).'">
    //                         <i class="fa fa-pencil"></i> Edit
    //                     </a>';
    //                 }

    //                 if ($this->user->can('currency.delete')) {
    //                     $action.= '<button class="btn btn-edit text-white delete-record dropdown-item" data-id="'.$currency->id.'" data-title="'.$currency->name.'" data-segment="currency">
    //                                     <i class="fa fa-trash fa-sm" aria-hidden="true"></i> Delete
    //                                 </button>';
    //                 }
    //                 $action.= '
    //                 </div>
    //             ';

    //             return $action;
    //         })
    //         ->rawColumns(['id', 'name', 'currency_code', 'currency_value', 'status','created_at', 'updated_at','action'])  // Specify the columns that contain HTML
    //         ->filter(function ($query) {
    //             if (request()->has('search')) {
    //                 $searchValue = request('search')['value'];
    //                 $query->where('name', 'like', "%{$searchValue}%")
    //                     ->orWhereHas('currency', function($q) use ($searchValue) {
    //                         $q->where('name', 'like', "%{$searchValue}%");
    //                     });

    //                     // ->orWhere('email', 'like', "%{$searchValue}%");
    //             }
    //         })
    //         ->order(function ($query) {
    //             if (request()->has('order')) {
    //                 $orderColumn = request('order')[0]['column'];
    //                 $orderDirection = request('order')[0]['dir'];
    //                 $columns = request('columns');
    //                 $query->orderBy($columns[$orderColumn]['data'], $orderDirection);
    //             }
    //         })
    //         ->make(true);
    // }
    public function ajaxIndex()
    {

        $query = Currency::query();
        $query->select('id', 'name', 'currency_code', 'currency_value', 'status', 'created_at', 'updated_at');

        return DataTables::eloquent($query)
            ->addColumn('id', function (Currency $city) {
                return $city->id;
            })
            ->addColumn('name', function (Currency $city) {
                return $city->name;
            })
            ->addColumn('currency_code', function (Currency $city) {
                return $city->currency_code; // Display the state name
            })
            ->addColumn('currency_value', function (Currency $city) {
                return $city->currency_value; // Display the country name
            })

            ->addColumn('status', function (Currency $city) {
                $status = "";
                if (true) {
                    $status = '<i class="fa fa-' . ($city->status == 0 ? 'times' : 'check') . ' update-status" data-status="' . $city->status . '" data-id="' . $city->id . '" aria-hidden="true" data-table="currencies"></i>';
                } else {
                    $status = '<select class="form-control update-status badge ' . ($city->status == 0 ? 'bg-warning' : 'bg-success') . ' text-white" name="status" data-id="' . $city->id . '" data-table="currencies">
                            <option value="1" ' . ($city->status == 1 ? 'selected' : '') . '>Active</option>
                            <option value="0" ' . ($city->status == 0 ? 'selected' : '') . '>De-Active</option>
                        </select>';
                }

                return $status;
            })
            ->addColumn('updated_at', function (Currency $city) {
                return formatDate("Y-m-d H:i", $city->updated_at);
            })
            ->addColumn('action', function (Currency $city) {

                $action = '
                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="action_menu_' . $city->id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        &#x22EE;
                    </button>
                    <div class="dropdown-menu" aria-labelledby="action_menu_' . $city->id . '">
                    ';

                if ($this->user->can('currency.edit')) {
                    $action .= '<a class="btn btn-edit text-white dropdown-item" href="' . route('admin.currency.edit', $city->id) . '">
                            <i class="fa fa-pencil"></i> Edit
                        </a>';
                }

                if ($this->user->can('currency.delete')) {
                    $action .= '<button class="btn btn-edit text-white delete-record dropdown-item" data-id="' . $city->id . '" data-title="' . $city->name . '" data-segment="currency">
                                        <i class="fa fa-trash fa-sm" aria-hidden="true"></i> Delete
                                    </button>';
                }
                $action .= '
                    </div>
                ';


                return $action;
            })
            ->rawColumns(['id', 'name', 'currency_code', 'currency_value', 'status', 'created_at', 'updated_at', 'action'])  // Specify the columns that contain HTML
            ->filter(function ($query) {
                if (request()->has('search')) {
                    $searchValue = request('search')['value'];
                    $query->where('name', 'like', "%{$searchValue}%");
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
        if (is_null($this->user) || !$this->user->can('currency.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create City !');
        }


        return view('backend.pages.currency.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('currency.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create City !');
        }

        // Validation Data
        $request->validate([

            'name' => 'required',

        ]);

        // Create New Server Record
        $dataObj = new Currency();
        $dataObj->name = $request->name;
        $dataObj->currency_code = $request->currency_code;
        $dataObj->currency_value  = $request->currency_value;
        $dataObj->status = $request->status;
        $dataObj->save();

        session()->flash('success', $dataObj->name . ' record has been created !!');
        return redirect()->route('admin.currency.index');
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
        if (is_null($this->user) || !$this->user->can('currency.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit City !');
        }

        $data = Currency::find($id);

        return view('backend.pages.currency.edit', compact('data'));
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
        if (is_null($this->user) || !$this->user->can('currency.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit City !');
        }

        // Validation Data
        $request->validate([

            'name' => 'required',

        ]);

        // Create New Server Record
        $dataObj = Currency::find($id);
        $dataObj->name = $request->name;
        $dataObj->currency_code = $request->currency_code;
        $dataObj->currency_value  = $request->currency_value;
        $dataObj->status = $request->status;
        $dataObj->save();

        session()->flash('success', $dataObj->name . ' records has been updated !!');
        return redirect()->route('admin.currency.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        if (is_null($this->user) || !$this->user->can('currency.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete City !');
        }

        $dataObj = Currency::find($id);
        if ($dataObj) {
            $dataObj->delete();
            return response()->json(['data' => ['message' => $dataObj->name . ' record has been successfully deleted.']], 200);
        } else {
            return response()->json(['data' => ['message' => 'Record already deleted.']], 200);
        }
    }
}
