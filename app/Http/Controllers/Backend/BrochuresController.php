<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use App\Models\Brochures;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class BrochuresController extends Controller
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
        if (is_null($this->user) || !$this->user->can('brochures.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view City !');
        }

        // $dataArr = City::limit(1000)->get();
        return view('backend.pages.brochures.index');
    }


    public function ajaxIndex()
    {

        $query = Brochures::query();
        $query->select('id', 'location', 'file', 'agent', 'status', 'created_at', 'updated_at');

        return DataTables::eloquent($query)
            ->addColumn('id', function (Brochures $city) {
                return $city->id;
            })
            ->addColumn('location', function (Brochures $city) {
                return $city->location;
            })
            ->addColumn('file', function (Brochures $city) {
                if ($city->file) {
                    // Assuming your PDFs are stored in storage/app/public/brochures
                    $url = asset('storage/brochures/' . $city->file);
                    return '<a href="' . $url . '" download>' . $city->file . '</a>';
                }
                return '-';
            })

            ->addColumn('agent', function (Brochures $city) {
                return $city->agent; // Display the country name
            })

            ->addColumn('status', function (Brochures $city) {
                $status = "";
                if (true) {
                    $status = '<i class="fa fa-' . ($city->status == 0 ? 'times' : 'check') . ' update-status" data-status="' . $city->status . '" data-id="' . $city->id . '" aria-hidden="true" data-table="brochures"></i>';
                } else {
                    $status = '<select class="form-control update-status badge ' . ($city->status == 0 ? 'bg-warning' : 'bg-success') . ' text-white" name="status" data-id="' . $city->id . '" data-table="brochures">
                            <option value="1" ' . ($city->status == 1 ? 'selected' : '') . '>Active</option>
                            <option value="0" ' . ($city->status == 0 ? 'selected' : '') . '>De-Active</option>
                        </select>';
                }

                return $status;
            })
            ->addColumn('updated_at', function (Brochures $city) {
                return formatDate("Y-m-d H:i", $city->updated_at);
            })
            ->addColumn('action', function (Brochures $city) {

                $action = '
                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="action_menu_' . $city->id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        &#x22EE;
                    </button>
                    <div class="dropdown-menu" aria-labelledby="action_menu_' . $city->id . '">
                    ';

                if ($this->user->can('brochures.edit')) {
                    $action .= '<a class="btn btn-edit text-white dropdown-item" href="' . route('admin.brochures.edit', $city->id) . '">
                            <i class="fa fa-pencil"></i> Edit
                        </a>';
                }

                if ($this->user->can('brochures.delete')) {
                    $action .= '<button class="btn btn-edit text-white delete-record dropdown-item" data-id="' . $city->id . '" data-title="' . $city->name . '" data-segment="brochures">
                                        <i class="fa fa-trash fa-sm" aria-hidden="true"></i> Delete
                                    </button>';
                }
                $action .= '
                    </div>
                ';


                return $action;
            })
            ->rawColumns(['id',  'location', 'file', 'agent', 'status', 'created_at', 'updated_at', 'action'])  // Specify the columns that contain HTML
            ->filter(function ($query) {
                if (request()->has('search')) {
                    $searchValue = request('search')['value'];
                    $query->where('location', 'like', "%{$searchValue}%");
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
        if (is_null($this->user) || !$this->user->can('brochures.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create City !');
        }


        return view('backend.pages.brochures.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('brochures.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create City !');
        }

        // Validation Data
        $request->validate([

            'location' => 'required',

        ]);

        // Create New Server Record
        $dataObj = new Brochures();
        $dataObj->location = $request->location;
        $dataObj->file = $request->file;
        $dataObj->agent  = $request->agent;
        $dataObj->status = $request->status;
        $dataObj->save();

        session()->flash('success', $dataObj->name . ' record has been created !!');
        return redirect()->route('admin.brochures.index');
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
        if (is_null($this->user) || !$this->user->can('brochures.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit City !');
        }

        $data = Brochures::find($id);

        return view('backend.pages.brochures.edit', compact('data'));
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
        if (is_null($this->user) || !$this->user->can('brochures.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit City !');
        }

        // Validation Data
        $request->validate([

            'location' => 'required',

        ]);

        // Create New Server Record
        $dataObj = Brochures::find($id);
        $dataObj->location = $request->location;
        $dataObj->file = $request->file;
        $dataObj->agent  = $request->agent;

        $dataObj->status = $request->status;
        $dataObj->save();

        session()->flash('success', $dataObj->name . ' records has been updated !!');
        return redirect()->route('admin.brochures.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        if (is_null($this->user) || !$this->user->can('brochures.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete City !');
        }

        $dataObj = Brochures::find($id);
        if ($dataObj) {
            $dataObj->delete();
            return response()->json(['data' => ['message' => $dataObj->name . ' record has been successfully deleted.']], 200);
        } else {
            return response()->json(['data' => ['message' => 'Record already deleted.']], 200);
        }
    }
}
