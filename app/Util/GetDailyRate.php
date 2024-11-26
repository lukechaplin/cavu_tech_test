<?php

namespace App\Util;

class GetDailyRate {

    private static ?GetDailyRate $instance = null;

    // Private constructor to prevent direct instantiation
    private function __construct() {}

    // Method to get the singleton instance
    public static function getInstance(): GetDailyRate
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private $rates = [
        'winter_weekday' => 15.00,
        'winter_weekend' => 20.00,
        'summer_weekday' => 10.00,
        'summer_weekend' => 15.00,
        'standard_weekday' => 12.00,
        'standard_weekend' => 18.00,
    ];

     /**
     * Get car park daily rate based on month and whether it is a weekend
     * @return float
     */
        public function getDailyRate($month, $isWeekend): float
    {
        if (in_array($month, [12, 1, 2])) { // Winter
            return $isWeekend ? $this->rates['winter_weekend'] : $this->rates['winter_weekday'];
        } elseif (in_array($month, [6, 7, 8])) { // Summer
            return $isWeekend ? $this->rates['summer_weekend'] : $this->rates['summer_weekday'];
        } else { // Standard months
            return $isWeekend ? $this->rates['standard_weekend'] : $this->rates['standard_weekday'];
        }
    }
}
