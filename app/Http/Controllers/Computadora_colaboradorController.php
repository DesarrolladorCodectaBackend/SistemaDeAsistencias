<?php

namespace App\Http\Controllers;

use App\Models\Computadora_colaborador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
class Computadora_colaboradorController extends Controller
{

    public function index()
    {
        $access = FunctionHelperController::verifyAdminAccess();
        if(!$access){
            return redirect()->route('dashboard')->with('error', 'No tiene acceso para ejecutar esta acción. No lo intente denuevo o puede ser baneado.');
        }
        $computadora_colaborador = Computadora_colaborador::all();

        return view('computadora_colaborador.index', compact('computadora_colaborador'));
    }


    public function create(Request $request)
    {
        
        Computadora_colaborador::create([
            "colaborador_id" => $request->colaborador_id,
            "procesador" => $request->procesador,
            "tarjeta_grafica" => $request->tarjeta_grafica,
            "memoria_grafica" => $request->memoria_grafica,
            "ram" => $request->ram,
            "almacenamiento" => $request->almacenamiento,
            "es_laptop" => $request->es_laptop,
            "codigo_serie" => $request->codigo_serie
        ]);

        return response()->json(["resp" => "Registro creado correctamente"]);
    }

    public function store(Request $request)
    {
        // return $request;
        $access = FunctionHelperController::verifyAdminAccess();
        if(!$access){
            return redirect()->route('dashboard')->with('error', 'No tiene acceso para ejecutar esta acción. No lo intente denuevo o puede ser baneado.');
        }
        DB::beginTransaction();
        try{
            $request->validate([
                'colaborador_id' => 'required|integer|min:1|max:100',
                'es_laptop' =>  'required|boolean|min:1|max:255',
                'codigo_serie' =>  'required|string|min:1|max:255',
                'procesador' => 'required|string|min:1|max:255',
                'tarjeta_grafica' =>  'required|string|min:1|max:255',
                'memoria_grafica' =>  'required|string|min:1|max:255',
                'ram' =>  'required|string|min:1|max:255',
                'almacenamiento' =>  'required|string|min:1|max:255',
            ]);


            Computadora_colaborador::create([
                "colaborador_id" => $request->colaborador_id,
                "procesador" => $request->procesador,
                "tarjeta_grafica" => $request->tarjeta_grafica,
                "memoria_grafica" => $request->memoria_grafica,
                "ram" => $request->ram,
                "almacenamiento" => $request->almacenamiento,
                "es_laptop" => $request->es_laptop,
                "codigo_serie" => $request->codigo_serie
            ]);

            DB::commit();
            return redirect()->route('colaboradores.getComputadora', $request->colaborador_id);

        } catch(Exception $e) {
            DB::rollBack();
            return redirect()->route('colaboradores.getComputadora', $request->colaborador_id);
        }


    }



    public function show($computadora_colaborador_id)
    {
        $computadora_colaborador = Computadora_colaborador::with([
            'colaboradores' => function($query) {$query->select('id', 'candidato_id');}])->find($computadora_colaborador_id);

        return response()->json(["data" => $computadora_colaborador]);
    }


    public function update(Request $request, $computadora_colaborador_id)
    {
        $access = FunctionHelperController::verifyAdminAccess();
        if(!$access){
            return redirect()->route('dashboard')->with('error', 'No tiene acceso para ejecutar esta acción. No lo intente denuevo o puede ser baneado.');
        }
        DB::beginTransaction();
        try{
            // return $request;
            $request->validate([
                'colaborador_id' => 'required|integer|min:1|max:100',
                'es_laptop' =>  'required|boolean',
                'codigo_serie' =>  'required|string|min:1|max:255',
                'procesador' => 'required|string|min:1|max:255',
                'tarjeta_grafica' =>  'required|string|min:1|max:255',
                'memoria_grafica' =>  'required|string|min:1|max:255',
                'ram' =>  'required|string|min:1|max:255',
                // 'estado' => 'required|boolean',
                'almacenamiento' =>  'required|string|min:1|max:255',
            ]);
            $estado = false;
            if($request->estado){
                $estado = true;
            } else{
                $estado = false;
            }

            $computadora_colaborador = Computadora_colaborador::findOrFail($computadora_colaborador_id);

            if($computadora_colaborador){
                $computadora_colaborador->update([
                    "procesador" => $request->procesador,
                    "tarjeta_grafica" => $request->tarjeta_grafica,
                    "memoria_grafica" => $request->memoria_grafica,
                    "ram" => $request->ram,
                    "almacenamiento" => $request->almacenamiento,
                    "es_laptop" => $request->es_laptop,
                    "codigo_serie" => $request->codigo_serie,
                    "estado" => $estado
                ]);
            }

            DB::commit();
            return redirect()->route('colaboradores.getComputadora', $request->colaborador_id);
        } catch(Exception $e) {
            DB::rollBack();
            // return response()->json(["error" => $e->getMessage()]);
            return redirect()->route('colaboradores.getComputadora', $request->colaborador_id);
        }

    }


    public function destroy($computadora_colaborador_id)
    {
        $computadora_colaborador = Computadora_colaborador::findOrFail($computadora_colaborador_id);

        $computadora_colaborador->delete();

        return redirect()->route('computadora_colaborador.index');
    }


    public function activarInactivar($colaborador_id, $computadora_id){
        $access = FunctionHelperController::verifyAdminAccess();
        if(!$access){
            return redirect()->route('dashboard')->with('error', 'No tiene acceso para ejecutar esta acción. No lo intente denuevo o puede ser baneado.');
        }
        DB::beginTransaction();
        try{
            $registro = Computadora_colaborador::findOrFail($computadora_id);

            if($registro){
                $registro->update(["estado" => !$registro->estado]);
            }
            DB::commit();
            return redirect()->route('colaboradores.getComputadora', $colaborador_id);
        } catch(Exception $e){
            DB::rollBack();
            return redirect()->route('colaboradores.getComputadora', $colaborador_id);
        }
    }


}
