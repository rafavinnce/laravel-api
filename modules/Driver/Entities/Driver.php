<?php

namespace Modules\Driver\Entities;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'driver_drivers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'document',
    ];
}
