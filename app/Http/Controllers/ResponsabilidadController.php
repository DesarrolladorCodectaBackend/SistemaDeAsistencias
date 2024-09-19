<?php

namespace App\Http\Controllers;

use App\Models\Responsabilidades_semanales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class ResponsabilidadController extends Controller
{
    public function index(){
        $access = FunctionHelperController::verifyAdminAccess();
        if(!$access){
            return redirect()->route('dashboard')->with('error', 'No tiene acceso para ejecutar esta acción. No lo intente denuevo o puede ser baneado.');
        }
        $responsabilidades = Responsabilidades_semanales::paginate(12);

        $pageData = FunctionHelperController::getPageData($responsabilidades);
        $hasPagination = true;

        return view('inspiniaViews.responsabilidades.gestionResponsabilidad',[
            "responsabilidades" => $responsabilidades,
            "pageData" => $pageData,
            "hasPagination" => $hasPagination,
        ]);
    }

    public function store(Request $request){
        $access = FunctionHelperController::verifyAdminAccess();
        if(!$access){
            return redirect()->route('dashboard')->with('error', 'No tiene acceso para ejecutar esta acción. No lo intente denuevo o puede ser baneado.');
        }
        DB::beginTransaction();
        try {
            $request->validate([
                'nombre' => 'required|string|min:1|max:100',
                'porcentaje_peso' => 'required|integer',
            ]);

            Responsabilidades_semanales::create([
                'nombre' => $request->nombre,
                'porcentaje_peso' => $request->porcentaje_peso
            ]);

            DB::commit();
            if($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('gestionResponsabilidad.index');
            }
        } catch(Exception $e){
            DB::rollBack();
                if($request->currentURL) {
                    return redirect($request->currentURL);
                } else {
                    return redirect()->route('gestionResponsabilidad.index');
                }
        }


    }

    public function update(Request $request, $responsabilidades_id){
        $access = FunctionHelperController::verifyAdminAccess();
        if(!$access){
            return redirect()->route('dashboard')->with('error', 'No tiene acceso para ejecutar esta acción. No lo intente denuevo o puede ser baneado.');
        }
        DB::beginTransaction();
        try{
            $request->validate([
                'nombre' => 'required|string|min:1|max:100',
                'porcentaje_peso' => 'required|integer',
            ]);

            $responsabilidades = Responsabilidades_semanales::findOrFail($responsabilidades_id);

            $responsabilidades->update($request->all());

            DB::commit();
            if($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('gestionResponsabilidad.index');
            }
        } catch(Exception $e) {
            DB::rollBack();
            if($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('gestionResponsabilidad.index');
            }
        }

    }

    public function inactive(Request $request, $responsabilidades_id){
        $access = FunctionHelperController::verifyAdminAccess();
        if(!$access){
            return redirect()->route('dashboard')->with('error', 'No tiene acceso para ejecutar esta acción. No lo intente denuevo o puede ser baneado.');
        }
        DB::beginTransaction();
        try{
            $responsabilidades = Responsabilidades_semanales::findOrFail($responsabilidades_id);

            $responsabilidades->estado = !$responsabilidades->estado;

            $responsabilidades->save();

            DB::commit();
            if($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('gestionResponsabilidad.index');
            }
        } catch(Exception $e) {
            DB::rollBack();
            if($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('gestionResponsabilidad.index');
            }
        }
    }
}
