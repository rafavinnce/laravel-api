<?php

namespace Modules\Status\Tests\Validators;

use Illuminate\Validation\Rule;
use Modules\Status\Validators\StatusValidator;
use Tests\TestCase;

class StatusValidatorTest extends TestCase
{
    /**
     * The status validator instance.
     *
     * @var StatusValidator
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

        $this->validator = $this->app->make(StatusValidator::class);
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
                'required', 'max:64',
            ],
            'code' => [
                'required', 'integer', Rule::unique('status_status'),
            ],
            'type' => [
                'required', 'max:32',
            ],
        ];

        $this->assertEquals($validators, StatusValidator::create($request));
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
                'required', 'max:64',
            ],
            'code' => [
                'required', 'integer', Rule::unique('status_status')->ignore($id, 'id'),
            ],
            'type' => [
                'required', 'max:32',
            ],
        ];

        $this->assertEquals($validators, StatusValidator::update($id, $request));
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