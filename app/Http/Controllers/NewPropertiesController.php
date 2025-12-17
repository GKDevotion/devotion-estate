<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Properties;
use App\Models\PropertyType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewPropertiesController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('perPage', 4);

        // STEP 1: Row number per developer (latest first)
        $subQuery = Properties::select(
                'properties.*',
                DB::raw("
                    ROW_NUMBER() OVER (
                        PARTITION BY developer_id
                        ORDER BY id DESC
                    ) AS row_num
                ")
            )
            ->where('is_new_property', 1)
            ->where('status', 1)
            ->whereNotNull('developer_id');

        // STEP 2: Pick only 5 per developer
        // STEP 3: Sort globally by latest property
        $properties = DB::query()
            ->fromSub($subQuery, 'p')
            ->where('p.row_num', '<=', 5)
            ->orderBy('p.id', 'DESC') 
            ->paginate($perPage);

        $total = $properties->total();

        $locationObj = Location::select('id', 'name')
            ->where('status', 1)
            ->get();

        $propertyTypeObj = PropertyType::select('id', 'name', 'main_type')
            ->orderBy('name')
            ->get();

        $residentialTypes = PropertyType::where('main_type', 1)
            ->where('status', 1)
            ->get();

        $commercialTypes = PropertyType::where('main_type', 2)
            ->where('status', 1)
            ->get();

        return view('frontend.pages.new-properties', compact(
            'properties',
            'locationObj',
            'propertyTypeObj',
            'residentialTypes',
            'commercialTypes',
            'total',
            'perPage'
        ))->with('type', 'new');
    }
}
