<?php

namespace App\Http\Controllers;

use App\Models\Candidatos;
use App\Models\Institucion;
use App\Models\Carrera;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCandidatosRequest;
use App\Http\Requests\UpdateCandidatosRequest;
use Illuminate\Support\Facades\DB;

class CandidatosController extends Controller
{

    public function index()
    {
        /*
        $candidatos = Candidatos::with([
            'institucion' => function ($query) {
                $query->select('id', 'nombre'); },
            'carrera' => function ($query) {
                $query->select('id', 'nombre'); }
        ])->where('estado', 1)->get();
        return response()->json(["data" => $candidatos, "conteo" => count($candidatos)]);
        */
        $candidatos = Candidatos::with('carrera', 'institucion')->get();
        $instituciones = Institucion::all();
        $carreras = Carrera::all();

        return view('candidatos.index', compact('candidatos', 'instituciones', 'carreras'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|min:1|max:100',
            'apellido' => 'required|string|min:1|max:100',
            'dni' => 'required|string|min:1|max:8',
            'direccion' => 'required|string|min:1|max:100',
            'fecha_nacimiento' => 'required|string|min:1|max:255',
            'ciclo_de_estudiante' => 'required|string|min:1|max:50',
            'institucion_id' => 'required|integer|min:1|max:20',
            'carrera_id' => 'required|integer|min:1|max:20',
            'correo' => 'required|string|min:1|max:255',
            'celular' => 'required|string|min:1|max:20',
            'icono' => 'image|mimes:jpeg,png,jpg,gif'
        ]);

        if ($request->hasFile('icono')) {
            $icono = $request->file('icono');
            $nombreIcono = time() . '.' . $icono->getClientOriginalExtension();
            $icono->move(public_path('storage/candidatos'), $nombreIcono);
        } else {
            $nombreIcono = 'Default.png';
        }

        //Area::create($request->all());

        Candidatos::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'dni' => $request->dni,
            'direccion' => $request->direccion,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'ciclo_de_estudiante' => $request->ciclo_de_estudiante,
            'institucion_id' => $request->institucion_id,
            'carrera_id' => $request->carrera_id,
            'correo' => $request->correo,
            'celular' => $request->celular,
            'icono' => $nombreIcono
        ]);


        return redirect()->route('candidatos.index');

    }


    public function show($candidato_id)
    {
        $candidato = Candidatos::with([
            'institucion' => function ($query) {
                $query->select('id', 'nombre');
            },
            'carrera' => function ($query) {
                $query->select('id', 'nombre');
            }
        ])->find($candidato_id);
        return response()->json(["Data" => $candidato]);
    }


    public function update(Request $request, $candidato_id)
    {
        $request->validate([
            'nombre' => 'sometimes|string|min:1|max:100',
            'apellido' => 'sometimes|string|min:1|max:100',
            'dni' => 'sometimes|string|min:1|max:8',
            'direccion' => 'sometimes|string|min:1|max:100',
            'fecha_nacimiento' => 'sometimes|string|min:1|max:255',
            'ciclo_de_estudiante' => 'sometimes|string|min:1|max:50',
            'institucion_id' => 'sometimes|integer|min:1|max:20',
            'carrera_id' => 'sometimes|integer|min:1|max:20',
            'correo' => 'sometimes|string|min:1|max:255',
            'celular' => 'sometimes|string|min:1|max:20',
            'icono' => 'sometimes|image|mimes:jpeg,png,jpg,gif'
        ]);
        
        $candidato = Candidatos::findOrFail($candidato_id);
        $datosActualizar = $request->except(['icono']);

        if ($request->hasFile('icono')) {
            $rutaPublica = public_path('storage/candidatos');
            if ($candidato->icono && $candidato->icono != 'Default.png' && file_exists($rutaPublica . '/' . $candidato->icono)) {
                unlink($rutaPublica . '/' . $candidato->icono);
            }
    
            $icono = $request->file('icono');
            $nombreIcono = time() . '.' . $icono->getClientOriginalExtension();
    
            $icono->move($rutaPublica, $nombreIcono);
    
            $datosActualizar['icono'] = $nombreIcono;
        }

        $candidato->update($datosActualizar);
        
        return redirect()->route('candidatos.index');
    }


    public function destroy($candidato_id)
    {
        /*
        $candidato = Candidatos::find($candidato_id);

        $candidato->delete();

        return response()->json(["resp" => "Candidato eliminado correctamente"]);
        */
        $candidato = Candidatos::findOrFail($candidato_id);

        $candidato->delete();

        return redirect()->route('candidatos.index');

    }

    public function ShowByName(Request $request)
    {
        $nombreCompleto = $request->nombre;

        $candidatos = Candidatos::with([
            'institucion' => function ($query) {
                $query->select('id', 'nombre');
            },
            'carrera' => function ($query) {
                $query->select('id', 'nombre');
            }
        ])
            ->where('estado', 1)
            ->where(DB::raw("CONCAT(nombre, ' ', apellido)"), 'like', '%' . $nombreCompleto . '%')
            ->get();

        return response()->json(["data" => $candidatos, "conteo" => count($candidatos)]);
    }


}
