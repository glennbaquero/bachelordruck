<?php

use Illuminate\Support\Facades\Route;

Route::get('/product_ribbon_colors', \App\Livewire\Domain\Products\Lists\ProductRibbonColorsList::class)->name('product_ribbon_color.list');
Route::get('/product_ribbon_colors/create', \App\Livewire\Domain\Products\Create\ProductRibbonColorCreate::class)->name('product_ribbon_color.create');
Route::get('/product_ribbon_colors/{model}', \App\Livewire\Domain\Products\Show\ProductRibbonColorShow::class)->name('product_ribbon_color.show');
Route::get('/product_ribbon_colors/{model}/edit', \App\Livewire\Domain\Products\Edit\ProductRibbonColorEdit::class)->name('product_ribbon_color.edit');
