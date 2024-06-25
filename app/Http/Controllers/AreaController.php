<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Colaboradores_por_Area;
use App\Models\Horario_de_Clases;
use App\Models\Horario_Presencial_Asignado;
use App\Models\Horarios_Presenciales;
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
        $areas = Area::get();
        // return response()->json(["areas" => $areas]);
        //Redirigir a la vista mandando las áreas
        return view('inspiniaViews.areas.index', compact('areas'));
    }

    public function create()
    {
        return view('areas.create');
    }

    
    public function getFormHorarios($area_id){
        //Encontrar area
        $area = Area::findOrFail($area_id);
        //Encontrar el id de los colaboradores del área
        $colaboradoresAreaId = Colaboradores_por_Area::where('area_id', $area_id)->get()->pluck('colaborador_id');
        //encontrar los días de clase de esos colaboradores
        $horariosColaboradores = Horario_de_Clases::whereIn('colaborador_id', $colaboradoresAreaId)->get();
        $diasColaboradores = $horariosColaboradores->pluck('dia');
        //Filtrar los horarios exceptuando las que tiene días usados por los colaboradores
        $horariosDisponibles = Horarios_Presenciales::whereNotIn('dia', $diasColaboradores)->get();
        
        $hasHorario = false;
        $horarioAsignado = Horario_Presencial_Asignado::with('horario_presencial')->where('area_id', $area_id)->get();
        
        $horariosFormateados = [];
        if(count($horarioAsignado)>0){
            $hasHorario = true;
            foreach ($horarioAsignado as $horario) {
                $horaInicial = (int) date('H', strtotime($horario->horario_presencial->hora_inicial));
                $horaFinal = (int) date('H', strtotime($horario->horario_presencial->hora_final));
    
                $horariosFormateados[] = [
                    'hora_inicial' => $horaInicial,
                    'hora_final' => $horaFinal,
                    'dia' => $horario->horario_presencial->dia,
                ];
            }

        } else{
            $hasHorario = false;
        }

        foreach($horariosDisponibles as $horario) {
            //En caso sea igual al horario asignado, darle un campo "actual" true; para que en el front sepa que es el horario actual y no lo pueda cambiar
            //Hacer los cambios en el mismo array usado "horariosDisponibles" para no tener que hacer otro foreach y no tener que crear otro array
            if($hasHorario) {
                foreach($horarioAsignado as $horarioAsig) {
                    if($horarioAsig->horario_presencial_id == $horario->id) {
                        $horario->actual = true;
                        break;
                    } else {
                        $horario->actual = false;
                    }
                }
            } else {
                $horario->actual = false;
            }
        }

        // return $horariosDisponibles;

        return view('inspiniaViews.areas.gestHorarios', [
            "area" => $area,
            "horariosDisponibles" => $horariosDisponibles,
            "horarioAsignado" => $horarioAsignado,
            "horariosFormateados" => $horariosFormateados,
            "hasHorario" => $hasHorario
        ]);
    }
    
    

    /*
    public function getFormHorarios($area_id)
    {
        // Encontrar área
        $area = Area::findOrFail($area_id);
        
        // Encontrar el id de los colaboradores del área
        $colaboradoresAreaId = Colaboradores_por_Area::where('area_id', $area_id)->get()->pluck('colaborador_id');
        
        // Encontrar los días y horas de clase de esos colaboradores
        $horariosColaboradores = Horario_de_Clases::whereIn('colaborador_id', $colaboradoresAreaId)->get();
        
        // Filtrar los horarios exceptuando los que tienen conflictos de día y horas usadas por los colaboradores
        $horariosDisponibles = Horarios_Presenciales::all()->filter(function ($horarioPresencial) use ($horariosColaboradores) {
            foreach ($horariosColaboradores as $horarioColaborador) {
                if ($horarioPresencial->dia == $horarioColaborador->dia) {
                    $inicioPresencial = strtotime($horarioPresencial->hora_inicial);
                    $finPresencial = strtotime($horarioPresencial->hora_final);
                    $inicioColaborador = strtotime($horarioColaborador->hora_inicial);
                    $finColaborador = strtotime($horarioColaborador->hora_final);
                    
                    // return response()->json(["IP" => $inicioPresencial, "FP" => $finPresencial,
                    //     "IC" => $inicioColaborador, "FC" => $finColaborador]);

                    // Verificar si hay solapamiento de horarios
                    if (($inicioPresencial < $finColaborador) && ($finPresencial > $inicioColaborador)) {
                        return false; // Solapamiento encontrado, excluir este horario
                    }
                    // if(($inicioColaborador >= $inicioPresencial) && ()){

                    // }
                }
            }
            return true; // No hay solapamiento, incluir este horario
        });

        $hasHorario = false;
        $horarioAsignado = Horario_Presencial_Asignado::with('horario_presencial')->where('area_id', $area_id)->get();

        $horariosFormateados = [];
        if (count($horarioAsignado) > 0) {
            $hasHorario = true;
            foreach ($horarioAsignado as $horario) {
                $horaInicial = (int) date('H', strtotime($horario->horario_presencial->hora_inicial));
                $horaFinal = (int) date('H', strtotime($horario->horario_presencial->hora_final));

                $horariosFormateados[] = [
                    'hora_inicial' => $horaInicial,
                    'hora_final' => $horaFinal,
                    'dia' => $horario->horario_presencial->dia,
                ];
            }
        } else {
            $hasHorario = false;
        }

        foreach ($horariosDisponibles as $horario) {
            // En caso sea igual al horario asignado, darle un campo "actual" true; para que en el front sepa que es el horario actual y no lo pueda cambiar
            // Hacer los cambios en el mismo array usado "horariosDisponibles" para no tener que hacer otro foreach y no tener que crear otro array
            if ($hasHorario) {
                foreach ($horarioAsignado as $horarioAsig) {
                    if ($horarioAsig->horario_presencial_id == $horario->id) {
                        $horario->actual = true;
                        break;
                    } else {
                        $horario->actual = false;
                    }
                }
            } else {
                $horario->actual = false;
            }
        }

        return response()->json(["HC" => $horariosColaboradores, "Disp" => $horariosDisponibles]);

        return view('inspiniaViews.areas.gestHorarios', [
            "area" => $area,
            "horariosDisponibles" => $horariosDisponibles,
            "horarioAsignado" => $horarioAsignado,
            "horariosFormateados" => $horariosFormateados,
            "hasHorario" => $hasHorario
        ]);
    }
    */




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
                'icono' => 'image|mimes:jpeg,png,jpg,gif'
            ]);
            //Validar que los datos no esten vacios
            if(!$request->especializacion) return response()->json(["message" => "Debe ingresar la especialización"]);
            if(!$request->descripcion) return response()->json(["message" => "Debe ingresar la descripcion"]);
            if(!$request->color_hex) return response()->json(["message" => "Debe ingresar el color"]);
            
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
                'icono' => $nombreIcono
            ]);
            //Se confirma la transacción
            DB::commit();
            //return response()->json(["resp" => "Área creada correctamente"]);
            //Se redirige a la vista index.blade.php de la carpeta areas
            return redirect()->route('areas.index');
        } catch (\Exception $e) {
            //Si ocurre algún error
            //Se revierte la transacción
            DB::rollback();
            //Se retorna un mensaje avisando que hubo un error con la información del error
            return response()->json(["message" => "Error al crear el registro", "error" => $e->getMessage()]);
        }
    }

    public function show($area_id)
    {
        $area = Area::find($area_id);

        return response()->json(["data" => $area]);
    }


    public function edit($area_id)
    {
        $area = Area::findOrFail($area_id);

        return view('inspiniaViews.areas.edit', compact('area'));
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
                'icono' => 'sometimes|image|mimes:jpeg,png,jpg,gif'
            ]);

            // return $request;

            //Se busca el área por el id ingresado como parámetro 
            $area = Area::findOrFail($area_id);
            //Se asignan los valores ingresados por el usuario a las variables correspondientes, si no se ingresó nada se asigna el valor actual de la base de datos
            $especializacion = !$request->especializacion ? $area->especializacion : $request->especializacion;
            $descripcion = !$request->descripcion ? $area->descripcion : $request->descripcion;
            $color_hex = !$request->color_hex ? $area->color_hex : $request->color_hex;
            //Se crea un array con los datos a actualizar
            $datosActualizar = [
                "especializacion" => $especializacion, 
                "descripcion" => $descripcion, 
                "color_hex" => $color_hex
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
            return redirect()->route('areas.index');
        } catch (\Exception $e) {
            //Si ocurre algún error
            //Se revierte la transacción
            DB::rollBack();
            //Se retorna un mensaje avisando que hubo un error con la información del error
            return response()->json(["message" => "Hubo un error", "error" => $e->getMessage()]);
        }
    }



    public function destroy($area_id)
    {
        $area = Area::findOrFail($area_id);

        $area->delete();

        return redirect()->route('areas.index');
    }
}
