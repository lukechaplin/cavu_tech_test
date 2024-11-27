<?php

namespace Tests\Feature;

describe('CalculateTroralPrice', function() {

    it('should calculate total price for booking a car park space', function () {
       $response = $this->postJson('/check-car-park-price', [
          "start_date" => "2024-12-20",
          "end_date" => "2024-12-25"
       ]);

       $this->assertJson($response->getContent());

       $response->assertStatus(200);

       $response->assertJson([
        'message' => 'Price for booking will be £85'
    ]);
    });
});
