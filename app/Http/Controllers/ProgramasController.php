<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Programas;
use App\Models\Area;

class ProgramasController extends Controller
{
    public function index()
    {
        $programas = Programas::get();

        return view("inspiniaViews.programas.index", compact("programas"));
    }

    /*
    public function create(Request $request)
    {
        Programas::create([
            "nombre" => $request->nombre,
            "descripcion" => $request->descripcion,
            "memoria_grafica" => $request->memoria_grafica,
            "ram" => $request->ram
        ]);

        return response()->json(["resp" => "Programa creado"]);
    }
    */

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|min:1|max:100',
            'descripcion' => 'required|string|min:1|max:255',
            'icono' => 'image|mimes:jpeg,png,jpg,gif'
        ]);

        if ($request->hasFile('icono')) {
            $icono = $request->file('icono');
            $nombreIcono = time() . '.' . $icono->getClientOriginalExtension();
            $icono->move(public_path('storage/programas'), $nombreIcono);
        } else {
            $nombreIcono = 'default.png';
        }


        Programas::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'icono' => $nombreIcono
        ]);


        return redirect()->route('programas.index');
    }


    public function show($programa_id)
    {
        $programa = Programas::find($programa_id);

        return response()->json(["data" => $programa]);
    }


    public function update(Request $request, $programa_id)
    {
        $request->validate([
            "nombre" => "required|string|min:1|max:255",
            "descripcion" => "sometimes|string|min:1|max:500",
            "icono" => "image|mimes:jpeg,png,jpg,gif"
        ]);

        $programa = Programas::findOrFail($programa_id);

        $datosActualizar = $request->except(['icono']);

        if ($request->hasFile('icono')) {
            $rutaPublica = public_path('storage/programas');
        
            // Verificar si el icono actual no es el predeterminado
            if ($programa->icono && $programa->icono !== "default.png") {
                // Eliminar el icono actual si no es el predeterminado
                unlink($rutaPublica . '/' . $programa->icono);
            }
        
            $icono = $request->file('icono');
            $nombreIcono = time() . '.' . $icono->getClientOriginalExtension();
        
            $icono->move($rutaPublica, $nombreIcono);
        
            $datosActualizar['icono'] = $nombreIcono;
        }

        $programa->update($datosActualizar);

        return redirect()->route('programas.index');
    }



    public function destroy($programa_id)
    {
        $programa = Programas::findOrFail($programa_id);

        $programa->delete();

        return redirect()->route('programas.index');
    }

    public function activarInactivar($programa_id)
    {
        $programa = Programas::findOrFail($programa_id);

        $programa->estado = !$programa->estado;

        $programa->save();

        return redirect()->route('programas.index');
    }
}
