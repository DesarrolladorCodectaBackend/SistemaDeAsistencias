<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\CandidatosController;
use App\Http\Controllers\CarreraController;
use App\Http\Controllers\ColaboradoresController;
use App\Http\Controllers\Cumplio_Responsabilidad_SemanalController;
use App\Http\Controllers\CursosController;
use App\Http\Controllers\HorarioDeClasesController;
use App\Http\Controllers\InstitucionController;
use App\Http\Controllers\MaquinasController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgramasController;
use App\Http\Controllers\Responsabilidades_SemanalesController;
use App\Http\Controllers\SalonesController;
use App\Models\Cumplio_Responsabilidad_Semanal;
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


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::resource('areas', AreaController::class);
    Route::resource('institucion', InstitucionController::class);
    Route::post('institucion/{institucion}/activar-inactivar', [InstitucionController::class, 'activarInactivar'])->name('institucion.activarInactivar');
    Route::resource('carreras', CarreraController::class);
    Route::post('carreras/{carreras}/activar-inactivar', [CarreraController::class, 'activarInactivar'])->name('carreras.activarInactivar');
    Route::resource('cursos', CursosController::class);
    Route::post('cursos/{cursos}/activar-inactivar', [CursosController::class, 'activarInactivar'])->name('cursos.activarInactivar');
    Route::resource('programas', ProgramasController::class);
    Route::post('programas/{programas}/activar-inactivar', [ProgramasController::class, 'activarInactivar'])->name('programas.activarInactivar');
    Route::resource('salones', SalonesController::class);
    Route::post('salones/{salones}/activar-inactivar', [SalonesController::class, 'activarInactivar'])->name('salones.activarInactivar');
    Route::post('salones/{maquina}/activar-inactivar-maquina', [SalonesController::class, 'activarInactivarMaquina'])->name('salones.activarInactivarMaquina');
    Route::get('/salones/{salon}/maquinas', [SalonesController::class, 'salonMaquinas']);
    Route::resource('maquinas', MaquinasController::class);
    Route::post('maquinas/{maquinas}/activar-inactivar', [MaquinasController::class, 'activarInactivar'])->name('maquinas.activarInactivar');
    Route::resource('candidatos', CandidatosController::class);
    Route::get('/formToColab/{candidato_id}', [CandidatosController::class, 'getFormToColab'])->name('candidatos.form');
    //Route::get('/candidatos/form-candidatos', function () {return view('candidatos.form-candidatos');})->name('candidatos.form');
    Route::resource('colaboradores', ColaboradoresController::class);
    //Route::get('/horarioClase/{colaborador_id}', [ColaboradoresController::class, 'getHorarioClases'])->name('colaboradores.horarioClase');
    Route::post('colaboradores/{colaboradores}/activar-inactivar', [ColaboradoresController::class, 'activarInactivar'])->name('colaboradores.activarInactivar');
    Route::resource('horarioClase', HorarioDeClasesController::class);
    Route::get('/horarioClases/{colaborador_id}', [HorarioDeClasesController::class, 'getCalendariosColaborador'])->name('colaboradores.horarioClase');
    Route::resource('responsabilidades', Cumplio_Responsabilidad_SemanalController::class);
    Route::get('/responsabilidades/meses/{area_id}', [Cumplio_Responsabilidad_SemanalController::class, 'getMesesAreas'])->name('responsabilidades.meses');
    Route::post('/responsabilidades/{mes}', [Cumplio_Responsabilidad_SemanalController::class, 'getFormAsistencias'])->name('responsabilidades.asis');
    Route::put('/responsabilidades/{semana_id}/{area_id}', [Cumplio_Responsabilidad_SemanalController::class, 'actualizar'])->name('responsabilidades.actualizar');

});

require __DIR__ . '/auth.php';
