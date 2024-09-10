<?php

namespace App\Http\Controllers;

use App\Models\Maquinas;
use App\Models\Salones;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSalonesRequest;
use App\Http\Requests\UpdateSalonesRequest;
use Illuminate\Support\Facades\DB;
use Exception;

class SalonesController extends Controller
{
    
    public function index()
    {
        $access = FunctionHelperController::verifyAdminAccess();
        if(!$access){
            return redirect()->route('dashboard')->with('error', 'No tiene acceso para ejecutar esta acción. No lo intente denuevo o puede ser baneado.');
        }
        $salones = Salones::paginate(12);

        foreach($salones as $salon){
            $maquinas = Maquinas::where('salon_id', $salon->id)->get();
            $conteoMaquinas = $maquinas->count();
            $salon->cant_maquinas = $conteoMaquinas;
            $salon->maquinas = $maquinas;
        }

        // return $salones;
        $pageDate = FunctionHelperController::getPageData($salones);
        $hasPagination = true;

        return view('inspiniaViews.salones.index', [
            'salones' => $salones, 
            'pageData' => $pageDate, 
            'hasPagination' => $hasPagination
        ]);
    }
    
    // public function create(Request $request)
    // {
    //     Salones::create([
    //         "nombre" => $request->nombre,
    //         "descripcion" => $request->descripcion
    //     ]);

    //     return response()->json(["resp" => "Salón creado"]);
    // }

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
                'descripcion' => 'required|string|min:1|max:255',
            ]);
    
     
            //Salones::create($request->all());
    
            Salones::create([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
            ]);
    
            DB::commit();
            if($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('salones.index');
            }
        } catch (Exception $e) {
            DB::rollback();
            if($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('salones.index');
            }

        }

    }

    
    //public function show($salon_id)
    //{
      //  $salon = Salones::find($salon_id);

        //return response()->json(["data" => $salon]);
    //}

    
    public function update(Request $request, $salon_id)
    {
        $access = FunctionHelperController::verifyAdminAccess();
        if(!$access){
            return redirect()->route('dashboard')->with('error', 'No tiene acceso para ejecutar esta acción. No lo intente denuevo o puede ser baneado.');
        }
        DB::beginTransaction();
        try{
            $request->validate([
                'nombre' => 'required|string|min:1|max:100',
                'descripcion' => 'required|string|min:1|max:255',
            ]);
            
            $salon = Salones::findOrFail($salon_id);
            
            $datosActualizar = $request->all();
    
            $salon->update($datosActualizar);
            DB::commit();
            if($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('salones.index');
            }
        } catch(Exception $e) {
            DB::rollback();
            if($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('salones.index');
            }
        }

    }

    
    public function destroy($salon_id)
    {
        $access = FunctionHelperController::verifyAdminAccess();
        if(!$access){
            return redirect()->route('dashboard')->with('error', 'No tiene acceso para ejecutar esta acción. No lo intente denuevo o puede ser baneado.');
        }
        $salon = Salones::findOrFail($salon_id);

        $salon->delete();

        return redirect()->route('salones.index');
    }

    public function activarInactivar(Request $request, $salon_id)
    {
        $access = FunctionHelperController::verifyAdminAccess();
        if(!$access){
            return redirect()->route('dashboard')->with('error', 'No tiene acceso para ejecutar esta acción. No lo intente denuevo o puede ser baneado.');
        }
        DB::beginTransaction();
        try{
            $salon = Salones::findOrFail($salon_id);
    
            $salon->estado = !$salon->estado;
    
            $salon->save();
    
            DB::commit();
            if($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('salones.index');
            }
        } catch(Exception $e) {
            DB::rollback();
            if($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('salones.index');
            }

        }
    }
}
