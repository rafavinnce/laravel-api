<?php

namespace Modules\Operation\Entities;

use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'operation_operations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];
}
