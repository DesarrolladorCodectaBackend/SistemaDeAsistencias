<?php

namespace App\Http\Controllers;

use App\Models\Horario_Virtual_Colaborador;
use Illuminate\Http\Request;
use App\Http\Requests\StoreHorario_Virtual_ColaboradorRequest;
use App\Http\Requests\UpdateHorario_Virtual_ColaboradorRequest;

class HorarioVirtualColaboradorController extends Controller
{
    
    public function index()
    {
        $horarios_virtuales_colaborador = Horario_Virtual_Colaborador::with([
            'horarios_virtuales' => function($query) {$query->select('id', 'hora_inicial', 'hora_final');},
            'colaboradores' => function($query) {$query->select('id', 'candidato_id');}])->get();

        return response()->json(["data" => $horarios_virtuales_colaborador, "conteo" => count($horarios_virtuales_colaborador)]);
    }

    
    public function create(Request $request)
    {
        Horario_Virtual_Colaborador::create([
            "horario_virtual_id" => $request->horario_virtual_id,
            "colaborador_id" => $request->colaborador_id
        ]);

        return response()->json(["resp" => "Registro creado correctamente"]);
    }

    
    public function show($horario_virtual_colaborador_id)
    {
        $horario_virtual_colaborador = Horario_Virtual_Colaborador::with([
            'horarios_virtuales' => function($query) {$query->select('id', 'hora_inicial', 'hora_final');},
            'colaboradores' => function($query) {$query->select('id', 'candidato_id');}])->find($horario_virtual_colaborador_id);
        
        return response()->json(["data" => $horario_virtual_colaborador]);
    }

    
    public function update(Request $request, $horario_virtual_colaborador_id)
    {
        $horario_virtual_colaborador = Horario_Virtual_Colaborador::find($horario_virtual_colaborador_id);

        $horario_virtual_colaborador->fill([
            "horario_virtual_id" => $request->horario_virtual_id,
            "colaborador_id" => $request->colaborador_id
        ])->save();

        return response()->json(["resp" => "Registro actualizado correctamente"]);
    }

    
    public function destroy($horario_virtual_colaborador_id)
    {
        $horario_virtual_colaborador = Horario_Virtual_Colaborador::find($horario_virtual_colaborador_id);

        $horario_virtual_colaborador->delete();

        return response()->json(["resp" => "Registro eliminado correctamente"]);
    }
}
