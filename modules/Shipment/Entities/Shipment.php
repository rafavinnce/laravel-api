<?php

namespace Modules\Shipment\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Dock\Entities\Dock;
use Modules\Wait\Entities\Wait;
use Modules\Carrier\Entities\Carrier;
use Modules\Operation\Entities\Operation;

class Shipment extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'shipment_shipments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'wait_id',
        'dock_id',
        'load_id',
        'box',
        'operation_id',
        'finish_at',
        'manifest_finish_at',
    ];

    /**
     * Get the pendencies for the shipment.
     */
    public function pendencies()
    {
        return $this->hasMany(Pendency::class, 'shipment_id', 'id')->orderBy('created_at', 'desc');
    }

    /**
     * Get the steps for the shipment.
     */
    public function steps()
    {
        return $this->hasMany(Step::class, 'shipment_id', 'id')->orderBy('created_at', 'desc');
    }

    /**
     * Get the wait of the shipment.
     */
    public function wait()
    {
        return $this->belongsTo(Wait::class, 'wait_id', 'id');
    }

    /**
     * Get the dock of the shipment.
     */
    public function dock()
    {
        return $this->belongsTo(Dock::class, 'dock_id', 'id');
    }

    /**
     * Get the operation of the shipment.
     */
    public function operation()
    {
        return $this->belongsTo(Operation::class, 'operation_id', 'id');
    }
}
