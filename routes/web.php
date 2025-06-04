<?php
 # modificado
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\ProfileController; # modificado
use App\Http\Controllers\RentACarController;
use App\Http\Controllers\VehicleController;
use App\Livewire\ShowRental;
use App\Livewire\UserRentals;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('home'))->name('home');
Route::get('/about', fn() => view('about'))->name('about');

Route::middleware('guest')->group(function() {
    Route::get('/sign-in', [AuthController::class, 'showLogin'])->name('login');
    Route::get('/sign-up', [AuthController::class, 'showRegistration'])->name('register');
    Route::post('/sign-in', [AuthController::class, 'login'])->name('login.store');
    Route::post('/sign-up', [AuthController::class, 'register'])->name('register.store');

    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

Route::middleware('auth')->group(function() {
    Route::post('/sign-out', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/rents', UserRentals::class)->name('profile.rents');
});

/**
 * Business Logic Routes
 */
Route::get('/vehicles', [VehicleController::class, 'index'])->name('vehicles.index');
Route::get('/rent-a-car', [RentACarController::class, 'index'])->name('rent-a-car.index');

Route::middleware('auth')->group(function() {
    Route::get('/rent-a-car/{vehicle:id}', ShowRental::class)->name('rent-a-car.show'); # modificado
});