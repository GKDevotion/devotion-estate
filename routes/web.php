<?php


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


Route::get('/home', function () {
    return view('frontend.pages.home');
});

Route::get('/about-us', function () {
    return view('frontend.pages.about-us');
});


Route::get('/blog', function () {
    return view('frontend.pages.blog');
});


Route::get('/buy-properties', function () {
    return view('frontend.pages.buy-properties');
});


Route::get('/rent-properties', function () {
    return view('frontend.pages.rent-properties');
});


Route::get('/buyer-guide', function () {
    return view('frontend.pages.buyer-guide');
});

Route::get('/seller-guide', function () {
    return view('frontend.pages.seller-guide');
});

Route::get('/tenant-guide', function () {
    return view('frontend.pages.tenant-guide');
});


Route::get('/investment-advisory', function () {
    return view('frontend.pages.investment-advisory');
});
Route::get('/mortage-advisory', function () {
    return view('frontend.pages.mortage-advisory');
});
Route::get('/off-plan', function () {
    return view('frontend.pages.off-plan');
});
Route::get('/luxury-properties', function () {
    return view('frontend.pages.luxury-properties');
});
Route::get('/list-your-properties', function () {
    return view('frontend.pages.list-your-properties');
});
Route::get('/hot-offer', function () {
    return view('frontend.pages.hot-offer');
});

Route::get('/login', function () {
    return view('frontend.pages.login');
});
Route::get('/sign-up', function () {
    return view('frontend.pages.sign-up');
});

Route::get('/contact-us', function () {
    return view('frontend.pages.contact-us');
});
Route::get('/sign-up', function () {
    return view('frontend.pages.sign-up');
});
Route::get('/privacy-policy', function () {
    return view('frontend.pages.privacy-policy');
});
Route::get('/terms-condition', function () {
    return view('frontend.pages.terms-condition');
});

