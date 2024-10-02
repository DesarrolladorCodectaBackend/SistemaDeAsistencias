<?php

namespace App\Http\Controllers;

use App\Models\RegistroResponsabilidad;
use App\Models\Responsabilidades_semanales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Carbon;

class ResponsabilidadController extends Controller
{
    public function index()
    {
        $access = FunctionHelperController::verifyAdminAccess();
        if (!$access) {
            return redirect()->route('dashboard')->with('error', 'No tiene acceso para ejecutar esta acción. No lo intente denuevo o puede ser baneado.');
        }
        $responsabilidades = Responsabilidades_semanales::paginate(12);

        $pageData = FunctionHelperController::getPageData($responsabilidades);
        $hasPagination = true;

        return view('inspiniaViews.responsabilidades.gestionResponsabilidad', [
            "responsabilidades" => $responsabilidades,
            "pageData" => $pageData,
            "hasPagination" => $hasPagination,
        ]);
    }

    public function store(Request $request)
    {
        $access = FunctionHelperController::verifyAdminAccess();
        if (!$access) {
            return redirect()->route('dashboard')->with('error', 'No tiene acceso para ejecutar esta acción. No lo intente denuevo o puede ser baneado.');
        }
        DB::beginTransaction();
        try {
            $request->validate([
                'nombre' => 'required|string|min:1|max:100',
                'porcentaje_peso' => 'required|integer',
            ]);

            $responsabilidad = Responsabilidades_semanales::create([
                'nombre' => $request->nombre,
                'porcentaje_peso' => $request->porcentaje_peso
            ]);

            RegistroResponsabilidadController::crearRegistro($responsabilidad->id, 1);

            DB::commit();
            if ($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('gestionResponsabilidad.index');
            }
        } catch (Exception $e) {
            DB::rollBack();
            if ($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('gestionResponsabilidad.index');
            }
        }
    }

    public function update(Request $request, $responsabilidades_id)
    {
        $access = FunctionHelperController::verifyAdminAccess();
        if (!$access) {
            return redirect()->route('dashboard')->with('error', 'No tiene acceso para ejecutar esta acción. No lo intente denuevo o puede ser baneado.');
        }
        DB::beginTransaction();
        try {
            $request->validate([
                'nombre' => 'required|string|min:1|max:100',
                'porcentaje_peso' => 'required|integer',
            ]);

            $responsabilidades = Responsabilidades_semanales::findOrFail($responsabilidades_id);

            $responsabilidades->update($request->all());

            DB::commit();
            if ($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('gestionResponsabilidad.index');
            }
        } catch (Exception $e) {
            DB::rollBack();
            if ($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('gestionResponsabilidad.index');
            }
        }
    }

    public function inactive(Request $request, $responsabilidades_id)
    {
        $access = FunctionHelperController::verifyAdminAccess();
        if (!$access) {
            return redirect()->route('dashboard')->with('error', 'No tiene acceso para ejecutar esta acción. No lo intente de nuevo o puede ser baneado.');
        }

        DB::beginTransaction();
        try {
            $responsabilidades = Responsabilidades_semanales::findOrFail($responsabilidades_id);
            $responsabilidades->estado = !$responsabilidades->estado;
            $responsabilidades->save();


            $created = RegistroResponsabilidadController::crearRegistro($responsabilidades->id, 0);
            // DB::rollBack();
            // return $created;
            if(!$created){
            }
            if ($responsabilidades->estado == 0) {
                // return $responsabilidades;

                // $registrosActivos = RegistroResponsabilidad::where('responsabilidad_id', $responsabilidades->id)->where('estado', 1)->get();

                // foreach ($registrosActivos as $registro) {
                //     $registro->update(['estado' => 0]);
                // }
            }
            DB::commit();
            return $request->currentURL
                ? redirect($request->currentURL)
                : redirect()->route('gestionResponsabilidad.index');
        } catch (Exception $e) {
            DB::rollBack();
            return $request->currentURL
                ? redirect($request->currentURL)->with('error', 'Ocurrió un error al actualizar el estado, intente de nuevo. Si este error persiste, contacte a su equipo de soporte.')
                : redirect()->route('gestionResponsabilidad.index')->with('error', 'Ocurrió un error al actualizar el estado, intente de nuevo. Si este error persiste, contacte a su equipo de soporte.');
        }
    }
}
