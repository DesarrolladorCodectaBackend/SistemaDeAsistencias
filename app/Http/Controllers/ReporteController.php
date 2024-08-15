<?php

namespace App\Http\Controllers;

use App\Models\Colaboradores;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    public function index(){
        $colaboradoresEmpresa = Colaboradores::whereNot('estado', 2)->get();
        $colaboradores = FunctionHelperController::colaboradoresConArea($colaboradoresEmpresa);

        return view('inspiniaViews.reportes.index', [
            "colaboradores" => $colaboradores
        ]);
    }
}
