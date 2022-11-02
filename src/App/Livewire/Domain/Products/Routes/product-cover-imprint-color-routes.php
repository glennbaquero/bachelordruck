<?php

use Illuminate\Support\Facades\Route;

Route::get('/product_cover_imprint_colors', \App\Livewire\Domain\Products\Lists\ProductCoverImprintColorsList::class)->name('product_cover_imprint_color.list');
Route::get('/product_cover_imprint_colors/create', \App\Livewire\Domain\Products\Create\ProductCoverImprintColorCreate::class)->name('product_cover_imprint_color.create');
Route::get('/product_cover_imprint_colors/{model}', \App\Livewire\Domain\Products\Show\ProductCoverImprintColorShow::class)->name('product_cover_imprint_color.show');
Route::get('/product_cover_imprint_colors/{model}/edit', \App\Livewire\Domain\Products\Edit\ProductCoverImprintColorEdit::class)->name('product_cover_imprint_color.edit');
