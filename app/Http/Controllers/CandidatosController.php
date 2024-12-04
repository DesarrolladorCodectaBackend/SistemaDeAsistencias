<?php

namespace App\Http\Controllers;

use App\Models\Candidatos;
use App\Models\Colaboradores;
use App\Models\Institucion;
use App\Models\Carrera;
use App\Models\Area;
use App\Models\User;
use App\Models\Sede;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCandidatosRequest;
use App\Http\Requests\UpdateCandidatosRequest;
use Illuminate\Support\Facades\DB;
use Exception;

class CandidatosController extends Controller
{

    public function index()
    {
        $access = FunctionHelperController::verifyAdminAccess();
        if(!$access){
            return redirect()->route('dashboard')->with('error', 'No tiene acceso para ejecutar esta acción. No lo intente denuevo o puede ser baneado.');
        }
        $candidatos = Candidatos::with('carrera', 'sede')->where("estado", 1)->paginate(6);

        $sedesAll = Sede::with('institucion')->orderBy('nombre', 'asc')->get();
        $institucionesAll = Institucion::orderBy('nombre', 'asc')->get();
        $carrerasAll = Carrera::orderBy('nombre', 'asc')->get();

        $sedes = $sedesAll->where('estado', 1);
        $instituciones = $institucionesAll->where('estado', 1);
        $carreras = $carrerasAll->where('estado', 1);

        $pageData = FunctionHelperController::getPageData($candidatos);
        $hasPagination = true;
        // return $pageData;
        return view('inspiniaViews.candidatos.index', [
            'candidatos' => $candidatos,
            'hasPagination' => $hasPagination,
            'pageData' => $pageData,
            'sedes' => $sedes,
            'instituciones' => $instituciones,
            'carreras' => $carreras,
            'sedesAll' => $sedesAll,
            'institucionesAll' => $institucionesAll,
            'carrerasAll' => $carrerasAll,
        ]);
    }

    public function getFormToColab($candidato_id)
    {
        $access = FunctionHelperController::verifyAdminAccess();
        if(!$access){
            return redirect()->route('dashboard')->with('error', 'No tiene acceso para ejecutar esta acción. No lo intente denuevo o puede ser baneado.');
        }
        $candidato = Candidatos::findOrFail($candidato_id);
        $areas = Area::where('estado', 1)->orderBy('especializacion', 'asc')->get();
        $horas = [
            "07:00",
            "08:00",
            "09:00",
            "10:00",
            "11:00",
            "12:00",
            "13:00",
            "14:00",
            "15:00",
            "16:00",
            "17:00",
            "18:00",
            "19:00",
            "20:00",
            "21:00",
            "22:00",
        ];
        return view('inspiniaViews.candidatos.form-candidatos', ['candidato' => $candidato, 'horas' => $horas], compact('areas'));
    }


    public function store(StoreCandidatosRequest $request)
    {
        $access = FunctionHelperController::verifyAdminAccess();
        if(!$access){
            return redirect()->route('dashboard')->with('error', 'No tiene acceso para ejecutar esta acción. No lo intente denuevo o puede ser baneado.');
        }
        DB::beginTransaction();
        try{
            $request->validated();

            if(isset($request->correo)){
                $user = User::where('email', $request->correo)->first();
                if($user){
                    return redirect($request->currentURL)->with('error', 'El correo ingresado ya se encuentra registrado en un usuario del sistema.');
                }
            }

            if ($request->hasFile('icono')) {
                $icono = $request->file('icono');
                $nombreIcono = time() . '.' . $icono->getClientOriginalExtension();
                $icono->move(public_path('storage/candidatos'), $nombreIcono);
            } else {
                $nombreIcono = 'default.png';
            }

            Candidatos::create([
                'nombre' => $request->nombre,
                'apellido' => $request->apellido,
                'dni' => $request->dni,
                'direccion' => $request->direccion,
                'fecha_nacimiento' => $request->fecha_nacimiento,
                'ciclo_de_estudiante' => $request->ciclo_de_estudiante,
                'sede_id' => $request->sede_id,
                'carrera_id' => $request->carrera_id,
                'correo' => $request->correo,
                'celular' => $request->celular,
                'icono' => $nombreIcono
            ]);

            DB::commit();
            if($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('candidatos.index');
            }
        }catch(Exception $e) {
            DB::rollBack();
            // return $e;
            if($request->currentURL) {
                return redirect($request->currentURL)->with('error', 'Ocurrió un error al registrar, intente denuevo. Si este error persiste, contacte a su equipo de soporte.');
            } else {
                return redirect()->route('candidatos.index')->with('error', 'Ocurrió un error al registrar, intente denuevo. Si este error persiste, contacte a su equipo de soporte.');
            }
        }
    }

    public function update(Request $request, $candidato_id)
    {
        // return $request;
        $access = FunctionHelperController::verifyAdminAccess();
        if(!$access){
            return redirect()->route('dashboard')->with('error', 'No tiene acceso para ejecutar esta acción. No lo intente denuevo o puede ser baneado.');
        }
        DB::beginTransaction();
        try {
            $returnRoute = route('colaboradores.index');
            if (isset($request->currentURL)) {
                $returnRoute = $request->currentURL;
            }

            $candidato = Candidatos::findOrFail($candidato_id);
            $datosActualizar = $request->except(['icono']);
            $errors = [];

            // Validación de Nombre
            if (!isset($request->nombre) || strlen($request->nombre) > 100) {
                $errors['nombre'.$candidato_id] = !isset($request->nombre)
                    ? 'El nombre es un campo requerido.'
                    : 'El nombre no puede exceder los 100 caracteres.';
            }

            // Validación de Apellido
            if (!isset($request->apellido) || strlen($request->apellido) > 100) {
                $errors['apellido'.$candidato_id] = !isset($request->apellido)
                    ? 'El apellido es un campo requerido.'
                    : 'El apellido no puede exceder los 100 caracteres.';
            }

            // Validación de Ícono
            if ($request->hasFile('icono')) {
                $extensiones = ['jpeg', 'png', 'jpg', 'svg', 'webp'];
                $extensionVal = $request->file('icono')->getClientOriginalExtension();
                if (!in_array($extensionVal, $extensiones)) {
                    $errors['icono'.$candidato_id] = 'El icono debe ser un archivo de tipo: ' . implode(', ', $extensiones);
                }
            }

            // Validación de Dirección
            if (strlen($request->direccion) > 200) {
                $errors['direccion'.$candidato_id] = 'La dirección no puede exceder los 200 caracteres.';
            }

            // Validación de DNI
            if (isset($request->dni) && strlen($request->dni) !== 8) {
                $errors['dni'.$candidato_id] = 'El DNI debe contener 8 caracteres.';
            } else if (isset($request->dni)) {
                $candidatos = Candidatos::where('dni', $request->dni)->get();
                foreach ($candidatos as $cand) {
                    if ($cand->id != $candidato_id) {
                        $errors['dni'.$candidato_id] = 'El DNI ya está en uso.';
                        break;
                    }
                }
            }

            // Validación de Correo
            if (isset($request->correo)) {
                $candidatos = Candidatos::where('correo', $request->correo)->get();
                foreach ($candidatos as $cand) {
                    if ($cand->id != $candidato_id) {
                        $errors['correo'.$candidato_id] = 'El correo ya está en uso.';
                        break;
                    }
                }
            }

            // Validación de Celular
            if (isset($request->celular) && strlen($request->celular) !== 9) {
                $errors['celular'.$candidato_id] = 'El celular debe contener 9 números.';
            } else if (isset($request->celular)) {
                $candidatos = Candidatos::where('celular', $request->celular)->get();
                foreach ($candidatos as $cand) {
                    if ($cand->id != $candidato_id) {
                        $errors['celular'.$candidato_id] = 'El celular ya está en uso.';
                        break;
                    }
                }
            }

            // Si hay errores, redirigir con ellos
            if (!empty($errors)) {
                return redirect($returnRoute)->withErrors($errors)->withInput();
            }

            $usuarioAsociado = null;
            if($candidato->correo != null){
                $user = User::where('email', $candidato->correo)->first();
                if($user){
                    $usuarioAsociado = $user;
                    if(!isset($request->correo)){
                        return redirect($returnRoute)->with('error', 'Debe ingresar el correo para este registro que es un usuario.');
                    } else{
                        if(strlen($request->correo) < 5 || strlen($request->correo) > 100) {
                            return redirect($returnRoute)->with('error', 'El correo debe tener entre 5 y 100 caracteres.');
                        }
                    }
                }
            }
            if(isset($request->correo)){
                if($usuarioAsociado != null) {
                    $sameUser = User::where('email', $request->correo)->whereNot('id', $usuarioAsociado->id)->first();
                } else{
                    $sameUser = User::where('email', $request->correo)->first();
                }
                if($sameUser) {
                    return redirect($returnRoute)->with('error', 'El correo ingresado ya se encuentra registrado en un usuario del sistema.');
                }
            }

            if($usuarioAsociado != null){
                FunctionHelperController::modifyUserByColab($candidato, $request);
            }

            // Manejo de Ícono
            if ($request->hasFile('icono')) {
                $rutaPublica = public_path('storage/candidatos');
                if ($candidato->icono && $candidato->icono !== 'default.png') {
                    unlink($rutaPublica . '/' . $candidato->icono);
                }
                $icono = $request->file('icono');
                $nombreIcono = time() . '.' . $icono->getClientOriginalExtension();
                $icono->move($rutaPublica, $nombreIcono);
                $datosActualizar['icono'] = $nombreIcono;
            }

            // Actualización de Datos
            $candidato->update($datosActualizar);

            DB::commit();
            return redirect($returnRoute);
        } catch (Exception $e) {
            // return $e;
            DB::rollBack();
            return redirect($returnRoute)->with('error', 'Ocurrió un error al actualizar, intente de nuevo. Si este error persiste, contacte a su equipo de soporte.');
        }
    }


    public function rechazarCandidato(Request $request, $candidato_id){
        $access = FunctionHelperController::verifyAdminAccess();
        if(!$access){
            return redirect()->route('dashboard')->with('error', 'No tiene acceso para ejecutar esta acción. No lo intente denuevo o puede ser baneado.');
        }
        DB::beginTransaction();
        try{
            $candidato = Candidatos::findOrFail($candidato_id);
            if($candidato){
                if($candidato->estado == 1){
                    //Estado "2" es igual a rechazado
                    $candidato->update(["estado" => 2]);
                }
            }
            DB::commit();
            if($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('candidatos.index');
            }
        } catch(Exception $e){
            DB::rollBack();
            if($request->currentURL) {
                return redirect($request->currentURL)->with('error', 'Ocurrió un error al rechazar, intente denuevo. Si este error persiste, contacte a su equipo de soporte.');
            } else {
                return redirect()->route('candidatos.index')->with('error', 'Ocurrió un error al rechazar, intente denuevo. Si este error persiste, contacte a su equipo de soporte.');
            }
        }
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


    public function filtrarCandidatos(string $estados = '0,1,2,3', string $carreras = '', string $instituciones = '', string $ciclos = '', string $sedes = '')
    {
        $access = FunctionHelperController::verifyAdminAccess();
        if(!$access){
            return redirect()->route('dashboard')->with('error', 'No tiene acceso para ejecutar esta acción. No lo intente denuevo o puede ser baneado.');
        }
        $ciclos = $ciclos ? explode(',', $ciclos): [];
        $estados = explode(',', $estados);
        $carreras = $carreras ? explode(',', $carreras) : [];
        $instituciones = $instituciones ? explode(',', $instituciones) : [];
        $sedes = $sedes ? explode(',', $sedes) : [];

        $sedesAll = Sede::with('institucion')->orderBy('nombre', 'asc')->get();
        $institucionesAll = Institucion::orderBy('nombre', 'asc')->get();
        $carrerasAll = Carrera::orderBy('nombre', 'asc')->get();
        $ciclosAll = Candidatos::select('ciclo_de_estudiante')->distinct()
            ->orderBy('ciclo_de_estudiante', 'asc')->pluck('ciclo_de_estudiante');

        $sedes = $sedesAll->where('estado', 1);
        $institucionesFiltradas = $institucionesAll->where('estado', 1);
        $carrerasFiltradas = $carrerasAll->where('estado', 1);
        $sedesFiltradas = $sedesAll->where('estado', 1);
        $requestCarreras = empty($carreras) ? $carrerasAll->pluck('id')->toArray() : $carreras;
        $requestInstituciones = empty($instituciones) ? $institucionesAll->pluck('id')->toArray() : $instituciones;

        $sedesId = Sede::whereIn('institucion_id', $requestInstituciones)->get()->pluck('id');
        $requestSedes = empty($sedes) ? $sedesAll->pluck('id')->toArray() : $sedes;
        $candidatos = Candidatos::whereIn('carrera_id', $requestCarreras)
            ->whereIn('sede_id', $sedesId)
            ->whereIn('estado', $estados)
            ->when(!empty($ciclos), function ($query) use ($ciclos) {
                $query->whereIn('ciclo_de_estudiante', $ciclos);
            })
            ->paginate(6);

        $pageData = FunctionHelperController::getPageData($candidatos);
        $hasPagination = true;

        return view('inspiniaViews.candidatos.index', [
            'candidatos' => $candidatos,
            'hasPagination' => $hasPagination,
            'pageData' => $pageData,
            'sedes' => $sedesFiltradas,
            'instituciones' => $institucionesFiltradas,
            'carreras' => $carrerasFiltradas,
            'sedesAll' => $sedesAll,
            'institucionesAll' => $institucionesAll,
            'carrerasAll' => $carrerasAll,
            'ciclosAll' => $ciclosAll,
        ]);
    }

    public function search(string $busqueda = '')
    {
        $access = FunctionHelperController::verifyAdminAccess();
        if(!$access){
            return redirect()->route('dashboard')->with('error', 'No tiene acceso para ejecutar esta acción. No lo intente denuevo o puede ser baneado.');
        }
        //Filtrar por id
        // $candidatosPorDni = Candidatos::with('carrera', 'sede')->where('dni', $busqueda)->paginate(6);

        //Filtrar por nombre y apellido de candidato
        $candidatosPorDni = Candidatos::with('sede', 'carrera')
            ->where(DB::raw("dni"), 'like', '%' . $busqueda . '%')
            ->paginate(6);

        $candidatosPorNombre = Candidatos::with('sede', 'carrera')
            ->where(DB::raw("CONCAT(nombre, ' ', apellido)"), 'like', '%' . $busqueda . '%')
            ->paginate(6);

        //Si existe un registro encontrado por el id
        if ($candidatosPorDni->count() > 0) {
            $candidatos = $candidatosPorDni;
        } else { //Si no existe
            $candidatos = $candidatosPorNombre;
        }

        $sedesAll = Sede::with('institucion')->orderBy('nombre', 'asc')->get();
        $institucionesAll = Institucion::orderBy('nombre', 'asc')->get();
        $carrerasAll = Carrera::orderBy('nombre', 'asc')->get();

        $sedes = $sedesAll->where('estado', 1);
        $instituciones = $institucionesAll->where('estado', 1);
        $carreras = $carrerasAll->where('estado', 1);

        $hasPagination = true;
        $pageData = FunctionHelperController::getPageData($candidatos);

        //return $colaboradoresConArea;

        return view('inspiniaViews.candidatos.index', [
            'candidatos' => $candidatos,
            'hasPagination' => $hasPagination,
            'pageData' => $pageData,
            'sedes' => $sedes,
            'instituciones' => $instituciones,
            'carreras' => $carreras,
            'sedesAll' => $sedesAll,
            'institucionesAll' => $institucionesAll,
            'carrerasAll' => $carrerasAll,
        ]);

    }

    public function reActivate(Request $request, $candidato_id){
        $access = FunctionHelperController::verifyAdminAccess();
        if(!$access){
            return redirect()->route('dashboard')->with('error', 'No tiene acceso para ejecutar esta acción. No lo intente denuevo o puede ser baneado.');
        }
        DB::beginTransaction();
        try{
            $candidato = Candidatos::findOrFail($candidato_id);
            if($candidato && $candidato->estado === 2) {
                $candidato->update(["estado" => 1]);
            }
            DB::commit();
            if($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('candidatos.index');
            }
        } catch(Exception $e){
            DB::rollback();
            if($request->currentURL) {
                return redirect($request->currentURL)->with('error', 'Ocurrió un error al reconsiderar, intente denuevo. Si este error persiste, contacte a su equipo de soporte.');
            } else {
                return redirect()->route('candidatos.index')->with('error', 'Ocurrió un error al reconsiderar, intente denuevo. Si este error persiste, contacte a su equipo de soporte.');
            }
        }
    }

    public function destroy(Request $request, $candidato_id)
    {
        $access = FunctionHelperController::verifyAdminAccess();
        if(!$access){
            return redirect()->route('dashboard')->with('error', 'No tiene acceso para ejecutar esta acción. No lo intente denuevo o puede ser baneado.');
        }
        DB::beginTransaction();
        try{
            $candidato = Candidatos::findOrFail($candidato_id);

            if($candidato && $candidato->estado === 2){
                $colaborador = Colaboradores::where('candidato_id', $candidato_id)->first();
                if($colaborador) {
                    if($request->currentURL) {
                        return redirect($request->currentURL);
                    } else {
                        return redirect()->route('candidatos.index');
                    }
                } else{
                    $candidato->delete();
                }
            }

            DB::commit();

            if($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('candidatos.index');
            }
        } catch(Exception $e) {
            DB::rollBack();
            if($request->currentURL) {
                return redirect($request->currentURL)->with('error', 'Ocurrió un error al eliminar, intente denuevo. Si este error persiste, contacte a su equipo de soporte.');
            } else {
                return redirect()->route('candidatos.index')->with('error', 'Ocurrió un error al eliminar, intente denuevo. Si este error persiste, contacte a su equipo de soporte.');
            }
        }

    }


}
