<?php

use App\Http\Controllers\AjusteController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\CandidatosController;
use App\Http\Controllers\CarreraController;
use App\Http\Controllers\ColaboradoresController;
use App\Http\Controllers\Computadora_colaboradorController;
use App\Http\Controllers\Cumplio_Responsabilidad_SemanalController;
use App\Http\Controllers\CursosController;
use App\Http\Controllers\Horario_Presencial_AsignadoController;
use App\Http\Controllers\HorarioDeClasesController;
use App\Http\Controllers\InstitucionController;
use App\Http\Controllers\MaquinasController;
use App\Http\Controllers\ObjetoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Programas_instaladosController;
use App\Http\Controllers\ProgramasController;
use App\Http\Controllers\Registro_MantenimientoController;
use App\Http\Controllers\SedeController;
use App\Http\Controllers\Responsabilidades_SemanalesController;
use App\Http\Controllers\SalonesController;
use App\Http\Controllers\Reuniones_ProgramadasController;
use App\Http\Controllers\MaquinaReservadaController;
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
    
    //Horarios (Area)
    Route::get('/areas/horario/{area_id}', [AreaController::class, 'getFormHorarios'])->name('areas.getHorario');
    Route::get('/horarioGeneral', [Horario_Presencial_AsignadoController::class, 'index'])->name('horarios.getHorarioGeneral');
    Route::post('/areas/horarioCreate', [Horario_Presencial_AsignadoController::class, 'store'])->name('areas.horarioCreate');
    Route::put('/areas/horarioUpdate/{horario_presencial_asignado_id}', [Horario_Presencial_AsignadoController::class, 'update'])->name('areas.horarioUpdate');
    Route::delete('/areas/horarioDelete/{area_id}/{horario_presencial_asignado_id}', [Horario_Presencial_AsignadoController::class, 'destroy'])->name('areas.horarioDelete');
    
    //Reuniones (Area)
    Route::get('/ReunionesAreas', [Reuniones_ProgramadasController::class, 'getAllReu'])->name('reuniones.getAll');
    Route::get('/areas/reuniones/{area_id}', [Reuniones_ProgramadasController::class, 'reunionesGest'])->name('areas.getReuniones');
    Route::post('/areas/reunionCreate', [Reuniones_ProgramadasController::class, 'store'])->name('areas.reunionCreate');
    Route::put('/areas/reunionUpdate/{id}', [Reuniones_ProgramadasController::class, 'update'])->name('areas.reunionUpdate');
    Route::delete('/areas/reunionDelete/{id}', [Reuniones_ProgramadasController::class, 'destroy']);

    //Maquina Reservada
    Route::get('/area/maquinas/{area_id}', [AreaController::class, 'getMaquinasByArea'])->name('areas.getMaquinas');
    Route::post('/area/maquinas/AsignarColab/{area_id}/{maquina_id}', [MaquinaReservadaController::class, 'asignarColaborador'])->name('areas.asignarMaquinaColab');
    Route::delete('/area/maquinas/LiberarMaquina/{area_id}/{maquina_id}', [MaquinaReservadaController::class, 'liberarMaquina'])->name('areas.liberarMaquina');

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

    //MAQUINAS
    Route::resource('maquinas', MaquinasController::class);
    Route::post('maquinas/{maquinas}/activar-inactivar', [MaquinasController::class, 'activarInactivar'])->name('maquinas.activarInactivar');
    
    //SEDES
    Route::resource('sedes', SedeController::class);
    Route::post('sedes/activar-inactivar/{sede_id}', [SedeController::class, 'activarInactivar'])->name('sedes.activarInactivar');


    //OBJETOS
    Route::resource('objetos', ObjetoController::class);

    //CANDIDATOS
    Route::resource('candidatos', CandidatosController::class);
    Route::get('/formToColab/{candidato_id}', [CandidatosController::class, 'getFormToColab'])->name('candidatos.form');
    Route::post('candidato/rechazarCandidato/{candidato_id}', [CandidatosController::class, 'rechazarCandidato'])->name('candidatos.rechazarCandidato');
    // Route::post('candidatos/filtrar', [CandidatosController::class, 'filtrarCandidatos'])->name('candidatos.filtrar');
    // Route::get('candidatos/filtrar', [CandidatosController::class, 'filtrarCandidatos'])->name('candidatos.filtrar');
    Route::get('candidatos/filtrar/estados={estados}/carreras={carreras?}/instituciones={instituciones?}', [CandidatosController::class, 'filtrarCandidatos'])
        ->where(['estados' => '[0-9,]+','carreras' => '[0-9,]*','instituciones' => '[0-9,]*'])->name('candidatos.filtrar');
    Route::get('candidatos/search/{busqueda}', [CandidatosController::class, 'search'])->name('candidatos.search');
    
    
    
    //COLABORADORES
    Route::resource('colaboradores', ColaboradoresController::class);
    Route::post('colaboradores/activar-inactivar/{colaborador_id}', [ColaboradoresController::class, 'activarInactivar'])->name('colaboradores.activarInactivar');
    Route::get('colaboradores/filtrar/estados={estados}/areas={areas?}/carreras={carreras?}/instituciones={instituciones?}', [ColaboradoresController::class, 'filtrarColaboradores'])
    ->where(['estados' => '[0-9,]+','areas' => '[0-9,]*','carreras' => '[0-9,]*','instituciones' => '[0-9,]*'])->name('colaboradores.filtrar');
    Route::get('colaboradores/search/{busqueda}', [ColaboradoresController::class, 'search'])->name('colaboradores.search');
    // Route::post('colaboradores/filtrar', [ColaboradoresController::class, 'filtrarColaboradores'])->name('colaboradores.filtrar');
    // Route::post('colaboradores/search', [ColaboradoresController::class, 'search'])->name('colaboradores.search');
    
    //HORARIO DE CLASES
    Route::resource('horarioClase', HorarioDeClasesController::class);
    Route::get('/horarioClases/{colaborador_id}', [HorarioDeClasesController::class, 'getCalendariosColaborador'])->name('colaboradores.horarioClase');

    //COMPUTADORA
    Route::get('/colaborador/computadora/{colaborador_id}', [ColaboradoresController::class, 'getComputadoraColaborador'])->name('colaboradores.getComputadora');
    Route::post('/computadora/storeComputadoraColab', [Computadora_colaboradorController::class, 'store'])->name('computadora.storeComputadoraColab');
    Route::put('/computadora/updateComputadoraColab/{computadora_colaborador_id}', [Computadora_colaboradorController::class, 'update'])->name('computadora.updateComputadoraColab');
    Route::put('/computadora/activarInactivar/{colaborador_id}/{computadora_id}', [Computadora_colaboradorController::class, 'activarInactivar'])->name('computadora.activarInactivar');

    //REGISTRO MANTENIMIENTO
    Route::post('/computadora/mantenimientoStore', [Registro_MantenimientoController::class, 'store'])->name('computadora.mantenimientoStore');
    Route::put('/computadora/mantenimientoInactivar/{colaborador_id}/{registro_Mantenimiento_id}', [Registro_MantenimientoController::class, 'inactivar'])->name('computadora.mantenimientoInactivar');

    //PROGRAMAS INSTALADOS
    Route::post('/computadora/programasInstalados/selectProgramas/{computadora_id}', [Programas_instaladosController::class, 'selectProgramas'])->name('computadora.selectProgramas');
    Route::put('/computadora/programasInstalados/Inactivate/{colaborador_id}/{id}', [Programas_instaladosController::class, 'inactivate'])->name('computadora.ProgramaInactivate');

    //AJUSTES
    Route::resource('ajustes', AjusteController::class);

    //RESPONSABILIDADES
    Route::resource('responsabilidades', Cumplio_Responsabilidad_SemanalController::class);
    Route::put('/responsabilidades/{semana_id}/{area_id}', [Cumplio_Responsabilidad_SemanalController::class, 'actualizar'])->name('responsabilidades.actualizar');
    Route::get('/responsabilidades/years/{area_id}', [Cumplio_Responsabilidad_SemanalController::class, 'getYearsArea'])->name('responsabilidades.years');
    Route::get('/responsabilidades/{year}/{area_id}', [Cumplio_Responsabilidad_SemanalController::class, 'getMesesAreas'])->name('responsabilidades.meses');
    Route::get('/responsabilidades/evaluacion/{year}/{mes}/{area_id}', [Cumplio_Responsabilidad_SemanalController::class, 'getFormAsistencias'])->name('responsabilidades.asis');
    Route::get('/responsabilidades/promedio/{year}/{mes}/{area_id}', [Cumplio_Responsabilidad_SemanalController::class, 'getMonthProm'])->name('responsabilidades.getMonthProm');
    Route::post('/responsabilidades/promedios/{area_id}', [Cumplio_Responsabilidad_SemanalController::class, 'getMonthsProm'])->name('responsabilidades.getMonthsProm');

});

require __DIR__ . '/auth.php';
