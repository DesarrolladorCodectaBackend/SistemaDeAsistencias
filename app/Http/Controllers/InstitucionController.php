<?php

namespace App\Http\Controllers;

use App\Models\Institucion;
use Illuminate\Http\Request;
use App\Http\Requests\StoreInstitucionRequest;
use App\Http\Requests\UpdateInstitucionRequest;
use Illuminate\Support\Facades\DB;
use Exception;

class InstitucionController extends Controller
{

    public function index()
    {
        $institucion = Institucion::paginate(12);

        $pageData = FunctionHelperController::getPageData($institucion);
        $hasPagination = true;

        // return response()->json(['data' => $institucion]);
        return view('inspiniaViews.institucion.index', [
            'institucion' => $institucion,
            'pageData' => $pageData,
            'hasPagination' => $hasPagination
        ]);

    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try{
            $request->validate([
                        'nombre' => 'required|string|min:1|max:100',
                    ]);

            institucion::create([
                'nombre' => $request->nombre,
            ]);
            
            DB::commit();
            if($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('institucion.index');
            }
        } catch(Exception $e) {
            DB::rollBack();
            if($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('institucion.index');
            }
        }
    }

    public function update(Request $request, $institucion_id)
    {
        DB::beginTransaction();
        try{
            $request->validate([
                'nombre' => 'sometimes|string|min:1|max:100',
            ]);

            $institucion = Institucion::findOrFail($institucion_id);

            $institucion->update($request->all());

            DB::commit();
            if($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('institucion.index');
            }
        } catch(Exception $e) {
            DB::rollBack();
            if($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('institucion.index');
            }
        }

    }


    public function destroy($institucion_id)
    {
        $institucion = Institucion::findOrFail($institucion_id);

        $institucion->delete();

        return redirect()->route('institucion.index');

    }

    public function activarInactivar(Request $request,$institucion_id)
    {
        DB::beginTransaction();
        try{
            $institucion = Institucion::findOrFail($institucion_id);

            $institucion->estado = !$institucion->estado;

            $institucion->save();

            DB::commit();
            if($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('institucion.index');
            }
        } catch(Exception $e) {
            DB::rollBack();
            if($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('institucion.index');
            }
        }
    }
    
}
