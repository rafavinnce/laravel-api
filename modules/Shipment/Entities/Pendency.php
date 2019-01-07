<?php

namespace Modules\Shipment\Entities;

use Illuminate\Database\Eloquent\Model;

class Pendency extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'shipment_pendencies';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'assigned_by', 'finish_at', 'shipment_id', 'step_id',
    ];

    /**
     * Get the shipment of the pendency.
     */
    public function shipment()
    {
        return $this->belongsTo(Shipment::class, 'shipment_id', 'id');
    }

    /**
     * Get the step of the pendency.
     */
    public function step()
    {
        return $this->belongsTo(Step::class, 'step_id', 'id');
    }
}
