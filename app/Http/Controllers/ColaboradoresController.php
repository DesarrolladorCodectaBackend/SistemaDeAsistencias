<?php

namespace App\Http\Controllers;

use App\Models\Colaboradores;
use App\Models\Candidatos;
use App\Models\Institucion;
use App\Models\Carrera;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class ColaboradoresController extends Controller
{

    public function index()
    {
        $colaboradores = Colaboradores::with('candidato')->get();
        $instituciones = Institucion::all();
        $carreras = Carrera::all();
        return view('colaboradores.index', compact('colaboradores', 'instituciones', 'carreras'));

    }


    public function store(Request $request)
    {
        $request->validate([
            'candidato_id' => 'required|integer'
        ]);

        $candidato = Candidatos::findOrFail($request->candidato_id);
        if ($candidato->estado == true) {
            Colaboradores::create($request->all());
            $candidato->estado = !$candidato->estado;
            $candidato->save();
        }

    
        return redirect()->route('candidatos.index');

    }


    public function show($colaborador_id)
    {
        try{
            $colaborador = Colaboradores::with('candidatos')->find($colaborador_id);
            if(!$colaborador){
                return response()->json(["resp" => "No existe un registro con ese id"]);
            }
            return response()->json(["data" => $colaborador]);
        } catch(Exception $e){
            return response()->json(["error" => $e]);
        }

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
        
        return redirect()->route('colaboradores.index');

    }


    public function destroy($colaborador_id)
    {
        $colaborador = Colaboradores::findOrFail($colaborador_id);

        $colaborador->delete();

        return redirect()->route('colaboradores.index');

    }


    public function activarInactivar($colaborador_id)
    {
        $colaborador = Colaboradores::findOrFail($colaborador_id);

        $colaborador->estado = !$colaborador->estado;

        $colaborador->save();

        return redirect()->route('colaboradores.index');
    }


    public function ShowByName(Request $request)
    {
        try{
            if(!$request->nombre){
                return response()->json(["resp" => "Ingrese el nombre del colaborador"]);
            }

            if(!is_string($request->nombre)){
                return response()->json(["resp" => "El nombre debe ser una cadena de texto"]);
            }

            $nombreCompleto = $request->nombre;

            $colaboradores = Colaboradores::with([
                'candidatos' => function ($query) {
                    $query->select('id', 'nombre', 'apellido', 'dni', 'direccion', 'fecha_nacimiento', 'ciclo_de_estudiante', 'estado', 'institucion_id', 'carrera_id');
                }
            ])
                ->whereHas('candidatos', function ($query) use ($nombreCompleto) {
                    $query->where(DB::raw("CONCAT(nombre, ' ', apellido)"), 'like', '%' . $nombreCompleto . '%');
                })
                ->where('estado', true)
                ->get();

            return response()->json(["data" => $colaboradores, "conteo" => $colaboradores->count()]);
        } catch(Exception $e){
            return response()->json(["error" => $e]);
        }

    }
}
