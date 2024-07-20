<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Objetos;
use Illuminate\Support\Facades\DB;
use Exception;

class ObjetoController extends Controller
{
    public function index(){
        $objetos = Objetos::paginate(12);

        $pageData = FunctionHelperController::getPageData($objetos);
        $hasPagination = true;
        // return $objetos;

        return view('objetos.index', [
            "objetos" => $objetos,
            "pageData" => $pageData,
            "hasPagination" => $hasPagination,
        ]);


        

    }

    public function store(Request $request){
        DB::beginTransaction();
        try {


            DB::commit();
            if($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('objetos.index');
            }
        } catch(Exception $e){
            DB::rollBack();
            if($request->currentURL) {
                return redirect($request->currentURL);
            } else {
                return redirect()->route('objetos.index');
            }
        }

    }

    public function update(Request $request, $objeto_id){

    }

    public function activarInactivar(Request $request, $objeto_id){

    }
}
