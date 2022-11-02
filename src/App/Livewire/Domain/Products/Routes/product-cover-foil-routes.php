<?php

use Illuminate\Support\Facades\Route;

Route::get('/product_cover_foils', \App\Livewire\Domain\Products\Lists\ProductCoverFoilsList::class)->name('product_cover_foil.list');
Route::get('/product_cover_foils/create', \App\Livewire\Domain\Products\Create\ProductCoverFoilCreate::class)->name('product_cover_foil.create');
Route::get('/product_cover_foils/{model}', \App\Livewire\Domain\Products\Show\ProductCoverFoilShow::class)->name('product_cover_foil.show');
Route::get('/product_cover_foils/{model}/edit', \App\Livewire\Domain\Products\Edit\ProductCoverFoilEdit::class)->name('product_cover_foil.edit');
