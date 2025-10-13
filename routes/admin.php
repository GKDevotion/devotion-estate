<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Backend\AdminLogController;
use App\Http\Controllers\Backend\AdminsController;
use App\Http\Controllers\Backend\CitiesController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\LocationController;
use App\Http\Controllers\Backend\PermissionController;
use App\Http\Controllers\Backend\PropertyFeatureController;
use App\Http\Controllers\Backend\StatesController;
use App\Http\Controllers\Backend\UsersController;
use App\Http\Controllers\Backend\VisitingCardController;
use App\Models\PropertyFeature;

// Prefix all routes with 'admin' and add middleware if needed
Route::prefix('admin')->group(function () {

    // Login Routes
        Route::get('login', 'Backend\Auth\LoginController@showLoginForm')->name('admin.login');
        Route::post('login/submit', 'Backend\Auth\LoginController@login')->name('admin.login.submit');

    // Logout Routes
        Route::post('logout/submit', 'Backend\Auth\LoginController@logout')->name('admin.logout.submit');

    // Forget Password Routes
        Route::get('/password/reset', 'Backend\Auth\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
        Route::post('/password/reset/submit', 'Backend\Auth\ForgetPasswordController@reset')->name('admin.password.update');

    // Dashboard Routes
        Route::get('/', 'Backend\DashboardController@index')->name('admin.dashboard');
        Route::get('/{slug?}/{id?}/company', [DashboardController::class, 'CompanyManagement'] );
        Route::get('/{slug?}/{id?}/company/{cid?}', [DashboardController::class, 'DepartmentManagement'] );

        Route::get('/holding-company/{type?}', [DashboardController::class, 'HoldingCompanyServices'] );

    /**
     * Property Management
     */
        Route::resource('locations', 'Backend\LocationController', ['names' => 'admin.locations']);
        Route::get('/locations-ajax-data', [LocationController::class, 'ajaxIndex'])->name('locations.ajaxIndex');

        // Route::resource('property-features', 'Backend\PropertyFeatureController', ['names' => 'admin.property_features']);
        Route::get('/property-features', [PropertyFeatureController::class, 'index'])->name('admin.property-features.index');
        Route::get('/property-features/create', [PropertyFeatureController::class, 'create'])->name('admin.property-features.create');
        Route::get('/property-features/store', [PropertyFeatureController::class, 'store'])->name('admin.property-features.store');
        Route::get('/property-features-ajax-data', [PropertyFeatureController::class, 'ajaxIndex'])->name('property-features.ajaxIndex');

    /**
     * User Management
     */

        Route::resource('users', 'Backend\UsersController', ['names' => 'admin.user']);
        Route::get('/user-ajax-data', [UsersController::class, 'ajaxIndex'])->name('user.ajaxIndex');

        Route::resource('admins', 'Backend\AdminsController', ['names' => 'admin.admin']);

        Route::resource('customers', 'Backend\CustomersController', ['names' => 'admin.customer']);

        Route::resource('visiting-card', 'Backend\VisitingCardController', ['names' => 'admin.visiting-card']);
        Route::get('/user-ajax-data', [VisitingCardController::class, 'ajaxIndex'])->name('visiting-card.ajaxIndex');

    /**
     * Continent Management
     */
        Route::resource('religions', 'Backend\ReligionsController', ['names' => 'admin.religion']);
        Route::resource('continents', 'Backend\ContinentsController', ['names' => 'admin.continent']);
        Route::resource('countries', 'Backend\CountriesController', ['names' => 'admin.country']);
        Route::resource('states', 'Backend\StatesController', ['names' => 'admin.state']);
        Route::get('/state-ajax-data', [StatesController::class, 'ajaxIndex'])->name('state.ajaxIndex');
        Route::resource('cities', 'Backend\CitiesController', ['names' => 'admin.city']);
        Route::get('/city-ajax-data', [CitiesController::class, 'ajaxIndex'])->name('city.ajaxIndex');

    /**
     * Setting
     */
        Route::resource('menu', 'Backend\MenuController', ['names' => 'admin.menu']);
        Route::resource('logs', 'Backend\AdminLogController', ['names' => 'admin.admin-log']);
        Route::get('/admin-log-ajax-data', [AdminLogController::class, 'ajaxIndex'])->name('admin-log.ajaxIndex');
        Route::resource('roles', 'Backend\RolesController', ['names' => 'admin.role']);
        Route::resource('permission', 'Backend\PermissionController', ['names' => 'admin.permission']);
        Route::post('changePermission', [PermissionController::class, 'changePermission']);
        Route::get('change-password', [AdminsController::class, 'changePassword'])->name('admin.change-password');
        Route::resource('configurations', 'Backend\ConfigurationController', ['names' => 'admin.configurations']);

    /**
     * Common Function Routes
     */
        Route::get('update-status/{table}/{id}/{status}', [AdminsController::class, 'updateFieldStatus']);
        Route::get('delete-event/{title}/{id}', [AdminsController::class, 'deleteEvent']);


    /**
     * To implement a password change with email OTP confirmation
     */
    Route::post('/send-otp', [PasswordController::class, 'sendOtp'])->name('send.otp');
    Route::post('/change-password', [PasswordController::class, 'changePassword'])->name('change.password');

});

?>
