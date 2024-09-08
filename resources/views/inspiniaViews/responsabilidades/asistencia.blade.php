<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>INSPINIA | ASISTENCIA</title>
</head>

<body>
    <div id="wrapper">
        @include('components.inspinia.side_nav_bar-inspinia')
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-10">
                <h2>Responsabilidades</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="/dashboard">Home</a>
                    </li>
                    <li class="breadcrumb-item active">
                        <strong>Responsabilidades - Semanas</strong>
                    </li>
                </ol>
            </div>

        </div>
        <style>
            .juntar {
                margin-bottom: 0px;
            }

            table {
                margin: 0 auto;
                width: 80%;
                border-collapse: collapse;
                background-color: #ffffff;
                margin-bottom: 20px;
            }

            tr {
                width: 100%;
            }

            th,
            td {
                border: 1px solid #ddd;
                padding: 18px;
                text-align: center;
            }

            th {
                background-color: #4E7BBF;
                color: rgb(255, 255, 255);
                padding: 15px;
            }

            .semana {
                background-color: #4E7BBF;
                position: relative;
            }

            .semana button {
                position: absolute;
                right: 10px;
                top: 50%;
                transform: translateY(-50%);
                background-color: antiquewhite;
            }

            .area {
                background-color: #78EA91;
                color: #000000;
            }

            .colabo {
                background-color: #eaeaeb;
                color: #000000;
            }

            .check,
            .x {
                cursor: pointer;
            }

            .respon {
                background-color: #A0D6F4;
                color: #000000;
                padding: 10px;
            }

            #semana2 {
                display: none;
            }

            .semanaactiva {
                display: block;
            }

            .regre {
                position: absolute;
                left: 10px;
                background-color: antiquewhite;
            }

            .disabled {
                pointer-events: none;
                opacity: 0.75;
                /* Cambia la opacidad para simular el efecto de deshabilitar */
            }
        </style>


        @foreach($semanasMes as $index => $semana)
            <section id="semana{{$index+1}}" style="display: none">
                <table class="juntar">
                    <tr>
                        <th> {{$mes}} </th>
                        <th class="semana" colspan="8">Semana: {{$index+1}}
                            <div>
                                <button id="backButton{{$index+1}}" onclick="regresarSemana()"
                                    style="margin-right: 30px">←</button>
                                <button id="nextButton{{$index+1}}" onclick="avanzarSemana()">→</button>
                            </div>


                        </th>
                    </tr>
                    <tr>
                        <th> Área</th>
                        <th class="area" colspan="8">{{$area->especializacion}}
                        {{-- Botón ver informes --}}
                        <a class="btn btn-primary btn-success btn-md float-right fa fa-file-o"
                        style="font-size: 20px;"
                        data-toggle="modal" 
                        data-target="#modal-show-form-{{$index+1}}">
                        </a>
                        </th>
                    </tr>
                </table>

                        <!-- Modal para la semana actual -->
<div id="modal-show-form-{{$index+1}}" class="modal hidden">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Informe de Semana {{$index+1}}</h5>
                <!-- Botón para cerrar el modal -->
                <button type="button" class="close" onclick="hideModal('modal-show-form-{{$index+1}}')">&times;</button>
            </div>

            <div class="modal-body">
                <!-- Contenido del historial de informes para la semana {{$index+1}} -->
                <form id="crud-form-{{$index+1}}">
                    <input type="hidden" name="semana_id" value="{{$semana->id}}">

                    @forelse($informesSemanales as $informe)
                        @if($informe->semana_id == $semana->id)
                            <div class="informe-item d-flex justify-content-between align-items-center">
                                <div>
                                    <h6>{{ $informe->titulo }}</h6>
                                    <p>{{ $informe->nota_semanal }}</p>
                                    @if($informe->informe_url)
                                        <p><a href="{{ asset('storage/informes/' . $informe->informe_url) }}" target="_blank">Ver archivo</a></p>
                                    @else
                                        <p>No hay archivo disponible</p>
                                    @endif
                                </div>
                                <div>
                                    <!-- Ver informe respectivo -->
                                    <button type="button" class="btn btn-info mr-2 fa fa-eye" onclick="abrirModalVisualizacion({{$informe->id}}, {{$index+1}})"></button>

                                    <!-- Editar informe respectivo -->
                                    <a data-toggle="modal" id="editButton{{ $informe->id }}"
                                        class="btn btn-warning mr-2 fa fa-edit"
                                        onclick="abrirModalEdicion({{ $informe->id }});"
                                        style="font-size: 20px; width: 60px;"
                                        href="#modal-edit-form-{{ $informe->id }}"></a>

                                    <!-- Eliminar informe respectivo -->
                                    <button type="button" class="btn btn-danger mr-2 fa fa-trash" onclick="confirmDelete({{$informe->id}}, '{{ url()->current() }}')"></button>
                                </div>
                            </div>
                            <hr>
                        @endif
                    @empty
                        <p>No hay informes registrados para esta semana.</p>
                    @endforelse
                </form>
            </div>

            <div class="modal-footer">
                <!-- Botón para crear un nuevo informe -->
                <button type="button" class="btn btn-success" onclick="abrirModalCreacion({{$index+1}})">Crear Informe</button>
                <!-- Botón para cerrar el modal -->
            </div>
        </div>
    </div>
</div>



               <!-- Modal para crear informe -->
<div id="modal-create-form-{{$index+1}}" class="modal hidden">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Crear Informe de Semana {{$index+1}}</h5>
                <button type="button" class="close" onclick="hideModal('modal-create-form-{{$index+1}}')">&times;</button>
            </div>
            <div class="modal-body">
                <form id="create-crud-form-{{$index+1}}" method="POST"
                      action="{{ route('InformeSemanal.store')}}"
                      enctype="multipart/form-data">
                    @csrf
                    <!-- Campos ocultos para la semana, área, año y mes -->
                    <input type="hidden" name="semana_id" value="{{ $semana->id }}">
                    <input type="hidden" name="area_id" value="{{ $area->id }}">
                    <input type="hidden" name="year" value="{{ $year}}">
                    <input type="hidden" name="mes" value="{{ $mes }}">

                    <!-- Campos del formulario -->
                    <div class="form-group">
                        <label for="titulo">Título:</label>
                        <input type="text" id="titulo" name="titulo" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="nota_semanal">Nota Semanal:</label>
                        <textarea id="nota_semanal" name="nota_semanal" class="form-control" rows="4" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="informe_url">Archivo:</label>
                        <input type="file" id="informe_url" name="informe_url" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="hideModal('modal-create-form-{{$index+1}}')">Cerrar</button>
            </div>
        </div>
    </div>
</div>




           <!-- Modal para editar informe -->
<div id="modal-edit-form-{{ $informe->id }}" class="modal hidden">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Informe</h5>
                <button type="button" class="close" onclick="hideModal('modal-edit-form-{{ $informe->id }}')">&times;</button>
            </div>
            <form action="{{ route('InformeSemanal.update', $informe->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" name="semana_id" value="{{ $informe->semana_id }}">
                    <input type="hidden" name="year" value="{{ $year }}">
                    <input type="hidden" name="mes" value="{{ $mes }}">
                    <input type="hidden" name="area_id" value="{{ $area->id }}">
                    <input type="hidden" name="informe" value="{{ $informe->id }}">

                    <div class="form-group">
                        <label for="titulo">Título</label>
                        <input type="text" class="form-control" id="titulo" name="titulo" value="{{ $informe->titulo }}" required>
                    </div>
                    <div class="form-group">
                        <label for="nota_semanal">Nota Semanal</label>
                        <textarea class="form-control" id="nota_semanal" name="nota_semanal" rows="3" required>{{ $informe->nota_semanal }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="informe_url">Archivo</label>
                        <input type="file" class="form-control" id="informe_url" name="informe_url">
                        @if($informe->informe_url)
                            <p><a href="{{ asset('storage/informes/' . $informe->informe_url) }}" target="_blank">Ver archivo actual</a></p>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="hideModal('modal-edit-form-{{ $informe->id }}')">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>






                @if($semana->cumplido == true)
                <table id="table-semana-cumplida{{$index+1}}" class="disabled">
                    <form id="cumplioUpdate{{$index+1}}" role="form" method="POST"
                        action="{{ route('responsabilidades.actualizar', ['semana_id' => $semana->id, 'area_id' => $area->id]) }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="year" value="{{$year}}">
                        <input type="hidden" name="mes" value="{{$mes}}">
                        <thead>
                            <tr>
                                <th> Colaboradores / Responsabilidades </th>
                                @foreach($responsabilidades as $responsabilidad)
                                <td class="respon">{{$responsabilidad->nombre}}</td>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($semana->colaboradores as $colaboradorArea)
                            <tr>
                                <th class="colabo">
                                    {{$colaboradorArea->colaborador->candidato->nombre}}
                                    {{$colaboradorArea->colaborador->candidato->apellido}}
                                    <input type="number" name="colaborador_area_id[]" value="{{$colaboradorArea->id}}"
                                        style="display: none">
                                    <input type="number" name="semana_id" value="{{$semana->id}}" style="display: none">
                                </th>
                                @foreach($responsabilidades as $responsabilidad)

                                <?php
                                    $registro = $registros->where('colaborador_area_id', $colaboradorArea->id)
                                                        ->where('responsabilidad_id', $responsabilidad->id)
                                                        ->where('semana_id', $semana->id)
                                                        ->first();
                                ?>
                                <input type="number" name="responsabilidad_id[]" value="{{$responsabilidad->id}}"
                                    style="display: none">
                                <td class="check" onclick="toggleCheck(this)">
                                    <div>
                                        <span>
                                            @isset($registro->cumplio)
                                            @if($registro->cumplio == true)
                                            ✔️
                                            @else
                                            ❌
                                            @endif
                                            @endisset
                                        </span>
                                        @isset($registro->cumplio)
                                        <input type="number" name="cumplio[]"
                                            value="{{ old('cumplio', $registro->cumplio) }}" style="display: none">
                                        @else
                                        <input type="number" name="cumplio[]" style="display: none">
                                        @endisset

                                    </div>
                                </td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </form>
                </table>
                <div class="text-center">
                    <button onclick="habilitarEdicion({{$index+1}})"
                        class="ladda-button btn btn-success mr-2">Editar</button>
                    <a href="#" id="BtnGuardar{{$index+1}}" class="ladda-button btn btn-primary mr-2 disabled"
                        onclick="document.getElementById('cumplioUpdate{{$index+1}}').submit();" disabled>Guardar</a>
                    <button onclick="descartarCambios()" class="ladda-button btn btn-warning"
                        data-style="expand-left">Descartar</button>
                </div>
                <script>
                    function habilitarEdicion(index) {
                        let tabla = document.getElementById(`table-semana-cumplida${index}`);
                        let botonGuardar = document.getElementById(`BtnGuardar${index}`);

                        tabla.classList.remove('disabled');
                        botonGuardar.classList.remove('disabled');
                    }
                </script>
                @else
                <table id="table-semana{{$index+1}}">
                    <form id="cumplioStore{{$index+1}}" role="form" method="POST"
                        action="{{ route('responsabilidades.store') }}">
                        @csrf
                        <input type="hidden" name="year" value="{{$year}}">
                        <input type="hidden" name="mes" value="{{$mes}}">
                        <input type="hidden" name="area_id" value="{{$area->id}}">
                        <thead>
                            <tr>
                                <th> Colaboradores / Responsabilidades </th>
                                @foreach($responsabilidades as $responsabilidad)
                                <td class="respon">{{$responsabilidad->nombre}}</td>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($semana->colaboradores as $colaboradorArea)
                            <tr>
                                <th class="colabo">
                                    {{$colaboradorArea->colaborador->candidato->nombre}}
                                    {{$colaboradorArea->colaborador->candidato->apellido}}
                                    <input type="number" name="colaborador_area_id[]" value="{{$colaboradorArea->id}}"
                                        style="display: none">
                                    <input type="number" name="semana_id" value="{{$semana->id}}" style="display: none">
                                </th>
                                @foreach($responsabilidades as $responsabilidad)
                                <input type="number" name="responsabilidad_id[]" value="{{$responsabilidad->id}}"
                                    style="display: none">
                                <td class="check" onclick="toggleCheck(this)">
                                    <div>
                                        <span></span>
                                        <input type="number" name="cumplio[]" value="0" style="display: none">
                                    </div>
                                </td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </form>
                </table>
                <div class="text-center">
                    <a href="#" class="ladda-button btn btn-primary mr-5"
                        onclick="document.getElementById('cumplioStore{{$index+1}}').submit();">Guardar</a>
                    <button onclick="descartarCambios()" class="ladda-button btn btn-warning"
                        data-style="expand-left">Descartar</button>
                </div>
                @endif

            </section>

        @endforeach

        <script>
            var currentWeek = 1;
            var totalWeeks = {{ count($semanasMes) }};
            $("#semana"+currentWeek).css("display", "unset");
            updateNavigationButtons();

                function toggleCheck(cell) {
                    var span = cell.querySelector('div span');
                    var input = cell.querySelector('div input');
                    if (span.textContent === '✔️') {
                        span.textContent = '❌';
                        input.setAttribute('value', '0');
                    } else {
                        span.textContent = '✔️';
                        input.setAttribute('value', '1');
                    }
                }
                function actualizarSemana(offset) {
                    currentWeek += offset;
                    var semanaTitulo = document.querySelector('.semana');
                    semanaTitulo.textContent = "Semana: " + currentWeek;

                    var checkCells = document.querySelectorAll('.check');
                    checkCells.forEach(function(cell) {
                        cell.textContent = '';
                    });
                    var backButton = document.getElementById('backButton');
                    var nextButton = document.getElementById('nextButton');

                    if (currentWeek === 1) {
                        backButton.style.display = 'none';
                        nextButton.style.display = 'inline-block';
                    } else if (currentWeek === 2) {
                        backButton.style.display = 'inline-block';
                        nextButton.style.display = 'none';
                    } else {
                        backButton.style.display = 'inline-block';
                        nextButton.style.display = 'none';
                    }
                }
                function regresarSemana() {
                    if (currentWeek > 1) {
                        $(`#semana${currentWeek}`).css("display", "none");
                        currentWeek--;
                        $(`#semana${currentWeek}`).css("display", "unset");
                        updateNavigationButtons();
                    }
                }

                function avanzarSemana() {
                    if (currentWeek < totalWeeks) {
                        $(`#semana${currentWeek}`).css("display", "none");
                        currentWeek++;
                        $(`#semana${currentWeek}`).css("display", "unset");
                        updateNavigationButtons();
                    }
                }

                function descartarCambios() {
                    location.reload();
                }

                function updateNavigationButtons() {
                    for (var i = 1; i <= totalWeeks; i++) {
                        var backButton = $(`#backButton${i}`);
                        var nextButton = $(`#nextButton${i}`);

                        backButton.show();
                        nextButton.show();

                        if (currentWeek === 1) {
                            backButton.prop('disabled', true);
                        } else {
                            backButton.prop('disabled', false);
                        }

                        if (currentWeek === totalWeeks) {
                            nextButton.prop('disabled', true);
                        } else {
                            nextButton.prop('disabled', false);
                        }
                    }
                }

        </script>


        @include('components.inspinia.footer-inspinia')
    </div>
    </div>


    {{-- scripts modals --}}
    <script>
/// Función para ocultar el modal
function hideModal(modalId) {
    console.log('Ocultando modal con ID: ' + modalId);
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'none'; // Oculta el modal
        // También ocultar el backdrop si existe
        const backdrop = document.querySelector('.modal-backdrop');
        if (backdrop) {
            backdrop.remove();
        }
    }
}

// Función para mostrar el modal
function showModal(modalId) {
    // Primero ocultar todos los modales para asegurarnos de que solo uno esté visible
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
        modal.style.display = 'none';
    });
    
    // Mostrar el modal deseado
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'block';

        // Añadir el backdrop
        const existingBackdrop = document.querySelector('.modal-backdrop');
        if (!existingBackdrop) {
            const backdrop = document.createElement('div');
            backdrop.className = 'modal-backdrop';
            document.body.appendChild(backdrop);
        }
    }
}

// Función para abrir el modal de creación
function abrirModalCreacion(index) {
    hideModal('modal-show-form-' + index);
    hideModal('modal-edit-form-' + index);
    showModal('modal-create-form-' + index);
}

// Función para abrir el modal de visualización
function abrirModalVisualizacion(informeId, index) {
    hideModal('modal-show-form-' + index);
    hideModal('modal-create-form-' + index);
    showModal('modal-visualize-form-' + informeId);
}

// Función para abrir el modal de edición
function abrirModalEdicion(informeId) {
    hideModal('modal-show-form-' + index);
    hideModal('modal-create-form-' + index);
    showModal('modal-edit-form-' + informeId);
}

// Función para confirmar eliminación
function confirmDelete(informeId, url) {
    if (confirm('¿Estás seguro de que deseas eliminar este informe?')) {
        fetch(url + '/' + informeId, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('informe-' + informeId).remove();
            } else {
                alert('No se pudo eliminar el informe.');
            }
        })
        .catch(error => console.error('Error:', error));
    }
}


    </script>
    
    
    
    


</body>

</html>
