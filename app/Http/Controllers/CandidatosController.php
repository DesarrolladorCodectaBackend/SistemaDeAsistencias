<?php

namespace App\Http\Controllers;

use App\Models\Candidatos;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCandidatosRequest;
use App\Http\Requests\UpdateCandidatosRequest;
use Illuminate\Support\Facades\DB;

class CandidatosController extends Controller
{

    public function index()
    {
        $candidatos = Candidatos::with([
            'institucion' => function ($query) {
                $query->select('id', 'nombre'); },
            'carrera' => function ($query) {
                $query->select('id', 'nombre'); }
        ])->where('estado', 1)->get();
        return response()->json(["data" => $candidatos, "conteo" => count($candidatos)]);
    }


    public function create(Request $request)
    {
        Candidatos::create([
            "nombre" => $request->nombre,
            "apellido" => $request->apellido,
            "dni" => $request->dni,
            "direccion" => $request->direccion,
            "fecha_nacimiento" => $request->fecha_nacimiento,
            "ciclo_de_estudiante" => $request->ciclo_de_estudiante,
            "institucion_id" => $request->institucion_id,
            "carrera_id" => $request->carrera_id
        ]);

        return response()->json(["resp" => "Candidato creado exitosamente"]);
    }


    public function show($candidato_id)
    {
        $candidato = Candidatos::with([
            'institucion' => function ($query) {
                $query->select('id', 'nombre'); },
            'carrera' => function ($query) {
                $query->select('id', 'nombre'); }
        ])->find($candidato_id);
        return response()->json(["Data" => $candidato]);
    }


    public function update(Request $request, $candidato_id)
    {
        $candidato = Candidatos::find($candidato_id);

        $candidato->fill([
            "nombre" => $request->nombre,
            "apellido" => $request->apellido,
            "dni" => $request->dni,
            "direccion" => $request->direccion,
            "fecha_nacimiento" => $request->fecha_nacimiento,
            "ciclo_de_estudiante" => $request->ciclo_de_estudiante,
            "institucion_id" => $request->institucion_id,
            "carrera_id" => $request->carrera_id
        ])->save();

        return response()->json(["resp" => "Candidato actualizado correctamente"]);
    }


    public function destroy($candidato_id)
    {
        $candidato = Candidatos::find($candidato_id);

        $candidato->delete();

        return response()->json(["resp" => "Candidato eliminado correctamente"]);

    }

    public function ShowByName(Request $request)
    {
        $nombreCompleto = $request->nombre;

        $candidatos = Candidatos::with([
            'institucion' => function ($query) {
                $query->select('id', 'nombre');
            },
            'carrera' => function ($query) {
                $query->select('id', 'nombre');
            }
        ])
            ->where('estado', 1)
            ->where(DB::raw("CONCAT(nombre, ' ', apellido)"), 'like', '%' . $nombreCompleto . '%')
            ->get();

        return response()->json(["data" => $candidatos, "conteo" => count($candidatos)]);
    }


}
