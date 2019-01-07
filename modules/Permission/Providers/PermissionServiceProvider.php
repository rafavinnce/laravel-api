<?php

namespace Modules\Permission\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Modules\Permission\Console\MigrateCommand;
use Modules\Permission\Console\RefreshCommand;
use Modules\Permission\Console\SyncCommand;
use Modules\Permission\Repositories;

class PermissionServiceProvider extends ServiceProvider
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
        $this->registerFactories();
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Repositories\PermissionRepository::class, Repositories\PermissionRepositoryEloquent::class);
        $this->app->bind(Repositories\RoleRepository::class, Repositories\RoleRepositoryEloquent::class);

        $this->commands([
            MigrateCommand::class,
            RefreshCommand::class,
            SyncCommand::class,
        ]);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../Config/config.php' => config_path('permission.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'permission'
        );
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/permission');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'permission');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'permission');
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
