<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Responsabilidades_semanales;
use Illuminate\Support\Facades\DB;
use Exception;

class Responsabilidades_SemanalesController extends Controller
{
    //NOT USING YET
    public function index()
    {
        $responsabilidad_semanal = Responsabilidades_semanales::all();

        return view('inspiniaViews.responsabilidad_semanal.index', compact('responsabilidad_semanal'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|min:1|max:100',
            'porcentaje_peso' => 'required|string|min:1|max:255'
        ]);

        Responsabilidades_semanales::create([
            "nombre" => $request->nombre,
            "porcentaje_peso" => $request->porcentaje_peso

        ]);

        return redirect()->route('inspiniaViews.responsabilidad_semanal.index');
    }


    public function show($responsabilidad_semanal_id)
    {
        try {
            $responsabilidad_semanal = Responsabilidades_semanales::find($responsabilidad_semanal_id);

            if ($responsabilidad_semanal == null) {
                return response()->json(["resp" => "No existe un registro con ese id"]);
            }

            return response()->json(["data" => $responsabilidad_semanal]);
        } catch (Exception $e) {
            return response()->json(["error" => $e]);
        }
       
    }


    public function update(Request $request, $responsabilidad_semanal_id)
    {
        $request->validate([
            'nombre' => 'required|string|min:1|max:100',
            'porcentaje_peso' => 'required|string|min:1|max:255'
        ]);

        $responsabilidad_semanal = Responsabilidades_semanales::findOrFail($responsabilidad_semanal_id);

        $responsabilidad_semanal->update($request->all());

        return redirect()->route('inspiniaViews.responsabilidad_semanal.index');
    }


    public function destroy($responsabilidad_semanal_id)
    {
        $responsabilidad_semanal = Responsabilidades_semanales::findOrFail($responsabilidad_semanal_id);

        $responsabilidad_semanal->delete();

        return redirect()->route('inspiniaViews.responsabilidad_semanal.index');

    }
}
