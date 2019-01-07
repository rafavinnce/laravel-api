<?php

namespace Modules\Shipment\Validators;

use Illuminate\Http\Request;
use Prettus\Validator\LaravelValidator;

class LoadValidator extends LaravelValidator
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
            'wave' => [
                'required',
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
            'wave' => [
                'required',
            ],
        ];
    }
}
