<?php

namespace Modules\Vehicle\Tests\Validators;

use Illuminate\Validation\Rule;
use Modules\Vehicle\Validators\VehicleValidator;
use Tests\TestCase;

class VehicleValidatorTest extends TestCase
{
    /**
     * The vehicle validator instance.
     *
     * @var VehicleValidator
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

        $this->validator = $this->app->make(VehicleValidator::class);
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
            'board' => [
                'required', 'max:32', Rule::unique('vehicle_vehicles'),
            ],
        ];

        $this->assertEquals($validators, VehicleValidator::create($request));
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
            'board' => [
                'required', 'max:32', Rule::unique('vehicle_vehicles')->ignore($id, 'id'),
            ],
        ];

        $this->assertEquals($validators, VehicleValidator::update($id, $request));
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