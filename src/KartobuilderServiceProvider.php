<?php

namespace Noxyz20\Kartobuilder;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Noxyz20\Kartobuilder\Console\InstallCommand;

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

        if(env('KARTOBUILDER_ROUTE_ENABLE') == false){
            $this->app['router']->namespace('Noxyz20\Kartobuilder\Controllers')
                ->middleware(['web'])
                ->group(function () {
                    $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
                });
        }
        \Route::middleware('api')->prefix('api')->group(function () {
            $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        });

        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
            $this->commands([
                InstallCommand::class,
            ]);
        }

        $this->publishes([
            __DIR__.'/../resources/js/Map.vue' => resource_path('js/Pages/Map.vue'),
            __DIR__.'/../resources/js/MapElement.vue' => resource_path('js/Pages/MapElement.vue'),
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