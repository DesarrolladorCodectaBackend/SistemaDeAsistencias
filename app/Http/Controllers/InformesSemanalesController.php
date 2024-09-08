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
        // obtiene el a;o, mes, area_id, semana_id para la creacion de dicho informe ubicandolo en las semanas, anios, mes y area respectivas
        $year = $request->year;
        $mes = $request->mes;
        $area_id = $request->area_id;
        $semana_id = $request->semana_id;

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
        // return $request;

        return redirect()->route('responsabilidades.asis', ['year' => $year, 'mes' => $mes,'area_id' => $area_id]);
    }

    public function update(Request $request, $InformeSemanal)
    {
        $year = $request->year;
        $mes = $request->mes;
        $area_id = $request->area_id;
        $semana_id = $request->semana_id;

        $informe = InformeSemanal::findOrFail($InformeSemanal);
        
        // Preparar los datos para actualizar
        $datosActualizar = $request->except(['informe_url']);
        
        // Actualizar el archivo si se sube uno nuevo
        if ($request->hasFile('informe_url')) {
            $rutaPublica = public_path('storage/informes');
            
            // Eliminar el archivo existente
            if ($informe->informe_url && file_exists($rutaPublica . '/' . $informe->informe_url)) {
                unlink($rutaPublica . '/' . $informe->informe_url);
            }

            // Subir el nuevo archivo
            $archivo = $request->file('informe_url');
            $nombreInforme = time() . '.' . $archivo->getClientOriginalExtension();
            $archivo->move($rutaPublica, $nombreInforme);
            
            $datosActualizar['informe_url'] = $nombreInforme;
        }

        $informe->update($datosActualizar);
        return $informe;

        // return redirect()->route('responsabilidades.asis', ['year' => $year, 'mes' => $mes,'area_id' => $area_id]);
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




    public function delete()
    {
        //
    }
}
