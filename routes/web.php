<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MaintenanceController;

Route::get('/', [MaintenanceController::class, 'index'])->name('index');
