<?php

namespace Modules\Notification\Tests\Validators;

use Illuminate\Validation\Rule;
use Modules\Notification\Validators\NotificationValidator;
use Tests\TestCase;

class NotificationValidatorTest extends TestCase
{
    /**
     * The notification validator instance.
     *
     * @var NotificationValidator
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

        $this->validator = $this->app->make(NotificationValidator::class);
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
            'message' => [
                'max:255',
            ],
            'user_id' => [
                'required', Rule::exists('user_users', 'id'),
            ],
            'extra' => [
                'array',
            ],
            'finish_at' => [
                'date',
            ],
        ];

        $this->assertEquals($validators, NotificationValidator::create($request));
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
            'message' => [
                'max:255',
            ],
            'user_id' => [
                'required', Rule::exists('user_users', 'id'),
            ],
            'extra' => [
                'array',
            ],
            'finish_at' => [
                'date',
            ],
        ];

        $this->assertEquals($validators, NotificationValidator::update($id, $request));
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