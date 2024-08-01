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
                    {{-- <form method="POST" action="{{route('colaboradores.search')}}"
                        class="flex-centered gap-20 spc-per-100">
                        <input class="form-control wdt-per-80" type="search" name="busqueda"
                            placeholder="Buscar Colaborador..." aria-label="Search">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                    </form> --}}
                    <form id="searchColaboradores" role="form" method="GET" action="" enctype="multipart/form-data" onsubmit="return prepareSearchActionURL()"
                        class="flex-centered gap-20 spc-per-100">
                        <input id="searchInput" class="form-control wdt-per-80" type="search"
                            placeholder="Buscar Colaborador..." aria-label="Search">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
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
                                            <p style='font-size: 0.9rem;'>{{$colaborador->candidato->nombre}}</p>
                                        </div>
                                        <div class="form-group">
                                            <p style='font-weight: bold; font-size: 1rem; margin: 0px; ' class="m-t-none m-b">Apellidos:</p>
                                            <p style='font-size: 0.9rem;'>{{$colaborador->candidato->apellido}}</p>
                                        </div>
                                        <div class="form-group">
                                            <p style='font-weight: bold; font-size: 1rem; margin: 0px; ' class="m-t-none m-b">Direccion:</p>
                                            <p style='font-size: 0.9rem;'>{{$colaborador->candidato->direccion}}</p>
                                        </div>
                                        <div class="form-group">
                                            <p style='font-weight: bold; font-size: 1rem; margin: 0px; ' class="m-t-none m-b">Institución - Sede:</p>
                                            <p style='font-size: 0.9rem;'>{{$colaborador->candidato->sede->nombre}}</p>
                                        </div>
                                        <div class="form-group">
                                            <p style='font-weight: bold; font-size: 1rem; margin: 0px; ' class="m-t-none m-b">Ciclo:</p>
                                            <p style='font-size: 0.9rem;'>{{$colaborador->candidato->ciclo_de_estudiante}}°</p>
                                        </div>
                                        <div class="form-group">
                                            <p style='font-weight: bold; font-size: 1rem; margin: 0px; ' class="m-t-none m-b">Correo:</p>
                                            <p style='font-size: 0.9rem;'>{{$colaborador->candidato->correo}}</p>
                                        </div>
                                        <div class="form-group">
                                            <p style='font-weight: bold; font-size: 1rem; margin: 0px; ' class="m-t-none m-b">Fecha de nacimiento:</p>
                                            <p style='font-size: 0.9rem;'>{{$colaborador->candidato->fecha_nacimiento}}</p>
                                        </div>
                                        <div class="form-group">
                                            <p style='font-weight: bold; font-size: 1rem; margin: 0px; ' class="m-t-none m-b">DNI:</p>
                                            <p style='font-size: 0.9rem;'>{{$colaborador->candidato->dni}}</p>
                                        </div>
                                        <div class="form-group">
                                            <p style='font-weight: bold; font-size: 1rem; margin: 0px; ' class="m-t-none m-b">Celular:</p>
                                            <p style='font-size: 0.9rem;'>{{$colaborador->candidato->celular}}</p>
                                        </div>
                                        <div class="form-group">
                                            <p style='font-weight: bold; font-size: 1rem; margin: 0px; ' class="m-t-none m-b">Área(s):</p>
                                            @foreach($colaborador->areas as $area)
                                            <p style='font-size: 0.9rem;' class=''>{{$area}}</p>
                                            @endforeach
                                        </div>
                                        <div class="form-group">
                                            <p style='font-weight: bold; font-size: 1rem; margin: 0px; ' class="m-t-none m-b">Actividades favoritas:</p>
                                            @foreach($colaborador->actividadesFavoritas as $actividades)
                                            <p style='font-size: 0.9rem;' class=''>{{$actividades}}</p>
                                            @endforeach
                                        </div>
                                        <div class="form-group">
                                            <p style='font-weight: bold; font-size: 1rem; margin: 0px; ' class="m-t-none m-b">Carrera:</p>
                                            <p style='font-size: 0.9rem;'>{{$colaborador->candidato->carrera->nombre}}</p>
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
                                            <a data-toggle="modal"
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
                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 ">
                    <div class="ibox">
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
                                        @if($colaborador->estado != 2)
                                        <div class="text-center">
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
                                                                        </label>
                                                                        <select name="ciclo_de_estudiante"
                                                                            class="form-control" required>
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
                                                                            @foreach ($areas as $key => $area)
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

            {{-- <div class="row mb-4">
                <div class="col-6 d-flex justify-content-start align-items-center gap-10">
                    @if($colaboradores->lastPag > 2 && $colaboradores->currentPage() !== 1)
                    <a href="{{ $colaboradores->url(1) }}" class="btn btn-outline-dark rounded-5"><i
                            class="fa fa-arrow-circle-left"></i> First</a>
                    @endif
                    @if($colaboradores->currentPage() > 1)
                    <a href="{{$colaboradores->previousPageUrl()}}" class="btn btn-outline-dark rounded-5"> <i
                            class="fa fa-arrow-circle-left"></i> Anterior </a>
                    @endif
                </div>
                <div class="col-6 d-flex justify-content-end align-items-center gap-10">
                    @if($colaboradores->currentPage() < $colaboradores->lastPage())
                        <a href="{{ $colaboradores->nextPageUrl() }}" class="btn btn-outline-dark rounded-5"> Siguiente
                            <i class="fa fa-arrow-circle-right"></i></a>
                        @endif
                        @if($colaboradores->lastPage() > 2 && $colaboradores->currentPage() !==
                        $colaboradores->lastPage())
                        <a href="{{ $colaboradores->url($colaboradores->lastPage()) }}"
                            class="btn btn-outline-dark rounded-5">Last <i class="fa fa-arrow-circle-right"></i></a>
                        @endif
                </div>
            </div> --}}
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

        function confirmDelete(id, currentURL) {
            alertify.confirm("¿Deseas eliminar este registro? Esta acción es permanente y eliminará todo lo relacionado a este colaborador", function(e) {
                if (e) {
                    let form = document.createElement('form')

                    form.method = 'POST'
                    form.action = `/colaboradores/${id}`
                    form.innerHTML = '@csrf @method('DELETE')'

                    if(currentURL != null){
                        let inputHidden = document.createElement('input');
                        inputHidden.type = 'hidden';
                        inputHidden.name = 'currentURL';
                        inputHidden.value = currentURL;
                        form.appendChild(inputHidden)
                    }

                    document.body.appendChild(form)
                    form.submit()
                } else {
                    return false
                }
            });
        }

        function prepareSearchActionURL() {
            let busqueda = document.getElementById('searchInput').value;

            let actionUrl = `{{ url('colaboradores/search/${busqueda}') }}`;
            console.log(actionUrl);
            document.querySelector('#searchColaboradores').action = actionUrl;

            return true;
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

            let actionUrl = `{{ url('colaboradores/filtrar/estados=${estados}/areas=${areas}/carreras=${carreras}/instituciones=${instituciones}') }}`;
            console.log(actionUrl);
            document.querySelector('#filtrarColaboradores').action = actionUrl;

            return true;
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
            $('.multiple_actividades_select').select2();
        });
    </script>
</body>

</html>
