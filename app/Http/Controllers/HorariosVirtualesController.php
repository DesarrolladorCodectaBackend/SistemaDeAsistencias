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

            //Tipo de dato
            if (!is_string($request->horario_inicial)) {
                return response()->json(["resp" => "El horario inicial debe ser una cadena de texto"]);
            }
            if (!is_string($request->horario_final)) {
                return response()->json(["resp" => "El horario final debe ser una cadena de texto"]);
            }

            Horarios_Virtuales::create([
                "hora_inicial" => $request->hora_inicial,
                "hora_final" => $request->hora_final
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

            if (!$request->horario_inicial) {
                return response()->json(["resp" => "Ingrese el horario inicial"]);
            }
            if (!$request->horario_final) {
                return response()->json(["resp" => "Ingrese el horario final"]);
            }

            //Tipo de dato
            if (!is_string($request->horario_inicial)) {
                return response()->json(["resp" => "El horario inicial debe ser una cadena de texto"]);
            }
            if (!is_string($request->horario_final)) {
                return response()->json(["resp" => "El horario final debe ser una cadena de texto"]);
            }

            $horario->fill([
                "horario_inicial" => $request->horario_inicial,
                "horario_final" => $request->horario_final
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
