<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Developer;
use App\Models\Location;
use App\Models\PaymentPlan;
use App\Models\Properties;
use App\Models\PropertyFeature;
use App\Models\PropertyFeatureMap;
use App\Models\PropertyImageMap;
use App\Models\PropertyType;
use App\Models\PropertyVariant;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
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
    public function index(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('properties.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view Location !');
        }

        $param = [
            'field' => '',
            'value' => 0
        ];
        $properties = Properties::latest()->get();
        $locations = Location::all(); // or however you fetch locations
        $agentObj = User::select('id', 'first_name', 'last_name')->where([
            'status' => 1,
            'type' => 4
        ])->get();
        $developerObj = Developer::select('id', 'name')->where('status', 1)->get();

        return view('backend.pages.properties.index', compact('param', 'locations', 'agentObj', 'properties', 'developerObj'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function newPropertyindex(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('properties.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view Location !');
        }

        $param = [
            'field' => 'is_new_property',
            'value' => 1
        ];
        $properties = Properties::latest()->get();
        $agentObj = User::select('id', 'first_name', 'last_name')->where([
            'status' => 1,
            'type' => 4
        ])->get();
        $developerObj = Developer::select('id', 'name')->where('status', 1)->get();
        $locations = Location::all(); // or however you fetch locations
        return view('backend.pages.properties.index', compact('param', 'agentObj', 'developerObj', 'locations', 'properties'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function luxuryPropertyindex(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('properties.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view Location !');
        }

        $param = [
            'field' => 'is_luxury_property',
            'value' => 1
        ];
        $properties = Properties::latest()->get();
        $agentObj = User::select('id', 'first_name', 'last_name')->where([
            'status' => 1,
            'type' => 4
        ])->get();
        $developerObj = Developer::select('id', 'name')->where('status', 1)->get();
        $locations = Location::all(); // or however you fetch locations
        return view('backend.pages.properties.index', compact('param', 'agentObj', 'developerObj', 'locations', 'properties'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function hotPropertyindex(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('properties.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view Location !');
        }

        $param = [
            'field' => 'is_hot_offer',
            'value' => 1
        ];
        $properties = Properties::latest()->get();
        $agentObj = User::select('id', 'first_name', 'last_name')->where([
            'status' => 1,
            'type' => 4
        ])->get();
        $developerObj = Developer::select('id', 'name')->where('status', 1)->get();
        $locations = Location::all(); // or however you fetch locations
        return view('backend.pages.properties.index', compact('param', 'agentObj', 'developerObj', 'locations', 'properties'));
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function featurePropertyindex(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('properties.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view Location !');
        }

        $param = [
            'field' => 'is_featured_property',
            'value' => 1
        ];
        $properties = Properties::latest()->get();
        $agentObj = User::select('id', 'first_name', 'last_name')->where([
            'status' => 1,
            'type' => 4
        ])->get();
        $developerObj = Developer::select('id', 'name')->where('status', 1)->get();
        $locations = Location::all(); // or however you fetch locations
        return view('backend.pages.properties.index', compact('param', 'agentObj', 'developerObj', 'locations', 'properties'));
    }

    /**
     *
     */
    public function ajaxIndex(Request $request)
    {

        $this->setPublicVar();

        $query = Properties::query()->orderBy('id', 'DESC');

        if (!$this->is_assign_super_admin) {
            $query->where('admin_id', $this->admin_id);
        }

        $query->where('status', "!=", 2);// 2 : Deleted

        /**
         * set dynamic other property features
         * like: new, feature, luxury, etc...,
         */
        if ($request->field && $request->value) {
            $query->where($request->field, $request->value);
        }

        $query->select('id', 'unique_id', 'developer_id', 'name', 'slug', 'purpose', 'type', 'publish', 'area', 'price', 'location_id', 'count', 'status', 'updated_at', 'is_hot_offer', 'is_luxury_property', 'is_featured_property', 'is_new_property');

        return DataTables::eloquent($query)
            ->addColumn('id', function (Properties $ar) {
                return $ar->id;
            })

            ->addColumn('unique_id', function (Properties $ar) {
                return $ar->unique_id;
            })

            ->addColumn('image', function (Properties $ar) {
                $image = optional($ar->images->first())->filename;

                if ($image) {
                    return '<img src="' . asset('storage/app/propertyImage/' . $image) . '"
                 width="80" height="60" style="object-fit:cover; border-radius:4px;" />';
                }

                return 'No Image';
            })

            ->addColumn('name', function (Properties $ar) {

                $name = '<a href="' . url('property/' . ($ar->slug ?? '')) . '" class="fw-bold text-center" target="_blank" style=" text-decoration:none; color: #ab8134; ">'
                    . ($ar->name ?? '') .
                    '</a>';

                if ($ar->developer) {
                    $name .= " (" . $ar->developer->name . ")";
                }

                return $name;
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
                // return $ar->publish ? 'Published' : 'Un Publish';
                return '<i class="fa fa-' . ($ar->publish == 0 ? 'times' : 'check') . ' update-field-status" data-field="publish" data-status="' . $ar->publish . '" data-id="' . $ar->id . '" aria-hidden="true" data-table="properties"></i>';
            })
            ->addColumn('area', function (Properties $ar) {
                return $ar->area;
            })
            ->addColumn('price', function (Properties $ar) {
                return $ar->price;
            })
            ->addColumn('location_id', function (Properties $ar) {
                return $ar->location->name ?? '';
            })
            ->addColumn('count', function (Properties $ar) {
                return $ar->count;
            })

            ->addColumn('status', function (Properties $ar) {
                $status = "";
                if (true) {
                    $status = '<i class="fa fa-' . ($ar->status == 0 ? 'times' : 'check') . ' update-status" data-status="' . $ar->status . '" data-id="' . $ar->id . '" aria-hidden="true" data-table="properties"></i>';
                } else {
                    $status = '<select class="form-control update-status badge ' . ($ar->status == 0 ? 'bg-warning' : 'bg-success') . ' text-white" name="status" data-id="' . $ar->id . '" data-table="properties">
                            <option value="1" ' . ($ar->status == 1 ? 'selected' : '') . '>Active</option>
                            <option value="0" ' . ($ar->status == 0 ? 'selected' : '') . '>De-Active</option>
                        </select>';
                }

                return $status;
            })
            ->addColumn('is_new_property', function (Properties $ar) {
                return '<i class="fa fa-' . ($ar->is_new_property == 0 ? 'times' : 'check') . ' update-field-status" data-field="is_new_property" data-status="' . $ar->is_new_property . '" data-id="' . $ar->id . '" aria-hidden="true" data-table="properties"></i>';
            })
            ->addColumn('is_featured_property', function (Properties $ar) {
                return '<i class="fa fa-' . ($ar->is_featured_property == 0 ? 'times' : 'check') . ' update-field-status" data-field="is_featured_property" data-status="' . $ar->is_featured_property . '" data-id="' . $ar->id . '" aria-hidden="true" data-table="properties"></i>';
            })
            ->addColumn('is_luxury_property', function (Properties $ar) {
                return '<i class="fa fa-' . ($ar->is_luxury_property == 0 ? 'times' : 'check') . ' update-field-status" data-field="is_luxury_property" data-status="' . $ar->is_luxury_property . '" data-id="' . $ar->id . '" aria-hidden="true" data-table="properties"></i>';
            })
            ->addColumn('is_hot_offer', function (Properties $ar) {
                return '<i class="fa fa-' . ($ar->is_hot_offer == 0 ? 'times' : 'check') . ' update-field-status" data-field="is_hot_offer" data-status="' . $ar->is_hot_offer . '" data-id="' . $ar->id . '" aria-hidden="true" data-table="properties"></i>';
            })
            ->addColumn('updated_at', function (Properties $ar) {
                return formatDate("Y-m-d H:i", $ar->updated_at);
            })
            ->addColumn('action', function (Properties $ar) {

                $action = '
                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="action_menu_' . $ar->id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        &#x22EE;
                    </button>
                    <div class="dropdown-menu" aria-labelledby="action_menu_' . $ar->id . '">
                    ';

                if ($this->user->can('properties.edit')) {

                    $action .= '<a href="javascript:void(0);" class="btn btn-edit text-white dropdown-item btn-description" data-id="' . $ar->id . '" data-description="' . htmlspecialchars($ar->description, ENT_QUOTES) . '">
                    <i class="fa fa-pencil"></i> Description
                      </a>';

                    $action .= '<a href="javascript:void(0);"
                                class="btn btn-edit text-white dropdown-item btn-information"
                                data-id="' . $ar->id . '"
                                data-name="' . htmlspecialchars($ar->name, ENT_QUOTES) . '"
                                data-price="' . $ar->price . '"
                                data-location="' . htmlspecialchars(optional($ar->location)->name, ENT_QUOTES) . '"
                                data-agent="' . htmlspecialchars(optional($ar->agent)->name, ENT_QUOTES) . '"
                                data-developer="' . htmlspecialchars(optional($ar->developer)->name, ENT_QUOTES) . '"
                                data-features="' . $ar->additional_features . '"
                                data-building="' . $ar->building_name . '"
                            >
                            <i class="fa fa-pencil"></i> Other Information
                            </a>';

                    $action .= '<a href="javascript:void(0);"
                                class="btn btn-edit text-white dropdown-item btn-variant"
                                data-id="' . $ar->id . '"
                                data-price=\'' . json_encode(json_decode($ar->variants["price"] ?? "[]")) . '\'
                                data-property-type=\'' . json_encode(json_decode($ar->variants["property_type"] ?? "[]")) . '\'
                                data-size=\'' . json_encode(json_decode($ar->variants["size"] ?? "[]")) . '\'
                                data-bed=\'' . json_encode(json_decode($ar->variants["bed"] ?? "[]")) . '\'
                                data-bath=\'' . json_encode(json_decode($ar->variants["bath"] ?? "[]")) . '\'
                                >
                                <i class="fa fa-pencil"></i> Variants
                                </a>';



                    $action .= '<a class="btn btn-edit text-white dropdown-item" href="' . route('admin.properties.imageOrder', $ar->id) . '">
                            <i class="fa fa-pencil"></i> Image
                        </a>';

                    $action .= '<a class="btn btn-edit text-white dropdown-item" href="' . route('admin.properties.edit', $ar->id) . '">
                            <i class="fa fa-pencil"></i> Edit
                        </a>';
                }


                if ($this->user->can('properties.delete')) {
                    $action .= '<button class="btn btn-edit text-white delete-record dropdown-item" data-id="' . $ar->id . '" data-title="' . $ar->name . '" data-segment="properties">
                    <i class="fa fa-trash fa-sm" aria-hidden="true"></i> Delete
                    </button>';
                }

                $action .= '
                    </div>
                ';

                return $action;
            })
            ->rawColumns(['id', 'image', 'unique_id', 'developer', 'name', 'purpose', 'type', 'publish', 'area', 'price', 'location_id', 'count', 'status', 'updated_at', 'action', 'is_hot_offer', 'is_luxury_property', 'is_featured_property', 'is_new_property'])  // Specify the columns that contain HTML
            ->filter(function ($query) {
                if (request()->has('search')) {
                    $searchValue = request('search')['value'];
                    if ($searchValue != "") {
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
        $paymentPlanObj = PaymentPlan::select('id', 'name')->where('status', 1)->get();
        $propertyTypeObj = PropertyType::select('id', 'main_type', 'name')->where('status', 1)->get();
        $propertyFeatureObj = PropertyFeature::select('id', 'name')->where('status', 1)->get();
        $locationObj = Location::select('id', 'name')->where('status', 1)->get();
        $properties = Properties::where('status', 1)
            ->where('id', '!=', $propertyDataObj->id ?? null)
            ->select('id', 'unique_id', 'name')
            ->get();

        $agentObj = User::select('id', 'first_name', 'last_name')->where([
            'status' => 1,
            'type' => 4
        ])->get();
        $developerObj = Developer::select('id', 'name')->where('status', 1)->get();

        return view('backend.pages.properties.create', compact('propertyTypeObj', 'properties', 'propertyFeatureObj', 'locationObj', 'paymentPlanObj', 'agentObj', 'developerObj'));
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

        if ($request->step == 1) {

            $request->validate([
                'name' => 'required',
                // 'seo_title' => 'required',
                // 'h1_tag' => 'required',
                // 'meta_description' => 'required',
                'description' => 'required',
            ]);
        }

        $this->setPublicVar();

        $propertyId = 0;
        if ($request->step > 1 || $request->id != 0) {
            $propertyId = $request->id;
        }

        $personDataObj = storePropertyRecord($request, $this->admin_id, $propertyId, 0);

        return response()->json($personDataObj);
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

        // In your PropertyController (show method)

        $relatedProperties = \App\Models\Properties::with(['images', 'location'])
            ->where('status', 1)
            ->where('id', '!=', $property->id)
            ->where(function ($q) use ($property) {
                $q->where('location_id', $property->location_id)
                    ->orWhere('developer_id', $property->developer_id);
            })
            ->latest()
            ->take(10)
            ->get();


        // ✅ Seller properties (by same agent, excluding current)
        $sellerProperties = \App\Models\Properties::with(['images', 'location'])
            ->where('status', 1)
            ->where('id', '!=', $property->id)
            ->where('agent_id', $property->agent_id)
            ->latest()
            ->take(10)
            ->get();

        // Fetch related IDs from variants table
        $variant = PropertyVariant::where('property_id', $property->id)->first();


        $relatedProperty = collect(); // empty collection by default

        if ($variant && $variant->related_id) {
            $relatedIds = json_decode($variant->related_id, true);

            $relatedProperty = Properties::whereIn('id', $relatedIds)
                ->where('status', 1)
                ->get();
        }



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

        $variant = PropertyVariant::where('property_id', $property->id)->first();

        $prices = $propertyTypes = $sizes = $beds = $baths = [];
        $count = 0;

        if ($variant) {
            $prices = json_decode($variant->price, true) ?? [];
            $propertyTypes = json_decode($variant->property_type, true) ?? [];
            $sizes  = json_decode($variant->size, true) ?? [];
            $beds  = json_decode($variant->bed, true) ?? [];
            $baths  = json_decode($variant->bath, true) ?? [];

            $count = max(
                count($prices),
                count($propertyTypes),
                count($sizes),
                count($beds),
                count($baths)
            );
        }

        return view('frontend.pages.properties-detail', compact('property', 'type', 'agent', 'sellerProperties', 'relatedProperties', 'relatedProperty', 'prices', 'propertyTypes', 'sizes', 'beds', 'baths', 'count'));
    }


    public function search(Request $request)
    {
        // dd( $request->all() );
        $perPage = $request->get('perPage', 4);

        // Fetch data
        $data = getSearchByProperties($request->all(), $perPage);

        // Add extra values for blade
        $data['perPage'] = $perPage;

        // Detect which main blade to load
        switch ($request->redirect_page) {
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
        return view($view, $data);
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

        $paymentPlanObj = PaymentPlan::select('id', 'name')->where('status', 1)->get();
        $propertyTypeObj = PropertyType::select('id', 'main_type', 'name')->where('status', 1)->get();
        $locationObj = Location::select('id', 'name')->where('status', 1)->get();
        $agentObj = User::select('id', 'first_name', 'last_name')->where([
            'status' => 1,
            'type' => 4
        ])->get();

        $data = Properties::with('variants')->findOrFail($id);

        $featureMap = [];
        if ($data->featureMap) {
            foreach ($data->featureMap as $dt) {
                $featureMap[] = $dt->feature_id;
            }
        }

        // dd($id, $data->variants);
        $paymentPlanArr = PaymentPlan::where('status', 1)->pluck('name', 'id'); //->select('id', 'name')->get();
        $developerObj = Developer::select('id', 'name')->where('status', 1)->get();

        return view('backend.pages.properties.edit', compact('data', 'propertyTypeObj', 'locationObj', 'agentObj', 'featureMap', 'paymentPlanArr', 'developerObj'));
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
        $location = Properties::findOrFail($id);
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

        session()->flash('success', $request->name . ' record has been updated !!');
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
            // PropertyFeatureMap::where('property_id', $id)->delete();

            //delete property image map if applicable
            // PropertyImageMap::where('property_id', $id)->delete();

            //delete proerty
            $record->status = 2;
            $record->save();
        }

        return response()->json(['data' => ['message' => "'" . $record->name . '" has been successfully deleted.']], 200);
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function imageOrder(int $id)
    {
        if (is_null($this->user) || !$this->user->can('properties.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit Property Features !');
        }

        $imageArr = PropertyImageMap::select('id', 'filename', 'sort_order')->where('property_id', $id)->get();

        return view('backend.pages.properties.image-order', compact('imageArr', 'id'));
    }

    /**
     *
     */
    public function imageOrderUpdate(Request $request)
    {
        $request->validate([
            'property_id' => 'required|integer'
        ]);

        $property_id = $request->property_id;
 
        // Count existing images (excluding deleted ones)
        $existingImagesCount = PropertyImageMap::where('property_id', $property_id)
            ->where('status', 1) // assuming status 1 = active
            ->whereNotIn('id', $request->delete_images ?? [])
            ->count();

        $maxImages = 5;
        $uploadedCount = count($request->file('propertyImage') ?? []);

        if ($existingImagesCount + $uploadedCount > $maxImages) {
            return back()->withErrors([
                'propertyImage' => "You can upload maximum " . ($maxImages - $existingImagesCount) . " more images."
            ])->withInput();
        }

        /* ----------------------------------------
     | 1️⃣ Update Sort Order
     ---------------------------------------- */
        if ($request->has('image_id') && $request->has('sort_order')) {
            foreach ($request->image_id as $key => $imageId) {
                if (isset($request->sort_order[$key])) {
                    PropertyImageMap::where('id', $imageId)->update([
                        'sort_order' => $request->sort_order[$key]
                    ]);
                }
            }
        }

        /* ----------------------------------------
     | 2️⃣ Handle Image Deletions
     ---------------------------------------- */
        if ($request->filled('delete_images')) {
            foreach ($request->delete_images as $imageId) {
                $imageMap = PropertyImageMap::find($imageId);

                if ($imageMap) {
                    $filePath = 'propertyImage/' . $imageMap->filename;

                    if (Storage::exists($filePath)) {
                        Storage::delete($filePath);
                    }

                    $imageMap->delete();
                }
            }
        }

        /* ----------------------------------------
     | 3️⃣ Handle New Image Uploads
     ---------------------------------------- */
        if ($request->hasFile('propertyImage')) {

            // ✅ Get last sort order once
            // ✅ Get max sort_order safely
            $lastSortOrder = PropertyImageMap::where('property_id', $property_id)
                ->whereNotNull('sort_order')
                ->max('sort_order');

            $lastSortOrder = (int) ($lastSortOrder ?? 0);

            foreach ($request->file('propertyImage') as $file) {

                if (!$file || !$file->isValid()) {
                    continue;
                }

                $ext = strtolower($file->getClientOriginalExtension());
                if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                    continue;
                }

                // $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)
                //     . '_' . time() . '_' . uniqid() . '.jpg';
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $filename = $originalName . '.' . $extension;

                $img = Image::make($file);

                // Watermark text
                $img->text('© DevotionEstate', $img->width() - 20, $img->height() - 20, function ($font) {
                    $font->size(20);
                    $font->color([255, 255, 255, 0.7]);
                    $font->align('right');
                    $font->valign('bottom');
                });

                // Logo watermark
                $watermarkPath = public_path('img/devotion-trusted-real-estate.png');
                if (is_file($watermarkPath)) {
                    $watermark = Image::make($watermarkPath)
                        ->resize(240, 60, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        });

                    // Insert resized watermark into main image
                    $img->insert($watermark, 'bottom-right', 10, 3);
                }


                $path = 'propertyImage/' . $filename;
                Storage::put($path, (string) $img->encode());

                // 🔥 increment correctly
                $lastSortOrder++;

                PropertyImageMap::create([
                    'property_id' => $property_id,
                    'image'       => $filename,
                    'filename'    => $filename,
                    'sort_order'  => $lastSortOrder,
                    'status'      => 1 
                ]);
            }
        }


        session()->flash('success', 'Property images updated successfully!');
        return redirect()->route('admin.properties.index');
    }

    // Description Model
    public function updateDescription(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:properties,id',
            'description' => 'nullable|string'
        ]);

        Properties::where('id', $request->id)->update([
            'description' => $request->description
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Description updated successfully'
        ]);
    }

    public function getDescription($id)
    {
        return response()->json(
            Properties::where('id', $id)->value('description')
        );
    }

    // Information Model
    public function getInformation($id)
    {
        return Properties::select('name', 'price', 'location_id', 'agent_id', 'developer_id', 'additional_features', 'building_name')
            ->findOrFail($id);
    }

    public function updateInformation(Request $request)
    {
        $property = Properties::findOrFail($request->id);
        $property->name = $request->name;
        $property->price = $request->price;
        $property->location_id = $request->location_id;
        $property->agent_id = $request->agent_id;
        $property->developer_id = $request->developer_id;
        $property->additional_features = $request->additional_features;
        $property->building_name = $request->building_name;
        $property->save();

        return response()->json(['success' => true]);
    }

    public function updateVariants(Request $request)
    {
        $request->validate([
            'property_id' => 'required|exists:properties,id',
        ]);

        PropertyVariant::updateOrCreate(
            [
                'property_id' => $request->property_id, // UNIQUE
            ],
            [
                'price'  => json_encode($request->price ?? []),
                'property_type' => json_encode($request->property_type ?? []),
                'size'   => json_encode($request->size ?? []),
                'bed'    => json_encode($request->bed ?? []),
                'bath'   => json_encode($request->bath ?? []),
                'status' => 1,
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Property variants updated successfully'
        ]);
    }
}
