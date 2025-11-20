<?php

use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\Backend\AgentsController;
use App\Http\Controllers\Backend\ContactUsController as BackendContactUsController;
use App\Http\Controllers\Backend\PropertiesController;
use App\Http\Controllers\Backend\ReviewsController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BuyerGuideController;
use App\Http\Controllers\BuyPropertiesController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HotOfferController;
use App\Http\Controllers\InvestmentAdvisoryController;
use App\Http\Controllers\LuxuryPropertiesController;
use App\Http\Controllers\MortgageAdvisoryController;
use App\Http\Controllers\MortgageController;
use App\Http\Controllers\NewPropertiesController;
use App\Http\Controllers\OffPlanController;
use App\Http\Controllers\PrivacyPolicyController;
use App\Http\Controllers\PropertyContactController;
use App\Http\Controllers\RentPropertiesController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SellerGuideController;
use App\Http\Controllers\TenantGuideController;
use App\Http\Controllers\TermsConditionController;
use App\Models\Properties;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('config:cache');
    return "will clear the all cached!";
});


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::post('review/store', [ReviewController::class, 'store'])->name('review.store');

Route::post('property-contact/store', [PropertyContactController::class, 'store'])->name('property-contact.store');


// Route::get('/{type}-properties/{slug}', [PropertiesController::class, 'show'])->name('property.detail');
Route::get('property/hot-offer', [HotOfferController::class, 'index'])->name('hot-offer');
Route::get('property/{slug}', [PropertiesController::class, 'show'])->name('property.detail');

// properties serach section/web.php
Route::get('properties/search', [PropertiesController::class, 'search'])->name('properties.search');

Route::get('/agent/{id}', [Properties::class, 'show'])->name('agent.show');
Route::get('/property/send-mail/{agent_id}', [PropertiesController::class, 'sendMail'])->name('property.sendMail');


Route::get('about-us', [AboutUsController::class, 'index'])->name('about-us');

Route::get('blog', [BlogController::class, 'index'])->name('blog');
// Route::get('blog/{slug?}', [BlogController::class, 'show'])->name('property.detail');

Route::get('buy-properties', [BuyPropertiesController::class, 'index'])->name('buy.properties');


Route::get('rent-properties', [RentPropertiesController::class, 'index'])->name('rent.properties');
Route::get('luxury-properties', [LuxuryPropertiesController::class, 'index'])->name('luxury.properties');
Route::get('new-properties', [NewPropertiesController::class, 'index'])->name('new.properties');
Route::get('buyer-guide', [BuyerGuideController::class, 'index'])->name('buyer-guide');
Route::get('seller-guide', [SellerGuideController::class, 'index'])->name('seller-guide');
Route::get('tenant-guide', [TenantGuideController::class, 'index'])->name('tenant-guide');
Route::get('investment-advisory', [InvestmentAdvisoryController::class, 'index'])->name('investment-advisory');
Route::get('mortgage-advisory', [MortgageAdvisoryController::class, 'index'])->name('mortgage-advisory');
Route::get('off-plan', [OffPlanController::class, 'index'])->name('off-plan');
Route::get('/list-your-properties', function () {
    return view('frontend.pages.list-your-properties');
});
Route::get('/property-management', function () {
    return view('frontend.pages.property-management');
});

Route::get('hot-offer', [HotOfferController::class, 'index'])->name('hot-offer');


Route::get('/login', function () {
    return view('frontend.pages.login');
});
Route::get('/sign-up', function () {
    return view('frontend.pages.sign-up');
});

Route::get('contact-us', [ContactUsController::class, 'index'])->name('contact-us');
Route::post('contact/store', [ContactUsController::class, 'store'])->name('contact.store');

Route::get('sign-up', function () {
    return view('frontend.pages.sign-up');
});
Route::get('privacy-policy', [PrivacyPolicyController::class, 'index'])->name('privacy-policy');
Route::get('terms-condition', [TermsConditionController::class, 'index'])->name('terms-condition');

Route::get('execute-sql-statement', [HomeController::class, 'setSqlStatement']);


Route::get('cant-properties', [PropertiesController::class, 'deleteproperties']);



Route::get('/mortgage', [MortgageController::class, 'index'])->name('mortgage.index');

