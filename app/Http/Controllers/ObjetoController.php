<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Objetos;
use Illuminate\Support\Facades\DB;
use Exception;

class ObjetoController extends Controller
{
    public function index(){
        $objetos = Objetos::paginate(12);

        $pageData = FunctionHelperController::getPageData($objetos);
        $hasPagination = true;
        //return $objetos;

        return view('inspiniaViews.objetos.index', [
            "objetos" => $objetos,
            "pageData" => $pageData,
            "hasPagination" => $hasPagination,
        ]);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'nombre' => 'required|string|min:1|max:100',
                'descripcion' => 'required|string|min:1|max:300',
            ]);

            Objetos::create([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion
            ]);

            DB::commit();
            if($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('objeto.index');
            }
        } catch(Exception $e){
            DB::rollBack();
                if($request->currentURL) {
                    return redirect($request->currentURL);
                } else {
                    return redirect()->route('objeto.index');
                }
        }

    }

    public function update(Request $request, $objeto_id){
        DB::beginTransaction();
        try{
            $request->validate([
                'nombre' => 'sometimes|string|min:1|max:100',
                'descripcion' => 'sometimes|string|min:1|max:300',
                'estado' => 'sometimes|boolean'
            ]);

            $objeto = Objetos::findOrFail($objeto_id);

            $objeto->update($request->all());

            DB::commit();
            if($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('objeto.index');
            }
        } catch(Exception $e) {
            DB::rollBack();
            if($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('objeto.index');
            }
        }
    }

    public function destroy($objeto_id)
    {
        $objeto = Objetos::findOrFail($objeto_id);

        $objeto->delete();

        return redirect()->route('objeto.index');
    }
    
    public function activarInactivar(Request $request, $objeto_id){

        DB::beginTransaction();
        try{
            $objeto = Objetos::findOrFail($objeto_id);

            $objeto->estado = !$objeto->estado;

            $objeto->save();

            DB::commit();
            if($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('objeto.index');
            }
        } catch(Exception $e) {
            DB::rollBack();
            if($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('objeto.index');
            }
        }

    }
}
