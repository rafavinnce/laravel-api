<?php

namespace Modules\Status\Tests\Services;

use Faker\Provider;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Artisan;
use Modules\Status\Entities\Status;
use Modules\Status\Services\StatusService;
use Tests\TestCase;

class StatusServiceTest extends TestCase
{
    /**
     * The status service instance.
     *
     * @var StatusService
     */
    protected $statusService;

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

        $this->statusService = $this->app->make(StatusService::class);
    }

    /**
     * Test it can store a newly created entity in storage.
     *
     * @return void
     */
    public function testItCanCreateEntity()
    {
        $values = factory(Status::class)->make()->toArray();

        $entity = $this->statusService->create($values);
        $data = $entity->toArray();

        $this->assertDatabaseHas('status_status', $values);
        $this->assertInstanceOf(Status::class, $entity);

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
        factory(Status::class, $amount)->create();

        $list = $this->statusService->paginate();
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
        $fake = factory(Status::class)->create();
        $entity = $this->statusService->find($fake->id);
        $data = $entity->toArray();

        $this->assertInstanceOf(Status::class, $entity);

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
        $fake = factory(Status::class)->create();
        $entity = $this->statusService->find($fake->id);
        $values = factory(Status::class)->make()->toArray();

        $entity->update($values);

        $this->assertDatabaseHas('status_status', $values);
    }

    /**
     * Test it can remove the specified entity from storage.
     *
     * @return void
     */
    public function testItCanDestroyEntity()
    {
        $entity = factory(Status::class)->create();
        $response = $this->statusService->destroy($entity->id);
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
            'code',
            'type',
            'created_at',
            'updated_at',
        ];
    }
}