<?php

namespace App\Http\Controllers;

use App\Models\Colaboradores_por_Area;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class ColaboradoresPorAreaController extends Controller
{
    
    public function index()
    {
        try{
            $Colabs_Area = Colaboradores_por_Area::/*with([
                'colaboradores' => function($query){$query->select('id', 'candidato_id');},
                'area' => function($query){$query->select('id', 'especializacion', 'color_hex');}])->*/get();
            
            if (count($Colabs_Area) == 0){
                return response()->json(["resp" => "No hay registros insertados"]);
            }

            return response()->json(["data" => $Colabs_Area, "conteo" => count($Colabs_Area)]);
        } catch(Exception $e){
            return response()->json(["error" => $e]);
        }
    }

    
    public function store(Request $request)
    {
        DB::beginTransaction();
        try{
            if(!$request->colaborador_id){
                return response()->json(["resp" => "Ingrese colaborador"]);
            }
            
            if(!$request->area_id){
                return response()->json(["resp" => "Ingrese area"]);
            }

            if(!$request->semana_inicio_id){
                return response()->json(["resp" => "Ingrese semana inicio"]);
            }

            if(!is_integer($request->colaborador_id)){
                return response()->json(["resp" => "El id del colaborador debe ser un número entero"]);
            }
            
            if(!is_integer($request->area_id)){
                return response()->json(["resp" => "El id del area debe ser un número entero"]);
            }
            
            if(!is_integer($request->semana_inicio_id)){
                return response()->json(["resp" => "El id de la semana inicio debe ser un número entero"]);
            }

            Colaboradores_por_Area::create([
                "colaborador_id" => $request->colaborador_id,
                "area_id" => $request->area_id,
                "semana_inicio_id" => $request->semana_inicio_id
            ]);
            DB::commit();
            return response()->json(["resp" => "Registro creado correctamente"]);
        } catch (Exception $e){
            DB::rollBack();
            return response()->json(["error" => $e]);
        }

    }

    
    public function show($colaborador_por_area_id)
    {
        try{
            $colaborador_por_area = Colaboradores_por_Area::/*with([
                'colaboradores' => function($query){$query->select('id', 'candidato_id');},
                'area' => function($query){$query->select('id', 'especializacion', 'color_hex');}])
                ->*/find($colaborador_por_area_id);

            if(!$colaborador_por_area){
                return response()->json(["resp" => "No existe un registro con ese id"]);
            }

            return response()->json(["data" => $colaborador_por_area]);
        } catch(Exception $e){
            return response()->json(["resp" => $e]);
        }
    }

    
    public function update(Request $request, $colaborador_por_area_id)
    {
        DB::beginTransaction();
        try{
            $colaborador_por_area = Colaboradores_por_Area::find($colaborador_por_area_id);

            if(!$colaborador_por_area){
                return response()->json(["resp" => "No existe un registro con ese id"]);
            }

            if(!$request->colaborador_id){
                return response()->json(["resp" => "Ingrese colaborador"]);
            }
            
            if(!$request->area_id){
                return response()->json(["resp" => "Ingrese area"]);
            }

            if(!$request->semana_inicio_id){
                return response()->json(["resp" => "Ingrese semana inicio"]);
            }

            if(!is_integer($request->colaborador_id)){
                return response()->json(["resp" => "El id del colaborador debe ser un número entero"]);
            }
            
            if(!is_integer($request->area_id)){
                return response()->json(["resp" => "El id del area debe ser un número entero"]);
            }
            
            if(!is_integer($request->semana_inicio_id)){
                return response()->json(["resp" => "El id de la semana inicio debe ser un número entero"]);
            }

            $colaborador_por_area->fill([
                "colaborador_id" => $request->colaborador_id,
                "area_id" => $request->area_id,
                "semana_inicio_id" => $request->semana_inicio_id
            ])->save();
            DB::commit();
            return response()->json(["resp" => "Registro actualizado correctamente"]);
        } catch(Exception $e){
            DB::rollBack();
            return response()->json(["error" => $e]);
        }
    }

    
    public function destroy($colaborador_por_area_id)
    {
        DB::beginTransaction();
        try{
            $colaborador_por_area = Colaboradores_por_Area::find($colaborador_por_area_id);

            if(!$colaborador_por_area){
                return response()->json(["resp" => "No existe un registro con ese id"]);
            }

            $colaborador_por_area->delete();
            DB::commit();
            return response()->json(["resp" => "Registro eliminado correctamente"]);
        } catch (Exception $e){
            DB::rollBack();
            return response()->json(["error" => $e]);
        }
    }
}
