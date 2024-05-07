<?php

namespace App\Http\Controllers;

use App\Models\Maquina_reservada;
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

    public function store(Request $request)
    {
        $request->validate([
            'horario_presencial_id' => 'required|string|min:1|max:100',
            'maquina_id' => 'required|string|min:1|max:255'
        ]);

        Maquina_reservada::create([
            "horario_presencial_id" => $request->horario_presencial_id,
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
