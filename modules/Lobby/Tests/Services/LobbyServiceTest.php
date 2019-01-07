<?php

namespace Modules\Lobby\Tests\Services;

use Faker\Provider;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Artisan;
use Modules\Lobby\Entities\Lobby;
use Modules\Lobby\Services\LobbyService;
use Tests\TestCase;

class LobbyServiceTest extends TestCase
{
    use WithFaker;

    /**
     * The driver service instance.
     *
     * @var LobbyService
     */
    protected $lobbyService;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('passport:install');

        $this->faker->addProvider(new Provider\pt_BR\Person($this->faker));

        $this->lobbyService = $this->app->make(LobbyService::class);
    }

    /**
     * Test it can store a newly created entity in storage.
     *
     * @return void
     */
    public function testItCanCreateEntity()
    {
        $values = [
            'name' => 'Lobby testing',
        ];

        $entity = $this->lobbyService->create($values);
        $data = $entity->toArray();

        $this->assertDatabaseHas('lobby_lobbies', $values);
        $this->assertInstanceOf(Lobby::class, $entity);

        foreach ($this->dataStructure() as $key) {
            $this->assertArrayHasKey($key, $data);
        }
    }

    /**
     * Test it can display a listing of the entity.
     *
     * @return void
     */
    public function testItCanListingEntity()
    {
        $amount = 2;
        factory(Lobby::class, $amount)->create();

        $list = $this->lobbyService->paginate();
        $data = current($list->items())->toArray();

        $this->assertInstanceOf(LengthAwarePaginator::class, $list);
        $this->assertEquals($amount, $list->total());

        foreach ($this->dataStructure() as $key) {
            $this->assertArrayHasKey($key, $data);
        }
    }

    /**
     * Test it can show the specified entity.
     *
     * @return void
     */
    public function testItCanShowEntity()
    {
        $fake = factory(Lobby::class)->create();
        $entity = $this->lobbyService->find($fake->id);
        $data = $entity->toArray();

        $this->assertInstanceOf(Lobby::class, $entity);

        foreach ($this->dataStructure() as $key) {
            $this->assertArrayHasKey($key, $data);
        }
    }

    /**
     * Test it can update the specified entity in storage.
     *
     * @return void
     */
    public function testItCanUpdateEntity()
    {
        $fake = factory(Lobby::class)->create();
        $entity = $this->lobbyService->find($fake->id);
        $data = [
            'name' => 'Name of dock testing updated',
        ];

        $entity->update($data);

        $this->assertDatabaseHas('lobby_lobbies', $data);
    }

    /**
     * Test it can remove the specified entity from storage.
     *
     * @return void
     */
    public function testItCanDestroyEntity()
    {
        $entity = factory(Lobby::class)->create();

        $response = $this->lobbyService->destroy($entity->id);

        $this->assertTrue($response);
    }

    /**
     * Clean up the testing environment before the next test.
     *
     * @return void
     */
    public function tearDown()
    {
        Artisan::call('migrate:reset');
        parent::tearDown();
    }

    /**
     * Structure of response entity.
     *
     * @return array
     */
    private function dataStructure()
    {
        return [
            'id',
            'name',
        ];
    }
}