<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>INSPINIA | Colaboradores</title>
</head>

<body>
    <div id="wrapper">
        @include('components.inspinia.side_nav_bar-inspinia')
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-10">
                <h2>Colaboradores</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.html">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a>Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active">
                        <strong>Colaboradores</strong>
                    </li>
                </ol>
            </div>
            <div class="col-lg-2">

                <div class="ibox-content">
                    <div class="text-center">
                        <a data-toggle="modal" class="btn btn-primary " href="#modal-form1"> Agregar <i
                                class="fa fa-long-arrow-right"></i></a>
                    </div>
                    <!-- Modal view here-->
                </div>

            </div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                @foreach($colaboradoresConArea as $index => $colaborador)
                <div id="modal-form-view{{$colaborador->id}}" class="modal fade" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="row">

                                    <div class="col-sm-6 b-r">
                                        <h3 class="m-t-none m-b">Informacion Personal </h3>


                                        <form role="form">
                                            <style>
                                                .form-group {
                                                    margin-bottom: 0rem;
                                                }
                                            </style>
                                            <div class="form-group"><label>
                                                    <h5 class="m-t-none m-b">Nombres:</h5>
                                                </label><label for="">{{$colaborador->candidato->nombre}}</label>
                                            </div>
                                            <div class="form-group"><label>
                                                    <h5 class="m-t-none m-b">Apellidos:</h5>
                                                </label><label for="">{{$colaborador->candidato->apellido}}</label>
                                            </div>
                                            <div class="form-group"><label>
                                                    <h5 class="m-t-none m-b">Direccion:</h5>
                                                </label><label for="">{{$colaborador->candidato->direccion}}</label>
                                            </div>
                                            <div class="form-group"><label>
                                                    <h5 class="m-t-none m-b">Institucion:</h5>
                                                </label><label
                                                    for="">{{$colaborador->candidato->institucion->nombre}}</label>
                                            </div>
                                            <div class="form-group"><label>
                                                    <h5 class="m-t-none m-b">Ciclo:</h5>
                                                </label><label
                                                    for="">{{$colaborador->candidato->ciclo_de_estudiante}}°</label>
                                            </div>
                                            <div class="form-group"><label>
                                                    <h5 class="m-t-none m-b">Correo:</h5>
                                                </label><label for="">{{$colaborador->candidato->correo}}</label>
                                            </div>
                                            <div class="form-group"><label>
                                                    <h5 class="m-t-none m-b">fecha de
                                                        Nacimiento:</h5>
                                                </label><label
                                                    for="">{{$colaborador->candidato->fecha_nacimiento}}</label>
                                            </div>
                                            <div class="form-group"><label>
                                                    <h5 class="m-t-none m-b">DNI:</h5>
                                                </label><label for="">{{$colaborador->candidato->dni}}</label>
                                            </div>
                                            <div class="form-group"><label>
                                                    <h5 class="m-t-none m-b">Celular:</h5>
                                                </label><label for="">{{$colaborador->candidato->celular}}</label>
                                            </div>
                                            <div class="form-group"><label>
                                                    <h5 class="m-t-none m-b">Area:</h5>
                                                </label><label for="">Analisis</label></div>
                                            <div class="form-group"><label>
                                                    <h5 class="m-t-none m-b">Carrera:</h5>
                                                </label><label
                                                    for="">{{$colaborador->candidato->carrera->nombre}}</label>
                                            </div>
                                            <div class="form-group"><label>
                                                    <h5 class="m-t-none m-b">Estado:</h5>
                                                </label><label for="">
                                                    @if ($colaborador->estado == 1)
                                                    <span style="color: green"><strong>Activo</strong></span>

                                                    @else
                                                    <span style="color: #F00"><strong>Inactivo</strong></span>
                                                    @endif
                                                </label></div>
                                            <div>
                                                <a data-toggle="modal"
                                                    class="btn btn-sm btn-primary float-right m-t-n-xs fa fa-edit btn-success"
                                                    onclick="abrirModalEdicion({{$colaborador->id}});"
                                                    style="font-size: 20px; width: 60px;"
                                                    href="#modal-form-update{{$colaborador->id}}"></a>

                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-sm-6 text-center text-danger">
                                        <h2><strong> Colaborador </strong></h2>
                                        <a style="color: black;"><strong>{{$colaborador->id}}</strong></a>
                                        <div class="custom-file w-200 h-300 " style="padding: 20px 0px;">
                                            <img src="{{asset('storage/candidatos/'.$colaborador->candidato->icono)}}"
                                                class="img-lg  max-min-h-w-200 img-cover">

                                        </div>
                                        <a class="btn btn-primary btn-success fa fa-desktop"
                                            style="width: 100px; font-size: 18px;" href="Computadora.html"></a>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="ibox">
                        <div class="ibox-content product-box">

                            <div class="text-center rounded-circle">
                                <img src="{{asset('storage/candidatos/'.$colaborador->candidato->icono)}}"
                                    class="rounded-circle max-min-h-w-200 p-a-10 img-cover">
                            </div>
                            <div class="product-desc">
                                <span class="product-price btn-Default" style="background-color: transparent;">
                                    <form method="POST"
                                        action="{{ route('colaboradores.activarInactivar', $colaborador->id) }}">
                                        @csrf
                                        <button type="submit"
                                            class="btn btn-{{ $colaborador->estado ? 'outline-success' : 'danger' }} btn-primary dim btn-xs">
                                            <span>{{ $colaborador->estado ? 'Activo' : 'Inactivo' }}</span>
                                        </button>
                                    </form>
                                </span>


                                <a href="#" class="product-name">
                                    <h2>{{$colaborador->candidato->nombre." ".$colaborador->candidato->apellido}}</h2>
                                </a>



                                <small class="text-muted text-left">
                                    <h3>Area:</h3>
                                </small>
                                <div class="small m-t-xs text-left">
                                    <h5>{{$colaborador->area}}</h5>
                                </div>
                                <small class="text-muted text-left">
                                    <h3>DN1:</h3>
                                </small>
                                <div class="small m-t-xs text-left">
                                    <h5>{{$colaborador->candidato->dni}}</h5>
                                </div>
                                <small class="text-muted text-left">
                                    <h3>Correo:</h3>
                                </small>
                                <div class="small m-t-xs text-left">
                                    <h5>{{$colaborador->candidato->correo}}</h5>
                                </div>
                                <small class="text-muted text-left">
                                    <h3>Celular:</h3>
                                </small>
                                <div class="small m-t-xs text-left">
                                    <h5>{{$colaborador->candidato->celular}}</h5>
                                </div>
                                <div class="m-t text-righ">

                                    <a href="#" data-toggle="model"> <i></i> </a>
                                    <div class="ibox-content">
                                        <div class="text-right">
                                            <button class="btn btn-primary btn-danger fa fa-trash"
                                                style="font-size: 20px;" type="button"
                                                onclick="confirmDelete({{ $colaborador->id }})"></button>
                                            <button data-toggle="modal" class="btn btn-primary fa fa-clock-o"
                                                style="font-size: 20px;" type="button"
                                                href="#modal-form-update{{$colaborador->id}}"
                                                data-toggle="modal"></button>
                                            <button data-toggle="modal" class="btn btn-primary btn-success fa fa-eye"
                                                style="font-size: 20px;"
                                                href="#modal-form-view{{$colaborador->id}}"></button>
                                        </div>
                                        <div id="modal-form-update{{$colaborador->id}}" class="modal fade"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <form role="form" method="POST"
                                                            action="{{ route('colaboradores.update', $colaborador->candidato->id) }}"
                                                            enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')
                                                            <style>
                                                                .form-group {
                                                                    margin-bottom: 0rem;
                                                                }
                                                            </style>
                                                            <div class="row">
                                                                <div class="col-sm-6 b-r">
                                                                    <h3 class="m-t-none m-b">Informacion Personal </h3>
                                                                    <div class="form-group"><label>
                                                                            <h5 class="m-t-none">Nombres:</h5>
                                                                        </label><input type="text" placeholder="....."
                                                                            class="form-control" name="nombre"
                                                                            id="nombre"
                                                                            value="{{ old('nombre', $colaborador->candidato->nombre) }}">
                                                                    </div>
                                                                    <div class="form-group"><label>
                                                                            <h5 class="m-t-none">Apellidos:</h5>
                                                                        </label><input type="text" placeholder="....."
                                                                            class="form-control" name="apellido"
                                                                            id="apellido"
                                                                            value="{{ old('apellido', $colaborador->candidato->apellido) }}">
                                                                    </div>
                                                                    <div class="form-group"><label>
                                                                            <h5 class="m-t-none">Direccion:</h5>
                                                                        </label><input type="text" placeholder="....."
                                                                            class="form-control" name="direccion"
                                                                            id="direccion"
                                                                            value="{{ old('direccion', $colaborador->candidato->direccion) }}">
                                                                    </div>
                                                                    <div class="form-group"><label>
                                                                            <h5 class="m-t-none">Institucion:</h5>
                                                                        </label>
                                                                        <select class="form-control"
                                                                            name="institucion_id">
                                                                            @foreach($instituciones as $institucion)
                                                                            <option value="{{ $institucion->id }}"
                                                                                @if($institucion->id ==
                                                                                old('institucion_id',
                                                                                $colaborador->candidato->institucion_id)) selected
                                                                                @endif>{{ $institucion->nombre }}
                                                                            </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group"><label>
                                                                            <h5 class="m-t-none">Ciclo:</h5>
                                                                        </label><input type="text" placeholder="....."
                                                                            class="form-control"
                                                                            name="ciclo_de_estudiante"
                                                                            id="ciclo_de_estudiante"
                                                                            value="{{ old('ciclo_de_estudiante', $colaborador->candidato->ciclo_de_estudiante) }}">
                                                                    </div>
                                                                    <div class="form-group"><label>
                                                                            <h5 class="m-t-none">Correo:</h5>
                                                                        </label><input type="text" placeholder="....."
                                                                            class="form-control" name="correo"
                                                                            id="correo"
                                                                            value="{{ old('correo', $colaborador->candidato->correo) }}">
                                                                    </div>
                                                                    <div class="form-group"><label>
                                                                            <h5 class="m-t-none">fecha de Nacimiento:
                                                                            </h5>
                                                                        </label><input type="date" placeholder="....."
                                                                            class="form-control" name="fecha_nacimiento"
                                                                            id="fecha_nacimiento"
                                                                            value="{{ old('fecha_nacimiento', $colaborador->candidato->fecha_nacimiento) }}">
                                                                    </div>
                                                                    <div class="form-group"><label>
                                                                            <h5 class="m-t-none">DNI:</h5>
                                                                        </label><input type="text" placeholder="....."
                                                                            class="form-control" name="dni" id="dni"
                                                                            value="{{ old('dni', $colaborador->candidato->dni) }}"></input>
                                                                    </div>
                                                                    <div class="form-group"><label>
                                                                            <h5 class="m-t-none">Celular:</h5>
                                                                        </label><input type="text" placeholder="....."
                                                                            class="form-control" name="celular"
                                                                            id="celular"
                                                                            value="{{ old('celular', $colaborador->candidato->celular) }}">
                                                                    </div>
                                                                    <div class="form-group"><label>
                                                                            <h5 class="m-t-none">Area:</h5>
                                                                        </label><input style="padding: 1px 8px;"
                                                                            type="text" class="form-control"
                                                                            value="Analisis"></input></div>
                                                                    <div class="form-group"><label>
                                                                            <h5 class="m-t-none">Carrera:</h5>
                                                                        </label>
                                                                        <select class="form-control" name="carrera_id">
                                                                            @foreach($carreras as $carrera)
                                                                            <option value="{{ $carrera->id }}"
                                                                                @if($carrera->id == old('carrera_id',
                                                                                $colaborador->candidato->carrera_id)) selected
                                                                                @endif>{{ $carrera->nombre }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>




                                                                    <div class="form-group"><label>Estado: </label>
                                                                        <input type="checkbox" class="js-switch"
                                                                            checked />
                                                                        <br>
                                                                        <br>

                                                                    </div>

                                                                    <div>
                                                                        <button
                                                                            class="btn btn-sm btn-primary float-left m-t-n-xs btn-success"
                                                                            type="submit">
                                                                            <strong>Guardar</strong>
                                                                        </button>

                                                                        <a class="btn btn-sm btn-primary float-right m-t-n-xs  btn-success"
                                                                            style="color: #FFF" href="colaboradores">
                                                                            <strong>Descartar</strong>
                                                                        </a>



                                                                    </div>
                                                        </form>



                                                    </div>
                                                    <div class="col-sm-6 text-center text-danger">
                                                        <h2><strong> Colaborador </strong></h2>
                                                        <a
                                                            style="color: black;"><strong>{{$colaborador->id}}</strong></a>
                                                        <div class="custom-file w-200 h-300 "
                                                            style="padding: 20px 0px;">


                                                            <input type="file" class="form-control-file"
                                                                id="icono-{{ $colaborador->candidato->id }}"
                                                                name="icono"
                                                                value="{{ old('icono', $colaborador->candidato->icono) }}"
                                                                style="display: none;">
                                                            <button type="button" class="btn btn-link"
                                                                id="icon-upload-{{ $colaborador->candidato->id }}">
                                                                <img src="{{asset('storage/candidatos/'.$colaborador->candidato->icono)}}"
                                                                    class="img-lg w-200 max-min-h-w-200 img-cover">
                                                            </button>
                                                            <script>
                                                                document.getElementById('icon-upload-{{ $colaborador->candidato->id }}').addEventListener('click', function() {
                                                                        document.getElementById('icono-{{ $colaborador->candidato->id }}').click();
                                                                    });
                                                            </script>
                                                        </div>
                                                        <a data-toggle="modal"
                                                            class="btn btn-primary btn-success fa fa-desktop"
                                                            style="width: 100px; font-size: 18px;" href=""></a>
                                                        <a data-toggle="modal" class="btn btn-primary btn-success "
                                                            style="width: 100px; font-size: 12px;" href="">?</a>

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
            </div>
        </div>




        @endforeach
    </div>






    </div>










    @include('components.inspinia.footer-inspinia')
    </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const personal = document.getElementById('personalCont');
            if (personal) {
                personal.classList.add('active');
            } else {
                console.error("El elemento con el id 'personalCont' no se encontró en el DOM.");
            }
        });
        document.addEventListener('DOMContentLoaded', function() {
            const colabCont = document.getElementById('colaboradoresCont');
            if (colabCont) {
                colabCont.classList.add('active');
            } else {
                console.error("El elemento con el id 'colaboradoresCont' no se encontró en el DOM.");
            }
        });
        document.addEventListener('DOMContentLoaded', function() {
            const colaborador = document.getElementById('colaboradores');
            if (colaborador) {
                colaborador.classList.add('active');
            } else {
                console.error("El elemento con el id 'colaboradores' no se encontró en el DOM.");
            }
        });
    </script>

    <script>
        function hideModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('show');

                // Remover el Backdrop
                const backdrop = document.querySelector('.modal-backdrop');
                if (backdrop) {
                    backdrop.parentNode.removeChild(backdrop);
                }
            }
        }

        function showModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.add(' show');
            }
        }

        function abrirModalEdicion(id) {
            hideModal('modal-form-view' + id);
            showModal('modal-form-update' + id);
        }

        function confirmDelete(id) {
            alertify.confirm("¿Deseas eliminar este registro?", function(e) {
                if (e) {
                    let form = document.createElement('form')
                    form.method = 'POST'
                    form.action = `/colaboradores/${id}`
                    form.innerHTML = '@csrf @method('DELETE')'
                    document.body.appendChild(form)
                    form.submit()
                } else {
                    return false
                }
            });
        }
    </script>
</body>

</html>