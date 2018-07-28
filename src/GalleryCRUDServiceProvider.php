<?php

namespace SeanDowney\BackpackGalleryCrud;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;

class GalleryCRUDServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Where the route file lives, both inside the package and in the app (if overwritten).
     *
     * @var string
     */
    public $routeFilePath = '/routes/seandowney/backpackgallerycrud.php';

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // publish migrations
        $this->publishes([__DIR__.'/database/migrations' => database_path('migrations')], 'migrations');

        // LOAD THE VIEWS
        // - first the published views (in case they have any changes)
        $this->loadViewsFrom(resource_path('views/vendor/seandowney/gallerycrud'), 'seandowney');
        // - then the stock views that come with the package, in case a published view might be missing
        $this->loadViewsFrom(realpath(__DIR__.'/resources/views'), 'seandowney');

        $this->mergeConfigFrom(
            __DIR__.'/config/seandowney/gallerycrud.php', 'seandowney.gallerycrud'
        );

        // // publish views
        $this->publishes([
            __DIR__.'/resources/views/gallerycrud' => resource_path('views/vendor/seandowney/gallerycrud'),
            __DIR__.'/resources/views/backpackcrud' => resource_path('views/vendor/backpack/crud'),
        ], 'views');

        // publish config file
        $this->publishes([__DIR__.'/config' => config_path()], 'config');

    }


    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        // register its dependencies
        $this->app->register(\Cviebrock\EloquentSluggable\ServiceProvider::class);

        $this->setupRoutes($this->app->router);
    }


    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function setupRoutes(Router $router)
    {
        // by default, use the routes file provided in vendor
        $routeFilePathInUse = __DIR__.$this->routeFilePath;

        // but if there's a file with the same name in routes/backpack, use that one
        if (file_exists(base_path().$this->routeFilePath)) {
            $routeFilePathInUse = base_path().$this->routeFilePath;
        }

        $this->loadRoutesFrom($routeFilePathInUse);
    }
}
