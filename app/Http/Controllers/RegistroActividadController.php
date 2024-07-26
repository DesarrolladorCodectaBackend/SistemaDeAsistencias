<?php

namespace App\Http\Controllers;

use App\Models\Colaboradores_por_Area;
use App\Models\Semanas;
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

    public function obtenerInactividad($colaboradorAreaId){
        $registros = RegistroActividad::where('colaborador_area_id', $colaboradorAreaId)->get();
        // return $registros;
        $inactividades = [];
        /*
        cada objeto debe tener algo como esto:
        {
            desde: 2024-04-20, //fecha del registro si estado = 0
            hasta: 2024-06-20, //fecha del registro si estado = 1
            semanas: [ //Datos de la tabla semana que entren en el rango de fechas
                {
                    id: 1,
                    fecha_lunes: 2024-04-15
                },
                {
                    id: 2,
                    fecha_lunes: 2024-04-22
                },
            ]
        }
        */
        $inactividadActual = null;

        foreach ($registros as $registro) {
            if ($registro->estado == 0) {
                // Si no hay una inactividad actual en curso, inicia una nueva
                if ($inactividadActual === null) {
                    $inactividadActual = [
                        'desde' => $registro->fecha,
                        'hasta' => null,
                        'semanas' => [],
                    ];
                }
            } else if ($registro->estado == 1) {
                // Si hay una inactividad actual en curso, finalízala
                if ($inactividadActual !== null) {
                    $inactividadActual['hasta'] = $registro->fecha;
                    $desde = $inactividadActual['desde'];
                    $hasta = $inactividadActual['hasta'];
                    //transformar desde a un tipo date
                    
                    // $desde = Carbon::parse($desde);
                    $semanaDesde = $this->getSemanaByDay($desde);
                    // $hasta = Carbon::parse($hasta);
                    $semanaHasta = $this->getSemanaByDay($hasta);
                    $semanasId = [];
                    return [$semanaDesde, $semanaHasta];
                    $inactividades[] = $inactividadActual;
                    $inactividadActual = null;
                }
            }
        }

        // Si al final del procesamiento aún hay una inactividad en curso
        if ($inactividadActual !== null) {
            $inactividadActual['hasta'] = null; // Indefinida
            $inactividades[] = $inactividadActual;
        }

        return $inactividades;

    }

    public function getSemanaByDay($date){
        $date = Carbon::parse($date);
        $semanaDate = $date;
        if(($date->isMonday()) || ($date->isTuesday()) || ($date->isWednesday())){
            $semanaDate = $date->copy()->startOfWeek();
        } else{
            while(!$semanaDate->isMonday()){
                $semanaDate->addDay();
            }
        }
        $semana = Semanas::where('fecha_lunes', $semanaDate->toDateString())->first();
        return $semana;
    }
}
