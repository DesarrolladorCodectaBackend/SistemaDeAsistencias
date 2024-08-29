<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Colaboradores_por_Area;
use App\Models\Cumplio_Responsabilidad_Semanal;
use App\Models\Horario_Presencial_Asignado;
use App\Models\Horarios_Presenciales;
use App\Models\Responsabilidades_semanales;
use App\Models\Semanas;
use App\Models\ReunionesProgramadas;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomePageController extends Controller
{
    public function home(){
        $areasProm = $this->getMonthPromAreas();
        $reunionesProgramadas = $this->getTodayProgramReu();
        $areas = $this->getAreasToday();
        return view('dashboard', [
            'areasProm' => $areasProm,
            'reunionesProgramadas' => $reunionesProgramadas,
            'areas' => $areas
        ]);
    }

    function getMonthPromAreas(){
        $areas = Area::where('estado', 1)->get();
        $responsabilidades = Responsabilidades_semanales::get();
        $today = Carbon::now()->format('Y-m-d');
        //verifica que no nos encontremos en la primera semana del mes
        //si estamos en la primera semana de
        $mes = date('m', strtotime($today));
        $year = date('Y', strtotime($today));
        $thisWeek = FunctionHelperController::findThisWeek();
        if($thisWeek){
            $semanaPasada = Semanas::where('id', $thisWeek->id-1)->first();
            //  $semanaPasada;
            if($semanaPasada){
                $fecha = $semanaPasada->fecha_lunes;
                $mesSemanaPasada = date('m', strtotime($fecha));
                $yearSemanaPasada = date('Y', strtotime($fecha));
                //verificar si son del mismo año
                if($yearSemanaPasada == $year){
                    //verificar si son del mismo mes
                    if($mesSemanaPasada != $mes){
                        $mes = $mesSemanaPasada;
                    }
                }else{
                    $mes = $mesSemanaPasada;
                    $year = $yearSemanaPasada;
                }
            }
        }
        
        $Meses = FunctionHelperController::getMonths();
        $semanasTotales = Semanas::get();

        $semanasMes = [];

        foreach ($Meses as $Month) {
            if ($Month['id'] == $mes) {
                foreach ($semanasTotales as $semana) {
                    $mesFecha = date('m', strtotime($semana->fecha_lunes));
                    $yearFecha = date('Y', strtotime($semana->fecha_lunes));
                    if ($mesFecha == $Month['id'] && $yearFecha == $year) {
                        $semanasMes[] = $semana;
                    }
                }
            }
        }
        
        $totalSemanas = count($semanasMes);
        $areasProm = [];
        foreach ($areas as $area) {
            $area_id = $area->id;
            $colaboradoresMes = [];
            foreach ($semanasMes as $semana) {
                $colaboradoresArea = Colaboradores_por_Area::where('area_id', $area_id)->where('semana_inicio_id', '<=', $semana->id)->with('colaborador', 'semana')->get();
                $colaboradoresAreaId = $colaboradoresArea->pluck('id');
                $colaboradoresActivosId = [];
                $countColabsActivos = 0;
                foreach($colaboradoresAreaId as $colabAreaId){
                    $inactividades = RegistroActividadController::obtenerInactividad($colabAreaId);
                    $activo = true;
                    foreach($inactividades as $inactividad){
                        $semanasInactivas = $inactividad['semanas'];
                        foreach($semanasInactivas as $semanaInactiva){
                            if($semana->id === $semanaInactiva['id']){
                                $activo = false;
                                break 2;
                            }
                        }
                    }
                    // Si el colaborador está activo, añadirlo al array temporal
                    if ($activo === true) {
                        $colaboradoresActivosId[] = $colabAreaId;
                        $countColabsActivos++;
                    }
                }
                $colaboradoresActivosToAdd = Colaboradores_por_Area::whereIn('id', $colaboradoresActivosId)->get();
                
                foreach ($colaboradoresActivosToAdd as $colaboradorActivoToAdd) {
                    $semanaCumplida = Cumplio_Responsabilidad_Semanal::where("semana_id", $semana->id)->where("colaborador_area_id", $colaboradorActivoToAdd->id)->first();
                    // return $semanaCumplida;
                    // Verificar si el colaborador ya está en $colaboradoresMes
                    if($semanaCumplida){
                        $existe = false;
                        foreach ($colaboradoresMes as &$colaboradorMes) {
                            if ($colaboradorMes['id'] === $colaboradorActivoToAdd->id) {
                                $colaboradorMes['semanasCount']++;
                                $colaboradorMes['semanas'][] = $semana->id;
                                $existe = true;
                                break;
                            }
                        }
                        
                        // Si el colaborador no está en $colaboradoresMes, agregarlo
                        if (!$existe) {
                            $candidato = $colaboradorActivoToAdd->colaborador->candidato;
                            $colaboradoresMes[] = [
                                'id' => $colaboradorActivoToAdd->id,
                                'semanasCount' => 1,
                                'semanas' => [$semana->id],
                                'colaborador' => $colaboradorActivoToAdd,
                                'nombre' => $candidato->nombre . ' ' . $candidato->apellido,
                            ];
                        }
                    }
                }
            }
            // if(count($colaboradoresMes) > 0){
            //     return $colaboradoresMes;
            // }
            // Obtener la suma de sus notas
            foreach ($colaboradoresMes as $index => &$colaboradorMes) {
                // Inicializar sumNotes con todas las responsabilidades en 0
                $sumNotes = [];
                foreach ($responsabilidades as $responsabilidad) {
                    $nombreResponsabilidad = $responsabilidad->nombre;
                    $sumNotes[$nombreResponsabilidad] = 0;
                }
                foreach ($colaboradorMes['semanas'] as $semanaId) {
                    $registrosCumplidosSemana = Cumplio_Responsabilidad_Semanal::where('semana_id', $semanaId)
                        ->where('colaborador_area_id', $colaboradorMes['id'])
                        ->get();
                    
                    foreach ($registrosCumplidosSemana as $registro) {
                        $valorCumplio = $registro->cumplio == 1 ? 20 : 0;
                        
                        foreach($responsabilidades as $responsabilidad){
                            if($responsabilidad->id == $registro->responsabilidad_id) {
                                $nombreResponsabilidad = $responsabilidad->nombre;
                                $sumNotes[$nombreResponsabilidad] += $valorCumplio;
                            }
                        }
                    }
                }
                // Agregar el array $sumNotes al array $colaboradorMes['sumNotas']
                $colaboradorMes['sumNotas'] = $sumNotes;
            }
            unset($colaboradorMes); // Unset the reference
    
            // return $colaboradoresMes;
            
            //Dividir la suma maxima de las notas por la cantidad de semanas para obtener el promedio de cada responsabilidad
            foreach ($colaboradoresMes as $index => $colaboradorMes) {
                // Inicializar promNotes con todas las responsabilidades en 0
                $semanasCount = $colaboradoresMes[$index]['semanasCount'];
                $PromNotas = [];
                foreach (array_keys($colaboradoresMes[$index]['sumNotas']) as $responsabilidad) {
                    $PromNotas[$responsabilidad] = number_format(($colaboradoresMes[$index]['sumNotas'][$responsabilidad]) / $semanasCount, 1);
                }
                $colaboradoresMes[$index]['promedio'] = $PromNotas;
                //Total suma de todas las responsabilidades entre el conteo de estas para obtener el promedio general del colaborador en el mes
                $colaboradoresMes[$index]['total'] = number_format((array_sum($PromNotas))/$responsabilidades->count(),1);
                
            }
            if(count($colaboradoresMes) > 0){
                $areaTotal = 0;
                $areaProm = 0;
                foreach($colaboradoresMes as $index => $colaboradorMes){
                    $areaTotal += $colaboradoresMes[$index]['total'];
                }
                $areaProm = number_format($areaTotal / count($colaboradoresMes), 0);
                $areasProm[] = [
                    "area" => $area,
                    "promedio" => $areaProm
                ];
            }
            // return $areaProm;

            // if(count($colaboradoresMes) > 0){
            //     return $colaboradoresMes;
            // }
        }
        return $areasProm;
    }

    function getTodayProgramReu(){
        $today = Carbon::now()->format('Y-m-d');
        // return $today;
        $reunionesProgramadas = ReunionesProgramadas::where('fecha', $today)->get();
        foreach ($reunionesProgramadas as $horario) {
            $horaInicial = (int) date('H', strtotime($horario->hora_inicial));
            $horaFinal = (int) date('H', strtotime($horario->hora_final));
            $year = date('Y', strtotime($horario->fecha));
            $month = date('m', strtotime($horario->fecha));
            $day = date('d', strtotime($horario->fecha));

            $month = $month -1;
    
            $horariosFormateados = [
                'hora_inicial' => $horaInicial,
                'hora_final' => $horaFinal,
                'year' => $year,
                'month' => $month,
                'day' => $day,
                'url' => route('reunionesProgramadas.show', $horario->id),
            ];
            $horario->horario_modificado = $horariosFormateados;
        }
        return $reunionesProgramadas;
    }

    function getAreasToday(){
        $dia_today = Carbon::now()->format('l');
        $dias = [
            "Monday" => "Lunes", 
            "Tuesday" => "Martes", 
            "Wednesday" => "Miércoles", 
            "Thursday" => "Jueves", 
            "Friday" => "Viernes", 
            "Saturday" => "Sábado", 
            "Sunday" => "Domingo"
        ];
        
        $dia_español = $dias[$dia_today];
        $horariosToday = Horarios_Presenciales::where('dia', $dia_español)->get();
        $horariosAreasToday = Horario_Presencial_Asignado::with('area', 'horario_presencial')->whereIn('horario_presencial_id', $horariosToday->pluck('id'))->get();
        $areasToday = [];
        foreach($horariosAreasToday as $horario){
            if($horario->area->estado == 1){
                $horaInicial = (int) date('H', strtotime($horario->horario_presencial->hora_inicial));
                $horaFinal = (int) date('H', strtotime($horario->horario_presencial->hora_final));
                $areasToday[] = 
                    [
                        'especializacion' => $horario->area->especializacion,
                        'color' => $horario->area->color_hex,
                        'hora_inicial' => $horaInicial,
                        'hora_final' => $horaFinal,
                        'url' => route('areas.getHorario', $horario->area->id),
                    ];
            }
        }
        
        return $areasToday;
    }

}
