<?php

namespace App\Http\Controllers;

use App\Models\Maquinas;
use App\Models\Salones;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSalonesRequest;
use App\Http\Requests\UpdateSalonesRequest;
use Illuminate\Support\Facades\DB;
use Exception;

class SalonesController extends Controller
{
    
    public function index()
    {
        try{
            $salones = Salones::get();
    
            foreach($salones as $salon){
                $maquinas = Maquinas::where('salon_id', $salon->id)->get();
                $conteoMaquinas = $maquinas->count();
                $salon->cant_maquinas = $conteoMaquinas;
                $salon->maquinas = $maquinas;
            }
    
            return response()->json(["status" => 200, "salones" => $salones]);
        } catch(Exception $e){
            return response()->json(["status" => 500, "error" => $e->getMessage()]);
        }
    }
    
    // public function create(Request $request)
    // {
    //     Salones::create([
    //         "nombre" => $request->nombre,
    //         "descripcion" => $request->descripcion
    //     ]);

    //     return response()->json(["resp" => "Salón creado"]);
    // }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try{
            //VALIDAR
            //Nombre (requerido, string, maximo 100 caracters)
            if(!isset($request->nombre)){
                return response()->json(["status" => 400,"message" => "El nombre es obligatorio"]);
            }else{
                if(!is_string($request->nombre)){
                    return response()->json(["status" => 400,"message" => "El nombre debe ser una cadena de texto"]);
                }
                if(strlen($request->nombre) > 100){
                    return response()->json(["status" => 400,"message" => "El nombre no debe exceder los 100 caracteres"]);
                }
            }
            //Descripcion (requerido, string, maximo 100 caracters)
            if(!isset($request->descripcion)){
                return response()->json(["status" => 400,"message" => "La descripcion es obligatoria"]);
            }else{
                if(!is_string($request->descripcion)){
                    return response()->json(["status" => 400,"message" => "La descripcion debe ser una cadena de texto"]);
                }
                if(strlen($request->descripcion) > 255){
                    return response()->json(["status" => 400,"message" => "La descripcion no debe exceder los 255 caracteres"]);
                }
            }
    
            Salones::create([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
            ]);
    
            DB::commit();
            return response()->json(["status" => 200, "resp" => "Salón creado exitosamente"]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(["status" => 500, "error" => $e->getMessage()]);
        }

    }

    
    //public function show($salon_id)
    //{
      //  $salon = Salones::find($salon_id);

        //return response()->json(["data" => $salon]);
    //}

    
    public function update(Request $request, $salon_id)
    {
        DB::beginTransaction();
        try{
            //VALIDAR
            //Nombre (requerido, string, maximo 100 caracters)
            if(!isset($request->nombre)){
                return response()->json(["status" => 400,"message" => "El nombre es obligatorio"]);
            }else{
                if(!is_string($request->nombre)){
                    return response()->json(["status" => 400,"message" => "El nombre debe ser una cadena de texto"]);
                }
                if(strlen($request->nombre) > 100){
                    return response()->json(["status" => 400,"message" => "El nombre no debe exceder los 100 caracteres"]);
                }
            }
            //Descripcion (requerido, string, maximo 100 caracters)
            if(!isset($request->descripcion)){
                return response()->json(["status" => 400,"message" => "La descripcion es obligatoria"]);
            }else{
                if(!is_string($request->descripcion)){
                    return response()->json(["status" => 400,"message" => "La descripcion debe ser una cadena de texto"]);
                }
                if(strlen($request->descripcion) > 255){
                    return response()->json(["status" => 400,"message" => "La descripcion no debe exceder los 255 caracteres"]);
                }
            }
            
            $salon = Salones::findOrFail($salon_id);
            if(!$salon){
                return response()->json(["status" => 400,"message" => "No se encontró un salón con ese id"]);
            }
            
            $datosActualizar = $request->all();
            
            $salon->update($datosActualizar);
            DB::commit();
            return response()->json(["status" => 200,"resp" => "Salón actualizado correctamente"]);
        } catch(Exception $e) {
            DB::rollback();
            return response()->json(["status" => 500, "error" => $e->getMessage()]);
        }

    }

    
    public function destroy($salon_id)
    {
        $salon = Salones::findOrFail($salon_id);

        $salon->delete();

        return redirect()->route('salones.index');
    }

    public function activarInactivar(Request $request, $salon_id)
    {
        DB::beginTransaction();
        try{
            $salon = Salones::findOrFail($salon_id);

            if(!$salon){
                return response()->json(["status" => 400,"message" => "No se encontró un salón con ese id"]);
            }
    
            $salon->estado = !$salon->estado;

            if($salon->estado == 1){
                $tipoEstado = 'activado';
            } else{
                $tipoEstado = 'inactivado';
            }
    
            $salon->save();
    
            DB::commit();
            return response()->json(["status" => 200,"resp" => "Salón ".$tipoEstado." correctamente"]);
        } catch(Exception $e) {
            DB::rollback();
            return response()->json(["status" => 500,"error" => $e->getMessage()]);
        }
    }
}
