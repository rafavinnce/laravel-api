<?php

namespace Modules\Carrier\Validators;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Prettus\Validator\LaravelValidator;

class CarrierValidator extends LaravelValidator
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
                'required', 'max:100', Rule::unique('carrier_carriers'),
            ],
            'id_external' => [
                'required', 'integer', Rule::unique('carrier_carriers'),
            ],
            'is_casual' => [
                'boolean'
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
                'required', 'max:100', Rule::unique('carrier_carriers')->ignore($id, 'id'),
            ],
            'id_external' => [
                'required', 'integer', Rule::unique('carrier_carriers')->ignore($id, 'id'),
            ],
            'is_casual' => [
                'boolean'
            ],
        ];
    }
}
