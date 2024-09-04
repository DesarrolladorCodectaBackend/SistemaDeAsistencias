<?php

namespace App\Http\Controllers;

use App\Http\Requests\InformesSemanalesRequest;
use App\Models\Area;
use App\Models\InformeSemanal;
use App\Models\Semanas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class InformesSemanalesController extends Controller
{
    public function store(Request $request)
    {
        DB::beginTransaction();
        try{
             $request->validate([
                'titulo' => 'required|min:1|max:250',
                'nota_semanal' => 'required|min:1|max:6000',
                'informe_url' => 'required',
             ]);

            $informe = InformeSemanal::create([
                ""
            ]);

            DB::commit();
                return redirect()->route('responsabilidades.asis', ['informe' => $informe]);

        } catch(Exception $e){
            DB::rollBack();
                return redirect()->route('responsabilidades.asis', ['informe' => $informe]);
        }
    }


    public function update()
    {
        //
    }

    public function delete()
    {
        //
    }
}
