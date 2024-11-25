<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CarParkBooking extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
      protected $table = 'car_park_bookings_table';


    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'car_park_space_id',
        'start_date',
        'end_date'
    ];

    /**
     * Get the car park space that belongs to the booking.
     * @return BelongsTo
     */

    public function carParkSpace(): BelongsTo
    {
        return $this->belongsTo(CarParkSpacesReference::class, 'car_park_space_id');
    }
}
