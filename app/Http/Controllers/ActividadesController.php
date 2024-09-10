<?php

namespace App\Http\Controllers;

use App\Models\Actividades;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Http\Request;

class ActividadesController extends Controller
{
    public function index()
    {
        $access = FunctionHelperController::verifyAdminAccess();
        if(!$access){
            return redirect()->route('dashboard')->with('error', 'No tiene acceso para ejecutar esta acción. No lo intente denuevo o puede ser baneado.');
        }
        $actividades = Actividades::get();
        return view('inspiniaViews.actividades.index', ['actividades'=>$actividades]);
    }

    public function store(Request $request)
    {
        $access = FunctionHelperController::verifyAdminAccess();
        if(!$access){
            return redirect()->route('dashboard')->with('error', 'No tiene acceso para ejecutar esta acción. No lo intente denuevo o puede ser baneado.');
        }
        DB::beginTransaction();
        try {
            $request->validate([
                'nombre' => 'required|string|min:1|max:100',
            ]);

            Actividades::create([
                'nombre' => $request->nombre,
            ]);

            DB::commit();
                return redirect()->route('actividades.index');
        } catch(Exception $e){
            DB::rollBack();
                return redirect()->route('actividades.index');

        }
    }

    public function update(Request $request, $actividad_id)
    {
        $access = FunctionHelperController::verifyAdminAccess();
        if(!$access){
            return redirect()->route('dashboard')->with('error', 'No tiene acceso para ejecutar esta acción. No lo intente denuevo o puede ser baneado.');
        }
        DB::beginTransaction();
        try{
            $request->validate([
                'nombre' => 'sometimes|string|min:1|max:100',
            ]);

            $actividad = Actividades::findOrFail($actividad_id);

            $actividad->update($request->all());

            DB::commit();
                return redirect()->route('actividades.index');

        } catch(Exception $e) {
            DB::rollBack();
                return redirect()->route('actividades.index');
            }
        }


    public function activarInactivar($actividad_id)
    {
        $access = FunctionHelperController::verifyAdminAccess();
        if(!$access){
            return redirect()->route('dashboard')->with('error', 'No tiene acceso para ejecutar esta acción. No lo intente denuevo o puede ser baneado.');
        }
        DB::beginTransaction();
        try{
            $actividad = Actividades::findOrFail($actividad_id);

            $actividad->estado = !$actividad->estado;

            $actividad->save();

            DB::commit();
                return redirect()->route('actividades.index');

        } catch(Exception $e) {
            DB::rollBack();
                return redirect()->route('actividades.index');

        }

    }

}

