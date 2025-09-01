<?php

use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\TourController;
use App\Models\Reservation;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;

Route::controller(TourController::class)->group(function () {
    Route::get('/', action: 'home')->name('homepage');
    Route::get('/tours/{tour}','show')->name('tours.show');
});

Route::middleware([
    'auth',
    'verified',
    \App\Http\Middleware\CheckRole::class . ':admin:manager',
])->group(function () {
    Route::get('/dashboard', [ReservationController::class, 'dashboard'])->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::name('reservation.')->prefix('/reservation')->group(function (){
        Route::controller(ReservationController::class)->group(function () {
            Route::get('/my', 'index')->name('index');
            Route::get('/{tour}', 'create')->name('create');
            Route::post('/{tour}','store')->name('store');
            Route::post('/{reservation}/cancel', 'cancel')->name('cancel');
        });

        Route::controller(ReviewController::class)->group(function () {
            Route::get('/{reservation}/review', 'create')->name('review.create');
            Route::post('/{reservation}/review','store')->name('review');
        });
    });
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
