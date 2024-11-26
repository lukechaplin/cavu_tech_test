<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CheckCarParkAvailabilityController;
use App\Http\Controllers\CalculateTotalPriceController;
use App\Http\Controllers\BookCarParkSpaceController;
use App\Http\Controllers\CancelCarParkBookingController;
use App\Http\Controllers\UpdateCarParkBookingController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/check-car-park-availability', [CheckCarParkAvailabilityController::class, 'checkCarParkAvailability']);

Route::get('/check-car-park-price', [CalculateTotalPriceController::class, 'calculateTotalPrice']);

Route::post('/book-car-park-space', [BookCarParkSpaceController::class, 'bookCarParkSpace']);

Route::delete('/cancel-car-park-booking', [CancelCarParkBookingController::class, 'cancelCarParkBooking']);

Route::patch('/update-car-park-booking', [UpdateCarParkBookingController::class, 'updateCarParkBooking']);
