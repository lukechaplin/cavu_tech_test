<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTruncation;
use Database\Seeders\CarParkSpacesSeeder;

uses(DatabaseTruncation::class);

describe('BookCarParkSpaceTest', function() {
    // Seed the car_par_spaces_reference_table in test database
     beforeEach(function() {
        $this->seed(CarParkSpacesSeeder::class);
    });

    it('should return correctly when booking a car park space with car_park_space_id value between 1 - 10 inclusive', function () {
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
});


describe('BookCarParkSpaceTest', function() {
    // Seed the car_par_spaces_reference_table in test database
     beforeEach(function() {
        $this->seed(CarParkSpacesSeeder::class);
    });

   it('should return error 500 when booking a car park space with car_park_space_id value over 11', function () {

       $response = $this->postJson('/book-car-park-space', [
          "car_park_space_id" => "11",
          "start_date" => "2024-12-20",
          "end_date" => "2024-12-25"
       ]);

       $this->assertJson($response->getContent());

       $response->assertStatus(500);
    });
});
