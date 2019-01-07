<?php

namespace Modules\Dock\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Carrier\Entities\Carrier;
use Modules\Shipment\Entities\Shipment;
use Modules\Wait\Entities\Wait;

class Dock extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dock_docks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Get the carrier of the dock.
     */
    public function carrier()
    {
        return $this->belongsTo(Carrier::class, 'carrier_id', 'id');
    }

    /**
     * Get the shipment record associated with the dock.
     */
    public function shipment()
    {
        return $this->hasOne(Shipment::class, 'dock_id', 'id');
    }

    /**
     * Get the carrier of the dock.
     */
    public function wait()
    {
        return $this->belongsTo(Wait::class, 'wait_id', 'id');
    }
}
