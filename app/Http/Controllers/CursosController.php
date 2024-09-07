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
        $access = FunctionHelperController::verifyAdminAccess();
        if(!$access){
            return redirect()->route('dashboard')->with('error', 'No tiene acceso para ejecutar esta acción. No lo intente denuevo o puede ser baneado.');
        }
        $cursos = Cursos::paginate(12);

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
        $access = FunctionHelperController::verifyAdminAccess();
        if(!$access){
            return redirect()->route('dashboard')->with('error', 'No tiene acceso para ejecutar esta acción. No lo intente denuevo o puede ser baneado.');
        }
        DB::beginTransaction();
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

            DB::commit();
            if($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('cursos.index');
            }
        } catch(Exception $e){
            DB::rollBack();
            if($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('cursos.index');
            }
        }
        
        
    }
    public function update(Request $request, $curso_id)
    {
        $access = FunctionHelperController::verifyAdminAccess();
        if(!$access){
            return redirect()->route('dashboard')->with('error', 'No tiene acceso para ejecutar esta acción. No lo intente denuevo o puede ser baneado.');
        }
        DB::beginTransaction();
        try{
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
    
            DB::commit();

            if($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('cursos.index');
            }
        } catch(Exception $e){
            DB::rollBack();
            if($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('cursos.index');
            }
        }

    }


    // public function destroy($curso_id)
    // {
    //     $curso = Cursos::findOrFail($curso_id);

    //     $curso->delete();

    //     return redirect()->route('cursos.index');

    // }

    public function activarInactivar(Request $request, $curso_id)
    {
        $access = FunctionHelperController::verifyAdminAccess();
        if(!$access){
            return redirect()->route('dashboard')->with('error', 'No tiene acceso para ejecutar esta acción. No lo intente denuevo o puede ser baneado.');
        }
        DB::beginTransaction();
        try{
            $curso = Cursos::findOrFail($curso_id);
    
            $curso->estado = !$curso->estado;
    
            $curso->save();
    
            DB::commit();
            if($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('cursos.index');
            }
        } catch(Exception $e){
            DB::rollBack();
            if($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('cursos.index');
            }
        }
    }
}
