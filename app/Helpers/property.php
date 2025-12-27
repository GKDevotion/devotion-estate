<?php

use App\Models\Location;
use App\Models\Properties;
use App\Models\PropertyFeature;
use App\Models\PropertyFeatureMap;
use App\Models\PropertyImageMap;
use App\Models\PropertyType;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

/**
 * Create employee records
 */

function storePropertyRecord($request, $admin_id, $property_id = 0, $sendRegisterMail = 1)
{

    $msg = "created";

    $isRedirectThankYou = false;
    try {

        //creat new client or person
        if ($property_id) {
            $propertyDataObj = Properties::find($property_id);
            $msg = "updated";
        } else {
            $propertyDataObj = new Properties();
            $propertyDataObj->unique_id = "PID" . setPropertyUniqueNumber(4);
        }
        //1. Basic Information -->
        if ($request->step == 1 || $request->_method == "PUT") {

            $price = str_replace(',', '', $request->price);


            // 🟢 Handle "Other" location
            if ($request->location_id === 'other' && !empty($request->other_location)) {

                $name = trim($request->other_location);
                $slug = convertStringToSlug($name);

                $location = Location::firstOrCreate(
                    ['name' => $name],
                    [
                        'continent_id'  => 3,       // change if needed
                        'country_id'    => 231,     // UAE, etc.
                        'state_id'      => 3391,
                        'city_id'       => 32,
                        'admin_id'     => 1,
                        'address'      => $name,
                        'slug'         => $slug,
                        'display_name' => $name,
                        'status'       => 1,
                    ]
                );

                // ✅ Correctly assign created location id
                $location_id = $location->id;
            } else {
                // ✅ Fallback to selected existing location
                $location_id = $request->location_id ?? null;
            }

            $propertyDataObj->admin_id = $admin_id;
            $propertyDataObj->name = strip_tags($request->name);
            $propertyDataObj->building_name = $request->building_name;
            // $propertyDataObj->slug = convertStringToSlug($request->name);
            $propertyDataObj->h1_tag = $request->name;//$request->h1_tag;
            $propertyDataObj->seo_title = $request->name; //$request->seo_title;
            $propertyDataObj->meta_description = $request->name; //$request->meta_description;
            $propertyDataObj->description = $request->description;
            $propertyDataObj->purpose = $request->purpose;
            $propertyDataObj->type = $request->type;
            $propertyDataObj->sub_type_id = $request->sub_type_id;
            $propertyDataObj->is_furnish = $request->is_furnish;
            $propertyDataObj->is_complete = $request->is_complete;
            $propertyDataObj->is_occupancy = $request->is_occupancy;
            $propertyDataObj->off_plan_sale_type = $request->off_plan_sale_type;
            $propertyDataObj->completed_date = $request->completed_date;
            $propertyDataObj->quarter = $request->quarter;
            $propertyDataObj->payment_plan_id = $request->payment_plan_id;
            $propertyDataObj->plan_detail = $request->plan_detail;
            $propertyDataObj->rent_frequency = $request->rent_frequency;
            $propertyDataObj->rent_contract_period = $request->rent_contract_period ?? 0;
            $propertyDataObj->rent_notice_period = $request->rent_notice_period ?? 0;
            $propertyDataObj->maintenance_fees = $request->maintenance_fees ?? 0.00;
            $propertyDataObj->maintenance_paid = $request->maintenance_paid ?? 0.00;
            $propertyDataObj->is_finance_available  = $request->is_finance_available;
            $propertyDataObj->finance_name = $request->finance_name;
            $propertyDataObj->rera_number = $request->rera_number;
            $propertyDataObj->permit_number = $request->permit_number;
            $propertyDataObj->location_id = $location_id;
            $propertyDataObj->developer_id =  $request->developer_id;
            $propertyDataObj->agent_id  = $request->agent_id;
            // $propertyDataObj->publish = 0;
            $propertyDataObj->beds = $request->beds;
            $propertyDataObj->baths = $request->baths;
            $propertyDataObj->area = $request->area;
            $propertyDataObj->price = $price;
            // $propertyDataObj->status = $status;

            $propertyDataObj->save();

            $propertyDataObj->slug = $propertyDataObj->id.'-'.convertStringToSlug($request->name);
            $propertyDataObj->save();
        }

        //2. Job Information -->
        if ($request->step == 2 || $request->_method == "PUT") {

            $propertyDataObj->additional_features = $request->additional_features;

            // --- Store property flags safely ---
            $propertyDataObj->is_new_property = $request->is_new_property;
            $propertyDataObj->is_featured_property = $request->is_featured_property;
            $propertyDataObj->is_luxury_property = $request->is_luxury_property;
            $propertyDataObj->is_hot_offer = $request->is_hot_offer;
            // $propertyDataObj->is_new_property = $request->has('is_new_property') ? 1 : 0;
            // $propertyDataObj->is_featured_property = $request->has('is_featured_property') ? 1 : 0;
            // $propertyDataObj->is_luxury_property = $request->has('is_luxury_property') ? 1 : 0;
            // $propertyDataObj->is_hot_offer = $request->has('is_hot_offer') ? 1 : 0;

            // Save property data first
            $propertyDataObj->save();

            // --- Handle property features dynamically ---
            if (!empty($request->feature_id)) {

                // Reset previous property-feature mappings
                PropertyFeatureMap::where('property_id', $property_id)->update(['status' => 0]);

                // Convert CKEditor input text into an array of feature names
                // This handles input separated by commas, new lines, or both
                $features = preg_split('/[\r\n,]+/', $request->feature_id);

                // Trim and remove empty values
                $features = array_filter(array_map('trim', $features));

                // Get the current max sort_order (to continue sequence)
                $lastSortOrder = PropertyFeature::max('sort_order') ?? 0;

                foreach ($features as $featureName) {
                    if ($featureName !== '') {

                        // Create the feature if it doesn’t exist
                        $feature = PropertyFeature::firstOrCreate(
                            ['name' => ucfirst(strtolower($featureName))], // normalize text
                            ['admin_id'    => 1,], // Default admin
                            ['sort_order'  => $lastSortOrder += 2], // increment by 2
                            ['status' => 1]
                        );

                        // Map the feature to the property
                        PropertyFeatureMap::updateOrCreate(
                            [
                                'property_id' => $property_id,
                                'feature_id'  => $feature->id,
                            ],
                            [
                                'status' => 1,
                            ]
                        );
                    }
                }
            }
        }

        //3. Reference Information -->
        if ($request->step == 3 || $request->_method == "PUT") {


            /**
             * ✅ 1️⃣ Handle Deletions First
             * You’ll receive an array of image IDs or filenames via checkboxes in the form: name="delete_images[]"
             */
            if ($request->has('delete_images')) {
                foreach ($request->delete_images as $imageId) {
                    $imageMap = PropertyImageMap::find($imageId);
                    if ($imageMap) {
                        $filePath = str_replace('/storage/', '', $imageMap->filename);
                        $storagePath = storage_path('app/' . $filePath);

                        if (file_exists($storagePath)) {
                            unlink($storagePath);
                        }

                        $imageMap->delete(); // remove DB record
                    }
                }
            }


            $uploadedImages = [];

            if ($request->file('propertyImage')) {
                foreach ($request->file('propertyImage') as $file) {

                    // Create unique filename
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                    // Open image
                    $img = Image::make($file->getRealPath());

                    // Add copyright watermark (icon or text)
                    // 1️⃣ Add copyright text
                    $img->text('©DevotionEstate', $img->width() - 10, $img->height() - 10, function ($font) {
                        $font->file(public_path('backend/assets/fonts/themify.ttf')); // optional custom font
                        $font->size(24);
                        $font->color([255, 255, 255, 0.8]);
                        $font->align('left');
                        $font->valign('bottom');
                    });

                    // OR 2️⃣ Add watermark icon (replace with your logo path)

                    $watermark = public_path('img/devotion-trusted-real-estate.png'); // original watermark
                    if (file_exists($watermark)) {
                        // Load and resize the watermark
                        $watermarkImg = Image::make($watermark)->resize(240, 60, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        });

                        // Insert resized watermark into main image
                        $img->insert($watermarkImg, 'bottom-right', 10, 3);
                    }

                    // Save to storage
                    $path = 'propertyImage/' . $filename;
                    Storage::put($path, (string) $img->encode());

                    $uploadedImages[] = [
                        'image' => Storage::url($path),
                        'filename' => $filename
                    ];
                }

                //reset Property Feature Map status
                PropertyImageMap::where('property_id', $property_id)->update(['status' => 0]);

                foreach ($uploadedImages as $ar) {

                    PropertyImageMap::updateOrCreate(
                        [
                            'property_id' => $property_id,
                            'image' => $ar['image'],
                            'filename' => $ar['filename'],
                        ], // Search criteria
                        [
                            'status' => 1
                        ] // Attributes to update or create
                    );
                }

                //update proper property status
                $propertyDataObj->publish = $request->publish;
                $propertyDataObj->status = $request->status;
                $propertyDataObj->save();
            }

            $isRedirectThankYou = true;
        }

        return ['type' => 'success', 'id' => $propertyDataObj->id, 'unique_id' => $propertyDataObj->unique_id,  'message' => $propertyDataObj->name . ' has been ' . $msg . ' !!', 'status_code' => 200, 'isRedirectThankYou' => $isRedirectThankYou];
    } catch (Exception $e) {

        // removeEmployeeHistoryData( $personId );
        return ['type' => 'error', 'message' => $e->getMessage(), 'status_code' => 500];
    }
}

/**
 * Generate property Unique Alpha Numeric Number
 *
 * @param integer $type
 * @param integer $no
 * @param integer $company_id
 * @return void
 */
function setPropertyUniqueNumber($no = 4)
{
    $propertyCountObj = Properties::select('id');
    $value = $propertyCountObj->count() + 1;
    return str_pad($value, $no, '0', STR_PAD_LEFT);
}

/**
 *
 */
function getPropertyFeatures()
{
    return PropertyFeature::select('id', 'name')->where('status', 1)->get();
}

/**
 * $type = 0: 'All', 1: 'Sale', 2:'rent , 3:'land'
 */
function getPropertiesByType($type = [1])
{
    $sliderPage = getConfigurationField('SLIDER_PER_PAGE'); //get slider per page
    return Properties::with('subType', 'location', 'single_image')
        ->whereIn('purpose', $type)
        ->where([
            'status' => 1,
            'publish' => 1
        ])
        ->where('status', "!=" , 2)// 2 : Deleted
        // ->groupBy( 'developer_id' )
        ->latest()
        ->take($sliderPage)
        ->get();
}


function getSearchByProperties($request, $perPage = 4)
{
    $query = Properties::where([
            'status' => 1,
            'publish' => 1
        ])
        ->where('status', "!=" , 2);// 2 : Deleted;


 // 🔹 Detect page source (rent, buy, offplan, luxury, etc.)
    $redirectPage = $request['redirect_page'] ?? null;

    if ($redirectPage) {
        switch ($redirectPage) {
            case 'buy':
                $query->where('purpose', 1);
                break;
            case 'rent':
                $query->where('purpose', 2);
                break;
            case 'off':
                $query->where('is_complete', 3);
                break;
            case 'hot':
                $query->where('is_hot_offer', 1);
                break;
            case 'new':
                $query->where('is_new_property', 1);
                break;
            case 'luxury':
                $query->where('is_luxury_property', 1); // ✅ limit to luxury
                break;
        }
    }

    if (!empty($request['location'] ?? null)) {
        $query->where('location_id', $request['location']);
    }

    if (!empty($request['type'] ?? null)) {
        $query->where('type', $request['type']);
    }

    if (!empty($request['sub_type'] ?? null)) {
        $query->where('sub_type_id', $request['sub_type']);
    }

        // ✅ Bed filter
    if (!empty($request['bed'])) {
        $query->where('beds', '>=', $request['bed']); // can also use '=' if you want exact match
    }

    // ✅ Bath filter
    if (!empty($request['bath'])) {
        $query->where('baths', '>=', $request['bath']); // or '='
    }

    $type = $request['type'] ?? null;

    // ✅ Price range
    if (!empty($request['min_price'] ?? null) && !empty($request['max_price'] ?? null)) {
        $query->whereBetween('price', [$request['min_price'], $request['max_price']]);
    } else {
        if (!empty($request['min_price'] ?? null)) {
            $query->where('price', '>=', $request['min_price']);
        }
        if (!empty($request['max_price'] ?? null)) {
            $query->where('price', '<=', $request['max_price']);
        }
    }

    // ✅ Keyword search
    if (!empty($request['keyword'] ?? null)) {
        $keyword = trim($request['keyword']);
        $query->where(function ($q) use ($keyword) {
            $q->where('name', 'like', "%{$keyword}%")
              ->orWhere('h1_tag', 'like', "%{$keyword}%")
              ->orWhere('description', 'like', "%{$keyword}%")
              ->orWhere('meta_description', 'like', "%{$keyword}%")
              ->orWhere('additional_features', 'like', "%{$keyword}%")
              ->orWhere('finance_name', 'like', "%{$keyword}%")
              ->orWhere('rera_number', 'like', "%{$keyword}%")
              ->orWhere('permit_number', 'like', "%{$keyword}%");

            $q->orWhereHas('location', function ($locQuery) use ($keyword) {
                $locQuery->where('name', 'like', "%{$keyword}%");
            });
        });
    }

    $properties = $query->paginate($perPage)->withQueryString();
    $total = $properties->total();
    $locationObj = Location::select('id', 'name')
        ->where('status', 1)
        ->orderBy('name', 'asc')  // sorted alphabetically
        ->get();

    $featureObj = PropertyFeature::select('id', 'name')->where('status', 1)->get();

    $propertyTypeObj = PropertyType::select('id', 'name', 'main_type')->orderBy('name')->get();
    $residentialTypes = PropertyType::select('id', 'name', 'main_type')->where('main_type', 1)->where('status', 1)->get();
    $commercialTypes = PropertyType::select('id', 'name', 'main_type')->where('main_type', 2)->where('status', 1)->get();

    return compact(
        'properties',
        'locationObj',
        'featureObj',
        'propertyTypeObj',
        'residentialTypes',
        'commercialTypes',
        'total',
        'perPage',
        'type',
    );
}
