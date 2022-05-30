<?php

use Illuminate\Support\Facades\Route;

Route::get('/import', 'TestExcelController@importFile')->name('import');
Route::post('/import', 'TestExcelController@importExcel');

Route::get('/reportOrphan/{id}', 'TestExcelController@reportOrphan')->name('reportOrphan');
Route::get('/report', 'TestExcelController@pdf')->name('pdf');

Route::get('/index', function () {
    return view('orphan.index');
})->name('dashboard');
Route::middleware('auth')->group(function () {
    Route::prefix('orphans')->group(function () {
        Route::get('/', 'Orphan\OrphanController@index')->name('orphans.list');
        Route::get('/searchOrphans', 'Orphan\OrphanController@searchOrphans')->name('searchOrphans');
        Route::get('/getOrphansList','Orphan\OrphanController@getOrphansList')->name('get.orphans.list');
        Route::post('/storeOrphan', 'Orphan\OrphanController@store')->name('add.orphan');
        Route::get('/addOrphan', function () {
            return view('orphan.add_orphan');
        })->name('form.add.orphan');
        Route::get('/showOrphan/{id}', 'Orphan\OrphanController@show')->name('show.orphan');
        Route::post('/updateOrphan/{id}', 'Orphan\OrphanController@update')->name('update.orphan');
        Route::post('/deleteOrphan','Orphan\OrphanController@deleteOrphan')->name('delete.orphan');
        Route::post('/deleteSelectedOrphan','Orphan\OrphanController@deleteSelectedOrphans')->name('delete.selected.orphans');
        //image gallery for orphan
        Route::post('/add-image','Orphan\ImageGalleryController@store')->name('add.image');
        Route::get('/getImagesList/{id}','Orphan\ImageGalleryController@getImagesList')->name('get.images.list');
        Route::post('/getImageDetails','Orphan\ImageGalleryController@getImageDetails')->name('get.image.details');
        Route::post('/updateImageDetails','Orphan\ImageGalleryController@update')->name('update.image.details');
        Route::post('/deleteImage','Orphan\ImageGalleryController@deleteImage')->name('delete.image');
        Route::post('/deleteSelectedImages','Orphan\ImageGalleryController@deleteSelectedImages')->name('delete.selected.images');
        Route::prefix('importExcelOrphans')->group(function (){
            Route::get('/', 'Orphan\ImportExcelOrphansController@index')->name('form.import.excel.orphans');
            Route::post('/addExcelOrphans','Orphan\ImportExcelOrphansController@store')->name('add.excel.orphans');
            Route::post('/uploadImagesReports', 'TestExcelController@uploadFolder')->name('import.images.reports.orphan');

        });


    });
    Route::prefix('roles')->group(function (){
        Route::get('/','User\RoleController@index')->name('roles.list');
        Route::post('/add-role','User\RoleController@store')->name('add.role');
        Route::get('/getRolesList','User\RoleController@getRolesList')->name('get.roles.list');
        Route::post('/getRoleDetails','User\RoleController@getRoleDetails')->name('get.role.details');
        Route::post('/updateRoleDetails','User\RoleController@update')->name('update.role.details');
        Route::post('/deleteRole','User\RoleController@deleteRole')->name('delete.role');
        Route::post('/deleteSelectedRoles','User\RoleController@deleteSelectedRoles')->name('delete.selected.roles');

    });
    Route::prefix('users')->group(function (){
        Route::get('/','User\UserController@index')->name('users.list');
        Route::post('/add-user','User\UserController@store')->name('add.user');
        Route::get('/getUsersList','User\UserController@getUsersList')->name('get.users.list');
        Route::post('/getUserDetails','User\UserController@getUserDetails')->name('get.user.details');
        Route::post('/updateUserDetails','User\UserController@update')->name('update.user.details');
        Route::post('/deleteUser','User\UserController@deleteUser')->name('delete.user');
        Route::post('/deleteSelectedUsers','User\UserController@deleteSelectedUsers')->name('delete.selected.users');

    });
    Route::prefix('payments')->group(function (){
        Route::get('/','Payment\PaymentController@index')->name('payments.list');
        Route::post('/add-payment','Payment\PaymentController@store')->name('add.payment');
        Route::get('/getPaymentsList','Payment\PaymentController@getPaymentsList')->name('get.payments.list');
        Route::post('/getPaymentDetails','Payment\PaymentController@getPaymentDetails')->name('get.payment.details');
        Route::post('/updatePaymentDetails','Payment\PaymentController@update')->name('update.payment.details');
        Route::post('/deletePayment','Payment\PaymentController@deletePayment')->name('delete.payment');
        Route::post('/deleteSelectedPayments','Payment\PaymentController@deleteSelectedPayments')->name('delete.selected.payments');
        Route::prefix('paymentsOrphans')->group(function (){
            Route::get('/', 'Payment\PaymentOrphanController@index')->name('paymentOrphans.list');
            Route::get('/searchOrphans', 'Payment\PaymentOrphanController@searchPaymentOrphans')->name('searchPaymentOrphans');
            Route::get('/getOrphansList','Payment\PaymentOrphanController@getPaymentOrphansList')->name('get.payment.orphans.list');
            Route::post('/storePaymentOrphan', 'Payment\PaymentOrphanController@store')->name('add.payment.orphan');
            Route::get('/showPaymentOrphan/{id}', 'Payment\PaymentOrphanController@show')->name('show.payment.orphan');
            Route::post('/updatePaymentOrphan/{id}', 'Payment\PaymentOrphanController@update')->name('update.payment.orphan');
            Route::post('/deletePaymentOrphan','Payment\PaymentOrphanController@deletePaymentOrphan')->name('delete.payment.orphan');
            Route::post('/deleteSelectedPaymentOrphans','Payment\PaymentOrphanController@deleteSelectedPaymentOrphans')->name('delete.selected.payment.orphans');
        });
    });
});
Route::get('/','Auth\LoginController@login')->name('index');
Route::get('/login','Auth\LoginController@login')->name('login');
Route::post('/authenticate','Auth\LoginController@authenticate')->name('authenticate');
Route::get('/logout','Auth\LoginController@logout')->name('logout');
Route::get('/404', function () {
    return view('error-404');
})->name('404');
Route::get('/403', function () {
    return view('error-403');
})->name('403');



Route::get('/test', function () {
    return view('welcome');
});




