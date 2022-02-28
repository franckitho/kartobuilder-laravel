<?php

namespace Noxyz20\Kartobuilder\Controllers;

use Illuminate\Routing\Controller;
use Noxyz20\Kartobuilder\Models\Map;
use Noxyz20\Kartobuilder\Models\MapElement;


class MapApiController extends Controller
{
    public function __invoke($id)
    {
        $map = Map::findOrFail($id);
        $mapElement = MapElement::where('map_id', $id)->get();
        $features = array();
        foreach ($mapElement as $element) {
            $element->GeoJSON = json_decode($element->GeoJSON, true);
            foreach($element->GeoJSON['features'] as $feature) {
                array_push($features, $feature);
            }
        }
        $geoJsonResponse = array(
            'type' => 'FeatureCollection',
            'features' => $features,
        );
        
        return response()->json([
            'map' => $map->name,
            'GeoJSON' => $geoJsonResponse,
        ]);
    }
}