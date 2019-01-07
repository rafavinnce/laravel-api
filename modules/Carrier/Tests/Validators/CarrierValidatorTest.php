<?php

namespace Modules\Carrier\Tests\Validators;

use Illuminate\Validation\Rule;
use Modules\Carrier\Validators\CarrierValidator;
use Tests\TestCase;

class CarrierValidatorTest extends TestCase
{
    /**
     * The carrier validator instance.
     *
     * @var CarrierValidator
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

        $this->validator = $this->app->make(CarrierValidator::class);
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
            'name' => [
                'required', 'max:100', Rule::unique('carrier_carriers'),
            ],
            'id_external' => [
                'required', 'integer', Rule::unique('carrier_carriers'),
            ],
            'is_casual' => [
                'boolean'
            ],
        ];

        $this->assertEquals($validators, CarrierValidator::create($request));
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
            'name' => [
                'required', 'max:100', Rule::unique('carrier_carriers')->ignore($id, 'id'),
            ],
            'id_external' => [
                'required', 'integer', Rule::unique('carrier_carriers')->ignore($id, 'id'),
            ],
            'is_casual' => [
                'boolean'
            ],
        ];

        $this->assertEquals($validators, CarrierValidator::update($id, $request));
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