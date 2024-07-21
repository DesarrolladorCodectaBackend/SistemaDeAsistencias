<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sede;
use App\Models\Institucion;
use Illuminate\Support\Facades\DB;
use Exception;

class SedeController extends Controller
{
    public function index()
    {
        $sedes = Sede::with('institucion')->orderBy('nombre', 'asc')->paginate(12);
        $instituciones = Institucion::where('estado', 1)->orderBy('nombre', 'asc')->get();

        $pageData = FunctionHelperController::getPageData($sedes);
        $hasPagination = true;

        return view('inspiniaViews.sedes.index', [
            "sedes" => $sedes,
            "instituciones" => $instituciones,
            "pageData" => $pageData,
            "hasPagination" => $hasPagination,
        ]);
    }

    public function store(Request $request){
        DB::beginTransaction();
        try {
            $request->validate([
                'nombre' => 'required|string|max:100',
                'institucion_id' => 'required|integer|exists:institucions,id',
            ]);
            $institucion = Institucion::findOrFail($request->institucion_id);
            if($institucion){
                Sede::create([
                    'nombre' => $institucion->nombre." - ".$request->nombre,
                    'institucion_id' => $request->institucion_id,
                ]);
            }
            DB::commit();
            if($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('sedes.index');
            }
        } catch (Exception $e) {
            DB::rollBack();
            if($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('sedes.index');
            }
        }
    }

    public function update(Request $request, $sede_id){
        DB::beginTransaction();
        try {
            $request->validate([
                'nombre' => 'required|string|max:100',
                'institucion_id' => 'required|integer|exists:institucions,id',
            ]);
            $sede = Sede::findOrFail($sede_id);
            if($sede){
                $institucion = Institucion::findOrFail($request->institucion_id);
                if($institucion){
                    $sede->update([
                        'nombre' => $request->nombre,
                        'institucion_id' => $request->institucion_id,
                    ]);
                }
            }
            DB::commit();
            if($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('sedes.index');
            }
        } catch (Exception $e) {
            DB::rollBack();
            if($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('sedes.index');
            }
        }
    }

    public function activarInactivar(Request $request, $sede_id){
        DB::beginTransaction();
        try{
            $sede = Sede::findOrFail($sede_id);
            if($sede){
                $sede->update([
                    'estado' => !$sede->estado,
                ]);
            }
            DB::commit();
            if($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('sedes.index');
            }
        } catch(Exception $e){
            DB::rollBack();
            if($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('sedes.index');
            }
        }
    }

}
