<?php

namespace App\Http\Controllers;

use App\Models\Colaboradores;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ReunionesProgramadas;
use App\Models\IntegrantesReuniones;
use Exception;
use Carbon\Carbon;

class ReunionesProgramadasController extends Controller
{
    public function getAllProgramReuToCalendar(){
        $reunionesProgramadas = ReunionesProgramadas::get();
        foreach ($reunionesProgramadas as $horario) {
            $horaInicial = (int) date('H', strtotime($horario->hora_inicial));
            $horaFinal = (int) date('H', strtotime($horario->hora_final));
            $year = date('Y', strtotime($horario->fecha));
            $month = date('m', strtotime($horario->fecha));
            $day = date('d', strtotime($horario->fecha));

            $month = $month -1;
    
            $horariosFormateados = [
                'hora_inicial' => $horaInicial,
                'hora_final' => $horaFinal,
                'year' => $year,
                'month' => $month,
                'day' => $day,
                'url' => route('reunionesProgramadas.show', $horario->id),
            ];
            $horario->horario_modificado = $horariosFormateados;
        }
        $horas = [
            "01:00",
            "02:00",
            "03:00",
            "04:00",
            "05:00",
            "06:00",
            "07:00", 
            "08:00", 
            "09:00", 
            "10:00", 
            "11:00", 
            "12:00", 
            "13:00", 
            "14:00", 
            "15:00", 
            "16:00", 
            "17:00", 
            "18:00", 
            "19:00", 
            "20:00", 
            "21:00", 
            "22:00",
            "23:00",
            "24:00",
        ];
        $colaboradores = Colaboradores::where('estado', 1)->get();
        // return $reunionesProgramadas;
        return view('inspiniaViews.horarios.reuniones_programadas_calendar', [
            'reunionesProgramadas' => $reunionesProgramadas,
            'horas' => $horas,
            'colaboradores' => $colaboradores,
        ]);

    }

    public function createReunionProgramada(Request $request){
        // return $request;
        DB::beginTransaction();
        try{
            $request->validate([
                'fecha' => 'required',
                'hora_inicial' => 'required',
                'hora_final' => 'required',
                'disponibilidad' => 'required|string',
                'descripcion' => 'sometimes',
                'colaboradores_id*' => 'required',
            ]);
            $descripcion = null;
            if($request->descripcion){
                $descripcion = $request->descripcion;
            }

            $newReunion = ReunionesProgramadas::create([
                "fecha" => $request->fecha,
                "hora_inicial" => $request->hora_inicial,
                "hora_final" => $request->hora_final,
                "disponibilidad" => $request->disponibilidad,
                "descripcion" => $descripcion,
            ]);

            if($newReunion){
                foreach($request->colaboradores_id as $colaborador_id){
                    IntegrantesReuniones::create([
                        "reunion_programada_id" => $newReunion->id,
                        "colaborador_id" => $colaborador_id,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('reunionesProgramadas.allReu');
        } catch(Exception $e){
            DB::rollBack();
            return redirect()->route('reunionesProgramadas.allReu');
        }
    }
    
    public function showReunionProgramada($reunion_id){
        $reunion = ReunionesProgramadas::find($reunion_id);
        $integrantes = IntegrantesReuniones::where('reunion_programada_id', $reunion_id)->where('estado', 1)->get();
        $colaboradores = Colaboradores::where('estado', 1)->get();
        $horas = [
            "01:00",
            "02:00",
            "03:00",
            "04:00",
            "05:00",
            "06:00",
            "07:00", 
            "08:00", 
            "09:00", 
            "10:00", 
            "11:00", 
            "12:00", 
            "13:00", 
            "14:00", 
            "15:00", 
            "16:00", 
            "17:00", 
            "18:00", 
            "19:00", 
            "20:00", 
            "21:00", 
            "22:00",
            "23:00",
            "24:00",
        ];

        return view('inspiniaViews.horarios.show_reunion_programada', [
            'reunion' => $reunion,
            'integrantes' => $integrantes,
            'colaboradores' => $colaboradores,
            'horas' => $horas,
        ]);
    }

    public function update(Request $request, $reunion_id){
        // return $request;
        DB::beginTransaction();
        try{
            $request->validate([
                'fecha' => 'sometimes',
                'hora_inicial' => 'sometimes',
                'hora_final' => 'sometimes',
                'disponibilidad' => 'sometimes|string',
                'descripcion' => 'sometimes',
                'colaboradores_id*' => 'sometimes',
            ]);
            $reunion = ReunionesProgramadas::findOrFail($reunion_id);

            if($reunion){
                $reunion->update([
                    "fecha" => $request->fecha,
                    "hora_inicial" => $request->hora_inicial,
                    "hora_final" => $request->hora_final,
                    "disponibilidad" => $request->disponibilidad,
                    "descripcion" => $request->descripcion,
                ]);

                foreach($request->colaboradores_id as $colaborador_id){
                    $integranteReunion = IntegrantesReuniones::where('reunion_programada_id', $reunion_id)->where('colaborador_id', $colaborador_id)->first();
                    if($integranteReunion){
                        if($integranteReunion->estado == 0){ 
                            //Si está inactivo se activa
                            $integranteReunion->update(["estado" => 1]);
                        }
                    }else{
                        IntegrantesReuniones::create([
                            "reunion_programada_id" => $reunion->id,
                            "colaborador_id" => $colaborador_id,
                        ]);
                    }
                }

                $integrantesExcluidos = IntegrantesReuniones::where('reunion_programada_id', $reunion_id)->whereNotIn('colaborador_id', $request->colaboradores_id)->where('estado', 1)->get();

                foreach($integrantesExcluidos as $integrante){
                    //Se inactiva
                    $integrante->update(["estado" => 0]);
                }

            }
    
            DB::commit();
            return redirect()->route('reunionesProgramadas.show', ["reunion_id" => $reunion_id]);
        } catch(Exception $e){
            // return $e;
            DB::rollBack();
            return redirect()->route('reunionesProgramadas.show', ["reunion_id" => $reunion_id]);
        }
    }
}
