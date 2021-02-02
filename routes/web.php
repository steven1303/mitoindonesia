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

// Route::get('/', function () {
//     return view('admin.app');
// });

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/login', 'App\Http\Controllers\Admin\LoginController@showLoginForm')->name('local.admin.login');
Route::post('/login', 'App\Http\Controllers\Admin\LoginController@login')->name('local.admin.login.submit');
Route::get('/logout', 'App\Http\Controllers\Admin\LoginController@logout')->name('local.admin.logout');
Route::get('/', 'App\Http\Controllers\Admin\DashboardController@index')->name('local.admin.dashboard');

// Route AjaxSettings
Route::get('/admin', 'App\Http\Controllers\Admin\AdminController@index')->name('local.admin.index');
Route::post('/admin', 'App\Http\Controllers\Admin\AdminController@store')->name('local.admin.store');
Route::patch('/admin/{id}', 'App\Http\Controllers\Admin\AdminController@update')->name('local.admin.update');
Route::get('/admin/{id}/edit', 'App\Http\Controllers\Admin\AdminController@edit')->name('local.admin.edit');
Route::delete('/admin/{id}', 'App\Http\Controllers\Admin\AdminController@destroy')->name('local.admin.delete');
Route::get('record/admin', 'App\Http\Controllers\Admin\AdminController@recordAdmin')->name('local.record.admin');

Route::get('/role', 'App\Http\Controllers\Admin\RoleController@index')->name('local.role.index');
Route::post('/role', 'App\Http\Controllers\Admin\RoleController@store')->name('local.role.store');
Route::patch('/role/{id}', 'App\Http\Controllers\Admin\RoleController@update')->name('local.role.update');
Route::get('/role/{id}/edit', 'App\Http\Controllers\Admin\RoleController@edit')->name('local.role.edit');
Route::delete('/role/{id}', 'App\Http\Controllers\Admin\RoleController@destroy')->name('local.role.delete');
Route::get('record/role', 'App\Http\Controllers\Admin\RoleController@recordRole')->name('local.record.role');

Route::get('/permission', 'App\Http\Controllers\Admin\PermissionController@index')->name('local.permission.index');
Route::post('/permission', 'App\Http\Controllers\Admin\PermissionController@store')->name('local.permission.store');
Route::patch('/permission/{id}', 'App\Http\Controllers\Admin\PermissionController@update')->name('local.permission.update');
Route::get('/permission/{id}/edit', 'App\Http\Controllers\Admin\PermissionController@edit')->name('local.permission.edit');
Route::delete('/permission/{id}', 'App\Http\Controllers\Admin\PermissionController@destroy')->name('local.permission.delete');
Route::get('record/permission', 'App\Http\Controllers\Admin\PermissionController@recordPermission')->name('local.record.permission');

Route::get('/branch', 'App\Http\Controllers\Admin\BranchController@index')->name('local.branch.index');
Route::post('/branch', 'App\Http\Controllers\Admin\BranchController@store')->name('local.branch.store');
Route::patch('/branch/{id}', 'App\Http\Controllers\Admin\BranchController@update')->name('local.branch.update');
Route::get('/branch/{id}/edit', 'App\Http\Controllers\Admin\BranchController@edit')->name('local.branch.edit');
Route::delete('/branch/{id}', 'App\Http\Controllers\Admin\BranchController@destroy')->name('local.branch.delete');
Route::get('record/branch', 'App\Http\Controllers\Admin\BranchController@recordBranch')->name('local.record.branch');

Route::get('/customer', 'App\Http\Controllers\Admin\CustomerController@index')->name('local.customer.index');
Route::post('/customer', 'App\Http\Controllers\Admin\CustomerController@store')->name('local.customer.store');
Route::patch('/customer/{id}', 'App\Http\Controllers\Admin\CustomerController@update')->name('local.customer.update');
Route::get('/customer/{id}/edit', 'App\Http\Controllers\Admin\CustomerController@edit')->name('local.customer.edit');
Route::delete('/customer/{id}', 'App\Http\Controllers\Admin\CustomerController@destroy')->name('local.customer.delete');
Route::get('record/customer', 'App\Http\Controllers\Admin\CustomerController@recordCustomer')->name('local.record.customer');

Route::get('/vendor', 'App\Http\Controllers\Admin\VendorController@index')->name('local.vendor.index');
Route::post('/vendor', 'App\Http\Controllers\Admin\VendorController@store')->name('local.vendor.store');
Route::patch('/vendor/{id}', 'App\Http\Controllers\Admin\VendorController@update')->name('local.vendor.update');
Route::get('/vendor/{id}/edit', 'App\Http\Controllers\Admin\VendorController@edit')->name('local.vendor.edit');
Route::delete('/vendor/{id}', 'App\Http\Controllers\Admin\VendorController@destroy')->name('local.vendor.delete');
Route::get('record/vendor', 'App\Http\Controllers\Admin\VendorController@recordVendor')->name('local.record.vendor');

Route::get('/stock_master', 'App\Http\Controllers\Admin\StockMasterController@index')->name('local.stock_master.index');
Route::post('/stock_master', 'App\Http\Controllers\Admin\StockMasterController@store')->name('local.stock_master.store');
Route::patch('/stock_master/{id}', 'App\Http\Controllers\Admin\StockMasterController@update')->name('local.stock_master.update');
Route::get('/stock_master/{id}/edit', 'App\Http\Controllers\Admin\StockMasterController@edit')->name('local.stock_master.edit');
Route::delete('/stock_master/{id}', 'App\Http\Controllers\Admin\StockMasterController@destroy')->name('local.stock_master.delete');
Route::get('record/stock_master', 'App\Http\Controllers\Admin\StockMasterController@recordStockMaster')->name('local.record.stock_master');

Route::get('/stock_movement/{id}', 'App\Http\Controllers\Admin\StockMovementController@index')->name('local.stock_movement.index');
