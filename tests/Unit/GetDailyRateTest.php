<?php

namespace Tests\Unit;

use App\Util\GetDailyRate;

//test for summmer weekday
//test for summer weekend
//test for winter weekday
//test for wimter weekend
//test for rest of the year weekday
//test for rest of the year weekend

describe('GetDailyRatesTest', function() {
    it('testgetDailyRateWinterWeekday', function () {
        $daily_rate = GetDailyRate::getInstance();
        $result = $daily_rate->getDailyRate(1, false);
        $this->assertEquals(15, $result);
    });

    it('testgetDailyRateWinterWeekend', function () {
        $daily_rate = GetDailyRate::getInstance();
        $result = $daily_rate->getDailyRate(1, true);
        $this->assertEquals(20, $result);
    });

    it('testgetDailyRateSummerWeekday', function () {
        $daily_rate = GetDailyRate::getInstance();
        $result = $daily_rate->getDailyRate(6, false);
        $this->assertEquals(10, $result);
    });

    it('testgetDailyRateSummerWeekend', function () {
        $daily_rate = GetDailyRate::getInstance();
        $result = $daily_rate->getDailyRate(6, true);
        $this->assertEquals(15, $result);
    });

     it('testgetDailyRateRestOfYearWeekday', function () {
        $daily_rate = GetDailyRate::getInstance();
        $result = $daily_rate->getDailyRate(3, false);
        $this->assertEquals(12, $result);
    });

     it('testgetDailyRateRestOfYearWeekend', function () {
        $daily_rate = GetDailyRate::getInstance();
        $result = $daily_rate->getDailyRate(3, true);
        $this->assertEquals(18, $result);
    });
});
