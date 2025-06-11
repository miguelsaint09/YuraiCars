<?php
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VehicleController;
use App\Livewire\ShowRental;
use App\Livewire\UserRentals;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\VehicleReviewController;

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

Route::middleware('auth')->group(function() {
    Route::get('/rent-a-car/{vehicle:id}', ShowRental::class)->name('rent-a-car.show');
});

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::post('/contact', function (Request $request) {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'subject' => 'required|string|max:255',
        'message' => 'required|string',
    ]);

    // Here you can add the logic to handle the contact form submission
    // For example, sending an email, storing in database, etc.

    return redirect()->route('contact')->with('success', '¡Gracias por tu mensaje! Te contactaremos pronto.');
})->name('contact.submit');

// Reviews routes
Route::prefix('vehicles/{vehicle}')->group(function () {
    Route::get('/reviews', [VehicleReviewController::class, 'show'])->name('vehicles.reviews');
    Route::get('/review', [VehicleReviewController::class, 'show']); // Alias for reviews
    Route::post('/review', [VehicleReviewController::class, 'store'])->name('vehicles.review');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/rentals/{rental}', \App\Livewire\RentalDetails::class)->name('rentals.show');
});