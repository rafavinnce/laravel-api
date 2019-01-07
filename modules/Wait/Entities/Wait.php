<?php

namespace Modules\Wait\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Carrier\Entities\Carrier;
use Modules\Lobby\Entities\Lobby;
use Modules\Operation\Entities\Operation;
use Modules\Shipment\Entities\Shipment;
use Modules\Vehicle\Entities\Vehicle;

class Wait extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'wait_waits';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'driver', 'manifest', 'seal1', 'seal2', 'authorized_by', 'arrival_at', 'entry_at',
        'output_at', 'operation_id', 'lobby_id', 'board_cart_id', 'board_horse_id', 'carrier_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'arrival_at' => 'datetime',
        'entry_at' => 'datetime',
        'output_at' => 'datetime',
    ];

    /**
     * Get the shipment record associated with the wait.
     */
    public function shipment()
    {
        return $this->hasOne(Shipment::class, 'wait_id', 'id');
    }

    /**
     * Get the carrier of the wait.
     */
    public function carrier()
    {
        return $this->belongsTo(Carrier::class, 'carrier_id', 'id');
    }

    /**
     * Get the board horse of the wait.
     */
    public function boardHorse()
    {
        return $this->belongsTo(Vehicle::class, 'board_horse_id', 'id');
    }

    /**
     * Get the board cart of the wait.
     */
    public function boardCart()
    {
        return $this->belongsTo(Vehicle::class, 'board_cart_id', 'id');
    }

    /**
     * Get the lobby of the wait.
     */
    public function lobby()
    {
        return $this->belongsTo(Lobby::class, 'lobby_id', 'id');
    }

    /**
     * Get the operation of the wait.
     */
    public function operation()
    {
        return $this->belongsTo(Operation::class, 'operation_id', 'id');
    }
}
