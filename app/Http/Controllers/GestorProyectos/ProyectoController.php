<?php

namespace App\Http\Controllers\GestorProyectos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProyectoController extends Controller
{
      public function index()
{


    return view('inspiniaViews.proyecto.index');

}

}


