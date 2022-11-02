<?php

use Illuminate\Support\Facades\Route;

Route::get('/employees', \App\Livewire\Domain\Employees\Lists\EmployeesList::class)->name('employee.list');
Route::get('/employees/create', \App\Livewire\Domain\Employees\Create\EmployeeCreate::class)->name('employee.create');
Route::get('/employees/{model}', \App\Livewire\Domain\Employees\Show\EmployeeShow::class)->name('employee.show');
Route::get('/employees/{model}/edit', \App\Livewire\Domain\Employees\Edit\EmployeeEdit::class)->name('employee.edit');
