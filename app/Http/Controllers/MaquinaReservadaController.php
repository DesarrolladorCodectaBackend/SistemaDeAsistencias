<?php

namespace App\Http\Controllers;

use App\Models\Maquina_reservada;
use App\Models\Colaboradores_por_Area;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MaquinaReservadaController extends Controller
{
    public function index()
    {
        /*
        try {
            $maquinas_reservadas = Maquina_reservada::with([
                'horarios_presenciales' => function ($query) {
                    $query->select('id', 'horario_inicial', 'horario_final', 'dia'); },
                'maquinas' => function ($query) {
                    $query->select('id', 'nombre'); }
            ])->get();

            if (count($maquinas_reservadas) == 0) {
                return response()->json(["resp" => "No hay registros insertados"]);
            }

            return response()->json(["data" => $maquinas_reservadas, "conteo" => count($maquinas_reservadas)]);
        } catch (Exception $e) {
            return response()->json(["error" => $e]);
        }
        */
        $maquina_reservada = Maquina_reservada::all();

        return view('inspiniaViews.maquinareservada.index', compact('maquinareservada'));
    }

    public function asignarColaborador(Request $request, $area_id, $maquina_id){
        DB::beginTransaction();
        try{
            $request->validate([
                'colaborador_area_id' => 'required|integer|min:1|max:100',
            ]);

            $colaboradoresAreaId = Colaboradores_por_Area::where('area_id', $area_id)->get()->pluck('id');

            $maquinaReservada = Maquina_reservada::where('maquina_id', $maquina_id)->whereIn('colaborador_area_id', $colaboradoresAreaId)->first();

            if($maquinaReservada){
                $maquinaReservada->update(['colaborador_area_id' => $request->colaborador_area_id]);
            } else{
                Maquina_reservada::create([
                    'maquina_id' => $maquina_id,
                    'colaborador_area_id' => $request->colaborador_area_id,
                ]);
            }
            DB::commit();
            return redirect()->route('areas.getMaquinas', ['area_id' => $area_id]);
            
        } catch(Exception $e){
            DB::rollBack();
            // return $e;
            return redirect()->route('areas.getMaquinas', ['area_id' => $area_id]);
        }
    }

    public function liberarMaquina($area_id, $maquina_id){
        DB::beginTransaction();
        try{
            $maquina = Maquina_reservada::findOrFail($maquina_id);
            if($maquina){
                $maquina->delete();
            }
            DB::commit();
            return redirect()->route('areas.getMaquinas', ['area_id' => $area_id]);
        } catch(Exception $e){
            DB::rollBack();
            return redirect()->route('areas.getMaquinas', ['area_id' => $area_id]);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'colaborador_area_id' => 'required|integer|min:1|max:100',
            'maquina_id' => 'required|integer|min:1|max:255'
        ]);

        Maquina_reservada::create([
            "colaborador_area_id" => $request->colaborador_area_id,
            "maquina_id" => $request->maquina_id
        ]);

        return redirect()->route('inspiniaViews.maquinareservada.index');

    }

    public function show($maquina_reservada_id)
    {
        try {
            $maquina_reservada = Maquina_reservada::with([
                'horarios_presenciales' => function ($query) {
                    $query->select('id', 'horario_inicial', 'horario_final', 'dia'); },
                'maquinas' => function ($query) {
                    $query->select('id', 'nombre'); }
            ])->find($maquina_reservada_id);

            if (!$maquina_reservada) {
                return response()->json(["resp" => "No existe un registro con ese id"]);
            }
            return response()->json(["data" => $maquina_reservada]);
        } catch (Exception $e) {
            return response()->json(["error" => $e]);
        }

    }

    public function update(Request $request, $maquina_reservada_id)
    {
        $request->validate([
            'horario_presencial_id' => 'required|string|min:1|max:100',
            'maquina_id' => 'required|string|min:1|max:255'
        ]);

        $maquina_reservada = Maquina_reservada::findOrFail($maquina_reservada_id);

        $maquina_reservada->update($request->all());

        return redirect()->route('inspiniaViews.maquinareservada.index');
    }

    public function destroy($maquina_reservada_id)
    {
        $maquina_reservada = Maquina_reservada::findOrFail($maquina_reservada_id);

        $maquina_reservada->delete();

        return redirect()->route('inspiniaViews.maquinareservada.index');

    }

}
