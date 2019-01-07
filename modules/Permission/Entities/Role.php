<?php

namespace Modules\Permission\Entities;

use Spatie\Permission\Models\Role as BaseRole;

class Role extends BaseRole
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'guard_name',
    ];
}
