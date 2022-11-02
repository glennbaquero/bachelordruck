<?php

use Illuminate\Support\Facades\Route;

Route::get('/product_back_covers', \App\Livewire\Domain\Products\Lists\ProductBackCoversList::class)->name('product_back_cover.list');
Route::get('/product_back_covers/create', \App\Livewire\Domain\Products\Create\ProductBackCoverCreate::class)->name('product_back_cover.create');
Route::get('/product_back_covers/{model}', \App\Livewire\Domain\Products\Show\ProductBackCoverShow::class)->name('product_back_cover.show');
Route::get('/product_back_covers/{model}/edit', \App\Livewire\Domain\Products\Edit\ProductBackCoverEdit::class)->name('product_back_cover.edit');
