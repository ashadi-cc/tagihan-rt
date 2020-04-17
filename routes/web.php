<?php

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

Auth::routes();

//root page
Route::get('/', 'HomeController@index')->name('home');


//admin route
Route::prefix('admin')
    ->middleware(['auth', 'role:admin'])
    ->group(function() {
    
    //master warga
    Route::get('/master/warga', 'Admin\WargaController@index');
    Route::get('/master/warga/upload', 'Admin\WargaController@getUpload');
    Route::post('/master/warga/upload', 'Admin\WargaController@postUpload');

    //master tagihan
    Route::get('/master/tagihan', 'Admin\BillingController@index');
    Route::get('/master/tagihan/upload', 'Admin\BillingController@getUpload');
    Route::post('/master/tagihan/upload', 'Admin\BillingController@postUpload');

});