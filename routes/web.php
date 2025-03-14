<?php

use App\Livewire\EmployeeList;
use App\Livewire\CustumerLocation;
use Illuminate\Support\Facades\Route;

Route::get('/', CustumerLocation::class);

Route::get('/teste', EmployeeList::class);

require __DIR__.'/auth.php';
