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
Route::get('record/search_customer', 'App\Http\Controllers\Admin\CustomerController@searchCustomer')->name('local.search.customer');

Route::get('/vendor', 'App\Http\Controllers\Admin\VendorController@index')->name('local.vendor.index');
Route::post('/vendor', 'App\Http\Controllers\Admin\VendorController@store')->name('local.vendor.store');
Route::patch('/vendor/{id}', 'App\Http\Controllers\Admin\VendorController@update')->name('local.vendor.update');
Route::get('/vendor/{id}/edit', 'App\Http\Controllers\Admin\VendorController@edit')->name('local.vendor.edit');
Route::delete('/vendor/{id}', 'App\Http\Controllers\Admin\VendorController@destroy')->name('local.vendor.delete');
Route::get('record/vendor', 'App\Http\Controllers\Admin\VendorController@recordVendor')->name('local.record.vendor');
Route::get('record/search_vendor', 'App\Http\Controllers\Admin\VendorController@searchVendor')->name('local.search.vendor');

Route::get('/stock_master', 'App\Http\Controllers\Admin\StockMasterController@index')->name('local.stock_master.index');
Route::post('/stock_master', 'App\Http\Controllers\Admin\StockMasterController@store')->name('local.stock_master.store');
Route::patch('/stock_master/{id}', 'App\Http\Controllers\Admin\StockMasterController@update')->name('local.stock_master.update');
Route::get('/stock_master/{id}/edit', 'App\Http\Controllers\Admin\StockMasterController@edit')->name('local.stock_master.edit');
Route::delete('/stock_master/{id}', 'App\Http\Controllers\Admin\StockMasterController@destroy')->name('local.stock_master.delete');
Route::get('record/stock_master', 'App\Http\Controllers\Admin\StockMasterController@recordStockMaster')->name('local.record.stock_master');
Route::get('record/search_stock_master', 'App\Http\Controllers\Admin\StockMasterController@searchStockMaster')->name('local.search.stock_master');

Route::get('/stock_movement/{id}', 'App\Http\Controllers\Admin\StockMovementController@index')->name('local.stock_movement.index');
Route::get('record/stock_movement/{id}', 'App\Http\Controllers\Admin\StockMovementController@recordStockMovement')->name('local.record.stock_movement');

Route::get('/stock_adj', 'App\Http\Controllers\Admin\StockAdjController@index')->name('local.stock_adj.index');
Route::post('/stock_adj', 'App\Http\Controllers\Admin\StockAdjController@store')->name('local.stock_adj.store');
Route::patch('/stock_adj/{id}', 'App\Http\Controllers\Admin\StockAdjController@update')->name('local.stock_adj.update');
Route::get('/stock_adj/{id}/edit', 'App\Http\Controllers\Admin\StockAdjController@edit')->name('local.stock_adj.edit');
Route::delete('/stock_adj/{id}', 'App\Http\Controllers\Admin\StockAdjController@destroy')->name('local.stock_adj.delete');
Route::get('record/stock_adj', 'App\Http\Controllers\Admin\StockAdjController@recordStockAdjustment')->name('local.record.stock_adj');

Route::get('/spbd', 'App\Http\Controllers\Admin\SpbdController@index')->name('local.spbd.index');
Route::post('/spbd', 'App\Http\Controllers\Admin\SpbdController@store')->name('local.spbd.store');
Route::patch('/spbd/{id}', 'App\Http\Controllers\Admin\SpbdController@update')->name('local.spbd.update');
Route::get('/spbd/{id}/edit', 'App\Http\Controllers\Admin\SpbdController@edit')->name('local.spbd.edit');
Route::delete('/spbd/{id}', 'App\Http\Controllers\Admin\SpbdController@destroy')->name('local.spbd.delete');
Route::get('record/spbd', 'App\Http\Controllers\Admin\SpbdController@recordSpbd')->name('local.record.spbd');
Route::get('record/search_spbd', 'App\Http\Controllers\Admin\SpbdController@searchSpbd')->name('local.search.spbd');

Route::get('/spbd_detail/{id}', 'App\Http\Controllers\Admin\SpbdController@detail')->name('local.spbd.detail.index');
Route::post('/spbd_detail/{id}', 'App\Http\Controllers\Admin\SpbdController@store_detail')->name('local.spbd.store_detail');
Route::get('/spbd/{id}/edit_detail', 'App\Http\Controllers\Admin\SpbdController@edit_detail')->name('local.spbd.edit_detail');
Route::patch('/spbd_detail/{id}', 'App\Http\Controllers\Admin\SpbdController@update_detail')->name('local.spbd.update_detail');
Route::delete('/spbd_detail/{id}', 'App\Http\Controllers\Admin\SpbdController@destroy_detail')->name('local.spbd.delete_detail');
Route::get('record/spbd_detail/{id}/{po_stat?}', 'App\Http\Controllers\Admin\SpbdController@recordSpbd_detail')->name('local.record.spbd_detail');
Route::get('/spbd_open/{id}', 'App\Http\Controllers\Admin\SpbdController@spbd_open')->name('local.spbd.open.index');

Route::get('/po_stock', 'App\Http\Controllers\Admin\PoStockController@index')->name('local.po_stock.index');
Route::post('/po_stock', 'App\Http\Controllers\Admin\PoStockController@store')->name('local.po_stock.store');
Route::get('/po_stock/{id}/edit', 'App\Http\Controllers\Admin\PoStockController@edit')->name('local.po_stock.edit');
Route::patch('/po_stock/{id}', 'App\Http\Controllers\Admin\PoStockController@update')->name('local.po_stock.update');
Route::delete('/po_stock/{id}', 'App\Http\Controllers\Admin\PoStockController@destroy')->name('local.po_stock.delete');
Route::get('record/po_stock', 'App\Http\Controllers\Admin\PoStockController@recordPoStock')->name('local.record.po_stock');
Route::get('record/search_po_stock', 'App\Http\Controllers\Admin\PoStockController@searchPo_stock')->name('local.search.po_stock');

Route::get('/po_stock_detail/{id}', 'App\Http\Controllers\Admin\PoStockController@detail')->name('local.po_stock.detail.index');
Route::post('/po_stock_detail/{id}', 'App\Http\Controllers\Admin\PoStockController@store_detail')->name('local.po_stock.store_detail');
Route::get('/po_stock_detail/{id}/edit_detail', 'App\Http\Controllers\Admin\PoStockController@edit_detail')->name('local.po_stock.edit_detail');
Route::patch('/po_stock_detail/{id}', 'App\Http\Controllers\Admin\PoStockController@update_detail')->name('local.po_stock.update_detail');
Route::delete('/po_stock_detail/{id}', 'App\Http\Controllers\Admin\PoStockController@destroy_detail')->name('local.po_stock.delete_detail');
Route::get('record/po_stock_detail/{id}/{rec_stat?}', 'App\Http\Controllers\Admin\PoStockController@recordPoStock_detail')->name('local.record.po_stock_detail');
Route::get('/po_stock_open/{id}', 'App\Http\Controllers\Admin\PoStockController@po_stock_open')->name('local.po_stock.open.index');

Route::get('/sppb', 'App\Http\Controllers\Admin\SppbController@index')->name('local.sppb.index');
Route::post('/sppb', 'App\Http\Controllers\Admin\SppbController@store')->name('local.sppb.store');
Route::patch('/sppb/{id}', 'App\Http\Controllers\Admin\SppbController@update')->name('local.sppb.update');
Route::get('/sppb/{id}/edit', 'App\Http\Controllers\Admin\SppbController@edit')->name('local.sppb.edit');
Route::delete('/sppb/{id}', 'App\Http\Controllers\Admin\SppbController@destroy')->name('local.sppb.delete');
Route::get('record/sppb', 'App\Http\Controllers\Admin\SppbController@recordSppb')->name('local.record.sppb');
Route::get('record/search_sppb', 'App\Http\Controllers\Admin\SppbController@searchSppb')->name('local.search.sppb');

Route::get('/sppb_detail/{id}', 'App\Http\Controllers\Admin\SppbController@detail')->name('local.sppb.detail.index');
Route::post('/sppb_detail/{id}', 'App\Http\Controllers\Admin\SppbController@store_detail')->name('local.sppb.store_detail');
Route::get('/sppb/{id}/edit_detail', 'App\Http\Controllers\Admin\SppbController@edit_detail')->name('local.sppb.edit_detail');
Route::patch('/sppb_detail/{id}', 'App\Http\Controllers\Admin\SppbController@update_detail')->name('local.sppb.update_detail');
Route::delete('/sppb_detail/{id}', 'App\Http\Controllers\Admin\SppbController@destroy_detail')->name('local.sppb.delete_detail');
Route::get('record/sppb_detail/{id}/{inv_stat?}', 'App\Http\Controllers\Admin\SppbController@recordSppb_detail')->name('local.record.sppb_detail');
Route::get('/sppb_open/{id}', 'App\Http\Controllers\Admin\SppbController@sppb_open')->name('local.sppb.open.index');

Route::get('/inv', 'App\Http\Controllers\Admin\InvoiceController@index')->name('local.inv.index');
Route::post('/inv', 'App\Http\Controllers\Admin\InvoiceController@store')->name('local.inv.store');
Route::get('/inv/{id}/edit', 'App\Http\Controllers\Admin\InvoiceController@edit')->name('local.inv.edit');
Route::patch('/inv/{id}', 'App\Http\Controllers\Admin\InvoiceController@update')->name('local.inv.update');
Route::delete('/inv/{id}', 'App\Http\Controllers\Admin\InvoiceController@destroy')->name('local.inv.delete');
Route::get('record/inv', 'App\Http\Controllers\Admin\InvoiceController@recordInv')->name('local.record.inv');

Route::get('/inv_detail/{id}', 'App\Http\Controllers\Admin\InvoiceController@detail')->name('local.inv.detail.index');
Route::post('/inv_detail/{id}', 'App\Http\Controllers\Admin\InvoiceController@store_detail')->name('local.inv.store_detail');
Route::get('/inv_detail/{id}/edit_detail', 'App\Http\Controllers\Admin\InvoiceController@edit_detail')->name('local.inv.edit_detail');
Route::patch('/inv_detail/{id}', 'App\Http\Controllers\Admin\InvoiceController@update_detail')->name('local.inv.update_detail');
Route::delete('/inv_detail/{id}', 'App\Http\Controllers\Admin\InvoiceController@destroy_detail')->name('local.inv.delete_detail');
Route::get('record/inv_detail/{id}/{inv_stat?}', 'App\Http\Controllers\Admin\InvoiceController@recordInv_detail')->name('local.record.inv_detail');
Route::get('/inv_open/{id}', 'App\Http\Controllers\Admin\InvoiceController@inv_open')->name('local.inv.open.index');

Route::get('/rec', 'App\Http\Controllers\Admin\ReceiptController@index')->name('local.rec.index');
Route::post('/rec', 'App\Http\Controllers\Admin\ReceiptController@store')->name('local.rec.store');
Route::get('/rec/{id}/edit', 'App\Http\Controllers\Admin\ReceiptController@edit')->name('local.rec.edit');
Route::patch('/rec/{id}', 'App\Http\Controllers\Admin\ReceiptController@update')->name('local.rec.update');
Route::delete('/rec/{id}', 'App\Http\Controllers\Admin\ReceiptController@destroy')->name('local.rec.delete');
Route::get('record/rec', 'App\Http\Controllers\Admin\ReceiptController@recordRec')->name('local.record.rec');

Route::get('/rec_detail/{id}', 'App\Http\Controllers\Admin\ReceiptController@detail')->name('local.rec.detail.index');
Route::post('/rec_detail/{id}', 'App\Http\Controllers\Admin\ReceiptController@store_detail')->name('local.rec.store_detail');
Route::get('/rec_detail/{id}/edit_detail', 'App\Http\Controllers\Admin\ReceiptController@edit_detail')->name('local.rec.edit_detail');
Route::patch('/rec_detail/{id}', 'App\Http\Controllers\Admin\ReceiptController@update_detail')->name('local.rec.update_detail');
Route::delete('/rec_detail/{id}', 'App\Http\Controllers\Admin\ReceiptController@destroy_detail')->name('local.rec.delete_detail');
Route::get('record/rec_detail/{id}/{rec_stat?}', 'App\Http\Controllers\Admin\ReceiptController@recordRec_detail')->name('local.record.rec_detail');
Route::get('/rec_open/{id}', 'App\Http\Controllers\Admin\ReceiptController@rec_open')->name('local.rec.open.index');
//
