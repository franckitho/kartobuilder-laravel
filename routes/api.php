<?php

use Noxyz20\Kartobuilder\Controllers\MapApiController;
use Noxyz20\Kartobuilder\Controllers\MapConfigController;


Route::get('/map/{id}', MapApiController::class);