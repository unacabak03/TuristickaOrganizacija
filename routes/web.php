<?php

use App\Http\Controllers\TourController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TourController::class, 'home'])->name('homepage');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    \App\Http\Middleware\CheckRole::class . ':admin'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
