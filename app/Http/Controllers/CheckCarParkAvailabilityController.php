<?php

namespace App\Http\Controllers;

use App\Models\CarParkBooking;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;


class CheckCarParkAvailabilityController extends Controller
{
    /**
     * Check if car park spaces are available to book
     * @return JsonResponse
     */

    public function checkCarParkAvailability(Request $request): JsonResponse
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
}
