<?php

namespace Modules\Lobby\Tests\Validators;

use Illuminate\Validation\Rule;
use Modules\Lobby\Validators\LobbyValidator;
use Tests\TestCase;

class LobbyValidatorTest extends TestCase
{
    /**
     * The dock validator instance.
     *
     * @var LobbyValidator
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

        $this->validator = $this->app->make(LobbyValidator::class);
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
                'required', 'max:50', Rule::unique('lobby_lobbies'),
            ],
        ];

        $this->assertEquals($validators, LobbyValidator::create($request));
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
                'required', 'max:50', Rule::unique('lobby_lobbies')->ignore($id, 'id'),
            ],
        ];

        $this->assertEquals($validators, LobbyValidator::update($id, $request));
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