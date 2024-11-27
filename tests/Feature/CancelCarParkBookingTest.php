<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTruncation;
use Database\Seeders\CarParkSpacesSeeder;
use App\Models\CarParkBooking;

uses(DatabaseTruncation::class);

describe('CancelCarParkBookingTest', function() {
    // Seed the car_par_spaces_reference_table in test database
     beforeEach(function() {
        $this->seed(CarParkSpacesSeeder::class);

     // Insert a record into the car_park_bookings table
        CarParkBooking::create([
            'car_park_space_id' => '1',
            'start_date' => '2024-12-20',
            'end_date' => '2024-12-25',
        ]);
    });

    it('should return correctly when booking a car park space with car_park_space_id value between 1 - 10 inclusive', function () {
       $response = $this->deleteJson('/cancel-car-park-booking', [
          "car_park_space_id" => "1",
          "start_date" => "2024-12-20",
          "end_date" => "2024-12-25"
       ]);

       $this->assertJson($response->getContent());

       $response->assertStatus(200);

       $response->assertJson([
        'message' => 'car park booking for car park space 1 cancelled successfully'
    ]);
    });
});
