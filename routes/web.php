<?php

use App\Setting;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::middleware(['auth.shopify'])->group(function () {
    Route::get('/', function () {
        $shop = Auth::user();
        $settings = Setting::where('shop_id', $shop->name)->first();
        return view('dashboard', compact('settings'));
    })->name('home');

    Route::get('/wishlists', 'WishlistController@test')->name('test');

    Route::post('/configureTheme', 'SettingController@configureTheme');

    Route::view('/products', 'products');
    Route::view('/customers', 'customers');
    Route::view('/settings', 'settings');
});
