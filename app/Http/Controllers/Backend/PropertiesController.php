<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Properties;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class PropertiesController extends Controller
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
        if (is_null($this->user) || !$this->user->can('properties.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view Location !');
        }

        return view('backend.pages.properties.index');
    }

    /**
     *
     */
    public function ajaxIndex( Request $request ){

        $this->setPublicVar();

        $query = Properties::query();

        if( !$this->is_assign_super_admin ){
            $query->where( 'admin_id', $this->admin_id );
        }

        $query->select('id','image', 'name', 'purpose','type','publish','area','price','address', 'sort_order','status', 'updated_at' );

        return DataTables::eloquent($query)
            ->addColumn('id', function(Properties $ar) {
                return $ar->id;
            })
                 ->addColumn('image', function(Properties $ar) {
                return $ar->image;
            })
            ->addColumn('name', function(Properties $ar) {
                return $ar->name;
            })
            ->addColumn('purpose', function(Properties $ar) {
                return $ar->purpose;
            })
            ->addColumn('type', function (Properties $ar) {
                return $ar->type;
            })
            ->addColumn('purpose', function (Properties $ar) {
                return $ar->purpose;
            })
            ->addColumn('publish', function (Properties $ar) {
                return $ar->publish;
            })
            ->addColumn('area', function (Properties $ar) {
                return $ar->area;
            })
            ->addColumn('price', function (Properties $ar) {
                return $ar->price;
            })
            ->addColumn('address', function (Properties $ar) {
                return $ar->address;
            })
            ->addColumn('sort_order', function(Properties $ar) {
                return $ar->sort_order;
            })
            
           ->addColumn('status', function(Properties $ar) {
                $status = "";
                if( true ){
                    $status = '<i class="fa fa-'.( $ar->status == 0 ? 'times' : 'check').' update-status" data-status="'.$ar->status.'" data-id="'.$ar->id.'" aria-hidden="true" data-table="properties"></i>';
                } else {
                 $status = '<select class="form-control update-status badge '.( $ar->status == 0 ? 'bg-warning' : 'bg-success').' text-white" name="status" data-id="'.$ar->id.'" data-table="properties">
                            <option value="1" '.($ar->status == 1 ? 'selected' : '').'>Active</option>
                            <option value="0" '.($ar->status == 0 ? 'selected' : '').'>De-Active</option>
                        </select>';
                }

                return $status;
            })
            ->addColumn('updated_at', function(Properties $ar) {
                return formatDate( "Y-m-d H:i", $ar->updated_at );
            })
            ->addColumn('action', function(Properties $ar ) {

                $action = '
                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="action_menu_'.$ar->id.'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        &#x22EE;
                    </button>
                    <div class="dropdown-menu" aria-labelledby="action_menu_'.$ar->id.'">
                    ';

                    if ($this->user->can('properties.edit')) {
                        $action.= '<a class="btn btn-edit text-white dropdown-item" href="'.route('admin.properties.edit', $ar->id).'">
                            <i class="fa fa-pencil"></i> Edit
                        </a>';
                    }

                    if ($this->user->can('properties.delete')) {
                        $action.= '<button class="btn btn-edit text-white dropdown-item delete-record" data-id="'.$ar->id.'" data-title="'.$ar->name.'" data-segment="properties">
                                        <i class="fa fa-trash fa-sm" aria-hidden="true"></i> Delete
                                    </button>';
                    }

                    $action.= '
                    </div>
                ';

                return $action;
            })
            ->rawColumns(['id','image', 'name', 'purpose','type','publish','area','price','address', 'sort_order', 'status','updated_at', 'action'])  // Specify the columns that contain HTML
            ->filter(function ($query) {
                if (request()->has('search')) {
                    $searchValue = request('search')['value'];
                    if( $searchValue != "" ){
                        $query->where('name', 'like', "%{$searchValue}%")
                            ->orWhere('description', 'like', "%{$searchValue}%");
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
        if (is_null($this->user) || !$this->user->can('properties.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create Location !');
        }

        return view('backend.pages.properties.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('properties.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create Location !');
        }

        // Validation Data
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'sort_order' => 'required',
        ]);

        // Create New Server Record
        $location = new Properties();
        $location->admin_id = $this->user->id;
        $location->image = $request->image;
        $location->name = $request->name;
        $location->purpose = $request->purpose;
        $location->type = $request->type;
        $location->publish = $request->publish;
        $location->area = $request->area;
        $location->price = $request->price;
        $location->address = $request->address;

        $location->sort_order = $request->sort_order;
        $location->slug = convertStringToSlug($request->name);
        $location->status = $request->status;
        $location->save();

        session()->flash('success', $request->name.' record has been created !!');
        return redirect()->route('admin.properties.index');
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
        if (is_null($this->user) || !$this->user->can('properties.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit Property Features !');
        }

        $data = Properties::find($id);

        return view('backend.pages.properties.edit', compact('data'));
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
        if (is_null($this->user) || !$this->user->can('properties.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit Location !');
        }

        // Validation Data
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'sort_order' => 'required',
        ]);

        // Update Old Feature data
        $location = new Properties();
        $location->admin_id = $this->user->id;

         $location->image = $request->image;
        $location->name = $request->name;
        $location->purpose = $request->purpose;
        $location->type = $request->type;
        $location->publish = $request->publish;
        $location->area = $request->area;
        $location->price = $request->price;
        $location->address = $request->address;


        $location->sort_order = $request->sort_order;
        $location->slug = convertStringToSlug( $request->name );
        $location->status = $request->status;
        $location->save();

        session()->flash('success', $request->name.' record has been updated !!');
        return redirect()->route('admin.properties.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        if (is_null($this->user) || !$this->user->can('properties.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete Location !');
        }

        $record = Properties::find($id);

        if (!is_null($record)) {
            $record->delete();
        }

        // session()->flash('success', 'Record has been deleted !!');
        return response()->json( ['data' => ['message' => "'".$record->name.'" has been successfully deleted.' ] ], 200);
    }
}
