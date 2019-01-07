<?php

namespace Modules\Vehicle\Validators;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Prettus\Validator\LaravelValidator;

class VehicleValidator extends LaravelValidator
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
            'board' => [
                'required', 'max:32', Rule::unique('vehicle_vehicles'),
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
            'board' => [
                'required', 'max:32', Rule::unique('vehicle_vehicles')->ignore($id, 'id'),
            ],
        ];
    }
}
