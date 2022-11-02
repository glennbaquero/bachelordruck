<?php

use Illuminate\Support\Facades\Route;

Route::get('/product_formats', \App\Livewire\Domain\Products\Lists\ProductFormatsList::class)->name('product_format.list');
Route::get('/product_formats/create', \App\Livewire\Domain\Products\Create\ProductFormatCreate::class)->name('product_format.create');
Route::get('/product_formats/{model}', \App\Livewire\Domain\Products\Show\ProductFormatShow::class)->name('product_format.show');
Route::get('/product_formats/{model}/edit', \App\Livewire\Domain\Products\Edit\ProductFormatEdit::class)->name('product_format.edit');
