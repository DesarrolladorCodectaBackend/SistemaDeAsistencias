<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\InformeSemanal;
use App\Models\Semanas;
use Illuminate\Http\Request;

class InformesSemanalesController extends Controller
{

    public function index()
{
    // Obtener todos los informes semanales
    $informes = InformeSemanal::with(['semana', 'area'])->get();

    // Pasar los datos a la vista
    return view('inspiniaViews.responsabilidades.asistencia', ['informes' => $informes]);
}


}
