<?php

namespace Modules\Shipment\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Status\Entities\Status;

class Step extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'shipment_steps';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'percent', 'updated_picking_at', 'shipment_id', 'status_id', 'type_id', 'invoice_id',
    ];

    /**
     * Get the steps for the shipment.
     */
    public function pendencies()
    {
        return $this->hasMany(Pendency::class, 'step_id', 'id')->orderBy('created_at', 'desc');
    }

    /**
     * Get the type of the step.
     */
    public function type()
    {
        return $this->belongsTo(Status::class, 'type_id', 'id');
    }

    /**
     * Get the shipment of the step.
     */
    public function shipment()
    {
        return $this->belongsTo(Shipment::class, 'shipment_id', 'id');
    }

    /**
     * Get the status of the step.
     */
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }

    /**
     * Get the invoice of the step.
     */
    public function invoice()
    {
        return $this->belongsTo(Status::class, 'invoice_id', 'id');
    }
}
