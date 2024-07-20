<?php

namespace App\Http\Controllers;

use App\Models\Candidatos;
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
        $sedes = Sede::with('institucion')->where('estado', true)->orderBy('nombre', 'asc')->get();
        $carreras = Carrera::all();
        $pageData = FunctionHelperController::getPageData($candidatos);
        $hasPagination = true;
        // return $pageData;
        return view('inspiniaViews.candidatos.index', [
            'candidatos' => $candidatos,
            'hasPagination' => $hasPagination,
            'pageData' => $pageData,
            'sedes' => $sedes,
            'carreras' => $carreras
        ]);
    }

    public function getFormToColab($candidato_id)
    {
        $candidato = Candidatos::findOrFail($candidato_id);
        $areas = Area::get();
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

    public function store(Request $request)
    {
        DB::beginTransaction();
        try{
            $request->validate([
                'nombre' => 'required|string|min:1|max:100',
                'apellido' => 'required|string|min:1|max:100',
                'dni' => 'required|string|min:1|max:8',
                'direccion' => 'required|string|min:1|max:100',
                'fecha_nacimiento' => 'required|string|min:1|max:255',
                'ciclo_de_estudiante' => 'required|string|min:1|max:50',
                'sede_id' => 'required|integer|min:1|max:20',
                'carrera_id' => 'required|integer|min:1|max:20',
                'correo' => 'required|string|min:1|max:255',
                'celular' => 'required|string|min:1|max:20',
                'icono' => 'image'
            ]);
    
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
        } catch(Exception $e) {
            DB::rollBack();
            // return $e;
            if($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('candidatos.index');
            }
        }
        

    }

    public function update(Request $request, $candidato_id)
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
                'icono' => 'sometimes|image'
            ]);

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
