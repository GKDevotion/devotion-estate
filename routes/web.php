<?php

use App\Http\Controllers\AboutUsController;
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
use App\Http\Controllers\OffPlanController;
use App\Http\Controllers\PrivacyPolicyController;
use App\Http\Controllers\PropertyContactController;
use App\Http\Controllers\RentPropertiesController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SellerGuideController;
use App\Http\Controllers\TenantGuideController;
use App\Http\Controllers\TermsConditionController;
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

Route::get('/new-properties/{slug}', [HomeController::class, 'showNew'])->name('new-properties.detail');
Route::get('/sale-properties/{slug}', [HomeController::class, 'showSale'])->name('sale-properties.detail');

Route::get('about-us', [AboutUsController::class, 'index'])->name('about-us');
Route::get('blog', [BlogController::class, 'index'])->name('blog');

Route::get('buy-properties', [BuyPropertiesController::class, 'index'])->name('buy.properties');
Route::get('/buy-properties/{slug}', [BuyPropertiesController::class, 'show'])->name('buy.property.detail');


Route::get('rent-properties', [RentPropertiesController::class, 'index'])->name('rent.properties');
Route::get('/rent-properties/{slug}', [RentPropertiesController::class, 'show'])->name('rent.property.detail');

Route::get('/luxury-properties/{slug}', [LuxuryPropertiesController::class, 'show'])->name('luxury-property.detail');
Route::get('luxury-properties', [LuxuryPropertiesController::class, 'index'])->name('luxury.properties');

Route::get('buyer-guide', [BuyerGuideController::class, 'index'])->name('buyer-guide');
Route::get('seller-guide', [SellerGuideController::class, 'index'])->name('seller-guide');
Route::get('tenant-guide', [TenantGuideController::class, 'index'])->name('tenant-guide');
Route::get('investment-advisory', [InvestmentAdvisoryController::class, 'index'])->name('investment-advisory');
Route::get('mortgage-advisory', [MortgageAdvisoryController::class, 'index'])->name('mortgage-advisory');

Route::get('/off-plan/{slug}', [OffPlanController::class, 'show'])->name('off-plan.detail');
Route::get('off-plan', [OffPlanController::class, 'index'])->name('off-plan');
Route::get('/list-your-properties', function () {
    return view('frontend.pages.list-your-properties');
});

Route::get('/hot-offer/{slug}', [HotOfferController::class, 'show'])->name('hot-offer.detail');
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

