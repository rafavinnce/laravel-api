<?php

namespace Modules\Permission\Entities;

use Spatie\Permission\Models\Permission as BasePermission;

class Permission extends BasePermission
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'title', 'module', 'guard_name',
    ];
}
