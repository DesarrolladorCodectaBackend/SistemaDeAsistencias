<?php

namespace App\Http\Controllers;

use App\Models\Disponibilidad_Presencial;
use Illuminate\Http\Request;
use App\Http\Requests\StoreDisponibilidad_PresencialRequest;
use App\Http\Requests\UpdateDisponibilidad_PresencialRequest;

class DisponibilidadPresencialController extends Controller
{
    
    public function index()
    {
        $disponibilidad_presencial = Disponibilidad_Presencial::with([
            'colaboradores' => function($query) {$query->select('id', 'candidato_id');},
            'horarios_presenciales' => function($query) {$query->select('id', 'horario_inicial', 'horario_final', 'dia');}])->get();
            
        return response()->json(["data" => $disponibilidad_presencial, "conteo" => count($disponibilidad_presencial)]);
    }


    public function create(Request $request)
    {
        Disponibilidad_Presencial::create([
            "colaborador_id" => $request->colaborador_id,
            "horarios_presenciales_id" => $request->horarios_presenciales_id
        ]);

        return response()->json(["resp" => "Registro creado correctamente"]);
    }

    
    public function show($disponibilidad_presencial_id)
    {
        $disponibilidad_presencial = Disponibilidad_Presencial::with([
            'colaboradores' => function($query) {$query->select('id', 'candidato_id');},
            'horarios_presenciales' => function($query) {$query->select('id', 'horario_inicial', 'horario_final', 'dia');}])->find($disponibilidad_presencial_id);

        return response()->json(["data" => $disponibilidad_presencial]);
    }

    
    public function update(Request $request, $disponibilidad_presencial_id)
    {
        $disponibilidad_presencial = Disponibilidad_Presencial::find($disponibilidad_presencial_id);

        $disponibilidad_presencial->fill([
            "colaborador_id" => $request->colaborador_id,
            "horarios_presenciales_id" => $request->horarios_presenciales_id
        ])->save();

        return response()->json(["resp" => "Registro actualizado correctamente"]);
    }

    
    public function destroy($disponibilidad_presencial_id)
    {
        $disponibilidad_presencial = Disponibilidad_Presencial::find($disponibilidad_presencial_id);

        $disponibilidad_presencial->delete();

        return response()->json(["resp" => "Registro eliminado correctamente"]);
    }
}
