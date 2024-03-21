<?php

namespace App\Http\Controllers;

use App\Models\Maquinas;
use Illuminate\Http\Request;
use App\Http\Requests\StoreMaquinasRequest;
use App\Http\Requests\UpdateMaquinasRequest;

class MaquinasController extends Controller
{
    
    public function index()
    {
        $maquinas = Maquinas::with(['salones' => function ($query) {$query->select('id', 'nombre');}])->where('estado', 1)->get();
        return response()->json(["data" => $maquinas, "conteo" => count($maquinas)]);
    }

    
    public function create(Request $request)    
    {
        Maquinas::create([
            "nombre" => $request->nombre,
            "detalles_tecnicos" => $request->detalles_tecnicos,
            "num_identificador" => $request->num_identificador,
            "salon_id" => $request->salon_id
        ]);

        return response()->json(["resp" => "Maquina creada correctamente"]);
    }

    
    public function show($maquina_id)
    {
        $maquina = Maquinas::with(['salones' => function($query) {$query->select('id', 'nombre');}])->find($maquina_id);

        return response()->json(["data" => $maquina]);
    }


    public function update(Request $request, $maquina_id)
    {
        $maquina = Maquinas::find($maquina_id);

        $maquina->fill([
            "nombre" => $request->nombre,
            "detalles_tecnicos" => $request->detalles_tecnicos,
            "num_identificador" => $request->num_identificador,
            "salon_id" => $request->salon_id
        ])->save();

        return response()->json(["resp" => "Maquina actualizada correctamente"]);
    }

    public function destroy($maquina_id)
    {
        $maquina = Maquinas::find($maquina_id);

        $maquina->delete();

        return response()->json(["resp" => "Maquina eliminada correctamente"]);
    }

}
