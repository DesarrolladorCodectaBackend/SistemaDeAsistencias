<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Colaboradores;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FiltrosController extends Controller
{
    public function getdata(): View
    {
        $colaboradores = Colaboradores::with(['candidato', 'institucion', 'colaborador_por_area.area'])->get();
        return view('inspiniaViews.filtros.index', ['colaboradores' => $colaboradores]);
    }
}
