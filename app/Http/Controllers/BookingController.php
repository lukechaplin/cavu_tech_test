<?php

namespace App\Http\Controllers;

use App\Models\CarParkBooking;
use App\Util\GetDailyRate;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * Check if car park spaces are available to book
     * @return JsonResponse
     */
    public function checkCarParkAvailbility(Request $request): JsonResponse
    {

        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $start_date = Carbon::parse($request->start_date);
        $end_date = Carbon::parse($request->end_date);

        if (CarParkBooking::count() < 10) {
            $sum = CarParkBooking::where('start_date', '>=', $start_date)->where('end_date', '<=', $end_date)->count();
            $total = 10 - $sum;
            return response()->json(['message' => 'car park spaces available to book', 'spaces available' => $total], 200);
        } else {
            return response()->json(['message' => 'no car park spaces available'], 200);
        }
    }

    /**
     * calculate total price for car park booking
     * @return JsonResponse
     */

     public function calculateTotalPrice(Request $request): JsonResponse
    {
        $start = Carbon::parse($request->start_date);
        $end = Carbon::parse($request->end_date);
        $daily_rate = GetDailyRate::getInstance();
        $total_price = 0;

        while ($start->lessThan($end)) {
            $month = $start->month;
            $isWeekend = $start->isWeekend();
            $daily_rate_price = $daily_rate->getDailyRate($month, $isWeekend);
            $total_price += $daily_rate_price;
            $start->addDay();
        }

        return response()->json(['message' =>  "Price for booking will be £$total_price"], 200, [], JSON_UNESCAPED_UNICODE);
    }


    /**
     * Book a car park space
     * @return JsonResponse
     */

    public function bookCarParkSpace(Request $request): JsonResponse
    {
        $request->validate([
            'car_park_space_id' => 'required|exists:car_park_spaces_references,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $car_park_space_id = $request->car_park_space_id;
        $start_date = Carbon::parse($request->start_date);
        $end_date = Carbon::parse($request->end_date);

        CarParkBooking::create([
            'car_park_space_id' => $car_park_space_id,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ]);

        $start = Carbon::parse($request->start_date);
        $end = Carbon::parse($request->end_date);
        $daily_rate = GetDailyRate::getInstance();
        $total_price = 0;

        while ($start->lessThan($end)) {
            $month = $start->month;
            $isWeekend = $start->isWeekend();
            $daily_rate_price = $daily_rate->getDailyRate($month, $isWeekend);
            $total_price += $daily_rate_price;
            $start->addDay();
        }

        return response()->json(['message' => "car park space booked successfully, total paid £$total_price"], 201, [], JSON_UNESCAPED_UNICODE);
    }
}
