<?php

namespace App\Http\Controllers;

use App\Models\Horarios_Virtuales;
use Illuminate\Http\Request;
use App\Http\Requests\StoreHorarios_VirtualesRequest;
use App\Http\Requests\UpdateHorarios_VirtualesRequest;
use Illuminate\Support\Facades\DB;
use Exception;

class HorariosVirtualesController extends Controller
{
    
    public function index()
    {
        try {
            $horarios_virtuales = Horarios_Virtuales::get();
            if (count($horarios_virtuales) == 0) {
                return response()->json(["resp" => "No hay registros insertados"]);
            }
            return response()->json(["data" => $horarios_virtuales, "conteo" => count($horarios_virtuales)]);
        } catch (Exception $e) {
            return response()->json(["error" => $e]);
        }
    }

    
    public function create(Request $request)
    {
        DB::beginTransaction();
        try {
            //Existencia
            if (!$request->hora_inicial) {
                return response()->json(["resp" => "Ingrese el hora inicial"]);
            }
            if (!$request->hora_final) {
                return response()->json(["resp" => "Ingrese el hora final"]);
            }
            if (!$request->dia) {
                return response()->json(["resp" => "Ingrese el dia"]);
            }

            //Tipo de dato
            if (!is_string($request->hora_inicial)) {
                return response()->json(["resp" => "La hora inicial debe ser una cadena de texto"]);
            }
            if (!is_string($request->hora_final)) {
                return response()->json(["resp" => "La hora final debe ser una cadena de texto"]);
            }
            if (!is_string($request->dia)) {
                return response()->json(["resp" => "El dia debe ser una cadena de texto"]);
            }

            Horarios_Virtuales::create([
                "hora_inicial" => $request->hora_inicial,
                "hora_final" => $request->hora_final,
                "dia" => $request->dia
            ]);

            DB::commit();
            return response()->json(["resp" => "Horario virtual creado"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["error" => $e]);
        }
    }

    
    public function show($horario_virtual_id)
    {
        try {
            $horario = Horarios_Virtuales::find($horario_virtual_id);

            if ($horario == null) {
                return response()->json(["resp" => "No existe un registro con ese id"]);
            }

            return response()->json(["data"=>$horario]);
        } catch (Exception $e) {
            return response()->json(["data" => $e]);
        }
    }

    
    public function update(Request $request, $horario_virtual_id)
    {
        DB::beginTransaction();

        try {
            $horario = Horarios_Virtuales::find($horario_virtual_id);

            //Existencia
            if ($horario == null) {
                return response()->json(["resp" => "No existe un registro con ese id"]);
            }

            if (!$request->hora_inicial) {
                return response()->json(["resp" => "Ingrese el hora inicial"]);
            }
            if (!$request->hora_final) {
                return response()->json(["resp" => "Ingrese el hora final"]);
            }
            if (!$request->dia) {
                return response()->json(["resp" => "Ingrese el dia"]);
            }

            //Tipo de dato
            if (!is_string($request->hora_inicial)) {
                return response()->json(["resp" => "La hora inicial debe ser una cadena de texto"]);
            }
            if (!is_string($request->hora_final)) {
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
            return response()->json(["resp" => "Horario virtual con id ".$horario_virtual_id." editado"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["error" => $e]);
        }
    }

    
    public function destroy($horario_virtual_id)
    {
        DB::beginTransaction();
        try {
            $horario = Horarios_Virtuales::find($horario_virtual_id);

            if ($horario == null) {
                return response()->json(["resp" => "No existe un registro con ese id"]);
            }

            $horario->delete();
            DB::commit();
            return response()->json(["resp" => "Horario virtual con id ".$horario_virtual_id." eliminado"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["error" => $e]);
        }
    }
}
