<?php

namespace Tests\Unit;

use App\Util\CheckSpaceAvailable;
use App\Models\CarParkBooking;
use Mockery;
use Carbon\Carbon;


describe('CheckSpaceAvailableTest', function() {
     beforeEach(function() {
        $this->mock = Mockery::mock(CarParkBooking::class);
        $this->instance(
            CarParkBooking::class,
            $this->mock
        );
    });

    it('testSpaceAlreadyBookedReturnsTrue', function () {

        $car_park_space_id = '1';
        $start_date = Carbon::parse('2024-12-20');
        $end_date = Carbon::parse('2024-12-25');

        $this->mock->shouldReceive('where')
            ->with('car_park_space_id', $car_park_space_id)
            ->andReturnSelf();
        $this->mock->shouldReceive('where')
            ->with(Mockery::on(function ($query) use ($start_date, $end_date) {
                $query->whereBetween('start_date', [$start_date, $end_date])
                    ->orWhereBetween('end_date', [$start_date, $end_date])
                    ->orWhere(function ($query) use ($start_date, $end_date) {
                        $query->where('start_date', '<=', $start_date)
                            ->where('end_date', '>=', $end_date);
                    });
                return true;
            }))
            ->andReturnSelf();
        $this->mock->shouldReceive('exists')
            ->andReturn(true);

        $checkSpaceAvailable = CheckSpaceAvailable::getInstance();

        $result = $checkSpaceAvailable->spaceAlreadyBooked(1, Carbon::parse('2024-12-20'), Carbon::parse('2024-12-25'));

        $this->assertTrue($result);
    });


    it('testSpaceAlreadyBookedReturnsFalse', function () {
        $car_park_space_id = '2';
        $start_date = Carbon::parse('2024-12-21');
        $end_date = Carbon::parse('2024-12-26');

        $this->mock->shouldReceive('where')
            ->with('car_park_space_id', $car_park_space_id)
            ->andReturnSelf();
        $this->mock->shouldReceive('where')
            ->with(Mockery::on(function ($query) use ($start_date, $end_date) {
                $query->whereBetween('start_date', [$start_date, $end_date])
                    ->orWhereBetween('end_date', [$start_date, $end_date])
                    ->orWhere(function ($query) use ($start_date, $end_date) {
                        $query->where('start_date', '<=', $start_date)
                            ->where('end_date', '>=', $end_date);
                    });
                return false;
            }))
            ->andReturnSelf();
        $this->mock->shouldReceive('exists')
            ->andReturn(false);

        $checkSpaceAvailable = CheckSpaceAvailable::getInstance();
        $result = $checkSpaceAvailable->spaceAlreadyBooked($car_park_space_id, $start_date, $end_date);

        $this->assertFalse($result);
    });
});

