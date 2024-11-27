<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTruncation;
use Database\Seeders\CarParkSpacesSeeder;
use App\Models\CarParkBooking;

uses(DatabaseTruncation::class);

describe('BookCarParkSpaceTest', function() {
    // Seed the car_par_spaces_reference table in test database
     beforeEach(function() {
        $this->seed(CarParkSpacesSeeder::class);
    });

    it('should create a booking record in the car_park_bookings table when given car_park_space_id value between 1 - 10 inclusive', function () {
       $response = $this->postJson('/book-car-park-space', [
          "car_park_space_id" => "1",
          "start_date" => "2024-12-20",
          "end_date" => "2024-12-25"
       ]);

       $this->assertJson($response->getContent());

       $response->assertStatus(201);

       $response->assertJson([
        'message' => 'Car park space booked successfully, total paid £85'
    ]);
    });

       it('should return error 400 when attempting to create a booking record in the car_park_bookings when a record exists with overlapping dates', function () {
       // Insert a record into the car_park_bookings table
        CarParkBooking::create([
            'car_park_space_id' => '1',
            'start_date' => '2024-12-20',
            'end_date' => '2024-12-25',
        ]);

        $response = $this->postJson('/book-car-park-space', [
          "car_park_space_id" => "1",
          "start_date" => "2024-12-20",
          "end_date" => "2024-12-25"
       ]);

       $this->assertJson($response->getContent());

       $response->assertStatus(400);

       $response->assertJson([
        'message' => 'Car park space already booked'
    ]);
    });


    it('should return error 500 when attempting to create a booking record in car_park_bookings table when given car_park_space_id value 11 and over', function () {

       $response = $this->postJson('/book-car-park-space', [
          "car_park_space_id" => "11",
          "start_date" => "2024-12-20",
          "end_date" => "2024-12-25"
       ]);

       $this->assertJson($response->getContent());

       $response->assertStatus(500);
    });
});



