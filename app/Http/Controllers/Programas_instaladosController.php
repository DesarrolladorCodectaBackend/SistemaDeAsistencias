<?php

namespace App\Http\Controllers;

use App\Models\Programas_instalados;
use Illuminate\Http\Request;

class Programas_instaladosController extends Controller
{
    
    public function index()
    {
        $programas_instalados = Programas_instalados::with([
            'computadora_colaborador' => function($query) {$query->select('id', 'colaborador_id', 'procesador', 'tarjeta_grafica',
            'ram', 'almacenamiento', 'es_laptop', 'codigo_serie');},
            'programas' => function($query){$query->select('id', 'nombre', 'descripcion', 'memoria_grafica', 'ram');}])
            ->get();

        return response()->json(["data" => $programas_instalados, "conteo" => count($programas_instalados)]);
    }

    
    public function create(Request $request)
    {
        Programas_instalados::create([
            "computadora_id" => $request->computadora_id,
            "programa_id" => $request->programa_id
        ]);

        return response()->json(["resp" => "Registro creado correctamente"]);
    }

    
    public function show($programas_instalados_id)
    {
        $programas_instalados = Programas_instalados::with([
            'computadora_colaborador' => function($query) {$query->select('id', 'colaborador_id', 'procesador', 'tarjeta_grafica',
            'ram', 'almacenamiento', 'es_laptop', 'codigo_serie');},
            'programas' => function($query){$query->select('id', 'nombre', 'descripcion', 'memoria_grafica', 'ram');}])
            ->find($programas_instalados_id);
        
        return response()->json(["data" => $programas_instalados]);
    }

    
    public function update(Request $request, $programas_instalados_id)
    {
        $programas_instalados = Programas_instalados::find($programas_instalados_id);

        $programas_instalados->fill([
            "computadora_id" => $request->computadora_id,
            "programa_id" => $request->programa_id
        ])->save();

        return response()->json(["resp" => "Registro actualizado correctamente"]);
    }

    
    public function destroy($programas_instalados_id)
    {
        $programas_instalados = Programas_instalados::find($programas_instalados_id);

        $programas_instalados->delete();

        return response()->json(["resp" => "Registro eliminado correctamente"]);
    }
}
