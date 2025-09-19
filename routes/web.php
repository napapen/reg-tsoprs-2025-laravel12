<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RegistrationsController;

Route::get('/', [RegisterController::class, 'index'])->name('index');
Route::get('/create', [RegisterController::class, 'create'])->name('create');
Route::post('/store', [RegisterController::class, 'store'])->name('store');
Route::get('/show/{register}', [RegisterController::class, 'show'])->name('show');
Route::get('/edit/{register}', [RegisterController::class, 'edit'])->name('edit');
Route::put('/update/{register}', [RegisterController::class, 'update'])->name('update');
Route::delete('/delete/{register}', [RegisterController::class, 'destroy'])->name('delete');


Route::get('/', [RegistrationsController::class, 'index'])->name('home');

Route::get('/onsite', [RegistrationsController::class, 'showOnsiteForm'])->name('onsite.form');
Route::post('/onsite', [RegistrationsController::class, 'storeOnsite'])->name('onsite.store');

Route::get('/online', [RegistrationsController::class, 'showOnlineForm'])->name('online.form');
Route::post('/online', [RegistrationsController::class, 'storeOnline'])->name('online.store');

Route::get('/workshop', [RegistrationsController::class, 'showWorkshopForm'])->name('workshop.form');
Route::post('/workshop', [RegistrationsController::class, 'storeWorkshop'])->name('workshop.store');

// Success Page
Route::get('/success/{transid}', [RegistrationsController::class, 'success'])->name('registration.success');
