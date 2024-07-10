<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Colaboradores;
use App\Models\Candidatos;
use App\Models\Colaboradores_por_Area;
use App\Models\Horario_de_Clases;
use App\Models\Institucion;
use App\Models\Carrera;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Session;
use Exception;

class ColaboradoresController extends Controller
{

    public function colaboradoresConArea($colaboradores){
        $colaboradoresConArea = [];

        foreach ($colaboradores as $colaborador) {
            $colaboradorArea = Colaboradores_por_Area::with('area')->where('colaborador_id', $colaborador->id)->where('estado', true)->get();
            if (count($colaboradorArea)>0) {
                $areas = [];

                foreach($colaboradorArea as $colArea){
                    $areas[] = $colArea->area->especializacion;
                }
                $colaborador->areas = $areas;
            } else {
                $colaborador->areas = ['Sin área asignada'];
            }
            $colaboradoresConArea[] = $colaborador;
        }
        return $colaboradoresConArea;
    }

    public function index()
    {
        $colaboradores = Colaboradores::with('candidato')->get();
        $instituciones = Institucion::get();
        $carreras = Carrera::get();
        $areas = Area::get();
        $colaboradoresConArea = $this->colaboradoresConArea($colaboradores);
        // return $colaboradoresConArea;
        return view('inspiniaViews.colaboradores.index', compact('colaboradoresConArea', 'instituciones', 'carreras', 'areas'));
    }

    public function filtrarColaboradores(Request $request)
    {
        // Validamos los request de los filtros que queremos aplicar
        $request->validate([
            'area_id.*' => 'sometimes|integer',
            'estado.*' => 'sometimes',
            'carrera_id.*' => 'sometimes|integer',
            'institucion_id.*' => 'sometimes|integer'
        ]);

        $instituciones = Institucion::get();
        $carreras = Carrera::get();
        $areas = Area::get();

        // Pasamos los request a arrays para usarlos más fácilmente
        //Validar si hay  request areas
        if (!$request->area_id) {
            $requestAreas = $areas->pluck('id');
        } else {
            $requestAreas = $request->area_id;
        }
        //Validar si hay  request estados
        if (!$request->estado) {
            $requestEstados = ["1", "0"];
        } else {
            $requestEstados = $request->estado;
        }
        //Validar si hay  request carreras
        if (!$request->carrera_id) {
            $requestCarreras = $carreras->pluck('id');
        } else {
            $requestCarreras = $request->carrera_id;
        }
        //Validar si hay  request carreras
        if (!$request->institucion_id) {
            $requestInstituciones = $instituciones->pluck('id');
        } else {
            $requestInstituciones = $request->institucion_id;
        }

        // Obtenemos a los colaboradores filtrados por áreas
        $colaboradoresArea = Colaboradores_por_Area::with('colaborador')
            ->whereIn('area_id', $requestAreas)
            ->get()
            ->pluck('colaborador');

        //filtramos por los estados
        $colaboradoresCandidatoId = $colaboradoresArea->whereIn('estado', $requestEstados)->pluck('candidato_id');

        //filtrar los candidatos por la carrera y la institucion
        $candidatosFiltradosId = Candidatos::whereIn('id', $colaboradoresCandidatoId)
            ->whereIn('carrera_id', $requestCarreras) //filtrar por la carrera
            ->whereIn('institucion_id', $requestInstituciones) //filtrar por la institucion
            ->pluck('id');

        $colaboradores = Colaboradores::with('candidato')->whereIn('candidato_id', $candidatosFiltradosId)->get();


        $colaboradoresConArea = $this->colaboradoresConArea($colaboradores);


        //return $colaboradoresConArea;
        return view('inspiniaViews.colaboradores.index', compact('colaboradoresConArea', 'instituciones', 'carreras', 'areas'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'candidato_id' => 'required|integer',
            'areas_id.*' => 'required|integer',
            'horarios' => 'required|array',
            'horarios.*.hora_inicial' => 'required|date_format:H:i',
            'horarios.*.hora_final' => 'required|date_format:H:i',
            'horarios.*.dia' => 'required|string'
        ]);
        //Se busca al candidato por su id
        $candidato = Candidatos::findOrFail($request->candidato_id);
        //Se verifica si el candidato está activo 
        if ($candidato->estado == true) {
            //Sí el candidato está activo, se crea un nuevo colaborador con el id del candidato
            $colaborador = Colaboradores::create(['candidato_id' => $request->candidato_id]);
            //Se recorre el request de areas
            foreach($request->areas_id as $area_id){
                //Se crea un nuevo registro en la tabla Colaboradores_por_Area con el id del colaborador y el id del área
                Colaboradores_por_Area::create([
                    'colaborador_id' => $colaborador->id,
                    'area_id' => $area_id,
                    'semana_inicio_id' => null
                ]);
            }
            //Se recorre el request de horarios
            foreach ($request->horarios as $horario) {
                //Se crea un nuevo registro en la tabla Horario_de_Clases con el id del colaborador y los datos del horario
                Horario_de_Clases::create([
                    'colaborador_id' => $colaborador->id,
                    'hora_inicial' => $horario['hora_inicial'],
                    'hora_final' => $horario['hora_final'],
                    'dia' => $horario['dia']
                ]);
            }
            //Se actualiza el estado del candidato a false (inactivo)
            $candidato->estado = false;
            $candidato->save();
        }
        //Se redirige a la vista de colaboradores
        return redirect()->route('colaboradores.index');
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


    public function update(Request $request, $colaborador_id)
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
            'icono' => 'sometimes|image|mimes:jpeg,png,jpg,gif',
            'areas_id.*' => 'sometimes|integer'

        ]);
        //Encontrar al colaborador con su candidato por su id
        $colaborador = Colaboradores::with('candidato')->findOrFail($colaborador_id);
        //Asignar el candidato a una variable
        $candidato = $colaborador->candidato;
        //Recorrer cada area enviado en el request
        foreach($request->areas_id as $area_id){
            //Buscar Si hay colaborador por area y colaborador
            $colaborador_por_area = Colaboradores_por_Area::where('colaborador_id', $colaborador->id)->where('area_id', $area_id)->first();
            //Si no se encuentra un colaborador con esta area
            if (!$colaborador_por_area) {
                //Se crea un nuevo registro con esta area y colaborador
                Colaboradores_por_Area::create([
                    'colaborador_id' => $colaborador->id,
                    'area_id' => $area_id,
                    'semana_inicio_id' => null,
                    'estado' => true,
                ]);
                //Si se encuentra un colaborador con esta area y esta inactivo
            } else if ($colaborador_por_area->estado == false) {
                //Se actualiza el estado a activo
                $colaborador_por_area->update(['estado' => true]);
            } 
        }
        // Buscar las areas que no estan en el request y que estan asociadas al colaborador
        $areasInactivas = Colaboradores_por_Area::where('colaborador_id', $colaborador_id)->whereNotIn('area_id', $request->areas_id)->get();
        // Por cada registro encontrado
        foreach ($areasInactivas as $areaInactiva) {
            //Se inactiva su estado
            $areaInactiva->update(['estado' => false]);
        }
        //Se crea un array de datos a actualizar para el candidato, exceptuando el icono y area_id
        $datosActualizar = $request->except(['icono', 'areas_id']);

        //Realizar la asignación y actualización del icono si se envía uno nuevo en la solicitud
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

        //Se actualizan los datos del candidato
        $candidato->update($datosActualizar);

        //Se redirige a la vista 
        return redirect()->route('colaboradores.index');

    }


    public function destroy($colaborador_id)
    {
        $colaborador = Colaboradores::findOrFail($colaborador_id);

        $colaborador->delete();

        return redirect()->route('colaboradores.index');

    }


    public function activarInactivar(Request $request, $colaborador_id)
    {
        $colaborador = Colaboradores::findOrFail($colaborador_id);

        $colaborador->estado = !$colaborador->estado;

        $colaborador->save();

        //$url = URL::current();

        //Session::put('previousUrl', url()->previous());

        //return redirect()->route('colaboradores.index');

        //$params = $request->except('_token');

        // Redirigir a la URL anterior con los parámetros de filtro
        //return redirect()->route('colaboradores.index', $params);

        return redirect()->route('colaboradores.index');
        //return back();
        //return redirect($url);
    }


    public function search(Request $request)
    {
        
        //asignar a variable
        $busqueda = $request->busqueda;

        //Obtener colaboradores con nombre
        $colabsWithCand = Colaboradores::with('candidato')->get();
        //Filtrar por id
        $colaboradorPorId = $colabsWithCand->where('id', $busqueda)->all(); //Se usa all para forzar a que sea una colección aunque solo tenga un elemento, para evitar errores al recorrer

        //Obtener todos los colabs con candidato por function query
        $colaboradoresTotales = Colaboradores::with([
            'candidato' => function ($query) {
                $query->select('id', 'nombre', 'apellido', 'dni', 'direccion', 'fecha_nacimiento', 'ciclo_de_estudiante', 'estado', 'institucion_id', 'carrera_id', 'icono', 'correo', 'celular'); }
        ]);
        //Filtrar por nombre y apellido de candidato                
        $colaboradoresPorNombre = $colaboradoresTotales->whereHas('candidato', function ($query) use ($busqueda) {
            $query->where(DB::raw("CONCAT(nombre, ' ', apellido)"), 'like', '%' . $busqueda . '%');
        })->get();

        //Si existe un registro encontrado por el id
        if ($colaboradorPorId) {
            //Se asigna el valor del colaboradorPorId
            $colaboradores = $colaboradorPorId;
        } else { //Si no existe
            //Se asigna el valor de los colaboradoresPorNombre
            $colaboradores = $colaboradoresPorNombre;
        }

        $instituciones = Institucion::get();
        $carreras = Carrera::get();
        $areas = Area::get();

        $colaboradoresConArea = $this->colaboradoresConArea($colaboradores);

        //return $colaboradoresConArea;

        return view('inspiniaViews.colaboradores.index', compact('colaboradoresConArea', 'instituciones', 'carreras', 'areas'));

    }
}
