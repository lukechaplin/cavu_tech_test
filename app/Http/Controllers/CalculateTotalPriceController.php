<?php

namespace App\Http\Controllers;

use App\Util\GetDailyRate;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;


class CalculateTotalPriceController extends Controller
{
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
}
