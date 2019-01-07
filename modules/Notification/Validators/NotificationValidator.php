<?php

namespace Modules\Notification\Validators;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Prettus\Validator\LaravelValidator;

class NotificationValidator extends LaravelValidator
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
            'message' => [
                'max:255',
            ],
            'type' => [
                'required', 'max:100',
            ],
            'extra' => [
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
            'message' => [
                'max:255',
            ],
            'type' => [
                'required', 'max:100',
            ],
            'extra' => [
                'array',
            ],
        ];
    }
}
