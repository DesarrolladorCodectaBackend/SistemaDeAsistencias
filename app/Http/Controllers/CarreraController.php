<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCarreraRequest;
use App\Http\Requests\UpdateCarreraRequest;
use Illuminate\Support\Facades\DB;
use Exception;

class CarreraController extends Controller
{

    public function index()
    {
        $carreras = Carrera::get();

        return view('inspiniaViews.carreras.index', compact('carreras'));

    }


    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|min:1|max:100',

        ]);

        Carrera::create([
            'nombre' => $request->nombre,
        ]);




        return redirect()->route('carreras.index');

    }


    public function show($carrera_id)
    {
        $carrera = Carrera::find($carrera_id);

        return response()->json(["data" => $carrera]);
    }


    public function update(Request $request, $carrera_id)
    {
        $request->validate([
            'nombre' => 'sometimes|string|min:1|max:100',
            'estado' => 'sometimes|boolean'
        ]);

        $carrera = Carrera::findOrFail($carrera_id);

        $carrera->update($request->all());

        return redirect()->route('carreras.index');

    }


    public function destroy($carrera_id)
    {
        $carrera = Carrera::findOrFail($carrera_id);

        $carrera->delete();

        return redirect()->route('carreras.index');

    }

    public function activarInactivar($carrera_id)
    {
        $carrera = Carrera::findOrFail($carrera_id);

        $carrera->estado = !$carrera->estado;

        $carrera->save();

        return redirect()->route('carreras.index');
    }

}
