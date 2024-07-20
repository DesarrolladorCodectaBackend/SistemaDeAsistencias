<?php

namespace App\Http\Controllers;

use App\Models\Maquinas;
use App\Models\Salones;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSalonesRequest;
use App\Http\Requests\UpdateSalonesRequest;

class SalonesController extends Controller
{
    
    public function index()
    {
        $salones = Salones::paginate(12);

        foreach($salones as $salon){
            $maquinas = Maquinas::where('salon_id', $salon->id)->get();
            $conteoMaquinas = $maquinas->count();
            $salon->cant_maquinas = $conteoMaquinas;
        }

        $pageDate = FunctionHelperController::getPageData($salones);
        $hasPagination = true;

        return view('inspiniaViews.salones.index', [
            'salones' => $salones, 
            'pageData' => $pageDate, 
            'hasPagination' => $hasPagination
        ]);
    }
    
    public function salonMaquinas($salon_id){
        $maquinas = Maquinas::where('salon_id', $salon_id)->get();
        return response()->json($maquinas);
    }
    
    // public function create(Request $request)
    // {
    //     Salones::create([
    //         "nombre" => $request->nombre,
    //         "descripcion" => $request->descripcion
    //     ]);

    //     return response()->json(["resp" => "Salón creado"]);
    // }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|min:1|max:100',
            'descripcion' => 'required|string|min:1|max:255',
        ]);

 
        //Salones::create($request->all());

        Salones::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
        ]);

        
        if($request->currentURL) {
            return redirect($request->currentURL);
        } else {
            return redirect()->route('salones.index');
        }

    }

    
    //public function show($salon_id)
    //{
      //  $salon = Salones::find($salon_id);

        //return response()->json(["data" => $salon]);
    //}

    
    public function update(Request $request, $salon_id)
    {
        $request->validate([
            'nombre' => 'required|string|min:1|max:100',
            'descripcion' => 'required|string|min:1|max:255',
        ]);


        
        $salon = Salones::findOrFail($salon_id);
        
        $datosActualizar = $request->all();

        $salon->update($datosActualizar);

        if($request->currentURL) {
            return redirect($request->currentURL);
        } else {
            return redirect()->route('salones.index');
        }

    }

    
    public function destroy($salon_id)
    {
        $salon = Salones::findOrFail($salon_id);

        $salon->delete();

        return redirect()->route('salones.index');
    }

    public function activarInactivar(Request $request, $salon_id)
    {
        $salon = Salones::findOrFail($salon_id);

        $salon->estado = !$salon->estado;

        $salon->save();

        if($request->currentURL) {
            return redirect($request->currentURL);
        } else {
            return redirect()->route('salones.index');
        }
    }

    public function activarInactivarMaquina($maquina_id)
    {
        $maquina = Maquinas::findOrFail($maquina_id);

        $maquina->estado = !$maquina->estado;

        $maquina->save();

        return redirect()->route('salones.index');
    }
}
