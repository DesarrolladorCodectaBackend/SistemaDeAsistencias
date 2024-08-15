<?php

namespace App\Http\Controllers;

use App\Http\Controllers\FunctionHelperController;
use App\Models\Actividades;
use App\Models\Area;
use App\Models\AreaRecreativa;
use App\Models\Asistentes_Clase;
use App\Models\Colaboradores;
use App\Models\Candidatos;
use App\Models\Colaboradores_por_Area;
use App\Models\Computadora_colaborador;
use App\Models\Cumplio_Responsabilidad_Semanal;
use App\Models\Horario_de_Clases;
use App\Models\Institucion;
use App\Models\Carrera;
use App\Models\Maquina_reservada;
use App\Models\Prestamos_objetos_por_colaborador;
use App\Models\Programas;
use App\Models\Programas_instalados;
use App\Models\Registro_Mantenimiento;
use App\Models\RegistroActividad;
use App\Models\Sede;
use App\Models\Semanas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Session;
use Exception;

class ColaboradoresController extends Controller
{
    public function index()
    {
        $colaboradores = Colaboradores::with('candidato')->whereNot('estado', 2)->paginate(12);
        // return $colaboradores;
        $sedesAll = Sede::with('institucion')->orderBy('nombre', 'asc')->get();
        $institucionesAll = Institucion::orderBy('nombre', 'asc')->get();
        $carrerasAll = Carrera::orderBy('nombre', 'asc')->get();
        $areasAll = Area::orderBy('especializacion', 'asc')->get();

        $sedes = $sedesAll->where('estado', 1);
        $instituciones = $institucionesAll->where('estado', 1);
        $carreras = $carrerasAll->where('estado', 1);
        $areas = $areasAll->where('estado', 1);
        
        $colabsActividades = AreaRecreativaController::getColabActividades($colaboradores->items());
        // return $colabsActividades;
        $colaboradoresConArea = FunctionHelperController::colaboradoresConArea($colabsActividades);
        $colaboradores->data = $colaboradoresConArea;
        // return $colaboradores;
        $pageData = FunctionHelperController::getPageData($colaboradores);
        $hasPagination = true;
        // return $pageData;
        // return $actividades;
        
        $Allactividades = Actividades::where('estado', 1)->get();
        return view('inspiniaViews.colaboradores.index', [
            'colaboradores' => $colaboradores,
            'hasPagination' => $hasPagination,
            'pageData' => $pageData,
            'sedes' => $sedes,
            'instituciones' => $instituciones,
            'carreras' => $carreras,
            'areas' => $areas,
            'sedesAll' => $sedesAll,
            'institucionesAll' => $institucionesAll,
            'carrerasAll' => $carrerasAll,
            'areasAll' => $areasAll,
            'Allactividades' => $Allactividades,
        ]);
    }

    public function getComputadoraColaborador($colaborador_id){
        $colaborador = Colaboradores::with('candidato')->findOrFail($colaborador_id);

        $computerColab = Computadora_colaborador::where('colaborador_id', $colaborador_id)->first();

        $hasComputer = false;
        $incidencias = [];
        $ultimaIncidencia = null;
        $programas = Programas::where('estado', 1)->orderBy('nombre', 'asc')->get();
        $programasInstalados = [];
        if($computerColab) {
            $hasComputer = true;
            $incidencias = Registro_Mantenimiento::where('computadora_id', $computerColab->id)->where('estado', true)->get();
            $ultimaIncidencia = Registro_Mantenimiento::where('computadora_id', $computerColab->id)->orderBy('fecha', 'desc')->first();
            $programasInstalados = Programas_instalados::with('programa')->where('computadora_id', $computerColab->id)->where('estado', 1)->get();
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

    //FUNCTION getObjetoColabodaor

    public function filtrarColaboradores(string $estados = '0,1,2', string $areas = '', string $carreras = '', string $instituciones = '')
    {
        // Validamos los request de los filtros que queremos aplicar
        $estados = explode(',', $estados);
        $areas = $areas ? explode(',', $areas) : [];
        $carreras = $carreras ? explode(',', $carreras) : [];
        $instituciones = $instituciones ? explode(',', $instituciones) : [];

        $sedesAll = Sede::with('institucion')->orderBy('nombre', 'asc')->get();
        $institucionesAll = Institucion::orderBy('nombre', 'asc')->get();
        $carrerasAll = Carrera::orderBy('nombre', 'asc')->get();
        $areasAll = Area::orderBy('especializacion', 'asc')->get();

        $sedesFiltradas = $sedesAll->where('estado', 1);
        $institucionesFiltradas = $institucionesAll->where('estado', 1);
        $carrerasFiltradas = $carrerasAll->where('estado', 1);
        $areasFiltradas = $areasAll->where('estado', 1);

        $requestCarreras = empty($carreras) ? $carrerasAll->pluck('id')->toArray() : $carreras;
        $requestInstituciones = empty($instituciones) ? $institucionesAll->pluck('id')->toArray() : $instituciones;
        $requestAreas = empty($areas) ? $areasAll->pluck('id')->toArray() : $areas;

        // Obtenemos a los colaboradores filtrados por áreas
        $colaboradoresArea = Colaboradores_por_Area::with('colaborador')
            ->whereIn('area_id', $requestAreas)
            ->get()
            ->pluck('colaborador');

        //filtramos por los estados
        $colaboradoresCandidatoId = $colaboradoresArea->whereIn('estado', $estados)->pluck('candidato_id');

        //filtrar los candidatos por la carrera y la sede - institucion
        $sedesInstitucionesId = Sede::whereIn('institucion_id', $requestInstituciones)->pluck('id');
        $candidatosFiltradosId = Candidatos::whereIn('id', $colaboradoresCandidatoId)
            ->whereIn('carrera_id', $requestCarreras) //filtrar por la carrera
            ->whereIn('sede_id', $sedesInstitucionesId) //filtrar por la sede
            ->pluck('id');

        $colaboradores = Colaboradores::with('candidato')->whereIn('candidato_id', $candidatosFiltradosId)->paginate(12);
        // return $estados;
        foreach($estados as $estado) {
            if(count($estados) === 1){
                if($estado === "2"){
                    $colaboradores = Colaboradores::with('candidato')->whereIn('candidato_id', $candidatosFiltradosId)->orderBy('updated_at', 'desc')->paginate(12);
                }
            }
        }

        $colabsActividades = AreaRecreativaController::getColabActividades($colaboradores->items());
        // $colaboradores->data = FunctionHelperController::colaboradoresConArea($colaboradores);
        $colaboradoresConArea = FunctionHelperController::colaboradoresConArea($colabsActividades);
        $colaboradores->data = $colaboradoresConArea;
        $pageData = FunctionHelperController::getPageData($colaboradores);
        $hasPagination = true;
        $Allactividades = Actividades::where('estado', 1)->get();

        return view('inspiniaViews.colaboradores.index', [
            'colaboradores' => $colaboradores,
            'hasPagination' => $hasPagination,
            'pageData' => $pageData,
            'sedes' => $sedesFiltradas,
            'instituciones' => $institucionesFiltradas,
            'carreras' => $carrerasFiltradas,
            'areas' => $areasFiltradas,
            'sedesAll' => $sedesAll,
            'institucionesAll' => $institucionesAll,
            'carrerasAll' => $carrerasAll,
            'areasAll' => $areasAll,
            'Allactividades' => $Allactividades,

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

                //Encontrar siguiente semana(Lunes)
                $semana = FunctionHelperController::findOrCreateNextWeek();
                
                //Se recorre el request de areas
                foreach($request->areas_id as $area_id){
                    //Se crea un nuevo registro en la tabla Colaboradores_por_Area con el id del colaborador y el id del área
                    Colaboradores_por_Area::create([
                        'colaborador_id' => $colaborador->id,
                        'area_id' => $area_id,
                        'semana_inicio_id' => $semana->id,
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
                'actividades_id.*' => 'sometimes|integer',
                'currentURL' => 'sometimes|string',

            ]);
            //Encontrar al colaborador con su candidato por su id
            $colaborador = Colaboradores::with('candidato')->findOrFail($colaborador_id);
            //Asignar el candidato a una variable
            $candidato = $colaborador->candidato;
            //Encontrar siguiente semana(Lunes)
            $semana = FunctionHelperController::findOrCreateNextWeek();
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
                        'semana_inicio_id' => $semana->id,
                        'estado' => true,
                    ]);
                    //Si se encuentra un colaborador con esta area y esta inactivo
                } else if ($colaborador_por_area->estado == false) {
                    //Se actualiza el estado a activo
                    $colaborador_por_area->update(['estado' => true]);
                    //Crear registro de re activación
                    RegistroActividadController::crearRegistro($colaborador_por_area->id, true);
                }
            }
            
            // Buscar las areas que no estan en el request y que estan asociadas al colaborador
            $areasInactivas = Colaboradores_por_Area::where('colaborador_id', $colaborador_id)->where('estado', 1)->whereNotIn('area_id', $request->areas_id)->get();
            // Por cada registro encontrado
            foreach ($areasInactivas as $areaInactiva) {
                //Se inactiva su estado
                $areaInactiva->update(['estado' => false]);
                //Crear registro de inactivación
                RegistroActividadController::crearRegistro($areaInactiva->id, false);
                //Se busca si tiene computadoras
                $ColabMachines = Maquina_reservada::where('colaborador_area_id', $areaInactiva->id)->get();
                //Recorrer maquinas encontradas
                foreach($ColabMachines as $machine){
                    //Eliminar maquinas
                    $machine->delete();
                }
            }
            if($request->actividades_id == null){
                $actividadesInactivas = AreaRecreativa::where('colaborador_id', $colaborador_id)->where('estado', 1)->get();
                foreach($actividadesInactivas as $actividadInactiva){
                    $actividadInactiva->update(['estado' => false]);
                }
            } else {
                //Lo mismo con las actividades
                foreach($request->actividades_id as $actividad_id){
                    $actividad_recreativa = AreaRecreativa::where('colaborador_id', $colaborador->id)->where('actividad_id', $actividad_id)->first();
    
                    if(!$actividad_recreativa){
                        AreaRecreativa::create([
                            'colaborador_id' => $colaborador->id,
                            'actividad_id' => $actividad_id,
                            'estado' => true
                        ]);
                    } else if($actividad_recreativa->estado == false) {
                        $actividad_recreativa->update(['estado' => true]);
                    }
                }
                //Lo mismo con las actividades, inactivarlas
                $actividadesInactivas = AreaRecreativa::where('colaborador_id', $colaborador_id)->where('estado', 1)->whereNotIn('actividad_id', $request->actividades_id)->get();
                foreach($actividadesInactivas as $actividadInactiva){
                    $actividadInactiva->update(['estado' => false]);
                }
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
            return $e;
            if($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('colaboradores.index');
            }
        }
    }


    public function activarInactivar(Request $request, $colaborador_id)
    {
        DB::beginTransaction();
        try{
            $colaborador = Colaboradores::findOrFail($colaborador_id);

            $colaborador->estado = !$colaborador->estado;

            $colaborador->save();

            if($colaborador->estado == 0){
                $colaboradoresAreaActivos = Colaboradores_por_Area::where('colaborador_id', $colaborador->id)->where('estado', 1)->get();
                foreach($colaboradoresAreaActivos as $colabArea){
                    $colabArea->update(['estado' => false]);
                    //Crear registro de inactivación
                    RegistroActividadController::crearRegistro($colabArea->id, false);
                }
            }
            DB::commit();

            // return redirect()->route('colaboradores.index');
            if($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('colaboradores.index');
            }
        } catch(Exception $e) {
            DB::rollBack();
            return $e->getMessage();
            // return redirect()->route('colaboradores.index');
            if($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('colaboradores.index');
            }
        }
    }

    public function search(string $busqueda = '')
    {

        //asignar a variable
        // $busqueda = $request->busqueda;

        //Obtener colaboradores con nombre
        //Filtrar por id
        $colaboradorPorId = Colaboradores::with('candidato')->where('id', $busqueda)->paginate(12);

        //Obtener todos los colabs con candidato por function query
        $colaboradoresTotales = Colaboradores::with([
            'candidato' => function ($query) {
                $query->select('id', 'nombre', 'apellido', 'dni', 'direccion', 'fecha_nacimiento', 'ciclo_de_estudiante', 'estado', 'sede_id', 'carrera_id', 'icono', 'correo', 'celular'); }
        ]);
        //Filtrar por nombre y apellido de candidato
        $colaboradoresPorNombre = $colaboradoresTotales->whereHas('candidato', function ($query) use ($busqueda) {
            $query->where(DB::raw("CONCAT(nombre, ' ', apellido)"), 'like', '%' . $busqueda . '%');
        })->paginate(12);

        //Si existe un registro encontrado por el id
        if ($colaboradorPorId->count() > 0) {
            //Se asigna el valor del colaboradorPorId
            $colaboradores = $colaboradorPorId;
        } else { //Si no existe
            //Se asigna el valor de los colaboradoresPorNombre
            $colaboradores = $colaboradoresPorNombre;
        }

        $sedesAll = Sede::with('institucion')->orderBy('nombre', 'asc')->get();
        $institucionesAll = Institucion::orderBy('nombre', 'asc')->get();
        $carrerasAll = Carrera::orderBy('nombre', 'asc')->get();
        $areasAll = Area::orderBy('especializacion', 'asc')->get();

        $sedes = $sedesAll->where('estado', 1);
        $instituciones = $institucionesAll->where('estado', 1);
        $carreras = $carrerasAll->where('estado', 1);
        $areas = $areasAll->where('estado', 1);

        $colabsActividades = AreaRecreativaController::getColabActividades($colaboradores->items());
        $colaboradoresConArea = FunctionHelperController::colaboradoresConArea($colabsActividades);
        $colaboradores->data = $colaboradoresConArea;
        $pageData = FunctionHelperController::getPageData($colaboradores);
        $hasPagination = true;

        //return $colaboradoresConArea;
        $Allactividades = Actividades::where('estado', 1)->get();
        return view('inspiniaViews.colaboradores.index', [
            'colaboradores' => $colaboradores,
            'hasPagination' => $hasPagination,
            'pageData' => $pageData,
            'sedes' => $sedes,
            'instituciones' => $instituciones,
            'carreras' => $carreras,
            'areas' => $areas,
            'sedesAll' => $sedesAll,
            'institucionesAll' => $institucionesAll,
            'carrerasAll' => $carrerasAll,
            'areasAll' => $areasAll,
            'Allactividades' => $Allactividades,
        ]);

    }

    public function despedirColaborador(Request $request, $colaborador_id){
        DB::beginTransaction();
        try{
            $colaborador = Colaboradores::findOrFail($colaborador_id);

            if($colaborador){
                //encontrar Candidato
                $candidato = Candidatos::findOrFail($colaborador->candidato_id);
                if($candidato){
                    //Estado 3 igual a ex trabajador en candidatos
                    $candidato->update(["estado" => 3]);
                }
                //encontrar ColaboradoresPorArea
                $colaboradorAreas = Colaboradores_por_Area::where('colaborador_id', $colaborador_id)->where('estado', 1)->get();
                foreach($colaboradorAreas as $colabArea){
                    $colabArea->update(["estado" => 0]); //inactivo del área
                    //Crear registro de inactivación
                    RegistroActividadController::crearRegistro($colabArea->id, false);
                }
                //Estado 2 es igual a ex trabajador
                $colaborador->update(["estado" => 2]);
            }
            DB::commit();
            if($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('colaboradores.index');
            }

        } catch(Exception $e){
            DB::rollBack();
            if($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('colaboradores.index');
            }
        }
    }

    public function recontratarColaborador(Request $request, $colaborador_id){
        DB::beginTransaction();
        try{
            //encontrar Colaborador
            $colaborador = Colaboradores::findOrFail($colaborador_id);
            if($colaborador) {
                //encontrar Candidato
                $candidato = Candidatos::findOrFail($colaborador->candidato_id);
                if($candidato) {
                    $candidato->update(["estado" => 0]); //estado 0 igual a activo en candidatos
                }
                $colaborador->update(["estado" => 1]); //estado 1 igual a activo en colaboradores
            }
            DB::commit();
            if($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('colaboradores.index');
            }
        } catch(Exception $e){
            DB::rollBack();
            if($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('colaboradores.index');
            }
        }
    }
    public function destroy(Request $request, $colaborador_id)
    {
        DB::beginTransaction();
        try{
            $colaborador = Colaboradores::findOrFail($colaborador_id);
            if($colaborador){
                //primero encontramos al candidato
                $candidato = Candidatos::findOrFail($colaborador->candidato_id);
                if($candidato) {
                    //despues a los colaboradores (suponiendo que por error tenga mas de uno)
                    $colaboradores = Colaboradores::where('candidato_id', $candidato->id)->get();
                    //despues a los colaboradores por area de todos los colaboradores encontrados
                    $colaboradores_por_area = Colaboradores_por_Area::whereIn('colaborador_id', $colaboradores->pluck('id'))->get();
                    //despues todos los horarios de clase de estos colaboradores
                    $horarios_de_clases = Horario_de_Clases::whereIn('colaborador_id', $colaboradores->pluck('id'))->get();
                    //ahora los registros de actividad de los colaboradores con area
                    $registros_actividad = RegistroActividad::whereIn('colaborador_area_id', $colaboradores_por_area->pluck('id'))->get();
                    //despues todos las maquinas reservadas de los colaboradores con area
                    $maquinas_reservadas = Maquina_reservada::whereIn('colaborador_area_id', $colaboradores_por_area->pluck('id'))->get();
                    //ahora todas las responsabilidades semanales cumplidas por todos los colaboradores con area}
                    $responsabilidades_semanales_cumplidas = Cumplio_Responsabilidad_Semanal::whereIn('colaborador_area_id', $colaboradores_por_area->pluck('id'))->get();
                    //despues todas las computadoras de todos los colaborades encontrados
                    $computadoras = Computadora_colaborador::whereIn('colaborador_id', $colaboradores->pluck('id'))->get();
                    //luego a todos los programas instalados de estas computadoras
                    $programas_instalados = Programas_instalados::whereIn('computadora_id', $computadoras->pluck('id'))->get();
                    //luego todos los registros de mantenimientos de las computadoras
                    $registros_mantenimientos = Registro_Mantenimiento::whereIn('computadora_id', $computadoras->pluck('id'))->get();
                    //ahora todos los prestamos de objetos del colaborador
                    $prestamos_objetos = Prestamos_objetos_por_colaborador::whereIn('colaborador_id', $colaboradores->pluck('id'))->get();
                    //finalmente todas las asistencias de clases (Aun no implementada pero puesta de igual manera para evitar errores)
                    $asistencias_clases = Asistentes_Clase::whereIn('colaborador_id', $colaboradores->pluck('id'))->get();

                    //ELIMINACIÓN EN CASCADA
                    //ahora procedemos a eliminarlos de los ultimos a los primeros
                    //asistencias_clase
                    foreach($asistencias_clases as $asistencia_clase) {
                        $asistencia_clase->delete();
                    }
                    //prestamos_objetos
                    foreach($prestamos_objetos as $prestamo_objeto) {
                        $prestamo_objeto->delete();
                    }
                    //registros_mantenimientos
                    foreach($registros_mantenimientos as $registro_mantenimiento) {
                        $registro_mantenimiento->delete();
                    }
                    //programas_instalados
                    foreach($programas_instalados as $programa_instalado) {
                        $programa_instalado->delete();
                    }
                    //computadoras
                    foreach($computadoras as $computadora) {
                        $computadora->delete();
                    }
                    //responsabilidades_Semanales_cumplidas
                    foreach($responsabilidades_semanales_cumplidas as $responsabilidad_semanal_cumplida) {
                        $responsabilidad_semanal_cumplida->delete();
                    }
                    //maquinas_reservadas
                    foreach($maquinas_reservadas as $maquina_reservada) {
                        $maquina_reservada->delete();
                    }
                    //registros_actividad
                    foreach($registros_actividad as $registro_actividad) {
                        $registro_actividad->delete();
                    }
                    //horarios_de_clases
                    foreach($horarios_de_clases as $horario_de_clase) {
                        $horario_de_clase->delete();
                    }
                    //colaboradores_por_area
                    foreach($colaboradores_por_area as $colaborador_por_area) {
                        $colaborador_por_area->delete();
                    }
                    //colaboradores
                    foreach($colaboradores as $colab) {
                        $colab->delete();
                    }
                    //candidato
                    $candidato->delete();
                }
            }

            DB::commit();
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
}
