<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\CandidatosController;
use App\Http\Controllers\CarreraController;
use App\Http\Controllers\ColaboradoresController;
use App\Http\Controllers\ColaboradoresPorAreaController;
use App\Http\Controllers\Computadora_colaboradorController;
use App\Http\Controllers\CursosController;
use App\Http\Controllers\MaquinaReservadaController;
use App\Http\Controllers\HorarioDeClasesController;
use App\Http\Controllers\HorariosPresencialesController;
use App\Http\Controllers\HorariosVirtualesController;
use App\Http\Controllers\HorarioVirtualColaboradorController;
use App\Http\Controllers\MaquinasController;
use App\Http\Controllers\Programas_instaladosController;
use App\Http\Controllers\ProgramasController;
use App\Http\Controllers\Responsabilidades_SemanalesController;
use App\Http\Controllers\SalonesController;
use App\Http\Controllers\DisponibilidadPresencialController;
use App\Http\Controllers\SemanasController;
use App\Models\Salones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InstitucionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/*
------------------------------
        PRIMER ESCALÓN
------------------------------
*/
//INSTITUCIONES 
Route::get('institucion/get', [InstitucionController::class,'index']);
Route::post('institucion/create', [InstitucionController::class,'create']);
Route::get('institucion/show/{institucion_id}', [InstitucionController::class,'show']);
Route::put('institucion/update/{institucion_id}', [InstitucionController::class,'update']);
Route::delete('institucion/delete/{institucion_id}', [InstitucionController::class,'destroy']);

//CARRERAS
Route::get('carrera/get', [CarreraController::class,'index']);
Route::post('carrera/create', [CarreraController::class,'create']);
Route::get('carrera/show/{carrera_id}', [CarreraController::class,'show']);
Route::put('carrera/update/{carrera_id}', [CarreraController::class,'update']);
Route::delete('carrera/delete/{carrera_id}', [CarreraController::class,'destroy']);

//HORARIOS PRESENCIALES
Route::get('horario_presencial/get', [HorariosPresencialesController::class,'index']);
Route::post('horario_presencial/create', [HorariosPresencialesController::class,'create']);
Route::get('horario_presencial/show/{horario_presencial_id}', [HorariosPresencialesController::class,'show']);
Route::put('horario_presencial/update/{horario_presencial_id}', [HorariosPresencialesController::class,'update']);
Route::delete('horario_presencial/delete/{horario_presencial_id}', [HorariosPresencialesController::class,'destroy']);

//HORARIOS VIRTUALES
Route::get('horario_virtual/get', [HorariosVirtualesController::class,'index']);
Route::post('horario_virtual/create', [HorariosVirtualesController::class,'create']);
Route::get('horario_virtual/show/{horario_virtual_id}', [HorariosVirtualesController::class,'show']);
Route::put('horario_virtual/update/{horario_virtual_id}', [HorariosVirtualesController::class,'update']);
Route::delete('horario_virtual/delete/{horario_virtual_id}', [HorariosVirtualesController::class,'destroy']);

//SALONES
Route::get('salon/get', [SalonesController::class,'index']);
Route::post('salon/create', [SalonesController::class,'create']);
Route::get('salon/show/{salon_id}', [SalonesController::class,'show']);
Route::put('salon/update/{salon_id}', [SalonesController::class,'update']);
Route::delete('salon/delete/{salon_id}', [SalonesController::class,'destroy']);

//AREAS
Route::get('area/get', [AreaController::class,'index']);
Route::post('area/create', [AreaController::class,'create']);
Route::get('area/show/{area_id}', [AreaController::class,'show']);
Route::put('area/update/{area_id}', [AreaController::class,'update']);
Route::delete('area/delete/{area_id}', [AreaController::class,'destroy']);

//PROGRAMAS
Route::get('programa/get', [ProgramasController::class,'index']);
Route::post('programa/create', [ProgramasController::class,'create']);
Route::get('programa/show/{programa_id}', [ProgramasController::class,'show']);
Route::put('programa/update/{programa_id}', [ProgramasController::class,'update']);
Route::delete('programa/delete/{programa_id}', [ProgramasController::class,'destroy']);

//SEMANAS
Route::get('semana/get', [SemanasController::class,'index']);
Route::post('semana/create', [SemanasController::class,'create']);
Route::get('semana/show/{semana_id}', [SemanasController::class,'show']);
Route::put('semana/update/{semana_id}', [SemanasController::class,'update']);
Route::delete('semana/delete/{semana_id}', [SemanasController::class,'destroy']);

//RESPONSABILIDADES SEMANALES
Route::get('responsabilidad_semanal/get', [Responsabilidades_SemanalesController::class,'index']);
Route::post('responsabilidad_semanal/create', [Responsabilidades_SemanalesController::class,'create']);
Route::get('responsabilidad_semanal/show/{responsabilidad_semanal_id}', [Responsabilidades_SemanalesController::class,'show']);
Route::put('responsabilidad_semanal/update/{responsabilidad_semanal_id}', [Responsabilidades_SemanalesController::class,'update']);
Route::delete('responsabilidad_semanal/delete/{responsabilidad_semanal_id}', [Responsabilidades_SemanalesController::class,'destroy']);

//CURSOS
Route::get('curso/get', [CursosController::class,'index']);
Route::post('curso/create', [CursosController::class,'create']);
Route::get('curso/show/{curso_id}', [CursosController::class,'show']);
Route::put('curso/update/{curso_id}', [CursosController::class,'update']);
Route::delete('curso/delete/{curso_id}', [CursosController::class,'destroy']);

/*
-------------------------------
        SEGUNDO ESCALÓN
-------------------------------
*/

//CANDIDATOS
Route::get('candidato/get', [CandidatosController::class,'index']);
Route::post('candidato/create', [CandidatosController::class,'create']);
Route::get('candidato/show/{candidato_id}', [CandidatosController::class,'show']);
Route::put('candidato/update/{candidato_id}', [CandidatosController::class,'update']);
Route::delete('candidato/delete/{candidato_id}', [CandidatosController::class,'destroy']);
Route::get('candidato/ShowByName', [CandidatosController::class, 'ShowByName']);

//MAQUINAS
Route::get('maquina/get', [MaquinasController::class,'index']);
Route::post('maquina/create', [MaquinasController::class,'create']);
Route::get('maquina/show/{maquina_id}', [MaquinasController::class,'show']);
Route::put('maquina/update/{maquina_id}', [MaquinasController::class,'update']);
Route::delete('maquina/delete/{maquina_id}', [MaquinasController::class,'destroy']);

/*
------------------------------
        TERCER ESCALÓN
------------------------------
*/

//COLABORADOR
Route::get('colaborador/get', [ColaboradoresController::class,'index']);
Route::post('colaborador/create', [ColaboradoresController::class,'create']);
Route::get('colaborador/show/{colaborador_id}', [ColaboradoresController::class,'show']);
Route::put('colaborador/update/{colaborador_id}', [ColaboradoresController::class,'update']);
Route::delete('colaborador/delete/{colaborador_id}', [ColaboradoresController::class,'destroy']);
Route::get('colaborador/ShowByName', [ColaboradoresController::class, 'ShowByName']);

//MAQUINA RESERVADA  
Route::get('copy_of_maquinas/get', [MaquinaReservadaController::class,'index']);
Route::post('copy_of_maquinas/create', [MaquinaReservadaController::class,'create']);
Route::get('copy_of_maquinas/show/{copy_of_maquinas_id}', [MaquinaReservadaController::class,'show']);
Route::put('copy_of_maquinas/update/{copy_of_maquinas_id}', [MaquinaReservadaController::class,'update']);
Route::delete('copy_of_maquinas/delete/{copy_of_maquinas_id}', [MaquinaReservadaController::class,'destroy']);

/*
------------------------------
        CUARTO ESCALÓN
------------------------------
*/

//DISPONIBILIDAD PRESENCIAL
Route::get('disponibilidad_presencial/get', [DisponibilidadPresencialController::class,'index']);
Route::post('disponibilidad_presencial/create', [DisponibilidadPresencialController::class,'create']);
Route::get('disponibilidad_presencial/show/{disponibilidad_presencial_id}', [DisponibilidadPresencialController::class,'show']);
Route::put('disponibilidad_presencial/update/{disponibilidad_presencial_id}', [DisponibilidadPresencialController::class,'update']);
Route::delete('disponibilidad_presencial/delete/{disponibilidad_presencial_id}', [DisponibilidadPresencialController::class,'destroy']);

//COLABORADORES POR AREA
Route::get('colaborador_por_area/get', [ColaboradoresPorAreaController::class,'index']);
Route::post('colaborador_por_area/create', [ColaboradoresPorAreaController::class,'create']);
Route::get('colaborador_por_area/show/{colaborador_por_area_id}', [ColaboradoresPorAreaController::class,'show']);
Route::put('colaborador_por_area/update/{colaborador_por_area_id}', [ColaboradoresPorAreaController::class,'update']);
Route::delete('colaborador_por_area/delete/{colaborador_por_area_id}', [ColaboradoresPorAreaController::class,'destroy']);

//HORARIO DE CLASES
Route::get('horario_de_clase/get', [HorarioDeClasesController::class,'index']);
Route::post('horario_de_clase/create', [HorarioDeClasesController::class,'create']);
Route::get('horario_de_clase/show/{horario_de_clase_id}', [HorarioDeClasesController::class,'show']);
Route::put('horario_de_clase/update/{horario_de_clase_id}', [HorarioDeClasesController::class,'update']);
Route::delete('horario_de_clase/delete/{horario_de_clase_id}', [HorarioDeClasesController::class,'destroy']);

//HORARIO VIRTUAL COLABORADOR
Route::get('horario_virtual_colaborador/get', [HorarioVirtualColaboradorController::class,'index']);
Route::post('horario_virtual_colaborador/create', [HorarioVirtualColaboradorController::class,'create']);
Route::get('horario_virtual_colaborador/show/{horario_virtual_colaborador_id}', [HorarioVirtualColaboradorController::class,'show']);
Route::put('horario_virtual_colaborador/update/{horario_virtual_colaborador_id}', [HorarioVirtualColaboradorController::class,'update']);
Route::delete('horario_virtual_colaborador/delete/{horario_virtual_colaborador_id}', [HorarioVirtualColaboradorController::class,'destroy']);

//COMPUTADORA COLABORADOR
Route::get('computadora_colaborador/get', [Computadora_colaboradorController::class,'index']);
Route::post('computadora_colaborador/create', [Computadora_colaboradorController::class,'create']);
Route::get('computadora_colaborador/show/{computadora_colaborador_id}', [Computadora_colaboradorController::class,'show']);
Route::put('computadora_colaborador/update/{computadora_colaborador_id}', [Computadora_colaboradorController::class,'update']);
Route::delete('computadora_colaborador/delete/{computadora_colaborador_id}', [Computadora_colaboradorController::class,'destroy']);

/*
------------------------------
        QUINTO ESCALÓN
------------------------------
*/

//PROGRAMAS INSTALADOS
Route::get('programas_instalados/get', [Programas_instaladosController::class,'index']);
Route::post('programas_instalados/create', [Programas_instaladosController::class,'create']);
Route::get('programas_instalados/show/{programas_instalados_id}', [Programas_instaladosController::class,'show']);
Route::put('programas_instalados/update/{programas_instalados_id}', [Programas_instaladosController::class,'update']);
Route::delete('programas_instalados/delete/{programas_instalados_id}', [Programas_instaladosController::class,'destroy']);

//Route::get('departamentos/get', [DepartamentosController::class, 'mostrarTodo']);



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
