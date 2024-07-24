<?php

namespace App\Http\Controllers;

use App\Models\Colaboradores_por_Area;
use App\Models\Horarios_Presenciales;
use App\Models\Maquina_reservada;
use Illuminate\Http\Request;
use App\Models\Horario_Presencial_Asignado;
use App\Models\Area;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AreaController;
use Exception;

class Horario_Presencial_AsignadoController extends Controller
{
    public function index()
    {
        try {
            $areasActivasId = Area::where('estado', 1)->get()->pluck('id');
            $horarios_presenciales_Asignados = Horario_Presencial_Asignado::with(['horario_presencial', 'area'])->whereIn('area_id', $areasActivasId)->get();

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

            //TO DO: Tras crear el horario se verificará si hay maquinas que choquen con otras de las áreas concurrentes
            //Si chocan ya sea con otro colaborador o el mismo pero en alguna de sus areas, se eliminará sin más

            // $area = Area::findOrFail($request->area_id);
            // if($area){
            //     // return $area;
            //     $areasConcurrentesWithoutThis = FunctionHelperController::getAreasConcurrentes(["area" => $area, "WithThis" => false, "active" => true]);
            //     // return $areasConcurrentes;
            //     // $areasConcurrentesWithoutThis = $areasConcurrentes->whereNot('id', $area->id);
            //     //Encontrar las maquinas reservadas del área
            //     $colaboradoresArea = Colaboradores_por_Area::with('colaborador')->where('area_id', $area->id)->where('estado', 1)->get();
            //     $maquinasReservadas = Maquina_reservada::whereIn('colaborador_area_id', $colaboradoresArea->pluck('id'))->get();
            //     $colaboradoresBaseArea = $colaboradoresArea->pluck('colaborador');
            //     // return $colaboradoresBaseArea;
            //     //Encontrar las maquinas reservadas de las áreas concurrentes
            //     $colaboradoresAreasConcurrentes = Colaboradores_por_Area::with('colaborador')->whereIn('area_id', $areasConcurrentesWithoutThis->pluck('id'))
            //         ->where('estado', 1)->whereNotIn('colaborador_id', $colaboradoresBaseArea->pluck('id'))->get();
                
            //     $maquinasReservadasAreasConcurrentes = Maquina_reservada::whereIn('colaborador_area_id', $colaboradoresAreasConcurrentes->pluck('id'))->get();

            //     //Buscar coincidencias
            //     $coincidencias = 0;
            //     foreach($maquinasReservadas as $maquinaReservada) {
            //         foreach($maquinasReservadasAreasConcurrentes as $maquinaReservadaAreaConcurrente) {
            //             if($maquinaReservada->maquina_id === $maquinaReservadaAreaConcurrente->maquina_id){
                            
            //             }
            //         }
            //     }
            //     return $maquinasReservadasAreasConcurrentes;
            // }
                // return $areasConcurrentesWithoutThis;

                $horariosPresencialesRegistros = Horarios_Presenciales::whereIn('id', $request->horario_presencial_id)->get();
                
                foreach($horariosPresencialesRegistros as $horarioPresencialRegistro) {
                    $horarioExistente = Horario_Presencial_Asignado::where('horario_presencial_id', $horarioPresencialRegistro->id)
                        ->where('area_id', $request->area_id)->first();
                    if(!$horarioExistente){
                        Horario_Presencial_Asignado::create([
                            "horario_presencial_id" => $horarioPresencialRegistro->id,
                            "area_id" => $request->area_id
                        ]);
                    }
                }




            DB::commit();
            // return response()->json(["resp" => "Registro creado exitosamente"]);
            return redirect()->route('areas.getHorario', ['area_id' => $request->area_id]);
        }catch(Exception $e){
            DB::rollBack();
            return $e;
            // return response()->json(["error" => $e]);
            return redirect()->route('areas.getHorario', ['area_id' => $request->area_id]);
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
