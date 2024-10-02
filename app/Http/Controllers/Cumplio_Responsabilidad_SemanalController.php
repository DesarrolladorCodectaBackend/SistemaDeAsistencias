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

            // Inicializar 'responsabilidades' como un array si no lo está
            // if (!isset($semana->responsabilidades)) {
            //     $semana->setAttribute('responsabilidades', []);
            // }

            // foreach ($responsabilidades as $responsabilidad) {
            //     $registroResponsabilidad = RegistroResponsabilidad::where('responsabilidad_id', $responsabilidad->id)
            //         ->whereDate('fecha', '<=', $semana->fecha_lunes)
            //         ->first();

            //     if ($registroResponsabilidad) {
            //         // Asignar al array 'responsabilidades' utilizando 'setAttribute'
            //         $responsabilidadesArray = $semana->getAttribute('responsabilidades');
            //         $responsabilidadesArray[$responsabilidad->id] = $registroResponsabilidad->estado == 1;
            //         $semana->setAttribute('responsabilidades', $responsabilidadesArray);
            //     }
            // }

            $semanaCumplida = Cumplio_Responsabilidad_Semanal::where("semana_id", $semana->id)->whereIn("colaborador_area_id", $colaboradoresActivosId)->first();
            if ($semanaCumplida) {
                $semana->cumplido = true;
            } else {
                $semana->cumplido = false;
            }
            // if ($colaboradoresArea->count() < 1) {
            //     // Eliminar la semana del array $semanasMes
            //     unset($semanasMes[$index]);
            // }
            if ($countColabsActivos < 1) {
                unset($semanasMes[$index]);
            }
        }
        $semanasMes = array_values($semanasMes);
        // return $semanasMes;
        // return $semanasMes;
        $registros = Cumplio_Responsabilidad_Semanal::get();
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
            'informesSemanales' => $informesSemanales
        ]);
    }

    public function getMonthPromOld($year, $mes, $area_id)
    {
        $area = Area::findOrFail($area_id);
        $responsabilidades = Responsabilidades_semanales::get();
        $colaboradoresArea = Colaboradores_por_Area::where('area_id', $area_id)->with('colaborador')->get();
        $colaboradoresAreaId = $colaboradoresArea->pluck('id');

        $Meses = FunctionHelperController::getMonths();

        $semanasMes = [];
        $semanasMesId = [];

        foreach ($Meses as $Month) {
            if ($Month['nombre'] == $mes) {
                $semanasTotales = Semanas::get();
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

        $semanasCumplidas = Cumplio_Responsabilidad_Semanal::whereIn("semana_id", $semanasMesId)->whereIn("colaborador_area_id", $colaboradoresAreaId)->get();
        $semanasCumplidasIds = $semanasCumplidas->pluck('semana_id')->toArray();

        $semanasCumplidasCount = 0;
        foreach ($semanasMes as &$semana) {
            if (in_array($semana->id, $semanasCumplidasIds)) {
                $semana->cumplido = true;
                $semanasCumplidasCount++;
            } else {
                $semana->cumplido = false;
            }
        }
        $dataProm = [];

        foreach ($semanasMesId as $id) {
            $registrosCumplidosSemana = Cumplio_Responsabilidad_Semanal::where('semana_id', $id)->whereIn("colaborador_area_id", $colaboradoresAreaId)->get(); //Posible problema con las areas, fijar despues, facil solucion con whereIn colaboradoresArea

            foreach ($registrosCumplidosSemana as $registro) {
                $colaboradorArea = Colaboradores_por_Area::findOrFail($registro->colaborador_area_id);
                $colaborador = Colaboradores::with('candidato')->findOrFail($colaboradorArea->colaborador_id);
                $colaboradorNombre = $colaborador->candidato->nombre . " " . $colaborador->candidato->apellido;

                $index = array_search($colaboradorNombre, array_column($dataProm, 'colaborador'));

                $valorCumplio = $registro->cumplio == 1 ? 20 : 0;

                if ($index !== false) {
                    switch ($registro->responsabilidad_id) {
                        case 1:
                            $dataProm[$index]['asistencia'] += $valorCumplio;
                            break;
                        case 2:
                            $dataProm[$index]['reuniones'] += $valorCumplio;
                            break;
                        case 3:
                            $dataProm[$index]['aportes'] += $valorCumplio;
                            break;
                        case 4:
                            $dataProm[$index]['participacion'] += $valorCumplio;
                            break;
                        case 5:
                            $dataProm[$index]['presentacion'] += $valorCumplio;
                            break;
                        case 6:
                            $dataProm[$index]['lecturas'] += $valorCumplio;
                            break;
                        case 7:
                            $dataProm[$index]['faltas_justificadas'] += $valorCumplio;
                            break;
                    }
                } else {
                    $nuevoRegistro = [
                        "colaborador" => $colaboradorNombre,
                        "asistencia" => 0,
                        "reuniones" => 0,
                        "aportes" => 0,
                        "participacion" => 0,
                        "presentacion" => 0,
                        "lecturas" => 0,
                        "faltas_justificadas" => 0,
                    ];

                    switch ($registro->responsabilidad_id) {
                        case 1:
                            $nuevoRegistro['asistencia'] = $valorCumplio;
                            break;
                        case 2:
                            $nuevoRegistro['reuniones'] = $valorCumplio;
                            break;
                        case 3:
                            $nuevoRegistro['aportes'] = $valorCumplio;
                            break;
                        case 4:
                            $nuevoRegistro['participacion'] = $valorCumplio;
                            break;
                        case 5:
                            $nuevoRegistro['presentacion'] = $valorCumplio;
                            break;
                        case 6:
                            $nuevoRegistro['lecturas'] = $valorCumplio;
                            break;
                        case 7:
                            $nuevoRegistro['faltas_justificadas'] = $valorCumplio;
                            break;
                    }

                    // Agregar el nuevo registro al array $dataProm
                    $dataProm[] = $nuevoRegistro;
                }
            }
        }

        foreach ($dataProm as &$colaboradorData) {
            $colaboradorData['asistencia'] /= $semanasCumplidasCount;
            $colaboradorData['reuniones'] /= $semanasCumplidasCount;
            $colaboradorData['aportes'] /= $semanasCumplidasCount;
            $colaboradorData['participacion'] /= $semanasCumplidasCount;
            $colaboradorData['presentacion'] /= $semanasCumplidasCount;
            $colaboradorData['lecturas'] /= $semanasCumplidasCount;
            $colaboradorData['faltas_justificadas'] /= $semanasCumplidasCount;

            $colaboradorData['total'] = number_format(
                ($colaboradorData['asistencia'] + $colaboradorData['reuniones'] + $colaboradorData['aportes'] +
                    $colaboradorData['participacion'] + $colaboradorData['presentacion'] + $colaboradorData['lecturas'] + $colaboradorData['faltas_justificadas']) / $responsabilidades->count(),
                1
            );
        }
        //return $dataProm;


        //return $semanasCumplidasCount;
        return view('inspiniaViews.responsabilidades.promediomes', [
            "dataProm" => $dataProm,
            "responsabilidades" => $responsabilidades,
            "year" => $year,
            "mes" => $mes,
            "area" => $area,
        ]);
    }

    public function getMonthsPromOld(Request $request, $area_id)
    {
        $area = Area::findOrFail($area_id);
        $responsabilidades = Responsabilidades_semanales::get();
        $colaboradoresArea = Colaboradores_por_Area::where('area_id', $area_id)->with('colaborador')->get();
        $colaboradoresAreaId = $colaboradoresArea->pluck('id');

        $year = $request->year;
        $selectedMonths = json_decode($request->input('selected_months'), true);

        $Meses = FunctionHelperController::getMonths();

        $totalSemanasCumplidasCount = 0;
        $totalDataProm = [];
        $semanasMeses = [];

        foreach ($selectedMonths as $mes) {
            $semanasMes = [];
            $semanasMesId = [];

            foreach ($Meses as $Month) {
                if ($Month['nombre'] == $mes) {
                    $semanasTotales = Semanas::get();
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

            $semanasCumplidas = Cumplio_Responsabilidad_Semanal::whereIn("semana_id", $semanasMesId)->whereIn("colaborador_area_id", $colaboradoresAreaId)->get();
            $semanasCumplidasIds = $semanasCumplidas->pluck('semana_id')->toArray();

            $semanasCumplidasCount = 0;
            foreach ($semanasMes as &$semana) {
                if (in_array($semana->id, $semanasCumplidasIds)) {
                    $semana->cumplido = true;
                    $semanasCumplidasCount++;
                } else {
                    $semana->cumplido = false;
                }
            }
            $totalSemanasCumplidasCount += $semanasCumplidasCount;

            $semanasMeses = array_merge($semanasMeses, $semanasMes);

            $dataProm = [];

            foreach ($semanasMesId as $id) {
                $registrosCumplidosSemana = Cumplio_Responsabilidad_Semanal::where('semana_id', $id)->whereIn("colaborador_area_id", $colaboradoresAreaId)->get();

                foreach ($registrosCumplidosSemana as $registro) {
                    $colaboradorArea = Colaboradores_por_Area::findOrFail($registro->colaborador_area_id);
                    $colaborador = Colaboradores::with('candidato')->findOrFail($colaboradorArea->colaborador_id);
                    $colaboradorNombre = $colaborador->candidato->nombre . " " . $colaborador->candidato->apellido;

                    $index = array_search($colaboradorNombre, array_column($dataProm, 'colaborador'));

                    $valorCumplio = $registro->cumplio == 1 ? 20 : 0;

                    if ($index !== false) {
                        switch ($registro->responsabilidad_id) {
                            case 1:
                                $dataProm[$index]['asistencia'] += $valorCumplio;
                                break;
                            case 2:
                                $dataProm[$index]['reuniones'] += $valorCumplio;
                                break;
                            case 3:
                                $dataProm[$index]['aportes'] += $valorCumplio;
                                break;
                            case 4:
                                $dataProm[$index]['participacion'] += $valorCumplio;
                                break;
                            case 5:
                                $dataProm[$index]['presentacion'] += $valorCumplio;
                                break;
                            case 6:
                                $dataProm[$index]['lecturas'] += $valorCumplio;
                                break;
                            case 7:
                                $dataProm[$index]['faltas_justificadas'] += $valorCumplio;
                                break;
                        }
                    } else {
                        $nuevoRegistro = [
                            "colaborador" => $colaboradorNombre,
                            "asistencia" => 0,
                            "reuniones" => 0,
                            "aportes" => 0,
                            "participacion" => 0,
                            "presentacion" => 0,
                            "lecturas" => 0,
                            "faltas_justificadas" => 0,
                        ];

                        switch ($registro->responsabilidad_id) {
                            case 1:
                                $nuevoRegistro['asistencia'] = $valorCumplio;
                                break;
                            case 2:
                                $nuevoRegistro['reuniones'] = $valorCumplio;
                                break;
                            case 3:
                                $nuevoRegistro['aportes'] = $valorCumplio;
                                break;
                            case 4:
                                $nuevoRegistro['participacion'] = $valorCumplio;
                                break;
                            case 5:
                                $nuevoRegistro['presentacion'] = $valorCumplio;
                                break;
                            case 6:
                                $nuevoRegistro['lecturas'] = $valorCumplio;
                                break;
                            case 7:
                                $nuevoRegistro['faltas_justificadas'] = $valorCumplio;
                                break;
                        }

                        $dataProm[] = $nuevoRegistro;
                    }
                }
            }

            foreach ($dataProm as $colaboradorData) {
                $index = array_search($colaboradorData['colaborador'], array_column($totalDataProm, 'colaborador'));

                if ($index !== false) {
                    $totalDataProm[$index]['asistencia'] += $colaboradorData['asistencia'];
                    $totalDataProm[$index]['reuniones'] += $colaboradorData['reuniones'];
                    $totalDataProm[$index]['aportes'] += $colaboradorData['aportes'];
                    $totalDataProm[$index]['participacion'] += $colaboradorData['participacion'];
                    $totalDataProm[$index]['presentacion'] += $colaboradorData['presentacion'];
                    $totalDataProm[$index]['lecturas'] += $colaboradorData['lecturas'];
                    $totalDataProm[$index]['faltas_justificadas'] += $colaboradorData['faltas_justificadas'];
                } else {
                    $totalDataProm[] = $colaboradorData;
                }
            }
        }

        foreach ($totalDataProm as &$colaboradorData) {
            $colaboradorData['asistencia'] = number_format($colaboradorData['asistencia'] / $totalSemanasCumplidasCount, 1);
            $colaboradorData['reuniones'] = number_format($colaboradorData['reuniones'] / $totalSemanasCumplidasCount, 1);
            $colaboradorData['aportes'] = number_format($colaboradorData['aportes'] / $totalSemanasCumplidasCount, 1);
            $colaboradorData['participacion'] = number_format($colaboradorData['participacion'] / $totalSemanasCumplidasCount, 1);
            $colaboradorData['presentacion'] = number_format($colaboradorData['presentacion'] / $totalSemanasCumplidasCount, 1);
            $colaboradorData['lecturas'] = number_format($colaboradorData['lecturas'] / $totalSemanasCumplidasCount, 1);
            $colaboradorData['faltas_justificadas'] = number_format($colaboradorData['faltas_justificadas'] / $totalSemanasCumplidasCount, 1);

            $colaboradorData['total'] = number_format(
                ($colaboradorData['asistencia'] + $colaboradorData['reuniones'] + $colaboradorData['aportes'] +
                    $colaboradorData['participacion'] + $colaboradorData['presentacion'] + $colaboradorData['lecturas'] + $colaboradorData['faltas_justificadas']) / $responsabilidades->count(),
                1
            );
        }

        $totalSemanas = count($semanasMeses);

        $firstWeek = $semanasMeses[0];
        $firstWeek->fecha_lunes = date("d/m/Y", strtotime($firstWeek->fecha_lunes));
        $lastWeek = end($semanasMeses);
        $fechaFinal = strtotime($lastWeek->fecha_lunes);
        $fechaFinal = strtotime('+4 days', $fechaFinal);
        $fechaFinal = date("d/m/Y", $fechaFinal);
        $lastWeek->fecha_lunes = $fechaFinal;
        return view('inspiniaViews.responsabilidades.promediomeses', [
            "totalDataProm" => $totalDataProm,
            "responsabilidades" => $responsabilidades,
            "selectedMonths" => $selectedMonths,
            "area" => $area,
            "totalSemanas" => $totalSemanas,
            "firstWeek" => $firstWeek,
            "lastWeek" => $lastWeek
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

            if ($semana->id > $thisSemana->id) {
                DB::rollBack();
                return redirect()->route('responsabilidades.asis', ['year' => $year, 'mes' => $mes, 'area_id' => $area_id])
                    ->with('EvaluacionWarning', 'No se puede evaluar semanas futuras.')->with('current_semana_id', $request->index);
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
        //Se les ira sumando sus semanas cumplidas
        $responsabilidadesMes = [];
        foreach ($semanasMes as $semana) {
            $colaboradoresArea = Colaboradores_por_Area::where('area_id', $area_id)->where('semana_inicio_id', '<=', $semana->id)->with('colaborador', 'semana')->get();
            $colaboradoresAreaId = $colaboradoresArea->pluck('id');
            $colaboradoresActivosId = [];
            $countColabsActivos = 0;

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
        //return $responsabilidadesMes;
        // Obtener la suma de sus notas
        foreach ($colaboradoresMes as $index => &$colaboradorMes) {
            // Inicializar sumNotes con todas las responsabilidades en 0
            $sumNotes = [];
            foreach ($responsabilidadesMes as $responsabilidad) {
                $nombreResponsabilidad = $responsabilidad['nombre'];
                $sumNotes[$nombreResponsabilidad] = 0;
            }
            foreach ($colaboradorMes['semanas'] as $semanaId) {
                $registrosCumplidosSemana = Cumplio_Responsabilidad_Semanal::where('semana_id', $semanaId)
                    ->where('colaborador_area_id', $colaboradorMes['id'])
                    ->get();
                    

                foreach ($registrosCumplidosSemana as $registro) {
                    $valorCumplio = $registro->cumplio == 1 ? 20 : 0;

                    foreach($responsabilidadesMes as $responsabilidad){
                        if($responsabilidad['id'] == $registro->responsabilidad_id) {
                            $nombreResponsabilidad = $responsabilidad['nombre'];
                            $sumNotes[$nombreResponsabilidad] += $valorCumplio;
                        }
                    }
                }
            }
            // Agregar el array $sumNotes al array $colaboradorMes['sumNotas']
            $colaboradorMes['sumNotas'] = $sumNotes;
        }
        unset($colaboradorMes); // Unset the reference

        

        //Dividir la suma maxima de las notas por la cantidad de semanas para obtener el promedio de cada responsabilidad
        foreach ($colaboradoresMes as $index => $colaboradorMes) {
            // Inicializar promNotes con todas las responsabilidades en 0
            $semanasCount = $colaboradoresMes[$index]['semanasCount'];
            $PromNotas = [];
            foreach (array_keys($colaboradoresMes[$index]['sumNotas']) as $responsabilidad) {
                $countRespSem = $responsabilidadesMes[$responsabilidad]['conteoSemanas'];
                $notaBaseColaborador = number_format(($colaboradoresMes[$index]['sumNotas'][$responsabilidad]) / $semanasCount, 1);
                $notaEntreSemana = number_format(($notaBaseColaborador * count($semanasMes))/$countRespSem, 1);
                $PromNotas[$responsabilidad] = $notaEntreSemana;
            }
            $colaboradoresMes[$index]['promedio'] = $PromNotas;
            //Total suma de todas las responsabilidades entre el conteo de estas para obtener el promedio general del colaborador en el mes
            $colaboradoresMes[$index]['total'] = number_format((array_sum($PromNotas))/count($responsabilidadesMes),1);
        }
        // return $colaboradoresMes;
        
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


                $colaboradoresArea = Colaboradores_por_Area::where('area_id', $area_id)->where('semana_inicio_id', '<=', $semana->id)->with('colaborador', 'semana')->get();
                $colaboradoresAreaId = $colaboradoresArea->pluck('id');
                $colaboradoresActivosId = [];
                // $colaboradoresInactivosId = [];
                $countColabsActivos = 0;
                // $countColabsInactivos = 0;
                foreach ($colaboradoresAreaId as $colabAreaId) {
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
                    // Si el colaborador está activo, añadirlo al array temporal
                    if ($activo === true) {
                        $colaboradoresActivosId[] = $colabAreaId;
                        $countColabsActivos++;
                    }
                    // else {
                    // $colaboradoresInactivosId[] = $col;
                    // $countColabsInactivos++;
                    // }
                }
                $colaboradoresActivosToAdd = Colaboradores_por_Area::whereIn('id', $colaboradoresActivosId)->get();

                foreach ($colaboradoresActivosToAdd as $colaboradorActivoToAdd) {
                    $semanaCumplida = Cumplio_Responsabilidad_Semanal::where("semana_id", $semana->id)->where("colaborador_area_id", $colaboradorActivoToAdd->id)->firstOrNew();
                    // Verificar si el colaborador ya está en $colaboradoresMeses
                    if ($semanaCumplida) {
                        $existe = false;
                        foreach ($colaboradoresMeses as &$colaboradorMes) {
                            if ($colaboradorMes['id'] === $colaboradorActivoToAdd->id) {
                                $colaboradorMes['semanasCount']++;
                                $colaboradorMes['semanas'][] = $semana->id;
                                $existe = true;
                                break;
                            }
                        }

                        // Si el colaborador no está en $colaboradoresMeses, agregarlo
                        if (!$existe) {
                            $candidato = $colaboradorActivoToAdd->colaborador->candidato;
                            $colaboradoresMeses[] = [
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
        }

        foreach ($colaboradoresMeses as $index => &$colaboradorMes) {
            // Inicializar sumNotes con todas las responsabilidades en 0
            $sumNotes = [];
            foreach ($responsabilidadesMeses as $responsabilidad) {
                $nombreResponsabilidad = $responsabilidad['nombre'];
                $sumNotes[$nombreResponsabilidad] = 0;
            }

            foreach ($colaboradorMes['semanas'] as $semanaId) {
                $registrosCumplidosSemana = Cumplio_Responsabilidad_Semanal::where('semana_id', $semanaId)
                    ->where('colaborador_area_id', $colaboradorMes['id'])
                    ->get();

                foreach ($registrosCumplidosSemana as $registro) {
                    $valorCumplio = $registro->cumplio == 1 ? 20 : 0;
                    
                    foreach($responsabilidadesMeses as $responsabilidad){
                        if($responsabilidad['id'] == $registro->responsabilidad_id) {
                            $nombreResponsabilidad = $responsabilidad['nombre'];
                            $sumNotes[$nombreResponsabilidad] += $valorCumplio;
                        }
                    }
                }
            }
            // Agregar el array $sumNotes al array $colaboradorMes['sumNotas']
            $colaboradorMes['sumNotas'] = $sumNotes;
        }
        unset($colaboradorMes);
        foreach ($colaboradoresMeses as $index => $colaboradorMes) {
            // Inicializar promNotes con todas las responsabilidades en 0
            $semanasCount = $colaboradoresMeses[$index]['semanasCount'];
            $PromNotas = [];
            foreach (array_keys($colaboradoresMeses[$index]['sumNotas']) as $responsabilidad) {
                $countRespSem = $responsabilidadesMeses[$responsabilidad]['conteoSemanas'];
                $notaBaseColaborador = number_format(($colaboradoresMeses[$index]['sumNotas'][$responsabilidad]) / $semanasCount, 1);
                $notaEntreSemana = number_format(($notaBaseColaborador * count($semanasMeses))/$countRespSem, 1);
                $PromNotas[$responsabilidad] = $notaEntreSemana;
                //$PromNotas[$responsabilidad] = number_format(($colaboradoresMeses[$index]['sumNotas'][$responsabilidad]) / $semanasCount, 1);
            }
            $colaboradoresMeses[$index]['promedio'] = $PromNotas;
            //Total suma de todas las responsabilidades entre el conteo de estas para obtener el promedio general del colaborador en el mes
            $colaboradoresMeses[$index]['total'] = number_format((array_sum($PromNotas)) / count($responsabilidadesMeses), 1);
        }
        // return $colaboradoresMeses;
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
