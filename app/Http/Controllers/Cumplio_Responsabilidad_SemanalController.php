<?php

namespace App\Http\Controllers;

use App\Models\Responsabilidades_semanales;
use Illuminate\Http\Request;
use App\Models\Cumplio_Responsabilidad_Semanal;
use App\Models\Area;
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

        // Inicializamos todos los meses con un arreglo vacío
        foreach ($nombresMeses as $mesNum => $mes) {
            $agrupadosPorMes[$mes] = [];
        }

        // Llenamos el arreglo con los registros existentes
        foreach ($Cumplio_res_Area as $registro) {
            $mesNum = date('m', strtotime($registro->semana->fecha_lunes));
            $mes = $nombresMeses[$mesNum];

            $registro->mes = $mes;
            $agrupadosPorMes[$mes][] = $registro;
        }
        //return $agrupadosPorMes;
        return view('inspiniaViews.responsabilidades.meses', ['area_id' => $area_id], compact('agrupadosPorMes'));
    }


    public function getFormAsistencias(Request $request, $mes)
    {
        $registros = $request->registros;
        $area_id = $request->area_id;
        $registros = unserialize(urldecode($registros));
        $area = Area::findOrFail($area_id);
        $responsabilidades = Responsabilidades_semanales::get();
        $colaboradoresArea = Colaboradores_por_Area::where('area_id', $area_id)->with('colaborador')->get();
        //return $registros;
        return view('inspiniaViews.responsabilidades.asistencia', [
            'mes' => $mes,
            'registros' => $registros,
            'area' => $area,
            'responsabilidades' => $responsabilidades,
            'colaboradoresArea' => $colaboradoresArea,
        ]);
    }



    public function create(Request $request)
    {
        DB::beginTransaction();
        try {
            if (!$request->colaborador_area_id) {
                return response()->json(["resp" => "ingrese colaborador"]);
            }

            if (!$request->responsabilidad_id) {
                return response()->json(["resp" => "ingrese responsabilidad"]);
            }

            if (!$request->semana_id) {
                return response()->json(["resp" => "ingrese semana"]);
            }

            if (!$request->cumplio) {
                return response()->json(["resp" => "ingrese si cumplio"]);
            }

            if (!is_integer($request->colaborador_area_id)) {
                return response()->json(["resp" => "El id del colaborador debe ser un número entero"]);
            }

            if (!is_integer($request->responsabilidad_id)) {
                return response()->json(["resp" => "El id de la responsabilidad debe ser un número entero"]);
            }

            if (!is_integer($request->semana_id)) {
                return response()->json(["resp" => "El id de la semana debe ser un número entero"]);
            }

            if (!is_bool($request->cumplio)) {
                return response()->json(["resp" => "Cumplio debe ser de tipo booleano"]);
            }

            Cumplio_Responsabilidad_Semanal::create([
                "colaborador_area_id" => $request->colaborador_area_id,
                "responsabilidad_id" => $request->responsabilidad_id,
                "semana_id" => $request->semana_id,
                "cumplio" => $request->cumplio
            ]);
            DB::commit();
            return response()->json(["resp" => "Registro creado correctamente"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["error" => $e]);
        }

    }

    public function store(Request $request)
    {
        //return $request;

        $request->validate([
            'colaborador_area_id.*' => 'required|integer|min:1|max:100',
            'responsabilidad_id.*' => 'required|integer|min:1|max:255',
            //'semana_id' => 'required|integer|min:1|max:100',
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
                "semana_id" => 1,
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


    public function update(Request $request, $cumplio_responsabilidad_semanal_id)
    {
        $request->validate([
            'computadora_id' => 'required|integer|min:1|max:100',
            'programa_id' => 'required|integer|min:1|max:255',
        ]);

        $cumplio_responsabilidad_semanal = Cumplio_Responsabilidad_Semanal::findOrFail($cumplio_responsabilidad_semanal_id);

        $cumplio_responsabilidad_semanal->update($request->all());

        return redirect()->route('cumplio_responsabilidad_semanal.index');

    }


    public function destroy($cumplio_responsabilidad_semanal_id)
    {
        $cumplio_responsabilidad_semanal = Cumplio_Responsabilidad_Semanal::findOrFail($cumplio_responsabilidad_semanal_id);

        $cumplio_responsabilidad_semanal->delete();

        return redirect()->route('cumplio_responsabilidad_semanal.index');
    }
}
