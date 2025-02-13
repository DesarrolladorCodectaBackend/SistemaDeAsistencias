<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LibroController extends Controller
{
    public function index() {

        $libros = Libro::get();

        $cantidadLib = $libros->count();

        return view('inspiniaViews.libros.index',[
            'libros' => $libros,
            'cantidadLib' => $cantidadLib
        ]
    );
    }

    public function store(Request $request) {
        DB::beginTransaction();
        try {

            Libro::create([
                'titulo' => $request->titulo,
                'autor' => $request->autor,
                'estado' => 1
            ]);

            DB::commit();
            return redirect()->route('libro.index');

        }catch (Exception $e) {
            
            // return $e;
            DB::rollback();
            return redirect()->route('libro.index');

        }
    }

    public function update(Request $request, $libro_id) {
        DB::beginTransaction();
        try {

            $libro = Libro::findOrFail($libro_id);

            $libro->update([
                'titulo' => $request->titulo,
                'autor' => $request->autor
            ]);

            DB::commit();
            return redirect()->route('libro.index');

        }catch (Exception $e){

            DB::rollback();
            return redirect()->route('libro.index');

        }
    }

    // public function activeInactive(Request $request, $libro_id) {
    //     DB::beginTransaction();
    //     try {

    //         $libro = Libro::findOrFail($libro_id);

    //         $libro->estado = !$libro->estado;
    //         $libro->save();

    //         DB::commit();
    //         return redirect()->route('libro.index');

    //     }catch (Exception $e){

    //         DB::rollback();
    //         return redirect()->route('libro.index');

    //     }
    // }
}
