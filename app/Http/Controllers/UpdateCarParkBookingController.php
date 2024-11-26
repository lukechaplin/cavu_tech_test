<?php

namespace App\Http\Controllers;

use App\Models\CarParkBooking;
use App\Util\GetDailyRate;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;


class UpdateCarParkBookingController extends Controller
{

    /**
     * Update a car park booking
     * @return JsonResponse
     */

    public function updateCarParkBooking(Request $request): JsonResponse
    {
        $car_park_space_id = $request->car_park_space_id;
        $start_date = Carbon::parse($request->start_date);
        $end_date = Carbon::parse($request->end_date);
        $daily_rate = GetDailyRate::getInstance();
        $total_price = 0;

        while ($start_date->lessThan($end_date)) {
            $month = $start_date->month;
            $isWeekend = $start_date->isWeekend();
            $daily_rate_price = $daily_rate->getDailyRate($month, $isWeekend);
            $total_price += $daily_rate_price;
            $start_date->addDay();
        }

        $booking = CarParkBooking::where('car_park_space_id', $car_park_space_id)->first();
        $booking->start_date = $request->start_date;
        $booking->end_date = $request->end_date;
        $booking->save();

        return response()->json(['message' => "car park booking updated successfully, new price is £$total_price"], 200, [], JSON_UNESCAPED_UNICODE);
    }
}
