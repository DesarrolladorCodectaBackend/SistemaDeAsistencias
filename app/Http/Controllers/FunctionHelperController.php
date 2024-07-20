<?php

namespace App\Http\Controllers;

use App\Models\Colaboradores_por_Area;
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
}
