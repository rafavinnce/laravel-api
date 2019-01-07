<?php

namespace Modules\Carrier\Entities;

use Illuminate\Database\Eloquent\Model;

class Carrier extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'carrier_carriers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'id_external', 'is_casual', 'operation_start', 'operation_end',
    ];
}
