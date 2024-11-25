<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('car_park_bookings', function (Blueprint $table) {
            $table->id();
             /*creates a foreign key constraint that looks at the id column of the car_park_spaces_references table
            Ensures that if a parking space is deleted in the car_park_spaces_references table
            all related bookings for that space are also deleted automatically in car_park_bookings_table */
            $table->foreignId('car_park_space_id')->constrained('car_park_spaces_references')->onDelete('cascade');
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_park_bookings');
    }
};
