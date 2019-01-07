<?php

namespace Modules\Configuration\Validators;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Prettus\Validator\LaravelValidator;

class ConfigurationValidator extends LaravelValidator
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
            'title' => [
                'required', 'max:100',
            ],
            'name' => [
                'required', 'max:64', Rule::unique('configuration_configurations'),
            ],
            'type' => [
                'max:64',
            ],
            'value' => [
                'array',
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
            'title' => [
                'required', 'max:100',
            ],
            'type' => [
                'max:64',
            ],
            'value' => [
                'array',
            ],
        ];
    }
}
