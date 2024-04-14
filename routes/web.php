<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\CandidatosController;
use App\Http\Controllers\ColaboradoresController;
use App\Http\Controllers\InstitucionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard-prueba', function () {
    return view('dashboard-prueba');
});

Route::get('/sidebar-inspinia', function () {
    return view('components.inspinia.sidebar-inspinia');
});

Route::get('/navbar-inspinia', function () {
    return view('components.inspinia.navbar-inspinia');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::resource('areas', AreaController::class);
    Route::resource('institucion', InstitucionController::class);
    Route::post('institucion/{institucion}/activar-inactivar', [InstitucionController::class,'activarInactivar'])->name('institucion.activarInactivar');
    Route::resource('candidatos', CandidatosController::class);
    Route::resource('colaboradores', ColaboradoresController::class);

});

require __DIR__ . '/auth.php';
