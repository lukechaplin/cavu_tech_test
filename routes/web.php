<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/check-car-park-availability', [BookingController::class, 'checkCarParkAvailbility']);

Route::get('/check-car-park-price', [BookingController::class, 'calculateTotalPrice']);

Route::post('/book-car-park-space', [BookingController::class, 'bookCarParkSpace']);

Route::delete('/cancel-car-park-booking', [BookingController::class, 'cancelCarParkBooking']);

Route::patch('/update-car-park-booking', [BookingController::class, 'updateCarParkBooking']);
