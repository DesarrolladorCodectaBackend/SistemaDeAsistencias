<?php

namespace App\Http\Controllers;

use App\Models\Horario_de_Clases;
use App\Models\Colaboradores;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HorarioDeClasesController extends Controller
{
    public function index()
    {
        try {
            $horario_de_clases = Horario_de_Clases::with('colaboradores')->get();

            if (count($horario_de_clases) == 0) {
                return response()->json(["resp" => "No hay registros insertados"]);
            }

            return response()->json(["data" => $horario_de_clases, "conteo" => count($horario_de_clases)]);
        } catch (Exception $e) {
            return response()->json(["error" => $e]);
        }

    }

    public function getCalendariosColaborador($colaborador_id)
    {
        $horariosDeClases = Horario_de_Clases::where('colaborador_id', $colaborador_id)->get();
        $horariosFormateados = [];

        $colaborador = Colaboradores::findOrFail($colaborador_id);

        foreach ($horariosDeClases as $horario) {
            $horaInicial = (int) date('H', strtotime($horario->hora_inicial));
            $horaFinal = (int) date('H', strtotime($horario->hora_final));

            $horariosFormateados[] = [
                'hora_inicial' => $horaInicial,
                'hora_final' => $horaFinal,
                'dia' => $horario->dia,
            ];
        }

        return view('inspiniaViews.colaboradores.horario_clases', [
            'horariosDeClases' => $horariosDeClases,
            'horariosFormateados' => $horariosFormateados,
            'colaborador' => $colaborador
        ]);
    }


    public function store(Request $request)
    {
        // return $request;
        $request->validate([
            'colaborador_id' => 'required|integer',
            'horarios' => 'required|array',
            'horarios.*.hora_inicial' => 'required|date_format:H:i',
            'horarios.*.hora_final' => 'required|date_format:H:i',
            'horarios.*.dia' => 'required|string'
        ]);
        foreach ($request->horarios as $horario) {
            Horario_de_Clases::create([
                'colaborador_id' => $request->colaborador_id,
                'hora_inicial' => $horario['hora_inicial'],
                'hora_final' => $horario['hora_final'],
                'dia' => $horario['dia']
            ]);
        }
        return redirect()->route('colaboradores.horarioClase', ['colaborador_id' => $request->colaborador_id]);
    }

    /*
    public function create(Request $request)
    {
        DB::beginTransaction();
        try{
            if(!$request->colaborador_id){
                return response()->json(["resp" => "Ingrese colaborador"]);
            }

            if(!$request->hora_inicial){
                return response()->json(["resp" => "Ingrese hora inicial"]);
            }

            if(!$request->hora_final){
                return response()->json(["resp" => "Ingrese hora final"]);
            }

            if(!$request->dia){
                return response()->json(["resp" => "Ingrese dia"]);
            }

            if(!is_integer($request->colaborador_id)){
                return response()->json(["resp" => "El id del colaborador debe ser un número entero"]);
            }

            if(!is_string($request->hora_inicial)){
                return response()->json(["resp" => "La hora inicial debe ser un texto"]);
            }

            if(!is_string($request->hora_final)){
                return response()->json(["resp" => "La hora final debe ser un texto"]);
            }

            if(!is_string($request->dia)){
                return response()->json(["resp" => "El dia debe ser un texto"]);
            }

            Horario_de_Clases::create([
                "colaborador_id" => $request->colaborador_id,
                "hora_inicial" => $request->hora_inicial,
                "hora_final" => $request->hora_final,
                "dia" => $request->dia
            ]);
            DB::commit();
            return response()->json(["resp" => "Registro creado correctamente"]);
        } catch (Exception $e){
            DB::rollBack();
            return response()->json(["error" => $e]);
        }
    }
    */


    public function show($horario_de_clases_id)
    {
        try {
            $horario_de_clases = Horario_de_Clases::with('colaboradores')->find($horario_de_clases_id);

            if (!$horario_de_clases) {
                return response()->json(["resp" => "No existe un registro con ese id"]);
            }

            return response()->json(["data" => $horario_de_clases]);
        } catch (Exception $e) {
            return response()->json(["error" => $e]);
        }

    }


    public function update(Request $request, $horario_de_clases_id)
    {
        $horario_de_clases = Horario_de_Clases::find($horario_de_clases_id);

        $request->validate([
            'dia' => 'sometimes|string|min:1|max:100',
            'hora_inicial' => 'sometimes',
            'hora_final' => 'sometimes',
        ]);

        //$horario_de_clases->update($request->all());
        $horario_de_clases->fill([
            "hora_inicial" => $request->hora_inicial,
            "hora_final" => $request->hora_final,
            "dia" => $request->dia
        ])->save();

        return redirect()->route('colaboradores.horarioClase', ['colaborador_id' => $horario_de_clases->colaborador_id]);
    }


    public function destroy($horario_de_clases_id)
    {
        $horario_de_clases = Horario_de_Clases::findOrFail($horario_de_clases_id);

        $horario_de_clases->delete();

        return redirect()->route('colaboradores.horarioClase', ['colaborador_id' => $horario_de_clases->colaborador_id]);
    }
}
