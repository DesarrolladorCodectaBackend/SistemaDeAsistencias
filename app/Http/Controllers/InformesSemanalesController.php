<?php

namespace App\Http\Controllers;

use App\Http\Requests\InformesSemanalesRequest;
use App\Models\Area;
use App\Models\Colaboradores_por_Area;
use App\Models\InformeSemanal;
use App\Models\Semanas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

use App\Http\Log;
class InformesSemanalesController extends Controller
{

    public function store(Request $request)
{
    DB::beginTransaction();
    try {
        // obtiene el año, mes, area_id, semana_id
        $year = $request->year;
        $mes = $request->mes;
        $area_id = $request->area_id;
        $semana_id = $request->semana_id;

        $returnRoute = route('responsabilidades.asis', ['year' => $year, 'mes' => $mes, 'area_id' => $area_id]);

        // Validación de la semana
        $semana = Semanas::find($semana_id);
        $thisWeekMonday = Carbon::today()->startOfWeek()->toDateString();
        $thisSemana = Semanas::where('fecha_lunes', $thisWeekMonday)->first();

        if ($thisSemana->id < $semana->id) {
            $warnings['semana_futura' . $semana_id] = 'No se puede crear informes en semanas futuras.';
            return redirect()->route('responsabilidades.asis', ['year' => $year, 'mes' => $mes, 'area_id' => $area_id])
                ->with('warning', $warnings)
                ->with('current_semana_id', $request->semana_id);
        }

        // Validación de errores
        $errors = [];

        // Validación de título
        if (!isset($request->titulo) || trim($request->titulo) === '') {
            $errors['titulo' . $semana_id] = 'El título es un campo requerido.';
        } else if (strlen($request->titulo) > 150) {
            $errors['titulo' . $semana_id] = 'El título no puede exceder los 150 caracteres.';
        }

        // Validación de nota_semanal
        if (strlen($request->nota_semanal) > 2000) {
            $errors['nota_semanal' . $semana_id] = 'La nota semanal no puede exceder los 2000 caracteres.';
        }

        // Validación de informe_url
        if (!$request->hasFile('informe_url')) {
            $errors['informe_url' . $semana_id] = 'Es obligatorio subir un archivo.';
        } else {
            $informe = $request->file('informe_url');
            $extensionVal = $informe->getClientOriginalExtension();
            $extensiones = ['pdf', 'docx'];

            if (!in_array($extensionVal, $extensiones)) {
                $errors['informe_url' . $semana_id] = 'El informe debe ser un archivo de tipo: ' . implode(', ', $extensiones);
            }
        }

        // Si hay errores, redirigir sin procesar la creación
        if (!empty($errors)) {
            return redirect($returnRoute)
                ->with('error', $errors)
                ->with('current_semana_id', $request->semana_id);
        }

        // Procesar la creación del informe
        $nombreInforme = time() . '.' . $informe->getClientOriginalExtension();
        $informe->move(public_path('storage/informes'), $nombreInforme);

        // Crear el informe
        InformeSemanal::create([
            'titulo' => $request->titulo,
            'nota_semanal' => $request->nota_semanal,
            'informe_url' => $nombreInforme,
            'semana_id' => $semana_id,
            'area_id' => $area_id
        ]);

        DB::commit();
        return redirect($returnRoute);
    } catch (Exception $e) {
        DB::rollBack();
        return redirect()->route('responsabilidades.asis', ['year' => $year, 'mes' => $mes, 'area_id' => $area_id])
            ->with('error', 'Ocurrió un error al actualizar, intente de nuevo. Si este error persiste, contacte a su equipo de soporte.');
    }
}


    public function update(Request $request, $InformeSemanal)
    {
        DB::beginTransaction();
        try {
            $year = $request->year;
            $mes = $request->mes;
            $area_id = $request->area_id;
            $semana_id = $request->semana_id;

            $returnRoute = route('responsabilidades.asis', ['year' => $year, 'mes' => $mes, 'area_id' => $area_id]);

            $informe = InformeSemanal::findOrFail($InformeSemanal);

            // Validaciones
            $errors = [];

            if (!isset($request->titulo)) {
                $errors['titulo' .$semana_id] = 'El titulo es un campo requerido.';
            } else {
                if (strlen($request->titulo) > 150) {
                    $errors['titulo' .$semana_id] = 'El titulo no puede exceder los 150 caracteres.';
                }
            }


            if (strlen($request->nota_semanal) > 2000) {
                $errors['nota_semanal' .$semana_id] = 'La nota semanal no puede exceder los 2000 caracteres.';
            }


            if ($request->hasFile('informe_url')) {
                $extensiones = ['pdf', 'docx'];
                $extensionVal = $request->file('informe_url')->getClientOriginalExtension();

                if (!in_array($extensionVal, $extensiones)) {
                    $errors['informe_url' .$semana_id] = 'El informe debe ser un archivo de tipo: ' . implode(', ', $extensiones);
                }
            }

            if (!empty($errors)) {
                return redirect()->route('responsabilidades.asis', ['year' => $year, 'mes' => $mes, 'area_id' => $area_id])->with('error',$errors)->with('current_semana_id', $request->semana_id);
            }

            // Preparar los datos para actualizar
            $datosActualizar = $request->except(['informe_url']);

            if ($request->hasFile('informe_url')) {
                $rutaPublica = public_path('storage/informes');

                if ($informe->informe_url && file_exists($rutaPublica . '/' . $informe->informe_url)) {
                    unlink($rutaPublica . '/' . $informe->informe_url);
                }

                $archivo = $request->file('informe_url');
                $nombreInforme = time() . '.' . $archivo->getClientOriginalExtension();
                $archivo->move($rutaPublica, $nombreInforme);

                $datosActualizar['informe_url'] = $nombreInforme;
            }

            $informe->update($datosActualizar);
            DB::commit();
            return redirect($returnRoute);
        } catch (Exception $e) {
            return redirect()->route($returnRoute)->with('error', 'Ocurrió un error al actualizar, intente denuevo. Si este error persiste, contacte a su equipo de soporte.');
        }
    }


    public function show($InformeSemanal)
    {
        // Obtener el informe con el ID proporcionado
        $informe = InformeSemanal::findOrFail($InformeSemanal);

        $year = $informe->year;
        $mes = $informe->mes;
        $semana_id = $informe->semana_id;
        $area_id = $informe->area_id;

        // Pasar todos los datos a la vista
        return view('inspiniaViews.responsabilidades.asistencia', compact('informe', 'year', 'mes', 'semana_id', 'area_id'));
    }

    public function destroy(Request $request, $InformeSemanal)
    {
        $area_id = $request->area_id;
        $year = $request->year;
        $mes = $request->mes;

        $informe = InformeSemanal::findOrFail($InformeSemanal);

        // Eliminar el archivo asociado si existe
        if ($informe->informe_url) {
            $rutaPublica = public_path('storage/informes');
            if (file_exists($rutaPublica . '/' . $informe->informe_url)) {
                unlink($rutaPublica . '/' . $informe->informe_url);
            }
        }

        $informe->delete();

        return redirect()->route('responsabilidades.asis', ['year' => $year, 'mes' => $mes, 'area_id' => $area_id]);
    }

}
