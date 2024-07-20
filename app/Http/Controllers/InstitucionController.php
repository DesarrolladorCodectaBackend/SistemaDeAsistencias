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
        $institucion = Institucion::paginate(2);

        $pageData = FunctionHelperController::getPageData($institucion);
        $hasPagination = true;

        // return response()->json(['data' => $institucion]);
        return view('inspiniaViews.institucion.index', [
            'institucion' => $institucion,
            'pageData' => $pageData,
            'hasPagination' => $hasPagination
        ]);

    }


    public function create(Request $request)
    {
        DB::beginTransaction();
        try {

            if (!$request->nombre) {
                return response()->json(["resp" => "Ingrese el nombre de la institucion"]);
            }

            if (!is_string($request->nombre)) {
                return response()->json(["resp" => "El nombre debe ser una cadena de texto"]);
            }

            if (strlen($request->nombre) > 100) {
                return response()->json(["resp" => "El nombre es demasiado largo"]);
            }

            Institucion::create([
                "Nombre" => $request->nombre,
            ]);

            DB::commit();
            return response()->json(["resp" => "Institución creada con nombre " . $request->nombre]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["error" => $e]);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|min:1|max:100',

        ]);

        institucion::create([
            'nombre' => $request->nombre,
        ]);
        
        if($request->currentURL) {
            return redirect($request->currentURL);
        } else {
            return redirect()->route('institucion.index');
        }

    }


    public function show($institucion_id)
    {
        $institucion = Institucion::find($institucion_id);

        return response()->json(["data" => $institucion]);
    }


    public function update(Request $request, $institucion_id)
    {
        $request->validate([
            'nombre' => 'sometimes|string|min:1|max:100',
            'estado' => 'sometimes|boolean'
        ]);

        $institucion = Institucion::findOrFail($institucion_id);

        $institucion->update($request->all());

        if($request->currentURL) {
            return redirect($request->currentURL);
        } else {
            return redirect()->route('institucion.index');
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
        $institucion = Institucion::findOrFail($institucion_id);

        $institucion->estado = !$institucion->estado;

        $institucion->save();

        if($request->currentURL) {
            return redirect($request->currentURL);
        } else {
            return redirect()->route('institucion.index');
        }
    }
}
