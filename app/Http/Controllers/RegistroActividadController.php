<?php

namespace App\Http\Controllers;

use App\Models\Colaboradores_por_Area;
use Illuminate\Http\Request;
use App\Models\RegistroActividad;
use Illuminate\Support\Facades\DB;
use Exception;
use Carbon\Carbon;

class RegistroActividadController extends Controller
{
    public static function crearRegistro($colaboradorArea_id, $estado){
        DB::beginTransaction();
        try{
            $today = Carbon::today();
            // return $today->toDateString();
            $colaboradorArea = Colaboradores_por_Area::findOrFail($colaboradorArea_id);
            if($colaboradorArea){
                RegistroActividad::create([
                    'colaborador_area_id' => $colaboradorArea_id,
                    'estado' => $estado,
                    'fecha' => $today->toDateString(),
                ]);
                DB::commit();
                return response()->json(['status' => true, 'message' => 'registro creado exitosamente']);
            } else{
                DB::commit();
                return response()->json(['status' => false, 'message' => 'No se encontró el colaborador Area con ese Id']);

            }
        } catch(Exception $e){
            DB::rollBack();
            return response()->json(['status' => false,'message'=> $e->getMessage()]);
        }
    }
}
