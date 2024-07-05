<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>INSPINIA | Form - Candidatos</title>
</head>

<body>
    <div id="wrapper">
        @include('components.inspinia.side_nav_bar-inspinia')

        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-10">
                <h2>Dashboards</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.html">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="#">Personal</a>
                    </li>
                    <li class="breadcrumb-item active">
                        <strong>Colaboradores</strong>
                    </li>
                </ol>
            </div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                        <div class="ibox-content">
                            <h2><strong>Informacion</strong></h2>
                            <form role="form" method="POST" action="{{ route('colaboradores.store') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group"><label>Nombres</label> <input type="text"
                                                placeholder="Ingrese su nombre"
                                                value="{{ $candidato->nombre }} {{ $candidato->apellido }}"
                                                class="form-control" disabled></div>
                                        <div class="form-group"><label>DNI</label> <input type="text"
                                                placeholder="Ingrese su DNI" value="{{ $candidato->dni }}"
                                                class="form-control" disabled></div>
                                        <div class="form-group"><label class="col-form-label">Carrera</label><input
                                                type="text" value="{{ $candidato->carrera->nombre }}"
                                                class="form-control" disabled>
                                        </div>

                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group"><label>Correo</label> <input type="email"
                                                placeholder="Ingrese su correo" value="{{ $candidato->correo }}"
                                                class="form-control" disabled></div>
                                        <div class="form-group"><label>Telefono</label> <input type="text"
                                                placeholder="Ingrese su telefono" value="{{ $candidato->celular }}"
                                                class="form-control" disabled></div>
                                        <div class="form-group"><label class="col-form-label">Area</label>
                                            <div>
                                                <select name="areas_id[]" multiple required
                                                    class="form-control multiple_areas_select">
                                                    @foreach ($areas as $key => $area)+
                                                    <option value="{{ $area->id }}">
                                                        {{ $area->especializacion }}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="ibox">
                                        <div class="ibox-title">
                                            <h5>Tabla</h5>
                                            <div class="ibox-tools">
                                                <button class="btn btn-primary" type="button" href="#modal-form-edit"
                                                    onclick="agregarFila()" data-toggle="modal"><i
                                                        class="fa fa-plus-circle"></i></button>
                                            </div>
                                        </div>
                                        <div class="ibox-content">

                                            <table id="tablaHorarios" class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Dia</th>
                                                        <th>Hora Inicial</th>
                                                        <th>Hora Final</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <div class="form-group row"><label
                                                                    class="col-form-label"></label>

                                                                <div class="col-sm-10"><select class="form-control m-b"
                                                                        name="horarios[0][dia]">
                                                                        <option>Lunes</option>
                                                                        <option>Martes</option>
                                                                        <option>Miércoles</option>
                                                                        <option>Jueves</option>
                                                                        <option>Viernes</option>
                                                                        <option>Sabado</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="input-group date">
                                                                <span class="input-group-addon"><i
                                                                        class="fa fa-calendar"></i></span>
                                                                <!--
                                                                <input type="time" class="form-control"
                                                                    name="horarios[0][hora_inicial]" value="00:00"> -->
                                                                <select class="form-control"
                                                                    name="horarios[0][hora_inicial]" id="">
                                                                    @foreach($horas as $key => $hora)
                                                                    <option value="{{ $hora }}">{{ $hora }}</option>

                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="input-group date">
                                                                <span class="input-group-addon"><i
                                                                        class="fa fa-calendar"></i></span>
                                                                <!--
                                                                <input type="time" class="form-control"
                                                                    name="horarios[0][hora_final]" value="00:00"> -->
                                                                <select class="form-control"
                                                                    name="horarios[0][hora_final]" id="">
                                                                    @foreach($horas as $key => $hora)
                                                                    <option value="{{ $hora }}">{{ $hora }}</option>

                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-danger float-right" type="button"
                                                                onclick="eliminarFila(this)"><i
                                                                    class="fa fa-trash-o"></i></button>
                                                        </td>
                                                    </tr>
                                                    <!---Div-->
                                                </tbody>

                                            </table>
                                            <input type="number" class="form-control-file" id="candidato_id"
                                                name="candidato_id" value="{{ $candidato->id }}" style="display: none;">

                                            <div class="text-center">
                                                <button class="ladda-button btn btn-primary mr-5" type="submit"
                                                    data-style="expand-left">Guardar</button>
                                                <a class="ladda-button btn btn-primary" data-style="expand-left"
                                                    href="/candidatos">Cancelar</a>
                                            </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    </div>


    @include('components.inspinia.footer-inspinia')


    </div>
    </div>
    <!--
    <script>
        var contadorFilas = 0;
        function agregarFila() {
            var tabla = document.getElementById("tablaHorarios").getElementsByTagName('tbody')[0];
            var nuevaFila = tabla.insertRow(tabla.rows.length);
    
            // Insertar celdas en la nueva fila
            var celdaDia = nuevaFila.insertCell(0);
            var celdaHoraInicial = nuevaFila.insertCell(1);
            var celdaHoraFinal = nuevaFila.insertCell(2);
            var celdaBotonEliminar = nuevaFila.insertCell(3);

            contadorFilas++;
    
            celdaDia.innerHTML = '<div class="form-group row"><label class="col-form-label"></label><div class="col-sm-10"><select class="form-control m-b" name="horarios[' + contadorFilas + '][dia]"><option>Lunes</option><option>Martes</option><option>Miércoles</option><option>Jueves</option><option>Viernes</option><option>Sabado</option></select></div></div>';
            celdaHoraInicial.innerHTML = '<div class="input-group date"><span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="time" class="form-control" name="horarios[' + contadorFilas + '][hora_inicial]" value="00:00"></div>';
            celdaHoraFinal.innerHTML = '<div class="input-group date"><span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="time" class="form-control" name="horarios[' + contadorFilas + '][hora_final]" value="00:00"></div>';
            celdaBotonEliminar.innerHTML = '<button class="btn btn-danger float-right" type="button" onclick="eliminarFila(this)"><i class="fa fa-trash-o"></i></button>';
        }
    
        function eliminarFila(boton) {
            var fila = boton.parentNode.parentNode;
            fila.parentNode.removeChild(fila);
        }
    </script> -->

    <style type="text/css">
        [required] {
            box-shadow: 0 0 10px 1px #f00;
        }
    </style>

    <script>
        //JQuery para select multiple de areas
        $(document).ready(function() {
            $('.multiple_areas_select').select2();
        });
    </script>

    <script>
        var contadorFilas = 0;
        var horas = @json($horas);
    
        function agregarFila() {
            var tabla = document.getElementById("tablaHorarios").getElementsByTagName('tbody')[0];
            var nuevaFila = tabla.insertRow(tabla.rows.length);
    
            // Insertar celdas en la nueva fila
            var celdaDia = nuevaFila.insertCell(0);
            var celdaHoraInicial = nuevaFila.insertCell(1);
            var celdaHoraFinal = nuevaFila.insertCell(2);
            var celdaBotonEliminar = nuevaFila.insertCell(3);
    
            contadorFilas++;
    
            // Construir el select de horas iniciales y finales
            var selectHoraInicial = construirSelectHora('horarios[' + contadorFilas + '][hora_inicial]');
            var selectHoraFinal = construirSelectHora('horarios[' + contadorFilas + '][hora_final]');
            
            celdaDia.innerHTML = '<div class="form-group row"><label class="col-form-label"></label><div class="col-sm-10"><select class="form-control m-b" name="horarios[' + contadorFilas + '][dia]"><option>Lunes</option><option>Martes</option><option>Miércoles</option><option>Jueves</option><option>Viernes</option><option>Sabado</option></select></div></div>';
            celdaHoraInicial.innerHTML = '<div class="input-group date"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>' + selectHoraInicial + '</div>';
            celdaHoraFinal.innerHTML = '<div class="input-group date"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>' + selectHoraFinal + '</div>';
            celdaBotonEliminar.innerHTML = '<button class="btn btn-danger float-right" type="button" onclick="eliminarFila(this)"><i class="fa fa-trash-o"></i></button>';
        }
    
        function construirSelectHora(name) {
            var select = '<select class="form-control" name="' + name + '">';
            for (var i = 0; i < horas.length; i++) {
                select += '<option value="' + horas[i] + '">' + horas[i] + '</option>';
            }
            select += '</select>';
            return select;
        }
    
        function eliminarFila(boton) {
            var fila = boton.parentNode.parentNode;
            fila.parentNode.removeChild(fila);
        }
    </script>

</body>

</html>