<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\PaymentPlan;
use App\Models\Properties;
use App\Models\PropertyFeature;
use App\Models\PropertyFeatureMap;
use App\Models\PropertyImageMap;
use App\Models\PropertyType;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
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

        $param = [
            'field' => '',
            'value' => 0
        ];

        return view('backend.pages.properties.index', compact('param'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function newPropertyindex( Request $request )
    {
        if (is_null($this->user) || !$this->user->can('properties.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view Location !');
        }

        $param = [
            'field' => 'is_new_property',
            'value' => 1
        ];

        return view( 'backend.pages.properties.index', compact('param') );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function featurePropertyindex( Request $request )
    {
        if (is_null($this->user) || !$this->user->can('properties.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view Location !');
        }

        $param = [
            'field' => 'is_featured_property',
            'value' => 1
        ];

        return view( 'backend.pages.properties.index', compact('param') );
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

        /**
         * set dynamic other property features
         * like: new, feature, luxury, etc...,
         */
        if( $request->field && $request->value ){
            $query->where( $request->field, $request->value );
        }

        $query->select('id', 'unique_id', 'name', 'purpose', 'type', 'publish', 'area', 'price', 'location_id', 'count','status', 'updated_at' );

        return DataTables::eloquent($query)
            ->addColumn('id', function(Properties $ar) {
                return $ar->id;
            })
            ->addColumn('unique_id', function(Properties $ar) {
                return $ar->unique_id;
            })
            ->addColumn('image', function(Properties $ar) {
                return $ar->single_image->image ?? '';
            })
            ->addColumn('name', function(Properties $ar) {
                return $ar->name;
            })
            ->addColumn('purpose', function (Properties $ar) {
                switch ($ar->purpose) {
                    case 1:
                        return 'Sale';
                    case 2:
                        return 'Rent';
                    case 2:
                        return 'Land';
                    default:
                        return 'All';
                }
            })

            ->addColumn('type', function (Properties $ar) {
                switch ($ar->type) {
                    case 1:
                        return 'Residential';
                    case 2:
                        return 'Commercial';
                    default:
                        return 'All';
                }
            })

            ->addColumn('publish', function (Properties $ar) {
                return $ar->publish ? 'Published' : 'Un Publish';
            })
            ->addColumn('area', function (Properties $ar) {
                return $ar->area;
            })
            ->addColumn('price', function (Properties $ar) {
                return $ar->price;
            })
            ->addColumn('location_id', function (Properties $ar) {
                return $ar->location->name;
            })
            ->addColumn('count', function(Properties $ar) {
                return $ar->count;
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
                        $action .= '<form method="POST" action="' .  route('admin.properties.destroy', $ar->id) . '" style="display:inline;">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="btn btn-edit text-white dropdown-item" onclick="return confirm(\'Are you sure you want to delete ' . $ar->name . '?\');">
                                <i class="fa fa-trash fa-sm" aria-hidden="true"></i> Delete
                            </button>
                        </form>';
                        }


                    $action.= '
                    </div>
                ';

                return $action;
            })
            ->rawColumns(['id', 'unique_id', 'name', 'purpose', 'type', 'publish', 'area', 'price', 'location_id', 'count', 'status', 'updated_at', 'action'])  // Specify the columns that contain HTML
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
        $paymentPlanObj = PaymentPlan::select('id', 'name')->where( 'status', 1 )->get();
        $propertyTypeObj = PropertyType::select('id', 'main_type', 'name')->where( 'status', 1 )->get();
        $locationObj = Location::select('id', 'name')->where( 'status', 1 )->get();
        $agentObj = User::select('id', 'first_name', 'last_name')->where( [
            'status' => 1,
            'type' => 4
        ] )->get();

        return view('backend.pages.properties.create', compact( 'propertyTypeObj', 'locationObj','paymentPlanObj', 'agentObj' ));
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

        if( $request->step == 1 ){

            $request->validate([
                'name' => 'required',
                'seo_title' => 'required',
                'h1_tag' => 'required',
                'meta_description' => 'required',
                'description' => 'required',
            ]);
        }

        $propertyId = 0;
        if( $request->step > 1 || $request->id != 0 ){
            $propertyId = $request->id;
        }

        $personDataObj = storePropertyRecord( $request, $this->admin_id, $propertyId, 0 );

        return response()->json( $personDataObj );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $property = Properties::with('agent')->where('slug', $slug)->firstOrFail();

        // Determine the property type label based on DB value
        $typeMap = [
            0 => 'All',
            1 => 'Sale',
            2 => 'Rent'
        ];

        $type = $typeMap[$property->type] ?? 'Unknown';

        // ✅ Fetch all active agents linked to any property
        $agent = User::whereIn(
            'designation_id',
            Properties::whereNotNull('agent_id')->pluck('agent_id')->unique()
        )
            ->where('status', 1)
            ->where('type', 4)
            ->get();

        return view('frontend.pages.properties-detail', compact('property', 'type', 'agent'));
    }


    public function search(Request $request)
    {
        $perPage = $request->get('perPage', 4);

        $filters = [
            'min_price'     => $request->min_price,
            'max_price'     => $request->max_price,
            'property_type' => $request->property_type,
            'location_id'   => $request->location_id,
            'type'          => $request->type ?? 'sale', // 'sale', 'rent', 'off-plan'

        ];

        // Fetch data
        $data = getSearchByProperties($filters, $perPage);

        // Add extra values for blade
        $data['perPage'] = $perPage;
        $data['type'] = $filters['type']; // ✅ ensure $type is available in blade

        // Detect which main blade to load
        switch ($filters['type']) {
            case 'rent':
                $view = 'frontend.pages.rent-properties';
                break;
            case 'off':
                $view = 'frontend.pages.off-plan';
                break;
            case 'luxury':
                $view = 'frontend.pages.luxury-properties';
                break;
            case 'hot':
                $view = 'frontend.pages.hot-offer';
                break;
            default:
                $view = 'frontend.pages.buy-properties';
                break;
        }

        // ✅ Return main page with data
        return view($view, $data );
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
        $paymentPlanObj = PaymentPlan::select('id', 'name')->where( 'status', 1 )->get();
        $propertyTypeObj = PropertyType::select('id', 'main_type', 'name')->where('status', 1)->get();
        $locationObj = Location::select('id', 'name')->where('status', 1)->get();
        $agentObj = User::select('id', 'first_name', 'last_name')->where([
            'status' => 1,
            'type' => 4
        ])->get();


        $data = Properties::findOrFail($id);

        $featureMap = [];
        if( $data->featureMap ){
            foreach( $data->featureMap as $dt ){
                $featureMap[] = $dt->feature_id;
            }
        }

        return view('backend.pages.properties.edit', compact('data', 'propertyTypeObj','paymentPlanObj', 'locationObj', 'agentObj', 'featureMap' ));
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

            //delete Featured property map if applicable
            PropertyFeatureMap::where( 'property_id', $id )->delete();

            //delete property image map if applicable
            PropertyImageMap::where( 'property_id', $id )->delete();

            //delete proerty
            $record->delete();
        }

        return response()->json( ['data' => ['message' => "'".$record->name.'" has been successfully deleted.' ] ], 200);
    }


    public function sendMail($agent_id)
{
    $agent = User::where('id', $agent_id)
        ->where('status', 1)
        ->where('type', 4)
        ->firstOrFail();

    $subject = 'Property Inquiry';
    $messageBody = "Hello {$agent->first_name},\n\nI am interested in one of your properties. Please share more details.";

    try {
        Mail::raw($messageBody, function ($message) use ($agent, $subject) {
            $message->to($agent->email_id)
                    ->subject($subject)
                    ->from('support@devotionestate.com', 'Devotion Estate');
        });

        return back()->with('success', 'Inquiry email sent successfully to the agent!');
    } catch (\Exception $e) {
        return back()->with('error', 'Failed to send email. Please try again later.');
    }
}
}
