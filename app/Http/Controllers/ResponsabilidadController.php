<?php

namespace App\Http\Controllers;

use App\Models\Responsabilidades_semanales;
use Illuminate\Http\Request;

class ResponsabilidadController extends Controller
{
    public function index(){
        $access = FunctionHelperController::verifyAdminAccess();
        if(!$access){
            return redirect()->route('dashboard')->with('error', 'No tiene acceso para ejecutar esta acción. No lo intente denuevo o puede ser baneado.');
        }
        $responsabilidades = Responsabilidades_semanales::paginate(12);

        $pageData = FunctionHelperController::getPageData($responsabilidades);
        $hasPagination = true;
        //return $objetos;

        return view('inspiniaViews.responsabilidades.gestionResponsabilidad', [
            "responsabilidades" => $responsabilidades,
            "pageData" => $pageData,
            "hasPagination" => $hasPagination,
        ]);
    }

    public function store(){

    }

    public function update(){

    }

    public function inactive(){

    }
}
