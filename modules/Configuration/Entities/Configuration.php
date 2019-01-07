<?php

namespace Modules\Configuration\Entities;

use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'configuration_configurations';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'value' => 'array',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'name', 'type', 'value',
    ];
}
