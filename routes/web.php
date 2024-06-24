<?php

use App\Http\Controllers\AjusteController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\CandidatosController;
use App\Http\Controllers\CarreraController;
use App\Http\Controllers\ColaboradoresController;
use App\Http\Controllers\Cumplio_Responsabilidad_SemanalController;
use App\Http\Controllers\CursosController;
use App\Http\Controllers\Horario_Presencial_AsignadoController;
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

    //AREAS
    Route::resource('areas', AreaController::class);
    Route::get('/areas/horario/{area_id}', [AreaController::class, 'getFormHorarios'])->name('areas.getHorario');
    
    Route::get('/horarioGeneral', [Horario_Presencial_AsignadoController::class, 'index'])->name('horarios.getHorarioGeneral');
    Route::post('/areas/horarioCreate', [Horario_Presencial_AsignadoController::class, 'store'])->name('areas.horarioCreate');
    Route::put('/areas/horarioUpdate/{horario_presencial_asignado_id}', [Horario_Presencial_AsignadoController::class, 'update'])->name('areas.horarioUpdate');

    //INSTITUCION
    Route::resource('institucion', InstitucionController::class);
    Route::post('institucion/{institucion}/activar-inactivar', [InstitucionController::class, 'activarInactivar'])->name('institucion.activarInactivar');

    //CARRERAS
    Route::resource('carreras', CarreraController::class);
    Route::post('carreras/{carreras}/activar-inactivar', [CarreraController::class, 'activarInactivar'])->name('carreras.activarInactivar');

    //CURSOS
    Route::resource('cursos', CursosController::class);
    Route::post('cursos/{cursos}/activar-inactivar', [CursosController::class, 'activarInactivar'])->name('cursos.activarInactivar');

    //PROGRAMAS
    Route::resource('programas', ProgramasController::class);
    Route::post('programas/{programas}/activar-inactivar', [ProgramasController::class, 'activarInactivar'])->name('programas.activarInactivar');

    //SALONES
    Route::resource('salones', SalonesController::class);
    Route::post('salones/{salones}/activar-inactivar', [SalonesController::class, 'activarInactivar'])->name('salones.activarInactivar');
    Route::post('salones/{maquina}/activar-inactivar-maquina', [SalonesController::class, 'activarInactivarMaquina'])->name('salones.activarInactivarMaquina');
    Route::get('/salones/{salon}/maquinas', [SalonesController::class, 'salonMaquinas']);

    //MAQUINAS
    Route::resource('maquinas', MaquinasController::class);
    Route::post('maquinas/{maquinas}/activar-inactivar', [MaquinasController::class, 'activarInactivar'])->name('maquinas.activarInactivar');

    //CANDIDATOS
    Route::resource('candidatos', CandidatosController::class);
    Route::get('/formToColab/{candidato_id}', [CandidatosController::class, 'getFormToColab'])->name('candidatos.form');

    //COLABORADORES
    Route::resource('colaboradores', ColaboradoresController::class);
    Route::post('colaboradores/{colaboradores}/activar-inactivar', [ColaboradoresController::class, 'activarInactivar'])->name('colaboradores.activarInactivar');
    Route::resource('horarioClase', HorarioDeClasesController::class);
    Route::get('/horarioClases/{colaborador_id}', [HorarioDeClasesController::class, 'getCalendariosColaborador'])->name('colaboradores.horarioClase');
    Route::post('colaboradores/filtrar', [ColaboradoresController::class, 'filtrarColaboradores'])->name('colaboradores.filtrar');   
    Route::post('colaboradores/search', [ColaboradoresController::class, 'search'])->name('colaboradores.search');

    //AJUSTES
    Route::resource('ajustes', AjusteController::class);

    //RESPONSABILIDADES
    Route::resource('responsabilidades', Cumplio_Responsabilidad_SemanalController::class);
    Route::get('/responsabilidades/years/{area_id}', [Cumplio_Responsabilidad_SemanalController::class, 'getYearsArea'])->name('responsabilidades.years');
    Route::get('/responsabilidades/{year}/{area_id}', [Cumplio_Responsabilidad_SemanalController::class, 'getMesesAreas'])->name('responsabilidades.meses');
    Route::post('/responsabilidades/evaluacion/{year}/{mes}/{area_id}', [Cumplio_Responsabilidad_SemanalController::class, 'getFormAsistencias'])->name('responsabilidades.asis');
    Route::put('/responsabilidades/{semana_id}/{area_id}', [Cumplio_Responsabilidad_SemanalController::class, 'actualizar'])->name('responsabilidades.actualizar');
    Route::get('/responsabilidades/promedio/{year}/{mes}/{area_id}', [Cumplio_Responsabilidad_SemanalController::class, 'getMonthProm'])->name('responsabilidades.getMonthProm');
    Route::post('/responsabilidades/promedios/{area_id}', [Cumplio_Responsabilidad_SemanalController::class, 'getMonthsProm'])->name('responsabilidades.getMonthsProm');

});

require __DIR__ . '/auth.php';
