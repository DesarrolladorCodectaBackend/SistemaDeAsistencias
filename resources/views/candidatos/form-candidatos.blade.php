<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>INSPINIA | Form - Candidatos</title>
    <link href="../../../public/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../../public/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="../../../public/css/animate.css" rel="stylesheet">
    <link href="../../../public/css/style.css" rel="stylesheet">
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
                            <div class="row">
                                <div class="col-sm-6">
                                    <form role="form" method="POST" action="{{ route('colaboradores.store') }}">
                                        @csrf
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
                                    <!--
                                    <div class="form-group"><label class="col-form-label">Area</label>

                                        <div><select class="form-control m-b" name="account">
                                            <option>Programacion</option>
                                            <option>Analisis</option>
                                            <option>Planeacion</option>
                                            <option>Diseño</option>
                                            <option>Arquitectura</option>
                                            <option>Android</option>
                                            <option>Inteligencia Artificial</option>
                                            <option>Programacion Web</option>
                                            <option>Videojuegos</option>
                                        </select>
                                        </div>
                                    </div -->
                                    <div class="form-group"><label class="col-form-label">Area</label>
                                        <div><select class="form-control m-b" name="area_id">
                                                @foreach ($areas as $area)
                                                    <option value="{{ $area->id }}">{{ $area->especializacion }}
                                                    </option>
                                                @endforeach
                                            </select></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="ibox">
                                    <div class="ibox-title">
                                        <h5>Tabla</h5>
                                        <div class="ibox-tools">
                                            <button class="btn btn-primary" type="button" href="#modal-form-edit"
                                                data-toggle="modal"><i class="fa fa-plus-circle"></i></button>
                                        </div>
                                    </div>
                                    <div class="ibox-content">

                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Horario</th>
                                                    <th>Descripcion</th>
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
                                                                    name="account">
                                                                    <option>Presencial</option>
                                                                    <option>Virtual</option>
                                                                    <option>Semi-Presencial</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" placeholder="******">
                                                    </td>
                                                    <td>
                                                        <div class="form-group row"><label
                                                                class="col-form-label"></label>

                                                            <div class="col-sm-10"><select class="form-control m-b"
                                                                    name="account">
                                                                    <option>Lunes</option>
                                                                    <option>Martes</option>
                                                                    <option>Miercoles</option>
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
                                                                    class="fa fa-calendar"></i></span><input
                                                                type="text" class="form-control" value="8:30am">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group date">
                                                            <span class="input-group-addon"><i
                                                                    class="fa fa-calendar"></i></span><input
                                                                type="text" class="form-control" value="12:30pm">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-danger float-right" type="button"><i
                                                                class="fa fa-trash-o"></i></button>
                                                    </td>
                                                </tr>
                                                <!---Div-->
                                                <tr>
                                                    <td>
                                                        <div class="form-group row"><label
                                                                class="col-form-label"></label>

                                                            <div class="col-sm-10"><select class="form-control m-b"
                                                                    name="account">
                                                                    <option>Presencial</option>
                                                                    <option>Virtual</option>
                                                                    <option>Semi-Presencial</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            placeholder="******">
                                                    </td>
                                                    <td>
                                                        <div class="form-group row"><label
                                                                class="col-form-label"></label>

                                                            <div class="col-sm-10"><select class="form-control m-b"
                                                                    name="account">
                                                                    <option>Lunes</option>
                                                                    <option>Martes</option>
                                                                    <option>Miercoles</option>
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
                                                                    class="fa fa-calendar"></i></span><input
                                                                type="text" class="form-control" value="8:30am">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group date">
                                                            <span class="input-group-addon"><i
                                                                    class="fa fa-calendar"></i></span><input
                                                                type="text" class="form-control" value="12:30pm">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-danger float-right" type="button"><i
                                                                class="fa fa-trash-o"></i></button>
                                                    </td>
                                                </tr>
                                            </tbody>

                                        </table>
                                        <input type="number" class="form-control-file" id="candidato_id"
                                            name="candidato_id" value="{{ $candidato->id }}" style="display: none;">

                                        <div class="text-center">
                                            <button class="ladda-button btn btn-primary mr-5" type="submit"
                                                data-style="expand-left">Guardar</button>
                                            <button class="ladda-button btn btn-primary"
                                                data-style="expand-left">Cancelar</button>
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
</body>

</html>
