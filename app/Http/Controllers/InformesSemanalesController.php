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
