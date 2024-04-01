<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Responsabilidades_semanales;
use Illuminate\Support\Facades\DB;
use Exception;

class Responsabilidades_SemanalesController extends Controller
{
    public function index()
    {
        try {
            $responsabilidades_semanales = Responsabilidades_semanales::get();
            if (count($responsabilidades_semanales) == 0) {
                return response()->json(["resp" => "No hay registros insertados"]);
            }
            return response()->json(["data" => $responsabilidades_semanales, "conteo" => count($responsabilidades_semanales)]);
        } catch (Exception $e) {
            return response()->json(["resp" => $e]);
        }
    }


    public function create(Request $request)
    {
        DB::beginTransaction();
        try {

            if (!$request->nombre) {
                return response()->json(["resp" => "Ingrese el nombre"]);
            }

            if (!$request->porcentaje_peso) {
                return response()->json(["resp" => "Ingrese el porcentaje"]);
            }

            if (!is_string($request->nombre)) {
                return response()->json(["resp" => "El nombre debe ser un texto"]);
            }

            if (!is_string($request->porcentaje_peso)) {
                return response()->json(["resp" => "La porcentaje de peso debe ser un texto"]);
            }

            Responsabilidades_semanales::create([
                "nombre" => $request->nombre,
                "porcentaje_peso" => $request->porcentaje_peso
            ]);

            DB::commit();
            return response()->json(["resp" => "Registro creado"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["error" => $e]);
        }
    }


    public function show($responsabilidad_semanal_id)
    {
        try {
            $responsabilidad_semanal = Responsabilidades_semanales::find($responsabilidad_semanal_id);

            if ($responsabilidad_semanal == null) {
                return response()->json(["resp" => "No existe un registro con ese id"]);
            }

            return response()->json(["data" => $responsabilidad_semanal]);
        } catch (Exception $e) {
            return response()->json(["error" => $e]);
        }
       
    }


    public function update(Request $request, $responsabilidad_semanal_id)
    {
        DB::beginTransaction();

        try {
            $responsabilidad_semanal = Responsabilidades_semanales::find($responsabilidad_semanal_id);

            if ($responsabilidad_semanal == null) {
                return response()->json(["resp" => "No existe un registro con ese id"]);
            }

            if (!$request->nombre) {
                return response()->json(["resp" => "Ingrese el nombre"]);
            }

            if (!$request->porcentaje_peso) {
                return response()->json(["resp" => "Ingrese el porcentaje"]);
            }

            if (!is_string($request->nombre)) {
                return response()->json(["resp" => "El nombre debe ser un texto"]);
            }

            if (!is_string($request->porcentaje_peso)) {
                return response()->json(["resp" => "La porcentaje de peso debe ser un texto"]);
            }

            $responsabilidad_semanal->fill([
                "nombre" => $request->nombre,
                "porcentaje_peso" => $request->porcentaje_peso
            ])->save();

            DB::commit();
            return response()->json(["resp" => "Registro editado"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["error" => $e]);
        }

    }


    public function destroy($responsabilidad_semanal_id)
    {
        DB::beginTransaction();

        try {
            $responsabilidad_semanal = Responsabilidades_semanales::find($responsabilidad_semanal_id);

            if ($responsabilidad_semanal == null) {
                return response()->json(["resp" => "No existe un registro con ese id"]);
            }

            $responsabilidad_semanal->delete();

            DB::commit();
            return response()->json(["resp" => `Registro con id ${responsabilidad_semanal_id} eliminado`]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["error" => $e]);
        }

    }
}
