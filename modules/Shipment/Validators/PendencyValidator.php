<?php

namespace Modules\Shipment\Validators;

use Illuminate\Http\Request;
use Prettus\Validator\LaravelValidator;

class PendencyValidator extends LaravelValidator
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
            'name' => [
                'required', 'max:100',
            ],
            'shipment_id' => [
                'required', 'exists:shipment_shipments,id',
            ],
            'step_id' => [
                'required', 'exists:shipment_steps,id',
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
            'name' => [
                'required', 'max:100',
            ],
        ];
    }
}
