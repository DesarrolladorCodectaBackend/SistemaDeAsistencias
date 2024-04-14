<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inspina|Candidatos</title>
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <link href="../../font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="../../css/animate.css" rel="stylesheet">
    <link href="../../css/style.css" rel="stylesheet">
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
                        <strong>Candidatos</strong>
                    </li>
                </ol>
            </div>
            <div class="col-lg-2">
                <button class="btn btn-success dim float-right" href="#modal-form-add" data-toggle="modal"
                    type="button">Agregar</button>
                <div id="modal-form-add" class="modal fade" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body">
                                <form role="form" method="POST" action="{{ route('candidatos.store') }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-sm-6 b-r">
                                            <h3 class="m-t-none m-b">Ingrese los Datos</h3>
                                            <div class="form-group"><label>Nombre</label> <input type="text"
                                                    placeholder="Ingrese un nombre" class="form-control" name="nombre">
                                            </div>
                                            <div class="form-group"><label>Apellido</label> <input type="text"
                                                    placeholder="Ingrese apellido" class="form-control" name="apellido">
                                            </div>
                                            <div class="form-group"><label>DNI</label> <input type="text"
                                                    placeholder="....." class="form-control" name="dni"></div>
                                            <div class="form-group"><label>Dirección</label> <input type="text"
                                                    placeholder="Ingrese un nombre" class="form-control"
                                                    name="direccion">
                                            </div>
                                            <div class="form-group"><label>Fecha de Nacimiento</label> <input
                                                    type="date" placeholder="Ingrese apellido" class="form-control"
                                                    name="fecha_nacimiento">
                                            </div>
                                            <div class="form-group"><label>Ciclo de Estudiante</label> <input
                                                    type="text" placeholder="....." class="form-control"
                                                    name="ciclo_de_estudiante"></div>


                                        </div>
                                        <div class="col-sm-6">
                                            <h4>Subir Icono</h4>
                                            <input type="file" class="form-control-file" id="icono" name="icono"
                                                style="display: none;">
                                            <!-- Icono que simula el clic en el botón de subir archivos -->


                                            <button type="button" class="btn btn-link" id="icon-upload">
                                                <i class="fa fa-cloud-download big-icon"></i>
                                            </button>

                                            <div class="form-group"><label>Institucion</label> <input type="text"
                                                    placeholder="Ingrese apellido" class="form-control"
                                                    name="institucion_id">
                                            </div>
                                            <div class="form-group"><label>Carrera</label> <input type="text"
                                                    placeholder="....." class="form-control" name="carrera_id"></div>
                                            <div class="form-group"><label>Correo</label> <input type="text"
                                                    placeholder="Ingrese un nombre" class="form-control" name="correo">
                                            </div>
                                            <div class="form-group"><label>Celular</label> <input type="text"
                                                    placeholder="Ingrese apellido" class="form-control" name="celular">
                                            </div>


                                        </div>
                                        <div>
                                            <a href="candidatos"
                                                class="btn btn-white btn-sm m-t-n-xs float-left">Cancelar</a>
                                            <button class="btn btn-primary btn-sm m-t-n-xs float-right" type="submit"><i
                                                    class="fa fa-check"></i>&nbsp;Confirmar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                @foreach ($candidatos as $index => $candidato)
                @if ($index % 2 == 0)
            </div>
            <div class="row">
                @endif
                <div class="col-lg-6">
                    <div class="ibox ">
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-sm-6 b-r">
                                    <p class="text-center">
                                        <a href=""><i class="fa fa-user-circle big-icon"></i></a>
                                    </p>
                                    <p class="text-center">
                                        {{ $candidato->nombre." ".$candidato->apellido}}
                                    </p>
                                    <p class="text-center">
                                        @if ($candidato->estado == true)
                                        <button class="btn btn-primary" type="button"
                                            onclick="confirmColaborador({{ $candidato->id }})">
                                            Agregar Colaborador
                                        </button>
                                        @else
                                        <button class="btn btn-secondary" type="button" disabled
                                        style="cursor: not-allowed">
                                            Agregar Colaborador
                                        </button>
                                        @endif

                                    </p>
                                </div>
                                <div class="col-sm-6">

                                    <dl class="row mb-0">
                                        <div class="col-sm-6 text-sm-left">
                                            <dt>Carrera:</dt>
                                            <dd class="sm-2"> {{$candidato->carrera->nombre}} </dd>
                                        </div>
                                    </dl>
                                    <dl class="row mb-0">
                                        <div class="col-sm-6 text-sm-left">
                                            <dt>DNI:</dt>
                                            <dd class="sm-2">{{$candidato->dni}}</dd>
                                        </div>
                                    </dl>
                                    <dl class="row mb-0">
                                        <div class="col-sm-6 text-sm-left">
                                            <dt>Correo</dt>
                                            <dd class="sm-2">{{$candidato->correo}}</dd>
                                        </div>
                                    </dl>
                                    <dl class="row mb-0">
                                        <div class="col-sm-6 text-sm-left">
                                            <dt>Celular</dt>
                                            <dd class="sm-2">{{$candidato->celular}}</dd>
                                        </div>
                                    </dl>
                                    <div>
                                        <div class="mb-4">
                                            <button class="btn btn-danger float-right" type="button"
                                                onclick="confirmDelete({{ $candidato->id }})"><i
                                                    class="fa fa-trash-o"></i></button>
                                            <button class="btn btn-info float-right" type="button"
                                                href="#modal-form{{$candidato->id}}" data-toggle="modal"><i
                                                    class="fa fa-paste"></i></button>
                                        </div>
                                        <div id="modal-form{{$candidato->id}}" class="modal fade" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <form role="form" method="POST"
                                                            action="{{ route('candidatos.update', $candidato->id) }}"
                                                            enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="row">
                                                                <div class="col-sm-6 b-r">
                                                                    <h3 class="m-t-none m-b">Ingrese los Datos</h3>
                                                                    <div class="form-group">
                                                                        <label>Nombre</label>
                                                                        <input type="text" placeholder="....."
                                                                            class="form-control" name="nombre"
                                                                            id="nombre"
                                                                            value="{{ old('nombre', $candidato->nombre) }}">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Apellido</label>
                                                                        <input type="text" placeholder="....."
                                                                            class="form-control" name="apellido"
                                                                            id="apellido"
                                                                            value="{{ old('apellido', $candidato->apellido) }}">
                                                                    </div>
                                                                    <div class="form-group"><label>DNI</label>
                                                                        <input type="text" placeholder="....."
                                                                            class="form-control" name="dni" id="dni"
                                                                            value="{{ old('dni', $candidato->dni) }}">
                                                                    </div>
                                                                    <div class="form-group"><label>Dirección</label>
                                                                        <input type="text" placeholder="....."
                                                                            class="form-control" name="direccion"
                                                                            id="direccion"
                                                                            value="{{ old('direccion', $candidato->direccion) }}">
                                                                    </div>
                                                                    <div class="form-group"><label>Fecha de
                                                                            Nacimiento</label>
                                                                        <input type="date" placeholder="....."
                                                                            class="form-control" name="fecha_nacimiento"
                                                                            id="fecha_nacimiento"
                                                                            value="{{ old('fecha_nacimiento', $candidato->fecha_nacimiento) }}">
                                                                    </div>
                                                                    <div class="form-group"><label>Ciclo de
                                                                            Estudiante</label>
                                                                        <input type="text" placeholder="....."
                                                                            class="form-control"
                                                                            name="ciclo_de_estudiante"
                                                                            id="ciclo_de_estudiante"
                                                                            value="{{ old('ciclo_de_estudiante', $candidato->ciclo_de_estudiante) }}">
                                                                    </div>

                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <h4>Subir Icono</h4>
                                                                    <input type="file" class="form-control-file"
                                                                        id="icono-{{ $candidato->id }}" name="icono"
                                                                        value="{{ old('icono', $candidato->icono) }}"
                                                                        style="display: none;">
                                                                    <button type="button" class="btn btn-link"
                                                                        id="icon-upload-{{ $candidato->id }}">
                                                                        <i class="fa fa-cloud-download big-icon"></i>
                                                                    </button>
                                                                    <script>
                                                                        document.getElementById('icon-upload-{{ $candidato->id }}').addEventListener('click', function() {
                                                                        document.getElementById('icono-{{ $candidato->id }}').click();
                                                                    });
                                                                    </script>
                                                                    <div class="form-group">
                                                                        <label>Institucion</label>
                                                                        <input type="text" placeholder="....."
                                                                            class="form-control" name="institucion_id"
                                                                            id="institucion_id"
                                                                            value="{{ old('institucion_id', $candidato->institucion_id) }}">
                                                                    </div>
                                                                    <div class="form-group"><label>Carrera</label>
                                                                        <input type="text" placeholder="....."
                                                                            class="form-control" name="carrera_id"
                                                                            id="carrera_id"
                                                                            value="{{ old('carrera_id', $candidato->carrera_id) }}">
                                                                    </div>
                                                                    <div class="form-group"><label>Correo</label>
                                                                        <input type="text" placeholder="....."
                                                                            class="form-control" name="correo"
                                                                            id="correo"
                                                                            value="{{ old('correo', $candidato->correo) }}">
                                                                    </div>
                                                                    <div class="form-group"><label>Celular</label>
                                                                        <input type="text" placeholder="....."
                                                                            class="form-control" name="celular"
                                                                            id="celular"
                                                                            value="{{ old('celular', $candidato->celular) }}">
                                                                    </div>
                                                                    <div>
                                                                        <a href="candidatos"
                                                                            class="btn btn-white btn-sm m-t-n-xs float-left">Cancelar</a>
                                                                        <button
                                                                            class="btn btn-primary btn-sm m-t-n-xs float-right"
                                                                            type="submit"><i
                                                                                class="fa fa-check"></i>&nbsp;Confirmar</button>
                                                                    </div>
                                                                </div>
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
                    </div>
                </div>
                @endforeach
            </div>

        </div>

        @include('components.inspinia.footer-inspinia')

































    </div>
    </div>
    <script>
        const hiddenFileInput = document.getElementById('icono');
        const iconUploadButton = document.getElementById('icon-upload');

        iconUploadButton.addEventListener('click', function() {
            hiddenFileInput.click();
        });
    </script>

    <script>
        function confirmDelete(id) {
            alertify.confirm("¿Deseas eliminar este registro?", function(e) {
                if (e) {
                    let form = document.createElement('form')
                    form.method = 'POST'
                    form.action = `/candidatos/${id}`
                    form.innerHTML = '@csrf @method('DELETE')'
                    document.body.appendChild(form)
                    form.submit()
                } else {
                    return false
                }
            });
        }

        function confirmColaborador(id) {
            alertify.confirm("¿Deseas agregar a este colaborador?", function(e) {
                if (e) {
                    let form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/colaboradores`;

                    // CSRF Token
                    const csrfField = document.createElement('input');
                    csrfField.type = 'hidden';
                    csrfField.name = '_token';
                    csrfField.value = '{{ csrf_token() }}'; // Use Laravel's helper to generate a CSRF token
                    form.appendChild(csrfField);

                    // HTTP Method
                    const methodField = document.createElement('input');
                    methodField.type = 'hidden';
                    methodField.name = '_method';
                    methodField.value = 'POST';
                    form.appendChild(methodField);

                    // Candidato ID
                    const candidatoField = document.createElement('input');
                    candidatoField.type = 'hidden';
                    candidatoField.name = 'candidato_id';
                    candidatoField.value = id;
                    form.appendChild(candidatoField);

                    document.body.appendChild(form);
                    form.submit();
                } else {
                    return false;
                }
            });
        }

    </script>

</body>

</html>