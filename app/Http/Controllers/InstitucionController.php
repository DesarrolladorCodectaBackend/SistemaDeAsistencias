<?php

namespace App\Http\Controllers;

use App\Models\Institucion;
use Illuminate\Http\Request;
use App\Http\Requests\StoreInstitucionRequest;
use App\Http\Requests\UpdateInstitucionRequest;

class InstitucionController extends Controller
{
    
    public function index()
    {
        $instituciones = Institucion::get();
        return response()->json(["data"=>$instituciones, "conteo"=> count($instituciones)]);
    }

    
    public function create(Request $request)
    {
        Institucion::create([
            "nombre" => $request->nombre,
        ]);

        return response()->json(["resp" => "Institución creada con nombre ".$request->nombre]);
    }

    
    public function show($institucion_id)
    {
        $institucion = Institucion::find($institucion_id);

        return response()->json(["data"=>$institucion]);
    }

    
    public function update(Request $request, $institucion_id)
    {
        $institucion = Institucion::find($institucion_id);

        $institucion->fill([
            "nombre" => $request->nombre
        ])->save();
        
        return response()->json(["resp" => "Institución con id ".$institucion_id." fue editada"]);

    }

    
    public function destroy($institucion_id)
    {
        $institucion = Institucion::find($institucion_id);

        $institucion->delete();

        return response()->json(["resp" => "Institución con id ".$institucion_id." y nombre ".$institucion->nombre." eliminada"]);
    }
}
