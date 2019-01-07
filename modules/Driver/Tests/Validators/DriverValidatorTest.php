<?php

namespace Modules\Driver\Tests\Validators;

use Illuminate\Validation\Rule;
use Modules\Driver\Validators\DriverValidator;
use Tests\TestCase;

class DriverValidatorTest extends TestCase
{
    /**
     * The driver validator instance.
     *
     * @var DriverValidator
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

        $this->validator = $this->app->make(DriverValidator::class);
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
                'required', 'max:100', Rule::unique('driver_drivers'),
            ],
            'document' => [
                'required', 'max:18', Rule::unique('driver_drivers'),
            ],
        ];

        $this->assertEquals($validators, DriverValidator::create($request));
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
                'required', 'max:100', Rule::unique('driver_drivers')->ignore($id, 'id'),
            ],
            'document' => [
                'required', 'max:18', Rule::unique('driver_drivers')->ignore($id, 'id'),
            ],
        ];

        $this->assertEquals($validators, DriverValidator::update($id, $request));
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