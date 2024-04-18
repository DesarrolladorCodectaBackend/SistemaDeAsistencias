<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cursos;
use Illuminate\Support\Facades\DB;
use Exception;

class CursosController extends Controller
{
    public function index()
    {
        $curso = Cursos::all();

        return view('curso.index', compact('curso'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|min:1|max:100',
            'categoria' => 'required|string|min:1|max:255',
            'duracion' =>  'required|integer|min:1|max:15'
        ]);

        Cursos::create([
            'nombre' => $request->especializacion,
            'categoria' => $request->descripcion,
            'duracion' => $request->duracion
        ]);

        
        return redirect()->route('curso.index');

    }


    public function show($curso_id)
    {
        try {
            $curso = Cursos::find($curso_id);

            if ($curso == null) {
                return response()->json(["resp" => "No existe un registro con ese id"]);
            }

            return response()->json(["data" => $curso]);
        } catch (Exception $e) {
            return response()->json(["error" => $e]);
        }
       
    }


    public function update(Request $request, $curso_id)
    {
        $request->validate([
            'nombre' => 'required|string|min:1|max:100',
            'categoria' => 'required|string|min:1|max:255',
            'duracion' =>  'required|integer|min:1|max:15'
        ]);
        
        $curso = Cursos::findOrFail($curso_id);


        $curso->update($request->all());

        return redirect()->route('curso.index');

    }


    public function destroy($curso_id)
    {
        $curso = Cursos::findOrFail($curso_id);

        $curso->delete();

        return redirect()->route('curso.index');

    }
}
