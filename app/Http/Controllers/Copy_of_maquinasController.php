<?php

namespace App\Http\Controllers;

use App\Models\Copy_of_Maquinas;
use Illuminate\Http\Request;

class Copy_of_maquinasController extends Controller
{
    public function index()
    {
        $copy_of_maquinas = Copy_of_Maquinas::with([
            'horarios_presenciales' => function($query) {$query->select('id', 'horario_inicial', 'horario_final', 'dia');},
            'maquinas' => function($query) {$query->select('id', 'nombre');}])->get();
        
        return response()->json(["data" => $copy_of_maquinas, "conteo" => count($copy_of_maquinas)]);
    }

    public function create(Request $request)
    {
        Copy_of_Maquinas::create([
            "horario_presencial_id" => $request->horario_presencial_id,
            "maquina_id" => $request->maquina_id
        ]);

        return response()->json(["resp" => "Registro creado correctamente"]);
    }

    public function show($copy_of_maquinas_id)
    {
        $copy_of_maquinas = Copy_of_Maquinas::with([
            'horarios_presenciales' => function($query) {$query->select('id', 'horario_inicial', 'horario_final', 'dia');},
            'maquinas' => function($query) {$query->select('id', 'nombre');}])->find($copy_of_maquinas_id);

        return response()->json(["data" => $copy_of_maquinas]);
    }

    public function update(Request $request, $copy_of_maquinas_id)
    {
        $copy_of_maquinas = Copy_of_Maquinas::find($copy_of_maquinas_id);

        $copy_of_maquinas->fill([
            "horario_presencial_id" => $request->horario_presencial_id,
            "maquina_id" => $request->maquina_id
        ])->save();

        return response()->json(["resp" => "Registro actualizado correctamente"]);
    }

    public function destroy($copy_of_maquinas_id)
    {
        $copy_of_maquinas = Copy_of_Maquinas::find($copy_of_maquinas_id);

        $copy_of_maquinas->delete();

        return response()->json(["resp" => "Registro eliminado correctamente"]);
    }
    
}
