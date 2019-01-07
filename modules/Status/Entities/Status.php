<?php

namespace Modules\Status\Entities;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'status_status';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'code', 'type',
    ];
}
