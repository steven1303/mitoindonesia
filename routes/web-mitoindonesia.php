<?php

use Illuminate\Support\Facades\Route;


// Route::get('/', 'App\Http\Controllers\Frontend\HomeController@index')->name('local.frontend.home');

// PO Internal
Route::get('/po_internal_new', 'App\Http\Controllers\Admin\PoInternalNewController@index')->name('local.po_internal.new.index');
Route::post('/po_internal_new', 'App\Http\Controllers\Admin\PoInternalNewController@store')->name('local.po_internal.new.store');
Route::get('/po_internal_new/{id}/edit', 'App\Http\Controllers\Admin\PoInternalNewController@edit')->name('local.po_internal.new.edit');
Route::patch('/po_internal_new/{id}', 'App\Http\Controllers\Admin\PoInternalNewController@update')->name('local.po_internal.new.update');
Route::delete('/po_internal_new/{id}', 'App\Http\Controllers\Admin\PoInternalNewController@destroy')->name('local.po_internal.new.delete');
Route::get('record/po_internal_new', 'App\Http\Controllers\Admin\PoInternalNewController@recordPoInternal')->name('local.record.po_internal.new');
Route::get('/po_internal_new/{id}/approve', 'App\Http\Controllers\Admin\PoInternalNewController@approve')->name('local.po_internal.new.approve');
Route::get('record/search_po_internal_new', 'App\Http\Controllers\Admin\PoInternalNewController@searchPoInternal')->name('local.search.po_internal.new');

// PO Internal Detail
Route::get('/po_internal_new_detail/{id}', 'App\Http\Controllers\Admin\PoInternalNewController@detail')->name('local.po_internal.detail.new.index');
Route::post('/po_internal_new_detail/{id}', 'App\Http\Controllers\Admin\PoInternalNewController@store_detail')->name('local.po_internal.new.store_detail');
Route::get('/po_internal_new/{id}/edit_detail', 'App\Http\Controllers\Admin\PoInternalNewController@edit_detail')->name('local.po_internal.new.edit_detail');
Route::patch('/po_internal_new_detail/{id}', 'App\Http\Controllers\Admin\PoInternalNewController@update_detail')->name('local.po_internal.new.update_detail');
Route::delete('/po_internal_new_detail/{id}', 'App\Http\Controllers\Admin\PoInternalNewController@destroy_detail')->name('local.po_internal.new.delete_detail');
Route::get('record/po_internal_new_detail/{id}/{status?}', 'App\Http\Controllers\Admin\PoInternalNewController@recordPoInternal_detail')->name('local.record.po_internal_detail.new');
Route::get('/po_internal_new_open/{id}', 'App\Http\Controllers\Admin\PoInternalNewController@po_internal_open')->name('local.po_internal.new.open.index');

// SPPB New
Route::get('/sppb_new', 'App\Http\Controllers\Admin\SppbNewController@index')->name('local.sppb.new.index');
Route::post('/sppb_new', 'App\Http\Controllers\Admin\SppbNewController@store')->name('local.sppb.new.store');
Route::patch('/sppb_new/{id}', 'App\Http\Controllers\Admin\SppbNewController@update')->name('local.sppb.new.update');
// Route::get('/sppb_new/{id}/edit', 'App\Http\Controllers\Admin\SppbNewController@edit')->name('local.sppb.new.edit');
Route::delete('/sppb_new/{id}', 'App\Http\Controllers\Admin\SppbNewController@destroy')->name('local.sppb.new.delete');
Route::get('record/sppb_new', 'App\Http\Controllers\Admin\SppbNewController@recordSppb')->name('local.record.sppb.new');
// Route::get('record/search_sppb_new', 'App\Http\Controllers\Admin\SppbNewController@searchSppb')->name('local.search.sppb.new');
// Route::get('/sppb_new/{id}/pembatalan', 'App\Http\Controllers\Admin\SppbNewController@pembatalan')->name('local.sppb.new.pembatalan');

// // SPPB New Detail
Route::get('/sppb_new_detail/{id}', 'App\Http\Controllers\Admin\SppbNewController@detail')->name('local.sppb.new.detail.index');
// Route::post('/sppb_new_detail/{id}', 'App\Http\Controllers\Admin\SppbNewController@store_detail')->name('local.sppb.new.store_detail');
// Route::get('/sppb_new/{id}/edit_detail', 'App\Http\Controllers\Admin\SppbNewController@edit_detail')->name('local.sppb.new.edit_detail');
// Route::patch('/sppb_new_detail/{id}', 'App\Http\Controllers\Admin\SppbNewController@update_detail')->name('local.sppb.new.update_detail');
// Route::delete('/sppb_new_detail/{id}', 'App\Http\Controllers\Admin\SppbNewController@destroy_detail')->name('local.sppb.new.delete_detail');
Route::get('record/sppb_new_detail/{id}/{inv_stat?}', 'App\Http\Controllers\Admin\SppbNewController@recordSppb_detail')->name('local.record.sppb_detail.new');
// Route::get('/sppb_new_open/{id}', 'App\Http\Controllers\Admin\SppbNewController@sppb_open')->name('local.sppb.new.open.index');

// Invoice
Route::get('/inv_new', 'App\Http\Controllers\Admin\InvoiceNewController@index')->name('local.inv.new.index');
Route::post('/inv_new', 'App\Http\Controllers\Admin\InvoiceNewController@store')->name('local.inv.new.store');
// Route::get('/inv_new/{id}/edit', 'App\Http\Controllers\Admin\InvoiceNewController@edit')->name('local.inv.new.edit');
Route::patch('/inv_new/{id}', 'App\Http\Controllers\Admin\InvoiceNewController@update')->name('local.inv.new.update');
Route::delete('/inv_new/{id}', 'App\Http\Controllers\Admin\InvoiceNewController@destroy')->name('local.inv.new.delete');
Route::get('record/inv_new', 'App\Http\Controllers\Admin\InvoiceNewController@recordInv')->name('local.record.inv.new');
// Route::get('/inv_new/{id}/pembatalan', 'App\Http\Controllers\Admin\InvoiceNewController@pembatalan')->name('local.inv.new.pembatalan');

// // Invoice Detail
Route::get('/inv_new_detail/{id}', 'App\Http\Controllers\Admin\InvoiceNewController@detail')->name('local.inv.detail.new.index');
// Route::post('/inv_new_detail/{id}', 'App\Http\Controllers\Admin\InvoiceNewController@store_detail')->name('local.inv.new.store_detail');
// Route::get('/inv_new_detail/{id}/edit_detail', 'App\Http\Controllers\Admin\InvoiceNewController@edit_detail')->name('local.inv.new.edit_detail');
// Route::patch('/inv_new_detail/{id}', 'App\Http\Controllers\Admin\InvoiceNewController@update_detail')->name('local.inv.new.update_detail');
// Route::delete('/inv_new_detail/{id}', 'App\Http\Controllers\Admin\InvoiceNewController@destroy_detail')->name('local.inv.new.delete_detail');
// Route::get('record/inv_new_detail/{id}/{inv_stat?}', 'App\Http\Controllers\Admin\InvoiceNewController@recordInv_detail')->name('local.record.inv_detail.new');
// Route::get('/inv_new_open/{id}', 'App\Http\Controllers\Admin\InvoiceNewController@inv_open')->name('local.inv.new.open.index');
// Route::get('/inv_new_batal/{id}', 'App\Http\Controllers\Admin\InvoiceNewController@inv_batal')->name('local.inv.new.batal.index');
