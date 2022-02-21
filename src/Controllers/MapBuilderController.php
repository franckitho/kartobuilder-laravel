<?php

namespace Noxyz20\Kartobuilder\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Noxyz20\Kartobuilder\Models\Map;
use Noxyz20\Kartobuilder\Models\MapElement;
use Inertia\Inertia;

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
        dd($map);
    }

    public function create()
    {
        return 'create';
    }

    public function store(Request $request)
    {
        dd($request->all());
    }

    public function edit($id)
    {
        return 'edit';
    }

    public function update(Request $request, $id)
    {
        dd($request->all());
    }

    public function destroy($id)
    {
        return 'destroy';
    }
    
}