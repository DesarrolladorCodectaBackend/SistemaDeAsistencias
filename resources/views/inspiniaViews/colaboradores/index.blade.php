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
                        <a href="/dashboard">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a>Personal</a>
                    </li>
                    <li class="breadcrumb-item active">
                        <strong>Colaboradores</strong>
                    </li>
                </ol>
            </div>
            <div class="col-lg-7 flex-centered">
                <div class="flex-centered spc-per-90">

                    <form id="searchColaboradores" role="form" method="GET" action="" enctype="multipart/form-data" onsubmit="return prepareSearchActionURL()"
                        class="flex-centered gap-20 spc-per-100">
                        <input type="hidden" id="searchRoute" value="{{route('colaboradores.search', ['busqueda' => '/'])}}">
                        <input id="searchInput" class="form-control wdt-per-80" type="search"
                            placeholder="Buscar Colaborador..." aria-label="Search" required autocomplete="off">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
                    </form>
                </div>
            </div>
            <div class="col-lg-2">

                <div class="ibox-content">
                    <div class="text-center flex-centered gap-20">
                        <a class="btn btn-primary" href="/candidatos">
                            <i class="fa fa-long-arrow-left"></i> Agregar
                        </a>
                        <a data-toggle="modal" class="btn btn-success " href="#modal-filtrar"> Filtrar </a>
                    </div>
                    <div id="modal-filtrar" class="modal fade" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <!--
                                    <form id="filtrarColaboradores" role="form" method="GET" action="" enctype="multipart/form-data" onsubmit="return prepareFilterActionURL()">
                                        <h2 class="m-t-none m-b font-bold">Filtrar Colaboradores</h2>
                                        <div class="row">
                                            <div class="col-sm-12 col-md-6 b-r">
                                                <div class="form-group">
                                                    <label>
                                                        <h4 class="m-t-none m-b">Areas:</h4>
                                                    </label>
                                                    <div class="form-group">
                                                        <input type="checkbox" id="select-all-areas"><span>Seleccionar
                                                            todos</span>
                                                    </div>
                                                    @foreach($areasAll as $index => $area)
                                                    <div class="form-group">
                                                        <input type="checkbox" id="checkbox-areas-{{$index}}" class="area-checkbox" value="{{ $area->id }}"><span>{{$area->especializacion}}</span>
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
                                                        <input type="checkbox" class="estado-checkbox" id="checkbox-estados-1"
                                                            value="1"><span>activo</span>
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="checkbox" class="estado-checkbox" id="checkbox-estados-0"
                                                            value="0"><span>inactivo</span>
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="checkbox" class="estado-checkbox" id="checkbox-estados-0"
                                                            value="2"><span>Ex colaborador</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-6 b-r">
                                                <div class="form-group">
                                                    <label>
                                                        <h4 class="m-t-none m-b">Carreras:</h4>
                                                    </label>
                                                    <div class="form-group">
                                                        <input type="checkbox"
                                                            id="select-all-carreras"><span>Seleccionar todos</span>
                                                    </div>
                                                    @foreach($carrerasAll as $index => $carrera)
                                                    <div class="form-group">
                                                        <input type="checkbox" class="carrera-checkbox" value="{{ $carrera->id }}"><span>{{ $carrera->nombre }}</span>
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
                                                    @foreach($institucionesAll as $index => $institucion)
                                                    <div class="form-group">
                                                        <input type="checkbox" class="institucion-checkbox" value="{{ $institucion->id }}"><span>{{ $institucion->nombre }}</span>
                                                    </div>
                                                    @endforeach
                                                </div>
                                                <div class="form-group mt-3 text-center">
                                                    <button type="submit" class="btn btn-primary px-5">Filtrar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    -->
                                    <form id="filtrarColaboradores" role="form" method="GET" action="" enctype="multipart/form-data" onsubmit="return prepareFilterActionURL()">
                                        <h2 class="m-t-none m-b font-bold text-center">Filtrar Colaboradores</h2>
                                        <div class="accordion" id="accordionExample">
                                            <!-- Estados -->
                                            <div class="card">
                                                <div class="card-header" id="headingEstados">
                                                    <h5 class="mb-0">
                                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseEstados" aria-expanded="true" aria-controls="collapseEstados">
                                                            Estados
                                                        </button>
                                                    </h5>
                                                </div>
                                                <div id="collapseEstados" class="collapse show" aria-labelledby="headingEstados" data-parent="#accordionExample">
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <input type="checkbox" id="select-all-estados"><span> Seleccionar todos</span>
                                                        </div>
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input estado-checkbox" id="checkbox-estados-1" value="1">
                                                            <span for="checkbox-estados-1">Activo</span>
                                                        </div>
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input estado-checkbox" id="checkbox-estados-0" value="0">
                                                            <span for="checkbox-estados-0">Inactivo</span>
                                                        </div>
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input estado-checkbox" id="checkbox-estados-2" value="2">
                                                            <span for="checkbox-estados-2">Ex colaborador</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Areas -->
                                            <div class="card">
                                                <div class="card-header" id="headingAreas">
                                                    <h5 class="mb-0">
                                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseAreas" aria-expanded="false" aria-controls="collapseAreas">
                                                            Áreas
                                                        </button>
                                                    </h5>
                                                </div>

                                                <div id="collapseAreas" class="collapse" aria-labelledby="headingAreas" data-parent="#accordionExample">
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <input type="checkbox" id="select-all-areas"><span> Seleccionar todos</span>
                                                        </div>
                                                        @foreach($areasAll as $index => $area)
                                                        <div class="form-check">
                                                            <input type="checkbox" id="checkbox-areas-{{$index}}" class="form-check-input area-checkbox" value="{{ $area->id }}">
                                                            <span for="checkbox-areas-{{$index}}">{{$area->especializacion}}</span>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Carreras -->
                                            <div class="card">
                                                <div class="card-header" id="headingCarreras">
                                                    <h5 class="mb-0">
                                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseCarreras" aria-expanded="false" aria-controls="collapseCarreras">
                                                            Carreras
                                                        </button>
                                                    </h5>
                                                </div>
                                                <div id="collapseCarreras" class="collapse" aria-labelledby="headingCarreras" data-parent="#accordionExample">
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <input type="checkbox" id="select-all-carreras"><span> Seleccionar todos</span>
                                                        </div>
                                                        @foreach($carrerasAll as $index => $carrera)
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input carrera-checkbox" value="{{ $carrera->id }}">
                                                            <span for="checkbox-carreras-{{$index}}">{{ $carrera->nombre }}</span>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Instituciones -->
                                            <div class="card">
                                                <div class="card-header" id="headingInstituciones">
                                                    <h5 class="mb-0">
                                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseInstituciones" aria-expanded="false" aria-controls="collapseInstituciones">
                                                            Instituciones
                                                        </button>
                                                    </h5>
                                                </div>
                                                <div id="collapseInstituciones" class="collapse" aria-labelledby="headingInstituciones" data-parent="#accordionExample">
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <input type="checkbox" id="select-all-instituciones"><span> Seleccionar todos</span>
                                                        </div>
                                                        @foreach($institucionesAll as $index => $institucion)
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input institucion-checkbox" value="{{ $institucion->id }}">
                                                            <span for="checkbox-instituciones-{{$index}}">{{ $institucion->nombre }}</span>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Submit Button -->
                                            <div class="text-center mt-4">
                                                <button type="submit" class="btn btn-primary px-5">Filtrar</button>
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
            @if(session('error'))
            <div id="alert-error" class="alert alert-danger alert-dismissible fade show d-flex align-items-start" role="alert" style="position: relative;">
                <div style="flex-grow: 1;">
                    <strong>Error:</strong> {{ session('error') }}
                </div>
                <button onclick="deleteAlertError()" type="button" class="btn btn-outline-dark btn-xs" style="position: absolute; top: 10px; right: 10px;" data-bs-dismiss="alert" aria-label="Close"><i class="fa fa-close"></i></button>
            </div>
            @endif
            <div class="row">
                @foreach($colaboradores->data as $index => $colaborador)
                <div id="modal-form-view{{$colaborador->id}}" class="modal fade" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="row">

                                    <div style='padding: 3px' class="col-sm-6 b-r">
                                        <h3 style="font-size: 1.1rem; font-weight: bold; border-bottom: 1px solid currentColor;" class="m-t-none m-b pb-1">Información Personal </h3>
                                        <style>
                                            .form-group {
                                                margin: 0rem;

                                            }
                                            p{
                                                margin: 0px;
                                            }
                                        </style>
                                        <div class="form-group">
                                            <p style='font-weight: bold; font-size: 1rem; margin: 0px; '>Nombres:</p>
                                            <p class="overflowing-skipt" style='font-size: 0.9rem;'>{{$colaborador->candidato->nombre}}</p>
                                        </div>
                                        <div class="form-group">
                                            <p style='font-weight: bold; font-size: 1rem; margin: 0px; ' class="m-t-none m-b">Apellidos:</p>
                                            <p class="overflowing-skipt" style='font-size: 0.9rem;'>{{$colaborador->candidato->apellido}}</p>
                                        </div>
                                        <div class="form-group">
                                            <p style='font-weight: bold; font-size: 1rem; margin: 0px; ' class="m-t-none m-b">Direccion:</p>
                                            <p class="overflowing-skipt" style='font-size: 0.9rem;'>{{$colaborador->candidato->direccion ?? 'Sin Direccion'}}</p>
                                        </div>
                                        <div class="form-group">
                                            <p style='font-weight: bold; font-size: 1rem; margin: 0px; ' class="m-t-none m-b">Institución - Sede:</p>
                                            <p class="overflowing-skipt" style='font-size: 0.9rem;'>{{$colaborador->candidato->sede->nombre ?? 'Sin Institucion - Sede'}}</p>
                                        </div>
                                        <div class="form-group">
                                            <p style='font-weight: bold; font-size: 1rem; margin: 0px; ' class="m-t-none m-b">Ciclo:</p>
                                            <p class="overflowing-skipt" style='font-size: 0.9rem;'>{{$colaborador->candidato->ciclo_de_estudiante ?? 'Sin ciclo'}}°</p>
                                        </div>
                                        <div class="form-group">
                                            <p style='font-weight: bold; font-size: 1rem; margin: 0px; ' class="m-t-none m-b">Correo:</p>
                                            <p class="overflowing-skipt" style='font-size: 0.9rem;'>{{$colaborador->candidato->correo ?? 'Sin correo'}}</p>
                                        </div>
                                        <div class="form-group">
                                            <p style='font-weight: bold; font-size: 1rem; margin: 0px; ' class="m-t-none m-b">Fecha de nacimiento:</p>
                                            <p class="overflowing-skipt" style='font-size: 0.9rem;'>{{$colaborador->candidato->fecha_nacimiento ?? 'Sin fecha de nacimiento'}}</p>
                                        </div>
                                        <div class="form-group">
                                            <p style='font-weight: bold; font-size: 1rem; margin: 0px; ' class="m-t-none m-b">DNI:</p>
                                            <p class="overflowing-skipt" style='font-size: 0.9rem;'>{{$colaborador->candidato->dni ?? 'Sin DNI'}}</p>
                                        </div>
                                        <div class="form-group">
                                            <p style='font-weight: bold; font-size: 1rem; margin: 0px; ' class="m-t-none m-b">Celular:</p>
                                            <p class="overflowing-skipt" style='font-size: 0.9rem;'>{{$colaborador->candidato->celular ?? 'Sin celular'}}</p>
                                        </div>
                                        <div class="form-group">
                                            <p style='font-weight: bold; font-size: 1rem; margin: 0px; ' class="m-t-none m-b">Área(s):</p>
                                            <ol class="custom-list">
                                            @foreach($colaborador->areas as $area)
                                                <li class="overflowing-skipt" style='font-size: 0.9rem;'>{{$area['nombre']}} @if($area['tipo'] === 1)(Apoyo) @endif</li>
                                            @endforeach
                                            </ol>
                                            
                                        </div>
                                        <div class="form-group">
                                            <p style='font-weight: bold; font-size: 1rem; margin: 0px; ' class="m-t-none m-b">Actividades favoritas:</p>
                                            <ol class="custom-list">
                                                @foreach($colaborador->actividadesFavoritas as $actividades)
                                                <li style='font-size: 0.9rem;' class="overflowing-skipt">{{$actividades}}</li>
                                                @endforeach
                                            </ol>
                                        </div>
                                        <div class="form-group">
                                            <p style='font-weight: bold; font-size: 1rem; margin: 0px; ' class="m-t-none m-b">Carrera:</p>
                                            <p class="overflowing-skipt" style='font-size: 0.9rem;'>{{$colaborador->candidato->carrera->nombre}}</p>
                                        </div>
                                        <div class="form-group">
                                            <p style='font-weight: bold; font-size: 1rem; margin: 0px; ' class="m-t-none m-b">Estado:</p>
                                            <p style='font-size: 0.9rem;'>
                                                @if ($colaborador->estado == 1)
                                                <span style="color: green"><strong>Activo</strong></span>

                                                @else
                                                <span style="color: #F00"><strong>Inactivo</strong></span>
                                                @endif
                                            </p></div>
                                        <div>
                                            {{-- editar colaborador--}}
                                            <a data-toggle="modal" id="editButton{{ $colaborador->id }}"
                                                class="btn btn-sm btn-primary float-right m-t-n-xs fa fa-edit btn-success"
                                                onclick="abrirModalEdicion({{$colaborador->id}});"
                                                style="font-size: 20px; width: 60px;"
                                                href="#modal-form-update{{$colaborador->id}}"></a>

                                        </div>
                                    </div>
                                    <div class="col-sm-6 text-center text-danger">
                                        <h2><strong> Colaborador </strong></h2>
                                        <a style="color: black;"><strong>{{$colaborador->id}}</strong></a>
                                        <div class="custom-file w-200 h-300 " style="padding: 20px 0px;">
                                            <img src="{{asset('storage/candidatos/'.$colaborador->candidato->icono)}}"
                                                class="img-lg  max-min-h-w-200 img-cover">

                                        </div>
                                        <div style="display: flex; gap:2px">
                                            {{-- Redirección a computadora --}}
                                            <form id="getComputadoraColab{{$colaborador->id}}"
                                                action="{{route('colaboradores.getComputadora', $colaborador->id)}}">
                                            </form>
                                            <a href="#" class="btn btn-primary btn-success fa fa-desktop"
                                                style="width: 100px; font-size: 18px;"
                                                onclick="document.getElementById('getComputadoraColab{{$colaborador->id}}').submit();">
                                            </a>

                                            {{-- Redirección a préstamo --}}
                                            <form id="getPrestamoColab{{$colaborador->id}}" action="{{route('colaboradores.getPrestamo', $colaborador->id)}}">
                                            </form>
                                            <a data-toggle="modal" class="btn btn-primary btn-success fa fa-dropbox"
                                                style="width: 100px; font-size: 18px;" href="#" onclick="document.getElementById('getPrestamoColab{{$colaborador->id}}').submit();"></a>
                                        </div>

                                        <div class="mt-2">
                                            <form role="form" method="POST" action="{{route('colaboradores.despedirColaborador', $colaborador->id)}}">
                                                @csrf
                                                @method('PUT')
                                                @isset($pageData->currentURL)
                                                <input type="hidden" name="currentURL" value="{{ $pageData->currentURL }}">
                                                @endisset
                                                <button class="btn btn-danger">Despedir</button>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <style>
                    /* .product-box {
                        display: flex;
                        flex-direction: column;
                        height: 100%;
                    }
                
                    .product-name h2 {
                        font-size: 1.5rem;
                        margin: 0;
                        overflow: hidden;
                        text-overflow: ellipsis;
                        white-space: nowrap;
                    }
                
                    .product-desc h5 {
                        font-size: 1rem;
                        margin: 0;
                        overflow: hidden;
                        text-overflow: ellipsis;
                        white-space: nowrap;
                    } */

                    .overflowing-text{
                        margin: 0;
                        overflow: hidden;
                        text-overflow: ellipsis;
                        white-space: nowrap;
                    }

                    .overflowing-skipt{
                        word-wrap: break-word; /* Permite que las palabras largas se rompan y continúen en la siguiente línea */
                        overflow-wrap: break-word; /* Asegura que las palabras largas se rompan en navegadores más modernos */
                        white-space: normal;/* Permite el salto de línea normal */
                    }
                    ol.custom-list {
                        list-style-position: inside; /* Esto coloca los números dentro del contenedor, evitando el sangrado */
                        padding-left: 0; /* Elimina el relleno a la izquierda del <ol> */
                        margin-left: 0; /* Elimina el margen a la izquierda del <ol> */
                    }

                    ol.custom-list li {
                        margin: 0; /* Elimina el margen de los elementos <li> */
                        padding-left: 0; /* Opcional: Agrega un poco de espacio a la izquierda para el número, si es necesario */
                    }
                
                    /* .text-center {
                        text-align: center;
                    }
                
                    .text-left {
                        text-align: left;
                    }
                
                    .small {
                        font-size: 0.875rem;
                    }
                
                    .product-desc {
                        flex: 1;
                    }
                
                    .product-box img {
                        max-width: 100%;
                        height: auto;
                    }
                
                    .ibox-content {
                        padding: 1rem;
                        box-sizing: border-box;
                    }
                
                    .btn {
                        margin: 0.5rem;
                    } */
                </style>
                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 ">
                    <div style="" class="ibox">
                        <div class="ibox-content product-box">
                            <div class="text-center rounded-circle">
                                <img src="{{asset('storage/candidatos/'.$colaborador->candidato->icono)}}"
                                    class="rounded-circle max-min-h-w-200 p-a-10 img-cover">
                            </div>
                            <div class="product-desc">
                                @if($colaborador->estado != 2)
                                <span class="product-price btn-Default" style="background-color: transparent;">
                                    <form method="POST" action="{{ route('colaboradores.activarInactivar', ["colaborador_id"=> $colaborador->id]) }}">
                                        @csrf
                                        @isset($pageData->currentURL)
                                        <input type="hidden" name="currentURL" value="{{ $pageData->currentURL }}">
                                        @endisset

                                        <button type="submit"
                                            class="btn btn-{{ $colaborador->estado ? 'outline-success' : 'danger' }} btn-primary dim btn-xs">
                                            <span>{{ $colaborador->estado ? 'Activo' : 'Inactivo' }}</span>
                                        </button>
                                    </form>
                                </span>
                                @else
                                <h3 class="text-danger font-weight-bold">Ex Colaborador</h3>
                                @endif


                                <div href="#" class="product-name">
                                    <h2 class="overflowing-text" >{{$colaborador->candidato->nombre." ".$colaborador->candidato->apellido}}</h2>
                                </div>



                                <small class="text-muted text-left">
                                    <h3 class="text-dark" >Área(s):</h3>
                                </small>
                                <div class="small m-t-xs text-left">
                                    <h5 class="overflowing-text">
                                    @foreach($colaborador->areas as $index => $area)
                                    @if($index > 0) | @endif {{$area['nombre']}} @if($area['tipo'] === 1) <span style="color: #007">(Apoyo)</span>@endif
                                    @endforeach
                                    </h5>
                                </div>
                                <small class="text-muted text-left">
                                    <h3 class="text-dark">DNI:</h3>
                                </small>
                                <div class="small m-t-xs text-left">
                                    <h5 class="overflowing-text">{{$colaborador->candidato->dni ?? 'Sin DNI'}}</h5>
                                </div>
                                <small class="text-muted text-left">
                                    <h3 class="text-dark">Correo:</h3>
                                </small>
                                <div class="small m-t-xs text-left">
                                    <h5 class="overflowing-text">{{$colaborador->candidato->correo ?? 'Sin correo'}}</h5>
                                </div>
                                <small class="text-muted text-left">
                                    <h3 class="text-dark">Celular:</h3>
                                </small>
                                <div class="small m-t-xs text-left">
                                    <h5 class="overflowing-text">{{$colaborador->candidato->celular ?? 'Sin celular'}}</h5>
                                </div>
                                <div class="m-t text-righ">

                                    <a href="#" data-toggle="model"> <i></i> </a>
                                    <form id="horario-clase-{{$colaborador->id}}" role="form" method="GET"
                                        action="{{route('colaboradores.horarioClase', $colaborador->id)}}">
                                    </form>
                                    <div class="ibox-content">
                                        @if($colaborador->estado != 2)
                                        <div class="text-center">
                                            {{-- Botón calendario colaborador --}}
                                            <button data-toggle="modal" class="btn btn-primary fa fa-clock-o"
                                                style="font-size: 20px;"
                                                onclick="document.getElementById('horario-clase-{{$colaborador->id}}').submit();"></button>

                                            {{-- Botón ver colaborador --}}
                                            <button data-toggle="modal" class="btn btn-primary btn-success fa fa-eye"
                                                style="font-size: 20px;"
                                                href="#modal-form-view{{$colaborador->id}}"></button>
                                        </div>
                                        {{-- MODAL UPDATE --}}
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
                                                            {{-- Campo oculto para identificar el tipo de formulario --}}
                                                            <input type="hidden" name="form_type" value="edit">
                                                            <input type="hidden" name="colaborador_id" value="{{ $colaborador->id }}">

                                                            <style>
                                                                .form-group {
                                                                    margin-bottom: 0rem;
                                                                }
                                                            </style>
                                                            @isset($pageData->currentURL)
                                                            <input type="hidden" name="currentURL"
                                                                value="{{ $pageData->currentURL }}">
                                                            @endisset
                                                            <div class="row">
                                                                <div class="col-sm-4 b-r">
                                                                    <h3 class="m-t-none m-b">Informacion Personal
                                                                    </h3>
                                                                    <div class="form-group"><label>
                                                                            <h5 class="m-t-none">Nombres:</h5>
                                                                        </label><input type="text" placeholder="....."
                                                                            class="form-control" name="nombre"
                                                                            id="nombre"
                                                                            value="{{ $colaborador->candidato->nombre }}">
                                                                            @error('nombre'.$colaborador->id)
                                                                            <span class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                    </div>
                                                                    <div class="form-group"><label>
                                                                            <h5 class="m-t-none">Apellidos:</h5>
                                                                        </label><input type="text" placeholder="....."
                                                                            class="form-control" name="apellido"
                                                                            id="apellido"
                                                                            value="{{ $colaborador->candidato->apellido }}">
                                                                            @error('apellido'.$colaborador->id)
                                                                            <span class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                    </div>
                                                                    <div class="form-group"><label>
                                                                            <h5 class="m-t-none">Direccion:</h5>
                                                                        </label><input type="text" placeholder="....."
                                                                            class="form-control" name="direccion"
                                                                            id="direccion"
                                                                            value="{{  $colaborador->candidato->direccion }}">
                                                                            @error('direccion'.$colaborador->id)
                                                                            <span class="text-danger">{{ $message }}</span>
                                                                            @enderror
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
                                                                        </label>
                                                                        <select name="ciclo_de_estudiante"
                                                                            class="form-control">
                                                                            @for($i = 4; $i <= 10; $i++) <option
                                                                                @if($i==$colaborador->
                                                                                candidato->ciclo_de_estudiante) selected
                                                                                @endif >{{$i}}</option>
                                                                                @endfor

                                                                        </select>

                                                                    </div>
                                                                    <div class="form-group"><label>
                                                                            <h5 class="m-t-none">Correo:</h5>
                                                                        </label><input type="text" placeholder="....."
                                                                            class="form-control" name="correo"
                                                                            id="correo"
                                                                            value="{{ $colaborador->candidato->correo }}">
                                                                            @error('correo'.$colaborador->id)
                                                                            <span class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>
                                                                            <h5 class="m-t-none">Actividades favoritas:</h5>
                                                                        </label>
                                                                        <select name="actividades_id[]" multiple
                                                                            class="form-control multiple_actividades_select">
                                                                            @foreach ($Allactividades as $actividad)
                                                                            <option value="{{ $actividad->id }}"
                                                                                @foreach($colaborador->actividadesFavoritas as $actividadNombre)
                                                                                @if($actividad->nombre ==
                                                                                $actividadNombre)
                                                                                selected
                                                                                @endif
                                                                                @endforeach
                                                                                >
                                                                                {{ $actividad->nombre }}</option>
                                                                            @endforeach
                                                                        </select>
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
                                                                            value="{{ $colaborador->candidato->fecha_nacimiento }}">
                                                                    </div>
                                                                    <div class="form-group"><label>
                                                                            <h5 class="m-t-none">DNI:</h5>
                                                                        </label><input type="text" placeholder="....."
                                                                            class="form-control" name="dni" id="dni"
                                                                            value="{{$colaborador->candidato->dni}}"></input>
                                                                            @error('dni'.$colaborador->id)
                                                                            <span class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                    </div>
                                                                    <div class="form-group"><label>
                                                                            <h5 class="m-t-none">Celular:</h5>
                                                                        </label><input type="text" placeholder="....."
                                                                            class="form-control" name="celular"
                                                                            id="celular"
                                                                            value="{{ $colaborador->candidato->celular }}">
                                                                            @error('celular'.$colaborador->id)
                                                                            <span class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label>
                                                                            <h5 class="m-t-none">Área(s):</h5>
                                                                        </label>
                                                                        <select name="areas_id[]" multiple
                                                                            class="form-control multiple_areas_select">
                                                                            @foreach ($areas as $key => $area)
                                                                            <option value="{{ $area->id }}"
                                                                                @foreach($colaborador->areas as $areaNombre)
                                                                                    @if($areaNombre['tipo'] === 0)
                                                                                        @if($area->especializacion ==
                                                                                        $areaNombre['nombre'])
                                                                                        selected
                                                                                        @endif
                                                                                    @endif
                                                                                @endforeach
                                                                                >
                                                                                {{ $area->especializacion }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>
                                                                            <h5 class="m-t-none">Área(s) Apoyo:</h5>
                                                                        </label>
                                                                        <select name="areas_apoyo_id[]" multiple
                                                                            class="form-control multiple_apoyo_select">
                                                                            @foreach ($areas as $key => $area)
                                                                            <option value="{{ $area->id }}"
                                                                                @foreach($colaborador->areas as $areaNombre)
                                                                                    @if($areaNombre['tipo'] === 1)
                                                                                        @if($area->especializacion ==
                                                                                        $areaNombre['nombre'])
                                                                                        selected
                                                                                        @endif
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
                                                                        @error('icono'.$colaborador->id)
                                                                        <span class="text-danger">{{ $message }}</span>
                                                                    @enderror
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
                                                                            href="" onclick="document.getElementById('getPrestamoColab{{$colaborador->id}}').submit();"></a>
                                                                    </div>

                                                                </div>

                                                            </div>
                                                        </form>



                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @else
                                        <div class="text-center d-flex justify-content-center gap-10">
                                            <form role="form" method="POST" action="{{route('colaboradores.recontratarColaborador', $colaborador->id)}}">
                                                @csrf
                                                @method('PUT')
                                                @isset($pageData->currentURL)
                                                <input type="hidden" name="currentURL" value="{{ $pageData->currentURL }}">
                                                @endisset
                                                <button class="btn btn-success" type="submit">
                                                    Re Contratar
                                                </button>
                                            </form>
                                            <button class="btn btn-danger" type="button" onclick="confirmDelete({{ $colaborador->id }}, '{{ $pageData->currentURL }}')">
                                                Eliminar
                                            </button>
                                        </div>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>


            @if($hasPagination === true)
            <div class="row mb-5 mb-md-4">
                <div
                    class="col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-start align-items-center gap-10 my-3">
                    @if($pageData->lastPage > 2 && $pageData->currentPage !== 1)
                    <a href="{{ $colaboradores->url(1) }}" class="btn btn-outline-dark rounded-5">
                        <i class="fa fa-arrow-circle-left"></i> First
                    </a>
                    @endif
                    @if($pageData->currentPage > 1)
                    <a href="{{$pageData->previousPageUrl}}" class="btn btn-outline-dark rounded-5">
                        <i class="fa fa-arrow-circle-left"></i> Anterior
                    </a>
                    @endif
                </div>
                <div
                    class="col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end align-items-center gap-10">
                    @if($pageData->currentPage < $pageData->lastPage)
                        <a href="{{ $pageData->nextPageUrl }}" class="btn btn-outline-dark rounded-5">
                            Siguiente <i class="fa fa-arrow-circle-right"></i>
                        </a>
                        @endif
                        @if($pageData->lastPage > 2 && $pageData->currentPage !== $pageData->lastPage)
                        <a href="{{ $pageData->lastPageUrl }}" class="btn btn-outline-dark rounded-5">
                            Last <i class="fa fa-arrow-circle-right"></i>
                        </a>
                        @endif
                </div>
            </div>
            @endif


        </div>




        @include('components.inspinia.footer-inspinia')
    </div>



    </div>
<!-- Script para manejar los errores globalmente -->
<script>
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            console.error("Error: {{ $error }}");
        @endforeach
    @endif
</script>

 {{-- MODAL SCRIPT --}}
    @if ($errors->any())
        <script>
            console.log(@json($errors->all())); // Muestra todos los errores en la consola
            document.addEventListener('DOMContentLoaded', function() {
                @if (old('form_type') == 'edit' && old('colaborador_id'))
                $('#modal-form-update' + {{ old('colaborador_id') }}).modal('show');
                @endif
            });
        </script>
    @endif






    <style>
        .select2-container.select2-container--default.select2-container--open {
            z-index: 9999 !important;
            width: 100% !important;
        }


        .select2-container {
            display: inline !important;
        }


    </style>
    <script src="{{asset('js/inspiniaViewsJS/indexColaboradores.js')}}"></script>
    {{-- <script>
        const deleteAlertError = () => {
            let alertError = document.getElementById('alert-error');
            if (alertError) {
                alertError.remove();
            } else{
                console.error("Elemento con ID 'alert-error' no encontrado.");
            }
        }
        document.addEventListener('DOMContentLoaded', function() {
            const personal = document.getElementById('personalCont');
            if (personal) {
                personal.classList.add('active');
            } else {
                console.error("El elemento con el id 'personalCont' no se encontró en el DOM.");
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
                modal.classList.add('show');
            }
        }

        function abrirModalEdicion(id) {
            hideModal('modal-form-view' + id);
            showModal('modal-form-update' + id);
        }

      

        function prepareSearchActionURL(event) {
            // preventDefault();

            let busqueda = document.getElementById('searchInput').value;

            if(busqueda.trim().length > 0){
                console.log(busqueda);

                let actionUrl = `{{ url('colaboradores/search/${busqueda}') }}`;
                console.log(actionUrl);
                document.querySelector('#searchColaboradores').action = actionUrl;

                return true;
            } else{
                event.preventDefault();
                return false;
            }

        }

        function prepareFilterActionURL() {
            let estados = Array.from(document.querySelectorAll('.estado-checkbox:checked')).map(cb => cb.value);
            let areas = Array.from(document.querySelectorAll('.area-checkbox:checked')).map(cb => cb.value);
            let carreras = Array.from(document.querySelectorAll('.carrera-checkbox:checked')).map(cb => cb.value);
            let instituciones = Array.from(document.querySelectorAll('.institucion-checkbox:checked')).map(cb => cb.value);

            estados = estados.length ? estados.join(',') : '0,1,2';
            areas = areas.length ? areas.join(',') : '';
            carreras = carreras.length ? carreras.join(',') : '';
            instituciones = instituciones.length ? instituciones.join(',') : '';

            if(estados != null && areas != null && carreras != null && instituciones != null){
                let actionUrl = `{{ url('colaboradores/filtrar/estados=${estados}/areas=${areas}/carreras=${carreras}/instituciones=${instituciones}') }}`;
                console.log(actionUrl);
                document.querySelector('#filtrarColaboradores').action = actionUrl;

                return true;
            }

        }

        document.getElementById('select-all-estados').addEventListener('change', function() {
            let checkboxes = document.querySelectorAll('.estado-checkbox');
            checkboxes.forEach(cb => cb.checked = this.checked);
        });

        document.getElementById('select-all-areas').addEventListener('change', function() {
            let checkboxes = document.querySelectorAll('.area-checkbox');
            checkboxes.forEach(cb => cb.checked = this.checked);
        });
        document.getElementById('select-all-carreras').addEventListener('change', function() {
            let checkboxes = document.querySelectorAll('.carrera-checkbox');
            checkboxes.forEach(cb => cb.checked = this.checked);
        });

        document.getElementById('select-all-instituciones').addEventListener('change', function() {
            let checkboxes = document.querySelectorAll('.institucion-checkbox');
            checkboxes.forEach(cb => cb.checked = this.checked);
        });






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
        $(document).ready(function() {
            $('.multiple_apoyo_select').select2();
        });
        $(document).ready(function() {
            $('.multiple_actividades_select').select2();
        });
    </script> --}}
</body>

</html>
