<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarParkSpacesReference extends Model
{

    /** @use HasFactory<\Database\Factories\CarParkSpacesReferenceFactory> */
    use HasFactory;

     /**
     * The table associated with the model.
     *
     * @var string
     */
      protected $table = 'car_park_spaces_references';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id',
        'created_at',
        'updated_at',
    ];

}
