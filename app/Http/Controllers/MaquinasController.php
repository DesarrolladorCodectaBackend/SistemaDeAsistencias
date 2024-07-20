<?php

namespace App\Http\Controllers;

use App\Models\Maquinas;
use App\Models\Salones;
use Illuminate\Http\Request;
use App\Http\Requests\StoreMaquinasRequest;
use App\Http\Requests\UpdateMaquinasRequest;

class MaquinasController extends Controller
{
    
    public function index()
    {
        $maquinas = Maquinas::orderBy('salon_id', 'asc')->paginate(12);

        $salones = Salones::get();

        $pageData = FunctionHelperController::getPageData($maquinas);
        $hasPagination = true;

        return view('inspiniaViews.maquinas.index', [
            'maquinas' => $maquinas,
            'salones' => $salones,
            'pageData' => $pageData,
            'hasPagination' => $hasPagination,
        ]);
    }

    
    public function create(Request $request)    
    {
        Maquinas::create([
            "nombre" => $request->nombre,
            "detalles_tecnicos" => $request->detalles_tecnicos,
            "num_identificador" => $request->num_identificador,
            "salon_id" => $request->salon_id
        ]);

        return response()->json(["resp" => "Maquina creada correctamente"]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|min:1|max:255',
            'detalles_tecnicos' => 'required|string|min:1|max:100',
            'num_identificador' => 'required|integer|min:1|max:255',
            'salon_id' => 'required|integer|min:1|max:15'  
        ]);

        Maquinas::create([
            "nombre" => $request->nombre,
            "detalles_tecnicos" => $request->detalles_tecnicos,
            "num_identificador" => $request->num_identificador,
            "salon_id" => $request->salon_id
        ]);

        if($request->currentURL) {
            return redirect($request->currentURL);
        } else {
            return redirect()->route('maquinas.index');
        }

    }

    
    public function show($maquina_id)
    {
        $maquina = Maquinas::with(['salones' => function($query) {$query->select('id', 'nombre');}])->find($maquina_id);

        return response()->json(["data" => $maquina]);
    }


    public function update(Request $request, $maquina_id)
    {

        $request->validate([
            'nombre' => 'sometimes|string|min:1|max:255',
            'detalles_tecnicos' => 'sometimes|string|min:1|max:100',
            'num_identificador' => 'sometimes|string|min:1|max:255',
            'salon_id' => 'sometimes|integer|min:1|max:15'  
        ]);
        
        $maquina = Maquinas::find($maquina_id);
        
        $maquina->update($request->all());
        
        if($request->currentURL) {
            return redirect($request->currentURL);
        } else {
            return redirect()->route('maquinas.index');
        }
    }

    public function destroy($maquina_id)
    {
        $maquina = Maquinas::findOrFail($maquina_id);

        $maquina->delete();

        return redirect()->route('maquinas.index');
    }

    public function activarInactivar(Request $request, $maquina_id)
    {
        $maquina = Maquinas::findOrFail($maquina_id);

        $maquina->estado = !$maquina->estado;

        $maquina->save();

        if($request->currentURL) {
            return redirect($request->currentURL);
        } else {
            return redirect()->route('maquinas.index');
        }
    }

}
