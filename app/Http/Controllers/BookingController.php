<?php

namespace App\Http\Controllers;

use App\Models\CarParkBooking;
use App\Util\GetDailyRate;
use App\Util\CheckSpaceAvailable;
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

        return response()->json(['message' =>  "Price for booking will be £$total_price"], 200, [], JSON_UNESCAPED_UNICODE);
    }


    /**
     * Book a car park space
     * @return JsonResponse
     */

    public function bookCarParkSpace(Request $request): JsonResponse
    {
        $car_park_space_id = $request->car_park_space_id;
        $start_date = Carbon::parse($request->start_date);
        $end_date = Carbon::parse($request->end_date);

        $spaceAvailable = CheckSpaceAvailable::getInstance()->checkSpaceAvailable($car_park_space_id, $start_date, $end_date);

        if ($spaceAvailable) {
            return response()->json(['message' => 'car park space already booked'], 400);
        }
        else {
            CarParkBooking::create([
            'car_park_space_id' => $car_park_space_id,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ]);

        $daily_rate = GetDailyRate::getInstance();
        $total_price = 0;

        while ($start_date->lessThan($end_date)) {
            $month = $start_date->month;
            $isWeekend = $start_date->isWeekend();
            $daily_rate_price = $daily_rate->getDailyRate($month, $isWeekend);
            $total_price += $daily_rate_price;
            $start_date->addDay();
        }

        return response()->json(['message' => "car park space booked successfully, total paid £$total_price"], 201, [], JSON_UNESCAPED_UNICODE);

        }
    }

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
