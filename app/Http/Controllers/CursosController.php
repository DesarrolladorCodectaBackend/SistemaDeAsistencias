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
        $cursos = Cursos::paginate(2);

        $pageData = FunctionHelperController::getPageData($cursos);
        $hasPagination = true;

        return view('inspiniaViews.cursos.index', [
            'cursos' => $cursos,
            'pageData' => $pageData,
            'hasPagination' => $hasPagination
        ]);
    }


    public function store(Request $request)
    {
        try{
            $request->validate([
                'nombre' => 'required|string|min:1|max:100',
                'categoria' => 'required|string|min:1|max:100',
                'duracion' =>  'required|string|min:1|max:15'
            ]);

            Cursos::create([
                'nombre' => $request->nombre,
                'categoria' => $request->categoria,
                'duracion' => $request->duracion
            ]);

            if($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('cursos.index');
            }
        } catch(Exception $e){
            if($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('cursos.index');
            }
        }
        
        
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
            'nombre' => 'sometimes|string|min:1|max:100',
            'categoria' => 'sometimes|string|min:1|max:255',
            'duracion' =>  'sometimes|string|min:1|max:15'
        ]);
        
        $curso = Cursos::findOrFail($curso_id);

        
        $curso->fill([
            "nombre" => $request->nombre,
            "categoria" => $request->categoria,
            "duracion" => $request->duracion
        ])->save();

        if($request->currentURL) {
            return redirect($request->currentURL);
        } else {
            return redirect()->route('cursos.index');
        }

    }


    public function destroy($curso_id)
    {
        $curso = Cursos::findOrFail($curso_id);

        $curso->delete();

        return redirect()->route('cursos.index');

    }

    public function activarInactivar(Request $request, $curso_id)
    {
        $curso = Cursos::findOrFail($curso_id);

        $curso->estado = !$curso->estado;

        $curso->save();

        if($request->currentURL) {
            return redirect($request->currentURL);
        } else {
            return redirect()->route('cursos.index');
        }
    }
}
