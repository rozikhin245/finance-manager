<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\SavingTargetController;

Route::get('/', function () {
    return view('welcome');
});

// route untuk login dengan google
Route::get('auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('transactions', TransactionController::class)->middleware('auth');

    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');


    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/add-balance', [DashboardController::class, 'addBalance'])->name('add.balance');


    Route::get('/saving-targets', [SavingTargetController::class, 'index'])->name('saving-targets.index');
    Route::post('/saving-targets', [SavingTargetController::class, 'store'])->name('saving-targets.store');
    Route::put('/saving-targets/{savingTarget}', [SavingTargetController::class, 'update'])->name('saving-targets.update');
    Route::delete('/saving-targets/{savingTarget}', [SavingTargetController::class, 'destroy'])->name('saving-targets.destroy');


    Route::post('/saving-targets/{id}/allocate', [SavingTargetController::class, 'allocate'])
    ->name('savingTargets.allocate');

});

require __DIR__.'/auth.php';
