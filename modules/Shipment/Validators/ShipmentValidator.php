<?php

namespace Modules\Shipment\Validators;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Prettus\Validator\LaravelValidator;

class ShipmentValidator extends LaravelValidator
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
            'wait_id' => [
                'required', 'exists:wait_waits,id',
            ],
            'dock_id' => [
                'required', 'exists:dock_docks,id',
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
            'wait_id' => [
                'required', 'exists:wait_waits,id',
            ],
            'dock_id' => [
                'required', 'exists:dock_docks,id',
            ],
        ];
    }
}
