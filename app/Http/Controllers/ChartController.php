<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Continent;
use App\Models\Country;
use App\Models\Industry;
use App\Models\Notification;
use App\Models\PropertyContact;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ChartController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // return view('home');
    }

    /**
     * company base admin chart data
     */
    public function companyBaseAdminChartData( Request $request){
        return getCompanyBaseAdminRecords( $request );
    }

    /**
     *
     */
    public function getDashboardNotifications(){

        $notificationObj = PropertyContact::where( 'is_read', 0 )->orderBy('id', 'DESC')->get();
        $response = [];

        foreach( $notificationObj as $k=>$ar ){
            $response[$k]['id'] = $ar->property_unique_id;
            $response[$k]['title'] = $ar->name." (".$ar->property_name.")";
            $response[$k]['url'] = url('admin/property-contact');
            $response[$k]['time'] = getTimeDifference($ar->created_at);
        }

        return response()->json( $response, 200 );
    }
}
