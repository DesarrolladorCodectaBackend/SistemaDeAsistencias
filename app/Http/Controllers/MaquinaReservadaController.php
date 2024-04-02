<?php

namespace App\Http\Controllers;

use App\Models\Maquina_reservada;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MaquinaReservadaController extends Controller
{
    public function index()
    {
        try {
            $maquinas_reservadas = Maquina_reservada::with([
                'horarios_presenciales' => function ($query) {
                    $query->select('id', 'horario_inicial', 'horario_final', 'dia'); },
                'maquinas' => function ($query) {
                    $query->select('id', 'nombre'); }
            ])->get();

            if (count($maquinas_reservadas) == 0) {
                return response()->json(["resp" => "No hay registros insertados"]);
            }

            return response()->json(["data" => $maquinas_reservadas, "conteo" => count($maquinas_reservadas)]);
        } catch (Exception $e) {
            return response()->json(["error" => $e]);
        }
    }

    public function create(Request $request)
    {
        DB::beginTransaction();
        try {
            if (!$request->horario_presencial_id) {
                return response()->json(["resp" => "Ingrese el id del horario presencial"]);
            }

            if (!$request->maquina_id) {
                return response()->json(["resp" => "Ingrese el id de la maquina"]);
            }

            if (!is_integer($request->horario_presencial_id)) {
                return response()->json(["resp" => "El id del horario presencial debe ser un número entero"]);
            }

            if (!is_integer($request->maquina_id)) {
                return response()->json(["resp" => "El id de la maquina debe ser un número entero"]);
            }
            Maquina_reservada::create([
                "horario_presencial_id" => $request->horario_presencial_id,
                "maquina_id" => $request->maquina_id
            ]);
            DB::commit();
            return response()->json(["resp" => "Registro creado correctamente"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["error" => $e]);
        }

    }

    public function show($maquina_reservada_id)
    {
        try {
            $maquina_reservada = Maquina_reservada::with([
                'horarios_presenciales' => function ($query) {
                    $query->select('id', 'horario_inicial', 'horario_final', 'dia'); },
                'maquinas' => function ($query) {
                    $query->select('id', 'nombre'); }
            ])->find($maquina_reservada_id);

            if (!$maquina_reservada) {
                return response()->json(["resp" => "No existe un registro con ese id"]);
            }
            return response()->json(["data" => $maquina_reservada]);
        } catch (Exception $e) {
            return response()->json(["error" => $e]);
        }

    }

    public function update(Request $request, $maquina_reservada_id)
    {
        DB::beginTransaction();
        try {
            $maquina_reservada = Maquina_reservada::find($maquina_reservada_id);

            if (!$maquina_reservada) {
                return response()->json(["resp" => "No existe un registro con ese id"]);
            }

            if (!$request->horario_presencial_id) {
                return response()->json(["resp" => "Ingrese el id del horario presencial"]);
            }

            if (!$request->maquina_id) {
                return response()->json(["resp" => "Ingrese el id de la maquina"]);
            }

            if (!is_integer($request->horario_presencial_id)) {
                return response()->json(["resp" => "El id del horario presencial debe ser un número entero"]);
            }

            if (!is_integer($request->maquina_id)) {
                return response()->json(["resp" => "El id de la maquina debe ser un número entero"]);
            }

            $maquina_reservada->fill([
                "horario_presencial_id" => $request->horario_presencial_id,
                "maquina_id" => $request->maquina_id
            ])->save();
            
            DB::commit();
            return response()->json(["resp" => "Registro actualizado correctamente"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["error" => $e]);
        }

    }

    public function destroy($maquina_reservada_id)
    {
        DB::beginTransaction();
        try {
            $maquina_reservada = Maquina_reservada::find($maquina_reservada_id);

            if (!$maquina_reservada) {
                return response()->json(["resp" => "No existe un registro con ese id"]);
            }

            $maquina_reservada->delete();

            DB::commit();
            return response()->json(["resp" => "Registro eliminado correctamente"]);
        } catch(Exception $e){
            DB::rollBack();
            return response()->json(["error" => $e]);
        }

    }

}
