<?php

namespace App\Http\Controllers;

use App\Models\Horarios_Virtuales;
use Illuminate\Http\Request;
use App\Http\Requests\StoreHorarios_VirtualesRequest;
use App\Http\Requests\UpdateHorarios_VirtualesRequest;

class HorariosVirtualesController extends Controller
{
    
    public function index()
    {
        $horarios_virtuales = Horarios_Virtuales::get();

        return response()->json(["data" => $horarios_virtuales, "conteo" => count($horarios_virtuales)]);
    }

    
    public function create(Request $request)
    {
        Horarios_Virtuales::create([
            "hora_inicial" => $request->hora_inicial,
            "hora_final" => $request->hora_final
        ]);

        return response()->json(["resp" => "Horario virtual creado"]);
    }

    
    public function show($horario_virtual_id)
    {
        $horario = Horarios_Virtuales::find($horario_virtual_id);

        return response()->json(["data"=>$horario]);
    }

    
    public function update(Request $request, $horario_virtual_id)
    {
        $horario = Horarios_Virtuales::find($horario_virtual_id);

        $horario->fill([
            "hora_inicial" => $request->hora_inicial,
            "hora_final" => $request->hora_final
        ]);

        return response()->json(["resp" => "Horario virtual con id ".$horario_virtual_id." editado"]);
    }

    
    public function destroy($horario_virtual_id)
    {
        $horario = Horarios_Virtuales::find($horario_virtual_id);

        $horario->delete();

        return response()->json(["resp" => "Horario virtual con id ".$horario_virtual_id." eliminado"]);
    }
}
