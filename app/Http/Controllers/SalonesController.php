<?php

namespace App\Http\Controllers;

use App\Models\Salones;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSalonesRequest;
use App\Http\Requests\UpdateSalonesRequest;

class SalonesController extends Controller
{
    
    public function index()
    {
        $Salones = Salones::get();

        return response()->json(["data" => $Salones, "conteo" => count($Salones)]);
    }
    
    
    public function create(Request $request)
    {
        Salones::create([
            "nombre" => $request->nombre,
            "descripcion" => $request->descripcion
        ]);

        return response()->json(["resp" => "Salón creado"]);
    }

    
    public function show($salon_id)
    {
        $salon = Salones::find($salon_id);

        return response()->json(["data" => $salon]);
    }

    
    public function update(Request $request, $salon_id)
    {
        $salon = Salones::find($salon_id);

        $salon->fill([
            "nombre" => $request->nombre,
            "descripcion" => $request->descripcion
        ])->save();

        return response()->json(["resp" => "Salón con id ".$salon_id." actualizado"]);
    }

    
    public function destroy($salon_id)
    {
        $salon = Salones::find($salon_id);

        $salon->delete();

        return response()->json(["resp" => "Salón con id ".$salon_id." eliminado"]);
    }
}
