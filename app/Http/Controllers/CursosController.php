<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cursos;
use Illuminate\Support\Facades\DB;
use Exception;

class CursosController extends Controller
{
    public function index()
    {
        try {
            $cursos = Cursos::get();
            if (count($cursos) == 0) {
                return response()->json(["resp" => "No hay registros insertados"]);
            }
            return response()->json(["data" => $cursos, "conteo" => count($cursos)]);
        } catch (Exception $e) {
            return response()->json(["error" => $e]);
        }
    }


    public function create(Request $request)
    {
        DB::beginTransaction();
        try {

            if (!$request->nombre) {
                return response()->json(["resp" => "Ingrese el nombre"]);
            }

            if (!$request->categoria) {
                return response()->json(["resp" => "Ingrese la categoria"]);
            }

            if (!$request->duracion) {
                return response()->json(["resp" => "Ingrese la duracion"]);
            }

            if (!is_string($request->nombre)) {
                return response()->json(["resp" => "El nombre debe ser un texto"]);
            }

            if (!is_string($request->categoria)) {
                return response()->json(["resp" => "La categoria debe ser un texto"]);
            }

            if (!is_integer($request->duracion)) {
                return response()->json(["resp" => "La duracion debe ser un número entero"]);
            }

            Cursos::create([
                "nombre" => $request->nombre,
                "categoria" => $request->categoria,
                "duracion" => $request->duracion
            ]);
            
            DB::commit();
            return response()->json(["resp" => "Registro creado"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["error" => $e]);
        }
    }


    public function show($curso_id)
    {
        try {
            $curso = Cursos::find($curso_id);

            if ($curso == null) {
                return response()->json(["resp" => "No existe un registro con ese id"]);
            }

            return response()->json(["data" => $curso]);
        } catch (Exception $e) {
            return response()->json(["error" => $e]);
        }
       
    }


    public function update(Request $request, $curso_id)
    {
        DB::beginTransaction();

        try {
            $curso = Cursos::find($curso_id);

            if ($curso == null) {
                return response()->json(["resp" => "No existe un registro con ese id"]);
            }

            if (!$request->nombre) {
                return response()->json(["resp" => "Ingrese el nombre"]);
            }

            if (!$request->categoria) {
                return response()->json(["resp" => "Ingrese la categoria"]);
            }

            if (!$request->duracion) {
                return response()->json(["resp" => "Ingrese la duracion"]);
            }

            if (!is_string($request->nombre)) {
                return response()->json(["resp" => "El nombre debe ser un texto"]);
            }

            if (!is_string($request->categoria)) {
                return response()->json(["resp" => "La categoria debe ser un texto"]);
            }

            if (!is_integer($request->duracion)) {
                return response()->json(["resp" => "La duracion debe ser un número entero"]);
            }

            $curso->fill([
                "nombre" => $request->nombre,
                "categoria" => $request->categoria,
                "duracion" => $request->duracion
            ])->save();

            DB::commit();
            return response()->json(["resp" => "Registro editado"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["error" => $e]);
        }

    }


    public function destroy($curso_id)
    {
        DB::beginTransaction();

        try {
            $curso = Cursos::find($curso_id);

            if ($curso == null) {
                return response()->json(["resp" => "No existe un registro con ese id"]);
            }

            $curso->delete();

            DB::commit();
            return response()->json(["resp" => `Registro con id ${curso_id} eliminado`]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["error" => $e]);
        }

    }
}
