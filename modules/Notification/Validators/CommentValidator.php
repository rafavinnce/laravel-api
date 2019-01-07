<?php

namespace Modules\Notification\Validators;

use Illuminate\Http\Request;
use Prettus\Validator\LaravelValidator;

class CommentValidator extends LaravelValidator
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
            'comment' => [
                'required', 'max:512',
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
            'comment' => [
                'required', 'max:512',
            ],
            'extra' => [
                'array',
            ],
        ];
    }
}
