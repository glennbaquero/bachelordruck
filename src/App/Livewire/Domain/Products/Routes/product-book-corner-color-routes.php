<?php

use Illuminate\Support\Facades\Route;

Route::get('/product_book_corner_colors', \App\Livewire\Domain\Products\Lists\ProductBookCornerColorsList::class)->name('product_book_corner_color.list');
Route::get('/product_book_corner_colors/create', \App\Livewire\Domain\Products\Create\ProductBookCornerColorCreate::class)->name('product_book_corner_color.create');
Route::get('/product_book_corner_colors/{model}', \App\Livewire\Domain\Products\Show\ProductBookCornerColorShow::class)->name('product_book_corner_color.show');
Route::get('/product_book_corner_colors/{model}/edit', \App\Livewire\Domain\Products\Edit\ProductBookCornerColorEdit::class)->name('product_book_corner_color.edit');
