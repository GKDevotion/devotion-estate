<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Backend\AdminLogController;
use App\Http\Controllers\Backend\AdminsController;
use App\Http\Controllers\Backend\AgentsController;
use App\Http\Controllers\Backend\AwardController;
use App\Http\Controllers\Backend\BannerController;
use App\Http\Controllers\Backend\BlogController;
use App\Http\Controllers\Backend\BrochuresController;
use App\Http\Controllers\Backend\CitiesController;
use App\Http\Controllers\Backend\ClientsController;
use App\Http\Controllers\Backend\ContactUsController;
use App\Http\Controllers\Backend\CurrencyController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\DesignationsController;
use App\Http\Controllers\Backend\DeveloperController;
use App\Http\Controllers\Backend\LocationController;
use App\Http\Controllers\Backend\OwnersController;
use App\Http\Controllers\Backend\PaymentPlanController;
use App\Http\Controllers\Backend\PermissionController;
use App\Http\Controllers\Backend\PropertiesController;
use App\Http\Controllers\Backend\PropertyContactController;
use App\Http\Controllers\Backend\PropertyFeatureController;
use App\Http\Controllers\Backend\PropertyTypeController;
use App\Http\Controllers\Backend\ReviewsController;
use App\Http\Controllers\Backend\StatesController;
use App\Http\Controllers\Backend\UsersController;
use App\Http\Controllers\Backend\VisitingCardController;

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
    Route::get('/admin', 'Backend\DashboardController@index')->name('admin.dashboard');
    Route::get('/{slug?}/{id?}/company', [DashboardController::class, 'CompanyManagement']);
    Route::get('/{slug?}/{id?}/company/{cid?}', [DashboardController::class, 'DepartmentManagement']);

    Route::get('/holding-company/{type?}', [DashboardController::class, 'HoldingCompanyServices']);

    /**
     * Property Management
     */
    Route::resource('locations', 'Backend\LocationController', ['names' => 'admin.locations']);
    Route::get('/locations-ajax-data', [LocationController::class, 'ajaxIndex'])->name('locations.ajaxIndex');

    Route::get('/property-features', [PropertyFeatureController::class, 'index'])->name('admin.property-features.index');
    Route::get('/property-features/create', [PropertyFeatureController::class, 'create'])->name('admin.property-features.create');
    Route::post('/property-features/store', [PropertyFeatureController::class, 'store'])->name('admin.property-features.store');
    Route::get('/property-features/edit/{id}', [PropertyFeatureController::class, 'edit'])->name('admin.property-features.edit');
    Route::post('/property-features/update', [PropertyFeatureController::class, 'update'])->name('admin.property-features.update');
    Route::delete('/property-features/{id}', [PropertyFeatureController::class, 'destroy'])->name('admin.property-features.destroy');
    Route::get('/property-features-ajax-data', [PropertyFeatureController::class, 'ajaxIndex'])->name('property-features.ajaxIndex');

    Route::resource('property-types', 'Backend\PropertyTypeController', ['names' => 'admin.property-types']);
    Route::get('/property-types-ajax-data', [PropertyTypeController::class, 'ajaxIndex'])->name('property-types.ajaxIndex');

    Route::resource('reviews', 'Backend\ReviewsController', ['names' => 'admin.reviews']);
    Route::get('/reviews-ajax-data', [ReviewsController::class, 'ajaxIndex'])->name('reviews.ajaxIndex');

    Route::resource('payment-plan', 'Backend\PaymentPlanController', ['names' => 'admin.payment-plan']);
    Route::get('/payment-plan-ajax-data', [PaymentPlanController::class, 'ajaxIndex'])->name('payment-plan.ajaxIndex');

    Route::resource('brochures', 'Backend\BrochuresController', ['names' => 'admin.brochures']);
    Route::get('/brochures-ajax-data', [BrochuresController::class, 'ajaxIndex'])->name('brochures.ajaxIndex');

    Route::resource('banner', 'Backend\BannerController', ['names' => 'admin.banner']);
    Route::get('/banner-ajax-data', [BannerController::class, 'ajaxIndex'])->name('banner.ajaxIndex');

    Route::resource('award', 'Backend\awardController', ['names' => 'admin.award']);
    Route::get('/award-ajax-data', [AwardController::class, 'ajaxIndex'])->name('award.ajaxIndex');

    Route::get('/blogs', [BlogController::class, 'index'])->name('admin.blogs.index');
    Route::get('/blogs/create', [BlogController::class, 'create'])->name('admin.blogs.create');
    Route::post('/blogs/store', [BlogController::class, 'store'])->name('admin.blogs.store');
    Route::get('/blogs/edit/{id}', [BlogController::class, 'edit'])->name('admin.blogs.edit');
    Route::post('/blogs/update', [BlogController::class, 'update'])->name('admin.blogs.update');
    Route::get('/blogs-ajax-data', [BlogController::class, 'ajaxIndex'])->name('blogs.ajaxIndex');

    Route::get('/new-property', [PropertiesController::class, 'newPropertyindex'])->name('admin.new-property.index');
    Route::get('/featured-property', [PropertiesController::class, 'featurePropertyindex'])->name('admin.featured-property.index');
    Route::resource('properties', 'Backend\PropertiesController', ['names' => 'admin.properties']);
    Route::get('/properties-ajax-data', [PropertiesController::class, 'ajaxIndex'])->name('properties.ajaxIndex');

    Route::resource('developer', 'Backend\DeveloperController', ['names' => 'admin.developer']);
    Route::get('/developer-ajax-data', [DeveloperController::class, 'ajaxIndex'])->name('developer.ajaxIndex');

    /**
     * User Management
     */

    Route::resource('designations', 'Backend\DesignationsController', ['names' => 'admin.designations']);
    Route::get('/designations-ajax-data', [DesignationsController::class, 'ajaxIndex'])->name('designations.ajaxIndex');

    Route::get('/users', [UsersController::class, 'index'])->name('admin.user.index');
    Route::get('/users/create', [UsersController::class, 'create'])->name('admin.user.create');
    Route::post('/users/store', [UsersController::class, 'store'])->name('admin.user.store');
    Route::get('/users/edit/{id}', [UsersController::class, 'edit'])->name('admin.user.edit');
    Route::post('/users/update', [UsersController::class, 'update'])->name('admin.user.update');
    Route::get('/users-ajax-data', [UsersController::class, 'ajaxIndex'])->name('user.ajaxIndex');

    Route::get('/owners', [OwnersController::class, 'index'])->name('admin.owners.index');
    Route::get('/owners/create', [OwnersController::class, 'create'])->name('admin.owners.create');
    Route::post('/owners/store', [OwnersController::class, 'store'])->name('admin.owners.store');
    Route::get('/owners/edit/{id}', [OwnersController::class, 'edit'])->name('admin.owners.edit');
    Route::post('/owners/update', [OwnersController::class, 'update'])->name('admin.owners.update');
    Route::get('/owners-ajax-data', [OwnersController::class, 'ajaxIndex'])->name('owners.ajaxIndex');

    Route::resource('agents', 'Backend\AgentsController', ['names' => 'admin.agents']);
    Route::get('/agents-ajax-data', [AgentsController::class, 'ajaxIndex'])->name('agents.ajaxIndex');

    Route::get('/clients', [ClientsController::class, 'index'])->name('admin.clients.index');
    Route::get('/clients/create', [ClientsController::class, 'create'])->name('admin.clients.create');
    Route::post('/clients/store', [ClientsController::class, 'store'])->name('admin.clients.store');
    Route::get('/clients/edit/{id}', [ClientsController::class, 'edit'])->name('admin.clients.edit');
    Route::post('/clients/update', [ClientsController::class, 'update'])->name('admin.clients.update');
    Route::get('/clients-ajax-data', [ClientsController::class, 'ajaxIndex'])->name('clients.ajaxIndex');


    Route::resource('contact-us', 'Backend\ContactUsController', ['names' => 'admin.contact-us']);
    Route::get('/contact-us-ajax-data', [ContactUsController::class, 'ajaxIndex'])->name('contact-us.ajaxIndex');

    Route::resource('property-contact', 'Backend\PropertyContactController', ['names' => 'admin.property-contact']);
    Route::get('/property-contact-ajax-data', [PropertyContactController::class, 'ajaxIndex'])->name('property-contact.ajaxIndex');

    Route::resource('admins', 'Backend\AdminsController', ['names' => 'admin.admin']);

    Route::resource('customers', 'Backend\CustomersController', ['names' => 'admin.customer']);

    Route::resource('visiting-card', 'Backend\VisitingCardController', ['names' => 'admin.visiting-card']);
    Route::get('/user-ajax-data', [VisitingCardController::class, 'ajaxIndex'])->name('visiting-card.ajaxIndex');


    Route::get('/designations', [DesignationsController::class, 'index'])->name('admin.designations.index');
    Route::get('/designations/create', [DesignationsController::class, 'create'])->name('admin.designations.create');
    Route::post('/designations/store', [DesignationsController::class, 'store'])->name('admin.designations.store');
    Route::get('/designations/edit/{id}', [DesignationsController::class, 'edit'])->name('admin.designations.edit');
    Route::post('/designations/update', [DesignationsController::class, 'update'])->name('admin.designations.update');
    Route::get('/designations-ajax-data', [DesignationsController::class, 'ajaxIndex'])->name('designations.ajaxIndex');

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

    Route::resource('currency', 'Backend\CurrencyController', ['names' => 'admin.currency']);
    Route::get('/currency-ajax-data', [CurrencyController::class, 'ajaxIndex'])->name('currency.ajaxIndex');

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
    Route::get('update-field-status/{table}/{id}/{status}/{field}', [AdminsController::class, 'updateFieldStatus']);
    Route::get('delete-event/{title}/{id}', [AdminsController::class, 'deleteEvent']);


    /**
     * To implement a password change with email OTP confirmation
     */
    Route::post('/send-otp', [PasswordController::class, 'sendOtp'])->name('send.otp');
    Route::post('/change-password', [PasswordController::class, 'changePassword'])->name('change.password');
});
