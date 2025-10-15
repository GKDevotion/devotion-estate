<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\PropertyAdd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class PropertyAddController extends Controller
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
        if (is_null($this->user) || !$this->user->can('property-add.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view Location !');
        }

        return view('backend.pages.property_add.create');
    }

    /**
     *
     */
    public function ajaxIndex( Request $request ){

        $this->setPublicVar();

        $query = PropertyAdd::query();

        if( !$this->is_assign_super_admin ){
            $query->where( 'admin_id', $this->admin_id );
        }

        $query->select('id', 'main_type','name', 'description', 'sort_order', 'updated_at', 'status');

        return DataTables::eloquent($query)
            ->addColumn('id', function(PropertyAdd $ar) {
                return $ar->id;
            })
            ->addColumn('type', function(PropertyAdd $ar) {
                return $ar->type == 0 ? 'Residential' : 'Commercial';
            })
            ->addColumn('name', function(PropertyAdd $ar) {
                return $ar->name;
            })
            ->addColumn('description', function(PropertyAdd $ar) {
                return $ar->description;
            })
            ->addColumn('count', function(PropertyAdd $ar) {
                return $ar->count;
            })
            ->addColumn('status', function(PropertyAdd $ar) {
                $status = "";
                if( true ){
                    $status = '<i class="fa fa-'.( $ar->status == 0 ? 'times' : 'check').' update-status" data-status="'.$ar->status.'" data-id="'.$ar->id.'" aria-hidden="true" data-table="property_types"></i>';
                } else {
                 $status = '<select class="form-control update-status badge '.( $ar->status == 0 ? 'bg-warning' : 'bg-success').' text-white" type_name="status" data-id="'.$ar->id.'" data-table="property_types">
                            <option value="1" '.($ar->status == 1 ? 'selected' : '').'>Active</option>
                            <option value="0" '.($ar->status == 0 ? 'selected' : '').'>De-Active</option>
                        </select>';
                }

                return $status;
            })
            ->addColumn('updated_at', function(PropertyAdd $ar) {
                return formatDate( "Y-m-d H:i", $ar->updated_at );
            })
            ->addColumn('action', function(PropertyAdd $ar ) {

                $action = '
                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="action_menu_'.$ar->id.'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        &#x22EE;
                    </button>
                    <div class="dropdown-menu" aria-labelledby="action_menu_'.$ar->id.'">
                    ';

                    if ($this->user->can('property-types.edit')) {
                        $action.= '<a class="btn btn-edit text-white dropdown-item" href="'.route('admin.property-types.edit', $ar->id).'">
                            <i class="fa fa-pencil"></i> Edit
                        </a>';
                    }

                    if ($this->user->can('property-types.delete')) {
                        $action.= '<button class="btn btn-edit text-white dropdown-item delete-record" data-id="'.$ar->id.'" data-title="'.$ar->name.'" data-segment="locations">
                                        <i class="fa fa-trash fa-sm" aria-hidden="true"></i> Delete
                                    </button>';
                    }

                    $action.= '
                    </div>
                ';

                return $action;
            })
            ->rawColumns(['id', 'type','name', 'description', 'count', 'sort_order', 'updated_at', 'status', 'action'])  // Specify the columns that contain HTML
            ->filter(function ($query) {
                if (request()->has('search')) {
                    $searchValue = request('search')['value'];
                    if( $searchValue != "" ){
                        $query->where('type_name', 'like', "%{$searchValue}%")
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
        if (is_null($this->user) || !$this->user->can('property-add.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create Location !');
        }

        return view('backend.pages.property_add.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('property-add.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create Location !');
        }

        // Validation Data
        $request->validate([
            'main_type' => 'required',
            'name' => 'required',
            'sort_order' => 'required',
        ]);

        // Create New Server Record
        $location = new PropertyAdd();
        $location->admin_id = $this->user->id;
        $location->image = $request->image;
        $location->name = $request->name;
        $location->slug = $request->slug;
        $location->purpose = $request->purpose;
        $location->type = $request->type;
        $location->publish = $request->publish;
        $location->price = $request->price;
        $location->address = $request->address;
        $location->sort_order = $request->sort_order;
        $location->slug = convertStringToSlug( $request->name );
        $location->status = $request->status;
        $location->save();
        
        session()->flash('success', $request->name.' record has been created !!');
        return redirect()->route('admin.property-add.index');
   
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
        if (is_null($this->user) || !$this->user->can('property-add.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit Property Types !');
        }

        $data = PropertyAdd::find($id);

        return view('backend.pages.property_add.edit', compact('data'));
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
        if (is_null($this->user) || !$this->user->can('property-add.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit Location !');
        }

        // Validation Data
        $request->validate([
            'main_type' => 'required',
            'name' => 'required',
            'description' => 'required',
            'sort_order' => 'required',
        ]);

        // Update Old Feature data
        $location = new PropertyAdd();
        $location->admin_id = $this->user->id;
        $location->main_type = $request->main_type;
        $location->name = $request->name;
        $location->description = $request->description;
        $location->sort_order = $request->sort_order;
        $location->slug = convertStringToSlug( $request->name );
        $location->status = $request->status;
        $location->save();

        session()->flash('success', $request->name.' record has been updated !!');
        return redirect()->route('admin.property-add.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        if (is_null($this->user) || !$this->user->can('property-add.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete Location !');
        }

        $record = PropertyAdd::find($id);

        if (!is_null($record)) {
            $record->delete();
        }

        // session()->flash('success', 'Record has been deleted !!');
        return response()->json( ['data' => ['message' => "'".$record->name.'" has been successfully deleted.' ] ], 200);
    }
}
