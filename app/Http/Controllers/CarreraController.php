<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCarreraRequest;
use App\Http\Requests\UpdateCarreraRequest;
use Illuminate\Support\Facades\DB;
use Exception;

class CarreraController extends Controller
{

    public function index()
    {
        $access = FunctionHelperController::verifyAdminAccess();
        if(!$access){
            return redirect()->route('dashboard')->with('error', 'No tiene acceso para ejecutar esta acción. No lo intente denuevo o puede ser baneado.');
        }
        $carreras = Carrera::paginate(12);

        $pageData = FunctionHelperController::getPageData($carreras);
        $hasPagination = true;

        return view('inspiniaViews.carreras.index', [
            'carreras' => $carreras,
            'pageData' => $pageData, 
            'hasPagination' => $hasPagination,
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
    
            ]);
    
            Carrera::create([
                'nombre' => $request->nombre,
            ]);
    
    
            DB::commit();
            if($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('carreras.index');
            }
        } catch(Exception $e){
            DB::rollBack();
            if($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('carreras.index');
            }
        }


    }



    public function update(Request $request, $carrera_id)
    {
        $access = FunctionHelperController::verifyAdminAccess();
        if(!$access){
            return redirect()->route('dashboard')->with('error', 'No tiene acceso para ejecutar esta acción. No lo intente denuevo o puede ser baneado.');
        }
        DB::beginTransaction();
        try{
            $request->validate([
                'nombre' => 'sometimes|string|min:1|max:100',
                'estado' => 'sometimes|boolean'
            ]);
    
            $carrera = Carrera::findOrFail($carrera_id);
    
            $carrera->update($request->all());
    
            DB::commit();
            if($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('carreras.index');
            }
        } catch(Exception $e){
            DB::rollBack();
            if($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('carreras.index');
            }
        }

    }


    public function destroy($carrera_id)
    {
        $access = FunctionHelperController::verifyAdminAccess();
        if(!$access){
            return redirect()->route('dashboard')->with('error', 'No tiene acceso para ejecutar esta acción. No lo intente denuevo o puede ser baneado.');
        }
        $carrera = Carrera::findOrFail($carrera_id);

        $carrera->delete();

        return redirect()->route('carreras.index');

    }

    public function activarInactivar(Request $request,$carrera_id)
    {
        $access = FunctionHelperController::verifyAdminAccess();
        if(!$access){
            return redirect()->route('dashboard')->with('error', 'No tiene acceso para ejecutar esta acción. No lo intente denuevo o puede ser baneado.');
        }
        DB::beginTransaction();
        try{
            $carrera = Carrera::findOrFail($carrera_id);

            $carrera->estado = !$carrera->estado;

            $carrera->save();

            DB::commit();
            if($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('carreras.index');
            }
        } catch(Exception $e){
            DB::rollBack();
            if($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('carreras.index');
            }
        }
        
    }

}
