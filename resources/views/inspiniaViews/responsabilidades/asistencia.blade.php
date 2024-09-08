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
                        data-target="#modal-form-{{$index+1}}">
                        </a>


                        </th>
                    </tr>
                </table>

                      <!-- Modal para la semana actual -->
                        <div id="modal-form-{{$index+1}}" class="modal" style="display: none;">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Informe de Semana {{$index+1}}</h5>
                                        <!-- Botón para abrir el modal de creación -->
                                        <button class="btn btn-success dim float-right"
                                                data-toggle="modal"
                                                data-target="#modal-form-add-{{ $index+1 }}"
                                                type="button">Agregar Informe
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Contenido del historial de informes para la semana {{$index+1}} -->
                                        <form id="crud-form-{{$index+1}}">
                                            <input type="hidden" name="semana_id" value="{{$semana->id}}">
                                            @forelse($informesSemanales as $informe)
                                                @if($informe->semana_id == $semana->id)  <!-- Solo muestra los informes de la semana actual -->
                                                    <div class="informe-item d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <h6>{{ $informe->titulo }}</h6>
                                                            <p>{{ $informe->nota_semanal }}</p>
                                                            @if($informe->informe_url)
                                                                <p><a href="{{ asset('storage/informes/' . $informe->informe_url) }}" target="_blank">Ver archivo</a></p>
                                                            @else
                                                                <p>No hay archivo disponible.</p>
                                                            @endif
                                                        </div>
                                                        <div>
                                                            <button type="button" class="btn btn-info mr-2 fa fa-eye"></button>

                                                            <button type="button" class="btn btn-warning mr-2 fa fa-edit" onclick="showModal('modal-update-form-{{ $informe->id }}')"></button>


                                                            <button type="button" class="btn btn-danger fa fa-trash"></button>
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
                                        <button type="button" class="btn btn-secondary" onclick="hideModal('modal-form-{{$index+1}}')">Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>




                       
                        <!-- Modal para crear un nuevo informe -->
                        <div id="modal-form-add-{{ $index+1 }}" class="modal fade" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Crear Informe - Semana {{ $index+1 }}</h5>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('InformeSemanal.store') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="semana_id" value="{{ $semana->id }}">
                                            <input type="hidden" name="year" value="{{ $year }}">
                                            <input type="hidden" name="mes" value="{{ $mes }}">
                                            <input type="hidden" name="area_id" value="{{ $area->id }}">
                    
                                            <div class="form-group">
                                                <label for="titulo">Título</label>
                                                <input type="text" class="form-control" id="titulo-{{ $index+1 }}" name="titulo" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="nota_semanal">Nota Semanal</label>
                                                <textarea class="form-control" id="nota_semanal-{{ $index+1 }}" name="nota_semanal" rows="3" required></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="informe_url">Archivo</label>
                                                <input type="file" class="form-control" id="informe_url-{{ $index+1 }}" name="informe_url">
                                            </div>
                    
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Guardar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                    


                    <!-- Modal para editar informe -->
                    <div id="modal-update-form-{{ $informe->id }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Editar Informe</h5>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
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
        function showModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
            modal.classList.add('show');
            modal.style.display = 'block'; // Asegúrate de que el modal se muestre
            }
        }

        function hideModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('show');
                modal.style.display = 'none'; // Asegúrate de que el modal se oculte
            }
        }

        function abrirModalCreacion(index) {
    ocultarTodosLosModales();
    showModal('modal-form-add-' + index);
}



        function abrirModalEdicion(id) {
            hideModal('modal-form-view' + id);
            showModal('modal-form-update' + id);
        }
    </scritp>
</body>
</html>
