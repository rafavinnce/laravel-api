<?php

namespace Modules\Status\Validators;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Prettus\Validator\LaravelValidator;

class StatusValidator extends LaravelValidator
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
                'required', 'max:64',
            ],
            'code' => [
                'required', 'integer', Rule::unique('status_status'),
            ],
            'type' => [
                'required', 'max:32',
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
                'required', 'max:64',
            ],
            'code' => [
                'required', 'integer', Rule::unique('status_status')->ignore($id, 'id'),
            ],
            'type' => [
                'required', 'max:32',
            ],
        ];
    }
}
