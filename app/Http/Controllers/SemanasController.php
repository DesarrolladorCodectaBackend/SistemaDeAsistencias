<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Semanas;
use Illuminate\Support\Facades\DB;
use Exception;

class SemanasController extends Controller
{
    public function index()
    {
        try {
            $semanas = Semanas::get();
            if (count($semanas) == 0) {
                return response()->json(["resp" => "No hay registros insertados"]);
            }
            return response()->json(["data" => $semanas, "conteo" => count($semanas)]);
        } catch (Exception $e) {
            return response()->json(["error" => $e]);
        }
    }


    public function store(Request $request)
    {
        DB::beginTransaction();
        try {

            if (!$request->fecha_lunes) {
                return response()->json(["resp" => "Ingrese la fecha"]);
            }

            /*if (!is_string($request->fecha_lunes)) {
                return response()->json(["resp" => "La fecha debe ser dateTime"]);
            }*/
            /*
            if (strlen($request->fecha_lunes) > 100) {
                return response()->json(["resp" => "La fehca es demasiada larga"]);
            }
            */

            Semanas::create([
                "fecha_lunes" => $request->fecha_lunes,
            ]);

            DB::commit();
            return response()->json(["resp" => "Registro creado"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["error" => $e]);
        }
    }


    public function show($semana_id)
    {
        try {
            $semana = Semanas::find($semana_id);

            if ($semana == null) {
                return response()->json(["resp" => "No existe un registro con ese id"]);
            }

            return response()->json(["data" => $semana]);
        } catch (Exception $e) {
            return response()->json(["error" => $e]);
        }
       
    }


    public function update(Request $request, $semana_id)
    {
        DB::beginTransaction();

        try {
            $semana = Semanas::find($semana_id);

            if ($semana == null) {
                return response()->json(["resp" => "No existe un registro con ese id"]);
            }

            if (!$request->fecha_lunes) {
                return response()->json(["resp" => "Ingrese el la fecha"]);
            }

            $semana->fill([
                "fecha_lunes" => $request->fecha_lunes
            ])->save();

            DB::commit();
            return response()->json(["resp" => "Registro editado"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["error" => $e]);
        }

    }


    public function destroy($semana_id)
    {
        DB::beginTransaction();

        try {
            $semana = Semanas::find($semana_id);

            if ($semana == null) {
                return response()->json(["resp" => "No existe un registro con ese id"]);
            }

            $semana->delete();

            DB::commit();
            return response()->json(["resp" => `Registro con id ${semana_id} eliminado`]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["error" => $e]);
        }

    }
}
