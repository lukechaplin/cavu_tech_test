<?php

namespace App\Util;

use App\Models\CarParkBooking;

class CheckSpaceAvailable {

    private static ?CheckSpaceAvailable $instance = null;

    // Private constructor to prevent direct instantiation
    private function __construct() {}

    // Method to get the singleton instance
    public static function getInstance(): CheckSpaceAvailable
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Check if car park spaces are available to book on given start and end date
     * @return bool
     */

    public function checkSpaceAvailable($car_park_space_id, $start_date, $end_date): bool
    {
       return CarParkBooking::where('car_park_space_id', $car_park_space_id)->where(function ($query) use ($start_date, $end_date) {
            $query->whereBetween('start_date', [$start_date, $end_date])
                  ->orWhereBetween('end_date', [$start_date, $end_date])
                  ->orWhere(function ($query) use ($start_date, $end_date) {
                      $query->where('start_date', '<=', $start_date)
                            ->where('end_date', '>=', $end_date);
                  });
        })
        ->exists();
    }
}
