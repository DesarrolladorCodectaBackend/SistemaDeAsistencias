<?php

namespace App\Http\Controllers;

use App\Models\Salones;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSalonesRequest;
use App\Http\Requests\UpdateSalonesRequest;

class SalonesController extends Controller
{
    
    public function index()
    {
        $salones = Salones::all();

        return view('salones.index', compact('salones'));
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

        
        return redirect()->route('salones.index');
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

        return redirect()->route('salones.index');

    }

    
    public function destroy($salon_id)
    {
        $salon = Salones::findOrFail($salon_id);

        $salon->delete();

        return redirect()->route('salones.index');
    }
}
