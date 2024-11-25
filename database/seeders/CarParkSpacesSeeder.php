<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CarParkSpacesReference;
use Exception;

class CarParkSpacesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
             CarParkSpacesReference::factory()->count(10)->create();
        } catch (Exception $e) {
            echo "Failed to insert rows" .$e->getMessage();
        }
    }
}

