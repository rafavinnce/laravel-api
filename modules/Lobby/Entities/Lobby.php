<?php

namespace Modules\Lobby\Entities;

use Illuminate\Database\Eloquent\Model;

class Lobby extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'lobby_lobbies';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];
}
