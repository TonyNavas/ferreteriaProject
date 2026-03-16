<?php

use Illuminate\Support\Facades\{Auth, Route};
use App\Livewire\Category\CategoryComponent;
use App\Livewire\Customer\CustomerComponent;
use App\Livewire\Home\Inicio;
use App\Livewire\Product\ProductComponent;
use App\Livewire\PurchaseOrder\PurchaseOrderComponent;
use App\Livewire\Supplier\SupplierComponent;
use App\Livewire\Warehouse\WarehouseComponent;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/inicio', Inicio::class)->name('inicio');
Route::get('/admin/categorias', CategoryComponent::class)->name('category.index');
Route::get('/admin/productos', ProductComponent::class)->name('product.index');
Route::get('/admin/clientes', CustomerComponent::class)->name('customer.index');
Route::get('/admin/proveedores', SupplierComponent::class)->name('supplier.index');
Route::get('/admin/almacen', WarehouseComponent::class)->name('warehouse.index');

// Ordenes de compra
Route::get('/admin/ordenes-compra', PurchaseOrderComponent::class)->name('purchaseorder.index');
