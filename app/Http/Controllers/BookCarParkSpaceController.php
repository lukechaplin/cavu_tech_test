<?php

namespace App\Http\Controllers;

use App\Models\CarParkBooking;
use App\Util\CheckSpaceAvailable;
use App\Util\GetDailyRate;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;
use Exception;

class BookCarParkSpaceController extends Controller
{
    /**
     * Book a car park space
     * @return JsonResponse
     */
    public function bookCarParkSpace(Request $request): JsonResponse
    {
        try {
            $car_park_space_id = $request->car_park_space_id;
            $start_date = Carbon::parse($request->start_date);
            $end_date = Carbon::parse($request->end_date);

           $SpaceAlreadyBooked = CheckSpaceAvailable::getInstance()->spaceAlreadyBooked($car_park_space_id, $start_date, $end_date);

            if ($SpaceAlreadyBooked) {
                return response()->json(['message' => 'Car park space already booked'], 400);
            } else {
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

                return response()->json(['message' => "Car park space booked successfully, total paid £$total_price"], 201, [], JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $e) {

                return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
