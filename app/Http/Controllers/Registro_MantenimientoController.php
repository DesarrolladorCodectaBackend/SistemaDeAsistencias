<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registro_Mantenimiento;
use Illuminate\Support\Facades\DB;
use Exception;

class Registro_MantenimientoController extends Controller
{
    public function index()
    {
        $registro_mantenimiento = Registro_Mantenimiento::all();

        return view('inspiniaViews.registro_mantenimiento.index', compact('registro_mantenimiento'));

    }


    public function create(Request $request)
    {
        DB::beginTransaction();
        try {
            if(!$request->computadora_id){
                return response()->json(["resp"=> "ingrese computadora"]);
            }

            if(!$request->fecha){
                return response()->json(["resp" => "ingrese programa"]);
            }

            if(!$request->registro_incidencia){
                return response()->json(["resp" => "ingrese programa"]);
            }

            if (!is_integer($request->computadora_id)){
                return response()->json(["resp"=> "El id de la computadora debe ser un número entero"]);
            }

            if (!is_string($request->fecha)){
                return response()->json(["resp"=> "La fecha debe ser escrita como cadena de texto"]);
            }

            if (!is_string($request->registro_incidencia)){
                return response()->json(["resp"=> "El registro incidencia debe ser escrito como cadena de texto"]);
            }

            Registro_Mantenimiento::create([
                "computadora_id" => $request->computadora_id,
                "fecha" => $request->fecha,
                "registro_incidencia" => $request->registro_incidencia
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
            'horario_presencial_id' => 'required|string|min:1|max:100',
            'fecha' => 'required|datetime|min:1|max:255',
            'registro_incidencia' => 'required|datetime|min:1|max:255'
        ]);

        Registro_Mantenimiento::create([
            "horario_presencial_id" => $request->horario_presencial_id,
            "fecha" => $request->fecha,
            "registro_incidencia" => $request->registro_incidencia

        ]);

        return redirect()->route('inspiniaViews.registro_mantenimiento.index');

    }


    public function show($registro_mantenimiento_id)
    {
        try{
            $registro_mantenimiento = Registro_Mantenimiento::/*with([
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
            ])->*/find($registro_mantenimiento_id);

            if(!$registro_mantenimiento){
                return response()->json(["resp"=> "No existe un registro con ese id"]);
            }

            return response()->json(["data" => $registro_mantenimiento]);
        } catch (Exception $e) {
            return response()->json(["error"=> $e]);
        }

    }


    public function update(Request $request, $registro_mantenimiento_id)
    {
        $request->validate([
            'horario_presencial_id' => 'required|string|min:1|max:100',
            'fecha' => 'required|datetime|min:1|max:255',
            'registro_incidencia' => 'required|datetime|min:1|max:255'
        ]);

        $registro_Mantenimiento = Registro_Mantenimiento::findOrFail($registro_mantenimiento_id);

        $registro_Mantenimiento->update($request->all());

        return redirect()->route('inspiniaViews.registro_Mantenimiento.index');

    }


    public function destroy($registro_mantenimiento_id)
    {
        $registro_Mantenimiento = Registro_Mantenimiento::findOrFail($registro_mantenimiento_id);

        $registro_Mantenimiento->delete();

        return redirect()->route('inspiniaViews.registro_Mantenimiento.index');

    }
}
