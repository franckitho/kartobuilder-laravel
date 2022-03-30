<?php

namespace Noxyz20\Kartobuilder\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Noxyz20\Kartobuilder\Models\Map;
use Noxyz20\Kartobuilder\Models\MapElement;


class MapConfigController extends Controller
{
    public function __invoke($id, Request $request)
    {
        $map = Map::findOrFail($id);
        $map->center = json_encode($request->center);
        $map->zoom = $request->zoom;
        $map->save();
        return back();
    }
}