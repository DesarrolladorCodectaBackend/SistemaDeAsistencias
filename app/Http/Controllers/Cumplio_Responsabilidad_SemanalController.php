<?php

namespace App\Http\Controllers;

use App\Models\Colaboradores;
use App\Models\Responsabilidades_semanales;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Cumplio_Responsabilidad_Semanal;
use App\Models\Area;
use App\Models\Semanas;
use App\Models\Colaboradores_por_Area;
use App\Models\InformeSemanal;
use App\Models\RegistroResponsabilidad;
use Illuminate\Support\Facades\DB;
use Exception;


class Cumplio_Responsabilidad_SemanalController extends Controller
{
    public function index()
    {
        $userData = FunctionHelperController::getUserRol();
        if ($userData['isAdmin']) {
            $areas = Area::with('salon')->where('estado', 1)->paginate(12);
        } else if ($userData['isBoss']) {
            $bossAreasId = $userData['Jefeareas']->pluck('area_id');
            // return $bossAreasId;
            $areas = Area::with('salon')->where('estado', 1)->whereIn('id', $bossAreasId)->paginate(12);
        } else {
            return redirect()->route('dashboard')->with('error', 'No es un usuario con permisos para evaluar áreas. No lo intente denuevo o puede ser baneado.');
        }

        $Years = FunctionHelperController::getYears();
        $countYears = count($Years);
        $currentYear = last($Years);

        $pageData = FunctionHelperController::getPageData($areas);
        $hasPagination = true;

        return view('inspiniaViews.responsabilidades.index', [
            'countYears' => $countYears,
            'currentYear' => $currentYear,
            'areas' => $areas,
            'hasPagination' => $hasPagination,
            'pageData' => $pageData,
        ]);
    }

    public function getYearsArea($area_id)
    {
        $access = FunctionHelperController::verifyAreaAccess($area_id);

        if (!$access) {
            return redirect()->route('dashboard')->with('error', 'No es un usuario con permisos para evaluar esa area. No lo intente denuevo o puede ser baneado.');
        }

        $Years = FunctionHelperController::getYears();

        return view(
            'inspiniaViews.responsabilidades.years',
            [
                'area_id' => $area_id,
                'Years' => $Years
            ]
        );
    }

    public function getMesesAreas($year, $area_id)
    {
        $access = FunctionHelperController::verifyAreaAccess($area_id);

        if (!$access) {
            return redirect()->route('dashboard')->with('error', 'No es un usuario con permisos para evaluar esa area. No lo intente denuevo o puede ser baneado.');
        }

        $Meses = FunctionHelperController::getMonths();

        $area = Area::findOrFail($area_id);

        $colaboradoresArea = Colaboradores_por_Area::where('area_id', $area_id)->get();
        $colaboradoresAreaIds = $colaboradoresArea->pluck('id');

        $Cumplio_res_Area = Cumplio_Responsabilidad_Semanal::with('semana')
            ->whereIn('colaborador_area_id', $colaboradoresAreaIds)
            ->get();

        $agrupadosPorMes = [];

        foreach ($Meses as $mes) {
            $agrupadosPorMes[$mes['nombre']] = [
                'tipo' => 'Accesible',
                'total_semanas' => 0,
                'semanas_evaluadas' => 0,
                'semanas_sin_evaluar' => 0,
            ];
        }

        $semanasTotales = Semanas::get();
        $lastWeek = $semanasTotales->last();

        foreach ($Meses as $mes) {
            $semanasMes = $semanasTotales->filter(function ($semana) use ($mes, $year) {
                return date('Y', strtotime($semana->fecha_lunes)) == $year &&
                    date('m', strtotime($semana->fecha_lunes)) == $mes['id'];
            });

            foreach ($semanasMes as $index => $semana) {
                $colaboradoresArea = Colaboradores_por_Area::where('area_id', $area_id)->where('semana_inicio_id', '<=', $semana->id)->with('colaborador', 'semana')->get();
                $colaboradoresAreaId = $colaboradoresArea->pluck('id');
                $colaboradoresActivosId = [];
                $countColabsActivos = 0;
                foreach ($colaboradoresAreaId as $colabKey => $colabAreaId) {
                    $inactividades = RegistroActividadController::obtenerInactividad($colabAreaId);
                    $activo = true;
                    foreach ($inactividades as $inactividad) {
                        $semanasInactivas = $inactividad['semanas'];
                        foreach ($semanasInactivas as $semanaInactiva) {
                            if ($semana->id === $semanaInactiva['id']) {
                                $activo = false;
                                break 2;
                            }
                        }
                    }
                    if ($activo === true) {
                        $colaboradoresActivosId[] = $colabAreaId;
                        $countColabsActivos++;
                    }
                }
                if ($countColabsActivos < 1) {
                    unset($semanasMes[$index]);
                }
            }

            if ($semanasMes->count() <= 0) {
                //VERIFICAR SI ES UN MES ANTERIOR AL AREA O SI AUN ES PROXIMO, DE CASO CONTRARIO, SERA ACCESIBLE
                if (date('Y', strtotime($lastWeek->fecha_lunes)) < $year) {
                    $agrupadosPorMes[$mes['nombre']]['tipo'] = 'Próximo';
                } elseif (date('Y', strtotime($lastWeek->fecha_lunes)) == $year) {
                    if (date('m', strtotime($lastWeek->fecha_lunes)) < $mes['id']) {
                        $agrupadosPorMes[$mes['nombre']]['tipo'] = 'Próximo';
                    } else {
                        $agrupadosPorMes[$mes['nombre']]['tipo'] = 'Anterior';
                    }
                } else {
                    $agrupadosPorMes[$mes['nombre']]['tipo'] = 'Anterior';
                }
            }
            $agrupadosPorMes[$mes['nombre']]['total_semanas'] = $semanasMes->count();

            $semanasEvaluadas = $Cumplio_res_Area->filter(function ($registro) use ($semanasMes) {
                return $semanasMes->contains('id', $registro->semana->id);
            })->unique('semana_id')->count();

            $agrupadosPorMes[$mes['nombre']]['semanas_evaluadas'] = $semanasEvaluadas;
            $agrupadosPorMes[$mes['nombre']]['semanas_sin_evaluar'] = $agrupadosPorMes[$mes['nombre']]['total_semanas'] - $semanasEvaluadas;
        }
        // return $agrupadosPorMes;
        return view('inspiniaViews.responsabilidades.meses', ['area_id' => $area_id, 'year' => $year], compact('agrupadosPorMes'));
    }

    public function getFormAsistencias($year, $mes, $area_id)
    {
        $access = FunctionHelperController::verifyAreaAccess($area_id);

        if (!$access) {
            return redirect()->route('dashboard')->with('error', 'No es un usuario con permisos para evaluar esa area. No lo intente denuevo o puede ser baneado.');
        }
        //$area_id = $request->area_id;
        $area = Area::findOrFail($area_id);
        // $responsabilidades = Responsabilidades_semanales::get();
        $responsabilidades = Responsabilidades_semanales::get();

        //Estado 2 en colaboradores será igual a que ha sido despedido o que ya no pertenece a la empresa
        // $colaboradoresRemanentes = Colaboradores::where('estado', 1)->get()->pluck('id'); //SOLO MOSTRAR A LOS ACTIVOS, NO INACTIVOS NI EX COLABORADORES
        // $colaboradoresArea = Colaboradores_por_Area::where('area_id', $area_id)->where('estado', 1)->whereIn('colaborador_id', $colaboradoresRemanentes)->with('colaborador')->get();
        // $colaboradoresAreaId = $colaboradoresArea->pluck('id');

        $Meses = FunctionHelperController::getMonths();

        //Obtener las semanas del mes
        $semanasMes = [];
        $semanasMesId = [];
        $semanasTotales = Semanas::get();

        $informesSemanales = InformeSemanal::get();
        // return $informesSemanales;
        foreach ($Meses as $Month) {
            if ($Month['nombre'] === $mes) {
                foreach ($semanasTotales as $semana) {
                    $mesFecha = date('m', strtotime($semana->fecha_lunes));
                    $yearFecha = date('Y', strtotime($semana->fecha_lunes));
                    if ($mesFecha == $Month['id'] && $yearFecha == $year) {
                        $semanasMes[] = $semana;
                        $semanasMesId[] = $semana->id;
                    }
                }
            }
        }


        $colaboradoresArea = [];
        // Definir semanas cumplidas
        // definir las responsabilidades
        foreach ($semanasMes as $index => &$semana) {
            // return $semana;
            //Añadir informes semanales de esta semana y area
            $informesSemanalesArea = InformeSemanal::where('semana_id', $semana->id)->where('area_id', $area_id)->get();
            //agregar como array key de esta semana
            $semana->informesSemanales = $informesSemanalesArea;
            $colaboradoresArea = Colaboradores_por_Area::where('area_id', $area_id)->where('semana_inicio_id', '<=', $semana->id)->with('colaborador', 'semana')->get();
            $colaboradoresAreaId = $colaboradoresArea->pluck('id');
            $colaboradoresActivosId = [];
            $responsabilidadesSemana = [];

            $datosSemana = FunctionHelperController::getWeekFromToDisponible($semana->id);
            //Fecha desde
            $semana->desde = $datosSemana['desde'];
            //Fecha hasta
            $semana->hasta = $datosSemana['hasta'];
            //Disponible
            $semana->disponible = $datosSemana['disponible'];

            foreach($responsabilidades as $responsabilidad){
                $activo = RegistroResponsabilidadController::verifyResponsabilidadInactivity($responsabilidad->id, $semana->id);
                if($activo){
                    $responsabilidadesSemana[] = $responsabilidad;
                }
            }
            $semana->responsabilidades = $responsabilidadesSemana;

            $countColabsActivos = 0;
            foreach ($colaboradoresAreaId as $colabKey => $colabAreaId) {
                $inactividades = RegistroActividadController::obtenerInactividad($colabAreaId);
                $activo = true;
                foreach ($inactividades as $inactividad) {
                    $semanasInactivas = $inactividad['semanas'];
                    foreach ($semanasInactivas as $semanaInactiva) {
                        if ($semana->id === $semanaInactiva['id']) {
                            // $colaboradoresAreaId->forget($colabKey);
                            //$colaboradoresOtherAreas->forget($key);
                            // echo "here" + $colabAreaId;
                            $activo = false;
                            break 2; // Salir de ambos bucles si el colaborador está inactivo
                        }
                    }
                }
                // Si el colaborador está activo, añadirlo al array temporal
                if ($activo === true) {
                    // echo $colabAreaId;
                    $colaboradoresActivosId[] = $colabAreaId;
                    $countColabsActivos++;
                }
            }
            $colaboradoresActivosToAdd = Colaboradores_por_Area::whereIn('id', $colaboradoresActivosId)->get();
            $semana->colaboradores = $colaboradoresActivosToAdd;
            // return $countColabsActivos;


            $semanaCumplida = Cumplio_Responsabilidad_Semanal::where("semana_id", $semana->id)->whereIn("colaborador_area_id", $colaboradoresActivosId)->first();
            if ($semanaCumplida) {
                $semana->cumplido = true;
            } else {
                $semana->cumplido = false;
            }

            if ($countColabsActivos < 1) {
                unset($semanasMes[$index]);
            }
        }
        $semanasMes = array_values($semanasMes);
        // return $semanasMes;
        // return $semanasMes;
        $registros = Cumplio_Responsabilidad_Semanal::get();
        $comeBackUri = route('responsabilidades.meses', ["year" => $year, "area_id" => $area_id]);
        //return $semanasCumplidas;
        //return $semanasMes;
        //return $registros;
        // return response()->json(['year' => $year, 'mes' => $mes, 'registros' => $registros, 'area' => $area, 'responsabilidades' => $responsabilidades,
        //     'colaboradoresArea' => $colaboradoresArea, 'semanasMes' => $semanasMes, 'informesSemanales' => $informesSemanales]);
        return view('inspiniaViews.responsabilidades.asistencia', [
            'year' => $year,
            'mes' => $mes,
            'registros' => $registros,
            'area' => $area,
            'responsabilidades' => $responsabilidades,
            'colaboradoresArea' => $colaboradoresArea,
            'semanasMes' => $semanasMes,
            'informesSemanales' => $informesSemanales,
            'comeBackUri' => $comeBackUri,
        ]);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {

            $request->validate([
                'colaborador_area_id.*' => 'required|integer|min:1|max:100',
                'responsabilidad_id.*' => 'required|integer|min:1|max:255',
                'semana_id' => 'required|integer|min:1|max:100',
                'cumplio.*' => 'required|boolean|min:0|max:1',
                'year' => 'required|integer',
                'mes' => 'required|string',
                'area_id' => 'required|integer',
            ]);
            $year = $request->year;
            $mes = $request->mes;
            $area_id = $request->area_id;

            $access = FunctionHelperController::verifyAreaAccess($area_id);

            if (!$access) {
                return redirect()->route('dashboard')->with('error', 'No es un usuario con permisos para evaluar esa area. No lo intente denuevo o puede ser baneado.');
            }

            //Verificar que estemos en una semana posterior a la que se esta registrando, si no, no se puede registrar la semana.

            $thisWeekMonday = Carbon::today()->startOfWeek()->toDateString();
            $thisSemana = Semanas::where('fecha_lunes', $thisWeekMonday)->first();


            $semana = Semanas::find($request->semana_id);

            if ($semana->id >= $thisSemana->id) {
                DB::rollBack();
                return redirect()->route('responsabilidades.asis', ['year' => $year, 'mes' => $mes, 'area_id' => $area_id])
                    ->with('EvaluacionWarning', 'No se puede evaluar semanas que aún no concluyen.')->with('current_semana_id', $request->index);
            }

            $responsabilidades = Responsabilidades_semanales::get();
            // $responsabilidadesIds = $responsabilidades->pluck('id');
            $responsabilidadesSemana = [];
            foreach($responsabilidades as $resp){
                $activo = RegistroResponsabilidadController::verifyResponsabilidadInactivity($resp->id,$semana->id);
                if($activo){
                    $responsabilidadesSemana[] = $resp;
                }
            }

            $contador = 0;
            $indiceColab = 0;
            foreach ($request->responsabilidad_id as $keyResp => $responsabilidad_id) {
                $colaborador_area_id = $request->colaborador_area_id[$indiceColab];

                Cumplio_Responsabilidad_Semanal::create([
                    "colaborador_area_id" => $colaborador_area_id,
                    "responsabilidad_id" => $responsabilidad_id,
                    "semana_id" => $request->semana_id,
                    "cumplio" => $request->cumplio[$keyResp]
                ]);

                $contador++;

                if ($contador >= count($responsabilidadesSemana)) {
                    $contador = 0;
                    $indiceColab++;
                }
            }

            DB::commit();
            return redirect()->route('responsabilidades.asis', ['year' => $year, 'mes' => $mes, 'area_id' => $area_id])->with('success', 'Se guardó correctamente.');
        } catch (Exception $e) {
            // return $e;
            DB::rollback();
            return redirect()->route('responsabilidades.asis', ['year' => $request->$year, 'mes' => $request->$mes, 'area_id' => $request->$area_id])
                ->with('error', 'Ocurrió un error.');
        }
    }

    public function actualizar(Request $request, $semana_id, $area_id)
    {
        DB::beginTransaction();
        try {
            $access = FunctionHelperController::verifyAreaAccess($area_id);

            if (!$access) {
                return redirect()->route('dashboard')->with('error', 'No es un usuario con permisos para evaluar esa area. No lo intente denuevo o puede ser baneado.');
            }

            $request->validate([
                'colaborador_area_id.*' => 'sometimes|integer|min:1|max:100',
                'responsabilidad_id.*' => 'sometimes|integer|min:1|max:255',
                'cumplio.*' => 'sometimes|boolean|min:0|max:1',
                'year' => 'required|integer',
                'mes' => 'required|string',
            ]);
            $year = $request->year;
            $mes = $request->mes;

            $semana = Semanas::find($semana_id);
            $thisWeekMonday = Carbon::today()->startOfWeek()->toDateString();
            $thisSemana = Semanas::where('fecha_lunes', $thisWeekMonday)->first();
            //Verificar solo por si acaso
            if ($thisSemana->id > $semana->id) {
                $colaboradoresAreaId = Colaboradores_por_Area::where('area_id', $area_id)->get()->pluck('id');

                $registros = Cumplio_Responsabilidad_Semanal::where('semana_id', $semana_id)->whereIn('colaborador_area_id', $colaboradoresAreaId)->get();

                foreach ($registros as $index => $registro) {
                    $registro->cumplio = $request->cumplio[$index];
                    $registro->save();
                }
            }

            DB::commit();
            return redirect()->route('responsabilidades.asis', ['year' => $year, 'mes' => $mes, 'area_id' => $area_id])->with('success', 'Se guardó correctamente.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->route('responsabilidades.asis', ['year' => $year, 'mes' => $mes, 'area_id' => $area_id])->with('error', 'Ocurrió un error.');
        }
    }


    // public function destroy($cumplio_responsabilidad_semanal_id)
    // {
    //     $cumplio_responsabilidad_semanal = Cumplio_Responsabilidad_Semanal::findOrFail($cumplio_responsabilidad_semanal_id);

    //     $cumplio_responsabilidad_semanal->delete();

    //     return redirect()->route('cumplio_responsabilidad_semanal.index');
    // }


    public function getMonthProm($year, $mes, $area_id)
    {
        $access = FunctionHelperController::verifyAreaAccess($area_id);

        if(!$access){
            return redirect()->route('dashboard')->with('error', 'No es un usuario con permisos para ver esa area. No lo intente denuevo o puede ser baneado.');
        }
        $area = Area::findOrFail($area_id);
        $responsabilidades = Responsabilidades_semanales::get();

        $Meses = FunctionHelperController::getMonths();

        $semanasMes = [];

        foreach ($Meses as $Month) {
            if ($Month['nombre'] == $mes) {
                $semanasTotales = Semanas::get();
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

        $firstWeek = $semanasMes[0];
        $firstWeek->fecha_lunes = date("d/m/Y", strtotime($firstWeek->fecha_lunes));
        $lastWeek = end($semanasMes);
        $fechaFinal = strtotime($lastWeek->fecha_lunes);
        $fechaFinal = strtotime('+4 days', $fechaFinal);
        $fechaFinal = date("d/m/Y", $fechaFinal);
        $lastWeek->fecha_lunes = $fechaFinal;

        $colaboradoresMes = [];
        //Recorrer semanas e ir agregando los colaboradores que tienen esten activos esa semana y tengan alguna responsabilidad cumplida en esa semana
        $responsabilidadesMes = [];
        foreach ($semanasMes as $semana) {
            $colaboradoresAreaId = Colaboradores_por_Area::where('area_id', $area_id)->where('semana_inicio_id', '<=', $semana->id)->with('colaborador', 'semana')->get()->pluck('id');
            $colaboradoresActivosId = [];

            foreach($responsabilidades as $responsabilidad){
                //Verificar si la responsabilidad estaba activa
                $activo = RegistroResponsabilidadController::verifyResponsabilidadInactivity($responsabilidad->id, $semana->id);
                if($activo){
                    //Si esta activa verificar si ya esta en el array
                    if(isset($responsabilidadesMes[$responsabilidad->nombre])){
                        //Si ya esta en el array se le agrega 1 a su conteo de semanas
                        $responsabilidadesMes[$responsabilidad->nombre]['conteoSemanas']++;
                    } else{
                        //Si no esta en el array se agrega con un conteo de 1
                        $responsabilidadesMes[$responsabilidad->nombre] = [
                            "id" => $responsabilidad->id,
                            "nombre" => $responsabilidad->nombre,
                            "conteoSemanas" => 1,
                        ];
                    }

                }
            }

            foreach($colaboradoresAreaId as $colabAreaId){
                $activo = RegistroActividadController::verifyColaboradorInactivity($colabAreaId, $semana->id);
                // Si el colaborador está activo, añadirlo al array temporal
                if ($activo === true) {
                    $colaboradoresActivosId[] = $colabAreaId;
                }
            }
            $colaboradoresActivosToAdd = Colaboradores_por_Area::whereIn('id', $colaboradoresActivosId)->get();

            foreach ($colaboradoresActivosToAdd as $colaboradorActivoToAdd) {
                $semanaCumplida = Cumplio_Responsabilidad_Semanal::where("semana_id", $semana->id)->where("colaborador_area_id", $colaboradorActivoToAdd->id)->first();
                if($semanaCumplida){
                    $existe = false;
                    foreach ($colaboradoresMes as &$colaboradorMes) {
                        if ($colaboradorMes['id'] === $colaboradorActivoToAdd->id) {
                            $existe = true;
                            break;
                        }
                    }
                    // Si el colaborador no está en $colaboradoresMes, agregarlo
                    if (!$existe) {
                        $candidato = $colaboradorActivoToAdd->colaborador->candidato;
                        $colaboradoresMes[] = [
                            'id' => $colaboradorActivoToAdd->id,
                            'colaborador' => $colaboradorActivoToAdd,
                            'nombre' => $candidato->nombre . ' ' . $candidato->apellido,
                        ];
                    }
                }
            }
        }
        foreach ($colaboradoresMes as &$colaboradorMes) {
            $promedioColab = FunctionHelperController::promedioColaborador($colaboradorMes['colaborador']->colaborador_id, $semanasMes);
            $colaboradorMes['sumNotas'] = $promedioColab['notasTotales'];
            $colaboradorMes['promedio'] = $promedioColab['promedioNotas'];
            $colaboradorMes['total'] = $promedioColab['promedio'];
        }
        unset($colaboradorMes);

        // return response()->json([
        //     "colaboradoresMes" => $colaboradoresMes,
        //     "responsabilidades" => $responsabilidades,
        //     "year" => $year,
        //     "mes" => $mes,
        //     "area" => $area,
        //     "totalSemanas" => $totalSemanas,
        //     "firstWeek" => $firstWeek,
        //     "lastWeek" => $lastWeek
        // ]);

        return view('inspiniaViews.responsabilidades.promediomes', [
            "colaboradoresMes" => $colaboradoresMes,
            "responsabilidades" => $responsabilidades,
            "responsabilidadesMes" => $responsabilidadesMes,
            "year" => $year,
            "mes" => $mes,
            "area" => $area,
            "totalSemanas" => $totalSemanas,
            "firstWeek" => $firstWeek,
            "lastWeek" => $lastWeek
        ]);
    }


    public function getMonthsProm(Request $request, $area_id)
    {
        $access = FunctionHelperController::verifyAreaAccess($area_id);

        if (!$access) {
            return redirect()->route('dashboard')->with('error', 'No es un usuario con permisos para ver esa area. No lo intente denuevo o puede ser baneado.');
        }
        $area = Area::findOrFail($area_id);
        $responsabilidades = Responsabilidades_semanales::get();

        $year = $request->year;
        $selectedMonths = json_decode($request->input('selected_months'), true);

        $Meses = FunctionHelperController::getMonths();
        $colaboradoresMeses = [];
        $semanasMeses = [];

        $responsabilidadesMeses = [];

        foreach ($selectedMonths as $mes) {
            $semanasMes = [];

            foreach ($Meses as $Month) {
                if ($Month['nombre'] == $mes) {
                    $semanasTotales = Semanas::get();
                    foreach ($semanasTotales as $semana) {
                        $mesFecha = date('m', strtotime($semana->fecha_lunes));
                        $yearFecha = date('Y', strtotime($semana->fecha_lunes));
                        if ($mesFecha == $Month['id'] && $yearFecha == $year) {
                            $semanasMes[] = $semana;
                        }
                    }
                }
            }
            $semanasMeses = array_merge($semanasMeses, $semanasMes);
            foreach ($semanasMes as $semana) {
                foreach($responsabilidades as $responsabilidad){
                    //Verificar si la responsabilidad estaba activa
                    $activo = RegistroResponsabilidadController::verifyResponsabilidadInactivity($responsabilidad->id, $semana->id);
                    if($activo){
                        //Si esta activa verificar si ya esta en el array
                        if(isset($responsabilidadesMeses[$responsabilidad->nombre])){
                            //Si ya esta en el array se le agrega 1 a su conteo de semanas
                            $responsabilidadesMeses[$responsabilidad->nombre]['conteoSemanas']++;
                        } else{
                            //Si no esta en el array se agrega con un conteo de 1
                            $responsabilidadesMeses[$responsabilidad->nombre] = [
                                "id" => $responsabilidad->id,
                                "nombre" => $responsabilidad->nombre,
                                "conteoSemanas" => 1,
                            ];
                        }
                    }
                }


                $colaboradoresAreaId = Colaboradores_por_Area::where('area_id', $area_id)->where('semana_inicio_id', '<=', $semana->id)->with('colaborador', 'semana')->get()->pluck('id');
                $colaboradoresActivosId = [];

                foreach ($colaboradoresAreaId as $colabAreaId) {
                    $activo = RegistroActividadController::verifyColaboradorInactivity($colabAreaId, $semana->id);
                    
                    // Si el colaborador está activo, añadirlo al array temporal
                    if ($activo === true) {
                        $colaboradoresActivosId[] = $colabAreaId;
                    }
                }
                $colaboradoresActivosToAdd = Colaboradores_por_Area::whereIn('id', $colaboradoresActivosId)->get();

                foreach ($colaboradoresActivosToAdd as $colaboradorActivoToAdd) {
                    $semanaCumplida = Cumplio_Responsabilidad_Semanal::where("semana_id", $semana->id)->where("colaborador_area_id", $colaboradorActivoToAdd->id)->firstOrNew();
                    // Verificar si el colaborador ya está en $colaboradoresMeses
                    if ($semanaCumplida) {
                        $existe = false;
                        foreach ($colaboradoresMeses as &$colaboradorMes) {
                            if ($colaboradorMes['id'] === $colaboradorActivoToAdd->id) {
                                $existe = true;
                                break;
                            }
                        }

                        // Si el colaborador no está en $colaboradoresMeses, agregarlo
                        if (!$existe) {
                            $candidato = $colaboradorActivoToAdd->colaborador->candidato;
                            $colaboradoresMeses[] = [
                                'id' => $colaboradorActivoToAdd->id,
                                'colaborador' => $colaboradorActivoToAdd,
                                'nombre' => $candidato->nombre . ' ' . $candidato->apellido,
                            ];
                        }
                    }
                }
            }
        }

        foreach ($colaboradoresMeses as &$colaboradorMes) {
            $promedioColab = FunctionHelperController::promedioColaborador($colaboradorMes['colaborador']->colaborador_id, $semanasMeses);
            $colaboradorMes['sumNotas'] = $promedioColab['notasTotales'];
            $colaboradorMes['promedio'] = $promedioColab['promedioNotas'];
            $colaboradorMes['total'] = $promedioColab['promedio'];
        }
        unset($colaboradorMes);
        $totalSemanas = count($semanasMeses);

        $firstWeek = $semanasMeses[0];
        $firstWeek->fecha_lunes = date("d/m/Y", strtotime($firstWeek->fecha_lunes));
        $lastWeek = end($semanasMeses);
        $fechaFinal = strtotime($lastWeek->fecha_lunes);
        $fechaFinal = strtotime('+4 days', $fechaFinal);
        $fechaFinal = date("d/m/Y", $fechaFinal);
        $lastWeek->fecha_lunes = $fechaFinal;

        // return [
        //     "colaboradoresMeses" => $colaboradoresMeses,
        //     "responsabilidades" => $responsabilidades,
        //     "selectedMonths" => $selectedMonths,
        //     "area" => $area,
        //     "totalSemanas" => $totalSemanas,
        //     "firstWeek" => $firstWeek,
        //     "lastWeek" => $lastWeek
        // ];
        return view('inspiniaViews.responsabilidades.promediomeses', [
            "colaboradoresMeses" => $colaboradoresMeses,
            "responsabilidades" => $responsabilidades,
            "responsabilidadesMeses" => $responsabilidadesMeses,
            "selectedMonths" => $selectedMonths,
            "area" => $area,
            "totalSemanas" => $totalSemanas,
            "firstWeek" => $firstWeek,
            "lastWeek" => $lastWeek
        ]);
    }
}
