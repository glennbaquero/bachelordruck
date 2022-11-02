<?php

use Illuminate\Support\Facades\Route;

Route::get('/product_cover_colors', \App\Livewire\Domain\Products\Lists\ProductCoverColorsList::class)->name('product_cover_color.list');
Route::get('/product_cover_colors/create', \App\Livewire\Domain\Products\Create\ProductCoverColorCreate::class)->name('product_cover_color.create');
Route::get('/product_cover_colors/{model}', \App\Livewire\Domain\Products\Show\ProductCoverColorShow::class)->name('product_cover_color.show');
Route::get('/product_cover_colors/{model}/edit', \App\Livewire\Domain\Products\Edit\ProductCoverColorEdit::class)->name('product_cover_color.edit');
