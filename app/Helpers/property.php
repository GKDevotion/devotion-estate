<?php

use App\Models\Properties;
use App\Models\PropertyFeature;
use App\Models\PropertyFeatureMap;
use App\Models\PropertyImageMap;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

/**
 * Create employee records
 */
function storePropertyRecord( $request, $admin_id, $property_id=0, $sendRegisterMail=1 ){

    $msg = "created";

    $isRedirectThankYou = false;
    try{

        //creat new client or person
        if( $property_id ){
            $propertyDataObj = Properties::find($property_id);
            $propertyDataObj->unique_id = "PID".setPropertyUniqueNumber( 4 );
            $msg = "updated";
        } else {
            $propertyDataObj = new Properties();
            $propertyDataObj->admin_id = $admin_id;
        }

        //1. Basic Information -->
        if( $request->step == 1 || $request->_method == "PUT" ){

            $propertyDataObj->name = $request->name;
            $propertyDataObj->slug = convertStringToSlug( $request->name );
            $propertyDataObj->h1_tag = $request->h1_tag;
            $propertyDataObj->seo_title = $request->seo_title;
            $propertyDataObj->meta_description = $request->meta_description;
            $propertyDataObj->description = $request->description;
            $propertyDataObj->purpose = $request->purpose;
            $propertyDataObj->type = $request->type;
            $propertyDataObj->sub_type_id = $request->sub_type_id;
            $propertyDataObj->is_furnish = $request->is_furnish;
            $propertyDataObj->is_complete = $request->is_complete;
            $propertyDataObj->is_occupancy = $request->is_occupancy;
            $propertyDataObj->off_plan_sale_type = $request->off_plan_sale_type;
            $propertyDataObj->completed_date = $request->completed_date;
            $propertyDataObj->rent_frequency = $request->rent_frequency;
            $propertyDataObj->rent_contract_period = $request->rent_contract_period ?? 0;
            $propertyDataObj->rent_notice_period = $request->rent_notice_period ?? 0;
            $propertyDataObj->maintenance_fees = $request->maintenance_fees ?? 0.00;
            $propertyDataObj->maintenance_paid = $request->maintenance_paid ?? 0.00;
            $propertyDataObj->is_finance_available  = $request->is_finance_available;
            $propertyDataObj->finance_name = $request->finance_name;
            $propertyDataObj->rera_number = $request->rera_number;
            $propertyDataObj->permit_number = $request->permit_number;
            $propertyDataObj->location_id = $request->location_id;
            $propertyDataObj->agent_id  = $request->agent_id ;
            $propertyDataObj->publish = 0;
            $propertyDataObj->area = $request->area;
            $propertyDataObj->price = $request->price;
            $propertyDataObj->status = 0;

            $propertyDataObj->save();
        }

        //2. Job Information -->
        if( $request->step == 2 || $request->_method == "PUT" ){

            // --- Store property flags safely ---
            $propertyDataObj->is_new_property = $request->has('is_new_property') ? 1 : 0;
            $propertyDataObj->is_featured_property = $request->has('is_featured_property') ? 1 : 0;
            $propertyDataObj->is_luxury_property = $request->has('is_luxury_property') ? 1 : 0;
            $propertyDataObj->is_hot_offer = $request->has('is_hot_offer') ? 1 : 0;

            // Save before mapping features
            $propertyDataObj->save();
            if (COUNT($request->feature_id) > 0) {

                //reset Property Feature Map status
                PropertyFeatureMap::where('property_id', $property_id)->update(['status' => 0]);

                // Remove null and empty values
                $featureIds = array_filter($request->feature_id, function ($value) {
                    return !is_null($value) && $value !== '';
                });

                foreach ($featureIds as $id) {

                    PropertyFeatureMap::updateOrCreate(
                        [
                            'property_id' => $property_id,
                            'feature_id' => $id,
                        ], // Search criteria
                        [
                            'status' => 1
                        ] // Attributes to update or create
                    );
                }
            }
        }

        //3. Reference Information -->
        if( $request->step == 3 || $request->_method == "PUT" ){

            $uploadedImages = [];

            if( $request->file('propertyImage') ){
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
                PropertyImageMap::where( 'property_id', $property_id )->update( ['status' => 0 ] );

                foreach( $uploadedImages as $ar ){

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

        return [ 'type' => 'success', 'id' => $propertyDataObj->id, 'unique_id' => $propertyDataObj->unique_id,  'message' => $propertyDataObj->name.' has been '.$msg.' !!', 'status_code' => 200, 'isRedirectThankYou' => $isRedirectThankYou ];

    } catch ( Exception $e ){

        // removeEmployeeHistoryData( $personId );
        return [ 'type' => 'error', 'message' => $e->getMessage(), 'status_code' => 500 ];
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
function setPropertyUniqueNumber( $no = 4 ){
    $propertyCountObj = Properties::select('id');
    $value = $propertyCountObj->count() + 1;
    return str_pad($value, $no, '0', STR_PAD_LEFT);
}

/**
 *
 */
function getPropertyFeatures(){
    return PropertyFeature::select('id', 'name')->where( 'status', 1 )->get();
}

/**
 * $type = 0: 'sell', 1: 'rent'
 */
function getPropertiesByType($type = [0])
{
    $sliderPage = getConfigurationField('SLIDER_PER_PAGE');//get slider per page
    return Properties::with('subType', 'location', 'single_image')
        ->whereIn('purpose', $type)
        ->where('status', 1)
        ->latest()
        ->take($sliderPage)
        ->get();
}
