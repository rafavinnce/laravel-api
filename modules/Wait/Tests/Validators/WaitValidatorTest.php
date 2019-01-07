<?php

namespace Modules\Wait\Tests\Validators;

use Modules\Wait\Validators\WaitValidator;
use Tests\TestCase;

class WaitValidatorTest extends TestCase
{
    /**
     * The wait validator instance.
     *
     * @var WaitValidator
     */
    protected $validator;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->validator = $this->app->make(WaitValidator::class);
    }

    /**
     * Test it can create story validators.
     *
     * @return void
     */
    public function testItCanCreateStoryValidators()
    {
        $request = $this->getMockBuilder('Illuminate\Http\Request');

        $validators = [
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

        $this->assertEquals($validators, WaitValidator::create($request));
    }

    /**
     * Test it can create update validators.
     *
     * @return void
     */
    public function testItCanCreateUpdateValidators()
    {
        $request = $this->getMockBuilder('Illuminate\Http\Request');
        $id = 1;

        $validators = [
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

        $this->assertEquals($validators, WaitValidator::update($id, $request));
    }

    /**
     * Clean up the testing environment before the next test.
     *
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();
    }
}