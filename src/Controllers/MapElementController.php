<?php

namespace Noxyz20\Kartobuilder\Controllers;

use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\URL;
use Noxyz20\Kartobuilder\Models\Map;
use Illuminate\Support\Facades\Redirect;
use Noxyz20\Kartobuilder\Models\MapElement;

class MapElementController extends Controller 
{
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
            'currentRoute' => route('map.store'),
        ]);
    }

    public function store(Request $request)
    {
        if($request->markers)
        {
            $data[0] = $request->markers;
            $type = 'marker';
        }
        else if($request->polygon)
        {
            $data[0] = $request->polygon;
            $type = 'polygon';
        }
        else
        {
            $data[0] = $request->polyline;
            $type = 'polyline';
        }

        $data[1] = $request->properties;

        MapElement::Create([
            'name' => $request->name,
            'map_id' => $request->map_id,
            'GeoJSON' => $this->geoJson($data, $type),
        ]);

        return back();
    }

    public function destroy($id)
    {
        $m = MapElement::where('id', $id)->first();
        $m->delete();
        return back();
    }
    
    function geoJson($array, $type) 
    {
  
        $original_data = $this->formatData($array[0], $type);

        $features = array();
        if($type == 'marker') {
            foreach($original_data as $key => $value) { 
                $features[] = array(
                        'type' => 'Feature',
                        'properties' => $array[1],
                        'geometry' => array('type' => 'Point', 'coordinates' => array((float)$value['lng'],(float)$value['lat'])),
                        );
                };   
        }else if ($type == 'polygon') {
            $features[] = array(
                'type' => 'Feature',
                'properties' => $array[1],
                'geometry' => array('type' => 'Polygon', 'coordinates' => array($original_data)),
                );
        }else{
            $features[] = array(
                'type' => 'Feature',
                'properties' => $array[1],
                'geometry' => array('type' => 'LineString', 'coordinates' => $original_data),
                );
        }

        $allfeatures = array('type' => 'FeatureCollection', 'features' => $features);
        return json_encode($allfeatures);

    }

    function formatData($array, $type)
    {
        $cleanArray = array();
        if($type == 'marker') {
            foreach($array as $a) {
                $c['id'] = $a['id'];
                $c['lat'] = $a['latlng']['lat'];
                $c['lng'] = $a['latlng']['lng'];
                array_push($cleanArray, $c);
            }
        }else{
            foreach($array as $a) {
                $c[0] = $a[1];
                $c[1] = $a[0];
                array_push($cleanArray, $c);
            }
        }
        return $cleanArray;
    }
}