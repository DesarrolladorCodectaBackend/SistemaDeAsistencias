<?php

namespace App\Http\Controllers;

use App\Http\Requests\InformesSemanalesRequest;
use App\Models\Area;
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
    try {
        $request->validate([
            'titulo' => 'required|min:1|max:255',
            'nota_semanal' => 'required|min:1|max:255',
            'informe_url' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'area_id' => 'required|exists:areas,id',
            'semana_id' => 'required|exists:semanas,id',
        ]);

        $informe_url = $request->file('informe_url')->store('informe_archivos');

        InformeSemanal::create([
            'titulo' => $request->input('titulo'),
            'nota_semanal' => $request->input('nota_semanal'),
            'informe_url' => $informe_url,
            'area_id' => $request->input('area_id'),
            'semana_id' => $request->input('semana_id'),
        ]);

        DB::commit();

        return redirect()->route('responsabilidades.asis', [
            'year' => now()->year,
            'mes' => now()->month,
            'area_id' => $request->input('area_id'),
        ]);
    } catch (Exception $e) {
        DB::rollBack();
        return redirect()->back()->withErrors('Error al guardar el informe. Por favor, intente nuevamente.');
    }
}



    /*public function store(Request $request){
        DB::beginTransaction();
        try{
            $area = Area::findOrFail($area_id);
            $semana = Semanas::findOrFail($semana_id);

            $request->validate([
                'titulo' => 'required|min:1|max:255',
                'nota_semanal' => 'required|min:1|max:255',
                'informe_url' => 'required',
            ]);
            $year = $request->year;
            $mes = $request->mes;
            $area_id = $request->area_id;
            DB::commit();
        return redirect()->route('responsabilidades.asis', ['year' => $year, 'mes' => $mes,'area_id' => $area_id]);
        }catch(Exception $e){
            DB::rollBack();
        }
    }*/


    public function update()
    {
        //
    }

    public function delete()
    {
        //
    }
}
