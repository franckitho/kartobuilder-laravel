<?php

namespace Noxyz20\Kartobuilder\Models;

use Illuminate\Database\Eloquent\Model;

class MapElement extends Model
{
    protected $table = 'Map_elements';

    protected $fillable = [
        'name',
        'GeoJSON'
    ];
}