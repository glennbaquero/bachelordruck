<?php

use Illuminate\Support\Facades\Route;

Route::get('/product_book_spine_colors', \App\Livewire\Domain\Products\Lists\ProductBookSpineColorsList::class)->name('product_book_spine_color.list');
Route::get('/product_book_spine_colors/create', \App\Livewire\Domain\Products\Create\ProductBookSpineColorCreate::class)->name('product_book_spine_color.create');
Route::get('/product_book_spine_colors/{model}', \App\Livewire\Domain\Products\Show\ProductBookSpineColorShow::class)->name('product_book_spine_color.show');
Route::get('/product_book_spine_colors/{model}/edit', \App\Livewire\Domain\Products\Edit\ProductBookSpineColorEdit::class)->name('product_book_spine_color.edit');
