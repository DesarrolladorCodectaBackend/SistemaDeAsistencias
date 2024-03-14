<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\CandidatosController;
use App\Http\Controllers\CarreraController;
use App\Http\Controllers\HorariosPresencialesController;
use App\Http\Controllers\HorariosVirtualesController;
use App\Http\Controllers\ProgramasController;
use App\Http\Controllers\SalonesController;
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

//CANDIDATOS
Route::get('candidato/get', [CandidatosController::class,'index']);
Route::post('candidato/create', [CandidatosController::class,'create']);
Route::get('candidato/show/{candidato_id}', [CandidatosController::class,'show']);
Route::put('candidato/update/{candidato_id}', [CandidatosController::class,'update']);
Route::delete('candidato/delete/{candidato_id}', [CandidatosController::class,'destroy']);




//Route::get('departamentos/get', [DepartamentosController::class, 'mostrarTodo']);



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
