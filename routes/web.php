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

// if (config('default.proxy_schema')) {
//     URL::forceScheme(config('default.proxy_schema'));
// }

Auth::routes();

//root page
Route::get('/', 'HomeController@index')->name('home');

/** User */
Route::get('/user/password', 'UserController@index'); 
Route::put('/user/password', 'UserController@store'); 

//admin route
Route::prefix('admin')
    ->middleware(['auth', 'role:admin'])
    ->group(function() {
    
    //master warga
    Route::get('/master/warga', 'Admin\WargaController@index');
    Route::get('/master/warga/upload', 'Admin\WargaController@getUpload');
    Route::post('/master/warga/upload', 'Admin\WargaController@postUpload');
    /** CURD */
    Route::get('/master/warga/get', 'Admin\WargaController@getData');
    Route::delete('/master/warga/{userID}', 'Admin\WargaController@delete');
    Route::get('/master/warga/edit/{userID}', 'Admin\WargaController@edit');
    Route::put('/master/warga/edit/{userID}', 'Admin\WargaController@postEdit');

    //master tagihan
    Route::get('/master/tagihan', 'Admin\BillingController@index');
    Route::get('/master/tagihan/upload', 'Admin\BillingController@getUpload');
    Route::post('/master/tagihan/upload', 'Admin\BillingController@postUpload');
    /** CURD */
    Route::get('/master/tagihan/get', 'Admin\BillingController@getData');
    Route::delete('/master/tagihan/{billingId}', 'Admin\BillingController@delete');
    Route::get('/master/tagihan/edit/{billingId}', 'Admin\BillingController@edit');
    Route::put('/master/tagihan/edit/{billingId}', 'Admin\BillingController@postEdit');

    //master payment
    Route::get('/master/payment', 'Admin\PaymentController@index');
    /** CURD */
    Route::get('/master/payment/get', 'Admin\PaymentController@getData');
    Route::delete('/master/payment/{paymentId}', 'Admin\PaymentController@delete');
    Route::get('/master/payment/edit/{paymentId}', 'Admin\PaymentController@edit');
    Route::put('/master/payment/edit/{paymentId}', 'Admin\PaymentController@postEdit');
    Route::post('/master/payment', 'Admin\PaymentController@store');

    //tagihan upload dan daftar
    Route::get('/tagihan/upload', 'Admin\TagihanController@index');
    Route::post('/tagihan/upload', 'Admin\TagihanController@uploadTagihan');
    Route::get('/tagihan/upload/template/{idTemplate}', 'Admin\TagihanController@getTemplate');
    /**CURD */
    Route::get('/tagihan/upload/get', 'Admin\TagihanController@getData');
    Route::delete('/tagihan/upload/{idRecord}', 'Admin\TagihanController@delete');
    Route::put('/tagihan/upload/{idRecord}', 'Admin\TagihanController@edit');

    //tagihan bulanan 
    Route::get('/tagihan/bulanan', 'Admin\TagihanBulanan@index');
    Route::get('/tagihan/bulanan/get', 'Admin\TagihanBulanan@getData');
    Route::put('/tagihan/bulanan/{idRecord}', 'Admin\TagihanBulanan@edit');
    Route::get('/tagihan/bulanan/summary', 'Admin\TagihanBulanan@summary');
    Route::get('/tagihan/bulanan/user', 'Admin\TagihanBulanan@byUser');
});