<?php

namespace Noxyz20\Kartobuilder\Models;

use Illuminate\Database\Eloquent\Model;
use Noxyz20\Kartobuilder\Models\MapElement;


class Map extends Model
{
    protected $table = 'maps';

    protected $fillable = [
        'name'
    ];

    public function elements()
    {
        return $this->hasMany(MapElement::class);
    }
}