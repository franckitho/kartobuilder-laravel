<?php

namespace Noxyz20\Kartobuilder\Models;

use Illuminate\Database\Eloquent\Model;

class MapElement extends Model
{
    protected $table = 'map_elements';

    protected $fillable = [
        'name',
        'map_id',
        'GeoJSON'
    ];

}