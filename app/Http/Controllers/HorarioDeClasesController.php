<?php

namespace App\Http\Controllers;

use App\Models\Horario_de_Clases;
use App\Models\Colaboradores;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HorarioDeClasesController extends Controller
{ 
    public function index()
    {
        try{
            $horario_de_clases = Horario_de_Clases::with('colaboradores')->get();

            if(count($horario_de_clases) == 0){
                return response()->json(["resp" => "No hay registros insertados"]);
            }

            return response()->json(["data" => $horario_de_clases, "conteo" => count($horario_de_clases)]);
        } catch(Exception $e){
            return response()->json(["error" => $e]);
        }

    }

    public function getCalendariosColaborador($colaborador_id) {
        $horariosDeClases = Horario_de_Clases::where('colaborador_id', $colaborador_id)->get();
        //return $horariosDeClases;
        return view('inspiniaViews.colaboradores.horario_clases', compact('horariosDeClases'));
    }


    public function store(Request $request, $candidato_id){
        $colaborador = Colaboradores::where('candidato_id', $candidato_id)->first();
        $request->validate([
            'hora_inicial' => 'required|time',
            'hora_final' => "required|time",
            'dia' => "required|string"
        ]);

        Horario_de_Clases::create([
            "colaborador_id" => $colaborador->id,
            "hora_inicial" => $request->hora_inicial,
            "hora_final" => $request->hora_final,
            "dia" => $request->dia
        ]);
    }
    
    /*
    public function create(Request $request)
    {
        DB::beginTransaction();
        try{
            if(!$request->colaborador_id){
                return response()->json(["resp" => "Ingrese colaborador"]);
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

            if(!is_integer($request->colaborador_id)){
                return response()->json(["resp" => "El id del colaborador debe ser un número entero"]);
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

            Horario_de_Clases::create([
                "colaborador_id" => $request->colaborador_id,
                "hora_inicial" => $request->hora_inicial,
                "hora_final" => $request->hora_final,
                "dia" => $request->dia
            ]);
            DB::commit();
            return response()->json(["resp" => "Registro creado correctamente"]);
        } catch (Exception $e){
            DB::rollBack();
            return response()->json(["error" => $e]);
        }
    }
    */

    
    public function show($horario_de_clases_id)
    {
        try{
            $horario_de_clases = Horario_de_Clases::with('colaboradores')->find($horario_de_clases_id);

            if(!$horario_de_clases){
                return response()->json(["resp" => "No existe un registro con ese id"]);
            }

            return response()->json(["data" => $horario_de_clases]);
        } catch(Exception $e){
            return response()->json(["error" => $e]);
        }

    }

    
    public function update(Request $request, $horario_de_clases_id)
    {
        DB::beginTransaction();
        try{
            $horario_de_clases = Horario_de_Clases::find($horario_de_clases_id);

            if(!$horario_de_clases){
                return response()->json(["resp" => "No existe un registro con ese id"]);
            }

            if(!$request->colaborador_id){
                return response()->json(["resp" => "Ingrese colaborador"]);
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

            if(!is_integer($request->colaborador_id)){
                return response()->json(["resp" => "El id del colaborador debe ser un número entero"]);
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

            $horario_de_clases->fill([
                "colaborador_id" => $request->colaborador_id,
                "hora_inicial" => $request->hora_inicial,
                "hora_final" => $request->hora_final,
                "dia" => $request->dia
            ])->save();
            DB::commit();
            return response()->json(["resp" => "Registro actualizado correctamente"]);
        } catch(Exception $e){
            DB::rollBack();
            return response()->json(["error" => $e]);
        }

    }

    
    public function destroy($horario_de_clases_id)
    {
        DB::beginTransaction();
        try{
            $horario_de_clases = Horario_de_Clases::find($horario_de_clases_id);

            if(!$horario_de_clases){
                return response()->json(["resp" => "No existe un registro con ese id"]);
            }

            $horario_de_clases->delete();
            DB::commit();
            return response()->json(["resp" => "Registro eliminado correctamente"]);
        } catch(Exception $e){
            DB::rollBack();
            return response()->json(["error" => $e]);
        }

    }
}
