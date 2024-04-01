<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCarreraRequest;
use App\Http\Requests\UpdateCarreraRequest;
use Illuminate\Support\Facades\DB;
use Exception;

class CarreraController extends Controller
{

    public function index()
    {

        try {
            $carreras = Carrera::get();
            if (count($carreras) == 0) {
                return response()->json(["resp" => "No hay registros insertados"]);
            }
            return response()->json(["data" => $carreras, "conteo" => count($carreras)]);
        } catch (Exception $e) {
            return response()->json(["error" => $e]);
        }
    }


    public function create(Request $request)
    {
        DB::beginTransaction();
        try {

            if (!$request->nombre) {
                return response()->json(["resp" => "Ingrese el nombre de la institucion"]);
            }

            if (!is_string($request->nombre)) {
                return response()->json(["resp" => "El nombre debe ser una cadena de texto"]);
            }

            if (strlen($request->nombre) > 100) {
                return response()->json(["resp" => "El nombre es demasiado largo"]);
            }

            $nombre_existente = Carrera::where('nombre', $request->nombre)->exists();
            if ($nombre_existente) {
                return response()->json(["resp" => "El nombre de la carrera ya existe"]);
            }

            Carrera::create([
                "nombre" => $request->nombre
            ]);

            DB::commit();
            return response()->json(["resp" => "Carrera creada con nombre " . $request->nombre]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["error" => $e]);
        }
    }


    public function show($carrera_id)
    {
        try {
            $carrera = Carrera::find($carrera_id);

            if ($carrera == null) {
                return response()->json(["resp" => "No existe una institución con ese id"]);
            }

            return response()->json(["data" => $carrera]);
        } catch (Exception $e) {
            return response()->json(["data" => $e]);
        }
    }


    public function update(Request $request, $carrera_id)
    {
        DB::beginTransaction();

        try {
            $carrera = Carrera::find($carrera_id);

            if ($carrera == null) {
                return response()->json(["resp" => "No existe una carrera con ese id"]);
            }

            if (!$request->nombre) {
                return response()->json(["resp" => "Ingrese el nombre de la carrera"]);
            }

            if (!is_string($request->nombre)) {
                return response()->json(["resp" => "El nombre debe ser una cadena de texto"]);
            }

            if (strlen($request->nombre) > 100) {
                return response()->json(["resp" => "El nombre es demasiado largo"]);
            }

            $carrera->fill([
                "nombre" => $request->nombre
            ])->save();

            DB::commit();
            return response()->json(["resp" => "Carrera con id " . $carrera_id . " fue editada"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["error" => $e]);
        }
    }


    public function destroy($carrera_id)
    {
        DB::beginTransaction();
        try {
            $carrera = Carrera::find($carrera_id);

            if ($carrera == null) {
                return response()->json(["resp" => "No existe una carrera con ese id"]);
            }

            $carrera->delete();
            DB::commit();
            return response()->json(["resp" => "Carrera con id " . $carrera_id . " y nombre " . $carrera->nombre . " ha sido eliminada."]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["error" => $e]);
        }
    }

}
