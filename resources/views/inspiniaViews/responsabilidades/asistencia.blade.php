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

                      {{-- Modal para la semana actual --}}
<div id="modal-form-{{$index+1}}" class="modal" style="display: none; position: fixed; z-index: 1050; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog" style="margin: 15% auto; width: 80%;">
        <div class="modal-content" style="background-color: #fff; padding: 20px; border-radius: 5px;">
            <div class="modal-header">
                <h5 class="modal-title">Informe de Semana {{$index+1}}</h5>
                {{-- Botón para abrir el modal de creación --}}
                <button
                    id="openModalButton{{ $index+1 }}"
                    class="btn btn-success dim float-right"
                    type="button"
                    onclick="abrirModalCreacion({{ $index+1 }});">
                    Agregar Informe
                </button>
                <button type="button" class="close" onclick="cerrarModal('modal-form-{{$index+1}}')">&times;</button>
            </div>
            <div class="modal-body">
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
                                    {{-- Botón Ver --}}
                                    <button type="button"
                                        id="viewModalButton{{ $informe->id }}"
                                        class="btn btn-sm btn-success float-right mx-2"
                                        onclick="abrirModalVista({{ $informe->id }})">
                                        <i style="font-size: 20px" class="fa fa-eye"></i>
                                    </button>

                                    {{-- Botón Editar --}}
                                    <button
                                        id="editButton{{ $informe->id }}"
                                        class="btn btn-sm btn-info float-right mx-2"
                                        onclick="abrirModalEdicion({{ $informe->id }})">
                                        <i style="font-size: 20px" class="fa fa-paste"></i>
                                    </button>

                                    {{-- Botón Eliminar --}}
                                    <form action="{{ route('InformeSemanal.destroy', $informe->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="semana_id" value="{{ $informe->semana_id }}">
                                        <input type="hidden" name="year" value="{{ $year }}">
                                        <input type="hidden" name="mes" value="{{ $mes }}">
                                        <input type="hidden" name="area_id" value="{{ $informe->area_id }}">
                                        <button type="submit" onclick="return confirm('¿Estás seguro de eliminar este informe?');" class="btn btn-danger">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @endif
                        @empty
                            <p>No hay informes disponibles para esta semana.</p>
                        @endforelse
                </form>
            </div>
        </div>
    </div>
</div>

                        @foreach($informesSemanales as $informe)
                        <!-- Modal de vista -->
                        <div id="modal-form-view-{{ $informe->id }}" class="modal" style="display: none; position: fixed; z-index: 1050; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0, 0, 0, 0.5);">
                            <div class="modal-dialog" style="margin: 10% auto; width: 50%;">
                                <div class="modal-content" style="background-color: #fff; padding: 20px; border-radius: 5px;">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Vista del Informe</h5>
                                        <button type="button" class="close" onclick="cerrarModal('modal-form-view-{{ $informe->id }}')">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <h6>{{ $informe->titulo }}</h6>
                                        <p>{{ $informe->nota_semanal }}</p>
                                        @if($informe->informe_url)
                                            <p><a href="{{ asset('storage/informes/' . $informe->informe_url) }}" target="_blank">Ver archivo</a></p>
                                        @else
                                            <p>No hay archivo disponible.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal de edición -->
                        <div id="modal-form-update-{{ $informe->id }}" class="modal" style="display: none; position: fixed; z-index: 1050; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0, 0, 0, 0.5);">
                            <div class="modal-dialog" style="margin: 10% auto; width: 50%;">
                                <div class="modal-content" style="background-color: #fff; padding: 20px; border-radius: 5px;">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Editar Informe</h5>
                                        <button type="button" class="close" onclick="cerrarModal('modal-form-update-{{ $informe->id }}')">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <form role="form" action="{{ route('InformeSemanal.update', $informe->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="semana_id" value="{{ $informe->semana_id }}">
                                            <input type="hidden" name="year" value="{{ $year }}">
                                            <input type="hidden" name="mes" value="{{ $mes }}">
                                            <input type="hidden" name="area_id" value="{{ $informe->area_id }}">

                                            <div class="form-group">
                                                <label for="titulo">Título</label>
                                                <input type="text" class="form-control" name="titulo" value="{{ $informe->titulo }}">
                                                @error('titulo')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="nota_semanal">Nota Semanal</label>
                                                <textarea class="form-control" name="nota_semanal" rows="3" required>{{ $informe->nota_semanal }}</textarea>
                                                @error('nota_semanal')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="informe_url">Archivo</label>
                                                <input type="file" class="form-control" name="informe_url">
                                                @if($informe->informe_url)
                                                    <p><a href="{{ asset('storage/informes/' . $informe->informe_url) }}" target="_blank">Ver archivo actual</a></p>
                                                @endif
                                                @error('informe_url')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Guardar cambios</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach



                        {{-- MODAL STORE --}}
                        <div id="modal-form-add-{{ $index+1 }}" class="modal fade" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Crear Informe - Semana {{ $index+1 }}</h5>
                                        </div>

                                            <form action="{{ route('InformeSemanal.store') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="form_type" value="create">
                                                <input type="hidden" name="semana_id" value="{{ $semana->id }}">
                                                <input type="hidden" name="year" value="{{ $year }}">
                                                <input type="hidden" name="mes" value="{{ $mes }}">
                                                <input type="hidden" name="area_id" value="{{ $area->id }}">

                                                <div class="form-group">
                                                    <label for="titulo">Título</label>
                                                    <input type="text" class="form-control" id="titulo-{{ $index+1 }}" name="titulo">
                                                    @error('titulo')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="nota_semanal">Nota Semanal</label>
                                                    <textarea class="form-control" id="nota_semanal-{{ $index+1 }}" name="nota_semanal" rows="3" ></textarea>
                                                    @error('nota_semanal')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="informe_url">Archivo</label>
                                                    <input type="file" class="form-control" id="informe_url-{{ $index+1 }}" name="informe_url">
                                                    @error('informe_url')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                                </div>
                                            </form>
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


        {{-- ERRORES MODALS --}}
        @if ($errors->any())
        <script>

            console.log(@json($errors->all())); // Muestra todos los errores en la consola
            document.addEventListener('DOMContentLoaded', function() {
                @if (old('form_type') == 'edit' && old('informe'))
                $('#modal-form-update-' + {{ old('informe') }}).modal('show');
                @endif
            });
        </script>
        @endif
        {{-- scripts modals --}}
        <script>

        function confirmDelete(informeId) {
            ocultarTodosLosModales(); // Ocultar todos los modales antes de mostrar la alerta de confirmación

        alertify.confirm("¿Estás seguro de que deseas eliminar este informe? Esta acción es permanente.", function(e) {
        if (e) {
            // Crear un formulario dinámicamente
            let form = document.createElement('form');

            // Configurar el formulario
            form.method = 'POST';
            form.action = `/InformeSemanal/${informeId}`; // Ruta para eliminar el informe

            // Agregar el token CSRF
            let csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            form.appendChild(csrfToken);

            // Agregar el método DELETE
            let methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'DELETE';
            form.appendChild(methodField);

            // Agregar el formulario al cuerpo del documento y enviarlo
            document.body.appendChild(form);

            // Usar un timeout para evitar problemas de visibilidad
            setTimeout(() => {
                form.submit();
            }, 100);
        } else {
            return false;
        }
    }, function() {
        // Callback para el botón de cancelar (si lo deseas)
        console.log('Cancelado');
    });
}
        </script>




        @include('components.inspinia.footer-inspinia')
    </div>
    </div>

    <script>
        function mostrarModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = 'block';
        }
    }

    function cerrarModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = 'none';
        }
    }

    function abrirModalCreacion(index) {
        mostrarModal('modal-form-add-' + index);
    }

    function abrirModalVista(id) {
        mostrarModal('modal-form-view-' + id);
    }

    function abrirModalEdicion(id) {
        mostrarModal('modal-form-update-' + id);
    }


    </script>




    @if ($errors->any())
    <script>
        $(document).ready(function() {
            // Si hay errores, muestra los mensajes en consola (opcional)
            console.log(@json($errors->all()));

            // Obtener el índice del formulario con errores
            var errorIndex = {{ old('semana_id') ? old('semana_id') : 'null' }};

            // Verificar si el índice es válido
            if (errorIndex !== null) {
                var modalId = '#modal-form-add-' + errorIndex;
                // Mostrar el modal correspondiente
                if ($(modalId).length) {
                    $(modalId).modal('show');
                } else {
                    console.error('El modal no se encuentra en el DOM:', modalId);
                }
            } else {
                console.error('No se pudo determinar el índice del modal.');
            }
        });
    </script>
@endif

</body>
</html>
