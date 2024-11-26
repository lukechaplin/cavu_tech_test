<?php

namespace App\Http\Controllers;

use App\Models\CarParkBooking;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


class CancelCarParkBookingController extends Controller
{
    /**
     * Cancel a car park booking
     * @return JsonResponse
     */

    public function cancelCarParkBooking(Request $request): JsonResponse
    {
        $car_park_space_id = $request->car_park_space_id;

        $booking = CarParkBooking::where('car_park_space_id', $car_park_space_id)->first();
        $booking->delete();


        return response()->json(['message' => "car park booking for car park space $car_park_space_id cancelled successfully" ], 200);
    }
}
