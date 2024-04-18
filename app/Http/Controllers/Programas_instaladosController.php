<?php

namespace App\Http\Controllers;

use App\Models\Programas_instalados;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class Programas_instaladosController extends Controller
{

    public function index()
    {
        $programas_instalados = Programas_instalados::all();

        return view('programas_instalados.index', compact('programas_instalados'));

    }


    public function create(Request $request)
    {
        DB::beginTransaction();
        try {
            if(!$request->computadora_id){
                return response()->json(["resp"=> "ingrese computadora"]);
            }

            if(!$request->programa_id){
                return response()->json(["resp" => "ingrese programa"]);
            }

            if (!is_integer($request->computadora_id)){
                return response()->json(["resp"=> "El id de la computadora debe ser un número entero"]);
            }

            if (!is_integer($request->programa_id)){
                return response()->json(["resp"=> "El id del programa debe ser un número entero"]);
            }

            Programas_instalados::create([
                "computadora_id" => $request->computadora_id,
                "programa_id" => $request->programa_id
            ]);
            DB::commit();
            return response()->json(["resp" => "Registro creado correctamente"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["error"=> $e]);
        }

    }

    public function store(Request $request)
    {
        $request->validate([
            'computadora_id' => 'required|integer|min:1|max:100',
            'programa_id' => 'required|integer|min:1|max:255'
        ]);
        
            
        Programas_instalados::create([
            "computadora_id" => $request->computadora_id,
            "programa_id" => $request->programa_id
        ]);

        return redirect()->route('programas_instalados.index');
    }



    public function show($programas_instalados_id)
    {
        try{
            $programas_instalados = Programas_instalados::with([
                'computadora_colaborador' => function ($query) {
                    $query->select(
                        'id',
                        'colaborador_id',
                        'procesador',
                        'tarjeta_grafica',
                        'ram',
                        'almacenamiento',
                        'es_laptop',
                        'codigo_serie'
                    );
                },
                'programas' => function ($query) {
                    $query->select('id', 'nombre', 'descripcion', 'memoria_grafica', 'ram'); }
            ])->find($programas_instalados_id);

            if(!$programas_instalados){
                return response()->json(["resp"=> "No existe un registro con ese id"]);
            }

            return response()->json(["data" => $programas_instalados]);
        } catch (Exception $e) {
            return response()->json(["error"=> $e]);
        }

    }


    public function update(Request $request, $programas_instalados_id)
    {
        $request->validate([
            'computadora_id' => 'required|integer|min:1|max:100',
            'programa_id' => 'required|integer|min:1|max:255',
        ]);

        $programas_instalados = Programas_instalados::findOrFail($programas_instalados_id);
        
        $programas_instalados->update($request->all());

        return redirect()->route('programas_instalados.index');

    }


    public function destroy($programas_instalados_id)
    {
        $programas_instalados = Programas_instalados::findOrFail($programas_instalados_id);

        $programas_instalados->delete();

        return redirect()->route('programas_instalados.index');
    }
}
