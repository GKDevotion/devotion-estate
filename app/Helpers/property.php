<?php

use App\Models\Properties;
use App\Models\PropertyFeature;
use App\Models\PropertyFeatureMap;
use App\Models\PropertyImageMap;
use App\Models\PropertyNew;
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
            $msg = "updated";
        } else {
            $propertyDataObj = new Properties();
            $propertyDataObj->admin_id = $admin_id;
        }

        //1. Basic Information -->
        if( $request->step == 1 || $request->_method == "PUT" ){

            $propertyDataObj->unique_id = "PID".setPropertyUniqueNumber( 4 );
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
            $propertyDataObj->rent_contract_period = $request->rent_contract_period;
            $propertyDataObj->rent_notice_period = $request->rent_notice_period;
            $propertyDataObj->maintenance_fees = $request->maintenance_fees;
            $propertyDataObj->maintenance_paid = $request->maintenance_paid;
            $propertyDataObj->is_finance_available  = $request->is_finance_available ;
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
            if( COUNT( $request->feature_id ) > 0 ){

                //reset Property Feature Map status
                PropertyFeatureMap::where( 'property_id', $property_id )->update( ['status' => 0 ] );

                // Remove null and empty values
                $featureIds = array_filter( $request->feature_id, function($value) {
                    return !is_null($value) && $value !== '';
                });

                foreach( $featureIds as $id ){

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
                $watermark = public_path('img/devotion-trusted-real-estate.png'); // 100x100 transparent PNG
                if (file_exists($watermark)) {
                    $img->insert($watermark, 'bottom-right', 20, 10);
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

            $isRedirectThankYou = true;

        }

        return [ 'type' => 'success', 'id' => $propertyDataObj->id, 'unique_id' => $propertyDataObj->unique_id,  'message' => $propertyDataObj->name.' has been '.$msg.' !!', 'status_code' => 200, 'isRedirectThankYou' => $isRedirectThankYou ];

    } catch ( Exception $e ){

        // removeEmployeeHistoryData( $personId );
        return [ 'type' => 'error', 'message' => $e->getMessage(), 'status_code' => 500 ];
    }

}

// function updatePropertyRecord($request, $admin_id, $property_id)
// {
//     $msg = "updated";
//     $isRedirectThankYou = false;

//     try {
//         // Ensure property exists
//         $propertyDataObj = Properties::find($property_id);
//         if (!$propertyDataObj) {
//             return [
//                 'type' => 'error',
//                 'message' => 'Property not found!',
//                 'status_code' => 404
//             ];
//         }

//         // 1️⃣ Basic Information
//         if ($request->step == 1 || $request->_method == "PUT") {

//             $propertyDataObj->name = $request->name;
//             $propertyDataObj->slug = convertStringToSlug($request->name);
//             $propertyDataObj->h1_tag = $request->h1_tag;
//             $propertyDataObj->seo_title = $request->seo_title;
//             $propertyDataObj->meta_description = $request->meta_description;
//             $propertyDataObj->description = $request->description;
//             $propertyDataObj->purpose = $request->purpose;
//             $propertyDataObj->type = $request->type;
//             $propertyDataObj->sub_type_id = $request->sub_type_id;
//             $propertyDataObj->is_furnish = $request->is_furnish;
//             $propertyDataObj->is_complete = $request->is_complete;
//             $propertyDataObj->is_occupancy = $request->is_occupancy;
//             $propertyDataObj->off_plan_sale_type = $request->off_plan_sale_type;
//             $propertyDataObj->completed_date = $request->completed_date;
//             $propertyDataObj->rent_frequency = $request->rent_frequency;
//             $propertyDataObj->rent_contract_period = $request->rent_contract_period;
//             $propertyDataObj->rent_notice_period = $request->rent_notice_period;
//             $propertyDataObj->maintenance_fees = $request->maintenance_fees;
//             $propertyDataObj->maintenance_paid = $request->maintenance_paid;
//             $propertyDataObj->is_finance_available = $request->is_finance_available;
//             $propertyDataObj->finance_name = $request->finance_name;
//             $propertyDataObj->rera_number = $request->rera_number;
//             $propertyDataObj->permit_number = $request->permit_number;
//             $propertyDataObj->location_id = $request->location_id;
//             $propertyDataObj->agent_id = $request->agent_id;
//             $propertyDataObj->area = $request->area;
//             $propertyDataObj->price = $request->price;
//             $propertyDataObj->publish = 0; // keep unpublished until final step
//             $propertyDataObj->status = 0;

//             $propertyDataObj->save();
//         }

//         // 2️⃣ Features
//         if ($request->step == 2 || $request->_method == "PUT") {
//             if (!empty($request->feature_id) && count($request->feature_id) > 0) {

//                 // Reset previous features
//                 PropertyFeatureMap::where('property_id', $property_id)->update(['status' => 0]);

//                 // Clean up empty feature IDs
//                 $featureIds = array_filter($request->feature_id, fn($v) => !is_null($v) && $v !== '');

//                 foreach ($featureIds as $id) {
//                     PropertyFeatureMap::updateOrCreate(
//                         [
//                             'property_id' => $property_id,
//                             'feature_id' => $id,
//                         ],
//                         ['status' => 1]
//                     );
//                 }
//             }
//         }

//         // 3️⃣ Images
//         if ($request->step == 3 || $request->_method == "PUT") {

//             $uploadedImages = [];

//             if ($request->hasFile('propertyImage')) {
//                 foreach ($request->file('propertyImage') as $file) {
//                     $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

//                     // Watermarking process
//                     $img = Image::make($file->getRealPath());
//                     $img->text('©DevotionEstate', $img->width() - 10, $img->height() - 10, function ($font) {
//                         $font->file(public_path('backend/assets/fonts/themify.ttf'));
//                         $font->size(24);
//                         $font->color([255, 255, 255, 0.8]);
//                         $font->align('left');
//                         $font->valign('bottom');
//                     });

//                     $watermark = public_path('img/devotion-trusted-real-estate.png');
//                     if (file_exists($watermark)) {
//                         $img->insert($watermark, 'bottom-right', 20, 10);
//                     }

//                     $path = 'propertyImage/' . $filename;
//                     Storage::put($path, (string) $img->encode());

//                     $uploadedImages[] = [
//                         'image' => Storage::url($path),
//                         'filename' => $filename
//                     ];
//                 }

//                 // Reset old images
//                 PropertyImageMap::where('property_id', $property_id)->update(['status' => 0]);

//                 // Save new images
//                 foreach ($uploadedImages as $ar) {
//                     PropertyImageMap::updateOrCreate(
//                         [
//                             'property_id' => $property_id,
//                             'image' => $ar['image'],
//                             'filename' => $ar['filename'],
//                         ],
//                         ['status' => 1]
//                     );
//                 }
//             }

//             // Update final property state
//             $propertyDataObj->publish = $request->publish ?? $propertyDataObj->publish;
//             $propertyDataObj->status = $request->status ?? $propertyDataObj->status;
//             $propertyDataObj->save();

//             $isRedirectThankYou = true;
//         }

//         return [
//             'type' => 'success',
//             'id' => $propertyDataObj->id,
//             'unique_id' => $propertyDataObj->unique_id,
//             'message' => $propertyDataObj->name . ' has been ' . $msg . ' successfully!',
//             'status_code' => 200,
//             'isRedirectThankYou' => $isRedirectThankYou
//         ];

//     } catch (Exception $e) {
//         return [
//             'type' => 'error',
//             'message' => $e->getMessage(),
//             'status_code' => 500
//         ];
//     }
// }

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


// function getPropertiesByType($type = ['sell', 'rent'], $limit = 6)
// {
//     // Ensure $type is always an array
//     $type = is_array($type) ? $type : [$type];

//     return Properties::with('feature', 'location', 'image')
//         ->whereIn('type', $type)
//         ->latest()
//         ->take($limit)
//         ->get();
// }
function getPropertiesByType($type = ['sell', 'rent'], $limit = 6)
{
    // Convert readable names to purpose values (based on your DB)
    $purposeMap = [
        'sell' => 0,
        'rent' => 1,
    ];

    // Normalize to array
    $type = is_array($type) ? $type : [$type];

    // Convert all to numeric purpose values
    $purposes = array_map(fn($t) => $purposeMap[$t] ?? $t, $type);

    return Properties::with('feature', 'location', 'image')
        ->whereIn('purpose', $purposes)
        ->latest()
        ->take($limit)
        ->get();
}
