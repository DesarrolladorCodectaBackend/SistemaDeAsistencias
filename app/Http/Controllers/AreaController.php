<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;
use App\Http\Requests\StoreareaRequest;
use App\Http\Requests\UpdateareaRequest;

class AreaController extends Controller
{
    public function index()
    {
        $areas = Area::all();

        return view('areas.index', compact('areas'));
    }

    public function create(){
        return view('areas.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'especializacion' => 'required|string|min:1|max:100',
            'color_hex' =>  'required|string|min:1|max:6',
            'icono' => 'image|mimes:jpeg,png,jpg,gif'
        ]);

        if ($request->hasFile('icono')) {
            $icono = $request->file('icono');
            $nombreIcono = time() . '.' . $icono->getClientOriginalExtension();
            $icono->storeAs('public/areas', $nombreIcono);
        }else {
            $nombreIcono = 'Default.png'; 
        }
 
        //Area::create($request->all());

        Area::create([
            'especializacion' => $request->especializacion,
            'color_hex' => $request->color_hex,
            'icono' => $nombreIcono
        ]);

        
        return redirect()->route('areas.index');
    }
    
    public function show($area_id)
    {
        $area = Area::find($area_id);

        return response()->json(["data" => $area]);
    }

    public function edit($area_id){
        $area = Area::findOrFail($area_id);

        return view('areas.edit', compact('area'));
    }
    
    public function update(Request $request, $area_id)
    {
        $request->validate([
            'especializacion' => 'sometimes|string|min:1|max:100',
            'color_hex' =>  'sometimes|string|min:1|max:6',
            'icono' => 'sometimes|image|mimes:jpeg,png,jpg,gif' 
        ]);
        
        $area = Area::findOrFail($area_id);
        
        $datosActualizar = $request->except(['icono']);

        if ($request->hasFile('icono')) {
            $rutaPublica = public_path('storage/areas');
            if ($area->icono && $area->icono != 'Default.png' && file_exists($rutaPublica . '/' . $area->icono)) {
                unlink($rutaPublica . '/' . $area->icono);
            }
    
            $icono = $request->file('icono');
            $nombreIcono = time() . '.' . $icono->getClientOriginalExtension();
    
            $icono->move($rutaPublica, $nombreIcono);
    
            $datosActualizar['icono'] = $nombreIcono;
        }

        $area->update($datosActualizar);

        return redirect()->route('areas.index');
    }

    
    public function destroy($area_id)
    {
        $area = Area::findOrFail($area_id);

        $area->delete();

        return redirect()->route('areas.index');
    }
}
