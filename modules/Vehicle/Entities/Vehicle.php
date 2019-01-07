<?php

namespace Modules\Vehicle\Entities;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'vehicle_vehicles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'board',
    ];
}
