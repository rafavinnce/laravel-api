<?php

namespace Modules\Shipment\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Carrier\Entities\Carrier;

class Load extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'shipment_loads';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'datetime',
        'sales_order',
        'item_code',
        'load_status_start',
        'wave',
        'billing_warehouse',
        'pre_number',
        'carrier_id',
        'dispatch_route',
        'customer_code',
        'load_number',
        'load_status',
        'amount',
        'volumes',
        'order_cubing',
    ];

    /**
     * Get the carrier of the load.
     */
    public function carrier()
    {
        return $this->belongsTo(Carrier::class, 'carrier_id', 'id');
    }

    /**
     * Get the shipments for the load.
     */
    public function shipments()
    {
        return $this->hasMany(Shipment::class, 'load_id', 'id');
    }
}
