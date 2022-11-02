<?php

use Illuminate\Support\Facades\Route;

Route::get('/additional_services', \App\Livewire\Domain\Products\Lists\AdditionalServicesList::class)->name('additional_service.list');
Route::get('/additional_services/create', \App\Livewire\Domain\Products\Create\AdditionalServiceCreate::class)->name('additional_service.create');
Route::get('/additional_services/{model}', \App\Livewire\Domain\Products\Show\AdditionalServiceShow::class)->name('additional_service.show');
Route::get('/additional_services/{model}/edit', \App\Livewire\Domain\Products\Edit\AdditionalServiceEdit::class)->name('additional_service.edit');
