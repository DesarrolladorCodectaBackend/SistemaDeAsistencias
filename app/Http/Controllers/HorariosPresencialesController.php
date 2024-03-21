<?php

namespace App\Http\Controllers;

use App\Models\Horarios_Presenciales;
use Illuminate\Http\Request;
use App\Http\Requests\StoreHorarios_PresencialesRequest;
use App\Http\Requests\UpdateHorarios_PresencialesRequest;

class HorariosPresencialesController extends Controller
{
    
    public function index()
    {
        $horarios_presenciales = Horarios_Presenciales::get();

        return response()->json(["data"=>$horarios_presenciales, "conteo"=>count($horarios_presenciales)]);
    }

    
    public function create(Request $request)
    {
        Horarios_Presenciales::create([
            "horario_inicial" => $request->horario_inicial,
            "horario_final" => $request->horario_final,
            "dia" => $request->dia
        ]);

        return response()->json(["resp" => "Horario presencial creado"]);
    }

    
    public function show($horario_presencial_id)
    {
        $horario = Horarios_Presenciales::find($horario_presencial_id);

        return response()->json(["data" => $horario]);
    }

    
    public function update(Request $request, $horario_presencial_id)
    {
        $horario = Horarios_Presenciales::find($horario_presencial_id);

        $horario->fill([
            "horario_inicial" => $request->horario_inicial,
            "horario_final" => $request->horario_final,
            "dia" => $request->dia
        ])->save();

        return response()->json(["resp" => "Horario presencial con id ".$horario_presencial_id." editado"]);
    }

    
    public function destroy($horario_presencial_id)
    {
        $horario = Horarios_Presenciales::find($horario_presencial_id);

        $horario->delete();

        return response()->json(["resp"=>"Horario presencial con id ".$horario_presencial_id." eliminado"]);
    }
}
