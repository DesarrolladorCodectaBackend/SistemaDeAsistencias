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
        </style>

        <div>
            <table class="juntar">
                <tr>
                    <th> {{$mes}} </th>
                    <th class="semana" colspan="8">Semana: 1
                        <button onclick="avanzarSemana()">-></button>

                    </th>
                </tr>
                <tr>
                    <th> Área </th>
                    <th class="area" colspan="8">{{$area->especializacion}}</th>
                </tr>
            </table>
            <table id="semana1">
                <form id="cumplioStore1" role="form" method="POST" action="{{ route('responsabilidades.store') }}">
                    @csrf
                    <table id="semana1">
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
                    </table>
                    <button type="submit">Guardar</button>
                </form>
            </table>



            <table id="semana2">
                <thead>
                    <tr>
                        <th> Colaboradores / Responsabilidades </th>
                        @foreach($responsabilidades as $responsabilidad)
                        <td class="respon">{{$responsabilidad->nombre}} </td>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($colaboradoresArea as $colaboradorArea)
                    <tr>
                        <th class="colabo">{{$colaboradorArea->colaborador->candidato->nombre}}
                            {{$colaboradorArea->colaborador->candidato->apellido}}</th>
                        @foreach($responsabilidades as $responsabilidad)
                        <td class="check" onclick="toggleCheck(this)"> </td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="text-center">
                <!--<button onclick="guardarCambios()" class="ladda-button btn btn-primary mr-5"
                    data-style="expand-left">Guardar</button>-->
                <a href="#" class="ladda-button btn btn-primary mr-5"
                    onclick="document.getElementById('cumplioStore1').submit();">Guardar</a>
                <button onclick="descartarCambios()" class="ladda-button btn btn-primary"
                    data-style="expand-left">Descartar</button>
            </div>

            <script>
                var currentWeek = 1;
        
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
                        $("#semana2").css("display", "none");
                        $("#semana1").css("display", "table");
                        actualizarSemana(-1);
                    }
                }
            
                function avanzarSemana() {
                    $("#semana1").css("display", "none");
                    $("#semana2").css("display", "table");
                    actualizarSemana(1);
                }        

            </script>
        </div>










        @include('components.inspinia.footer-inspinia')
    </div>
    </div>

</body>

</html>