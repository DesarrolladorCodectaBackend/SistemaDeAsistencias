<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;
use App\Http\Requests\StoreareaRequest;
use App\Http\Requests\UpdateareaRequest;

class AreaController extends Controller
{
    public function index()
    {
        $Areas = Area::get();

        return response()->json(["data" => $Areas, "conteo" => count($Areas)]);
    }

    
    public function create(Request $request)
    {
        Area::create([
            "especializacion" => $request->especializacion,
            "color_hex" => $request->color_hex
        ]);

        return response()->json(["resp" => "Área creada"]);
    }

    
    public function show($area_id)
    {
        $area = Area::find($area_id);

        return response()->json(["data" => $area]);
    }

    
    public function update(Request $request, $area_id)
    {
        $area = Area::find($area_id);

        $area->fill([
            "especializacion" => $request->especializacion,
            "color_hex" => $request->color_hex
        ])->save();

        return response()->json(["resp" => "Área con id ".$area_id." actualizada"]);
    }

    
    public function destroy($area_id)
    {
        $area = Area::find($area_id);

        $area->delete();

        return response()->json(["resp" => "Área con id ".$area_id." eliminada"]);
    }
}
