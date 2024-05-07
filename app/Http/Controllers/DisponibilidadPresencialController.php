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
        $disponibilidad_presencial = Disponibilidad_Presencial::all();

        return view('inspiniaViews.disponibilidad_presencial.index', compact('disponibilidad_presencial'));
    }


    public function store(Request $request)
    {

        $request->validate([
            'colaborador_id' => 'required|string|min:1|max:100',
            'horarios_presenciales_id' => 'required|string|min:1|max:255'
        ]);

        Disponibilidad_Presencial::create([
            "colaborador_id" => $request->colaborador_id,
            "horarios_presenciales_id" => $request->horarios_presenciales_id
        ]);

        return redirect()->route('inspiniaViews.disponibilidad_presencial.index');
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
        $request->validate([
            'colaborador_id' => 'required|string|min:1|max:100',
            'horarios_presenciales_id' => 'required|string|min:1|max:255'
        ]);

        $disponibilidad_presencial = Disponibilidad_Presencial::findOrFail($disponibilidad_presencial_id);

        $disponibilidad_presencial->update($request->all());

        return redirect()->route('inspiniaViews.disponibilidad_presencial.index');
    }

    
    public function destroy($disponibilidad_presencial_id)
    {
        $disponibilidad_presencial = Disponibilidad_Presencial::findOrFail($disponibilidad_presencial_id);

        $disponibilidad_presencial->delete();

        return redirect()->route('inspiniaViews.disponibilidad_presencial.index');
    }
}
