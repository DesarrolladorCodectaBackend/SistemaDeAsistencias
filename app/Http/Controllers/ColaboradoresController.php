<?php

namespace App\Http\Controllers;

use App\Models\Colaboradores;
use App\Models\Candidatos;
use App\Models\Colaboradores_por_Area;
use App\Models\Horario_de_Clases;
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
        $colaboradoresConArea = [];

        foreach ($colaboradores as $colaborador) {
            $colaboradorArea = Colaboradores_por_Area::with('area')->where('colaborador_id', $colaborador->id)->first();
            if ($colaboradorArea) {
                $colaborador->area = $colaboradorArea->area->especializacion;
            } else {
                $colaborador->area = 'Sin área asignada';
            }
            $colaboradoresConArea[] = $colaborador;
        }

        return view('inspiniaViews.colaboradores.index', compact('colaboradoresConArea', 'instituciones', 'carreras'));
    }

    
    public function store(Request $request)
    {
    $request->validate([
        'candidato_id' => 'required|integer',
        'area_id' => 'required|integer',
        'horarios' => 'required|array',
        'horarios.*.hora_inicial' => 'required|date_format:H:i',
        'horarios.*.hora_final' => 'required|date_format:H:i',
        'horarios.*.dia' => 'required|string'
    ]);

    $candidato = Candidatos::findOrFail($request->candidato_id);

    if ($candidato->estado == true) {
        $colaborador = Colaboradores::create(['candidato_id' => $request->candidato_id]);

        Colaboradores_por_Area::create([
            'colaborador_id' => $colaborador->id,
            'area_id' => $request->area_id,
            'semana_inicio_id' => null
        ]);

        foreach ($request->horarios as $horario) {
            Horario_de_Clases::create([
                'colaborador_id' => $colaborador->id,
                'hora_inicial' => $horario['hora_inicial'],
                'hora_final' => $horario['hora_final'],
                'dia' => $horario['dia']
            ]);
        }

        $candidato->estado = !$candidato->estado;
        $candidato->save();
    }

    return redirect()->route('inspiniaViews.colaboradores.index');
}



    public function show($colaborador_id)
    {
        try {
            $colaborador = Colaboradores::with('candidatos')->find($colaborador_id);
            if (!$colaborador) {
                return response()->json(["resp" => "No existe un registro con ese id"]);
            }
            return response()->json(["data" => $colaborador]);
        } catch (Exception $e) {
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

        return redirect()->route('inspiniaViews.colaboradores.index');

    }


    public function destroy($colaborador_id)
    {
        $colaborador = Colaboradores::findOrFail($colaborador_id);

        $colaborador->delete();

        return redirect()->route('inspiniaViews.colaboradores.index');

    }


    public function activarInactivar($colaborador_id)
    {
        $colaborador = Colaboradores::findOrFail($colaborador_id);

        $colaborador->estado = !$colaborador->estado;

        $colaborador->save();

        return redirect()->route('inspiniaViews.colaboradores.index');
    }


    public function ShowByName(Request $request)
    {
        try {
            if (!$request->nombre) {
                return response()->json(["resp" => "Ingrese el nombre del colaborador"]);
            }

            if (!is_string($request->nombre)) {
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
        } catch (Exception $e) {
            return response()->json(["error" => $e]);
        }

    }
}
