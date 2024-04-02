<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asistentes_Clase;
use Illuminate\Support\Facades\DB;
use Exception;

class Asistentes_ClaseController extends Controller
{
    public function index()
    {
        try{
            $asistentes_clases = Asistentes_Clase::/*with('colaboradores')->*/get();

            if(count($asistentes_clases) == 0){
                return response()->json(["resp" => "No hay registros insertados"]);
            }

            return response()->json(["data" => $asistentes_clases, "conteo" => count($asistentes_clases)]);
        } catch(Exception $e){
            return response()->json(["error" => $e]);
        }

    }

    
    public function create(Request $request)
    {
        DB::beginTransaction();
        try{
            if(!$request->colaborador_id){
                return response()->json(["resp" => "Ingrese colaborador"]);
            }

            if(!$request->clase_id){
                return response()->json(["resp" => "Ingrese clase"]);
            }

            if(!$request->asistio){
                return response()->json(["resp" => "Ingrese si asistio"]);
            }

            if(!is_integer($request->colaborador_id)){
                return response()->json(["resp" => "El id del colaborador debe ser un número entero"]);
            }

            if(!is_integer($request->clase_id)){
                return response()->json(["resp" => "El id de la clase debe ser un número entero"]);
            }

            if(!is_bool($request->asistio)){
                return response()->json(["resp" => "Asistio debe ser un booleano"]);
            }

            Asistentes_Clase::create([
                "colaborador_id" => $request->colaborador_id,
                "clase_id" => $request->clase_id,
                "asistio" => $request->asistio
            ]);
            DB::commit();
            return response()->json(["resp" => "Registro creado correctamente"]);
        } catch (Exception $e){
            DB::rollBack();
            return response()->json(["error" => $e]);
        }
    }

    
    public function show($asistente_clase_id)
    {
        try{
            $asistente_clase = Asistentes_Clase::with('colaboradores')->find($asistente_clase_id);

            if(!$asistente_clase){
                return response()->json(["resp" => "No existe un registro con ese id"]);
            }

            return response()->json(["data" => $asistente_clase]);
        } catch(Exception $e){
            return response()->json(["error" => $e]);
        }

    }

    
    public function update(Request $request, $asistente_clase_id)
    {
        DB::beginTransaction();
        try{
            $asistente_clase = Asistentes_Clase::find($asistente_clase_id);

            if(!$asistente_clase){
                return response()->json(["resp" => "No existe un registro con ese id"]);
            }

            if(!$request->colaborador_id){
                return response()->json(["resp" => "Ingrese colaborador"]);
            }

            if(!$request->clase_id){
                return response()->json(["resp" => "Ingrese clase"]);
            }

            if(!$request->asistio){
                return response()->json(["resp" => "Ingrese si asistio"]);
            }

            if(!is_integer($request->colaborador_id)){
                return response()->json(["resp" => "El id del colaborador debe ser un número entero"]);
            }

            if(!is_integer($request->clase_id)){
                return response()->json(["resp" => "El id de la clase debe ser un número entero"]);
            }

            if(!is_bool($request->asistio)){
                return response()->json(["resp" => "Asistio debe ser un booleano"]);
            }

            $asistente_clase->fill([
                "colaborador_id" => $request->colaborador_id,
                "clase_id" => $request->clase_id,
                "asistio" => $request->asistio
            ])->save();
            DB::commit();
            return response()->json(["resp" => "Registro actualizado correctamente"]);
        } catch(Exception $e){
            DB::rollBack();
            return response()->json(["error" => $e]);
        }

    }

    
    public function destroy($asistente_clase_id)
    {
        DB::beginTransaction();
        try{
            $asistente_clase = Asistentes_Clase::find($asistente_clase_id);

            if(!$asistente_clase){
                return response()->json(["resp" => "No existe un registro con ese id"]);
            }

            $asistente_clase->delete();
            DB::commit();
            return response()->json(["resp" => "Registro eliminado correctamente"]);
        } catch(Exception $e){
            DB::rollBack();
            return response()->json(["error" => $e]);
        }

    }
}
