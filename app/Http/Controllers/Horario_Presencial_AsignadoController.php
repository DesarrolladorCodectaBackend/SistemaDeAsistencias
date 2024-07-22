<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Horario_Presencial_Asignado;
use Illuminate\Support\Facades\DB;
use Exception;

class Horario_Presencial_AsignadoController extends Controller
{
    public function index()
    {
        try{
            $horarios_presenciales_Asignados = Horario_Presencial_Asignado::/*with([
                'institucion' => function ($query) {
                    $query->select('id', 'nombre'); },
                'carrera' => function ($query) {
                    $query->select('id', 'nombre'); }
            ])->*/get();
            if (count($horarios_presenciales_Asignados) == 0) {
                return response()->json(["resp" => "No hay registros insertados"]);
            }
            return response()->json(["data" => $horarios_presenciales_Asignados, "conteo" => count($horarios_presenciales_Asignados)]);
        } catch(Exception $e){
            return response()->json(["error" => $e]);
        }
        
    }


    public function create(Request $request)
    {
        DB::beginTransaction();
        try{
            if(!$request->horario_presencial_id){
                return response()->json(["resp" => "Ingrese el horario presencial"]);
            }

            if(!$request->area_id){
                return response()->json(["resp" => "Ingrese el area"]);
            }

            if (!is_integer($request->horario_presencial_id)) {
                return response()->json(["resp" => "El horario presencial debe ser un número entero"]);
            }

            if (!is_integer($request->area_id)) {
                return response()->json(["resp" => "El area debe ser un número entero"]);
            }

            Horario_Presencial_Asignado::create([
                "horario_presencial_id" => $request->horario_presencial_id,
                "area_id" => $request->area_id
            ]);

            DB::commit();
            return response()->json(["resp" => "Registro creado exitosamente"]);
        }catch(Exception $e){
            DB::rollBack();
            return response()->json(["error" => $e]);
        }

    }


    public function show($horario_presencial_asignado_id)
    {
        try{
            $horario_presencial_asignado = Horario_Presencial_Asignado::/*with([
                'institucion' => function ($query) {
                    $query->select('id', 'nombre'); },
                'carrera' => function ($query) {
                    $query->select('id', 'nombre'); }
            ])->*/find($horario_presencial_asignado_id);
            if (!$horario_presencial_asignado){
                return response()->json(["resp" => "No existe un registro con ese id"]);
            }
            return response()->json(["Data" => $horario_presencial_asignado]);
        } catch (Exception $e){
            return response()->json(["error" => $e]);
        }
    }


    public function update(Request $request, $horario_presencial_asignado_id)
    {
        DB::beginTransaction();
        try{
            $horario_presencial_asignado = Horario_Presencial_Asignado::find($horario_presencial_asignado_id);

            if (!$horario_presencial_asignado){
                return response()->json(["resp" => "No existe un registro con ese id"]);
            }

            if(!$request->horario_presencial_id){
                return response()->json(["resp" => "Ingrese el horario presencial"]);
            }

            if(!$request->area_id){
                return response()->json(["resp" => "Ingrese el area"]);
            }

            if (!is_integer($request->horario_presencial_id)) {
                return response()->json(["resp" => "El horario presencial debe ser un número entero"]);
            }

            if (!is_integer($request->area_id)) {
                return response()->json(["resp" => "El area debe ser un número entero"]);
            }

            $horario_presencial_asignado->fill([
                "horario_presencial_id" => $request->horario_presencial_id,
                "area_id" => $request->area_id
            ])->save();
            
            DB::commit();
            return response()->json(["resp" => "Registro actualizado correctamente"]);
        } catch(Exception $e){
            DB::rollBack();
            return response()->json(["error" => $e]);
        }


    }


    public function destroy($horario_presencial_asignado_id)
    {
        DB::beginTransaction();
        try{
            $horario_presencial_asignado = Horario_Presencial_Asignado::find($horario_presencial_asignado_id);

            if (!$horario_presencial_asignado){
                return response()->json(["resp" => "No existe un registro con ese id"]);
            }

            $horario_presencial_asignado->delete();
            
            DB::commit();
            return response()->json(["resp" => "Candidato eliminado correctamente"]);
        } catch (Exception $e){
            DB::rollBack();
            return response()->json(["error" => $e]);
        }


    }
}
