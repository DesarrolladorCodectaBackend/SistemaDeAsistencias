<?php

namespace App\Http\Controllers;

use App\Models\Responsabilidades_semanales;
use Illuminate\Http\Request;
use App\Models\Cumplio_Responsabilidad_Semanal;
use App\Models\Area;
use App\Models\Semanas;
use App\Models\Colaboradores_por_Area;
use Illuminate\Support\Facades\DB;
use Exception;


class Cumplio_Responsabilidad_SemanalController extends Controller
{
    public function index()
    {
        $areas = Area::get();

        return view('inspiniaViews.responsabilidades.index', compact('areas'));

    }


    public function getAsistenciaView($area_id)
    {
        $colaboradoresArea = Colaboradores_por_Area::where('area_id', $area_id)->get();
        $colaboradoresAreaIds = $colaboradoresArea->pluck('id');
        $Cumplio_res_Area = Cumplio_Responsabilidad_Semanal::whereIn('colaborador_area_id', $colaboradoresAreaIds)->get();
        $semanasArea = $Cumplio_res_Area->semana->fecha_lunes;
    }
    public function getMesesAreas($area_id)
    {
        $nombresMeses = [
            '01' => 'Enero',
            '02' => 'Febrero',
            '03' => 'Marzo',
            '04' => 'Abril',
            '05' => 'Mayo',
            '06' => 'Junio',
            '07' => 'Julio',
            '08' => 'Agosto',
            '09' => 'Septiembre',
            '10' => 'Octubre',
            '11' => 'Noviembre',
            '12' => 'Diciembre',
        ];

        $area = Area::findOrFail($area_id);

        $colaboradoresArea = Colaboradores_por_Area::where('area_id', $area_id)->get();
        $colaboradoresAreaIds = $colaboradoresArea->pluck('id');

        $Cumplio_res_Area = Cumplio_Responsabilidad_Semanal::with('semana')
            ->whereIn('colaborador_area_id', $colaboradoresAreaIds)
            ->get();

        $agrupadosPorMes = [];

        foreach ($nombresMeses as $mesNum => $mes) {
            $agrupadosPorMes[$mes] = [
                'total_semanas' => 0,
                'semanas_evaluadas' => 0,
                'semanas_sin_evaluar' => 0,
            ];
        }

        $semanasTotales = Semanas::get();

        foreach ($nombresMeses as $mesNum => $mes) {
            $semanasMes = $semanasTotales->filter(function ($semana) use ($mesNum) {
                return date('m', strtotime($semana->fecha_lunes)) == $mesNum;
            });

            $agrupadosPorMes[$mes]['total_semanas'] = $semanasMes->count();

            $semanasEvaluadas = $Cumplio_res_Area->filter(function ($registro) use ($semanasMes) {
                return $semanasMes->contains('id', $registro->semana->id);
            })->unique('semana_id')->count();

            $agrupadosPorMes[$mes]['semanas_evaluadas'] = $semanasEvaluadas;
            $agrupadosPorMes[$mes]['semanas_sin_evaluar'] = $agrupadosPorMes[$mes]['total_semanas'] - $semanasEvaluadas;
        }

        return view('inspiniaViews.responsabilidades.meses', ['area_id' => $area_id], compact('agrupadosPorMes'));
    }




    public function getFormAsistencias(Request $request, $mes)
    {
        $area_id = $request->area_id;
        $area = Area::findOrFail($area_id);
        $responsabilidades = Responsabilidades_semanales::get();
        $colaboradoresArea = Colaboradores_por_Area::where('area_id', $area_id)->with('colaborador')->get();
        //return $registros;

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

        //Obtener las semanas del mes
        $semanasMes = [];
        $semanasMesId = [];

        foreach ($Meses as $Month) {
            if ($Month['nombre'] == $mes) {
                $semanasTotales = Semanas::get();
                foreach ($semanasTotales as $semana) {
                    $mesFecha = date('m', strtotime($semana->fecha_lunes));
                    if ($mesFecha == $Month['id']) {
                        $semanasMes[] = $semana;
                        $semanasMesId[] = $semana->id;
                    }
                }
            }
        }

        //Obtener Registros creados del mes
        $semanasCumplidas = Cumplio_Responsabilidad_Semanal::whereIn("semana_id", $semanasMesId)->get();
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
            'mes' => $mes,
            'registros' => $registros,
            'area' => $area,
            'responsabilidades' => $responsabilidades,
            'colaboradoresArea' => $colaboradoresArea,
            'semanasMes' => $semanasMes,
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
        ]);
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

        return redirect()->route('responsabilidades.meses', ['area_id' => $area_id]);

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
        ]);

        $colaboradoresAreaId = Colaboradores_por_Area::where('area_id', $area_id)->get()->pluck('id');

        $registros = Cumplio_Responsabilidad_Semanal::where('semana_id', $semana_id)->whereIn('colaborador_area_id', $colaboradoresAreaId)->get();

        //return $registros;
        //return $request;

        foreach ($registros as $index => $registro) {
            $registro->cumplio = $request->cumplio[$index];
            $registro->save();
        }



        return redirect()->route('responsabilidades.meses', ['area_id' => $area_id]);

    }


    public function destroy($cumplio_responsabilidad_semanal_id)
    {
        $cumplio_responsabilidad_semanal = Cumplio_Responsabilidad_Semanal::findOrFail($cumplio_responsabilidad_semanal_id);

        $cumplio_responsabilidad_semanal->delete();

        return redirect()->route('cumplio_responsabilidad_semanal.index');
    }
}
