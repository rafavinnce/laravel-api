<?php

namespace Modules\Shipment\Tests\Validators;

use Illuminate\Validation\Rule;
use Modules\Shipment\Validators\ShipmentValidator;
use Tests\TestCase;

class ShipmentValidatorTest extends TestCase
{
    /**
     * The dock validator instance.
     *
     * @var ShipmentValidator
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

        $this->validator = $this->app->make(ShipmentValidator::class);
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
            'wait_id' => [
                'required', 'exists:wait_waits,id',
            ],
            'dock_id' => [
                'required', 'exists:dock_docks,id',
            ],
        ];

        $this->assertEquals($validators, ShipmentValidator::create($request));
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
            'wait_id' => [
                'required', 'exists:wait_waits,id',
            ],
            'dock_id' => [
                'required', 'exists:dock_docks,id',
            ],
        ];

        $this->assertEquals($validators, ShipmentValidator::update($id, $request));
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