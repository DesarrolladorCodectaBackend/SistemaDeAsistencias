<?php

namespace App\Http\Controllers;

use App\Models\Horarios_Presenciales;
use Illuminate\Http\Request;
use App\Http\Requests\StoreHorarios_PresencialesRequest;
use App\Http\Requests\UpdateHorarios_PresencialesRequest;
use Illuminate\Support\Facades\DB;
use Exception;

class HorariosPresencialesController extends Controller
{

    public function index()
    {
        try {
            $horarios_presenciales = Horarios_Presenciales::get();
            if (count($horarios_presenciales) == 0) {
                return response()->json(["resp" => "No hay registros insertados"]);
            }
            return response()->json(["data" => $horarios_presenciales, "conteo" => count($horarios_presenciales)]);
        } catch (Exception $e) {
            return response()->json(["error" => $e]);
        }
    }


    public function create(Request $request)
    {

        $request->validate([
            'hora_inicial' => 'required|string|min:1|max:100',
            'hora_final' => 'required|string|min:1|max:255',
            'dia' =>  'required|string|min:1|max:7',
        ]);

        Horarios_Presenciales::create([
                "hora_inicial" => $request->hora_inicial,
                "hora_final" => $request->hora_final,
                "dia" => $request->dia
        ]);
 
    }


    public function show($horario_presencial_id)
    {
        try {
            $horario = Horarios_Presenciales::find($horario_presencial_id);

            if ($horario == null) {
                return response()->json(["resp" => "No existe un registro con ese id"]);
            }

            return response()->json(["data" => $horario]);
        } catch (Exception $e) {
            return response()->json(["data" => $e]);
        }
    }


    public function update(Request $request, $horario_presencial_id)
    {
        $request->validate([
            'hora_inicial' => 'required|string|min:1|max:100',
            'hora_final' => 'required|string|min:1|max:255',
            'dia' =>  'required|string|min:1|max:7',
        ]);
        
        $horarios_presenciales = horarios_presenciales::findOrFail($horario_presencial_id);

        $horarios_presenciales->update($request->all());

        return redirect()->route('horarios_presenciales.index');
    }


    public function destroy($horario_presencial_id)
    {
        $horarios_presenciales = horarios_presenciales::findOrFail($horario_presencial_id);

            if ($horario == null) {
                return response()->json(["resp" => "No existe un registro con ese id"]);
            }

            $horario->delete();
            DB::commit();
            return response()->json(["resp" => "Horario presencial con id " . $horario_presencial_id . " eliminado"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["error" => $e]);
        }
    }
}
