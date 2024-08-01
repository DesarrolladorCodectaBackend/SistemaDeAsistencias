<?php

namespace App\Http\Controllers;

use App\Models\Actividades;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Http\Request;

class ActividadesController extends Controller
{
    public function index()
    {
        $actividades = Actividades::get();
        return view('inspiniaViews.actividades.index', ['actividades'=>$actividades]);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'nombre' => 'required|string|min:1|max:100',
            ]);

            Actividades::create([
                'nombre' => $request->nombre,
            ]);

            DB::commit();
                return redirect()->route('actividades.index');
        } catch(Exception $e){
            DB::rollBack();
                return redirect()->route('actividades.index');

        }
    }

    public function update()
    {

    }

    public function activarInactivar()
    {

    }
}
