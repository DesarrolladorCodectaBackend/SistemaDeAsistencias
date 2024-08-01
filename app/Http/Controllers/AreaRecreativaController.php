<?php

namespace App\Http\Controllers;

use App\Models\AreaRecreativa;
use Illuminate\Http\Request;

class AreaRecreativaController extends Controller
{
    public static function getColabActividades($colaboradores){
        $colabsConActividades = [];

        foreach($colaboradores as $colaborador){
            $colabActividades = AreaRecreativa::with('actividad')->where('colaborador_id', $colaborador->id)->where('estado', 1)->get();

            if($colabActividades->count() > 0){
                $actividades = [];
                foreach($colabActividades as $acti){
                    $actividades[] = $acti->actividad->nombre;
                }
                $colaborador->actividadesFavoritas = $actividades;
            } else {
                $colaborador->actividadesFavoritas = ['Sin actividades favoritas'];
            }
            $colabsConActividades[] = $colaborador;
        }
        return $colabsConActividades;
    }
}
