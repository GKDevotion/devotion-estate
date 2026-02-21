<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Amenity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class AmenityController extends Controller
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
        if (is_null($this->user) || !$this->user->can('amenity.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view City !');
        }

        // $dataArr = City::limit(1000)->get();
        return view('backend.pages.amenity.index');
    }


    public function ajaxIndex()
    {

        $query = Amenity::query();
        $query->select('id', 'name', 'icon', 'status', 'created_at', 'updated_at');

        return DataTables::eloquent($query)
            ->addColumn('id', function (Amenity $city) {
                return $city->id;
            })
            ->addColumn('icon', function (Amenity $city) {

            $iconClass = $city->icon ?? 'bi bi-question-circle'; 
            return '<i class="' . $iconClass . '" style="font-size:24px; color:#aa8038 "></i>';
            })

            ->addColumn('name', function (Amenity $city) {
                return $city->name; // Display the country name
            }) 

            ->addColumn('status', function (Amenity $city) {
                $status = "";
                if (true) {
                    $status = '<i class="fa fa-' . ($city->status == 0 ? 'times' : 'check') . ' update-status" data-status="' . $city->status . '" data-id="' . $city->id . '" aria-hidden="true" data-table=" amenities"></i>';
                } else {
                    $status = '<select class="form-control update-status badge ' . ($city->status == 0 ? 'bg-warning' : 'bg-success') . ' text-white" name="status" data-id="' . $city->id . '" data-table="amenities">
                            <option value="1" ' . ($city->status == 1 ? 'selected' : '') . '>Active</option>
                            <option value="0" ' . ($city->status == 0 ? 'selected' : '') . '>De-Active</option>
                        </select>';
                }

                return $status;
            })
            ->addColumn('updated_at', function (Amenity $city) {
                return formatDate("Y-m-d H:i", $city->updated_at);
            })
            ->addColumn('action', function (Amenity $city) {

                $action = '
                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="action_menu_' . $city->id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        &#x22EE;
                    </button>
                    <div class="dropdown-menu" aria-labelledby="action_menu_' . $city->id . '">
                    ';

                if ($this->user->can('amenity.edit')) {
                    $action .= '<a class="btn btn-edit text-white dropdown-item" href="' . route('admin.amenity.edit', $city->id) . '">
                            <i class="fa fa-pencil"></i> Edit
                        </a>';
                }

                if ($this->user->can('amenity.delete')) {
                    $action .= '<button class="btn btn-edit text-white delete-record dropdown-item" data-id="' . $city->id . '" data-title="' . $city->name . '" data-segment=" amenities">
                    <i class="fa fa-trash fa-sm" aria-hidden="true"></i> Delete
                    </button>';
                }

                $action .= '
                    </div>
                ';


                return $action;
            })
            ->rawColumns(['id',  'name', 'icon',  'status', 'created_at', 'updated_at', 'action'])  // Specify the columns that contain HTML
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
        if (is_null($this->user) || !$this->user->can('amenity.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create City !');
        }


        return view('backend.pages.amenity.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('amenity.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create Brochure !');
        }

        // ✅ Validate input
        $request->validate([ 
        ]); 

        $dataObj = $this->StoreUpdateData( $request );

        session()->flash('success', $dataObj->name . ' record has been created successfully!');
        return redirect()->route('admin.amenity.index');
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
        if (is_null($this->user) || !$this->user->can('amenity.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit City !');
        }

        $data = Amenity::find($id);

        return view('backend.pages.amenity.edit', compact('data'));
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
        if (is_null($this->user) || !$this->user->can('amenity.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit Banner !');
        }

        // Validate input
        $request->validate([ 
        ]); 

        $dataObj = $this->StoreUpdateData( $request, $id );
        session()->flash('success', $dataObj->name . ' record has been updated successfully!');
        return redirect()->route('admin.amenity.index');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        if (is_null($this->user) || !$this->user->can('amenity.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete City !');
        }

        $dataObj = Amenity::find($id);
        if ($dataObj) {
            $dataObj->delete();
            return response()->json(['data' => ['message' => $dataObj->name . ' record has been successfully deleted.']], 200);
        } else {
            return response()->json(['data' => ['message' => 'Record already deleted.']], 200);
        }
    }

    
    public function StoreUpdateData(Request $request, int $id = null)
    {
        // ✅ Find or create model
        $dataObj = $id ? Amenity::findOrFail($id) : new Amenity();


        $dataObj->name = $request->name;
        $dataObj->icon = $request->icon; 
        $dataObj->status = $request->status;
 


        $dataObj->save(); 
        return $dataObj;
    }
}
