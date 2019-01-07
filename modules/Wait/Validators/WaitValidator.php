<?php

namespace Modules\Wait\Validators;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Prettus\Validator\LaravelValidator;

class WaitValidator extends LaravelValidator
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
            'driver' => [
                'required', 'max:100',
            ],
            'manifest' => [
                'required', 'max:32',
            ],
            'seal1' => [
                'max:32',
            ],
            'seal2' => [
                'max:32',
            ],
            'authorized_by' => [
                'max:100',
            ],
            'arrival_at' => [
                'date',
            ],
            'entry_at' => [
                'date',
            ],
            'output_at' => [
                'date',
            ],
            'operation_id' => [
                'required', 'integer',
            ],
            'board_horse_id' => [
                'required', 'integer',
            ],
            'board_cart_id' => [
                'integer',
            ],
            'carrier_id' => [
                'required', 'integer',
            ],
            'lobby_id' => [
                'required', 'integer',
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
            'driver' => [
                'required', 'max:100',
            ],
            'manifest' => [
                'required', 'max:32',
            ],
            'seal1' => [
                'max:32',
            ],
            'seal2' => [
                'max:32',
            ],
            'authorized_by' => [
                'max:100',
            ],
            'arrival_at' => [
                'date',
            ],
            'entry_at' => [
                'date',
            ],
            'output_at' => [
                'date',
            ],
            'operation_id' => [
                'required', 'integer',
            ],
            'board_horse_id' => [
                'required', 'integer',
            ],
            'board_cart_id' => [
                'integer',
            ],
            'carrier_id' => [
                'required', 'integer',
            ],
            'lobby_id' => [
                'required', 'integer',
            ],
        ];
    }
}
