<?php

use Noxyz20\Kartobuilder\Controllers\MapConfigController;
use Noxyz20\Kartobuilder\Controllers\MapElementController;

Route::resource('map', 'MapElementController')->except(['create', 'edit', 'index']);
Route::resource('maps', 'MapController')->except(['create', 'edit', 'show']);
Route::put('map/config/{id}', MapConfigController::class)->name('config.map');