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
        dd('boot');
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
}