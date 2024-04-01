<?php

namespace App\Http\Controllers;

use App\Models\Horario_Virtual_Colaborador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class HorarioVirtualColaboradorController extends Controller
{
    
    public function index()
    {
        try{
            $horarios_virtuales_colaborador = Horario_Virtual_Colaborador::/*with([
                'horarios_virtuales' => function($query) {$query->select('id', 'hora_inicial', 'hora_final');},
                'colaboradores' => function($query) {$query->select('id', 'candidato_id');}])->*/get();

            if (count($horarios_virtuales_colaborador) == 0) {
                return response()->json(["resp" => "No hay registros insertados"]);
            }

            return response()->json(["data" => $horarios_virtuales_colaborador, "conteo" => count($horarios_virtuales_colaborador)]);
        } catch (Exception $e){
            return response()->json(["error" => $e]);
        }

    }

    
    public function create(Request $request)
    {
        DB::beginTransaction();
        try{
            if(!$request->horario_virtual_id){
                return response()->json(["resp" => "Ingrese horario virtual"]);
            }

            if(!$request->semana_id){
                return response()->json(["resp" => "Ingrese semana"]);
            }

            if(!$request->area_id){
                return response()->json(["resp" => "Ingrese area"]);
            }

            if(!is_integer($request->horario_virtual_id)){
                return response()->json(["resp" => "El horario virtual debe ser un número entero"]);
            }

            if(!is_integer($request->semana_id)){
                return response()->json(["resp" => "La semana debe ser un número entero"]);
            }

            if(!is_integer($request->area_id)){
                return response()->json(["resp" => "El area debe ser un número entero"]);
            }

            Horario_Virtual_Colaborador::create([
                "horario_virtual_id" => $request->horario_virtual_id,
                "semana_id" => $request->semana_id,
                "area_id" => $request->area_id
            ]);

            DB::commit();
            return response()->json(["resp" => "Registro creado correctamente"]);
        } catch (Exception $e){
            DB::rollBack();
            return response()->json(["error" => $e]);
        }

    }

    
    public function show($horario_virtual_colaborador_id)
    {
        try {
            $horario_virtual_colaborador = Horario_Virtual_Colaborador::/*with([
                'horarios_virtuales' => function($query) {$query->select('id', 'hora_inicial', 'hora_final');},
                'colaboradores' => function($query) {$query->select('id', 'candidato_id');}])->*/find($horario_virtual_colaborador_id);
            
            if (!$horario_virtual_colaborador){
                return response()->json(["resp" => "No existe un registro con ese id"]);
            }

            return response()->json(["data" => $horario_virtual_colaborador]);
        } catch (Exception $e){
            return response()->json(["error" => $e]);
        }

    }

    
    public function update(Request $request, $horario_virtual_colaborador_id)
    {
        DB::beginTransaction();
        try{
            $horario_virtual_colaborador = Horario_Virtual_Colaborador::find($horario_virtual_colaborador_id);

            if (!$horario_virtual_colaborador){
                return response()->json(["resp" => "No existe un registro con ese id"]);
            }

            if(!$request->horario_virtual_id){
                return response()->json(["resp" => "Ingrese horario virtual"]);
            }

            if(!$request->semana_id){
                return response()->json(["resp" => "Ingrese semana"]);
            }

            if(!$request->area_id){
                return response()->json(["resp" => "Ingrese area"]);
            }

            if(!is_integer($request->horario_virtual_id)){
                return response()->json(["resp" => "El horario virtual debe ser un número entero"]);
            }

            if(!is_integer($request->semana_id)){
                return response()->json(["resp" => "La semana debe ser un número entero"]);
            }

            if(!is_integer($request->area_id)){
                return response()->json(["resp" => "El area debe ser un número entero"]);
            }

            $horario_virtual_colaborador->fill([
                "horario_virtual_id" => $request->horario_virtual_id,
                "semana_id" => $request->semana_id,
                "area_id" => $request->area_id
            ])->save();
            
            DB::commit();
            return response()->json(["resp" => "Registro actualizado correctamente"]);
        } catch(Exception $e){
            DB::rollBack();
            return response()->json(["error" => $e]);
        }

    }

    
    public function destroy($horario_virtual_colaborador_id)
    {
        DB::beginTransaction();
        
        try{
            $horario_virtual_colaborador = Horario_Virtual_Colaborador::find($horario_virtual_colaborador_id);

            if (!$horario_virtual_colaborador){
                return response()->json(["resp" => "No existe un registro con ese id"]);
            }

            $horario_virtual_colaborador->delete();

            DB::commit();
            return response()->json(["resp" => "Registro eliminado correctamente"]);
        } catch(Exception $e){
            DB::rollBack();
            return response()->json(["error" => $e]);
        }

    }
}
