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
        // storage/informes

        return redirect()->route('responsabilidades.asis', ['year' => $year, 'mes' => $mes,'area_id' => $area_id]);
    }

    public function update(Request $request, $InformeSemanal)
    {
    
        // Encontrar el informe
        $informe = InformeSemanal::findOrFail($InformeSemanal);

        // Actualizar el archivo si se sube uno nuevo
        if ($request->hasFile('informe_url')) {
            // Eliminar el archivo existente
            if ($informe->informe_url && file_exists(public_path('storage/informes/' . $informe->informe_url))) {
                unlink(public_path('storage/informes/' . $informe->informe_url));
            }

            // Subir el nuevo archivo
            $archivo = $request->file('informe_url');
            $nombreInforme = time() . '.' . $archivo->getClientOriginalExtension();
            $archivo->move(public_path('storage/informes'), $nombreInforme);

            // Actualizar la ruta del archivo en la base de datos
            $informe->informe_url = $nombreInforme;
        }

        // Actualizar otros campos
        $informe->update([
            'titulo' => $request->titulo,
            'nota_semanal' => $request->nota_semanal,
            'semana_id' => $request->semana_id,
            'area_id' => $request->area_id,
        ]);

        // Redireccionar con parámetros
        return redirect()->route('responsabilidades.asis', [
            'year' => $request->year,
            'mes' => $request->mes,
            'area_id' => $request->area_id
        ]);
    }



    public function show($InformeSemanal)
{
    // // Obtener el informe con el ID proporcionado
    // $informe = InformeSemanal::findOrFail($InformeSemanal);

    // // Obtener los valores necesarios para la vista
    // $year = $informe->year; // o de alguna manera calculado/recuperado
    // $mes = $informe->mes; // o de alguna manera calculado/recuperado
    // $semana_id = $informe->semana_id;
    // $area_id = $informe->area_id;

    // // Pasar todos los datos a la vista
    // return view('inspiniaViews.responsabilidades.asistencia', compact('informe', 'year', 'mes', 'semana_id', 'area_id'));
}




    public function delete()
    {
        //
    }
}
