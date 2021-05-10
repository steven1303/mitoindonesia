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

Route::get('/admin/profile', 'App\Http\Controllers\Admin\AdminController@profile')->name('local.admin.profile');
Route::patch('/admin/profile/{id}', 'App\Http\Controllers\Admin\AdminController@update_profile')->name('local.profile.update');

// Admin
Route::get('/admin', 'App\Http\Controllers\Admin\AdminController@index')->name('local.admin.index');
Route::post('/admin', 'App\Http\Controllers\Admin\AdminController@store')->name('local.admin.store');
Route::patch('/admin/{id}', 'App\Http\Controllers\Admin\AdminController@update')->name('local.admin.update');
Route::get('/admin/{id}/edit', 'App\Http\Controllers\Admin\AdminController@edit')->name('local.admin.edit');
Route::delete('/admin/{id}', 'App\Http\Controllers\Admin\AdminController@destroy')->name('local.admin.delete');
Route::get('record/admin', 'App\Http\Controllers\Admin\AdminController@recordAdmin')->name('local.record.admin');

// Role
Route::get('/role', 'App\Http\Controllers\Admin\RoleController@index')->name('local.role.index');
Route::post('/role', 'App\Http\Controllers\Admin\RoleController@store')->name('local.role.store');
Route::patch('/role/{id}', 'App\Http\Controllers\Admin\RoleController@update')->name('local.role.update');
Route::get('/role/{id}/edit', 'App\Http\Controllers\Admin\RoleController@edit')->name('local.role.edit');
Route::get('/role/{id}/show', 'App\Http\Controllers\Admin\RoleController@show')->name('local.role.show');
Route::delete('/role/{id}', 'App\Http\Controllers\Admin\RoleController@destroy')->name('local.role.delete');
Route::get('record/role', 'App\Http\Controllers\Admin\RoleController@recordRole')->name('local.record.role');
Route::post('/rolePermission','App\Http\Controllers\Admin\RoleController@updatePermission')->name('local.update.rolePermission');

// Permission
Route::get('/permission', 'App\Http\Controllers\Admin\PermissionController@index')->name('local.permission.index');
Route::post('/permission', 'App\Http\Controllers\Admin\PermissionController@store')->name('local.permission.store');
Route::patch('/permission/{id}', 'App\Http\Controllers\Admin\PermissionController@update')->name('local.permission.update');
Route::get('/permission/{id}/edit', 'App\Http\Controllers\Admin\PermissionController@edit')->name('local.permission.edit');
Route::delete('/permission/{id}', 'App\Http\Controllers\Admin\PermissionController@destroy')->name('local.permission.delete');
Route::get('record/permission', 'App\Http\Controllers\Admin\PermissionController@recordPermission')->name('local.record.permission');

// Branch
Route::get('/branch', 'App\Http\Controllers\Admin\BranchController@index')->name('local.branch.index');
Route::post('/branch', 'App\Http\Controllers\Admin\BranchController@store')->name('local.branch.store');
Route::patch('/branch/{id}', 'App\Http\Controllers\Admin\BranchController@update')->name('local.branch.update');
Route::get('/branch/{id}/edit', 'App\Http\Controllers\Admin\BranchController@edit')->name('local.branch.edit');
Route::delete('/branch/{id}', 'App\Http\Controllers\Admin\BranchController@destroy')->name('local.branch.delete');
Route::get('record/branch', 'App\Http\Controllers\Admin\BranchController@recordBranch')->name('local.record.branch');

// Customer
Route::get('/customer', 'App\Http\Controllers\Admin\CustomerController@index')->name('local.customer.index');
Route::post('/customer', 'App\Http\Controllers\Admin\CustomerController@store')->name('local.customer.store');
Route::patch('/customer/{id}', 'App\Http\Controllers\Admin\CustomerController@update')->name('local.customer.update');
Route::get('/customer/{id}/edit', 'App\Http\Controllers\Admin\CustomerController@edit')->name('local.customer.edit');
Route::delete('/customer/{id}', 'App\Http\Controllers\Admin\CustomerController@destroy')->name('local.customer.delete');
Route::get('record/customer', 'App\Http\Controllers\Admin\CustomerController@recordCustomer')->name('local.record.customer');
Route::get('record/search_customer', 'App\Http\Controllers\Admin\CustomerController@searchCustomer')->name('local.search.customer');
Route::get('/customer/{id}/info', 'App\Http\Controllers\Admin\CustomerController@info')->name('local.customer.info');
Route::get('/customer/{id}/invoice', 'App\Http\Controllers\Admin\CustomerController@invoice')->name('local.customer.inv');

// Vendor
Route::get('/vendor', 'App\Http\Controllers\Admin\VendorController@index')->name('local.vendor.index');
Route::post('/vendor', 'App\Http\Controllers\Admin\VendorController@store')->name('local.vendor.store');
Route::patch('/vendor/{id}', 'App\Http\Controllers\Admin\VendorController@update')->name('local.vendor.update');
Route::get('/vendor/{id}/edit', 'App\Http\Controllers\Admin\VendorController@edit')->name('local.vendor.edit');
Route::delete('/vendor/{id}', 'App\Http\Controllers\Admin\VendorController@destroy')->name('local.vendor.delete');
Route::get('record/vendor', 'App\Http\Controllers\Admin\VendorController@recordVendor')->name('local.record.vendor');
Route::get('record/search_vendor', 'App\Http\Controllers\Admin\VendorController@searchVendor')->name('local.search.vendor');
Route::get('/vendor/{id}/info', 'App\Http\Controllers\Admin\VendorController@info')->name('local.vendor.info');
Route::get('/vendor/{id}/po_stock', 'App\Http\Controllers\Admin\VendorController@po_stock')->name('local.vendor.po_stock');

// Stock Master
Route::get('/stock_master', 'App\Http\Controllers\Admin\StockMasterController@index')->name('local.stock_master.index');
Route::post('/stock_master', 'App\Http\Controllers\Admin\StockMasterController@store')->name('local.stock_master.store');
Route::patch('/stock_master/{id}', 'App\Http\Controllers\Admin\StockMasterController@update')->name('local.stock_master.update');
Route::get('/stock_master/{id}/edit', 'App\Http\Controllers\Admin\StockMasterController@edit')->name('local.stock_master.edit');
Route::delete('/stock_master/{id}', 'App\Http\Controllers\Admin\StockMasterController@destroy')->name('local.stock_master.delete');
Route::get('record/stock_master', 'App\Http\Controllers\Admin\StockMasterController@recordStockMaster')->name('local.record.stock_master');
Route::get('record/search_stock_master', 'App\Http\Controllers\Admin\StockMasterController@searchStockMaster')->name('local.search.stock_master');

// Pricelist
Route::get('/pricelist', 'App\Http\Controllers\Admin\PricelistController@index')->name('local.pricelist.index');
Route::get('record/pricelist', 'App\Http\Controllers\Admin\PricelistController@recordPricelist')->name('local.record.pricelist');
Route::patch('/pricelist/{id}', 'App\Http\Controllers\Admin\PricelistController@update')->name('local.pricelist.update');
Route::get('/pricelist/{id}/edit', 'App\Http\Controllers\Admin\PricelistController@edit')->name('local.pricelist.edit');

// Stock Movement
Route::get('/stock_movement/{id}', 'App\Http\Controllers\Admin\StockMovementController@index')->name('local.stock_movement.index');
Route::get('record/stock_movement/{id}', 'App\Http\Controllers\Admin\StockMovementController@recordStockMovement')->name('local.record.stock_movement');

// Adjustment Old
Route::get('/stock_adj', 'App\Http\Controllers\Admin\StockAdjController@index')->name('local.stock_adj.index');
Route::post('/stock_adj', 'App\Http\Controllers\Admin\StockAdjController@store')->name('local.stock_adj.store');
Route::patch('/stock_adj/{id}', 'App\Http\Controllers\Admin\StockAdjController@update')->name('local.stock_adj.update');
Route::get('/stock_adj/{id}/edit', 'App\Http\Controllers\Admin\StockAdjController@edit')->name('local.stock_adj.edit');
Route::delete('/stock_adj/{id}', 'App\Http\Controllers\Admin\StockAdjController@destroy')->name('local.stock_adj.delete');
Route::get('record/stock_adj', 'App\Http\Controllers\Admin\StockAdjController@recordStockAdjustment')->name('local.record.stock_adj');

// SPBD
Route::get('/spbd', 'App\Http\Controllers\Admin\SpbdController@index')->name('local.spbd.index');
Route::post('/spbd', 'App\Http\Controllers\Admin\SpbdController@store')->name('local.spbd.store');
Route::patch('/spbd/{id}', 'App\Http\Controllers\Admin\SpbdController@update')->name('local.spbd.update');
Route::get('/spbd/{id}/edit', 'App\Http\Controllers\Admin\SpbdController@edit')->name('local.spbd.edit');
Route::delete('/spbd/{id}', 'App\Http\Controllers\Admin\SpbdController@destroy')->name('local.spbd.delete');
Route::get('record/spbd', 'App\Http\Controllers\Admin\SpbdController@recordSpbd')->name('local.record.spbd');
Route::get('record/search_spbd', 'App\Http\Controllers\Admin\SpbdController@searchSpbd')->name('local.search.spbd');

// SPBD Detail
Route::get('/spbd_detail/{id}', 'App\Http\Controllers\Admin\SpbdController@detail')->name('local.spbd.detail.index');
Route::post('/spbd_detail/{id}', 'App\Http\Controllers\Admin\SpbdController@store_detail')->name('local.spbd.store_detail');
Route::get('/spbd/{id}/edit_detail', 'App\Http\Controllers\Admin\SpbdController@edit_detail')->name('local.spbd.edit_detail');
Route::patch('/spbd_detail/{id}', 'App\Http\Controllers\Admin\SpbdController@update_detail')->name('local.spbd.update_detail');
Route::delete('/spbd_detail/{id}', 'App\Http\Controllers\Admin\SpbdController@destroy_detail')->name('local.spbd.delete_detail');
Route::get('record/spbd_detail/{id}/{po_stat?}', 'App\Http\Controllers\Admin\SpbdController@recordSpbd_detail')->name('local.record.spbd_detail');
Route::get('/spbd_open/{id}', 'App\Http\Controllers\Admin\SpbdController@spbd_open')->name('local.spbd.open.index');

// PO Stock
Route::get('/po_stock', 'App\Http\Controllers\Admin\PoStockController@index')->name('local.po_stock.index');
Route::post('/po_stock', 'App\Http\Controllers\Admin\PoStockController@store')->name('local.po_stock.store');
Route::get('/po_stock/{id}/edit', 'App\Http\Controllers\Admin\PoStockController@edit')->name('local.po_stock.edit');
Route::patch('/po_stock/{id}', 'App\Http\Controllers\Admin\PoStockController@update')->name('local.po_stock.update');
Route::delete('/po_stock/{id}', 'App\Http\Controllers\Admin\PoStockController@destroy')->name('local.po_stock.delete');
Route::get('record/po_stock', 'App\Http\Controllers\Admin\PoStockController@recordPoStock')->name('local.record.po_stock');
Route::get('record/search_po_stock', 'App\Http\Controllers\Admin\PoStockController@searchPo_stock')->name('local.search.po_stock');


// PO Stock Detail
Route::get('/po_stock_detail/{id}', 'App\Http\Controllers\Admin\PoStockController@detail')->name('local.po_stock.detail.index');
Route::post('/po_stock_detail/{id}', 'App\Http\Controllers\Admin\PoStockController@store_detail')->name('local.po_stock.store_detail');
Route::get('/po_stock_detail/{id}/edit_detail', 'App\Http\Controllers\Admin\PoStockController@edit_detail')->name('local.po_stock.edit_detail');
Route::patch('/po_stock_detail/{id}', 'App\Http\Controllers\Admin\PoStockController@update_detail')->name('local.po_stock.update_detail');
Route::delete('/po_stock_detail/{id}', 'App\Http\Controllers\Admin\PoStockController@destroy_detail')->name('local.po_stock.delete_detail');
Route::get('record/po_stock_detail/{id}/{rec_stat?}', 'App\Http\Controllers\Admin\PoStockController@recordPoStock_detail')->name('local.record.po_stock_detail');
Route::get('/po_stock_open/{id}', 'App\Http\Controllers\Admin\PoStockController@po_stock_open')->name('local.po_stock.open.index');

// SPPB
Route::get('/sppb', 'App\Http\Controllers\Admin\SppbController@index')->name('local.sppb.index');
Route::post('/sppb', 'App\Http\Controllers\Admin\SppbController@store')->name('local.sppb.store');
Route::patch('/sppb/{id}', 'App\Http\Controllers\Admin\SppbController@update')->name('local.sppb.update');
Route::get('/sppb/{id}/edit', 'App\Http\Controllers\Admin\SppbController@edit')->name('local.sppb.edit');
Route::delete('/sppb/{id}', 'App\Http\Controllers\Admin\SppbController@destroy')->name('local.sppb.delete');
Route::get('record/sppb', 'App\Http\Controllers\Admin\SppbController@recordSppb')->name('local.record.sppb');
Route::get('record/search_sppb', 'App\Http\Controllers\Admin\SppbController@searchSppb')->name('local.search.sppb');

// SPPB Detail
Route::get('/sppb_detail/{id}', 'App\Http\Controllers\Admin\SppbController@detail')->name('local.sppb.detail.index');
Route::post('/sppb_detail/{id}', 'App\Http\Controllers\Admin\SppbController@store_detail')->name('local.sppb.store_detail');
Route::get('/sppb/{id}/edit_detail', 'App\Http\Controllers\Admin\SppbController@edit_detail')->name('local.sppb.edit_detail');
Route::patch('/sppb_detail/{id}', 'App\Http\Controllers\Admin\SppbController@update_detail')->name('local.sppb.update_detail');
Route::delete('/sppb_detail/{id}', 'App\Http\Controllers\Admin\SppbController@destroy_detail')->name('local.sppb.delete_detail');
Route::get('record/sppb_detail/{id}/{inv_stat?}', 'App\Http\Controllers\Admin\SppbController@recordSppb_detail')->name('local.record.sppb_detail');
Route::get('/sppb_open/{id}', 'App\Http\Controllers\Admin\SppbController@sppb_open')->name('local.sppb.open.index');

// Invoice
Route::get('/inv', 'App\Http\Controllers\Admin\InvoiceController@index')->name('local.inv.index');
Route::post('/inv', 'App\Http\Controllers\Admin\InvoiceController@store')->name('local.inv.store');
Route::get('/inv/{id}/edit', 'App\Http\Controllers\Admin\InvoiceController@edit')->name('local.inv.edit');
Route::patch('/inv/{id}', 'App\Http\Controllers\Admin\InvoiceController@update')->name('local.inv.update');
Route::delete('/inv/{id}', 'App\Http\Controllers\Admin\InvoiceController@destroy')->name('local.inv.delete');
Route::get('record/inv', 'App\Http\Controllers\Admin\InvoiceController@recordInv')->name('local.record.inv');

// Invoice Detail
Route::get('/inv_detail/{id}', 'App\Http\Controllers\Admin\InvoiceController@detail')->name('local.inv.detail.index');
Route::post('/inv_detail/{id}', 'App\Http\Controllers\Admin\InvoiceController@store_detail')->name('local.inv.store_detail');
Route::get('/inv_detail/{id}/edit_detail', 'App\Http\Controllers\Admin\InvoiceController@edit_detail')->name('local.inv.edit_detail');
Route::patch('/inv_detail/{id}', 'App\Http\Controllers\Admin\InvoiceController@update_detail')->name('local.inv.update_detail');
Route::delete('/inv_detail/{id}', 'App\Http\Controllers\Admin\InvoiceController@destroy_detail')->name('local.inv.delete_detail');
Route::get('record/inv_detail/{id}/{inv_stat?}', 'App\Http\Controllers\Admin\InvoiceController@recordInv_detail')->name('local.record.inv_detail');
Route::get('/inv_open/{id}', 'App\Http\Controllers\Admin\InvoiceController@inv_open')->name('local.inv.open.index');
Route::get('/inv_batal/{id}', 'App\Http\Controllers\Admin\InvoiceController@inv_batal')->name('local.inv.batal.index');

// Receipt
Route::get('/rec', 'App\Http\Controllers\Admin\ReceiptController@index')->name('local.rec.index');
Route::post('/rec', 'App\Http\Controllers\Admin\ReceiptController@store')->name('local.rec.store');
Route::get('/rec/{id}/edit', 'App\Http\Controllers\Admin\ReceiptController@edit')->name('local.rec.edit');
Route::patch('/rec/{id}', 'App\Http\Controllers\Admin\ReceiptController@update')->name('local.rec.update');
Route::delete('/rec/{id}', 'App\Http\Controllers\Admin\ReceiptController@destroy')->name('local.rec.delete');
Route::get('record/rec', 'App\Http\Controllers\Admin\ReceiptController@recordRec')->name('local.record.rec');

// Receipt Detail
Route::get('/rec_detail/{id}', 'App\Http\Controllers\Admin\ReceiptController@detail')->name('local.rec.detail.index');
Route::post('/rec_detail/{id}', 'App\Http\Controllers\Admin\ReceiptController@store_detail')->name('local.rec.store_detail');
Route::get('/rec_detail/{id}/edit_detail', 'App\Http\Controllers\Admin\ReceiptController@edit_detail')->name('local.rec.edit_detail');
Route::patch('/rec_detail/{id}', 'App\Http\Controllers\Admin\ReceiptController@update_detail')->name('local.rec.update_detail');
Route::delete('/rec_detail/{id}', 'App\Http\Controllers\Admin\ReceiptController@destroy_detail')->name('local.rec.delete_detail');
Route::get('record/rec_detail/{id}/{rec_stat?}', 'App\Http\Controllers\Admin\ReceiptController@recordRec_detail')->name('local.record.rec_detail');
Route::get('/rec_open/{id}', 'App\Http\Controllers\Admin\ReceiptController@rec_open')->name('local.rec.open.index');

// Verify
Route::get('/po_stock/{id}/verify', 'App\Http\Controllers\Admin\PoStockController@verify')->name('local.po_stock.verify');
Route::get('/po_non_stock/{id}/verify', 'App\Http\Controllers\Admin\PoNonStockController@verify')->name('local.po_non_stock.verify');
Route::get('/sppb/{id}/verify', 'App\Http\Controllers\Admin\SppbController@verify')->name('local.sppb.verify');
Route::get('/inv/{id}/verify', 'App\Http\Controllers\Admin\InvoiceController@verify')->name('local.inv.verify');

// Approval
Route::get('/spbd/{id}/approve', 'App\Http\Controllers\Admin\SpbdController@approve')->name('local.spbd.approve');
Route::get('/po_stock/{id}/approve', 'App\Http\Controllers\Admin\PoStockController@approve')->name('local.po_stock.approve');
Route::get('/sppb/{id}/approve', 'App\Http\Controllers\Admin\SppbController@approve')->name('local.sppb.approve');
Route::get('/inv/{id}/approve', 'App\Http\Controllers\Admin\InvoiceController@approve')->name('local.inv.approve');
Route::get('/pelunasan/{id}/approve', 'App\Http\Controllers\Admin\PelunasanController@approve')->name('local.pelunasan.approve');
Route::get('/spb/{id}/approve', 'App\Http\Controllers\Admin\SpbController@approve')->name('local.spb.approve');
Route::get('/po_non_stock/{id}/approve', 'App\Http\Controllers\Admin\PoNonStockController@approve')->name('local.po_non_stock.approve');
Route::get('/adj/{id}/approve', 'App\Http\Controllers\Admin\AdjustmentController@approve')->name('local.adj.approve');
Route::get('/po_internal/{id}/approve', 'App\Http\Controllers\Admin\PoInternalController@approve')->name('local.po_internal.approve');
Route::get('/transfer/{id}/approve', 'App\Http\Controllers\Admin\TransferBranchController@approve')->name('local.transfer.approve');
Route::get('/transfer_receipt/{id}/approve', 'App\Http\Controllers\Admin\TransferReceiptController@approve')->name('local.transfer_receipt.approve');

// Print
Route::get('/spbd_print/{id}', 'App\Http\Controllers\Admin\PrintController@print_spbd')->name('local.print.spbd');
Route::get('/po_stock_print/{id}', 'App\Http\Controllers\Admin\PrintController@print_po_stock')->name('local.print.po_stock');
Route::get('/receipt_print/{id}', 'App\Http\Controllers\Admin\PrintController@print_receipt')->name('local.print.rec');
Route::get('/sppb_print/{id}', 'App\Http\Controllers\Admin\PrintController@print_sppb')->name('local.print.sppb');
Route::get('/inv_print/{id}', 'App\Http\Controllers\Admin\PrintController@print_inv')->name('local.print.inv');
Route::get('/pelunasan_print/{id}', 'App\Http\Controllers\Admin\PrintController@print_pelunasan')->name('local.print.pelunasan');
Route::get('/spb_print/{id}', 'App\Http\Controllers\Admin\PrintController@print_spb')->name('local.print.spb');
Route::get('/po_non_stock_print/{id}', 'App\Http\Controllers\Admin\PrintController@print_po_non_stock')->name('local.print.po_non_stock');
Route::get('/adj_print/{id}', 'App\Http\Controllers\Admin\PrintController@print_adj')->name('local.print.adj');
Route::get('/po_internal_print/{id}', 'App\Http\Controllers\Admin\PrintController@print_po_internal')->name('local.print.po_internal');
Route::get('/pembatalan_print/{id}', 'App\Http\Controllers\Admin\PrintController@print_pembatalan')->name('local.print.pembatalan');
Route::get('/transfer_print/{id}', 'App\Http\Controllers\Admin\PrintController@print_transfer')->name('local.print.transfer');
Route::get('/transfer_receipt_print/{id}', 'App\Http\Controllers\Admin\PrintController@print_transfer_receipt')->name('local.print.transfer_receipt');

// Pelunasan
Route::get('pelunasan', 'App\Http\Controllers\Admin\PelunasanController@index')->name('local.pelunasan.index');
Route::get('/pelunasan/{id}/add', 'App\Http\Controllers\Admin\PelunasanController@add_pelunasan')->name('local.pelunasan.add');
Route::post('/pelunasan', 'App\Http\Controllers\Admin\PelunasanController@store')->name('local.pelunasan.store');
Route::get('/pelunasan/{id}/edit', 'App\Http\Controllers\Admin\PelunasanController@edit')->name('local.pelunasan.edit');
Route::patch('/pelunasan/{id}', 'App\Http\Controllers\Admin\PelunasanController@update')->name('local.pelunasan.update');
Route::delete('/pelunasan/{id}', 'App\Http\Controllers\Admin\PelunasanController@destroy')->name('local.pelunasan.delete');
Route::get('record/pelunasan_inv', 'App\Http\Controllers\Admin\PelunasanController@recordInvPelunasan')->name('local.record.pelunasan_inv');
Route::get('record/pelunasan', 'App\Http\Controllers\Admin\PelunasanController@recordPelunasan')->name('local.record.pelunasan');

// SPB
Route::get('/spb', 'App\Http\Controllers\Admin\SpbController@index')->name('local.spb.index');
Route::post('/spb', 'App\Http\Controllers\Admin\SpbController@store')->name('local.spb.store');
Route::patch('/spb/{id}', 'App\Http\Controllers\Admin\SpbController@update')->name('local.spb.update');
Route::get('/spb/{id}/edit', 'App\Http\Controllers\Admin\SpbController@edit')->name('local.spb.edit');
Route::delete('/spb/{id}', 'App\Http\Controllers\Admin\SpbController@destroy')->name('local.spb.delete');
Route::get('record/spb', 'App\Http\Controllers\Admin\SpbController@recordSpb')->name('local.record.spb');
Route::get('record/search_spb', 'App\Http\Controllers\Admin\SpbController@searchSpb')->name('local.search.spb');

// SPB Detail
Route::get('/spb_detail/{id}', 'App\Http\Controllers\Admin\SpbController@detail')->name('local.spb.detail.index');
Route::post('/spb_detail/{id}', 'App\Http\Controllers\Admin\SpbController@store_detail')->name('local.spb.store_detail');
Route::get('/spb/{id}/edit_detail', 'App\Http\Controllers\Admin\SpbController@edit_detail')->name('local.spb.edit_detail');
Route::patch('/spb_detail/{id}', 'App\Http\Controllers\Admin\SpbController@update_detail')->name('local.spb.update_detail');
Route::delete('/spb_detail/{id}', 'App\Http\Controllers\Admin\SpbController@destroy_detail')->name('local.spb.delete_detail');
Route::get('record/spb_detail/{id}/{po_stat?}', 'App\Http\Controllers\Admin\SpbController@recordSpb_detail')->name('local.record.spb_detail');
Route::get('/spb_open/{id}', 'App\Http\Controllers\Admin\SpbController@spb_open')->name('local.spb.open.index');

// PO Stock
Route::get('/po_non_stock', 'App\Http\Controllers\Admin\PoNonStockController@index')->name('local.po_non_stock.index');
Route::post('/po_non_stock', 'App\Http\Controllers\Admin\PoNonStockController@store')->name('local.po_non_stock.store');
Route::get('/po_non_stock/{id}/edit', 'App\Http\Controllers\Admin\PoNonStockController@edit')->name('local.po_non_stock.edit');
Route::patch('/po_non_stock/{id}', 'App\Http\Controllers\Admin\PoNonStockController@update')->name('local.po_non_stock.update');
Route::delete('/po_non_stock/{id}', 'App\Http\Controllers\Admin\PoNonStockController@destroy')->name('local.po_non_stock.delete');
Route::get('record/po_non_stock', 'App\Http\Controllers\Admin\PoNonStockController@recordPoNonStock')->name('local.record.po_non_stock');

// PO Stock Detail
Route::get('/po_non_stock_detail/{id}', 'App\Http\Controllers\Admin\PoNonStockController@detail')->name('local.po_non_stock.detail.index');
Route::post('/po_non_stock_detail/{id}', 'App\Http\Controllers\Admin\PoNonStockController@store_detail')->name('local.po_non_stock.store_detail');
Route::get('/po_non_stock_detail/{id}/edit_detail', 'App\Http\Controllers\Admin\PoNonStockController@edit_detail')->name('local.po_non_stock.edit_detail');
Route::patch('/po_non_stock_detail/{id}', 'App\Http\Controllers\Admin\PoNonStockController@update_detail')->name('local.po_non_stock.update_detail');
Route::delete('/po_non_stock_detail/{id}', 'App\Http\Controllers\Admin\PoNonStockController@destroy_detail')->name('local.po_non_stock.delete_detail');
Route::get('record/po_non_stock_detail/{id}/{rec_stat?}', 'App\Http\Controllers\Admin\PoNonStockController@recordPoNonStock_detail')->name('local.record.po_non_stock_detail');
Route::get('/po_non_stock_detail_open/{id}', 'App\Http\Controllers\Admin\PoNonStockController@po_stock_open')->name('local.po_non_stock.open.index');

// Adjustment
Route::get('/adj', 'App\Http\Controllers\Admin\AdjustmentController@index')->name('local.adj.index');
Route::post('/adj', 'App\Http\Controllers\Admin\AdjustmentController@store')->name('local.adj.store');
Route::delete('/adj/{id}', 'App\Http\Controllers\Admin\AdjustmentController@destroy')->name('local.adj.delete');
Route::get('record/adj', 'App\Http\Controllers\Admin\AdjustmentController@recordAdj')->name('local.record.adj');

// Adjustment Detail
Route::get('/adj_detail/{id}', 'App\Http\Controllers\Admin\AdjustmentController@detail')->name('local.adj.detail.index');
Route::post('/adj_detail/{id}', 'App\Http\Controllers\Admin\AdjustmentController@store_detail')->name('local.adj.store_detail');
Route::get('/adj/{id}/edit_detail', 'App\Http\Controllers\Admin\AdjustmentController@edit_detail')->name('local.adj.edit_detail');
Route::patch('/adj_detail/{id}', 'App\Http\Controllers\Admin\AdjustmentController@update_detail')->name('local.adj.update_detail');
Route::delete('/adj_detail/{id}', 'App\Http\Controllers\Admin\AdjustmentController@destroy_detail')->name('local.adj.delete_detail');
Route::get('record/adj_detail/{id}', 'App\Http\Controllers\Admin\AdjustmentController@recordAjd_detail')->name('local.record.adj_detail');
Route::get('/adj_open/{id}', 'App\Http\Controllers\Admin\AdjustmentController@adj_open')->name('local.adj.open.index');

// PO Internal
Route::get('/po_internal', 'App\Http\Controllers\Admin\PoInternalController@index')->name('local.po_internal.index');
Route::post('/po_internal', 'App\Http\Controllers\Admin\PoInternalController@store')->name('local.po_internal.store');
Route::get('/po_internal/{id}/edit', 'App\Http\Controllers\Admin\PoInternalController@edit')->name('local.po_internal.edit');
Route::patch('/po_internal/{id}', 'App\Http\Controllers\Admin\PoInternalController@update')->name('local.po_internal.update');
Route::delete('/po_internal/{id}', 'App\Http\Controllers\Admin\PoInternalController@destroy')->name('local.po_internal.delete');
Route::get('record/po_internal', 'App\Http\Controllers\Admin\PoInternalController@recordPoInternal')->name('local.record.po_internal');

// SPPB Detail
Route::get('/po_internal_detail/{id}', 'App\Http\Controllers\Admin\PoInternalController@detail')->name('local.po_internal.detail.index');
Route::post('/po_internal_detail/{id}', 'App\Http\Controllers\Admin\PoInternalController@store_detail')->name('local.po_internal.store_detail');
Route::get('/po_internal/{id}/edit_detail', 'App\Http\Controllers\Admin\PoInternalController@edit_detail')->name('local.po_internal.edit_detail');
Route::patch('/po_internal_detail/{id}', 'App\Http\Controllers\Admin\PoInternalController@update_detail')->name('local.po_internal.update_detail');
Route::delete('/po_internal_detail/{id}', 'App\Http\Controllers\Admin\PoInternalController@destroy_detail')->name('local.po_internal.delete_detail');
Route::get('record/po_internal_detail/{id}', 'App\Http\Controllers\Admin\PoInternalController@recordPoInternal_detail')->name('local.record.po_internal_detail');
Route::get('/po_internal_open/{id}', 'App\Http\Controllers\Admin\PoInternalController@po_internal_open')->name('local.po_internal.open.index');

// Pembatalan
Route::get('/pembatalan', 'App\Http\Controllers\Admin\PembatalanController@index')->name('local.pembatalan.index');
Route::get('record/pembatalan', 'App\Http\Controllers\Admin\PembatalanController@recordPembatalan')->name('local.record.pembatalan');
Route::post('/pembatalan/{type}', 'App\Http\Controllers\Admin\PembatalanController@store')->name('local.pembatalan.store');
Route::delete('/pembatalan/{id}', 'App\Http\Controllers\Admin\PembatalanController@destroy')->name('local.pembatalan.delete');
Route::get('/pembatalan/{id}/approve', 'App\Http\Controllers\Admin\PembatalanController@approve')->name('local.pembatalan.approve');

// Search Pembatalan
Route::get('pembatalan/search_po_stock', 'App\Http\Controllers\Admin\PembatalanController@searchPoStock')->name('local.pembatalan.search.po_stock');
Route::get('pembatalan/search_po_non_stock', 'App\Http\Controllers\Admin\PembatalanController@searchPoNonStock')->name('local.pembatalan.search.po_non_stock');
Route::get('pembatalan/search_inv', 'App\Http\Controllers\Admin\PembatalanController@searchInvoice')->name('local.pembatalan.search.inv');


// Transfer Branch
Route::get('/transfer', 'App\Http\Controllers\Admin\TransferBranchController@index')->name('local.transfer.index');
Route::post('/transfer', 'App\Http\Controllers\Admin\TransferBranchController@store')->name('local.transfer.store');
Route::get('/transfer/{id}/edit', 'App\Http\Controllers\Admin\TransferBranchController@edit')->name('local.transfer.edit');
Route::patch('/transfer/{id}', 'App\Http\Controllers\Admin\TransferBranchController@update')->name('local.transfer.update');
Route::delete('/transfer/{id}', 'App\Http\Controllers\Admin\TransferBranchController@destroy')->name('local.transfer.delete');
Route::get('record/transfer', 'App\Http\Controllers\Admin\TransferBranchController@recordTransfer')->name('local.record.transfer');
Route::get('record/search_transfer', 'App\Http\Controllers\Admin\TransferBranchController@searchTransfer')->name('local.search.transfer');

// Transfer Branch Detail
Route::get('/transfer_detail/{id}', 'App\Http\Controllers\Admin\TransferBranchController@detail')->name('local.transfer.detail.index');
Route::post('/transfer_detail/{id}', 'App\Http\Controllers\Admin\TransferBranchController@store_detail')->name('local.transfer.store_detail');
Route::get('/transfer/{id}/edit_detail', 'App\Http\Controllers\Admin\TransferBranchController@edit_detail')->name('local.transfer.edit_detail');
Route::patch('/transfer_detail/{id}', 'App\Http\Controllers\Admin\TransferBranchController@update_detail')->name('local.transfer.update_detail');
Route::delete('/transfer_detail/{id}', 'App\Http\Controllers\Admin\TransferBranchController@destroy_detail')->name('local.transfer.delete_detail');
Route::get('record/transfer_detail/{id}/{rec_stat?}', 'App\Http\Controllers\Admin\TransferBranchController@recordTransfer_detail')->name('local.record.transfer_detail');
Route::get('/transfer_open/{id}', 'App\Http\Controllers\Admin\TransferBranchController@transfer_open')->name('local.transfer.open.index');

// Transfer Branch
Route::get('/transfer_receipt', 'App\Http\Controllers\Admin\TransferReceiptController@index')->name('local.transfer_receipt.index');
Route::post('/transfer_receipt', 'App\Http\Controllers\Admin\TransferReceiptController@store')->name('local.transfer_receipt.store');
Route::get('/transfer_receipt/{id}/edit', 'App\Http\Controllers\Admin\TransferReceiptController@edit')->name('local.transfer_receipt.edit');
Route::patch('/transfer_receipt/{id}', 'App\Http\Controllers\Admin\TransferReceiptController@update')->name('local.transfer_receipt.update');
Route::delete('/transfer_receipt/{id}', 'App\Http\Controllers\Admin\TransferReceiptController@destroy')->name('local.transfer_receipt.delete');
Route::get('record/transfer_receipt', 'App\Http\Controllers\Admin\TransferReceiptController@recordTransferReceipt')->name('local.record.transfer_receipt');
Route::get('/transfer_receipt_open/{id}', 'App\Http\Controllers\Admin\TransferReceiptController@transfer_receipt_open')->name('local.transfer_receipt.open.index');

// // Transfer Branch Detail
Route::get('/transfer_receipt_detail/{id}', 'App\Http\Controllers\Admin\TransferReceiptController@detail')->name('local.transfer_receipt.detail.index');
Route::post('/transfer_receipt_detail/{id}', 'App\Http\Controllers\Admin\TransferReceiptController@store_detail')->name('local.transfer_receipt.store_detail');
Route::get('/transfer_receipt/{id}/edit_detail', 'App\Http\Controllers\Admin\TransferReceiptController@edit_detail')->name('local.transfer_receipt.edit_detail');
Route::patch('/transfer_receipt_detail/{id}', 'App\Http\Controllers\Admin\TransferReceiptController@update_detail')->name('local.transfer_receipt.update_detail');
Route::delete('/transfer_receipt_detail/{id}', 'App\Http\Controllers\Admin\TransferReceiptController@destroy_detail')->name('local.transfer_receipt.delete_detail');
Route::get('record/transfer_receipt_detail/{id}', 'App\Http\Controllers\Admin\TransferReceiptController@recordTransfer_detail')->name('local.record.transfer_receipt_detail');
