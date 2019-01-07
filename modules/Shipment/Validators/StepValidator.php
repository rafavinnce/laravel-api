<?php

namespace Modules\Shipment\Validators;

use Illuminate\Http\Request;
use Prettus\Validator\LaravelValidator;

class StepValidator extends LaravelValidator
{
    /**
     * Get validation rules to create action.
     *
     * @param Request $request
     * @return array
     */
    public static function create($request)
    {
        return [
            'percent' => [
                'integer',
            ],
            'type_id' => [
                'required', 'exists:status_status,id',
            ],
            'status_id' => [
                'exists:status_status,id',
            ],
            'invoice_id' => [
                'exists:status_status,id',
            ],
            'shipment_id' => [
                'required', 'exists:shipment_shipments,id',
            ],
        ];
    }

    /**
     * Get validation rules to update action.
     *
     * @param integer $id
     * @param Request $request
     * @return array
     */
    public static function update($id, $request)
    {
        return [
            'percent' => [
                'integer',
            ],
            'type_id' => [
                'required', 'exists:status_status,id',
            ],
            'status_id' => [
                'exists:status_status,id',
            ],
            'invoice_id' => [
                'exists:status_status,id',
            ],
            'shipment_id' => [
                'required', 'exists:shipment_shipments,id',
            ],
        ];
    }
}
