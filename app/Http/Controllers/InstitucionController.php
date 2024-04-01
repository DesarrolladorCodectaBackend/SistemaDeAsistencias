<?php

namespace App\Http\Controllers;

use App\Models\Institucion;
use Illuminate\Http\Request;
use App\Http\Requests\StoreInstitucionRequest;
use App\Http\Requests\UpdateInstitucionRequest;
use Illuminate\Support\Facades\DB;
use Exception;

class InstitucionController extends Controller
{

    public function index()
    {
        try {
            $instituciones = Institucion::get();
            if (count($instituciones) == 0) {
                return response()->json(["resp" => "No hay registros insertados"]);
            }
            return response()->json(["data" => $instituciones, "conteo" => count($instituciones)]);
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

            Institucion::create([
                "nombre" => $request->nombre,
            ]);

            DB::commit();
            return response()->json(["resp" => "Institución creada con nombre " . $request->nombre]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["error" => $e]);
        }
    }


    public function show($institucion_id)
    {
        try {
            $institucion = Institucion::find($institucion_id);

            if ($institucion == null) {
                return response()->json(["resp" => "No existe una institución con ese id"]);
            }

            return response()->json(["data" => $institucion]);
        } catch (Exception $e) {
            return response()->json(["error" => $e]);
        }
       
    }


    public function update(Request $request, $institucion_id)
    {
        DB::beginTransaction();

        try {
            $institucion = Institucion::find($institucion_id);

            if ($institucion == null) {
                return response()->json(["resp" => "No existe una institución con ese id"]);
            }

            if (!$request->nombre) {
                return response()->json(["resp" => "Ingrese el nombre de la institucion"]);
            }

            if (!is_string($request->nombre)) {
                return response()->json(["resp" => "El nombre debe ser una cadena de texto"]);
            }

            if (strlen($request->nombre) > 100) {
                return response()->json(["resp" => "El nombre es demasiado largo"]);
            }

            $institucion->fill([
                "nombre" => $request->nombre
            ])->save();

            DB::commit();
            return response()->json(["resp" => "Institución con id " . $institucion_id . " fue editada"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["error" => $e]);
        }

    }


    public function destroy($institucion_id)
    {
        DB::beginTransaction();

        try {
            $institucion = Institucion::find($institucion_id);

            if ($institucion == null) {
                return response()->json(["resp" => "No existe una institución con ese id"]);
            }

            $institucion->delete();

            DB::commit();
            return response()->json(["resp" => "Institución con id " . $institucion_id . " y nombre " . $institucion->nombre . " eliminada"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["error" => $e]);
        }

    }
}
