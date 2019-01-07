<?php

namespace Modules\Shipment\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Modules\Shipment\Entities\Shipment;
use Modules\Shipment\Entities\Step;
use Modules\Shipment\Observers\ShipmentObserver;
use Modules\Shipment\Observers\StepObserver;
use Modules\Shipment\Repositories;

class ShipmentServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        Shipment::observe(ShipmentObserver::class);
        Step::observe(StepObserver::class);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Repositories\ShipmentRepository::class, Repositories\ShipmentRepositoryEloquent::class);
        $this->app->bind(Repositories\StepRepository::class, Repositories\StepRepositoryEloquent::class);
        $this->app->bind(Repositories\PendencyRepository::class, Repositories\PendencyRepositoryEloquent::class);
        $this->app->bind(Repositories\LoadRepository::class, Repositories\LoadRepositoryEloquent::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../Config/config.php' => config_path('shipment.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'shipment'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/shipment');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/shipment';
        }, \Config::get('view.paths')), [$sourcePath]), 'shipment');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/shipment');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'shipment');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'shipment');
        }
    }

    /**
     * Register an additional directory of factories.
     * 
     * @return void
     */
    public function registerFactories()
    {
        if (! app()->environment('production')) {
            app(Factory::class)->load(__DIR__ . '/../Database/factories');
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
