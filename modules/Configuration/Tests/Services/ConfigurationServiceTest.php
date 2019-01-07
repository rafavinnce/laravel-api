<?php

namespace Modules\Configuration\Tests\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Artisan;
use Modules\Configuration\Entities\Configuration;
use Modules\Configuration\Services\ConfigurationService;
use Tests\TestCase;

class ConfigurationServiceTest extends TestCase
{
    /**
     * The driver service instance.
     *
     * @var ConfigurationService
     */
    protected $configurationService;

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

        $this->configurationService = $this->app->make(ConfigurationService::class);
    }

    /**
     * Test it can store a newly created entity in storage.
     *
     * @return void
     */
    public function testItCanCreateEntity()
    {
        $values = factory(Configuration::class)->make()->toArray();

        $entity = $this->configurationService->create($values);
        $data = $entity->toArray();

        unset($values['value']);
        $this->assertDatabaseHas('configuration_configurations', $values);
        $this->assertInstanceOf(Configuration::class, $entity);

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
        factory(Configuration::class, $amount)->create();

        $list = $this->configurationService->paginate();
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
        $fake = factory(Configuration::class)->create();
        $entity = $this->configurationService->find($fake->id);
        $data = $entity->toArray();

        $this->assertInstanceOf(Configuration::class, $entity);

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
        $fake = factory(Configuration::class)->create();
        $entity = $this->configurationService->find($fake->id);
        $values =factory(Configuration::class)->make()->toArray();

        $entity->update($values);

        unset($values['value']);
        $this->assertDatabaseHas('configuration_configurations', $values);
    }

    /**
     * Test it can remove the specified entity from storage.
     *
     * @return void
     */
    public function testItCanDestroyEntity()
    {
        $entity = factory(Configuration::class)->create();

        $response = $this->configurationService->destroy($entity->id);

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
            'title',
            'name',
            'type',
            'value',
            'created_at',
            'updated_at',
        ];
    }
}