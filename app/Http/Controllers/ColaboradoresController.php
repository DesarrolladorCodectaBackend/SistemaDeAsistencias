<?php

namespace App\Http\Controllers;

use App\Models\Colaboradores;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class ColaboradoresController extends Controller
{

    public function index()
    {
        try{
            $colaboradores = Colaboradores::with([
                'candidatos' => function ($query) {
                    $query->select('id', 'nombre', 'apellido', 'dni', 'direccion', 'fecha_nacimiento', 'ciclo_de_estudiante', 'estado', 'institucion_id', 'carrera_id'); }
            ])->where('estado', true)->get();
            
            if (count($colaboradores) == 0) {
                return response()->json(["resp" => "No hay registros insertados"]);
            }
            
            return response()->json(["data" => $colaboradores, "conteo" => count($colaboradores)]);
        } catch(Exception $e){
            return response()->json(["error" => $e]);
        }

    }


    public function create(Request $request)
    {
        DB::beginTransaction();
        try{
            if(!$request->candidato_id){
                return response()->json(["resp" => "Ingrese el id del candidato"]);
            }

            if(!is_integer($request->candidato_id)){
                return response()->json(["resp" => "El id del candidato debe ser un número entero"]);
            }
            Colaboradores::create([
                "candidato_id" => $request->candidato_id
            ]);
            DB::commit();
            return response()->json(["resp" => "Colaborador creado correctamente"]);
        } catch(Exception $e){
            DB::rollBack();
            return response()->json(["error" => $e]);
        }

    }


    public function show($colaborador_id)
    {
        try{
            $colaborador = Colaboradores::with('candidatos')->find($colaborador_id);
            if(!$colaborador){
                return response()->json(["resp" => "No existe un registro con ese id"]);
            }
            return response()->json(["data" => $colaborador]);
        } catch(Exception $e){
            return response()->json(["error" => $e]);
        }

    }


    public function update(Request $request, $colaborador_id)
    {
        DB::beginTransaction();
        try{
            $colaborador = Colaboradores::find($colaborador_id);

            if(!$colaborador){
                return response()->json(["resp" => "No existe un registro con ese id"]);
            }

            if(!$request->candidato_id){
                return response()->json(["resp" => "Ingrese el id del candidato"]);
            }

            if(!is_integer($request->candidato_id)){
                return response()->json(["resp" => "El id del candidato debe ser un número entero"]);
            }

            $colaborador->fill([
                "candidato_id" => $request->candidato_id
            ])->save();
            
            DB::commit();
            return response()->json(["resp" => "Colaborador actualizado correctamente"]);
        } catch(Exception $e){
            DB::rollBack();
            return response()->json(["error" => $e]);
        }

    }


    public function destroy($colaborador_id)
    {
        DB::beginTransaction();
        try{
            $colaborador = Colaboradores::find($colaborador_id);

            if(!$colaborador){
                return response()->json(["resp" => "No existe un registro con ese id"]);
            }

            $colaborador->delete();

            DB::commit();
            return response()->json(["resp" => "Colaborador eliminado correctamente"]);
        } catch(Exception $e){
            DB::rollBack();
            return response()->json(["error" => $e]);
        }

    }

    public function ShowByName(Request $request)
    {
        try{
            if(!$request->nombre){
                return response()->json(["resp" => "Ingrese el nombre del colaborador"]);
            }

            if(!is_string($request->nombre)){
                return response()->json(["resp" => "El nombre debe ser una cadena de texto"]);
            }

            $nombreCompleto = $request->nombre;

            $colaboradores = Colaboradores::with([
                'candidatos' => function ($query) {
                    $query->select('id', 'nombre', 'apellido', 'dni', 'direccion', 'fecha_nacimiento', 'ciclo_de_estudiante', 'estado', 'institucion_id', 'carrera_id');
                }
            ])
                ->whereHas('candidatos', function ($query) use ($nombreCompleto) {
                    $query->where(DB::raw("CONCAT(nombre, ' ', apellido)"), 'like', '%' . $nombreCompleto . '%');
                })
                ->where('estado', true)
                ->get();

            return response()->json(["data" => $colaboradores, "conteo" => $colaboradores->count()]);
        } catch(Exception $e){
            return response()->json(["error" => $e]);
        }

    }
}
