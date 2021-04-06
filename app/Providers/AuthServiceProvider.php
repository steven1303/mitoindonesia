<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        // Admin
        Gate::define('admin.view', 'App\Policies\AdminPolicy@view');
        Gate::define('admin.store', 'App\Policies\AdminPolicy@store');
        Gate::define('admin.update', 'App\Policies\AdminPolicy@update');
        Gate::define('admin.delete', 'App\Policies\AdminPolicy@delete');
        Gate::define('admin.branch', 'App\Policies\AdminPolicy@branch');
        // Branch
        Gate::define('branch.view', 'App\Policies\BranchPolicy@view');
        Gate::define('branch.store', 'App\Policies\BranchPolicy@store');
        Gate::define('branch.update', 'App\Policies\BranchPolicy@update');
        Gate::define('branch.delete', 'App\Policies\BranchPolicy@delete');
        // Permission
        Gate::define('permission.view', 'App\Policies\PermissionPolicy@view');
        Gate::define('permission.store', 'App\Policies\PermissionPolicy@store');
        Gate::define('permission.update', 'App\Policies\PermissionPolicy@update');
        Gate::define('permission.delete', 'App\Policies\PermissionPolicy@delete');
        // Rule
        Gate::define('role.view', 'App\Policies\RolePolicy@view');
        Gate::define('role.store', 'App\Policies\RolePolicy@store');
        Gate::define('role.update', 'App\Policies\RolePolicy@update');
        Gate::define('role.delete', 'App\Policies\RolePolicy@delete');
        Gate::define('role.permission', 'App\Policies\RolePolicy@rolePermission');
        // Customer
        Gate::define('customer.view', 'App\Policies\CustomerPolicy@view');
        Gate::define('customer.store', 'App\Policies\CustomerPolicy@store');
        Gate::define('customer.update', 'App\Policies\CustomerPolicy@update');
        Gate::define('customer.delete', 'App\Policies\CustomerPolicy@delete');
        Gate::define('customer.info', 'App\Policies\CustomerPolicy@info');
        // Vendor
        Gate::define('vendor.view', 'App\Policies\VendorPolicy@view');
        Gate::define('vendor.store', 'App\Policies\VendorPolicy@store');
        Gate::define('vendor.update', 'App\Policies\VendorPolicy@update');
        Gate::define('vendor.delete', 'App\Policies\VendorPolicy@delete');
        Gate::define('vendor.info', 'App\Policies\VendorPolicy@info');
        // Stock Master
        Gate::define('stock.master.view', 'App\Policies\StockMasterPolicy@view');
        Gate::define('stock.master.store', 'App\Policies\StockMasterPolicy@store');
        Gate::define('stock.master.update', 'App\Policies\StockMasterPolicy@update');
        Gate::define('stock.master.delete', 'App\Policies\StockMasterPolicy@delete');
        Gate::define('stock.master.movement', 'App\Policies\StockMasterPolicy@movement');
         // Pricelist
         Gate::define('pricelist.view', 'App\Policies\PricelistPolicy@view');
         Gate::define('pricelist.update', 'App\Policies\PricelistPolicy@update');
         // SPBD
        Gate::define('spbd.view', 'App\Policies\SpbdPolicy@view');
        Gate::define('spbd.store', 'App\Policies\SpbdPolicy@store');
        Gate::define('spbd.update', 'App\Policies\SpbdPolicy@update');
        Gate::define('spbd.delete', 'App\Policies\SpbdPolicy@delete');
        Gate::define('spbd.open', 'App\Policies\SpbdPolicy@open');
        Gate::define('spbd.approve', 'App\Policies\SpbdPolicy@approve');
        Gate::define('spbd.print', 'App\Policies\SpbdPolicy@print');
         // PO Stock
         Gate::define('po.stock.view', 'App\Policies\PoStockPolicy@view');
         Gate::define('po.stock.store', 'App\Policies\PoStockPolicy@store');
         Gate::define('po.stock.update', 'App\Policies\PoStockPolicy@update');
         Gate::define('po.stock.delete', 'App\Policies\PoStockPolicy@delete');
         Gate::define('po.stock.open', 'App\Policies\PoStockPolicy@open');
         Gate::define('po.stock.verify', 'App\Policies\PoStockPolicy@verify');
         Gate::define('po.stock.approve', 'App\Policies\PoStockPolicy@approve');
         Gate::define('po.stock.print', 'App\Policies\PoStockPolicy@print');
         // Receipt
        Gate::define('receipt.view', 'App\Policies\ReceiptPolicy@view');
        Gate::define('receipt.store', 'App\Policies\ReceiptPolicy@store');
        Gate::define('receipt.update', 'App\Policies\ReceiptPolicy@update');
        Gate::define('receipt.delete', 'App\Policies\ReceiptPolicy@delete');
        Gate::define('receipt.open', 'App\Policies\ReceiptPolicy@open');
        Gate::define('receipt.print', 'App\Policies\ReceiptPolicy@print');
         // SPB
         Gate::define('spb.view', 'App\Policies\SpbPolicy@view');
         Gate::define('spb.store', 'App\Policies\SpbPolicy@store');
         Gate::define('spb.update', 'App\Policies\SpbPolicy@update');
         Gate::define('spb.delete', 'App\Policies\SpbPolicy@delete');
         Gate::define('spb.open', 'App\Policies\SpbPolicy@open');
         Gate::define('spb.approve', 'App\Policies\SpbPolicy@approve');
         Gate::define('spb.print', 'App\Policies\SpbPolicy@print');
         // PO NonStock
         Gate::define('po.non.stock.view', 'App\Policies\PoNonStockPolicy@view');
         Gate::define('po.non.stock.store', 'App\Policies\PoNonStockPolicy@store');
         Gate::define('po.non.stock.update', 'App\Policies\PoNonStockPolicy@update');
         Gate::define('po.non.stock.delete', 'App\Policies\PoNonStockPolicy@delete');
         Gate::define('po.non.stock.open', 'App\Policies\PoNonStockPolicy@open');
         Gate::define('po.non.stock.verify', 'App\Policies\PoNonStockPolicy@verify');
         Gate::define('po.non.stock.approve', 'App\Policies\PoNonStockPolicy@approve');
         Gate::define('po.non.stock.print', 'App\Policies\PoNonStockPolicy@print');
         // SPPB
         Gate::define('sppb.view', 'App\Policies\SppbPolicy@view');
         Gate::define('sppb.store', 'App\Policies\SppbPolicy@store');
         Gate::define('sppb.update', 'App\Policies\SppbPolicy@update');
         Gate::define('sppb.delete', 'App\Policies\SppbPolicy@delete');
         Gate::define('sppb.open', 'App\Policies\SppbPolicy@open');
         Gate::define('sppb.approve', 'App\Policies\SppbPolicy@approve');
         Gate::define('sppb.print', 'App\Policies\SppbPolicy@print');
         // Po Internal
         Gate::define('po.internal.view', 'App\Policies\PoInternalPolicy@view');
         Gate::define('po.internal.store', 'App\Policies\PoInternalPolicy@store');
         Gate::define('po.internal.update', 'App\Policies\PoInternalPolicy@update');
         Gate::define('po.internal.delete', 'App\Policies\PoInternalPolicy@delete');
         Gate::define('po.internal.open', 'App\Policies\PoInternalPolicy@open');
         Gate::define('po.internal.approve', 'App\Policies\PoInternalPolicy@approve');
         Gate::define('po.internal.print', 'App\Policies\PoInternalPolicy@print');
          // Invoice
          Gate::define('invoice.view', 'App\Policies\InvoicePolicy@view');
          Gate::define('invoice.store', 'App\Policies\InvoicePolicy@store');
          Gate::define('invoice.update', 'App\Policies\InvoicePolicy@update');
          Gate::define('invoice.delete', 'App\Policies\InvoicePolicy@delete');
          Gate::define('invoice.open', 'App\Policies\InvoicePolicy@open');
          Gate::define('invoice.verify', 'App\Policies\InvoicePolicy@verify');
          Gate::define('invoice.approve', 'App\Policies\InvoicePolicy@approve');
          Gate::define('invoice.print', 'App\Policies\InvoicePolicy@print');
           // Adjustment
           Gate::define('adjustment.view', 'App\Policies\AdjustmentPolicy@view');
           Gate::define('adjustment.store', 'App\Policies\AdjustmentPolicy@store');
           Gate::define('adjustment.update', 'App\Policies\AdjustmentPolicy@update');
           Gate::define('adjustment.delete', 'App\Policies\AdjustmentPolicy@delete');
           Gate::define('adjustment.open', 'App\Policies\AdjustmentPolicy@open');
           Gate::define('adjustment.old', 'App\Policies\AdjustmentPolicy@old');
           Gate::define('adjustment.approve', 'App\Policies\AdjustmentPolicy@approve');
           Gate::define('adjustment.print', 'App\Policies\AdjustmentPolicy@print');
           // Pelunasan
           Gate::define('pelunasan.view', 'App\Policies\PelunasanPolicy@view');
           Gate::define('pelunasan.store', 'App\Policies\PelunasanPolicy@store');
           Gate::define('pelunasan.update', 'App\Policies\PelunasanPolicy@update');
           Gate::define('pelunasan.delete', 'App\Policies\PelunasanPolicy@delete');
           Gate::define('pelunasan.approve', 'App\Policies\PelunasanPolicy@approve');
           Gate::define('pelunasan.print', 'App\Policies\PelunasanPolicy@print');
           // Pembatalan
           Gate::define('pembatalan.view', 'App\Policies\PembatalanPolicy@view');
           Gate::define('pembatalan.po.stock', 'App\Policies\PembatalanPolicy@po_stock');
           Gate::define('pembatalan.po.non.stock', 'App\Policies\PembatalanPolicy@po_non_stock');
           Gate::define('pembatalan.invoice', 'App\Policies\PembatalanPolicy@invoice');
           Gate::define('pembatalan.print', 'App\Policies\PembatalanPolicy@print');
    }
}
