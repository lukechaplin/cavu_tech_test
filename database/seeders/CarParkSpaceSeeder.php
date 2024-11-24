<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CarParkSpaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Attempt to insert 15 rows
        for ($i = 1; $i <= 15; $i++) {
            try {
                DB::table('car_park_spaces_reference')->insert([
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                echo "Inserted row $i successfully.\n";
            } catch (\Exception $e) {
                echo "Failed to insert row $i: " . $e->getMessage() . "\n";
            }
        }
    }
}
