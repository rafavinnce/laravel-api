<?php

namespace Modules\Operation\Tests\Validators;

use Illuminate\Validation\Rule;
use Modules\Operation\Validators\OperationValidator;
use Tests\TestCase;

class OperationValidatorTest extends TestCase
{
    /**
     * The operation validator instance.
     *
     * @var OperationValidator
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

        $this->validator = $this->app->make(OperationValidator::class);
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
                'required', 'max:32', Rule::unique('operation_operations'),
            ],
        ];

        $this->assertEquals($validators, OperationValidator::create($request));
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
                'required', 'max:32', Rule::unique('operation_operations')->ignore($id, 'id'),
            ],
        ];

        $this->assertEquals($validators, OperationValidator::update($id, $request));
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