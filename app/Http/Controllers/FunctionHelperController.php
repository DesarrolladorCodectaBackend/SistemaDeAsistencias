<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Colaboradores_por_Area;
use App\Models\Horario_Presencial_Asignado;
use App\Models\Semanas;
use Illuminate\Http\Request;

class FunctionHelperController extends Controller
{
    //COLABORADORES

    public static function colaboradoresConArea($colaboradoresBase){
        $colaboradoresConArea = [];

        foreach ($colaboradoresBase as $colaborador) {
            $colaboradorArea = Colaboradores_por_Area::with('area')->where('colaborador_id', $colaborador->id)->where('estado', true)->get();
            if (count($colaboradorArea)>0) {
                $areas = [];

                foreach($colaboradorArea as $colArea){
                    $areas[] = $colArea->area->especializacion;
                }
                $colaborador->areas = $areas;
            } else {
                $colaborador->areas = ['Sin área asignada'];
            }
            $colaboradoresConArea[] = $colaborador;
        }
        return $colaboradoresConArea;
    }
    //PAGINATION
    public static function getPageData($collection){
        $pageData = [
            'currentPage' => $collection->currentPage(),
            'currentURL' => $collection->url($collection->currentPage()),
            'lastPage' => $collection->lastPage(),
            'nextPageUrl' => $collection->nextPageUrl(),
            'previousPageUrl' => $collection->previousPageUrl(),
            'lastPageUrl' => $collection->url($collection->lastPage()),
        ];
        $pageData = json_decode(json_encode($pageData));
        return $pageData;
    }

    //TIME
    public static function getYears()
    {
        $TotalSemanas = Semanas::get();
        $Years = [];

        foreach ($TotalSemanas as $semana) {
            $semanaYear = date('Y', strtotime($semana->fecha_lunes));
            if (!in_array($semanaYear, $Years)) {
                $Years[] = $semanaYear;
            }
        }

        return $Years;
    }

    public static function getMonths()
    {
        $Meses = [
            "Enero" => ["nombre" => "Enero", "id" => "01"],
            "Febrero" => ["nombre" => "Febrero", "id" => "02"],
            "Marzo" => ["nombre" => "Marzo", "id" => "03"],
            "Abril" => ["nombre" => "Abril", "id" => "04"],
            "Mayo" => ["nombre" => "Mayo", "id" => "05"],
            "Junio" => ["nombre" => "Junio", "id" => "06"],
            "Julio" => ["nombre" => "Julio", "id" => "07"],
            "Agosto" => ["nombre" => "Agosto", "id" => "08"],
            "Septiembre" => ["nombre" => "Septiembre", "id" => "09"],
            "Octubre" => ["nombre" => "Octubre", "id" => "10"],
            "Noviembre" => ["nombre" => "Noviembre", "id" => "11"],
            "Diciembre" => ["nombre" => "Diciembre", "id" => "12"],
        ];

        return $Meses;
    }

    public static function getDays(){
        $days = [
            "Lunes",
            "Martes",
            "Miércoles",
            "Jueves",
            "Viernes",
            "Sábado",
            "Domingo"
        ];

        return $days;
    }

    /**
     * RETORNA LAS ÁREAS CONCURRENTES
     * REQUIERE DE UN ARRAY DENTRO DE ESTE EL OBJETO AREA QUE ES OBLIGATORIO
     * SE LE PUEDEN ESPECIFICAR SI SE QUIERE REGRESAR LAS ÁREAS INCLUYENDO ESTA Y SI SOLO RETORNAR ÁREAS ACTIVAS O NO
     * POR DEFECTO REGRESA LAS ÁREAS INCLUYENDO ESTA Y TODAS LAS AREAS INDEFERENTEMENTE DE SU ESTADO
     */
    public static function getAreasConcurrentes($array = ["area" => null, "WithThis" => true, "active" => false]){
        //Obtener el área
        // return $array;
        if($array['area'] && $array['area'] != null){
            $area = $array['area'];
            //Obtener los horarios id del área
            $horariosArea = Horario_Presencial_Asignado::where('area_id', $area->id)->get()->pluck('horario_presencial_id');
            //Buscar otras areas con el mismo horario
            $allAreasConcurrentesId = Horario_Presencial_Asignado::with('area')->whereIn('horario_presencial_id', $horariosArea)->get()->pluck('area_id');
            //Buscar todas las áreas con esos Id
            if(isset($array['WithThis'])){
                if($array['WithThis'] == true) {
                    //absolutamente todas las área concurrentes
                    $allAreasConcurrentes = Area::whereIn('id', $allAreasConcurrentesId)->get();
                } else{
                    //Todas las áreas concurrentes menos la que se está buscando
                    $allAreasConcurrentes = Area::whereIn('id', $allAreasConcurrentesId)->whereNot('id', $area->id)->get();
                }
            } else{
                $allAreasConcurrentes = Area::whereIn('id', $allAreasConcurrentesId)->get();
            }
            //Las areas tienen que ser del mismo salón para ser concurrentes
            $allAreasConcurrentesSalon = $allAreasConcurrentes->where('salon_id', $area->salon_id);
            //ver si se quiere que sean activas o no
            if(isset($array['active'])){
                if($array['active'] == true){
                    $allActiveAreasConcurrentes = $allAreasConcurrentesSalon->where('estado', 1);
                    return $allActiveAreasConcurrentes;
                } else{
                    return $allAreasConcurrentesSalon;
                }
            } else{
                return $allAreasConcurrentesSalon;
            }
        }
    }

}
