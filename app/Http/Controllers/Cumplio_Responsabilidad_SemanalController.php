<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cumplio_Responsabilidad_Semanal;
use Illuminate\Support\Facades\DB;
use Exception;

class Cumplio_Responsabilidad_SemanalController extends Controller
{
    public function index()
    {
        try {
            $C_R_S = Cumplio_Responsabilidad_Semanal::/*with([
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
])->*/ get();

            if (count($C_R_S) == 0) {
                return response()->json(["resp" => "No hay registros insertados"]);
            }

            return response()->json(["data" => $C_R_S, "conteo" => count($C_R_S)]);
        } catch (Exception $e) {
            return response()->json(["Error" => $e]);
        }

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
        DB::beginTransaction();
        try {
            $cumplio_responsabilidad_semanal = Cumplio_Responsabilidad_Semanal::find($cumplio_responsabilidad_semanal_id);

            if (!$cumplio_responsabilidad_semanal) {
                return response()->json(["resp" => "No existe un registro con ese id"]);
            }

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

            $cumplio_responsabilidad_semanal->fill([
                "colaborador_area_id" => $request->colaborador_area_id,
                "responsabilidad_id" => $request->responsabilidad_id,
                "semana_id" => $request->semana_id,
                "cumplio" => $request->cumplio
            ])->save();

            DB::commit();
            return response()->json(["resp" => "Registro actualizado correctamente"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["error" => $e]);
        }

    }


    public function destroy($cumplio_responsabilidad_semanal_id)
    {
        DB::beginTransaction();
        try {
            $cumplio_responsabilidad_semanal = Cumplio_Responsabilidad_Semanal::find($cumplio_responsabilidad_semanal_id);

            if (!$cumplio_responsabilidad_semanal) {
                return response()->json(["resp" => "No existe un registro con ese id"]);
            }

            $cumplio_responsabilidad_semanal->delete();
            DB::commit();
            return response()->json(["resp" => "Registro eliminado correctamente"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["error" => $e]);
        }
    }
}
