<?php

use Illuminate\Support\Facades\Route;

Route::get('/products', \App\Livewire\Domain\Products\Lists\ProductsList::class)->name('product.list');
Route::get('/products/create', \App\Livewire\Domain\Products\Create\ProductCreate::class)->name('product.create');
Route::get('/products/{model}', \App\Livewire\Domain\Products\Show\ProductShow::class)->name('product.show');
Route::get('/products/{model}/edit', \App\Livewire\Domain\Products\Edit\ProductEdit::class)->name('product.edit');
