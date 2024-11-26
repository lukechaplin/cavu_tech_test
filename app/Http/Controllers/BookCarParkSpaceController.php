<?php

namespace App\Http\Controllers;

use App\Models\CarParkBooking;
use App\Util\GetDailyRate;
use App\Util\CheckSpaceAvailable;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

class BookCarParkSpaceController extends Controller
{
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
}
