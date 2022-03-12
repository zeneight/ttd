<?php

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

// dashboard
Route::get('/admin','AdminDashboardController@getIndex');

Route::get('/admin/signature', 'AdminSignatureController@index');
Route::post('/admin/signature/store', 'AdminSignatureController@store')->name('signature.store');
Route::post('/admin/surats/ttd', 'AdminSuratsController@tandaTangan')->name('surats.ttd');

// ------------
// Route::get('/{any}', function () {
//     // return view('welcome');
// })->where('any', '.*');
Route::get('/', function () {
    return redirect('/admin/login');
});