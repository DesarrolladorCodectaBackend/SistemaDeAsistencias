<?php

namespace App\Http\Controllers;

use App\Models\Colaboradores_por_Area;
use Illuminate\Http\Request;
use App\Http\Requests\StoreColaboradores_por_AreaRequest;
use App\Http\Requests\UpdateColaboradores_por_AreaRequest;

class ColaboradoresPorAreaController extends Controller
{
    
    public function index()
    {
        $Colabs_Area = Colaboradores_por_Area::with([
            'colaboradores' => function($query){$query->select('id', 'candidato_id');},
            'area' => function($query){$query->select('id', 'especializacion', 'color_hex');}])->get();
        
        return response()->json(["data" => $Colabs_Area, "conteo" => count($Colabs_Area)]);
    }

    
    public function create(Request $request)
    {
        Colaboradores_por_Area::create([
            "colaborador_id" => $request->colaborador_id,
            "area_id" => $request->area_id,
            "semana_inicio_id" => $request->semana_inicio_id
        ]);

        return response()->json(["resp" => "Registro creado correctamente"]);
    }

    
    public function show($colaborador_por_area_id)
    {
        $colaborador_por_area = Colaboradores_por_Area::with([
            'colaboradores' => function($query){$query->select('id', 'candidato_id');},
            'area' => function($query){$query->select('id', 'especializacion', 'color_hex');}])
            ->find($colaborador_por_area_id);

        return response()->json(["data" => $colaborador_por_area]);
    }

    
    public function update(Request $request, $colaborador_por_area_id)
    {
        $colaborador_por_area = Colaboradores_por_Area::find($colaborador_por_area_id);

        $colaborador_por_area->fill([
            "colaborador_id" => $request->colaborador_id,
            "area_id" => $request->area_id,
            "semana_inicio_id" => $request->semana_inicio_id
        ])->save();

        return response()->json(["resp" => "Registro actualizado correctamente"]);
    }

    
    public function destroy($colaborador_por_area_id)
    {
        $colaborador_por_area = Colaboradores_por_Area::find($colaborador_por_area_id);

        $colaborador_por_area->delete();

        return response()->json(["resp" => "Registro eliminado correctamente"]);
    }
}
