<?php

use Illuminate\Support\Facades\Route;

Route::get('/teste', 'TestExcelController@testexcel')->name('import');
Route::get('/reportOrphan/{id}', 'TestExcelController@reportOrphan')->name('reportOrphan');
Route::get('/report', 'TestExcelController@pdf')->name('pdf');

Route::middleware('auth')->group(function () {
    Route::get('dashboard',function (){
        return view('dashboard');
    })->name('dashboard');
    Route::prefix('orphans')->middleware('IsOrphansPage')->group(function () {
        Route::get('/', 'Orphan\OrphanController@index')->name('orphans.list');
        Route::get('/searchOrphans', 'Orphan\OrphanController@searchOrphans')->name('searchOrphans');
        Route::get('/getOrphansList','Orphan\OrphanController@getOrphansList')->name('get.orphans.list');
        Route::post('/storeOrphan', 'Orphan\OrphanController@store')->middleware('can:AddOrphan')->name('add.orphan');
        Route::get('/addOrphan', function () {
            return view('orphan.add_orphan');
        })->middleware('can:AddOrphan')->name('form.add.orphan');
        Route::get('/showOrphan/{id}', 'Orphan\OrphanController@show')->middleware('can:ShowOrphan')->name('show.orphan');
        Route::post('/updateOrphan/{id}', 'Orphan\OrphanController@update')->middleware('can:EditOrphan')->name('update.orphan');
        Route::post('/deleteOrphan','Orphan\OrphanController@deleteOrphan')->middleware('can:DeleteOrphan')->name('delete.orphan');
        Route::post('/deleteSelectedOrphan','Orphan\OrphanController@deleteSelectedOrphans')->middleware('can:DeleteOrphan')->name('delete.selected.orphans');
        //image gallery for orphan
        Route::post('/add-image','Orphan\ImageGalleryController@store')->middleware('can:AddImageForOrphan')->name('add.image');
        Route::get('/getImagesList/{id}','Orphan\ImageGalleryController@getImagesList')->name('get.images.list');
        Route::post('/getImageDetails','Orphan\ImageGalleryController@getImageDetails')->name('get.image.details');
        Route::post('/updateImageDetails','Orphan\ImageGalleryController@update')->middleware('can:EditImageForOrphan')->name('update.image.details');
        Route::post('/deleteImage','Orphan\ImageGalleryController@deleteImage')->middleware('can:DeleteImageForOrphan')->name('delete.image');
        Route::post('/deleteSelectedImages','Orphan\ImageGalleryController@deleteSelectedImages')->middleware('can:DeleteImageForOrphan')->name('delete.selected.images');
        Route::post('/addExcelOrphans','Orphan\ImportExcelOrphansController@store')->middleware('can:AddExcelOrphans')->name('add.excel.orphans');
        Route::get('/ExportExcelOrphans', 'Orphan\ExportExcelOrphan@exportAllOrphans')->middleware('can:ExportExcelOrphans')->name('export.excel.orphans');
        //Route::post('/uploadImagesReports', 'TestExcelController@uploadFolder')->name('import.images.reports.orphan');
    });
    Route::prefix('roles')->middleware('IsRolesPage')->group(function (){
        Route::get('/','User\RoleController@index')->name('roles.list');
        Route::post('/add-role','User\RoleController@store')->middleware('can:AddRole')->name('add.role');
        Route::get('/getRolesList','User\RoleController@getRolesList')->name('get.roles.list');
        Route::post('/getRoleDetails','User\RoleController@getRoleDetails')->name('get.role.details');
        Route::post('/updateRoleDetails','User\RoleController@update')->middleware('can:EditRole')->name('update.role.details');
        Route::post('/deleteRole','User\RoleController@deleteRole')->middleware('can:DeleteRole')->name('delete.role');
        Route::post('/deleteSelectedRoles','User\RoleController@deleteSelectedRoles')->middleware('can:DeleteRole')->name('delete.selected.roles');

    });
    Route::prefix('users')->middleware('IsUsersPage')->group(function (){
        Route::get('/','User\UserController@index')->name('users.list');
        Route::post('/add-user','User\UserController@store')->middleware('can:AddUser')->name('add.user');
        Route::get('/getUsersList','User\UserController@getUsersList')->name('get.users.list');
        Route::post('/getUserDetails','User\UserController@getUserDetails')->name('get.user.details');
        Route::post('/updateUserDetails','User\UserController@update')->middleware('can:EditUser')->name('update.user.details');
        Route::post('/deleteUser','User\UserController@deleteUser')->middleware('can:DeleteUser')->name('delete.user');
        Route::post('/deleteSelectedUsers','User\UserController@deleteSelectedUsers')->middleware('can:DeleteUser')->name('delete.selected.users');

    });
    Route::prefix('payments')->middleware('IsPaymentsPage')->group(function (){
        Route::get('/','Payment\PaymentController@index')->name('payments.list');
        Route::post('/add-payment','Payment\PaymentController@store')->middleware('can:AddPayment')->name('add.payment');
        Route::get('/getPaymentsList','Payment\PaymentController@getPaymentsList')->name('get.payments.list');
        Route::post('/getPaymentDetails','Payment\PaymentController@getPaymentDetails')->name('get.payment.details');
        Route::post('/updatePaymentDetails','Payment\PaymentController@update')->middleware('can:EditPayment')->name('update.payment.details');
        Route::post('/deletePayment','Payment\PaymentController@deletePayment')->middleware('can:DeletePayment')->name('delete.payment');
        Route::post('/deleteSelectedPayments','Payment\PaymentController@deleteSelectedPayments')->middleware('can:DeletePayment')->name('delete.selected.payments');
    });
    Route::prefix('paymentsOrphans')->middleware('IsPaymentsOrphansPage')->group(function (){
        Route::get('/', 'Payment\PaymentOrphanController@index')->name('paymentOrphans.list');
        Route::get('/searchOrphans', 'Payment\PaymentOrphanController@searchPaymentOrphans')->name('searchPaymentOrphans');
        Route::get('/getPaymentOrphansList','Payment\PaymentOrphanController@getPaymentOrphansList')->name('get.payment.orphans.list');
        Route::post('/getPaymentOrphanDetails','Payment\PaymentOrphanController@getPaymentOrphanDetails')->name('get.payment.orphan.details');
        Route::get('/searchPaymentsOrphans', 'Payment\PaymentOrphanController@searchPaymentsOrphans')->name('searchPaymentsOrphans');
        Route::post('/storePaymentOrphan', 'Payment\PaymentOrphanController@store')->middleware('can:AddPaymentOrphan')->name('add.payment.orphan');
        Route::post('/updatePaymentOrphan', 'Payment\PaymentOrphanController@update')->middleware('can:EditPaymentOrphan')->name('update.payment.orphan.details');
        Route::post('/deletePaymentOrphan','Payment\PaymentOrphanController@deletePaymentOrphan')->middleware('can:DeletePaymentOrphan')->name('delete.payment.orphan');
        Route::post('/deleteSelectedPaymentOrphans','Payment\PaymentOrphanController@deleteSelectedPaymentOrphans')->middleware('can:DeletePaymentOrphan')->name('delete.selected.payments_orphans');
        Route::post('/addExcelPaymentsOrphans','Payment\ImportExcelPaymentsOrphansController@store')->middleware('can:AddExcelPaymentOrphan')->name('add.excel.payments.orphans');
        Route::get('/ExportExcelOrphans', 'Payment\ExportExcelPaymentOrphan@exportPaymentsOrphans')->middleware('can:ExportExcelPaymentOrphans')->name('export.excel.payments.orphans');
    });
    Route::prefix('typeImages')->middleware('IsTypeImagesPage')->group(function (){
        Route::get('/','User\TypeImageController@index')->name('type.images.list');
        Route::post('/add-type-images','User\TypeImageController@store')->middleware('can:AddTypeImage')->name('add.type.image');
        Route::get('/getTypeImagesList','User\TypeImageController@getTypeImagesList')->name('get.type.images.list');
        Route::post('/getTypeImageDetails','User\TypeImageController@getTypeImageDetails')->name('get.type.image.details');
        Route::post('/updateTypeImageDetails','User\TypeImageController@update')->middleware('can:EditTypeImage')->name('update.type.image.details');
        Route::post('/deleteTypeImage','User\TypeImageController@deleteTypeImage')->middleware('can:DeleteTypeImage')->name('delete.type.image');
        Route::post('/deleteSelectedTypeImageS','User\TypeImageController@deleteSelectedTypeImages')->middleware('can:DeleteTypeImage')->name('delete.selected.type.images');

    });
    Route::prefix('permissions')->middleware('IsPermissionsPage')->group(function (){
        Route::get('/','Permission\PermissionController@index')->name('permissions.list');
        Route::post('/add-permission','Permission\PermissionController@store')->middleware('can:AddPermission')->name('add.permission');
        Route::get('/getPermissionsList','Permission\PermissionController@getPermissionsList')->name('get.permissions.list');
        Route::post('/getPermissionDetails','Permission\PermissionController@getPermissionDetails')->name('get.permission.details');
        Route::post('/updatePermissionDetails','Permission\PermissionController@update')->middleware('can:EditPermission')->name('update.permission.details');
        Route::post('/deletePermission','Permission\PermissionController@deletePermission')->middleware('can:DeletePermission')->name('delete.permission');
        Route::post('/deleteSelectedPermissions','Permission\PermissionController@deleteSelectedPermissions')->middleware('can:DeletePermission')->name('delete.selected.permissions');

    });
    Route::prefix('permissionsUsers')->middleware('IsPermissionsUsersPage')->group(function (){
        Route::get('/getPermissionsUserList','Permission\PermissionUserController@getPermissionsUserList')->name('get.permissions.user.list');
        Route::post('/addPermissionsUser','Permission\PermissionUserController@addPermissionsUser')->middleware('can:AddPermissionsUser')->name('add.permissions.user');
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
    return view('in');
    //return view('welcome');
});





