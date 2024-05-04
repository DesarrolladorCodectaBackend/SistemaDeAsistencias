<?php

namespace App\Http\Controllers;

use App\Models\Horario_Virtual_Colaborador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class HorarioVirtualColaboradorController extends Controller
{
    
    public function index()
    {
        $horario_virtual_colaborador = Horario_Virtual_Colaborador::all();

        return view('horario_virtual_colaborador.index', compact('horario_virtual_colaborador'));

    }

    
    public function store(Request $request)
    {
        $request->validate([
            'horario_virtual_id' => 'required|integer|min:1|max:100',
            'semana_id' => 'required|integer|min:1|max:255',
            'area_id' => 'required|integer|min:1|max:255',
        ]);
        
            
        Horario_Virtual_Colaborador::create([
            "horario_virtual_id" => $request->computadora_id,
            "semana_id" => $request->programa_id,
            "area_id" => $request->programa_id,
        ]);

        return redirect()->route('horario_virtual_colaborador.index');

    }

    
    public function show($horario_virtual_colaborador_id)
    {
        try {
            $horario_virtual_colaborador = Horario_Virtual_Colaborador::/*with([
                'horarios_virtuales' => function($query) {$query->select('id', 'hora_inicial', 'hora_final');},
                'colaboradores' => function($query) {$query->select('id', 'candidato_id');}])->*/find($horario_virtual_colaborador_id);
            
            if (!$horario_virtual_colaborador){
                return response()->json(["resp" => "No existe un registro con ese id"]);
            }

            return response()->json(["data" => $horario_virtual_colaborador]);
        } catch (Exception $e){
            return response()->json(["error" => $e]);
        }

    }

    
    public function update(Request $request, $horario_virtual_colaborador_id)
    {
        $request->validate([
            'horario_virtual_id' => 'required|integer|min:1|max:100',
            'semana_id' => 'required|integer|min:1|max:255',
            'area_id' => 'required|integer|min:1|max:255',
        ]);

        $horario_virtual_colaborador = Horario_Virtual_Colaborador::findOrFail($horario_virtual_colaborador_id);
        
        $horario_virtual_colaborador->update($request->all());

        return redirect()->route('horario_virtual_colaborador.index');
    }

    
    public function destroy($horario_virtual_colaborador_id)
    {
        $horario_virtual_colaborador = Horario_Virtual_Colaborador::findOrFail($horario_virtual_colaborador_id);

        $horario_virtual_colaborador->delete();

        return redirect()->route('horario_virtual_colaborador.index');

    }
}
