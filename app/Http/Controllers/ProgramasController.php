<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Programas;

class ProgramasController extends Controller
{
    public function index()
    {
        $Programas = Programas::get();

        return response()->json(["data" => $Programas, "conteo" => count($Programas)]);
    }

    
    public function create(){
        return view('programas.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            "nombre" => $request->nombre,
            "descripcion" => $request->descripcion,
            "memoria_grafica" => $request->memoria_grafica,
            "ram" => $request->ram
        ]);

        Programa::create([
            "nombre" => $request->nombre,
            "descripcion" => $request->descripcion,
            "memoria_grafica" => $request->memoria_grafica,
            "ram" => $request->ram
        ]);

        
        return redirect()->route('programas.index');
    }
    
    public function show($programa_id)
    {
        $programa = Programas::find($programa_id);

        return response()->json(["data" => $programa]);
    }

    
    public function update(Request $request, $programa_id)
    {
        $programa = Programas::find($programa_id);

        $programa->fill([
            "nombre" => $request->nombre,
            "descripcion" => $request->descripcion,
            "memoria_grafica" => $request->memoria_grafica,
            "ram" => $request->ram
        ])->save();

        return response()->json(["resp" => "Programa con id ".$programa_id." actualizado"]);
    }

    
    public function destroy($programa_id)
    {
        $programa = Programas::find($programa_id);

        $programa->delete();

        return response()->json(["resp" => "Programa con id ".$programa_id." eliminado"]);

        return redirect()->route('programas.index');
    }
}
