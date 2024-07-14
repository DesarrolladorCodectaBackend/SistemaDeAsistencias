<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Horario_Presencial_Asignado;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AreaController;
use Exception;

class Horario_Presencial_AsignadoController extends Controller
{
    public function index()
    {
        try {
            $horarios_presenciales_Asignados = Horario_Presencial_Asignado::with(['horario_presencial', 'area'])->get();

            foreach ($horarios_presenciales_Asignados as $horario) {
                $horaInicial = (int) date('H', strtotime($horario->horario_presencial->hora_inicial));
                $horaFinal = (int) date('H', strtotime($horario->horario_presencial->hora_final));
        
                $horariosFormateados = [
                    'hora_inicial' => $horaInicial,
                    'hora_final' => $horaFinal,
                    'dia' => $horario->horario_presencial->dia,
                ];
                $horario->horario_modificado = $horariosFormateados;
            }

            return view('InspiniaViews.horarios.horario_general_presencial', compact('horarios_presenciales_Asignados'));
            // return response()->json(["data" => $horarios_presenciales_Asignados]);

        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()]);
        }
    }



    public function store(Request $request)
    {
        DB::beginTransaction();
        try{
            // return $request;
            $request->validate([
                "horario_presencial_id.*" => "required|integer",
                "area_id" => "required|integer",
            ]);

            // if(!$request->horario_presencial_id){
            //     return response()->json(["resp" => "Ingrese el horario presencial"]);
            // }

            // if(!$request->area_id){
            //     return response()->json(["resp" => "Ingrese el area"]);
            // }

            foreach($request->horario_presencial_id as $horario_presencial_id) {

                Horario_Presencial_Asignado::create([
                    "horario_presencial_id" => $horario_presencial_id,
                    "area_id" => $request->area_id
                ]);
            }


            DB::commit();
            // return response()->json(["resp" => "Registro creado exitosamente"]);
            return redirect()->route('areas.getHorario', ['area_id' => $request->area_id]);
        }catch(Exception $e){
            DB::rollBack();
            return response()->json(["error" => $e]);
        }

    }


    public function show($horario_presencial_asignado_id)
    {
        try{
            $horario_presencial_asignado = Horario_Presencial_Asignado::/*with([
                'institucion' => function ($query) {
                    $query->select('id', 'nombre'); },
                'carrera' => function ($query) {
                    $query->select('id', 'nombre'); }
            ])->*/find($horario_presencial_asignado_id);
            if (!$horario_presencial_asignado){
                return response()->json(["resp" => "No existe un registro con ese id"]);
            }
            return response()->json(["Data" => $horario_presencial_asignado]);
        } catch (Exception $e){
            return response()->json(["error" => $e]);
        }
    }


    public function update(Request $request, $horario_presencial_asignado_id)
    {
        DB::beginTransaction();
        try{
            $request->validate([
                "horario_presencial_id" => "required|integer",
                "area_id" => "required|integer",
            ]);
            $horario_presencial_asignado = Horario_Presencial_Asignado::find($horario_presencial_asignado_id);

            if (!$horario_presencial_asignado){
                return response()->json(["resp" => "No existe un registro con ese id"]);
            }

            if(!$request->horario_presencial_id){
                return response()->json(["resp" => "Ingrese el horario presencial"]);
            }

            if(!$request->area_id){
                return response()->json(["resp" => "Ingrese el area"]);
            }

            $horario_presencial_asignado->update($request->all());
            
            DB::commit();
            // return response()->json(["resp" => "Registro actualizado correctamente"]);
            return redirect()->route('areas.getHorario', ['area_id' => $request->area_id]);
        } catch(Exception $e){
            DB::rollBack();
            return response()->json(["error" => $e]);
        }


    }


    public function destroy($area_id, $horario_presencial_asignado_id)
    {
        DB::beginTransaction();
        try{
            // return [$area_id, $horario_presencial_asignado_id];
            
            $horario_presencial_asignado = Horario_Presencial_Asignado::findOrFail($horario_presencial_asignado_id);

            if (!$horario_presencial_asignado){
                return redirect()->route('areas.getHorario', ['area_id' => $area_id]);
            }

            $horario_presencial_asignado->delete();
            
            DB::commit();
            return redirect()->route('areas.getHorario', ['area_id' => $area_id]);
            // return response()->json(["resp" => "Candidato eliminado correctamente"]);
        } catch (Exception $e){
            DB::rollBack();
            // return response()->json(["error" => $e]);
            return redirect()->route('areas.getHorario', ['area_id' => $area_id]);
        }


    }
}
