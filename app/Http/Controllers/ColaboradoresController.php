<?php

namespace App\Http\Controllers;

use App\Http\Controllers\FunctionHelperController;
use App\Models\Area;
use App\Models\Colaboradores;
use App\Models\Candidatos;
use App\Models\Colaboradores_por_Area;
use App\Models\Computadora_colaborador;
use App\Models\Horario_de_Clases;
use App\Models\Institucion;
use App\Models\Carrera;
use App\Models\Programas;
use App\Models\Programas_instalados;
use App\Models\Registro_Mantenimiento;
use App\Models\Sede;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Session;
use Exception;

class ColaboradoresController extends Controller
{
    public function index()
    {
        $colaboradores = Colaboradores::with('candidato')->paginate(12);
        $sedes = Sede::with('institucion')->orderBy('nombre', 'asc')->get();
        $instituciones = Institucion::get();
        $carreras = Carrera::get();
        $areas = Area::get();
        $colaboradoresConArea = FunctionHelperController::colaboradoresConArea($colaboradores->items());
        $colaboradores->data = $colaboradoresConArea;
        $pageData = FunctionHelperController::getPageData($colaboradores);
        $hasPagination = true;
        // return $pageData;

        return view('inspiniaViews.colaboradores.index', [
            'colaboradores' => $colaboradores,
            'hasPagination' => $hasPagination,
            'pageData' => $pageData,
            'sedes' => $sedes,
            'instituciones' => $instituciones,
            'carreras' => $carreras,
            'areas' => $areas,
        ]);
    }

    public function getComputadoraColaborador($colaborador_id){
        $colaborador = Colaboradores::with('candidato')->findOrFail($colaborador_id);

        $computerColab = Computadora_colaborador::where('colaborador_id', $colaborador_id)->first();

        $hasComputer = false;
        $incidencias = [];
        $ultimaIncidencia = null;
        $programas = Programas::where('estado', true)->get();
        $programasInstalados = [];
        if($computerColab) {
            $hasComputer = true;
            $incidencias = Registro_Mantenimiento::where('computadora_id', $computerColab->id)->where('estado', true)->get();
            $ultimaIncidencia = Registro_Mantenimiento::where('computadora_id', $computerColab->id)->orderBy('fecha', 'desc')->first();
            $programasInstalados = Programas_instalados::with('programa')->where('computadora_id', $computerColab->id)->where('estado', true)->get();
        }

        $procesadores = [
            'Core I8',
            'Core I5',
            'Core I3',
        ];

        $almacenamientos = [
            '8 GBytes',
            '7 GBytes',
            '6 GBytes',
        ];


        // return response()->json(["colaborador" => $colaborador, "computerColab" => $computerColab, "hasComputer" => $hasComputer, "incidencias" => $incidencias, "ultimaIncidencia" => $ultimaIncidencia, "programas" => $programas,"programasInstalados" => $programasInstalados]);

        return view('inspiniaViews.computadoras.compuColab', [
            'colaborador' => $colaborador,
            'computerColab' => $computerColab,
            'hasComputer' => $hasComputer,
            'incidencias' => $incidencias,
            'ultimaIncidencia' => $ultimaIncidencia,
            'programas' => $programas,
            'programasInstalados' => $programasInstalados,
            'procesadores' => $procesadores,
            'almacenamientos' => $almacenamientos,
        ]);
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
        $sedes = Sede::with('institucion')->orderBy('nombre', 'asc')->get();
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

        //filtrar los candidatos por la carrera y la sede - institucion
        $sedesInstitucionesId = Sede::whereIn('institucion_id', $requestInstituciones)->pluck('id');
        $candidatosFiltradosId = Candidatos::whereIn('id', $colaboradoresCandidatoId)
            ->whereIn('carrera_id', $requestCarreras) //filtrar por la carrera
            ->whereIn('sede_id', $sedesInstitucionesId) //filtrar por la sede
            ->pluck('id');

        $colaboradores = Colaboradores::with('candidato')->whereIn('candidato_id', $candidatosFiltradosId)->get();


        $colaboradores->data = FunctionHelperController::colaboradoresConArea($colaboradores);
        $hasPagination = false;
        $pageData = [];


        //return $colaboradoresConArea;
        return view('inspiniaViews.colaboradores.index', [
            'colaboradores' => $colaboradores,
            'hasPagination' => $hasPagination,
            'pageData' => $pageData,
            'sedes' => $sedes,
            'instituciones' => $instituciones,
            'carreras' => $carreras,
            'areas' => $areas,
        ]);
    }


    public function store(Request $request)
    {
        DB::beginTransaction();
        try{
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
            if ($candidato->estado == 1) {
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
                //Se actualiza el estado del candidato a 0, significa que es un colaborador
                $candidato->estado = 0;
                $candidato->save();
            }

            DB::commit();
            //Se redirige a la vista de colaboradores
            return redirect()->route('colaboradores.index');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('colaboradores.index');

        }
        
    }

    public function update(Request $request, $colaborador_id)
    {
        DB::beginTransaction();
        try{
            $request->validate([
                'nombre' => 'sometimes|string|min:1|max:100',
                'apellido' => 'sometimes|string|min:1|max:100',
                'dni' => 'sometimes|string|min:1|max:8',
                'direccion' => 'sometimes|string|min:1|max:100',
                'fecha_nacimiento' => 'sometimes|string|min:1|max:255',
                'ciclo_de_estudiante' => 'sometimes|string|min:1|max:50',
                'sede_id' => 'sometimes|integer|min:1|max:20',
                'carrera_id' => 'sometimes|integer|min:1|max:20',
                'correo' => 'sometimes|string|min:1|max:255',
                'celular' => 'sometimes|string|min:1|max:20',
                'icono' => 'sometimes|image|mimes:jpeg,png,jpg,gif',
                'areas_id.*' => 'sometimes|integer',
                'currentURL' => 'sometimes|string',
    
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
            DB::commit();
    
            //Se redirige a la vista 
            if($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('colaboradores.index');
            }
        } catch(Exception $e){
            DB::rollBack();
            // return $e;
            if($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('colaboradores.index');
            }
        }
    }


    // public function destroy($colaborador_id)
    // {
    //     $colaborador = Colaboradores::findOrFail($colaborador_id);

    //     $colaborador->delete();

    //     return redirect()->route('colaboradores.index');

    // }


    public function activarInactivar(Request $request, $colaborador_id)
    {
        DB::beginTransaction();
        try{
            $colaborador = Colaboradores::findOrFail($colaborador_id);

            $colaborador->estado = !$colaborador->estado;

            $colaborador->save();
            DB::commit();

            // return redirect()->route('colaboradores.index');
            if($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('colaboradores.index');
            }
        } catch(Exception $e) {
            DB::rollBack();
            // return redirect()->route('colaboradores.index');
            if($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('colaboradores.index');
            }
        }
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
                $query->select('id', 'nombre', 'apellido', 'dni', 'direccion', 'fecha_nacimiento', 'ciclo_de_estudiante', 'estado', 'sede_id', 'carrera_id', 'icono', 'correo', 'celular'); }
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
        $sedes = Sede::with('institucion')->orderBy('nombre', 'asc')->get();

        $colaboradores->data = FunctionHelperController::colaboradoresConArea($colaboradores);
        $hasPagination = false;
        $pageData = [];
        
        //return $colaboradoresConArea;

        return view('inspiniaViews.colaboradores.index', [
            'colaboradores' => $colaboradores,
            'hasPagination' => $hasPagination,
            'pageData' => $pageData,
            'sedes' => $sedes,
            'instituciones' => $instituciones,
            'carreras' => $carreras,
            'areas' => $areas,
        ]);

    }
}
