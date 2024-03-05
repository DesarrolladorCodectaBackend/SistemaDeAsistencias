<?php

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

//Route::get('departamentos/get', [DepartamentosController::class, 'mostrarTodo']);



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
