<?php

use Illuminate\Support\Facades\Route;

Route::get('/divisions', \App\Livewire\Domain\Divisions\Lists\DivisionsList::class)->name('division.list');
Route::get('/divisions/create', \App\Livewire\Domain\Divisions\Create\DivisionCreate::class)->name('division.create');
Route::get('/divisions/create', \App\Livewire\Domain\Divisions\Create\DivisionCreate::class)->name('division.create');
Route::get('/divisions/{model}', \App\Livewire\Domain\Divisions\Show\DivisionShow::class)->name('division.show');
Route::get('/divisions/{model}/edit', \App\Livewire\Domain\Divisions\Edit\DivisionEdit::class)->name('division.edit');
