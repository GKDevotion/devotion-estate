<?php

use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BuyerGuideController;
use App\Http\Controllers\BuyPropertiesController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\HotOfferController;
use App\Http\Controllers\InvestmentAdvisoryController;
use App\Http\Controllers\LuxuryPropertiesController;
use App\Http\Controllers\MortgageAdvisoryController;
use App\Http\Controllers\OffPlanController;
use App\Http\Controllers\PrivacyPolicyController;
use App\Http\Controllers\RentPropertiesController;
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


Route::get('/', function () {
    return view('frontend.pages.home');
});

Route::get('about-us', [AboutUsController::class, 'index'])->name('about-us');
// Route::get('/about-us', function () {
//     return view('frontend.pages.about-us');
// });

Route::get('blog', [BlogController::class, 'index'])->name('blog');
// Route::get('/blog', function () {
//     return view('frontend.pages.blog');
// });


Route::get('buy-properties', [BuyPropertiesController::class, 'index'])->name('buy.properties');
// Route::get('/buy-properties', function () {
//     return view('frontend.pages.buy-properties');
// });

Route::get('rent-properties', [RentPropertiesController::class, 'index'])->name('rent.properties');

// Route::get('/rent-properties', function () {
//     return view('frontend.pages.rent-properties');
// });
Route::get('luxury-properties', [LuxuryPropertiesController::class, 'index'])->name('luxury.properties');
// Route::get('/luxury-properties', function () {
//     return view('frontend.pages.luxury-properties');
// });

Route::get('buyer-guide', [BuyerGuideController::class, 'index'])->name('buyer-guide');

// Route::get('/buyer-guide', function () {
//     return view('frontend.pages.buyer-guide');
// });

Route::get('seller-guide', [SellerGuideController::class, 'index'])->name('seller-guide');
// Route::get('/seller-guide', function () {
//     return view('frontend.pages.seller-guide');
// });
Route::get('tenant-guide', [TenantGuideController::class, 'index'])->name('tenant-guide');
// Route::get('/tenant-guide', function () {
//     return view('frontend.pages.tenant-guide');
// });
Route::get('investment-advisory', [InvestmentAdvisoryController::class, 'index'])->name('investment-advisory');

// Route::get('/investment-advisory', function () {
//     return view('frontend.pages.investment-advisory');
// });
Route::get('mortgage-advisory', [MortgageAdvisoryController::class, 'index'])->name('mortgage-advisory');
// Route::get('/mortgage-advisory', function () {
//     return view('frontend.pages.mortgage-advisory');
// });

Route::get('off-plan', [OffPlanController::class, 'index'])->name('off-plan');
// Route::get('/off-plan', function () {
//     return view('frontend.pages.off-plan');
// });

Route::get('/list-your-properties', function () {
    return view('frontend.pages.list-your-properties');
});

Route::get('hot-offer', [HotOfferController::class, 'index'])->name('hot-offer');
// Route::get('hot-offer', function () {
//     return view('frontend.pages.hot-offer');
// });

Route::get('/login', function () {
    return view('frontend.pages.login');
});
Route::get('/sign-up', function () {
    return view('frontend.pages.sign-up');
});

Route::get('contact-us', [ContactUsController::class, 'index'])->name('contact-us');
Route::post('contact/store', [ContactUsController::class, 'store'])->name('contact.store');


// Route::get('/contact-us', function () {
//     return view('frontend.pages.contact-us');
// });
Route::get('/sign-up', function () {
    return view('frontend.pages.sign-up');
});
Route::get('privacy-policy', [PrivacyPolicyController::class, 'index'])->name('privacy-policy');
// Route::get('/privacy-policy', function () {
//     return view('frontend.pages.privacy-policy');
// });
Route::get('terms-condition', [TermsConditionController::class, 'index'])->name('terms-condition');
// Route::get('/terms-condition', function () {
//     return view('frontend.pages.terms-condition');
// });

