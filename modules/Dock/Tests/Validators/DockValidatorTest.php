<?php

namespace Modules\Dock\Tests\Validators;

use Illuminate\Validation\Rule;
use Modules\Dock\Validators\DockValidator;
use Tests\TestCase;

class DockValidatorTest extends TestCase
{
    /**
     * The dock validator instance.
     *
     * @var DockValidator
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

        $this->validator = $this->app->make(DockValidator::class);
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
                'required', 'max:20', Rule::unique('dock_docks'),
            ],
        ];

        $this->assertEquals($validators, DockValidator::create($request));
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
                'required', 'max:20', Rule::unique('dock_docks')->ignore($id, 'id'),
            ],
        ];

        $this->assertEquals($validators, DockValidator::update($id, $request));
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