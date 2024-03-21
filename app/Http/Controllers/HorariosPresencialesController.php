<?php

namespace App\Http\Controllers;

use App\Models\Horarios_Presenciales;
use Illuminate\Http\Request;
use App\Http\Requests\StoreHorarios_PresencialesRequest;
use App\Http\Requests\UpdateHorarios_PresencialesRequest;
use Illuminate\Support\Facades\DB;
use Exception;

class HorariosPresencialesController extends Controller
{

    public function index()
    {
        try {
            $horarios_presenciales = Horarios_Presenciales::get();
            if (count($horarios_presenciales) == 0) {
                return response()->json(["resp" => "No hay registros insertados"]);
            }
            return response()->json(["data" => $horarios_presenciales, "conteo" => count($horarios_presenciales)]);
        } catch (Exception $e) {
            return response()->json(["resp" => $e]);
        }
    }


    public function create(Request $request)
    {
        DB::beginTransaction();
        try {
            //Existencia
            if (!$request->horario_inicial) {
                return response()->json(["resp" => "Ingrese el horario inicial"]);
            }
            if (!$request->horario_final) {
                return response()->json(["resp" => "Ingrese el horario final"]);
            }
            if (!$request->dia) {
                return response()->json(["resp" => "Ingrese el dia final"]);
            }

            //Tipo de dato
            if (!is_string($request->horario_inicial)) {
                return response()->json(["resp" => "El horario inicial debe ser una cadena de texto"]);
            }
            if (!is_string($request->horario_final)) {
                return response()->json(["resp" => "El horario final debe ser una cadena de texto"]);
            }
            if (!is_string($request->dia)) {
                return response()->json(["resp" => "El dia debe ser una cadena de texto"]);
            }

            Horarios_Presenciales::create([
                "horario_inicial" => $request->horario_inicial,
                "horario_final" => $request->horario_final,
                "dia" => $request->dia
            ]);

            DB::commit();
            return response()->json(["resp" => "Horario presencial creado"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["error" => $e]);
        }
    }


    public function show($horario_presencial_id)
    {
        try {
            $horario = Horarios_Presenciales::find($horario_presencial_id);

            if ($horario == null) {
                return response()->json(["resp" => "No existe un registro con ese id"]);
            }

            return response()->json(["data" => $horario]);
        } catch (Exception $e) {
            return response()->json(["data" => $e]);
        }
    }


    public function update(Request $request, $horario_presencial_id)
    {
        DB::beginTransaction();

        try {
            $horario = Horarios_Presenciales::find($horario_presencial_id);

            //Existencia
            if ($horario == null) {
                return response()->json(["resp" => "No existe un registro con ese id"]);
            }

            if (!$request->horario_inicial) {
                return response()->json(["resp" => "Ingrese el horario inicial"]);
            }
            if (!$request->horario_final) {
                return response()->json(["resp" => "Ingrese el horario final"]);
            }
            if (!$request->dia) {
                return response()->json(["resp" => "Ingrese el dia final"]);
            }

            //Tipo de dato
            if (!is_string($request->horario_inicial)) {
                return response()->json(["resp" => "El horario inicial debe ser una cadena de texto"]);
            }
            if (!is_string($request->horario_final)) {
                return response()->json(["resp" => "El horario final debe ser una cadena de texto"]);
            }
            if (!is_string($request->dia)) {
                return response()->json(["resp" => "El dia debe ser una cadena de texto"]);
            }

            $horario->fill([
                "horario_inicial" => $request->horario_inicial,
                "horario_final" => $request->horario_final,
                "dia" => $request->dia
            ])->save();

            DB::commit();
            return response()->json(["resp" => "Horario presencial con id " . $horario_presencial_id . " editado"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["error" => $e]);
        }
    }


    public function destroy($horario_presencial_id)
    {
        DB::beginTransaction();
        try {
            $horario = Horarios_Presenciales::find($horario_presencial_id);

            if ($horario == null) {
                return response()->json(["resp" => "No existe un registro con ese id"]);
            }

            $horario->delete();
            DB::commit();
            return response()->json(["resp" => "Horario presencial con id " . $horario_presencial_id . " eliminado"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["error" => $e]);
        }
    }
}
