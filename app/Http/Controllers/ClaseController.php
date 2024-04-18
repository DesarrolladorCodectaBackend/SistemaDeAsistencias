<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clase;
use Illuminate\Support\Facades\DB;
use Exception;

class ClaseController extends Controller
{
    public function index()
    {
        try{
            $clases = Clase::/*with([
                'horarios_virtuales' => function($query) {$query->select('id', 'hora_inicial', 'hora_final');},
                'colaboradores' => function($query) {$query->select('id', 'candidato_id');}])->*/get();

            if (count($clases) == 0) {
                return response()->json(["resp" => "No hay registros insertados"]);
            }

            return response()->json(["data" => $clases, "conteo" => count($clases)]);
        } catch (Exception $e){
            return response()->json(["error" => $e]);
        }

    }

    public function create(){
        return view('clase.create');
    }

    
    public function store(Request $request)
    {
        DB::beginTransaction();
        try{
            if(!$request->hora_inicial){
                return response()->json(["resp" => "Ingrese hora inicial"]);
            }

            if(!$request->hora_final){
                return response()->json(["resp" => "Ingrese hora final"]);
            }

            if(!$request->dia){
                return response()->json(["resp" => "Ingrese dia"]);
            }

            if(!$request->curso_id){
                return response()->json(["resp" => "Ingrese curso"]);
            }

            if(!is_string($request->hora_inicial)){
                return response()->json(["resp" => "La hora inicial debe ser un texto"]);
            }

            if(!is_string($request->hora_final)){
                return response()->json(["resp" => "La hora final debe ser un texto"]);
            }

            if(!is_string($request->dia)){
                return response()->json(["resp" => "El dia debe ser un texto"]);
            }

            if(!is_integer($request->curso_id)){
                return response()->json(["resp" => "El curso debe ser un número entero"]);
            }

            Clase::create([
                "hora_inicial" => $request->hora_inicial,
                "hora_final" => $request->hora_final,
                "dia" => $request->dia,
                "curso_id" => $request->curso_id
            ]);

            DB::commit();
            return response()->json(["resp" => "Registro creado correctamente"]);
        } catch (Exception $e){
            DB::rollBack();
            return response()->json(["error" => $e]);
        }

    }

    
    public function show($clase_id)
    {
        try {
            $clase = Clase::/*with([
                'horarios_virtuales' => function($query) {$query->select('id', 'hora_inicial', 'hora_final');},
                'colaboradores' => function($query) {$query->select('id', 'candidato_id');}])->*/find($clase_id);
            
            if (!$clase){
                return response()->json(["resp" => "No existe un registro con ese id"]);
            }

            return response()->json(["data" => $clase]);
        } catch (Exception $e){
            return response()->json(["error" => $e]);
        }

    }

    
    public function update(Request $request, $clase_id)
    {
        DB::beginTransaction();
        try{
            $clase = Clase::find($clase_id);

            if (!$clase_id){
                return response()->json(["resp" => "No existe un registro con ese id"]);
            }

            if(!$request->hora_inicial){
                return response()->json(["resp" => "Ingrese hora inicial"]);
            }

            if(!$request->hora_final){
                return response()->json(["resp" => "Ingrese hora final"]);
            }

            if(!$request->dia){
                return response()->json(["resp" => "Ingrese dia"]);
            }

            if(!$request->curso_id){
                return response()->json(["resp" => "Ingrese curso"]);
            }

            if(!is_string($request->hora_inicial)){
                return response()->json(["resp" => "La hora inicial debe ser un texto"]);
            }

            if(!is_string($request->hora_final)){
                return response()->json(["resp" => "La hora final debe ser un texto"]);
            }

            if(!is_string($request->dia)){
                return response()->json(["resp" => "El dia debe ser un texto"]);
            }

            if(!is_integer($request->curso_id)){
                return response()->json(["resp" => "El curso debe ser un número entero"]);
            }

            $clase->fill([
                "hora_inicial" => $request->hora_inicial,
                "hora_final" => $request->hora_final,
                "dia" => $request->dia,
                "curso_id" => $request->curso_id
            ])->save();
            
            DB::commit();
            return response()->json(["resp" => "Registro actualizado correctamente"]);
        } catch(Exception $e){
            DB::rollBack();
            return response()->json(["error" => $e]);
        }

    }

    
    public function destroy($clase_id)
    {
        DB::beginTransaction();
        
        try{
            $clase = Clase::find($clase_id);

            if (!$clase){
                return response()->json(["resp" => "No existe un registro con ese id"]);
            }

            $clase->delete();

            DB::commit();
            return response()->json(["resp" => "Registro eliminado correctamente"]);

            return redirect()->route('clase.index');
            
        } catch(Exception $e){
            DB::rollBack();
            return response()->json(["error" => $e]);
        }

    }
}
