<?php

use App\Livewire\Category\CategoryComponent;
use App\Livewire\Customer\CustomerComponent;
use App\Livewire\Home\Inicio;
use App\Livewire\Kardex\KardexComponent;
use App\Livewire\Movement\MovementComponent;
use App\Livewire\Product\ProductComponent;
use App\Livewire\Purchase\PurchaseComponent;
use App\Livewire\PurchaseOrder\PurchaseOrderComponent;
use App\Livewire\Quote\QuoteComponent;
use App\Livewire\Sale\SaleComponent;
use App\Livewire\Supplier\SupplierComponent;
use App\Livewire\Transfer\TransferComponent;
use App\Livewire\Warehouse\WarehouseComponent;
use Illuminate\Support\Facades\{Auth, Route};

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

// Compras
Route::get('/admin/compras', PurchaseComponent::class)->name('purchase.index');

Route::get('/admin/cotizaciones', QuoteComponent::class)->name('quote.index');

Route::get('/admin/ventas', SaleComponent::class)->name('sale.index');

Route::get('admin/movimientos', MovementComponent::class)->name('movement.index');

Route::get('admin/transferencias', TransferComponent::class)->name('transfer.index');

Route::get('admin/products/{product}/kardex', KardexComponent::class)->name('products.kardex');