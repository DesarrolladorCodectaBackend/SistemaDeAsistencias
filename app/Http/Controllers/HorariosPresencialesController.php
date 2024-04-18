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
            return response()->json(["error" => $e]);
        }
    }

    public function create(){
        return view('horariospresenciales.create');
    }


    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            //Existencia
            if (!$request->horario_inicial) {
                return response()->json(["resp" => "Ingrese la hora inicial"]);
            }
            if (!$request->horario_final) {
                return response()->json(["resp" => "Ingrese la hora final"]);
            }
            if (!$request->dia) {
                return response()->json(["resp" => "Ingrese el dia"]);
            }

            //Tipo de dato
            if (!is_string($request->horario_inicial)) {
                return response()->json(["resp" => "La hora inicial debe ser una cadena de texto"]);
            }
            if (!is_string($request->horario_final)) {
                return response()->json(["resp" => "La hora final debe ser una cadena de texto"]);
            }
            if (!is_string($request->dia)) {
                return response()->json(["resp" => "El dia debe ser una cadena de texto"]);
            }

            Horarios_Presenciales::create([
                "hora_inicial" => $request->hora_inicial,
                "hora_final" => $request->hora_final,
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
                return response()->json(["resp" => "Ingrese la hora inicial"]);
            }
            if (!$request->horario_final) {
                return response()->json(["resp" => "Ingrese la hora final"]);
            }
            if (!$request->dia) {
                return response()->json(["resp" => "Ingrese el dia"]);
            }

            //Tipo de dato
            if (!is_string($request->horario_inicial)) {
                return response()->json(["resp" => "La hora inicial debe ser una cadena de texto"]);
            }
            if (!is_string($request->horario_final)) {
                return response()->json(["resp" => "La hora final debe ser una cadena de texto"]);
            }
            if (!is_string($request->dia)) {
                return response()->json(["resp" => "El dia debe ser una cadena de texto"]);
            }

            $horario->fill([
                "hora_inicial" => $request->hora_inicial,
                "hora_final" => $request->hora_final,
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

            return redirect()->route('horariospresenciales.index');

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["error" => $e]);
        }
    }
}
