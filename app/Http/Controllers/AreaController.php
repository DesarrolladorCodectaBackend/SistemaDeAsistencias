<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Colaboradores_por_Area;
use App\Models\Horario_de_Clases;
use App\Models\Horario_Presencial_Asignado;
use App\Models\Horarios_Presenciales;
use App\Models\Maquinas;
use App\Models\Maquina_reservada;
use App\Models\Candidatos;
use App\Models\Colaboradores;
use App\Models\Salones;
use Illuminate\Http\Request;
use App\Http\Requests\StoreareaRequest;
use App\Http\Requests\UpdateareaRequest;
use Illuminate\Support\Facades\DB;

class AreaController extends Controller
{
    /**
     * INDEX
     * 
     * Se encarga de mostrar todos los registros de áreas en la vista index.blade.php de la carpeta areas.
     * 
     * @response 200 vista index.blade.php con todas las áreas
     * 
     */
    public function index()
    {
        //Recurar todos los registros en áreas
        $areas = Area::with('salon')->paginate(12);
        $salones = Salones::get();
        $pageData = FunctionHelperController::getPageData($areas);
        $hasPagination = true;
        // return response()->json(["areas" => $areas]);
        //Redirigir a la vista mandando las áreas
        return view('inspiniaViews.areas.index', [
            'areas' => $areas,
            'hasPagination' => $hasPagination,
            'pageData' => $pageData,
            'salones' => $salones
        ]);
    }
    
    public function getFormHorarios($area_id) {
        // Encontrar area
        $area = Area::findOrFail($area_id);
        // Encontrar el id de los colaboradores del área
        $colaboradoresAreaId = Colaboradores_por_Area::where('estado', true)->where('area_id', $area_id)->pluck('colaborador_id');
        // Encontrar los días de clase de esos colaboradores
        $horariosColaboradores = Horario_de_Clases::whereIn('colaborador_id', $colaboradoresAreaId)->get();
        // Obtener todos los Horarios presenciales disponibles
        $horariosPresenciales = Horarios_Presenciales::all();
        // Array para las horas ocupadas de los colaboradores
        $horasOcupadas = [];
        // Recorrer los horarios de los colaboradores
        foreach ($horariosColaboradores as $horarioColab) {
            $dia = $horarioColab->dia;
            $horaInicial = strtotime($horarioColab->hora_inicial);
            $horaFinal = strtotime($horarioColab->hora_final);
    
            // Por cada hora en el rango, agregar la hora al array de horas ocupadas para ese día
            for ($hora = $horaInicial; $hora <= $horaFinal; $hora += 3600) {
                //Agregar key dia y dentro de cada uno las horas que están ocupados durante ese día
                $horasOcupadas[$dia][] = date('H', $hora);
            }
        }
        // Array para los horarios disponibles
        $horariosDisponibles = [];
        // Recorrer todos los Horarios Presenciales
        foreach ($horariosPresenciales as $horarioPres) {
            $diaPres = $horarioPres->dia;
            $horaInicialPres = strtotime($horarioPres->hora_inicial);
            $horaFinalPres = strtotime($horarioPres->hora_final);
            $rangoHorasPres = [];
    
            // Rellenar el rango de horas del horario presencial
            for ($hora = $horaInicialPres; $hora <= $horaFinalPres; $hora += 3600) {
                $rangoHorasPres[] = date('H', $hora);

            }
            // return $rangoHorasPres;
            $disponible = true;
    
            // Comprobar si alguna de las horas del horario presencial coincide con las horas ocupadas
            if (isset($horasOcupadas[$diaPres])) {
                // error_log($diaPres);
                //Recorrer el rango de horas presenciales
                foreach ($rangoHorasPres as $hora) {
                    //Si la hora está dentro de las horas ocupadas del día
                    if (in_array($hora, $horasOcupadas[$diaPres])) {
                        //Este horario no estará disponible
                        $disponible = false;
                        break;
                    }
                }
            }
            //Si disponible es true
            if ($disponible) {
                //Se agrega el horario disponible al array de horarios disponibles
                $horariosDisponibles[] = $horarioPres;
            }
        }
        //Verificar si el área tiene horario asignado
        $hasHorario = false;
        //Ver si el area tiene horarios asignados
        $horarioAsignado = Horario_Presencial_Asignado::with('horario_presencial')->where('area_id', $area_id)->get();
        //Array de horariosFormateados
        $horariosFormateados = [];
        //Si el area tiene horarios asignados
        if(count($horarioAsignado)>0){
            //Se marca hasHorario como true
            $hasHorario = true;
            //Se recorre el horarios asignado
            foreach ($horarioAsignado as $horario) {
                $horaInicial = (int) date('H', strtotime($horario->horario_presencial->hora_inicial));
                $horaFinal = (int) date('H', strtotime($horario->horario_presencial->hora_final));
                //Se formatean las horas y se guarda en el array
                $horariosFormateados[] = [
                    'hora_inicial' => $horaInicial,
                    'hora_final' => $horaFinal,
                    'dia' => $horario->horario_presencial->dia,
                ];
            }

        } else{
            // Si no tiene horarios asignados, se marca hasHorario como false
            $hasHorario = false;
        }
        // Recorrer los horarios disponibles
        foreach($horariosDisponibles as $horario) {
            //En caso sea igual al horario asignado, darle un campo "using" true
            //Si hasHorario es true
            if($hasHorario) {
                //Se recorre cada horario Asignado
                foreach($horarioAsignado as $horarioAsig) {
                    //Si el horario asignado es igual al horario disponible
                    if($horarioAsig->horario_presencial_id == $horario->id) {
                        // Se marca como en uso
                        $horario->using = true;
                        break;
                    } else {
                        //Sino se marca como false
                        $horario->using = false;
                    }
                }
            } else {
                //Si no tiene horario asignado, se marca como false
                $horario->using = false;
            }
        }

        // return response()->json(["area" => $area, "horariosDisponibles" => $horariosDisponibles, "horarioAsignado" => $horarioAsignado, "horariosFormateados" => $horariosFormateados, "hasHorario" => $hasHorario]);
        return view('inspiniaViews.areas.gestHorarios', [
            "area" => $area,
            "horariosDisponibles" => $horariosDisponibles,
            "horarioAsignado" => $horarioAsignado,
            "horariosFormateados" => $horariosFormateados,
            "hasHorario" => $hasHorario
        ]);
        
    
    }


    public function getMaquinasByArea($area_id){
        $area = Area::findOrFail($area_id);
        //Datos esta area
        $horariosArea = Horario_Presencial_Asignado::where('area_id', $area->id)->pluck('horario_presencial_id');

        //Buscar otras areas con el mismo horario
        $allAreasConcurrentes = Horario_Presencial_Asignado::with('area')->whereIn('horario_presencial_id', $horariosArea)
            ->whereNot('area_id', $area->id)->get()->pluck('area');
        
        //Areas del mismo salon            
        $salonAreasConcurrentesId = $allAreasConcurrentes->where('salon_id', $area->salon_id)->pluck('id');
        $colaboradoresOtherAreas = Colaboradores_por_Area::with('colaborador')->whereIn('area_id', $salonAreasConcurrentesId)->get();

        $colaboradoresThisArea = Colaboradores_por_Area::with('colaborador')->where('area_id', $area->id)->get();

        foreach($colaboradoresThisArea as $colabHere){
            foreach($colaboradoresOtherAreas as $key => $colabThere){
                if($colabHere->colaborador_id == $colabThere->colaborador_id) {
                    //Añadir el colab there a la lista de colaboradores de esta area
                    $colaboradoresThisArea->push($colabThere);
                    //Quitar colabThere de su colección original
                    $colaboradoresOtherAreas->forget($key);
                }

            }
        }
        $colaboradoresOtherAreasId = $colaboradoresOtherAreas->pluck('id');
        $maquinasOtherAreas = Maquina_reservada::with('colaborador_area')->whereIn('colaborador_area_id', $colaboradoresOtherAreasId)->get();

        // return ["this" => $colaboradoresThisArea, "other" => $colaboradoresOtherAreas];
        $colaboradoresThisAreaId = $colaboradoresThisArea->pluck('id');
        $maquinasThisArea = Maquina_reservada::with('colaborador_area')->whereIn('colaborador_area_id', $colaboradoresThisAreaId)->get();


        // return $colaboradoresThisArea->pluck('id');
        //Todas las maquinas de este salon
        $maquinas = Maquinas::where('salon_id', $area->salon_id)->get();

        foreach($maquinas as $maquina){
            $maquina->estaArea = false;
            $maquina->otraArea = false;
            $maquina->maquina_reservada_id = null;
            $maquina->colaborador = 'Sin asignar';
            $maquina->colaborador_id = null;
            foreach($maquinasOtherAreas as $otherMaquina){
                if($maquina->id === $otherMaquina->maquina_id){
                    $areaNombre = $otherMaquina->colaborador_area->area->especializacion;
                    $maquina->otraArea = true;
                    $maquina->colaborador = 'Asignada a otra area ('.$areaNombre.')';
                    $maquina->maquina_reservada_id = $otherMaquina->id;
                }
            }
            foreach($maquinasThisArea as $thisMaquina){
                if($maquina->id === $thisMaquina->maquina_id){
                    $maquina->estaArea = true;
                    $colaborador = Colaboradores::with('candidato')->where('id', $thisMaquina->colaborador_area->colaborador_id)->first();
                    $candidato = $colaborador->candidato;
                    $maquina->colaborador = $candidato->nombre." ".$candidato->apellido;
                    $maquina->colaborador_id = $thisMaquina->colaborador_area_id;
                    $maquina->maquina_reservada_id = $thisMaquina->id;
                }
            }
        }

        foreach($colaboradoresThisArea as $colaboradorArea){
            $colaboradorArea->hasMaquina = false;
            $candidato =  Candidatos::findOrFail($colaboradorArea->colaborador->candidato_id);
            $colaboradorArea->nombre = $candidato->nombre." ".$candidato->apellido;

            $maquina = Maquina_reservada::where('colaborador_area_id', $colaboradorArea->id)->first();
            if($maquina){
                $colaboradorArea->hasMaquina = true;
            }

        }

        // return response()->json(['maquina' => $maquinas, 'colaboradoresArea' => $colaboradoresThisArea, 'area' => $area]);
        return view('inspiniaViews.areas.maquinas', [
            'maquinas' => $maquinas,
            'area' => $area,
            'colaboradoresArea' => $colaboradoresThisArea,
        ]);
    }


    /**
     *  STORE
     *  
     *  Se encarga de guardar los datos de un área en la base de datos. Con imagen definida o default.
     * 
     *  @bodyParam especializacion string required Especialización del área.
     *  @bodyParam descripcion string required Descripción del área.
     *  @bodyParam color_hex string required Color hexadecimal del área.
     *  @bodyParam icono file Imagen del área. Ejemplo: "icono.png" (opcional)
     *  
     *  @response 200 Ruta de redirección a la vista index.blade.php.
     * 
     *  @response 400 {"message": "Debe ingresar la especialización"}
     *  @response 400 {"message": "Debe ingresar la descripción"}
     *  @response 400 {"message": "Debe ingresar el color"}
     * 
     * 
     */
    public function store(Request $request)
    {
        //Se inicia la transacción 
        DB::beginTransaction();
        try{
            //Solicitar los datos requeridos
            $request->validate([
                'especializacion' => 'required|string|min:1|max:100',
                'descripcion' => 'required|string|min:1|max:255',
                'color_hex' => 'required|string|min:1|max:7',
                'salon_id' => 'required|integer',
                'icono' => 'image'
            ]);
            //Validar que los datos no esten vacios
            // if(!$request->especializacion) return response()->json(["message" => "Debe ingresar la especialización"]);
            // if(!$request->descripcion) return response()->json(["message" => "Debe ingresar la descripcion"]);
            // if(!$request->color_hex) return response()->json(["message" => "Debe ingresar el color"]);
            
            //Validar que la imagen haya sido ingresada
            if ($request->hasFile('icono')) {
                //Si se ingresó se guarda en la variable icono
                $icono = $request->file('icono');
                //Le asignamos un nombre único con la fecha y hora exacta actual y la extensión del archivo
                $nombreIcono = time() . '.' . $icono->getClientOriginalExtension();
                //Se mueve la imagen a la carpeta storage/areas con el nombre único que se le asignó anteriormente
                $icono->move(public_path('storage/areas'), $nombreIcono);
            } else {
                //Si no se ingresó se asigna el nombre de la imagen por defecto
                $nombreIcono = 'Default.png';
            }
    
            //Area::create($request->all());
            //Se crea un nuevo registro con  los datos requeridos y la imagen definida o default
            Area::create([
                'especializacion' => $request->especializacion,
                'descripcion' => $request->descripcion,
                'color_hex' => $request->color_hex,
                'salon_id' => $request->salon_id,
                'icono' => $nombreIcono
            ]);
            //Se confirma la transacción
            DB::commit();
            //return response()->json(["resp" => "Área creada correctamente"]);
            //Se redirige a la vista index.blade.php de la carpeta areas
            if($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('areas.index');
            }
        } catch (\Exception $e) {
            //Si ocurre algún error
            //Se revierte la transacción
            DB::rollback();
            if($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('areas.index');
            }
            //Se retorna un mensaje avisando que hubo un error con la información del error
            // return response()->json(["message" => "Error al crear el registro", "error" => $e->getMessage()]);
        }
    }

    /**
     *  UPDATE
     *  
     *  Se encarga de actualizar los datos de un área en la base de datos. 
     * 
     *  @urlParam  area_id integer required ID del área a actualizar. 
     *  
     *  @bodyParam especializacion string Especialización del área.
     *  @bodyParam descripcion string Descripción del área.
     *  @bodyParam color_hex string Color hexadecimal del área.
     *  @bodyParam icono file Imagen del área.
     * 
     *  @response 200 Ruta de redirección a la vista de áreas. 
     * 
     */

    public function update(Request $request, $area_id)
    {
        //Se inicia la transacción
        DB::beginTransaction();
        try{
            //Se raliza la validación de los datos ingresados por el usuario
            $request->validate([
                'especializacion' => 'sometimes|string|min:1|max:100',
                'descripcion' => 'sometimes|string|min:1|max:255',
                'color_hex' => 'sometimes|string|min:1|max:7',
                'salon_id' => 'sometimes|integer',
                'icono' => 'sometimes|image',
            ]);

            // return $request;

            //Se busca el área por el id ingresado como parámetro 
            $area = Area::findOrFail($area_id);
            //Se asignan los valores ingresados por el usuario a las variables correspondientes, si no se ingresó nada se asigna el valor actual de la base de datos
            $especializacion = !$request->especializacion ? $area->especializacion : $request->especializacion;
            $descripcion = !$request->descripcion ? $area->descripcion : $request->descripcion;
            $color_hex = !$request->color_hex ? $area->color_hex : $request->color_hex;
            $salon_id = !$request->salon_id ? $area->salon_id : $request->salon_id;
            //Se crea un array con los datos a actualizar
            $datosActualizar = [
                "especializacion" => $especializacion, 
                "descripcion" => $descripcion, 
                "color_hex" => $color_hex,
                "salon_id" => $salon_id
            ];
            //Se verifica si se ingresó la imagen
            if ($request->hasFile('icono')) {
                //Si existe buscamos la ruta publica
                $rutaPublica = public_path('storage/areas');
                //Si existe la imagen y no es la imagen por defecto, se elimina la imagen anterior
                if ($area->icono && $area->icono !== 'default.png') {
                    unlink($rutaPublica . '/' . $area->icono);
                }
                //Se obtiene la imagen ingresada por el usuario
                $icono = $request->file('icono');
                //Se obtiene el nombre de la imagen ingresada por el usuario y se le agrega la extensión de la imagen
                $nombreIcono = time() . '.' . $icono->getClientOriginalExtension();
                //Se mueve la imagen a la ruta publica con el nombre de la imagen definido anteriormente
                $icono->move($rutaPublica, $nombreIcono);
                //Se agrega el nombre de la imagen al array de datos a actualizar
                $datosActualizar['icono'] = $nombreIcono;
            }
            //Se actualiza el área con los datos ingresados por el usuario
            $area->update($datosActualizar);
            //Se confirma la transacción
            DB::commit();
            //Se redirige a la vista index.blade.php de la carpeta areas
            if($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('areas.index');
            }
        } catch (\Exception $e) {
            //Si ocurre algún error
            //Se revierte la transacción
            DB::rollBack();
            if($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('areas.index');
            }
            //Se retorna un mensaje avisando que hubo un error con la información del error
            // return response()->json(["message" => "Hubo un error", "error" => $e->getMessage()]);
        }
    }



    // public function destroy($area_id)
    // {
    //     $area = Area::findOrFail($area_id);

    //     $area->delete();

    //     return redirect()->route('areas.index');
    // }


    public function activarInactivar(Request $request, $area_id){
        
    }

}
