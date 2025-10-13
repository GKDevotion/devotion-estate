<?php

use App\Http\Controllers\API\AttendanceController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\AwardController;
use App\Http\Controllers\API\BoardMeetingController;
use App\Http\Controllers\API\ClientController;
use App\Http\Controllers\API\ClientMeetingController;
use App\Http\Controllers\API\CompanyController;
use App\Http\Controllers\API\CompanyMeetingController;
use App\Http\Controllers\API\ContinentController;
use App\Http\Controllers\API\CorporateDomainController;
use App\Http\Controllers\API\CorporateEmailController;
use App\Http\Controllers\API\DepartmentController;
use App\Http\Controllers\API\DeviceRecordController;
use App\Http\Controllers\API\EmployeeController;
use App\Http\Controllers\API\EmployeeMeetingController;
use App\Http\Controllers\API\EmployeePerformanceController;
use App\Http\Controllers\API\EmployeeTaskController;
use App\Http\Controllers\API\HealthConditionController;
use App\Http\Controllers\API\HolidayController;
use App\Http\Controllers\API\HomeController;
use App\Http\Controllers\API\IndustryController;
use App\Http\Controllers\API\LaptopRecordController;
use App\Http\Controllers\API\LeaveController;
use App\Http\Controllers\API\ServerRecordController;
use App\Http\Controllers\API\MobileRecordController;
use App\Http\Controllers\API\NoticeBoardController;
use App\Http\Controllers\API\PayrollController;
use App\Http\Controllers\API\PositionController;
use App\Http\Controllers\API\SimRecordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\CronController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('config:cache');

    return response()->json(
        [
            'success' => true,
            'data'    => [],
            'message' => "Will clear the all cached!",
        ],
        200
    );
});

Route::controller(AuthController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');
});

Route::middleware('auth:sanctum')->group( function () {
    Route::get('side-menu', [HomeController::class, 'sideListMenu' ] );
    Route::get('dashboard', [HomeController::class, 'dashboard' ] );

    /**
     * To implement a password change with email OTP confirmation
     */
    Route::post('send-otp', [PasswordController::class, 'sendOtpAPI']);
    Route::post('change-password', [PasswordController::class, 'changePasswordAPI']);
});

Route::get('get-continent-list', [CronController::class, 'getContinent'] );
Route::get('get-country-list/{id?}', [ContinentController::class, 'getCountryByContinentID'] );
Route::get('get-state-list/{id?}', [ContinentController::class, 'getStateByCountryID'] );
Route::get('get-states', [ContinentController::class, 'getStates'] );
Route::get('get-city-list/{id?}', [ContinentController::class, 'getCityByStateByID'] );
Route::get('get-cities', [ContinentController::class, 'getCities'] );
Route::get('get-social-media-platform', [CronController::class, 'getSocialMediaPlatform'] );
Route::get('get-marital-status', [CronController::class, 'getMaritalStatus'] );
Route::get('get-employee-type', [CronController::class, 'getEmployeeTypeList'] );
Route::get('get-employees', [CronController::class, 'getEmployeeList'] );
Route::get('get-employee-list/{id?}', [CronController::class, 'getEmployeeListByCompanyBase'] );
Route::get('get-employee-details/{id?}', [CronController::class, 'getEmployeeDetails'] );
Route::get('get-employees-personal-info/{id}', [CronController::class, 'getEmployeePersonalInformation'] );
Route::get('get-employees-notice-history/{id}', [CronController::class, 'getEmployeeNoticeHistory'] );
Route::get('get-employees-attendance-history/{id}', [CronController::class, 'getEmployeeAttandanceHistory'] );
Route::get('get-employees-leave-history/{id}', [CronController::class, 'getEmployeeLeaveHistory'] );
Route::get('get-employees-payroll-history/{id}', [CronController::class, 'getEmployeePayrollHistory'] );
Route::get('get-employees-award-history/{id}', [CronController::class, 'getEmployeeAwardHistory'] );
Route::get('get-payment-frequency', [CronController::class, 'getPaymentFrequency'] );

Route::get('get-industry-list', [CronController::class, 'getIndustries'] );
Route::get('get-religion-list', [ContinentController::class, 'getReligions'] );
Route::get('get-company-list/{id}', [CronController::class, 'getCompaniesByIndustryID'] );
Route::get('get-department-list/{id}', [CronController::class, 'getDepartmentByCompanyID'] );
Route::get('get-positions', [CronController::class, 'getAllPositionList'] );
Route::get('get-parent-position-list', [CronController::class, 'getParentPositionList'] );
Route::get('get-child-position-list/{id}', [CronController::class, 'getChildPositionList'] );
Route::get('get-skill-list/{id?}', [CronController::class, 'getSkillList'] );
Route::get('get-position-details/{id}', [CronController::class, 'getPositionDetails'] );
Route::get('get-parent-illness-list', [CronController::class, 'getParentIllnessList'] );
Route::get('get-illness-list/{id}', [CronController::class, 'getIllnessList'] );
Route::get('get-shift', [CronController::class, 'getShiftList'] );
Route::get('get-shift-detail/{id}', [CronController::class, 'getShiftDetailList'] );
Route::get('logos', [CronController::class, 'getLogos'] );
Route::get('get-qualification-list', [CronController::class, 'getQualifications'] );
Route::get('get-communication-type', [CronController::class, 'getCommunicationType'] );


Route::get('get-activity-log/{id?}', [CronController::class, 'getActivityLogs']);

/**
 * admin Dashboard Chart Load
 */
Route::get('industry-base-chart-data', [ChartController::class, 'generateIndustryBaseChartData']);
Route::get('continent-base-chart-data', [ChartController::class, 'generateContinentBaseChartData']);
Route::get('company-base-admin-chart-data', [ChartController::class, 'companyBaseAdminChartData']);
Route::get('get-dashboard-notifications', [ChartController::class, 'getDashboardNotifications']);
