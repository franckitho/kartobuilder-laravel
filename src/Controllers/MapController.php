<?php

namespace Noxyz20\Kartobuilder\Controllers;

use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\URL;
use Noxyz20\Kartobuilder\Models\Map;
use Symfony\Component\Routing\Route;
use Illuminate\Support\Facades\Redirect;

class MapController extends Controller
{
    public function index()
    {
        $maps = Map::all();;
        return Inertia::render('Map', [
            'maps' => $maps,
            'currentRoute' => URL::current(),
        ]);
    }

    public function store(Request $request)
    {
        Map::Create([
            'name' => $request->name,
        ]);

        return back();
    }

    public function destroy($id)
    {
        $m = Map::where('id', $id)->first();
        $m->delete();
        return back();
    }
}