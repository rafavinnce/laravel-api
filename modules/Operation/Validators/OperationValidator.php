<?php

namespace Modules\Operation\Validators;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Prettus\Validator\LaravelValidator;

class OperationValidator extends LaravelValidator
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
                'required', 'max:32', Rule::unique('operation_operations'),
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
                'required', 'max:32', Rule::unique('operation_operations')->ignore($id, 'id'),
            ],
        ];
    }
}
