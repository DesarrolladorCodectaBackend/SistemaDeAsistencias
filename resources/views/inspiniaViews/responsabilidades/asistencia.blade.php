<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                                <button id="backButton{{$index+1}}" onclick="regresarSemana("
                                    style="margin-right: 30px">←</button>
                                <button id="nextButton{{$index+1}}" onclick="avanzarSemana()">→</button>
                            </div>


                        </th>
                    </tr>
                    <tr>
                        <th> Área</th>
                        <th class="area" colspan="8">{{$area->especializacion}}
                        {{-- Botón ver informe --}}
                        <a class="btn btn-primary btn-success"
                     style="font-size: 20px;"
                     onclick="showModal('modal-form-view-{{$index+1}}')">Ver Informes</a>
                        </th>
                    </tr>
                </table>

               <!-- Modal para la semana actual -->
                <div id="modal-form-view-{{$index+1}}" class="modal" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Informe de Semana {{$index+1}}</h5>

                                <!-- Botón para abrir el modal de creación -->
                                <a data-toggle="modal" class="btn btn-primary btn-success"
                                style="font-size: 20px;"
                                onclick="showModal('modal-create-form-{{$index+1}}')">Crear Informe</a>
                                {{-- <button type="button" class="close" onclick="hideModal('modal-form-view-{{$index+1}}')">&times;</button> --}}

                            </div>

                            <div class="modal-body">
                                <!-- Contenido del modal para la semana {{$index+1}} -->
                                <form id="crud-form-{{$index+1}}">
                                    <input type="hidden" name="semana_id" value="{{$semana->id}}">
                                    @forelse($informesSemanales as $informe)
                                    @empty
                                        <p>No hay informes.</p>
                                    @endforelse
                                </form>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" onclick="hideModal('modal-form-view-{{$index+1}}')">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Modal store -->
                <div id="modal-create-form-{{$index+1}}" class="modal" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Crear Informe de Semana {{$index+1}}</h5>
                                <button type="button" class="close" onclick="hideModal('modal-create-form-{{$index+1}}')">&times;</button>
                            </div>
                            <div class="modal-body">
                                <!-- Contenido del modal para crear un informe -->
                                <form id="create-crud-form-{{$index+1}}" method="POST" action="{{ route('InformeSemanal.store') }}" enctype="multipart/form-data">
                                    @csrf
                                    <!-- Agrega los campos ocultos necesarios -->
                                    <input type="hidden" name="semana_id" value="{{ $semana->id }}">
                                    <input type="hidden" name="area_id" value="{{ $area_id }}">

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
                                        <input type="file" id="informe_url" name="informe_url" class="form- control" required>
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

    <script>
        function showModal(modalId) {
            var modal = document.getElementById(modalId);
            if (modal) {
                modal.style.display = 'block';
            }
        }

        function hideModal(modalId) {
            var modal = document.getElementById(modalId);
            if (modal) {
                modal.style.display = 'none';
            }
        }

        // Opcional: Cierra el modal si se hace clic fuera de él
        window.onclick = function(event) {
            var modals = document.querySelectorAll('.modal');
            modals.forEach(function(modal) {
                if (event.target === modal) {
                    modal.style.display = 'none';
                }
            });
        }
    </script>


</body>

</html>
