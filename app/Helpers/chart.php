<?php

use App\Models\Company;

/**
 * 
 */
function getCompanyBaseAdminRecords( $request ){

    //get company Records
    $companyObj = Company::select( 'id', 'name', 'slug' )->where( 'status', 1 )->get();

    foreach( $companyObj as $com ){
        
    }
    $dataPoint = [
        'labels' => [
            "Jan", "Feb", "Mar", "Apr"
        ],
        'values' => [
            10, 20, 30, 40
        ]
    ];
    // foreach( getIndustryObj() as $data ){
    //     for( $yr=2011;$yr<=2024;$yr++){
    //         $dataPoint[$data->slug][] = ["label"=> $yr, "y"=> rand(0, 1000)];
    //     }
    // }

    return $dataPoint;
}
?>