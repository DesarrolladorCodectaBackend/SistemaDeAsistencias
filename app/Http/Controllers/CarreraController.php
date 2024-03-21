<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCarreraRequest;
use App\Http\Requests\UpdateCarreraRequest;

class CarreraController extends Controller
{

    public function index()
    {
        $carreras = Carrera::get();
        return response()->json(["data" => $carreras, "conteo" => count($carreras)]);
    }


    public function create(Request $request)
    {
        Carrera::create([
            "nombre" => $request->nombre
        ]);
        return response()->json(["resp" => "Carrera creada con nombre " . $request->nombre]);
    }


    public function show($carrera_id)
    {
        $carrera = Carrera::find($carrera_id);

        return response()->json(["data" => $carrera]);
    }


    public function update(Request $request, $carrera_id)
    {
        $carrera = Carrera::find($carrera_id);

        $carrera->fill([
            "nombre" => $request->nombre
        ])->save();

        return response()->json(["resp" => "Carrera con id " . $carrera_id . " fue editada"]);
    }


    public function destroy($carrera_id)
    {
        $carrera = Carrera::find($carrera_id);

        $carrera->delete();

        return response()->json(["resp" => "Carrera con id " . $carrera_id . " y nombre " . $carrera->nombre . " ha sido eliminada."]);
    }

}
