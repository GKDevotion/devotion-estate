<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ReviewsController extends Controller
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
        if (is_null($this->user) || !$this->user->can('reviews.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view Location !');
        }

        return view('backend.pages.reviews.index');
    }

    /**
     *
     */
    public function ajaxIndex( Request $request ){

        $this->setPublicVar();

        $query = Review::query();

        if( !$this->is_assign_super_admin ){
            $query->where( 'admin_id', $this->admin_id );
        }

        $query->select('id', 'name', 'email','contact_no', 'review', 'rating', 'property_id', 'updated_at', 'status');

        return DataTables::eloquent($query)
            ->addColumn('id', function(Review $ar) {
                return $ar->id;
            })
            ->addColumn('name', function(Review $ar) {
                return $ar->name;
            })
            ->addColumn('email', function(Review $ar) {
                return $ar->email;
            })
               ->addColumn('contact_no', function(Review $ar) {
                return $ar->contact_no;
            })
               ->addColumn('review', function(Review $ar) {
                return $ar->review;
            })
               ->addColumn('rating', function(Review $ar) {
                return $ar->rating;
            })
              ->addColumn('property_id', function(Review $ar) {
                return $ar->property_id;
            })
            ->addColumn('status', function(Review $ar) {
                $status = "";
                if( true ){
                    $status = '<i class="fa fa-'.( $ar->status == 0 ? 'times' : 'check').' update-status" data-status="'.$ar->status.'" data-id="'.$ar->id.'" aria-hidden="true" data-table="reviews"></i>';
                } else {
                 $status = '<select class="form-control update-status badge '.( $ar->status == 0 ? 'bg-warning' : 'bg-success').' text-white" name="status" data-id="'.$ar->id.'" data-table="reviews">
                            <option value="1" '.($ar->status == 1 ? 'selected' : '').'>Active</option>
                            <option value="0" '.($ar->status == 0 ? 'selected' : '').'>De-Active</option>
                        </select>';
                }

                return $status;
            })
            ->addColumn('updated_at', function(Review $ar) {
                return formatDate( "Y-m-d H:i", $ar->updated_at );
            })
            ->addColumn('action', function(Review $ar ) {

                $action = '
                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="action_menu_'.$ar->id.'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        &#x22EE;
                    </button>
                    <div class="dropdown-menu" aria-labelledby="action_menu_'.$ar->id.'">
                    ';

                    if ($this->user->can('reviews.edit')) {
                        $action.= '<a class="btn btn-edit text-white dropdown-item" href="'.route('admin.reviews.edit', $ar->id).'">
                            <i class="fa fa-pencil"></i> Edit
                        </a>';
                    }

                    if ($this->user->can('reviews.delete')) {
                        $action.= '<button class="btn btn-edit text-white dropdown-item delete-record" data-id="'.$ar->id.'" data-title="'.$ar->name.'" data-segment="reviews">
                                        <i class="fa fa-trash fa-sm" aria-hidden="true"></i> Delete
                                    </button>';
                    }

                    $action.= '
                    </div>
                ';

                return $action;
            })
            ->rawColumns(['id', 'name', 'email','contact_no', 'review', 'rating', 'property_id', 'updated_at', 'status', 'action'])  // Specify the columns that contain HTML
            ->filter(function ($query) {
                if (request()->has('search')) {
                    $searchValue = request('search')['value'];
                    if( $searchValue != "" ){
                        $query->where('name', 'like', "%{$searchValue}%")
                            ->orWhere('display_name', 'like', "%{$searchValue}%");
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
        if (is_null($this->user) || !$this->user->can('reviews.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create Location !');
        }

        $continentObj = Review::where('status', 1)->get();
        return view('backend.pages.reviews.create', compact('continentObj'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('reviews.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create Review !');
        }

        // Validation Data
        $request->validate([
            'name' => 'required',
            'display_name' => 'required',
            'email' => 'required',
            'review' => 'required',
            'rating' => 'required',
          
        ]);

        // Create New Server Record
        $location = new Review();
        $location->admin_id = $this->user->id;
        $location->name = $request->name;
        $location->email = $request->email;
        $location->contact_no = $request->contact_no;
        $location->review = $request->review;
        $location->rating = $request->rating;
        $location->status = $request->status;
        $location->save();
            
        session()->flash('success', $request->name.' record has been created !!');
        return redirect()->route('admin.reviews.index');
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
        if (is_null($this->user) || !$this->user->can('reviews.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit Location !');
        }

        $data = Review::find($id);


        return view('backend.pages.reviews.edit', compact('data', 'continentObj', 'countryObj', 'stateObj', 'cityObj'));
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
        if (is_null($this->user) || !$this->user->can('reviews.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit Location !');
        }

        // Validation Data
        $request->validate([
            'name' => 'required',
            'display_name' => 'required',
            'address' => 'required',
            'continent_id' => 'required',
            'country_id' => 'required',
            'state_id' => 'required',
            'city_id' => 'required',
            'zipcode' => 'required',
        ]);

        // Create New Server Record
        $location = Review::find( $id );
        $location->admin_id = $this->user->id;
        $location->name = $request->name;
        $location->display_name = $request->display_name;
        $location->address = $request->address;
        $location->continent_id = $request->continent_id;
        $location->country_id = $request->country_id;
        $location->state_id = $request->state_id;
        $location->city_id = $request->city_id;
        $location->zipcode = $request->zipcode;
        $location->status = $request->status;
        $location->save();

        session()->flash('success', $request->display_name.' record has been updated !!');
        return redirect()->route('admin.reviews.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        if (is_null($this->user) || !$this->user->can('reviews.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete Location !');
        }

        $record = Review::find($id);

        if (!is_null($record)) {
            $record->delete();
        }

        // session()->flash('success', 'Record has been deleted !!');
        return response()->json( ['data' => ['message' => "'".$record->name.'" has been successfully deleted.' ] ], 200);
    }
}
