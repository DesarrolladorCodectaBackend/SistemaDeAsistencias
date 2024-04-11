<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCarreraRequest;
use App\Http\Requests\UpdateCarreraRequest;
use Illuminate\Support\Facades\DB;
use Exception;

class CarreraController extends Controller
{

    public function index()
    {
        $carrera = Carrera::all();

        return view('carreras.index', compact('carreras'));
    }


    public function create()
    {
        return view('carrera.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'especializacion' => 'required|string|min:1|max:100',
            'descripcion' => 'required|string|min:1|max:255',
            'color_hex' =>  'required|string|min:1|max:7',
            'icono' => 'image|mimes:jpeg,png,jpg,gif'
        ]);

        if ($request->hasFile('icono')) {
            $icono = $request->file('icono');
            $nombreIcono = time() . '.' . $icono->getClientOriginalExtension();
            $icono->move(public_path('storage/carrera'), $nombreIcono);
        }else {
            $nombreIcono = 'Default.png'; 
        }
 
        //Area::create($request->all());

        Carrera::create([
            'especializacion' => $request->especializacion,
            'descripcion' => $request->descripcion,
            'color_hex' => $request->color_hex,
            'icono' => $nombreIcono
        ]);

        
        return redirect()->route('carrera.index');
    }


    public function show($carrera_id)
    {
        $carrera = Carrera::find($carrera_id);

        return response()->json(["data" => $carrera]);
    }

    public function edit($carrera_id){
        $carrera = Carrera::findOrFail($carrera_id);

        return view('carrera.edit', compact('carrera'));
    }


    public function update(Request $request, $carrera_id)
    {
        $request->validate([
            'especializacion' => 'sometimes|string|min:1|max:100',
            'descripcion' => 'sometimes|string|min:1|max:255',
            'color_hex' =>  'sometimes|string|min:1|max:7',
            'icono' => 'sometimes|image|mimes:jpeg,png,jpg,gif' 
        ]);
        
        $carrera = Carrera::findOrFail($carrera_id);
        
        $datosActualizar = $request->except(['icono']);

        if ($request->hasFile('icono')) {
            $rutaPublica = public_path('storage/carrera');
            if ($carrera->icono && $carrera->icono != 'Default.png' && file_exists($rutaPublica . '/' . $carrera->icono)) {
                unlink($rutaPublica . '/' . $carrera->icono);
            }
    
            $icono = $request->file('icono');
            $nombreIcono = time() . '.' . $icono->getClientOriginalExtension();
    
            $icono->move($rutaPublica, $nombreIcono);
    
            $datosActualizar['icono'] = $nombreIcono;
        }

        $carrera->update($datosActualizar);

        return redirect()->route('carrera.index');
    }



    public function destroy($carrera_id)
    {
        $carrera = Carrera::findOrFail($carrera_id);

        $carrera->delete();

        return redirect()->route('carrera.index');
    }

}
