<?php

namespace Modules\User\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class UserValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'first_name' => ['required', 'max:30'],
            'last_name'  => ['required', 'max:150'],
            'email'      => ['required', 'email', 'max:255', 'unique:user_users,email'],
            'password'   => ['required', 'min:6', 'max:255'],
        ],
        ValidatorInterface::RULE_UPDATE => [
            'first_name' => ['required', 'max:30'],
            'last_name'  => ['required', 'max:150'],
            'email'      => ['required', 'email', 'max:255', 'unique:user_users,email'],
            'password'   => ['min:6', 'max:255'],
        ],
   ];
}
