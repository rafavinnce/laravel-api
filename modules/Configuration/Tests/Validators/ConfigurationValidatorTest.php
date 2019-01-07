<?php

namespace Modules\Configuration\Tests\Validators;

use Illuminate\Validation\Rule;
use Modules\Configuration\Validators\ConfigurationValidator;
use Tests\TestCase;

class ConfigurationValidatorTest extends TestCase
{
    /**
     * The dock validator instance.
     *
     * @var ConfigurationValidator
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

        $this->validator = $this->app->make(ConfigurationValidator::class);
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
            'title' => [
                'required', 'max:100',
            ],
            'name' => [
                'required', 'max:64', Rule::unique('configuration_configurations'),
            ],
            'type' => [
                'max:64',
            ],
            'value' => [
                'array',
            ],
        ];

        $this->assertEquals($validators, ConfigurationValidator::create($request));
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
            'title' => [
                'required', 'max:100',
            ],
            'type' => [
                'max:64',
            ],
            'value' => [
                'array',
            ],
        ];

        $this->assertEquals($validators, ConfigurationValidator::update($id, $request));
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