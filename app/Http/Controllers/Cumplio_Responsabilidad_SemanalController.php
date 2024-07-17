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
use Illuminate\Support\Facades\DB;
use Exception;


class Cumplio_Responsabilidad_SemanalController extends Controller
{

    public function years()
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

    public function meses()
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

    public function index()
    {
        $areas = Area::get();

        $Years = $this->years();
        $countYears = count($Years);
        $currentYear = last($Years);

        return view('inspiniaViews.responsabilidades.index', [
            'countYears' => $countYears,
            'currentYear' => $currentYear,
            'areas' => $areas
        ]);

    }

    public function getYearsArea($area_id)
    {

        $Years = $this->years();

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
        $Meses = $this->meses();

        $area = Area::findOrFail($area_id);

        $colaboradoresArea = Colaboradores_por_Area::where('area_id', $area_id)->get();
        $colaboradoresAreaIds = $colaboradoresArea->pluck('id');

        $Cumplio_res_Area = Cumplio_Responsabilidad_Semanal::with('semana')
            ->whereIn('colaborador_area_id', $colaboradoresAreaIds)
            ->get();

        $agrupadosPorMes = [];

        foreach ($Meses as $mes) {
            $agrupadosPorMes[$mes['nombre']] = [
                'total_semanas' => 0,
                'semanas_evaluadas' => 0,
                'semanas_sin_evaluar' => 0,
            ];
        }

        $semanasTotales = Semanas::get();

        foreach ($Meses as $mes) {
            $semanasMes = $semanasTotales->filter(function ($semana) use ($mes, $year) {
                return date('Y', strtotime($semana->fecha_lunes)) == $year &&
                    date('m', strtotime($semana->fecha_lunes)) == $mes['id'];
            });

            $agrupadosPorMes[$mes['nombre']]['total_semanas'] = $semanasMes->count();

            $semanasEvaluadas = $Cumplio_res_Area->filter(function ($registro) use ($semanasMes) {
                return $semanasMes->contains('id', $registro->semana->id);
            })->unique('semana_id')->count();

            $agrupadosPorMes[$mes['nombre']]['semanas_evaluadas'] = $semanasEvaluadas;
            $agrupadosPorMes[$mes['nombre']]['semanas_sin_evaluar'] = $agrupadosPorMes[$mes['nombre']]['total_semanas'] - $semanasEvaluadas;
        }

        return view('inspiniaViews.responsabilidades.meses', ['area_id' => $area_id, 'year' => $year], compact('agrupadosPorMes'));
    }

    public function getFormAsistencias($year, $mes, $area_id)
    {
        //$area_id = $request->area_id;
        $area = Area::findOrFail($area_id);
        $responsabilidades = Responsabilidades_semanales::get();
        $colaboradoresArea = Colaboradores_por_Area::where('area_id', $area_id)->where('estado', true)->with('colaborador')->get();
        $colaboradoresAreaId = $colaboradoresArea->pluck('id');
        //return $registros;

        $Meses = $this->meses();

        //Obtener las semanas del mes
        $semanasMes = [];
        $semanasMesId = [];
        $semanasTotales = Semanas::get();

        foreach ($Meses as $Month) {
            if ($Month['nombre'] == $mes) {
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

        //Obtener Registros creados del mes
        $semanasCumplidas = Cumplio_Responsabilidad_Semanal::whereIn("semana_id", $semanasMesId)->whereIn("colaborador_area_id", $colaboradoresAreaId)->get(); //validar por area (colaboradores)
        $semanasCumplidasIds = $semanasCumplidas->pluck('semana_id')->toArray();

        // Definir semanas cumplidas
        foreach ($semanasMes as &$semana) {
            if (in_array($semana->id, $semanasCumplidasIds)) {
                $semana->cumplido = true;
            } else {
                $semana->cumplido = false;
            }
        }

        $registros = Cumplio_Responsabilidad_Semanal::get();
        //return $semanasCumplidas;
        //return $semanasMes;
        //return $registros;
        return view('inspiniaViews.responsabilidades.asistencia', [
            'year' => $year,
            'mes' => $mes,
            'registros' => $registros,
            'area' => $area,
            'responsabilidades' => $responsabilidades,
            'colaboradoresArea' => $colaboradoresArea,
            'semanasMes' => $semanasMes,
        ]);
    }

    public function getMonthProm($year, $mes, $area_id)
    {
        $area = Area::findOrFail($area_id);
        $responsabilidades = Responsabilidades_semanales::get();
        $colaboradoresArea = Colaboradores_por_Area::where('area_id', $area_id)->with('colaborador')->get();
        $colaboradoresAreaId = $colaboradoresArea->pluck('id');

        $Meses = $this->meses();

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

    public function getMonthsProm(Request $request, $area_id)
    {
        $area = Area::findOrFail($area_id);
        $responsabilidades = Responsabilidades_semanales::get();
        $colaboradoresArea = Colaboradores_por_Area::where('area_id', $area_id)->with('colaborador')->get();
        $colaboradoresAreaId = $colaboradoresArea->pluck('id');

        $year = $request->year;
        $selectedMonths = json_decode($request->input('selected_months'), true);

        $Meses = $this->meses();

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

    public function create(Request $request)
    {
        //
    }
    
    public function store(Request $request)
    {
        //return $request;

        $request->validate([
            'colaborador_area_id.*' => 'required|integer|min:1|max:100',
            'responsabilidad_id.*' => 'required|integer|min:1|max:255',
            'semana_id' => 'required|integer|min:1|max:100',
            'cumplio.*' => 'required|boolean|min:0|max:1',
            'year' => 'required|integer',
            'mes' => 'required|string',
        ]);
        $year = $request->year;
        $mes = $request->mes;
        
        $colab_id = $request->colaborador_area_id[0];
        $colab = Colaboradores_por_Area::find($colab_id);
        $area_id = $colab->area_id;


        $responsabilidades = Responsabilidades_semanales::get();
        $responsabilidadesIds = $responsabilidades->pluck('id');


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

            if ($contador >= count($responsabilidadesIds)) {
                $contador = 0;
                $indiceColab++;
            }
        }

        return redirect()->route('responsabilidades.asis', ['year' => $year, 'mes' => $mes,'area_id' => $area_id]);
        

    }


    public function show($cumplio_responsabilidad_semanal_id)
    {
        try {
            $cumplio_responsabilidad_semanal = Cumplio_Responsabilidad_Semanal::/*with([
'computadora_colaborador' => function ($query) {
$query->select(
'id',
'colaborador_id',
'procesador',
'tarjeta_grafica',
'ram',
'almacenamiento',
'es_laptop',
'codigo_serie'
);
},
'programas' => function ($query) {
$query->select('id', 'nombre', 'descripcion', 'memoria_grafica', 'ram'); }
])->*/ find($cumplio_responsabilidad_semanal_id);

            if (!$cumplio_responsabilidad_semanal) {
                return response()->json(["resp" => "No existe un registro con ese id"]);
            }

            return response()->json(["data" => $cumplio_responsabilidad_semanal]);
        } catch (Exception $e) {
            return response()->json(["error" => $e]);
        }

    }


    public function actualizar(Request $request, $semana_id, $area_id)
    {
        $request->validate([
            'colaborador_area_id.*' => 'sometimes|integer|min:1|max:100',
            'responsabilidad_id.*' => 'sometimes|integer|min:1|max:255',
            'cumplio.*' => 'sometimes|boolean|min:0|max:1',
            'year' => 'required|integer',
            'mes' => 'required|string',
        ]);
        $year = $request->year;
        $mes = $request->mes;

        $colaboradoresAreaId = Colaboradores_por_Area::where('area_id', $area_id)->get()->pluck('id');

        $registros = Cumplio_Responsabilidad_Semanal::where('semana_id', $semana_id)->whereIn('colaborador_area_id', $colaboradoresAreaId)->get();

        foreach ($registros as $index => $registro) {
            $registro->cumplio = $request->cumplio[$index];
            $registro->save();
        }

        return redirect()->route('responsabilidades.asis', ['year' => $year, 'mes' => $mes,'area_id' => $area_id]);


    }


    // public function destroy($cumplio_responsabilidad_semanal_id)
    // {
    //     $cumplio_responsabilidad_semanal = Cumplio_Responsabilidad_Semanal::findOrFail($cumplio_responsabilidad_semanal_id);

    //     $cumplio_responsabilidad_semanal->delete();

    //     return redirect()->route('cumplio_responsabilidad_semanal.index');
    // }
}
