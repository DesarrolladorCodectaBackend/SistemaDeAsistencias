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
            <div class="col-lg-3">
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
            <div class="col-lg-7 flex-centered">
                <div class="flex-centered spc-per-90">
                    <form method="POST" action="{{route('colaboradores.search')}}"
                        class="flex-centered gap-20 spc-per-100">
                        @csrf
                        <input class="form-control wdt-per-80" type="search" name="busqueda"
                            placeholder="Buscar Colaborador..." aria-label="Search">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                    </form>
                </div>
            </div>
            <div class="col-lg-2">

                <div class="ibox-content">
                    <div class="text-center flex-centered gap-20">
                        <a class="btn btn-primary" href="/candidatos"> 
                            Agregar <i class="fa fa-long-arrow-right"></i>
                        </a>
                        <a data-toggle="modal" class="btn btn-success " href="#modal-filtrar"> Filtrar <i
                                class="fa fa-long-arrow-right"></i></a>
                    </div>
                    <!-- Modal view here-->
                    <div id="modal-filtrar" class="modal fade" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <form role="form" method="POST" action="{{ route('colaboradores.filtrar') }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-sm-6 b-r">
                                                <h2 class="m-t-none m-b">Filtrar Colaboradores</h2>
                                                <div class="form-group">
                                                    <label>
                                                        <h4 class="m-t-none m-b">Areas:</h4>
                                                    </label>
                                                    <div class="form-group">
                                                        <input type="checkbox" id="select-all-areas"><span>Seleccionar
                                                            todos</span>
                                                    </div>
                                                    @foreach($areas as $index => $area)
                                                    <div class="form-group">
                                                        <input type="checkbox" id="checkbox-areas-{{$index}}"
                                                            name="area_id[]" value="{{ $area->id }}"><span>{{
                                                            $area->especializacion
                                                            }}</span>
                                                    </div>
                                                    @endforeach
                                                </div>
                                                <div class="form-group">
                                                    <label>
                                                        <h4 class="m-t-none m-b">Estados:</h4>
                                                    </label>
                                                    <div class="form-group">
                                                        <input type="checkbox" id="select-all-estados"><span>Seleccionar
                                                            todos</span>
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="checkbox" name="estado[]" id="checkbox-estados-1"
                                                            value="1"><span>activo</span>
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="checkbox" name="estado[]" id="checkbox-estados-0"
                                                            value="0"><span>inactivo</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 b-r">
                                                <div class="form-group">
                                                    <label>
                                                        <h4 class="m-t-none m-b">Carreras:</h4>
                                                    </label>
                                                    <div class="form-group">
                                                        <input type="checkbox"
                                                            id="select-all-carreras"><span>Seleccionar todos</span>
                                                    </div>
                                                    @foreach($carreras as $index => $carrera)
                                                    <div class="form-group">
                                                        <input type="checkbox" name="carrera_id[]"
                                                            id="checkbox-carreras-{{$index}}"
                                                            value="{{ $carrera->id }}"><span>{{ $carrera->nombre
                                                            }}</span>
                                                    </div>
                                                    @endforeach
                                                </div>
                                                <div class="form-group">
                                                    <label>
                                                        <h4 class="m-t-none m-b">Instituciones:</h4>
                                                    </label>
                                                    <div class="form-group">
                                                        <input type="checkbox"
                                                            id="select-all-instituciones"><span>Seleccionar todos</span>
                                                    </div>
                                                    @foreach($instituciones as $index => $institucion)
                                                    <div class="form-group">
                                                        <input type="checkbox" name="institucion_id[]"
                                                            id="checkbox-institucion-{{$index}}"
                                                            value="{{ $institucion->id }}"><span>{{ $institucion->nombre
                                                            }}</span>
                                                    </div>
                                                    @endforeach
                                                </div>
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-primary">Filtrar</button>
                                                    <a class="btn btn-warning" href="">Cancelar</a>
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
                                                    <h5 class="m-t-none m-b">Institucion - Sede:</h5>
                                                </label><label for="">{{$colaborador->candidato->sede->nombre}}</label>
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
                                            <div class="form-group">
                                                <label>
                                                    <h5 class="m-t-none m-b">Area:</h5>
                                                </label>
                                                @foreach($colaborador->areas as $area)
                                                <label>{{$area}}</label>
                                                @endforeach
                                            </div>
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
                                        <div style="display: flex; gap:2px">
                                            <form id="getComputadoraColab{{$colaborador->id}}"
                                                action="{{route('colaboradores.getComputadora', $colaborador->id)}}">
                                            </form>
                                            <a href="#" class="btn btn-primary btn-success fa fa-desktop"
                                                style="width: 100px; font-size: 18px;"
                                                onclick="document.getElementById('getComputadoraColab{{$colaborador->id}}').submit();">
                                            </a>
                                            <a data-toggle="modal" class="btn btn-primary btn-success fa fa-dropbox"
                                                style="width: 100px; font-size: 18px;" href=""></a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 ">
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
                                    <h3>Área(s):</h3>
                                </small>
                                <div class="small m-t-xs text-left">
                                    @foreach($colaborador->areas as $area)
                                    <h5>{{$area}}</h5>
                                    @endforeach
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
                                    <form id="horario-clase-{{$colaborador->id}}" role="form" method="GET"
                                        action="{{route('colaboradores.horarioClase', $colaborador->id)}}">
                                    </form>
                                    <div class="ibox-content">
                                        <div class="text-center">
                                            {{-- <button class="btn btn-primary btn-danger fa fa-trash"
                                                style="font-size: 20px;" type="button"
                                                onclick="confirmDelete({{ $colaborador->id }})"></button> --}}
                                            <button data-toggle="modal" class="btn btn-primary fa fa-clock-o"
                                                style="font-size: 20px;"
                                                onclick="document.getElementById('horario-clase-{{$colaborador->id}}').submit();"></button>
                                            {{-- <button class="btn btn-primary btn-warning fa fa-book mx-1"
                                                style="font-size: 20px;"></button> --}}
                                            <button data-toggle="modal" class="btn btn-primary btn-success fa fa-eye"
                                                style="font-size: 20px;"
                                                href="#modal-form-view{{$colaborador->id}}"></button>
                                        </div>
                                        <div id="modal-form-update{{$colaborador->id}}" class="modal fade"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-custom">
                                                <div style="min-width: 750px" class="modal-content">
                                                    <div class="modal-body">
                                                        <form role="form" method="POST"
                                                            action="{{ route('colaboradores.update', $colaborador->id) }}"
                                                            enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')
                                                            <style>
                                                                .form-group {
                                                                    margin-bottom: 0rem;
                                                                }
                                                            </style>
                                                            <div class="row">
                                                                <div class="col-sm-4 b-r">
                                                                    <h3 class="m-t-none m-b">Informacion Personal
                                                                    </h3>
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
                                                                            <h5 class="m-t-none">Institucion - Sede:
                                                                            </h5>
                                                                        </label>
                                                                        <select class="form-control" name="sede_id">
                                                                            @foreach ($sedes as $sede)
                                                                            <option value="{{ $sede->id }}" @if($sede->
                                                                                id == $colaborador->candidato->sede_id)
                                                                                selected @endif>
                                                                                {{ $sede->nombre }}
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
                                                                </div>
                                                                <div class="col-sm-4 b-r">
                                                                    <h3 class="m-t-none m-b">.</h3>
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

                                                                    <div class="form-group">
                                                                        <label>
                                                                            <h5 class="m-t-none">Area:</h5>
                                                                        </label>
                                                                        <select name="areas_id[]" multiple required
                                                                            class="form-control multiple_areas_select">
                                                                            @foreach ($areas as $key => $area)+
                                                                            <option value="{{ $area->id }}"
                                                                                @foreach($colaborador->areas as $areaNombre)
                                                                                @if($area->especializacion ==
                                                                                $areaNombre)
                                                                                selected
                                                                                @endif
                                                                                @endforeach
                                                                                >
                                                                                {{ $area->especializacion }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>



                                                                    <div class="form-group"><label>
                                                                            <h5 class="m-t-none">Carrera:</h5>
                                                                        </label>
                                                                        <select class="form-control" name="carrera_id">
                                                                            @foreach ($carreras as $carrera)
                                                                            <option value="{{ $carrera->id }}"
                                                                                @if($carrera->id == old('carrera_id',
                                                                                $colaborador->candidato->carrera_id))
                                                                                selected @endif>
                                                                                {{ $carrera->nombre }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

                                                                    <div class="mt-4 text-center">
                                                                        <button
                                                                            class="btn btn-sm btn-primary float-left m-t-n-xs btn-success"
                                                                            type="submit">
                                                                            <strong>Guardar</strong>
                                                                        </button>

                                                                    </div>

                                                                </div>
                                                                <div class="col-sm-4 text-center text-danger">
                                                                    <h2><strong> Colaborador </strong></h2>
                                                                    <a style="color: black;"><strong>ID: {{
                                                                            $colaborador->id }}</strong></a>
                                                                    <div class="custom-file w-200 h-300 "
                                                                        style="padding: 20px 0px;">


                                                                        <input type="file" class="form-control-file"
                                                                            id="icono-{{ $colaborador->candidato->id }}"
                                                                            name="icono"
                                                                            value="{{ old('icono', $colaborador->candidato->icono) }}"
                                                                            style="display: none;">
                                                                        <button type="button" class="btn btn-link"
                                                                            id="icon-upload-{{ $colaborador->candidato->id }}">
                                                                            <img src="{{ asset('storage/candidatos/' . $colaborador->candidato->icono) }}"
                                                                                class="img-lg w-200 max-min-h-w-200 img-cover">
                                                                        </button>
                                                                        <script>
                                                                            document.getElementById('icon-upload-{{ $colaborador->candidato->id }}').addEventListener('click', function() {
                                                                                document.getElementById('icono-{{ $colaborador->candidato->id }}').click();
                                                                            });
                                                                        </script>
                                                                    </div>
                                                                    <div style="display: flex; gap:2px">
                                                                        <a href="#"
                                                                            class="btn btn-primary btn-success fa fa-desktop"
                                                                            style="width: 100px; font-size: 18px;"
                                                                            onclick="document.getElementById('getComputadoraColab{{$colaborador->id}}').submit();">
                                                                        </a>
                                                                        <a data-toggle="modal"
                                                                            class="btn btn-primary btn-success fa fa-dropbox"
                                                                            style="width: 100px; font-size: 18px;"
                                                                            href=""></a>
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
    <style>
        .select2-container.select2-container--default.select2-container--open {
            z-index: 9999 !important;
            width: 100% !important;
        }

        /* .select2-container--default .select2-selection--multiple {
            width: auto;
            min-width: 100% !important; 
        } */
        .select2-container {
            display: inline !important;
        }

        /* .select2.select2-container.select2-container--default.selection.select2-selection.select2-selection--multiple.
        .select2-selection__rendered.select2-container--below.select2-selection__rendered{
            z-index: 9999 !important;
            width: 100% !important;
        } */
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const personal = document.getElementById('personalCont');
            if (personal) {
                personal.classList.add('active');
            } else {
                console.error("El elemento con el id 'personalCont' no se encontró en el DOM.");
            }
        });
        /*
        document.addEventListener('DOMContentLoaded', function() {
            const colabCont = document.getElementById('colaboradoresCont');
            if (colabCont) {
                colabCont.classList.add('active');
            } else {
                console.error("El elemento con el id 'colaboradoresCont' no se encontró en el DOM.");
            }
        });
        */
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

        // function confirmDelete(id) {
        //     alertify.confirm("¿Deseas eliminar este registro?", function(e) {
        //         if (e) {
        //             let form = document.createElement('form')
        //             form.method = 'POST'
        //             form.action = `/colaboradores/${id}`
        //             form.innerHTML = '@csrf @method('DELETE')'
        //             document.body.appendChild(form)
        //             form.submit()
        //         } else {
        //             return false
        //         }
        //     });
        // }





        

        function updateSelectAll(checkboxGroup, selectAllId) {
            const selectAllCheckbox = document.getElementById(selectAllId);
            const checkboxes = document.querySelectorAll(checkboxGroup);
            selectAllCheckbox.checked = Array.from(checkboxes).every(checkbox => checkbox.checked);
        }

        document.getElementById('select-all-areas').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('input[id^="checkbox-areas-"]');
            for (var checkbox of checkboxes) {
                checkbox.checked = this.checked;
            }
        });

        document.getElementById('select-all-estados').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('input[id^="checkbox-estados-"]');
            for (var checkbox of checkboxes) {
                checkbox.checked = this.checked;
            }
        });

        document.getElementById('select-all-carreras').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('input[id^="checkbox-carreras-"]');
            for (var checkbox of checkboxes) {
                checkbox.checked = this.checked;
            }
        });

        document.getElementById('select-all-instituciones').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('input[id^="checkbox-institucion-"]');
            for (var checkbox of checkboxes) {
                checkbox.checked = this.checked;
            }
        });

        document.querySelectorAll('input[id^="checkbox-areas-"]').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                updateSelectAll('input[id^="checkbox-areas-"]', 'select-all-areas');
            });
        });

        document.querySelectorAll('input[id^="checkbox-estados-"]').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                updateSelectAll('input[id^="checkbox-estados-"]', 'select-all-estados');
            });
        });

        document.querySelectorAll('input[id^="checkbox-carreras-"]').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                updateSelectAll('input[id^="checkbox-carreras-"]', 'select-all-carreras');
            });
        });

        document.querySelectorAll('input[id^="checkbox-institucion-"]').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                updateSelectAll('input[id^="checkbox-institucion-"]', 'select-all-instituciones');
            });
        });


        






    </script>

    <script>
        //JQuery para select multiple de areas
        $(document).ready(function() {
            $('.multiple_areas_select').select2();
        });
    </script>
</body>

</html>