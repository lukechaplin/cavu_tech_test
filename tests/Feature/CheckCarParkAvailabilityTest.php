<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTruncation;

uses(DatabaseTruncation::class);

describe('CheckCarParkAvailabilityTest', function() {

    it('should check if any available car park spaces for given dates', function () {
       $response = $this->postJson('/check-car-park-availability', [
          "start_date" => "2024-12-20",
          "end_date" => "2024-12-25"
       ]);

       $this->assertJson($response->getContent());

       $response->assertStatus(200);

       $response->assertJson([
        'message' => 'car park spaces available to book, spaces available 10'
    ]);
    });
});
