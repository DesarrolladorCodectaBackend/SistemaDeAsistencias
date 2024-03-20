<?php

namespace App\Http\Controllers;

use App\Models\Horario_de_Clases;
use Illuminate\Http\Request;
use App\Http\Requests\StoreHorario_de_ClasesRequest;
use App\Http\Requests\UpdateHorario_de_ClasesRequest;

class HorarioDeClasesController extends Controller
{
    
    public function index()
    {
        $horario_de_clases = Horario_de_Clases::with('colaboradores')->get();

        return response()->json(["data" => $horario_de_clases, "conteo" => count($horario_de_clases)]);
    }

    
    public function create(Request $request)
    {
        Horario_de_Clases::create([
            "colaborador_id" => $request->colaborador_id,
            "hora_inicial" => $request->hora_inicial,
            "hora_final" => $request->hora_final,
            "dia" => $request->dia
        ]);

        return response()->json(["resp" => "Registro creado correctamente"]);
    }

    
    public function show($horario_de_clases_id)
    {
        $horario_de_clases = Horario_de_Clases::with('colaboradores')->find($horario_de_clases_id);

        return response()->json(["data" => $horario_de_clases]);
    }

    
    public function update(Request $request, $horario_de_clases_id)
    {
        $horario_de_clases = Horario_de_Clases::find($horario_de_clases_id);

        $horario_de_clases->fill([
            "colaborador_id" => $request->colaborador_id,
            "hora_inicial" => $request->hora_inicial,
            "hora_final" => $request->hora_final,
            "dia" => $request->dia
        ])->save();

        return response()->json(["resp" => "Registro actualizado correctamente"]);
    }

    
    public function destroy($horario_de_clases_id)
    {
        $horario_de_clases = Horario_de_Clases::find($horario_de_clases_id);

        $horario_de_clases->delete();

        return response()->json(["resp" => "Registro eliminado correctamente"]);
    }
}
