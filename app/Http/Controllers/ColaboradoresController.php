<?php

namespace App\Http\Controllers;

use App\Models\Colaboradores;
use Illuminate\Http\Request;
use App\Http\Requests\StoreColaboradoresRequest;
use App\Http\Requests\UpdateColaboradoresRequest;
use Illuminate\Support\Facades\DB;

class ColaboradoresController extends Controller
{

    public function index()
    {
        $colaboradores = Colaboradores::with([
            'candidatos' => function ($query) {
                $query->select('id', 'nombre', 'apellido', 'dni', 'direccion', 'fecha_nacimiento', 'ciclo_de_estudiante', 'estado', 'institucion_id', 'carrera_id'); }
        ])
            ->where('estado', true)->get();

        return response()->json(["data" => $colaboradores, "conteo" => count($colaboradores)]);
    }


    public function create(Request $request)
    {
        Colaboradores::create([
            "candidato_id" => $request->candidato_id
        ]);

        return response()->json(["resp" => "Colaborador creado correctamente"]);
    }


    public function show($colaborador_id)
    {
        $colaborador = Colaboradores::with('candidatos')->find($colaborador_id);

        return response()->json(["data" => $colaborador]);
    }


    public function update(Request $request, $colaborador_id)
    {
        $colaborador = Colaboradores::find($colaborador_id);

        $colaborador->fill([
            "candidato_id" => $request->candidato_id
        ])->save();

        return response()->json(["resp" => "Colaborador actualizado correctamente"]);
    }


    public function destroy($colaborador_id)
    {
        $colaborador = Colaboradores::find($colaborador_id);

        $colaborador->delete();

        return response()->json(["resp" => "Colaborador eliminado correctamente"]);
    }

    public function ShowByName(Request $request)
    {
        $nombreCompleto = $request->nombre;

        $colaboradores = Colaboradores::with([
            'candidatos' => function ($query) {
                $query->select('id', 'nombre', 'apellido', 'dni', 'direccion', 'fecha_nacimiento', 'ciclo_de_estudiante', 'estado', 'institucion_id', 'carrera_id');
            }
        ])
            ->whereHas('candidatos', function ($query) use ($nombreCompleto) {
                $query->where(DB::raw("CONCAT(nombre, ' ', apellido)"), 'like', '%' . $nombreCompleto . '%');
            })
            ->where('estado', true)
            ->get();

        return response()->json(["data" => $colaboradores, "conteo" => $colaboradores->count()]);
    }
}
