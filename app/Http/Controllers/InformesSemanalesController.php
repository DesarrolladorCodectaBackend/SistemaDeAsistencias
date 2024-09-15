<?php

namespace App\Http\Controllers;

use App\Http\Requests\InformesSemanalesRequest;
use App\Models\Area;
use App\Models\Colaboradores_por_Area;
use App\Models\InformeSemanal;
use App\Models\Semanas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

use App\Http\Log;
class InformesSemanalesController extends Controller
{

    public function store(Request $request)
    {
        DB::beginTransaction();
        try{
            // obtiene el a;o, mes, area_id, semana_id para la creacion de dicho informe ubicandolo en las semanas, anios, mes y area respectivas
            $year = $request->year;
            $mes = $request->mes;
            $area_id = $request->area_id;
            $semana_id = $request->semana_id;

            $returnRoute = route('responsabilidades.asis', ['year' => $year, 'mes' => $mes, 'area_id' => $area_id]);

            // obtencion de todos los errores
            $errors = [];

            // validacion titulo
            if (!isset($request->titulo)) {
                $errors['titulo' .$semana_id] = 'El titulo es un campo requerido.';
            } else {
                if (strlen($request->titulo) > 150) {
                    $errors['titulo' .$semana_id] = 'El titulo no puede exceder los 150 caracteres.';
                }
            }

            // validacion nota_semanal
            if (strlen($request->nota_semanal) > 2000) {
                $errors['nota_semanal' .$semana_id] = 'La nota semanal no puede exceder los 2000 caracteres.';
            }

            // validacion informe_url
            if(!isset($request->informe_url)){
                $errors['informe_url'. $semana_id] = 'Es obligatorio subir un archivo.';       
            } else if ($request->hasFile('informe_url')) {
                $extensiones = ['pdf', 'docx'];
                $extensionVal = $request->file('informe_url')->getClientOriginalExtension();

                if (!in_array($extensionVal, $extensiones)) {
                    $errors['informe_url' .$semana_id] = 'El informe debe ser un archivo de tipo: ' . implode(', ', $extensiones);
                }
            }
            
            // redireccion con los errores obtenidos y semana obtenida
            if (!empty($errors)) {
                return redirect()->route('responsabilidades.asis', ['year' => $year, 'mes' => $mes, 'area_id' => $area_id])->with('error',$errors)->with('current_semana_id', $request->semana_id);
            }

            $nombreInforme = '';

            if ($request->hasFile('informe_url')) {
                $informe = $request->file('informe_url');
                $nombreInforme = time() . '.' . $informe->getClientOriginalExtension();
                $informe->move(public_path('storage/informes'), $nombreInforme);
            }

            InformeSemanal::create([
                'titulo' => $request->titulo,
                'nota_semanal' => $request->nota_semanal,
                'informe_url' => $nombreInforme,
                'semana_id' => $semana_id,
                'area_id' => $area_id
            ]);


            DB::commit();
            return redirect($returnRoute);
        }catch(Exception $e){
            DB::rollBack();
            return redirect()->route('responsabilidades.asis', ['year' => $year, 'mes' => $mes,'area_id' => $area_id])->with('error', 'Ocurrió un error al actualizar, intente denuevo. Si este error persiste, contacte a su equipo de soporte.');

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
