<?php

namespace Modules\Dock\Validators;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Prettus\Validator\LaravelValidator;

class DockValidator extends LaravelValidator
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
                'required', 'max:20', Rule::unique('dock_docks'),
            ]
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
                'required', 'max:20', Rule::unique('dock_docks')->ignore($id, 'id'),
            ]
        ];
    }
}
