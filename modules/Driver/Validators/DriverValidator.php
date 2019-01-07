<?php

namespace Modules\Driver\Validators;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Prettus\Validator\LaravelValidator;

class DriverValidator extends LaravelValidator
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
                'required', 'max:100', Rule::unique('driver_drivers'),
            ],
            'document' => [
                'required', 'max:18', Rule::unique('driver_drivers'),
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
                'required', 'max:100', Rule::unique('driver_drivers')->ignore($id, 'id'),
            ],
            'document' => [
                'required', 'max:18', Rule::unique('driver_drivers')->ignore($id, 'id'),
            ],
        ];
    }
}
