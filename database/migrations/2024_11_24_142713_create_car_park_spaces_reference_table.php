<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
 public function up(): void
    {
        Schema::create('car_park_spaces_reference', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });

        // Adds a database trigger to limit the number of rows to 10
          if (Schema::hasTable('car_park_spaces_reference')) {
            DB::unprepared('
                CREATE TRIGGER limit_car_park_spaces_reference
                BEFORE INSERT ON car_park_spaces_reference
                FOR EACH ROW
                BEGIN
                    IF (SELECT COUNT(*) FROM car_park_spaces_reference) >= 10 THEN
                        SIGNAL SQLSTATE "45000"
                        SET MESSAGE_TEXT = "Cannot insert more than 10 car park spaces";
                    END IF;
                END
            ');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_park_spaces_reference');

         // Drops the trigger
        DB::unprepared('DROP TRIGGER IF EXISTS limit_car_park_spaces_reference');
    }
};
