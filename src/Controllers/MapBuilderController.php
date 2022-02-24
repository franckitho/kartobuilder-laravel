<?php

namespace Noxyz20\Kartobuilder\Controllers;

use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Noxyz20\Kartobuilder\Models\Map;
use Illuminate\Support\Facades\Redirect;
use Noxyz20\Kartobuilder\Models\MapElement;

class MapBuilderController extends Controller 
{
    public function index()
    {
        $maps = Map::all();
        return Inertia::render('Map', [
            'maps' => $maps,
        ]);
    }

    public function show($id)
    {
        $map = Map::find($id);
        $mapElement = MapElement::where('map_id', $id)->get();
        foreach ($mapElement as $element) {
            $element->GeoJSON = json_decode($element->GeoJSON, true);
        }
        return Inertia::render('MapElement', [
            'map' => $map,
            'mapElement' => $mapElement,
        ]);
    }

    public function store(Request $request)
    {
        MapElement::Create([
            'name' => $request->name,
            'map_id' => $request->map_id,
            'GeoJSON' => $this->geoJson($request->markers),
        ]);

        return back();
    }

    public function destroy($id)
    {
        $m = MapElement::where('id', $id)->first();
        $m->delete();
        return back();
    }
    
    function geoJson($array) 
    {
        $original_data = $this->formatData($array);
        $features = array();

        foreach($original_data as $key => $value) { 
            $features[] = array(
                    'type' => 'Feature',
                    'properties' => array(),
                    'geometry' => array('type' => 'Point', 'coordinates' => array((float)$value['lng'],(float)$value['lat'])),
                    );
            };   

        $allfeatures = array('type' => 'FeatureCollection', 'features' => $features);
        return json_encode($allfeatures);

    }

    function formatData($array)
    {
        $cleanArray = array();

        foreach($array as $a) {
            $c['id'] = $a['id'];
            $c['lat'] = $a['latlng']['lat'];
            $c['lng'] = $a['latlng']['lng'];
            array_push($cleanArray, $c);
        }
        return $cleanArray;
    }
}