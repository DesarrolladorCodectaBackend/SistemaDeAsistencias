<?php

namespace App\Http\Controllers;

use App\Models\Computadora_colaborador;
use Illuminate\Http\Request;

class Computadora_colaboradorController extends Controller
{

    public function index()
    {
        $computadora_colaborador = Computadora_colaborador::with([
            'colaboradores' => function($query) {$query->select('id', 'candidato_id');}])->get();

        return response()->json(["data" => $computadora_colaborador, "conteo" => count($computadora_colaborador)]);
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

    
    public function show($computadora_colaborador_id)
    {
        $computadora_colaborador = Computadora_colaborador::with([
            'colaboradores' => function($query) {$query->select('id', 'candidato_id');}])->find($computadora_colaborador_id);
        
        return response()->json(["data" => $computadora_colaborador]);
    }

    
    public function update(Request $request, $computadora_colaborador_id)
    {
        $computadora_colaborador = Computadora_colaborador::find($computadora_colaborador_id);

        $computadora_colaborador->fill([
            "colaborador_id" => $request->colaborador_id,
            "procesador" => $request->procesador,
            "tarjeta_grafica" => $request->tarjeta_grafica,
            "memoria_grafica" => $request->memoria_grafica,
            "ram" => $request->ram,
            "almacenamiento" => $request->almacenamiento,
            "es_laptop" => $request->es_laptop,
            "codigo_serie" => $request->codigo_serie
        ])->save();

        return response()->json(["resp" => "Registro actualizado correctamente"]);
    }

    
    public function destroy($computadora_colaborador_id)
    {
        $computadora_colaborador = Computadora_colaborador::find($computadora_colaborador_id);

        $computadora_colaborador->delete();

        return response()->json(["resp" => "Registro eliminado correctamente"]);
    }
}
