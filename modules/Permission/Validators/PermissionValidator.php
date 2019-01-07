<?php

namespace Modules\Permission\Validators;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Prettus\Validator\LaravelValidator;

class PermissionValidator extends LaravelValidator
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
                'required', 'max:80',
            ],
            'name' => [
                'required', 'max:64', Rule::unique('permission_permissions')->where(function ($query) use ($request) {
                    return $query->where('guard_name', $request->input('guard_name'));
                }),
            ],
            'guard_name' => [
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
            'title' => [
                'required', 'max:80',
            ],
            'name' => [
                'required', 'max:64', Rule::unique('permission_permissions')->where(function ($query) use ($request) {
                    return $query->where('guard_name', $request->input('guard_name'));
                })->ignore($id, 'id'),
            ],
            'guard_name' => [
                'required', 'max:32',
            ],
        ];
    }
}
