<?php

use Illuminate\Support\Facades\Route;

Route::get('/product_paper_thicknesses', \App\Livewire\Domain\Products\Lists\ProductPaperThicknessesList::class)->name('product_paper_thickness.list');
Route::get('/product_paper_thicknesses/create', \App\Livewire\Domain\Products\Create\ProductPaperThicknessCreate::class)->name('product_paper_thickness.create');
Route::get('/product_paper_thicknesses/{model}', \App\Livewire\Domain\Products\Show\ProductPaperThicknessShow::class)->name('product_paper_thickness.show');
Route::get('/product_paper_thicknesses/{model}/edit', \App\Livewire\Domain\Products\Edit\ProductPaperThicknessEdit::class)->name('product_paper_thickness.edit');
