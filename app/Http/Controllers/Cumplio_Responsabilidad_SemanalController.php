<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cumplio_Responsabilidad_Semanal;
use App\Models\Area;
use Illuminate\Support\Facades\DB;
use Exception;

class Cumplio_Responsabilidad_SemanalController extends Controller
{
    public function index()
    {
        $areas = Area::get();

        return view('inspiniaViews.responsabilidades.index', compact('areas'));

    }

    public function getMesesAreas($area_id)
    {
        $area = Area::findOrFail($area_id);

        $meses = [
            ['id' => 1, 'nombre' => 'Enero'],
            ['id' => 2, 'nombre' => 'Febrero'],
            ['id' => 3, 'nombre' => 'Marzo'],
            ['id' => 4, 'nombre' => 'Abril'],
            ['id' => 5, 'nombre' => 'Mayo'],
            ['id' => 6, 'nombre' => 'Junio'],
            ['id' => 7, 'nombre' => 'Julio'],
            ['id' => 8, 'nombre' => 'Agosto'],
            ['id' => 9, 'nombre' => 'Septiembre'],
            ['id' => 10, 'nombre' => 'Octubre'],
            ['id' => 11, 'nombre' => 'Noviembre'],
            ['id' => 12, 'nombre' => 'Diciembre']
        ];
        return view('inspiniaViews.responsabilidades.meses', ['area' => $area], compact('meses'));
    }

    public function getAsistenciasAreas($area_id){
        $responsabilidades = Cumplio_Responsabilidad_Semanal::where('area_id');
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

        $request->validate([
            'colaborador_area_id' => 'required|integer|min:1|max:100',
            'responsabilidad_id' => 'required|integer|min:1|max:255',
            'semana_id' => 'required|integer|min:1|max:100',
            'cumplio' => 'required|boolean|min:1|max:100',

        ]);


        Cumplio_Responsabilidad_Semanal::create([
            "colaborador_area_id" => $request->colaborador_area_id,
            "responsabilidad_id" => $request->responsabilidad_id,
            "semana_id" => $request->semana_id,
            "cumplio" => $request->cumplio
        ]);

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
