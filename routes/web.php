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

// Auth::routes();
// authentication routes
Auth::routes();

/*
|
| admin routes
|
|
*/
Route::middleware('auth')->prefix('/')->name('admin.')->group(
    function () {
        Route::post('/passwordupdate', 'Admin\DashboardController@updatepassword')->name('passwordupdate');
        Route::get('/passwordreset', 'Admin\DashboardController@showResetForm')->name('passwordreset');

        Route::get('/', 'Admin\DashboardController@index')->name('dashboard');

        Route::prefix('/user-vpn')->name('uservpn.')->group(function () {
            Route::get('/', 'Admin\UservpnController@index')->name('index');
            Route::get('/detail/{ip}/', 'Admin\UservpnController@detail')->name('detail');

            // export excel
            Route::get('/export_excel', 'Admin\UservpnController@export_excel')->name('excel');
            Route::get('/detail/{ip}/export_excel', 'Admin\UservpnController@detailexport_excel')->name('detailexcel');
        });
        Route::get('/test', 'Admin\UservpnController@test')->name('test');
    }
);

// Logout
Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');
