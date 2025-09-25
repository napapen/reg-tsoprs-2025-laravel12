<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RegistrationsController;
use App\Http\Controllers\Auth\AuthController;

// Route::get('/', [RegisterController::class, 'index'])->name('index');
// Route::get('/create', [RegisterController::class, 'create'])->name('create');
// Route::post('/store', [RegisterController::class, 'store'])->name('store');
// Route::get('/show/{register}', [RegisterController::class, 'show'])->name('show');
// Route::get('/edit/{register}', [RegisterController::class, 'edit'])->name('edit');
// Route::put('/update/{register}', [RegisterController::class, 'update'])->name('update');
// Route::delete('/delete/{register}', [RegisterController::class, 'destroy'])->name('delete');


Route::get('/', [RegistrationsController::class, 'index'])->name('home');

Route::get('/onsite', [RegistrationsController::class, 'showOnsiteForm'])->name('onsite.form');
Route::post('/onsite', [RegistrationsController::class, 'storeOnsite'])->name('onsite.store');

Route::get('/online', [RegistrationsController::class, 'showOnlineForm'])->name('online.form');
Route::post('/online', [RegistrationsController::class, 'storeOnline'])->name('online.store');

Route::get('/workshop', [RegistrationsController::class, 'showWorkshopForm'])->name('workshop.form');
Route::post('/workshop', [RegistrationsController::class, 'storeWorkshop'])->name('workshop.store');

// Success Page
Route::get('/success/{transid}', [RegistrationsController::class, 'success'])->name('registration.success');


// Admin Routes
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/post-login', [AuthController::class, 'postLogin'])->name('login.post'); 
Route::get('/registration', [AuthController::class, 'registration'])->name('register');
Route::post('/post-registration', [AuthController::class, 'postRegistration'])->name('register.post'); 
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// กลุ่มที่ต้อง login ก่อน
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

    Route::get('/register-list', [AuthController::class, 'registerList'])->name('register.list');
    Route::post('/register/update-status', [AuthController::class, 'updateStatus'])
        ->name('register.updateStatus');
        
    Route::get('/register/{id}', [AuthController::class, 'registerDetail'])
    ->name('register.detail');

});

