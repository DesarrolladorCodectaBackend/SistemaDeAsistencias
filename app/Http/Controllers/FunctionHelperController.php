<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Candidatos;
use App\Models\Colaboradores_por_Area;
use App\Models\ColaboradoresApoyoAreas;
use App\Models\Horario_Presencial_Asignado;
use App\Models\Maquina_reservada;
use App\Models\Semanas;
use App\Models\User;
use App\Models\UsuarioAdministrador;
use App\Models\UsuarioJefeArea;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class FunctionHelperController extends Controller
{
    //USERS
    public static function getUserRol(){
        $user = auth()->user();
        $administrador = UsuarioAdministrador::where('user_id', $user->id)->where('estado', 1)->first();
        $isAdmin = false;
        if($administrador){$isAdmin = true;}
        $jefeArea = UsuarioJefeArea::where('user_id', $user->id)->where('estado', 1)->get();
        $isBoss = false;
        if($jefeArea->count() > 0){$isBoss = true;}
        return [
            "user" => $user,
            "administrador" => $administrador,
            "Jefeareas" => $jefeArea,
            "isAdmin" => $isAdmin,
            "isBoss" => $isBoss,
        ];
    }

    public static function getUserRolById($user_id){
        $user = User::findOrFail($user_id);
        $administrador = UsuarioAdministrador::where('user_id', $user->id)->where('estado', 1)->first();
        $isAdmin = false;
        if($administrador){$isAdmin = true;}
        $jefeArea = UsuarioJefeArea::where('user_id', $user->id)->where('estado', 1)->get();
        $isBoss = false;
        if($jefeArea->count() > 0){$isBoss = true;}
        return [
            "user" => $user,
            "administrador" => $administrador,
            "Jefeareas" => $jefeArea,
            "isAdmin" => $isAdmin,
            "isBoss" => $isBoss,
        ];
    }

    public static function modifyColabByBoss($user, $newData){
        //Encontrar colaborador / Candidato
        $colaborador = Candidatos::where('correo', $user->email)->where('estado', 0)->first();
        $user->update([
            'name'=> $newData['name'],
            'apellido'=> $newData['apellido'],
            'email' => $newData['email']
        ]);
        if($colaborador){
            $colaborador->update([
                'nombre' => $newData['name'],
                'apellido'=> $newData['apellido'],
                'correo' => $newData['email']
            ]);
        }

    }
  

    public static function verifyAreaAccess($area_id){
        $userData = FunctionHelperController::getUserRol();
        if($userData['isAdmin']){
            return true;
        }else if($userData['isBoss']){
            $bossAreasId = $userData['Jefeareas']->pluck('area_id')->toArray();
            if(in_array($area_id, $bossAreasId)){
                return true;
            }else{
                return false;
            }
        } else{
            return false;
        }
    }

    public static function verifyAdminAccess(){
        $userData = FunctionHelperController::getUserRol();
        if($userData['isAdmin']){
            return true;
        } else{
            return false;
        }
    }

    public static function verifySuperAdmin($user_id){
        $SuperAdministrador = UsuarioAdministrador::where('user_id', $user_id)->where('super_admin', 1)->first();
        if($SuperAdministrador){
            return true;
        }else{
            return false;
        }
        
    }

    public static function getAreasJefe($user_id){
        $AreasJefe = UsuarioJefeArea::with('area')->where('user_id', $user_id)->where('estado', 1)->get()->pluck('area');

        return $AreasJefe;
    }


    //COLABORADORES
    public static function colaboradoresConArea($colaboradoresBase){
        $colaboradoresConArea = [];

        foreach ($colaboradoresBase as $colaborador) {
            $colaboradorArea = Colaboradores_por_Area::with('area')->where('colaborador_id', $colaborador->id)->where('estado', true)->get();
            $colaboradorApoyo = ColaboradoresApoyoAreas::with('area')->where('colaborador_id', $colaborador->id)->where('estado', true)->get();
            if (count($colaboradorArea)>0 || count($colaboradorApoyo)>0) {
                $areas = [];

                foreach($colaboradorArea as $colArea){
                    $areas[] = ["nombre" => $colArea->area->especializacion, "tipo" => 0];
                }
                foreach($colaboradorApoyo as $colApoyo){
                    $areas[] = ["nombre"=>$colApoyo->area->especializacion, "tipo" => 1];
                }
                $colaborador->areas = $areas;
            } else {
                $colaborador->areas = [["nombre" => 'Sin área asignada', "tipo" => 2]];
            }
            $colaboradoresConArea[] = $colaborador;
        }
        return $colaboradoresConArea;
    }
    //PAGINATION
    public static function getPageData($collection){
        $pageData = [
            'currentPage' => $collection->currentPage(),
            'currentURL' => $collection->url($collection->currentPage()),
            'lastPage' => $collection->lastPage(),
            'nextPageUrl' => $collection->nextPageUrl(),
            'previousPageUrl' => $collection->previousPageUrl(),
            'lastPageUrl' => $collection->url($collection->lastPage()),
        ];
        $pageData = json_decode(json_encode($pageData));
        return $pageData;
    }

    //TIME

    
    public static function findThisWeek(){
        $thisWeekMonday = Carbon::today()->startOfWeek()->toDateString();
        $thisSemana = Semanas::where('fecha_lunes', $thisWeekMonday)->first();

        return $thisSemana;
    }
    public static function findOrCreateNextWeek(){
        //Encontrar el dia actual
        $today = Carbon::now();
        $monday = $today;
        //Buscar el siguiente lunes
        while (!$today->isMonday()) {
            $today->addDay();
            $monday = $today;                    
        }
        //Buscar semana del siguiente lunes
        $semana = Semanas::where('fecha_lunes', $monday->toDateString())->first();
        if(!$semana){
            $semana = Semanas::create(['fecha_lunes' => $monday->toDateString()]);
        }
        //Retornar semana
        return $semana;
    }

    public static function getYears()
    {
        $TotalSemanas = Semanas::get();
        $Years = [];

        foreach ($TotalSemanas as $semana) {
            $semanaYear = date('Y', strtotime($semana->fecha_lunes));
            if (!in_array($semanaYear, $Years)) {
                $Years[] = $semanaYear;
            }
        }

        return $Years;
    }

    public static function getMonths()
    {
        $Meses = [
            "Enero" => ["nombre" => "Enero", "id" => "01"],
            "Febrero" => ["nombre" => "Febrero", "id" => "02"],
            "Marzo" => ["nombre" => "Marzo", "id" => "03"],
            "Abril" => ["nombre" => "Abril", "id" => "04"],
            "Mayo" => ["nombre" => "Mayo", "id" => "05"],
            "Junio" => ["nombre" => "Junio", "id" => "06"],
            "Julio" => ["nombre" => "Julio", "id" => "07"],
            "Agosto" => ["nombre" => "Agosto", "id" => "08"],
            "Septiembre" => ["nombre" => "Septiembre", "id" => "09"],
            "Octubre" => ["nombre" => "Octubre", "id" => "10"],
            "Noviembre" => ["nombre" => "Noviembre", "id" => "11"],
            "Diciembre" => ["nombre" => "Diciembre", "id" => "12"],
        ];

        return $Meses;
    }

    public static function getDays(){
        $days = [
            "Lunes",
            "Martes",
            "Miércoles",
            "Jueves",
            "Viernes",
            "Sábado",
            "Domingo"
        ];

        return $days;
    }

    /**
     * RETORNA LAS ÁREAS CONCURRENTES
     * REQUIERE DE UN ARRAY DENTRO DE ESTE EL OBJETO AREA QUE ES OBLIGATORIO
     * SE LE PUEDEN ESPECIFICAR SI SE QUIERE REGRESAR LAS ÁREAS INCLUYENDO ESTA Y SI SOLO RETORNAR ÁREAS ACTIVAS O NO
     * POR DEFECTO REGRESA LAS ÁREAS INCLUYENDO ESTA Y TODAS LAS AREAS INDEFERENTEMENTE DE SU ESTADO
     */
    public static function getAreasConcurrentes($array = ["area" => null, "WithThis" => true, "active" => false]){
        //Obtener el área
        // return $array;
        if($array['area'] && $array['area'] != null){
            $area = $array['area'];
            //Obtener los horarios id del área
            $horariosArea = Horario_Presencial_Asignado::where('area_id', $area->id)->get()->pluck('horario_presencial_id');
            //Buscar otras areas con el mismo horario
            $allAreasConcurrentesId = Horario_Presencial_Asignado::with('area')->whereIn('horario_presencial_id', $horariosArea)->get()->pluck('area_id');
            //Buscar todas las áreas con esos Id
            if(isset($array['WithThis'])){
                if($array['WithThis'] == true) {
                    //absolutamente todas las área concurrentes
                    $allAreasConcurrentes = Area::whereIn('id', $allAreasConcurrentesId)->get();
                } else{
                    //Todas las áreas concurrentes menos la que se está buscando
                    $allAreasConcurrentes = Area::whereIn('id', $allAreasConcurrentesId)->whereNot('id', $area->id)->get();
                }
            } else{
                $allAreasConcurrentes = Area::whereIn('id', $allAreasConcurrentesId)->get();
            }
            //Las areas tienen que ser del mismo salón para ser concurrentes
            $allAreasConcurrentesSalon = $allAreasConcurrentes->where('salon_id', $area->salon_id);
            //ver si se quiere que sean activas o no
            if(isset($array['active'])){
                if($array['active'] == true){
                    $allActiveAreasConcurrentes = $allAreasConcurrentesSalon->where('estado', 1);
                    return $allActiveAreasConcurrentes;
                } else{
                    return $allAreasConcurrentesSalon;
                }
            } else{
                return $allAreasConcurrentesSalon;
            }
        }
    }

    public static function destroySameMachines($area_id){
        DB::beginTransaction();
        try{
            $countDestroyed = 0;
            $area = Area::findOrFail($area_id);
            if($area){
                $areasConcurrentesWithoutThis = FunctionHelperController::getAreasConcurrentes(["area" => $area, "WithThis" => false, "active" => true]);
                //Encontrar los colaboradores de este area
                $colaboradoresArea = Colaboradores_por_Area::with('colaborador')->where('area_id', $area->id)->where('estado', 1)->get();
                //Encontrar las maquinas de esta area
                $maquinasReservadas = Maquina_reservada::whereIn('colaborador_area_id', $colaboradoresArea->pluck('id'))->get();
                
                //Encontrar los colaboradores de las áreas concurrentes
                $colaboradoresAreasConcurrentes = Colaboradores_por_Area::with('colaborador')->whereIn('area_id', $areasConcurrentesWithoutThis->pluck('id'))
                    ->where('estado', 1)->get();
                //Encontrar las máquinas de las áreas concurrentes
                $maquinasReservadasAreasConcurrentes = Maquina_reservada::whereIn('colaborador_area_id', $colaboradoresAreasConcurrentes->pluck('id'))->get();
        
                //Recorrer las maquinas de esta area
                foreach($maquinasReservadas as $maquinaReservada) {
                    //Recorrer las maquinas de las otras areas
                    foreach($maquinasReservadasAreasConcurrentes as $maquinaReservadaAreaConcurrente) {
                        //Verificar conflictos con las maquinas de otras areas
                        if($maquinaReservada->maquina_id === $maquinaReservadaAreaConcurrente->maquina_id){
                            //Si hay un choque, se elimina la maquina de esta area
                            $maquinaReservada->delete();
                            $countDestroyed++;
                        }
                        //Si no hay conflictos, no hacer nada
                    }
                }
            }
            DB::commit();
            return response()->json(["destroyed" => $countDestroyed]);
        } catch(Exception $e){
            DB::rollBack();
            return response()->json(["error" => $e->getMessage()]);
        }
    }

}
