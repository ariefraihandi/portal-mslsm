<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\GuestBookController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\RoleController;


Route::get('/',                                 [MaintenanceController::class, 'index'])->name('index');
Route::get('/buku-tamu',                        [GuestBookController::class, 'showBukuTamu'])->name('show.bukutamu');
Route::post('/submit-guestbook',                [GuestbookController::class, 'submit'])->name('submit-guestbook');

Route::get('/login',                            [AuthController::class, 'showLoginForm'])->name('login.view');
Route::get('/register',                         [AuthController::class, 'showRegisterForm'])->name('register.view');
Route::post('/register',                        [AuthController::class, 'register'])->name('register');

Route::get('/account/profile/detil',            [AccountController::class, 'showAccountDetil'])->name('login.view');
Route::get('/role/access',                      [RoleController::class, 'showRole'])->name('role.view');

Route::post('/send-notification', [NotificationController::class, 'sendNotification']);
