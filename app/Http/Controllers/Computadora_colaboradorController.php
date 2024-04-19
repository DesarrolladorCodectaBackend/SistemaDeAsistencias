<?php

namespace App\Http\Controllers;

use App\Models\Computadora_colaborador;
use Illuminate\Http\Request;

class Computadora_colaboradorController extends Controller
{

    public function index()
    {
        $computadora_colaborador = Computadora_colaborador::all();

        return view('computadora_colaborador.index', compact('computadora_colaborador'));
    }

    
    public function create(Request $request)
    {
        Computadora_colaborador::create([
            "colaborador_id" => $request->colaborador_id,
            "procesador" => $request->procesador,
            "tarjeta_grafica" => $request->tarjeta_grafica,
            "memoria_grafica" => $request->memoria_grafica,
            "ram" => $request->ram,
            "almacenamiento" => $request->almacenamiento,
            "es_laptop" => $request->es_laptop,
            "codigo_serie" => $request->codigo_serie
        ]);

        return response()->json(["resp" => "Registro creado correctamente"]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'colaborador_id' => 'required|integer|min:1|max:100',
            'procesador' => 'required|string|min:1|max:255',
            'tarjeta_grafica' =>  'required|string|min:1|max:255',
            'memoria_grafica' =>  'required|integer|min:1|max:255',
            'ram' =>  'required|integer|min:1|max:255',
            'almacenamiento' =>  'required|string|min:1|max:255',
            'es_laptop' =>  'required|boolean|min:1|max:255',
            'codigo_serie' =>  'required|string|min:1|max:255'
        ]);
        
              
        
        Computadora_colaborador::create([
            "colaborador_id" => $request->colaborador_id,
            "procesador" => $request->procesador,
            "tarjeta_grafica" => $request->tarjeta_grafica,
            "memoria_grafica" => $request->memoria_grafica,
            "ram" => $request->ram,
            "almacenamiento" => $request->almacenamiento,
            "es_laptop" => $request->es_laptop,
            "codigo_serie" => $request->codigo_serie
        ]);

        return redirect()->route('computadora_colaborador.index');
    }


    
    public function show($computadora_colaborador_id)
    {
        $computadora_colaborador = Computadora_colaborador::with([
            'colaboradores' => function($query) {$query->select('id', 'candidato_id');}])->find($computadora_colaborador_id);
        
        return response()->json(["data" => $computadora_colaborador]);
    }

    
    public function update(Request $request, $computadora_colaborador_id)
    {
        $request->validate([
            'colaborador_id' => 'required|integer|min:1|max:100',
            'procesador' => 'required|string|min:1|max:255',
            'tarjeta_grafica' =>  'required|string|min:1|max:255',
            'memoria_grafica' =>  'required|integer|min:1|max:255',
            'ram' =>  'required|integer|min:1|max:255',
            'almacenamiento' =>  'required|string|min:1|max:255',
            'es_laptop' =>  'required|boolean|min:1|max:255',
            'codigo_serie' =>  'required|string|min:1|max:255'
        ]);

        $computadora_colaborador = Computadora_colaborador::findOrFail($computadora_colaborador_id);
        
        $computadora_colaborador->update($request->all());

        return redirect()->route('computadora_colaborador.index');
    }

    
    public function destroy($computadora_colaborador_id)
    {
        $computadora_colaborador = Computadora_colaborador::findOrFail($computadora_colaborador_id);

        $computadora_colaborador->delete();

        return redirect()->route('computadora_colaborador.index');
    }
}
