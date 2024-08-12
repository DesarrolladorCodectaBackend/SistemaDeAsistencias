<?php

namespace App\Http\Controllers;

use App\Models\Candidatos;
use App\Models\Colaboradores;
use App\Models\Institucion;
use App\Models\Carrera;
use App\Models\Area;
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
        DB::beginTransaction();
        try{

            if ($request->hasFile('icono')) {
                $icono = $request->file('icono');
                $nombreIcono = time() . '.' . $icono->getClientOriginalExtension();
                $icono->move(public_path('storage/candidatos'), $nombreIcono);
            } else {
                $nombreIcono = 'Default.png';
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
                return redirect($request->currentURL);
            } else {
                return redirect()->route('candidatos.index');
            }
        }
    }

    public function update(UpdateCandidatosRequest $request, $candidato_id)
    {
        DB::beginTransaction();
        try{
            /*$request->validate([
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
                'icono' => 'sometimes|image'
            ]);*/

            $candidato = Candidatos::findOrFail($candidato_id);
            $datosActualizar = $request->except(['icono']);

            if ($request->hasFile('icono')) {
                $rutaPublica = public_path('storage/candidatos');

                // Verificar si el icono actual no es el predeterminado
                if ($candidato->icono && $candidato->icono !== 'default.png') {
                    // Eliminar el icono actual si no es el predeterminado
                    unlink($rutaPublica . '/' . $candidato->icono);
                }

                $icono = $request->file('icono');
                $nombreIcono = time() . '.' . $icono->getClientOriginalExtension();

                $icono->move($rutaPublica, $nombreIcono);

                $datosActualizar['icono'] = $nombreIcono;
            }

            $candidato->update($datosActualizar);

            DB::commit();
            if($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('candidatos.index');
            }
        } catch(Exception $e) {
            DB::rollBack();
            if($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('candidatos.index');
            }
        }
}

    public function rechazarCandidato(Request $request, $candidato_id){
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
                return redirect($request->currentURL);
            } else {
                return redirect()->route('candidatos.index');
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

    /*
    public function old(Request $request)
    {
        $request->validate([
            'estado.*' => 'sometimes',
            'carrera_id.*' => 'sometimes|integer',
            'institucion_id.*' => 'sometimes|integer'
        ]);
        // return $request;

        $sedesAll = Sede::with('institucion')->orderBy('nombre', 'asc')->get();
        $institucionesAll = Institucion::orderBy('nombre', 'asc')->get();
        $carrerasAll = Carrera::orderBy('nombre', 'asc')->get();

        $sedes = $sedesAll->where('estado', 1);
        $instituciones = $institucionesAll->where('estado', 1);
        $carreras = $carrerasAll->where('estado', 1);

        if (!$request->estado) {
            $requestEstados = ["0", "1", "2"];
        } else {
            $requestEstados = $request->estado;
        }
        if (!$request->carrera_id) {
            $requestCarreras = $carreras->pluck('id');
        } else {
            $requestCarreras = $request->carrera_id;
        }
        if (!$request->institucion_id) {
            $requestInstituciones = $instituciones->pluck('id');
        } else {
            $requestInstituciones = $request->institucion_id;
        }

        $sedesId = Sede::whereIn('institucion_id', $requestInstituciones)->get()->pluck('id');

        $candidatos = Candidatos::whereIn('carrera_id', $requestCarreras)->whereIn('sede_id', $sedesId)->whereIn('estado', $requestEstados)->get(); //paginate?

        $hasPagination = false;
        $pageData = [];

        return view('inspiniaViews.candidatos.index', [
            'candidatos' => $candidatos,
            'hasPagination' => $hasPagination,
            'pageData' => $pageData,
            'sedes' => $sedes,
            'instituciones' => $instituciones,
            'carreras' => $carreras,
            'sedesAll' => $sedesAll, //Not using
            'institucionesAll' => $institucionesAll,
            'carrerasAll' => $carrerasAll,
        ]);
    }
    */

    public function filtrarCandidatos(string $estados = '0,1,2,3', string $carreras = '', string $instituciones = '')
    {
        $estados = explode(',', $estados);
        $carreras = $carreras ? explode(',', $carreras) : [];
        $instituciones = $instituciones ? explode(',', $instituciones) : [];

        $sedesAll = Sede::with('institucion')->orderBy('nombre', 'asc')->get();
        $institucionesAll = Institucion::orderBy('nombre', 'asc')->get();
        $carrerasAll = Carrera::orderBy('nombre', 'asc')->get();

        $sedes = $sedesAll->where('estado', 1);
        $institucionesFiltradas = $institucionesAll->where('estado', 1);
        $carrerasFiltradas = $carrerasAll->where('estado', 1);

        $requestCarreras = empty($carreras) ? $carrerasAll->pluck('id')->toArray() : $carreras;
        $requestInstituciones = empty($instituciones) ? $institucionesAll->pluck('id')->toArray() : $instituciones;

        $sedesId = Sede::whereIn('institucion_id', $requestInstituciones)->get()->pluck('id');

        $candidatos = Candidatos::whereIn('carrera_id', $requestCarreras)
            ->whereIn('sede_id', $sedesId)
            ->whereIn('estado', $estados)
            ->paginate(6);

        $pageData = FunctionHelperController::getPageData($candidatos);
        $hasPagination = true;

        return view('inspiniaViews.candidatos.index', [
            'candidatos' => $candidatos,
            'hasPagination' => $hasPagination,
            'pageData' => $pageData,
            'sedes' => $sedes,
            'instituciones' => $institucionesFiltradas,
            'carreras' => $carrerasFiltradas,
            'sedesAll' => $sedesAll,
            'institucionesAll' => $institucionesAll,
            'carrerasAll' => $carrerasAll,
        ]);
    }

    public function search(string $busqueda = '')
    {
        //Filtrar por id
        $candidatoPorId = Candidatos::with('carrera', 'sede')->where('id', $busqueda)->paginate(6);

        //Filtrar por nombre y apellido de candidato
        $candidatosPorNombre = Candidatos::with('sede', 'carrera')
            ->where(DB::raw("CONCAT(nombre, ' ', apellido)"), 'like', '%' . $busqueda . '%')
            ->paginate(6);

        //Si existe un registro encontrado por el id
        if ($candidatoPorId->count() > 0) {
            $candidatos = $candidatoPorId;
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
                return redirect($request->currentURL);
            } else {
                return redirect()->route('candidatos.index');
            }
        }
    }

    public function destroy(Request $request, $candidato_id)
    {
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
                return redirect($request->currentURL);
            } else {
                return redirect()->route('candidatos.index');
            }
        }

    }


}
