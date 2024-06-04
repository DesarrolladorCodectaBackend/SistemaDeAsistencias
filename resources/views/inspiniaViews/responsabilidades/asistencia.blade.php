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
                        <a href=""> <b> Responsabilidades - Semanas</b></a>
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
                    <th> Área </th>
                    <th class="area" colspan="8">{{$area->especializacion}}</th>
                </tr>
            </table>
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
                        @foreach($colaboradoresArea as $colaboradorArea)
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
                                        @if($registro->cumplio == true)
                                        ✔️
                                        @else
                                        ❌
                                        @endif
                                    </span>
                                    <input type="number" name="cumplio[]"
                                        value="{{ old('cumplio', $registro->cumplio) }}" style="display: none">

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
                    <thead>
                        <tr>
                            <th> Colaboradores / Responsabilidades </th>
                            @foreach($responsabilidades as $responsabilidad)
                            <td class="respon">{{$responsabilidad->nombre}}</td>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($colaboradoresArea as $colaboradorArea)
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
            $("#semana1").css("display", "unset");
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

</body>

</html>