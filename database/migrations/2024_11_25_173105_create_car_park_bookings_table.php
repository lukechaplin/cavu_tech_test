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
            $table->foreignId('car_park_space_id');
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamps();

            $table->foreign('car_park_space_id')->references('id')->on('car_park_spaces_references')->onDelete('cascade');
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

