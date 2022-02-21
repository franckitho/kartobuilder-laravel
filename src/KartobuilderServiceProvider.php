<?php

namespace Noxyz20\Kartobuilder;

use Illuminate\Support\ServiceProvider;


class KartobuilderServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        
        $this->app['router']->namespace('Noxyz20\Kartobuilder\Controllers')
            ->middleware(['web'])
            ->group(function () {
                $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
            });
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }

        $this->publishes([
            __DIR__.'/../resourses/js/Pages/Map.vue' => resource_path('js/Pages/mapIndex.vue'),
            __DIR__.'/../resourses/js/Pages/Map_element.vue' => resource_path('js/Pages/Map_element.vue'),
        ], 'map-views');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public function bootForConsole()
    {
        $this->publishes([
            __DIR__ . '/../database/migrations/' => database_path('migrations'),
        ], 'migrations');
    }
}