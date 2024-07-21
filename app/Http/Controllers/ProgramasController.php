<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\Programas;
use App\Models\Area;
use Illuminate\Support\Facades\DB;

class ProgramasController extends Controller
{
    public function index()
    {
        $programas = Programas::paginate(12);
        $pageData = FunctionHelperController::getPageData($programas);
        $hasPagination = true;

        return view("inspiniaViews.programas.index", [
            'programas' => $programas,
            'pageData' => $pageData,
            'hasPagination' => $hasPagination,
        ]);
    }

    /*
    public function create(Request $request)
    {
        Programas::create([
            "nombre" => $request->nombre,
            "descripcion" => $request->descripcion,
            "memoria_grafica" => $request->memoria_grafica,
            "ram" => $request->ram
        ]);

        return response()->json(["resp" => "Programa creado"]);
    }
    */

    public function store(Request $request)
    {
        DB::beginTransaction();
        try{

            $request->validate([
                'nombre' => 'required|string|min:1|max:100',
                'descripcion' => 'required|string|min:1|max:255',
                'icono' => 'image'
            ]);
    
            if ($request->hasFile('icono')) {
                $icono = $request->file('icono');
                $nombreIcono = time() . '.' . $icono->getClientOriginalExtension();
                $icono->move(public_path('storage/programas'), $nombreIcono);
            } else {
                $nombreIcono = 'default.png';
            }
    
    
            Programas::create([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'icono' => $nombreIcono
            ]);
    
            DB::commit();
            if($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('programas.index');
            }
        } catch (Exception $e) {
            DB::rollBack();
            if($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('programas.index');
            }
        }
    }


    public function show($programa_id)
    {
        $programa = Programas::find($programa_id);

        return response()->json(["data" => $programa]);
    }


    public function update(Request $request, $programa_id)
    {
        DB::beginTransaction();
        try{

            $request->validate([
                "nombre" => "required|string|min:1|max:255",
                "descripcion" => "sometimes|string|min:1|max:500",
                "icono" => "image"
            ]);
    
            $programa = Programas::findOrFail($programa_id);
    
            $datosActualizar = $request->except(['icono']);
    
            if ($request->hasFile('icono')) {
                $rutaPublica = public_path('storage/programas');
            
                // Verificar si el icono actual no es el predeterminado
                if ($programa->icono && $programa->icono !== "default.png") {
                    // Eliminar el icono actual si no es el predeterminado
                    unlink($rutaPublica . '/' . $programa->icono);
                }
            
                $icono = $request->file('icono');
                $nombreIcono = time() . '.' . $icono->getClientOriginalExtension();
            
                $icono->move($rutaPublica, $nombreIcono);
            
                $datosActualizar['icono'] = $nombreIcono;
            }
    
            $programa->update($datosActualizar);
            DB::commit();
            if($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('programas.index');
            }
        } catch (Exception $e) {
            DB::rollBack();
            if($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('programas.index');
            }
        }
    }



    public function destroy($programa_id)
    {
        $programa = Programas::findOrFail($programa_id);

        $programa->delete();

        return redirect()->route('programas.index');
    }

    public function activarInactivar(Request $request, $programa_id)
    {
        DB::beginTransaction();
        try{
            $programa = Programas::findOrFail($programa_id);
    
            $programa->estado = !$programa->estado;
    
            $programa->save();
            DB::commit();
            if($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('programas.index');
            }
        } catch (Exception $e) {
            DB::rollBack();
            if($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('programas.index');
            }
        }
    }
}
