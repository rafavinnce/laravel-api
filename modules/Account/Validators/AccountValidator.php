<?php

namespace Modules\Account\Validators;

use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class AccountValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'first_name' => ['required', 'max:30'],
            'last_name' => ['required', 'max:150'],
            'email' => ['required', 'email', 'max:255', 'unique:user_users,email'],
            'password' => ['required', 'min:6', 'max:255'],
            'is_active' => ['boolean'],
            'is_superuser' => ['boolean'],
            'is_staff' => ['boolean'],
        ],
        ValidatorInterface::RULE_UPDATE => [
            'first_name' => ['required', 'max:30'],
            'last_name' => ['required', 'max:150'],
            'email' => ['required', 'email', 'max:255', 'unique:user_users,email'],
            'password' => ['min:6', 'max:255'],
            'is_active' => ['boolean'],
            'is_superuser' => ['boolean'],
            'is_staff' => ['boolean'],
        ],
    ];
}
