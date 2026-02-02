<?php

use App\Livewire\Category\CategoryComponent;
use App\Livewire\Customer\CustomerComponent;
use App\Livewire\Home\Inicio;
use App\Livewire\Product\ProductComponent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
