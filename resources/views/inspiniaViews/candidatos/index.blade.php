<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inspina|Candidatos</title>
</head>

<body>
    <div id="wrapper">
        @include('components.inspinia.side_nav_bar-inspinia')

        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-3">
                <h2>Candidatos</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="/dashboard">Inicio</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a>Personal</a>
                    </li>
                    <li class="breadcrumb-item active">
                        <strong>Candidatos</strong>
                    </li>
                </ol>
            </div>
            <div class="col-lg-7 flex-centered">
                <div class="flex-centered spc-per-90">
                    <form id="searchCandidatos" role="form" method="GET" action="" enctype="multipart/form-data" onsubmit="return prepareSearchActionURL(event)"
                        class="flex-centered gap-20 spc-per-100">
                        <input id="searchInput" class="form-control wdt-per-80" type="search"
                            placeholder="Buscar Candidato..." aria-label="Search" required autocomplete="off">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
                    </form>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="py-3">
                    {{-- abrir modal agregar --}}
                    <button class="btn btn-success dim float-right" href="#modal-form-add" data-toggle="modal"
                        type="button">Agregar</button>
                    <button data-toggle="modal" class="btn btn-primary dim float-right" href="#modal-filtrar"> Filtrar </button>
                </div>
                <div id="modal-filtrar" class="modal fade" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body">

                                <form id="filtrarCandidatos" role="form" method="GET" action="" enctype="multipart/form-data" onsubmit="return prepareFilterActionURL()">
                                    <h2 class="m-t-none m-b font-bold text-center">Filtrar Candidatos</h2>
                                    <div class="accordion" id="accordionExampleCandidatos">
                                        <!-- Estados -->
                                        <div class="card">
                                            <div class="card-header" id="headingEstadosCandidatos">
                                                <h5 class="mb-0">
                                                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseEstadosCandidatos" aria-expanded="true" aria-controls="collapseEstadosCandidatos">
                                                        Estados
                                                    </button>
                                                </h5>
                                            </div>
                                            <div id="collapseEstadosCandidatos" class="collapse show" aria-labelledby="headingEstadosCandidatos" data-parent="#accordionExampleCandidatos">
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <input type="checkbox" id="select-all-estados"><span> Seleccionar todos</span>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input estado-checkbox" id="checkbox-estados-candidatos-1" value="1">
                                                        <span for="checkbox-estados-candidatos-1">Pendiente</span>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input estado-checkbox" id="checkbox-estados-candidatos-0" value="0">
                                                        <span for="checkbox-estados-candidatos-0">Colaborador</span>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input estado-checkbox" id="checkbox-estados-candidatos-2" value="2">
                                                        <span for="checkbox-estados-candidatos-2">Rechazado</span>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input estado-checkbox" id="checkbox-estados-candidatos-3" value="3">
                                                        <span for="checkbox-estados-candidatos-3">Ex colaborador</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Carreras -->
                                        <div class="card">
                                            <div class="card-header" id="headingCarrerasCandidatos">
                                                <h5 class="mb-0">
                                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseCarrerasCandidatos" aria-expanded="false" aria-controls="collapseCarrerasCandidatos">
                                                        Carreras
                                                    </button>
                                                </h5>
                                            </div>
                                            <div id="collapseCarrerasCandidatos" class="collapse" aria-labelledby="headingCarrerasCandidatos" data-parent="#accordionExampleCandidatos">
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <input type="checkbox" id="select-all-carreras"><span> Seleccionar todos</span>
                                                    </div>
                                                    @foreach($carrerasAll as $index => $carrera)
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input carrera-checkbox" id="checkbox-carreras-candidatos-{{ $index }}" value="{{ $carrera->id }}">
                                                        <span for="checkbox-carreras-candidatos-{{ $index }}">{{ $carrera->nombre }}</span>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Ciclos -->
                                            <div class="card">
                                                <div class="card-header" id="headingCiclosCandidatos">
                                                    <h5 class="mb-0">
                                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                                                        data-target="#collapseCiclosCandidatos" aria-expanded="false" aria-controls="collapseCiclosCandidatos">
                                                            Ciclos
                                                        </button>
                                                    </h5>
                                                </div>
                                                <div id="collapseCiclosCandidatos" class="collapse" aria-labelledby="headingCiclosCandidatos"
                                                    data-parent="#accordionExampleCandidatos">
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <input type="checkbox" id="select-all-ciclos"><span> Seleccionar todos</span>
                                                        </div>
                                                        @foreach($ciclosAll as $index => $ciclo)
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input ciclo-checkbox"
                                                            id="checkbox-ciclo-candidatos-{{ $ciclo }}" value="{{ $ciclo }}">
                                                            <span for="checkbox-ciclo-candidatos-{{ $ciclo }}">Ciclo {{ $ciclo }}</span>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>

                                        <!-- Instituciones -->
                                        <div class="card">
                                            <div class="card-header" id="headingInstitucionesCandidatos">
                                                <h5 class="mb-0">
                                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseInstitucionesCandidatos" aria-expanded="false" aria-controls="collapseInstitucionesCandidatos">
                                                        Instituciones
                                                    </button>
                                                </h5>
                                            </div>
                                            <div id="collapseInstitucionesCandidatos" class="collapse" aria-labelledby="headingInstitucionesCandidatos" data-parent="#accordionExampleCandidatos">
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <input type="checkbox" id="select-all-instituciones"><span> Seleccionar todos</span>
                                                    </div>
                                                    @foreach($institucionesAll as $index => $institucion)
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input institucion-checkbox" id="checkbox-instituciones-candidatos-{{ $index }}" value="{{ $institucion->id }}">
                                                        <span for="checkbox-instituciones-candidatos-{{ $index }}">{{ $institucion->nombre }}</span>
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
                {{-- MODAL STORE --}}
                <div id="modal-form-add" class="modal fade" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body">
                                <form role="form" method="POST" action="{{ route('candidatos.store') }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="form_type" value="create">

                                    @isset($pageData->currentURL)
                                        <input type="hidden" name="currentURL" value="{{ $pageData->currentURL }}">
                                    @endisset
                                    <div class="row">
                                        <div class="col-sm-6 b-r">
                                            <h3 class="m-t-none m-b">Ingrese los Datos</h3>
                                            <div class="form-group"><label>Nombre</label>
                                                <input type="text" placeholder="Ingrese un nombre"  autocomplete="off" class="form-control" name="nombre" value="{{ old('nombre') }}">
                                                @error('nombre')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group"><label>Apellido</label> <input type="text"
                                                    placeholder="Ingrese apellido" class="form-control" name="apellido" value="{{ old('apellido')}}"
                                                     autocomplete="off">
                                                    @error('apellido')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                            </div>
                                            <div class="form-group">
                                                <label>DNI</label>
                                                <div class="position-relative">
                                                    <input type="number" id="dni-store" placeholder="Ingrese dni" class="form-control" name="dni" autocomplete="off" oninput="limitDNI(this)">
                                                    <span id="dni-counter-store" class="position-absolute" style="right: 10px; top: 50%; transform: translateY(-50%); font-size: 0.9rem; color: gray;">0/8</span>
                                                </div>
                                                @error('dni')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            

                                            <style>
                                                /* Quitar los controles de incremento y decremento en los navegadores */
                                                input[type="number"]::-webkit-outer-spin-button,
                                                input[type="number"]::-webkit-inner-spin-button {
                                                    -webkit-appearance: none;
                                                    margin: 0;
                                                }

                                                input[type="number"] {
                                                    -moz-appearance: textfield; /* Para Firefox */
                                                }
                                            </style>

                                            <div class="form-group">
                                                <label>Dirección</label>
                                                <input type="text"
                                                    placeholder="Ingrese dirección" class="form-control"
                                                    name="direccion" value="{{ old('direccion')}}" autocomplete="off">

                                                    @error('direccion')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                            </div>

                                            <div class="form-group"><label>Fecha de Nacimiento</label> <input
                                                    type="date" class="form-control" name="fecha_nacimiento" value="{{ old('fecha_nacimiento')}}" autocomplete="off">
                                            </div>
                                            <div class="form-group"><label>Ciclo de Estudiante</label>
                                                <select name="ciclo_de_estudiante" class="form-control" >
                                                    @for($i = 4; $i <= 10; $i++)
                                                        <option value="{{ $i }}"
                                                            @if($i == old('ciclo_de_estudiante')) selected @endif>
                                                            {{ $i }}
                                                        </option>
                                                    @endfor
                                                </select>
                                                @error('ciclo_de_estudiante')
                                                        <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>


                                        </div>
                                        <div class="col-sm-6">
                                            <h4>Subir Icono</h4>
                                            <input type="file" class="form-control-file" id="icono" name="icono" value="{{ old('icono')}}"
                                                style="display: none;">
                                            <button type="button" class="btn btn-link" id="icon-upload">
                                                <i class="fa fa-cloud-download big-icon"></i>
                                            </button>
                                            @error('icono')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                            <div class="form-group"><label>Institucion - Sede</label>
                                                <select class="form-control" name="sede_id" >
                                                    @foreach($sedes as $sede)
                                                        <option value="{{ $sede->id }}"
                                                            @if($sede->id == old('sede_id')) selected @endif>
                                                            {{ $sede->nombre }}
                                                        </option>
                                                    @endforeach

                                                </select>
                                                @error('sede_id')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group"><label>Carrera</label>
                                                <select class="form-control" name="carrera_id" >
                                                    @foreach($carreras as $carrera)
                                                        <option value="{{ $carrera->id }}"
                                                            @if($carrera->id == old('carrera_id')) selected @endif>
                                                            {{ $carrera->nombre }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('carrera_id')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group"><label>Correo</label> <input type="email"
                                                    placeholder="correo@gmail.com" class="form-control" name="correo" value="{{old('correo')}}">
                                                    @error('correo')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                            </div>

                                            <div class="form-group">
                                                <label>Celular</label> 
                                               <div class="position-relative">
                                                    <input type="number" id="cel-store"
                                                    placeholder="Ingrese celular" class="form-control" name="celular" oninput="limitCel(this)">
                                                    <span id="cel-counter-store" class="position-absolute" style="right: 10px; top: 50%; transform: translateY(-50%); font-size: 0.9rem; color: gray;">0/9</span>
                                                    @error('celular')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                               </div>
                                            </div>

                                          
                                        </div>
                                      
                                        <div>
                                            <button class="btn btn-primary btn-sm m-t-n-xs float-right" type="submit" ><i
                                                    class="fa fa-check"></i>&nbsp;Confirmar
                                            </button>
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
            @if(session('error'))
            <div id="alert-error" class="alert alert-danger alert-dismissible fade show d-flex align-items-start" role="alert" style="position: relative;">
                <div style="flex-grow: 1;">
                    <strong>Error:</strong> {{ session('error') }}
                </div>
                <button onclick="deleteAlertError()" type="button" class="btn btn-outline-dark btn-xs" style="position: absolute; top: 10px; right: 10px;" data-bs-dismiss="alert" aria-label="Close"><i class="fa fa-close"></i></button>
            </div>
            @endif
            <div class="row">
                @foreach ($candidatos as $index => $candidato)
                {{-- MODAL SHOW --}}
                <div id="modal-form-view{{$candidato->id}}" class="modal fade" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="row">

                                    <div class="col-sm-6 b-r">
                                        <h3 class="m-t-none m-b">Información Personal </h3>


                                        <form role="form">
                                            <style>
                                                .form-group {
                                                    margin-bottom: 0rem;
                                                }
                                            </style>
                                            <div class="form-group"><label>
                                                    <h5 class="m-t-none m-b">Nombres:</h5>
                                                </label><label for="">{{$candidato->nombre ?? 'Sin nombre'}}</label>
                                            </div>
                                            <div class="form-group"><label>
                                                    <h5 class="m-t-none m-b">Apellidos:</h5>
                                                </label><label for="">{{$candidato->apellido ?? 'Sin apellido'}}</label>
                                            </div>
                                            <div class="form-group"><label>
                                                    <h5 class="m-t-none m-b">Dirección:</h5>
                                                </label><label for="">{{$candidato->direccion ?? 'Sin dirección'}}</label>
                                            </div>
                                            <div class="form-group"><label>
                                                    <h5 class="m-t-none m-b">Institución - Sede:</h5>
                                                </label><label for="">{{$candidato->sede->nombre ?? 'Sin Institucion - Sede'}}</label>
                                            </div>
                                            <div class="form-group"><label>
                                                    <h5 class="m-t-none m-b">Ciclo:</h5>
                                                </label><label for="">{{$candidato->ciclo_de_estudiante  ?? 'Sin ciclo'}}°</label>
                                            </div>
                                            <div class="form-group"><label>
                                                    <h5 class="m-t-none m-b">Correo:</h5>
                                                </label><label for="">{{$candidato->correo  ?? 'Sin correo'}}</label>
                                            </div>
                                            <div class="form-group"><label>
                                                    <h5 class="m-t-none m-b">fecha de
                                                        Nacimiento:</h5>
                                                </label><label for="">{{$candidato->fecha_nacimiento  ?? 'Sin fecha de nacimiento'}}</label>
                                            </div>
                                            <div class="form-group"><label>
                                                    <h5 class="m-t-none m-b">DNI:</h5>
                                                </label><label for="">{{$candidato->dni  ?? 'Sin DNI'}}</label>
                                            </div>
                                            <div class="form-group"><label>
                                                    <h5 class="m-t-none m-b">Celular:</h5>
                                                </label><label for="">{{$candidato->celular  ?? 'Sin celular'}}</label>
                                            </div>
                                            <div class="form-group"><label>
                                                    <h5 class="m-t-none m-b">Carrera:</h5>
                                                </label><label for="">{{$candidato->carrera->nombre  ?? 'Sin carrera'}}</label>
                                            </div>
                                            <div class="form-group"><label>
                                                    <h5 class="m-t-none m-b">Estado: </h5>
                                                </label><label for="">
                                                    @if ($candidato->estado == 1)
                                                    <span style="color: green"><strong>Pendiente</strong></span>
                                                    @elseif($candidato->estado == 0)
                                                    <span style="color: gold"><strong>Colaborador</strong></span>
                                                    @else
                                                    <span style="color: #F00"><strong>Rechazado</strong></span>
                                                    @endif
                                                </label></div>
                                            <div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-sm-6 text-center text-danger">
                                        <h2><strong> Candidato </strong></h2>
                                        <a style="color: black;"><strong>{{$candidato->id}}</strong></a>
                                        <div class="custom-file w-200 h-300 " style="padding: 20px 0px;">
                                            <img src="{{asset('storage/candidatos/'.$candidato->icono)}}"
                                                class="img-lg  max-min-h-w-200 img-cover">

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <div class="ibox ">
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-sm-6 b-r">
                                    <div class="text-center rounded-circle">
                                        <img src="{{asset('storage/candidatos/'.$candidato->icono)}}"
                                            class="rounded-circle max-min-h-w-200 p-a-25 img-cover">
                                    </div>
                                    <p class="text-center">
                                        {{ $candidato->nombre." ".$candidato->apellido}}
                                    </p>
                                    <p class="text-center">
                                    @if ($candidato->estado == 1)
                                    <div class="d-flex gap-10">
                                        <form class="text-center" method="GET"
                                            action="{{ route('candidatos.form', $candidato->id) }}">
                                            <button class="btn btn-primary" type="submit">
                                                Agregar Colaborador
                                            </button>
                                        </form>
                                        <form class="text-center" method="POST"
                                            action="{{ route('candidatos.rechazarCandidato', $candidato->id) }}">
                                            @csrf
                                            @isset($pageData->currentURL)
                                            <input type="hidden" name="currentURL" value="{{ $pageData->currentURL }}">
                                            @endisset
                                            <button class="btn btn-danger" type="submit">
                                                Rechazar
                                            </button>
                                        </form>
                                    </div>

                                    @elseif($candidato->estado == 0)
                                    <div class="text-center">
                                        <h3 style="color: gold" class="font-bold">Colaborador</h3>
                                    </div>
                                    @elseif($candidato->estado == 2)
                                    <div class="d-flex justify-content-center gap-10">
                                        <form class="text-center" method="POST"
                                            action="{{ route('candidatos.reconsiderarCandidato', $candidato->id) }}">
                                            @csrf
                                            @isset($pageData->currentURL)
                                            <input type="hidden" name="currentURL" value="{{ $pageData->currentURL }}">
                                            @endisset
                                            <button class="btn btn-success" type="submit">
                                                Reconsiderar
                                            </button>
                                        </form>
                                        <button class="btn btn-danger" type="button" onclick="confirmDelete({{ $candidato->id }}, '{{ $pageData->currentURL }}')">
                                            Eliminar
                                        </button>
                                    </div>
                                    @elseif($candidato->estado == 3)
                                    <div class="text-center">
                                        <h3 class="text-danger font-bold">Ex Colaborador</h3>
                                    </div>
                                    @endif

                                    </p>
                                </div>
                                <div class="col-sm-6">

                                    <dl class="row mb-0">
                                        <div class="col-sm-6 text-sm-left">
                                            <dt>Carrera:</dt>
                                            <dd class="sm-2"> {{$candidato->carrera->nombre ?? 'Sin carrera'}} </dd>
                                        </div>
                                    </dl>
                                    <dl class="row mb-0">
                                        <div class="col-sm-6 text-sm-left">
                                            <dt>DNI:</dt>
                                            <dd class="sm-2">{{$candidato->dni ?? 'Sin DNI'}}</dd>
                                        </div>
                                    </dl>
                                    <dl class="row mb-0">
                                        <div class="col-sm-6 text-sm-left">
                                            <dt>Correo</dt>
                                            <dd class="sm-2">{{$candidato->correo ?? 'Sin correo'}}</dd>
                                        </div>
                                    </dl>
                                    <dl class="row mb-0">
                                        <div class="col-sm-6 text-sm-left">
                                            <dt>Celular</dt>
                                            <dd class="sm-2">{{$candidato->celular ?? 'Sin celular'}}</dd>
                                        </div>
                                    </dl>

                                    <div>
                                        <div class="d-flex justify-content-center align-items-center" style="display: flex; gap: 2px">
                                            {{-- botón ver colaborador --}}
                                            <x-uiverse.tooltip nameTool="Ver">
                                                <button class="btn btn-success float-right mx-2" type="button"
                                                    href="#modal-form-view{{$candidato->id}}" data-toggle="modal"><i
                                                        style="font-size: 20px" class="fa fa-eye"></i></button>
                                            </x-uiverse.tooltip>

                                            {{-- botón editar colaborador --}}
                                            <x-uiverse.tooltip nameTool="Editar">
                                                <button id="editButton{{ $candidato->id }}" class="btn btn-info float-right mx-2" type="button"
                                                href="#modal-form{{$candidato->id}}" data-toggle="modal"><i
                                                    style="font-size: 20px" class="fa fa-paste"></i></button>
                                            </x-uiverse.tooltip>
                                        </div>

                                        {{-- MODAL UPDATE --}}
                                        <div id="modal-form{{$candidato->id}}" class="modal fade" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <form role="form" method="POST"
                                                            action="{{ route('candidatos.update', $candidato->id) }}"
                                                            enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')
                                                            @isset($pageData->currentURL)
                                                            <input type="hidden" name="currentURL" value="{{ $pageData->currentURL }}">
                                                            @endisset

                                                            <input type="hidden" name="form_type" value="edit">
                                                            <input type="hidden" name="candidato_id" value="{{ $candidato->id }}">

                                                            <div class="row">
                                                                <div class="col-sm-6 b-r">
                                                                    <h3 class="m-t-none m-b">Ingrese los Datos</h3>
                                                                    <div class="form-group">
                                                                        <label>Nombre</label>
                                                                        <input type="text" placeholder="....."
                                                                            class="form-control" name="nombre"
                                                                            id="nombre"
                                                                            value="{{ $candidato->nombre }}">
                                                                            @error('nombre'.$candidato->id)
                                                                            <span class="text-danger">{{ $message }}</span>
                                                                        @enderror

                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Apellido</label>
                                                                        <input type="text" placeholder="....."
                                                                            class="form-control" name="apellido"
                                                                            id="apellido"
                                                                            value="{{ $candidato->apellido }}">
                                                                            @error('apellido'.$candidato->id)
                                                                            <span class="text-danger">{{ $message }}</span>
                                                                        @enderror
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label>DNI</label>
                                                                        <div class="position-relative">
                                                                            <!-- Campo DNI con ID dinámico -->
                                                                            <input type="number" id="dni-update-{{ $candidato->id }}" placeholder="Ingrese dni" class="form-control" name="dni" value="{{ $candidato->dni }}" autocomplete="off" oninput="limitDNI(this)">
                                                                            <span id="dni-counter-update-{{ $candidato->id }}" class="position-absolute" style="right: 10px; top: 50%; transform: translateY(-50%); font-size: 0.9rem; color: gray;">0/8</span>
                                                                        </div>
                                                                        @error('dni.' . $candidato->id)
                                                                            <span class="text-danger">{{ $message }}</span>
                                                                        @enderror
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="form-group"><label>Dirección</label>
                                                                        <input type="text" placeholder="....."
                                                                            class="form-control" name="direccion"
                                                                            id="direccion"
                                                                            value="{{ $candidato->direccion }}">
                                                                            @error('direccion'.$candidato->id)
                                                                            <span class="text-danger">{{ $message }}</span>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="form-group"><label>Fecha de
                                                                            Nacimiento</label>
                                                                        <input type="date" placeholder="....."
                                                                            class="form-control" name="fecha_nacimiento"
                                                                            id="fecha_nacimiento"
                                                                            value="{{ $candidato->fecha_nacimiento }}">

                                                                    </div>
                                                                    <div class="form-group"><label>Ciclo de
                                                                            Estudiante</label>
                                                                            <select name="ciclo_de_estudiante" id="ciclo_de_estudiante" class="form-control" >
                                                                                @for($i = 4; $i <= 10; $i++)
                                                                                    <option value="{{ $i }}"
                                                                                        @if($i ==  $candidato->ciclo_de_estudiante) selected @endif>
                                                                                        {{ $i }}
                                                                                    </option>
                                                                                @endfor
                                                                            </select>
                                                                            @error('ciclo_de_estudiante')
                                                                            <span class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                    </div>

                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <h4>Subir Ícono</h4>
                                                                    <input type="file" class="form-control-file"
                                                                        id="icono-{{ $candidato->id }}" name="icono"
                                                                        value="{{ old('icono', $candidato->icono) }}"
                                                                        style="display: none;">
                                                                    <button type="button" class="btn btn-link"
                                                                        id="icon-upload-{{ $candidato->id }}">
                                                                        <i class="fa fa-cloud-download big-icon"></i>
                                                                    </button>
                                                                    @error('icono'.$candidato->id)
                                                                        <span class="text-danger">{{ $message }}</span>
                                                                    @enderror
                                                                    <script>
                                                                        document.getElementById('icon-upload-{{ $candidato->id }}').addEventListener('click', function() {
                                                                        document.getElementById('icono-{{ $candidato->id }}').click();
                                                                    });
                                                                    </script>
                                                                    <div class="form-group">
                                                                        <label>Institución - Sede</label>
                                                                        <select class="form-control" name="sede_id">
                                                                            @foreach($sedes as $sede)
                                                                            <option value="{{ $sede->id }}" @if($sede->
                                                                                id ==

                                                                                $candidato->sede_id) selected
                                                                                @endif>{{ $sede->nombre }}
                                                                            </option>
                                                                            @endforeach
                                                                        </select>
                                                                        @error('sede_id')
                                                                        <span class="text-danger">{{ $message }}</span>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="form-group"><label>Carrera</label>
                                                                        <select class="form-control" name="carrera_id">
                                                                            @foreach($carreras as $carrera)
                                                                            <option value="{{ $carrera->id }}"
                                                                                @if($carrera->id ==
                                                                                $candidato->carrera_id) selected
                                                                                @endif >{{ $carrera->nombre }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        @error('carrera_id')
                                                                        <span class="text-danger">{{ $message }}</span>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="form-group"><label>Correo</label>
                                                                        <input type="text" placeholder="....."
                                                                            class="form-control" name="correo"
                                                                            id="correo"
                                                                            value="{{ $candidato->correo }}">
                                                                        @error('correo'.$candidato->id)
                                                                            <span class="text-danger">{{ $message }}</span>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="form-group">
                                                                      <div class="position-relative">
                                                                        <label>Celular</label>
                                                                        <input type="number" placeholder="....."
                                                                            class="form-control" name="celular"
                                                                            id="cel-update-{{ $candidato->id }}"
                                                                            oninput="limitCel(this)" value="{{ $candidato->celular }}">
                                                                             <span id="cel-counter-update-{{ $candidato->id }}" class="position-absolute" style="right: 10px; top: 70%; transform: translateY(-50%); font-size: 0.9rem; color: gray;">0/9</span>
                                                                        @error('celular'.$candidato->id)
                                                                            <span class="text-danger">{{ $message }}</span>
                                                                        @enderror
                                                                      </div>
                                                                    </div>
                                                                    <div class="mt-4">
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
            @if($hasPagination === true)
                <div class="row mb-5 mb-md-4">
                    <div class="col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-start align-items-center gap-10 my-3">
                        @if($pageData->lastPage > 2 && $pageData->currentPage !== 1)
                            <a href="{{ $candidatos->url(1) }}" class="btn btn-outline-dark rounded-5">
                                <i class="fa fa-arrow-circle-left"></i> Primero
                            </a>
                        @endif
                        @if($pageData->currentPage > 1)
                            <a href="{{$pageData->previousPageUrl}}" class="btn btn-outline-dark rounded-5">
                                <i class="fa fa-arrow-circle-left"></i> Anterior
                            </a>
                        @endif
                    </div>
                    <div class="col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end align-items-center gap-10">
                        @if($pageData->currentPage < $pageData->lastPage)
                            <a href="{{ $pageData->nextPageUrl }}" class="btn btn-outline-dark rounded-5">
                                Siguiente <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        @endif
                        @if($pageData->lastPage > 2 && $pageData->currentPage !== $pageData->lastPage)
                            <a href="{{ $pageData->lastPageUrl }}" class="btn btn-outline-dark rounded-5">
                                Último <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        @include('components.inspinia.footer-inspinia')

    </div>
    </div>

    @if ($errors->any())
        <script>
            // Reabrir el modal de creación si el error proviene del formulario de creación
            console.log(@json($errors->all()));
            @if (old('form_type') == 'create')
                $('#modal-form-add').modal('show');
            @endif

            // Reabrir el modal de edición si el error proviene del formulario de edición
            @if (old('form_type') == 'edit' && old('candidato_id'))
                $('#modal-form' + {{ old('candidato_id') }}).modal('show');
            @endif
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


    <script>
         // limiteCel
         function limitCel(input) {
            // Asegura que solo se permitan 8 caracteres
            if (input.value.length > 9) {
                input.value = input.value.slice(0, 9); // Limita a 8 caracteres
            }

            // Obtener el ID del candidato para el contador correspondiente
            let counterId;
            if (input.id.includes('store')) {
                counterId = 'cel-counter-store'; // Para el campo de creación
            } else {
                const candidateId = input.id.split('-')[2]; // Para los campos de actualización
                counterId = `cel-counter-update-${candidateId}`;
            }

            const counter = document.getElementById(counterId);

            // Actualiza el contador de caracteres
            counter.textContent = `${input.value.length}/9`;

            // Cambia el color del borde según el número de caracteres
            if (input.value.length >= 1 && input.value.length < 9) {
                input.style.borderColor = 'red'; // Rojo cuando llega a 1-7 caracteres
            } else if (input.value.length === 9) {
                input.style.borderColor = 'green'; // Verde cuando llega a 8 caracteres
            } else {
                input.style.borderColor = ''; // Restablece el borde si no está en el rango
            }
        }

        // Inicializa el contador y el borde al cargar la página
        document.addEventListener("DOMContentLoaded", function() {
            // Para Store (Crear)
            const inputStore = document.getElementById('cel-store');
            const counterStore = document.getElementById('cel-counter-store');
            if (inputStore) {
                const initialValueStore = inputStore.value || '';
                counterStore.textContent = `${initialValueStore.length}/9`;

                if (initialValueStore.length >= 1 && initialValueStore.length < 9) {
                    inputStore.style.borderColor = 'red';
                } else if (initialValueStore.length === 9) {
                    inputStore.style.borderColor = 'green';
                }

                inputStore.addEventListener('input', function() {
                    limitCel(inputStore);
                });
            }

            // Para Update (Actualizar)
            const inputsUpdate = document.querySelectorAll('[id^="cel-update-"]');

            inputsUpdate.forEach(inputUpdate => {
                const candidateId = inputUpdate.id.split('-')[2];  // Obtiene el ID del candidato
                const counterUpdate = document.getElementById(`cel-counter-update-${candidateId}`);

                // Inicializa el contador y el borde según el valor inicial
                const initialValueUpdate = inputUpdate.value || '';
                counterUpdate.textContent = `${initialValueUpdate.length}/9`;

                if (initialValueUpdate.length >= 1 && initialValueUpdate.length < 9) {
                    inputUpdate.style.borderColor = 'red';
                } else if (initialValueUpdate.length === 9) {
                    inputUpdate.style.borderColor = 'green';
                }

                // Agregar event listener al input
                inputUpdate.addEventListener('input', function() {
                    limitCel(inputUpdate);
                });
            });
        });



        // limiteDNI 
        function limitDNI(input) {
            // Asegura que solo se permitan 8 caracteres
            if (input.value.length > 8) {
                input.value = input.value.slice(0, 8); // Limita a 8 caracteres
            }

            // Obtener el ID del candidato para el contador correspondiente
            let counterId;
            if (input.id.includes('store')) {
                counterId = 'dni-counter-store'; // Para el campo de creación
            } else {
                const candidateId = input.id.split('-')[2]; // Para los campos de actualización
                counterId = `dni-counter-update-${candidateId}`;
            }

            const counter = document.getElementById(counterId);

            // Actualiza el contador de caracteres
            counter.textContent = `${input.value.length}/8`;

            // Cambia el color del borde según el número de caracteres
            if (input.value.length >= 1 && input.value.length < 8) {
                input.style.borderColor = 'red'; // Rojo cuando llega a 1-7 caracteres
            } else if (input.value.length === 8) {
                input.style.borderColor = 'green'; // Verde cuando llega a 8 caracteres
            } else {
                input.style.borderColor = ''; // Restablece el borde si no está en el rango
            }
            console.log(input.value);
        }

        // Inicializa el contador y el borde al cargar la página
        document.addEventListener("DOMContentLoaded", function() {
            // Para Store (Crear)
            const inputStore = document.getElementById('dni-store');
            const counterStore = document.getElementById('dni-counter-store');
            if (inputStore) {
                const initialValueStore = inputStore.value || '';
                counterStore.textContent = `${initialValueStore.length}/8`;

                if (initialValueStore.length >= 1 && initialValueStore.length < 8) {
                    inputStore.style.borderColor = 'red';
                } else if (initialValueStore.length === 8) {
                    inputStore.style.borderColor = 'green';
                }

                inputStore.addEventListener('input', function() {
                    limitDNI(inputStore);
                });
            }

            // Para Update (Actualizar)
            const inputsUpdate = document.querySelectorAll('[id^="dni-update-"]');

            inputsUpdate.forEach(inputUpdate => {
                const candidateId = inputUpdate.id.split('-')[2];  // Obtiene el ID del candidato
                const counterUpdate = document.getElementById(`dni-counter-update-${candidateId}`);

                // Inicializa el contador y el borde según el valor inicial
                const initialValueUpdate = inputUpdate.value || '';
                counterUpdate.textContent = `${initialValueUpdate.length}/8`;

                if (initialValueUpdate.length >= 1 && initialValueUpdate.length < 8) {
                    inputUpdate.style.borderColor = 'red';
                } else if (initialValueUpdate.length === 8) {
                    inputUpdate.style.borderColor = 'green';
                }

                // Agregar event listener al input
                inputUpdate.addEventListener('input', function() {
                    limitDNI(inputUpdate);
                });
            });
        });
    </script>



    <script>
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
            const candidato = document.getElementById('candidatos');
            if (candidato) {
                candidato.classList.add('active');
            } else {
                console.error("El elemento con el id 'candidato' no se encontró en el DOM.");
            }
        });
    </script>
    <script>
        const hiddenFileInput = document.getElementById('icono');
        const iconUploadButton = document.getElementById('icon-upload');

        iconUploadButton.addEventListener('click', function() {
            hiddenFileInput.click();
        });
    </script>

    <script>
        function showModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('show');
        modal.style.display = 'block'; // Asegúrate de que el modal se muestre
    }
}

function hideModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('show');
        modal.style.display = 'none'; // Asegúrate de que el modal se oculte
    }
}

function abrirModalCreacion(index) {
    ocultarTodosLosModales();
    showModal('modal-create-form-' + index);
}


        function abrirModalEdicion(id) {
            hideModal('modal-form-view' + id);
            showModal('modal-form-update' + id);
        }

        function confirmDelete(id, currentURL) {
            alertify.confirm("¿Deseas eliminar este registro? Esta acción es permanente", function(e) {
                if (e) {
                    let form = document.createElement('form')

                    form.method = 'POST'
                    form.action = `/candidatos/${id}`
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

        function updateSelectAll(checkboxGroup, selectAllId) {
            const selectAllCheckbox = document.getElementById(selectAllId);
            const checkboxes = document.querySelectorAll(checkboxGroup);
            selectAllCheckbox.checked = Array.from(checkboxes).every(checkbox => checkbox.checked);
        }

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
        function prepareSearchActionURL(event) {
            let busqueda = document.getElementById('searchInput').value;

            if(busqueda.trim().length > 0) {
                let actionUrl = `{{ url('candidatos/search/${busqueda}') }}`;
                console.log(actionUrl);
                document.querySelector('#searchCandidatos').action = actionUrl;

                return true;
            } else{
                event.preventDefault();
                return false;
            }
        }

        function prepareFilterActionURL() {
            let estados = Array.from(document.querySelectorAll('.estado-checkbox:checked')).map(cb => cb.value);
            let carreras = Array.from(document.querySelectorAll('.carrera-checkbox:checked')).map(cb => cb.value);
            let instituciones = Array.from(document.querySelectorAll('.institucion-checkbox:checked')).map(cb => cb.value);
            let ciclos = Array.from(document.querySelectorAll('.ciclo-checkbox:checked')).map(cb => cb.value);

            estados = estados.length ? estados.join(',') : '0,1,2,3';
            carreras = carreras.length ? carreras.join(',') : '0';
            instituciones = instituciones.length ? instituciones.join(',') : '0';
            ciclos = ciclos.length ? ciclos.join(',') : '0';

            if(estados != null && carreras != null && instituciones != null && ciclos !=null) {
                let actionUrl = `{{ url('candidatos/filtrar/estados=${estados}/carreras=${carreras}/instituciones=${instituciones}/ciclos=${ciclos}') }}`;
                console.log(actionUrl);
                document.querySelector('#filtrarCandidatos').action = actionUrl;

                return true;
            }
        }

    document.getElementById('select-all-estados').addEventListener('change', function() {
        let checkboxes = document.querySelectorAll('.estado-checkbox');
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

    document.getElementById('select-all-ciclos').addEventListener('change', function () {
        let checkboxes = document.querySelectorAll('.ciclo-checkbox');
        checkboxes.forEach(cb => cb.checked = this.checked);
    });
    </script>

</body>

</html>
