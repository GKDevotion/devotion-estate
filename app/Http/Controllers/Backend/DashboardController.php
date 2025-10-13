<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('admin')->user();
            return $next($request);
        });
    }

    public function index()
    {
        if (is_null($this->user) || !$this->user->can('dashboard.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view dashboard !');
        }

        $aTitle = pgTitle("Devotion Real Estate - Dubai UAE ( Holding Company )");
        $hTitle = pgTitle("Devotion Group");

        return view('backend.pages.dashboard.index', compact('hTitle', 'aTitle'));
    }

    public function CompanyManagement(Request $request, $slug, $id = null)
    {
        if (is_null($this->user) || !$this->user->can('dashboard.view') || $slug == "" || $id == "") {
            abort(403, 'Sorry !! You are Unauthorized to view dashboard !');
        }

        $industryAuthAccessDetails = false;
        $companyShow = true;
        $queryParam = "";
        $totalCountBadge = $where = [];

        $showCompanyBadge = true;

        if ($id) {
            $where['industry_id'] = _de($id);
            $queryParam .= "&iid=" . $id;
        }

        $where['status'] = 1;

        $totalCountBadge = $this->totalBadgeCount($where);
        $industries = [];

        $companies = Cache::remember('companies', 10, function () use ($where) {
            return Company::select( 'id', 'name' )->where($where)->orderBy('name', 'ASC')->get();
        });

        $industryObj = Cache::remember('industryObj', 10, function () use ($id) {
            return Industry::select( 'id', 'name' )->select('name')->find(_de($id));
        });

        $pageTitle = pgTitle($industryObj->name);
        $industryURL = $slug . "/" . $id;

        return view('backend.pages.dashboard.index', compact('companyShow', 'totalCountBadge', 'industries', 'companies', 'industryAuthAccessDetails', 'showCompanyBadge', 'industryURL', 'queryParam', 'pageTitle'));
    }

    public function HoldingCompanyServices(Request $request, $type = "")
    {
        if (is_null($this->user) || !$this->user->can('dashboard.view') && $type == "") {
            abort(403, 'Sorry !! You are Unauthorized to view dashboard !');
        }

        $industryAuthAccessDetails = true;
        $companyShow = false;
        $queryParam = "";
        $totalCountBadge = $where = $holdingCompanies = [];
        $showCompanyBadge = true;

        $where['status'] = 1;

        $totalCountBadge = $this->totalBadgeCount($where);

        $key = array_search($type, $this->holdingCompanyArr);
        $where['type'] = $key;
        $queryParam .= "&type=" . $type;

        $industries = Cache::remember('industries', 10, function () use ($key) {
            return Industry::select( 'id', 'name', 'slug' )
                    ->where(['status' => 1, 'type' => $key])
                    ->orderBy('sort_order', 'ASC')
                    ->orderBy('name', 'ASC')
                    ->get();
        });

        $companies = []; //Company::where( $where )->orderBy('name', 'ASC')->get();

        $industryURL = "";
        $hTitle = pgTitle( ( $type == "services" ) ? 'Industry' : $type );

        return view('backend.pages.dashboard.index', compact('companyShow', 'totalCountBadge', 'industries', 'companies', 'industryAuthAccessDetails', 'showCompanyBadge', 'industryURL', 'queryParam', 'holdingCompanies', 'hTitle'));
    }

    public function DepartmentManagement(Request $request, $slug, $id = null, $cid = null)
    {
        if (is_null($this->user) || !$this->user->can('dashboard.view') || $slug == "" || $id == "" || $cid == "") {
            abort(403, 'Sorry !! You are Unauthorized to view dashboard !');
        }

        $industryAuthAccessDetails = false;
        $companyShow = false;
        $totalCountBadge = $where = [];
        $queryParam = [];

        $showCompanyBadge = false;

        if ($cid) {
            $where['company_id'] = _de($cid);
            $queryParam["cid"] = $cid;
        } else if ($this->user->company_id) {
            $where['company_id'] = $this->user->company_id;
            $queryParam["cid"] = _en($where['company_id']);
            $showCompanyBadge = false;
        }

        // if( $slug != "" && Auth::guard('admin')->user()->is_assign_super_admin ){
        //     $industryObj = Industry::select('id')->where('slug', $slug)->first();
        //     $where['industry_id'] = $industryObj->id;
        // }

        if ($id) {
            $where['industry_id'] = _de($id);
            $queryParam["iid"] = $id;
        }

        $where['status'] = 1;

        $totalCountBadge = $this->totalBadgeCount($where);

        $industries = [];

        $departments = Cache::remember('departments', 10, function () use ($where) {
            return Department::select( 'id', 'name', 'admin_menu_id' )->where($where)->orderBy('sort_order')->get();
        });

        $industryURL = $slug . "/" . $id . "/company/" . $cid;

        $pageTitle = Cache::remember('pageTitle', 10, function () use ($cid) {
            $comapnyObj = Company::select( 'id', 'name')->find(_de($cid));
            return pgTitle($comapnyObj->name);
        });

        return view('backend.pages.dashboard.index', compact('totalCountBadge', 'industries', 'industryAuthAccessDetails', 'showCompanyBadge', 'industryURL', 'companyShow', 'departments', 'queryParam', 'pageTitle'));
    }

    /**
     *
     */
    public function totalBadgeCount($where)
    {
        return Cache::remember('totalCountBadge', 10, function () use ($where) {
            $totalCountBadge = [
                'totalAdmins' => DB::table('admins')->select('id')->where($where)->count(),
                'totalUsers' => DB::table('users')->select('id')->where($where)->count(),
                'totalEmployees' => DB::table('persons')->select('id')->where('type',1)->where($where)->count(),
                'totalCorporateEmails' => DB::table('corporate_emails')->select('id')->where($where)->count(),
                'totalMobileDevices' => DB::table('mobile_records')->select('id')->where($where)->count(),
                'totalLaptopDevices' => DB::table('laptop_records')->select('id')->where($where)->count(),
                'totalSims' => DB::table('sim_records')->select('id')->count(),
                'totalActiveInquiry' => DB::table('inquiries')->select('id')->where($where)->count(),
            ];

            if (isset($where['company_id'])) {
                // unset($where['company_id']);
                $totalCountBadge['totalCompanies'] = DB::table('companies')->select('id')->count();;
            } else {
                $totalCountBadge['totalCompanies'] = DB::table('companies')->select('id')->where($where)->count();
            }

            return $totalCountBadge;
        });
    }

    /**
     * @deprecated
     */
    public function _totalBadgeCount($where)
    {
        $totalCountBadge = [
            'totalAdmins' => Admin::select('id')->where($where)->count(),
            'totalUsers' => User::select('id')->where($where)->count(),
            'totalEmployees' => Person::select('id')->where('type',1)->where($where)->count(),
            'totalCorporateEmails' => CorporateEmail::select('id')->where($where)->count(),
            'totalMobileDevices' => MobileRecord::select('id')->where($where)->count(),
            'totalLaptopDevices' => LaptopRecord::select('id')->where($where)->count(),
            'totalSims' => SimRecord::select('id')->count(),
            'totalActiveInquiry' => Inquiry::select('id')->where($where)->count(),
        ];

        if (isset($where['company_id'])) {
            // unset($where['company_id']);
            $totalCountBadge['totalCompanies'] = Company::select('id')->count();;
        } else {
            $totalCountBadge['totalCompanies'] = Company::select('id')->where($where)->count();
        }

        return $totalCountBadge;
    }
}
