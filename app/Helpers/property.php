<?php

use App\Models\Properties;
use App\Models\PropertyFeature;
use App\Models\PropertyFeatureMap;
use App\Models\PropertyImageMap;
use Illuminate\Support\Facades\Storage;

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


            // //reset Property Feature Map status
            // PropertyImageMap::where( 'property_id', $property_id )->update( ['status' => 0 ] );

            // foreach( uploadPropertyImageWithCenterLogo() as $filename ){

            //     PropertyImageMap::updateOrCreate(
            //         [
            //             'property_id' => $property_id,
            //             'filename' => $filename,
            //         ], // Search criteria
            //         [
            //             'status' => 1
            //         ] // Attributes to update or create
            //     );
            // }

            // //update proper property status
            // $propertyDataObj->publish = $request->publish;
            // $propertyDataObj->status = $request->status;
            // $propertyDataObj->save();

            // $logoFile = public_path('img/devotion-trusted-real-estate.png');

            $isRedirectThankYou = true;

        }

        echo "Success";die;
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
 * upload multiple images, store them in a folder, resize/crop logos if needed, and display them centered on a image.
 */
function uploadPropertyImageWithCenterLogo(){

    // ============================
    // Configuration
    // ============================
    $uploadDir = storage_path('app/property_images/'); // Folder to store images

    //get Website Logo
    $logoDir = public_path('img/devotion-trusted-real-estate.png'); // Folder to store images

    // Create folder if not exists
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // ============================
    // Handle file uploads
    // ============================
    $uploadedImages = [];
    foreach ( $_FILES['propertyImage']['name'] as $key => $name ) {
        $tmpName = $_FILES['propertyImage']['tmp_name'][$key];
        $fileExt = pathinfo($name, PATHINFO_EXTENSION);
        $newName = uniqid('img_') . '.' . $fileExt; // unique filename
        $destination = $uploadDir . $newName;

        // Move uploaded file
        if (move_uploaded_file($tmpName, $destination)) {

            // Resize to 200x200 (you can adjust for logos)
            resizeImage($logoDir, 200, 200, $destination);
            $uploadedImages[] = $newName;
        }
    }

    return $uploadedImages;
}

// ============================
// Image resize & center function
// ============================
function resizeImage($file, $w, $h, $savePath) {
    list($width, $height, $type) = getimagesize($file);

    // Load image safely
    $src = null;
    switch ($type) {
        case IMAGETYPE_JPEG:
            $src = @imagecreatefromjpeg($file);
            break;
        case IMAGETYPE_PNG:
            // Suppress warning for bad ICC profile
            $src = @imagecreatefrompng($file);
            // Clean PNG by re-saving it
            if ($src) {
                imagepalettetotruecolor($src);
                imagepng($src, $file);
            }
            break;
        default:
            return false; // unsupported type
    }

    if (!$src) return false;

    $dst = imagecreatetruecolor($w, $h);

    // Fill background white for transparency
    $white = imagecolorallocate($dst, 255, 255, 255);
    imagefill($dst, 0, 0, $white);

    // Resize and center
    $src_aspect = $width / $height;
    $dst_aspect = $w / $h;

    if ($src_aspect > $dst_aspect) {
        $new_height = $h;
        $new_width = $width / ($height / $h);
    } else {
        $new_width = $w;
        $new_height = $height / ($width / $w);
    }

    $x = ($w - $new_width) / 2;
    $y = ($h - $new_height) / 2;

    imagecopyresampled($dst, $src, $x, $y, 0, 0, $new_width, $new_height, $width, $height);

    // Save the image
    switch ($type) {
        case IMAGETYPE_JPEG: imagejpeg($dst, $savePath); break;
        case IMAGETYPE_PNG:  imagepng($dst, $savePath); break;
    }

    imagedestroy($src);
    imagedestroy($dst);
    return true;
}
