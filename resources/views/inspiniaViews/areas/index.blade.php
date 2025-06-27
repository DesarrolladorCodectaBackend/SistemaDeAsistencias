<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <title>INSPINIA| Áreas</title>
</head>

<body>
    <div id="wrapper">
        @include('components.inspinia.side_nav_bar-inspinia')
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-4">
                <h2>Áreas</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{route('dashboard')}}">Inicio</a>
                    </li>
                    <li class="breadcrumb-item active">
                        <strong>Áreas</strong>
                    </li>
                </ol>
            </div>
            <div class="col-lg-6 d-flex align-items-center gap-10">
                <h2>Cant. Áreas: <span class="font-bold text-danger">{{$countAreas}}</span></h2>
                <h2>Cant. Colaboradores: <span class="font-bold text-danger">{{$countColabs}}</span></h2>
            </div>
            <div class="col-lg-2 d-flex align-items-center justify-content-end">
                <button class="btn btn-success dim float-right" href="#modal-form-add" data-toggle="modal"
                    type="button">Agregar</button>
                <div id="modal-form-add" class="modal fade" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body">
                                <form role="form" method="POST" action="{{ route('areas.store') }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="currentURL" value="{{ $pageData->currentURL }}">
                                    <input type="hidden" name="form_type" value="create">
                                    <div class="row">
                                        <div class="col-sm-6 b-r">
                                            <h3 class="m-t-none m-b">Ingrese los Datos</h3>
                                            <div class="form-group"><label>Especialización</label> <input type="text"
                                                    placeholder="....." class="form-control" name="especializacion"
                                                    >
                                            </div>
                                            @error('especializacion')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                            <div class="form-group"><label>Descripción</label> <input type="text"
                                                    placeholder="....." class="form-control" name="descripcion"
                                                    >
                                            </div>
                                            @error('descripcion')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                            <div class="form-group"><label>Color Hex</label>
                                                <input type="color" placeholder="....." class="form-control"
                                                    name="color_hex" >
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <h4>Subir Ícono</h4>
                                            <input type="file" class="form-control-file" id="icono" name="icono"
                                                style="display: none;">
                                            <!-- Icono que simula el clic en el botón de subir archivos -->
                                            <button type="button" class="btn btn-link" id="icon-upload">
                                                <i class="fa fa-cloud-download big-icon"></i>
                                            </button>
                                            <div class="form-group"><label>Salón</label>
                                                <select class="form-control" name="salon_id" required>
                                                    @foreach($salones as $key => $salon)
                                                    <option value="{{ $salon->id }}">{{ $salon->nombre }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div>
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
                @foreach ($areas as $index => $area)
                <div  class="col-sm-12 col-md-6 col-lg-4 col-xl-3">
                    {{-- <button class="ibox" type="button" data-toggle="modal" href="#modal-form{{ $area->id }}"> --}}
                        <div class="ibox">
                            <div class="ibox-content product-box">
                                <div class="product-imitation" style="object-fit: cover; padding: 0px; height: 225px;" onclick="onClickArea('{{ $area->id }}')">
                                    <img src="{{ asset('storage/areas/' . $area->icono) }}" alt="" style="height: 100%; width: 100%; object-fit: cover"  class="img-cover">
                                </div>
                                <div class="product-desc">
                                    {{-- CAMBIO DE ESTADO ÁREAS --}}


                                    <form action="{{ route('areas.activarInactivar', $area->id) }}" method="POST">
                                        @csrf
                                        @method('put')
                                        <input type="hidden" name="currentURL" value="{{ $pageData->currentURL }}">

                                    </form>


                                    <div>
                                        {{-- btn cambiar estado JS --}}
                                        <button type="button" class="btn btn-{{ $area->estado ? 'outline-success' : 'danger' }} btn-primary dim" onclick="confirmState({{ $area->id }})">
                                            <span>{{ $area->estado ? 'ON' : 'OFF' }}</span>
                                        </button>
                                    </div>
                                    <small class="text-muted">ID: {{ $area->id }} Salón: {{$area->salon->nombre}} Cant. Integrantes: {{$area->count_colabs}}</small>
                                    <a href="#"  class="product-name">{{ $area->especializacion }}</a>
                                    <div class="small m-t-xs">
                                        {{ $area->descripcion }}
                                    </div>
                                    <div style="display: flex; gap: 4px" class="m-t text-left">
                                        {{-- <button class="btn btn-danger" type="button"
                                            onclick="confirmDelete({{ $area->id }})"><i class="fa fa-trash-o"></i></button>
                                        --}}
                                        {{-- <button class="btn btn-info" type="button" href="#modal-form{{ $area->id }}"
                                            data-toggle="modal"><i class="fa fa-paste"></i> Edit</button> --}}

                                            {{-- botones --}}
                                        <form role="form" method="GET" action="{{ route('areas.getHorario', $area->id) }}">
                                            <x-uiverse.tooltip nameTool="Horarios">
                                                <button class="btn btn-primary fa fa-clock-o" style="font-size: 20px;"></button>
                                            </x-uiverse.tooltip>
                                        </form>
                                        <form role="form" method="GET"
                                            action="{{ route('areas.getReuniones', $area->id) }}">

                                            <x-uiverse.tooltip nameTool="Reuniones">
                                                <button class="btn btn-success fa fa-video-camera"
                                                style="font-size: 20px;"></button>
                                            </x-uiverse.tooltip>

                                        </form>
                                        <form role="form" method="GET" action="{{route('areas.getMaquinas', $area->id)}}">

                                            <x-uiverse.tooltip nameTool="Máquinas">
                                                <button class="btn btn-secondary fa fa-desktop" style="font-size: 20px;">
                                                </button>
                                            </x-uiverse.tooltip>

                                        </form>
                                      
                                        <x-uiverse.tooltip nameTool="Evaluaciones">
                                           <button 
                                                type="button" 
                                                id="btn-desactivar-evaluaciones-{{$area->id}}" 
                                                class="btn btn-secondary fa fa-calendar" 
                                                style="font-size: 20px;"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#modalDesactivarEvaluaciones{{$area->id}}"
                                                onclick="abrirModalDesactivacion({{$area->id}}, '{{$area->nombre}}')">
                                            </button>
                                        </x-uiverse.tooltip>

                                        {{-- desactivar evaluaciones --}}
                                        <div class="modal fade" id="modalDesactivarEvaluaciones{{$area->id}}" tabindex="-1" 
                                            aria-labelledby="modalDesactivarEvaluacionesLabel{{$area->id}}" aria-hidden="true"
                                            data-bs-backdrop="static" data-bs-keyboard="false">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header text-dark">
                                                        <h5 class="modal-title" id="modalDesactivarEvaluacionesLabel{{$area->id}}">
                                                            <i class="fas fa-calendar-times me-2"></i>
                                                            Desactivar Evaluaciones - {{$area->especializacion}}
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                                                    </div>
                                                    
                                                    <form method="POST" action="{{route('desactivarEvaluacion.area', $area->id)}}" id="formDesactivarEvaluaciones{{$area->id}}">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <div class="alert alert-info">
                                                                Seleccione el período durante el cual las evaluaciones estarán desactivadas para esta área.
                                                            </div>
                                                            
                                                            <div class="row">
                                                                {{-- fecha_inicio --}}
                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-3">
                                                                        <label for="fecha_inicio{{$area->id}}" class="form-label fw-bold">
                                                                            <i class="fas fa-calendar-plus text-success me-1"></i>
                                                                            Fecha de Inicio
                                                                        </label>
                                                                        <input type="date" 
                                                                            class="form-control form-control-lg" 
                                                                            id="fecha_inicio{{$area->id}}" 
                                                                            name="fecha_inicio" 
                                                                            required
                                                                            min="{{date('Y-m-d')}}"
                                                                            onchange="validarFechas({{$area->id}})">
                                                                        <small class="form-text text-muted">
                                                                            Fecha desde cuando se desactivarán las evaluaciones
                                                                        </small>
                                                                    </div>
                                                                </div>
                                                                
                                                                {{-- fecha_fin --}}
                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-3">
                                                                        <label for="fecha_fin{{$area->id}}" class="form-label fw-bold">
                                                                            Fecha de Fin
                                                                        </label>
                                                                        <input type="date" 
                                                                            class="form-control form-control-lg" 
                                                                            id="fecha_fin{{$area->id}}" 
                                                                            name="fecha_fin" 
                                                                            required
                                                                            min="{{date('Y-m-d')}}"
                                                                            onchange="validarFechas({{$area->id}})">
                                                                        <small class="form-text text-muted">
                                                                            Fecha hasta cuando estarán desactivadas
                                                                        </small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="mt-3">
                                                                <div class="card bg-light">
                                                                    <div class="card-body">
                                                                        <h6 class="card-title">
                                                                            <i class="fas fa-clock me-1"></i>
                                                                            Resumen del Período
                                                                        </h6>
                                                                        <p class="card-text" id="resumenPeriodo{{$area->id}}">
                                                                            Seleccione las fechas para ver el resumen del período de desactivación.
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                                Cancelar
                                                            </button>
                                                            <button type="submit" class="btn btn-primary" id="btnConfirmarDesactivacion{{$area->id}}" disabled>
                                                                Desactivar Evaluaciones
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    {{-- </button> --}}
                </div>
                <div id="modal-form{{ $area->id }}" class="modal fade" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body">
                                <form role="form" method="POST"
                                    action="{{ route('areas.update', $area->id) }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="currentURL" value="{{ $pageData->currentURL }}">
                                    <input type="hidden" name="form_type" value="edit">
                                    <input type="hidden" name="area_id" value="{{ $area->id }}">
                                    <div class="row">
                                        <div class="col-sm-6 b-r">
                                            <h3 class="m-t-none m-b">Ingrese los Datos</h3>
                                            <div class="form-group">
                                                <label>Especializacion</label>
                                                <input type="text" placeholder="....."
                                                    class="form-control" name="especializacion"
                                                    id="especializacion"
                                                    value="{{ $area->especializacion }}">
                                                    @error('especializacion'.$area->id)
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                            </div>
                                            <div class="form-group"><label>Descripción</label>
                                                <input type="text" placeholder="....."
                                                    class="form-control" name="descripcion"
                                                    id="descripcion"
                                                    value="{{ $area->descripcion }}">
                                                    @error('descripcion'.$area->id)
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                            </div>
                                            <div class="form-group"><label>Color Hex</label>
                                                <input type="color" placeholder="....."
                                                    class="form-control" name="color_hex"
                                                    id="color_hex"
                                                    value="{{ $area->color_hex }}">

                                            </div>
                                            <div class="form-group"><label>Jefe del Área</label>
                                                <select class="form-control" name="jefe_area_id" id="">
                                                    <option @if($area->hasBoss == false) selected @endif value="0">Sin jefe</option>
                                                    @foreach($area->integrantes as $integrante){
                                                        <option @if($integrante->jefe_area) selected @endif value="{{$integrante->id}}">{{$integrante->colaborador->candidato->nombre}} {{$integrante->colaborador->candidato->apellido}}</option>
                                                    }
                                                    @endforeach
                                                </select>

                                            </div>

                                        </div>
                                        <div class="col-sm-6">
                                            <h4>Subir Icono</h4>
                                            <input type="file" class="form-control-file"
                                                id="icono-{{ $area->id }}" name="icono"
                                                value="{{ old('icono', $area->icono) }}"
                                                style="display: none;">
                                            <button type="button" class="btn btn-link"
                                                id="icon-upload-{{ $area->id }}">
                                                <i class="fa fa-cloud-download big-icon"></i>
                                            </button>
                                            <script>
                                                document.getElementById('icon-upload-{{ $area->id }}').addEventListener('click', function() {
                                                        document.getElementById('icono-{{ $area->id }}').click();
                                                    });
                                            </script>
                                            <div class="form-group"><label>Salón</label>
                                                <select class="form-control" name="salon_id"
                                                    required>
                                                    @foreach($salones as $key => $salon)
                                                    <option value="{{ $salon->id }}" @if($salon->id
                                                        == $area->salon_id) selected @endif
                                                        >{{ $salon->nombre }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div>
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
                @endforeach
            </div>
            @if($hasPagination === true)
                <div class="row mb-5 mb-md-4">
                    <div class="col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-start align-items-center gap-10 my-3">
                        @if($pageData->lastPage > 2 && $pageData->currentPage !== 1)
                            <a href="{{ $areas->url(1) }}" class="btn btn-outline-dark rounded-5">
                                <i class="fa fa-arrow-circle-left"></i> First
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
    @if ($errors->any())
        <script>
            // Reabrir el modal de creación si el error proviene del formulario de creación
            console.log(@json($errors->all()));
            @if (old('form_type') == 'create')
                $('#modal-form-add').modal('show');
            @endif

            // Reabrir el modal de edición si el error proviene del formulario de edición
            @if (old('form_type') == 'edit' && old('area_id'))
                $('#modal-form' + {{ old('area_id') }}).modal('show');
            @endif
        </script>
    @endif
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const area = document.getElementById('areas');
            if (area) {
                area.classList.add('active');
            } else {
                console.error("El elemento con el id 'areas' no se encontró en el DOM.");
            }
        });
    </script>

    <script src="{{ asset('js/asistencia/areas/index.js') }}"></script>


    <script>
        function confirmState(id) {
            Swal.fire({
                    title: "¿Deseas cambiar el estado de esta área?",
                    showCancelButton: true,
                    confirmButtonText: "Confirmar",
                    cancelButtonText: "Cancelar"
                }).then((result) => {
                    if (result.isConfirmed) {

                    let form = document.createElement('form');
                    form.method = 'POST';
                    //form.action = `/areas/activarInactivar/${areaId}`;

                    let routeTemplate = "<?php echo route('areas.activarInactivar', ':id'); ?>";
                    form.action = routeTemplate.replace(':id', id);

                    //console.log(routeTemplate);
                    form.innerHTML = `
                        @csrf @method("PUT")
                        <input type="hidden" name="currentURL" value="{{ $pageData->currentURL }}">
                        `;

                    // if (currentURL != null) {
                    //     let inputHidden = document.createElement('input');
                    //     inputHidden.type = 'hidden';
                    //     inputHidden.name = 'currentURL';
                    //     inputHidden.value = currentURL;
                    //     form.appendChild(inputHidden);
                    // }

                    document.body.appendChild(form);
                    form.submit();
                    } else {

                        Swal.fire({
                            title: "Acción cancelada",
                            text: "No se cambió el estado",
                            icon: "info",
                            customClass: {
                                content: 'swal-content'
                            }
                        });

                        const style = document.createElement('style');
                        style.innerHTML = `
                            .swal2-html-container{
                                color: #FFFFFF;
                            }
                        `;
                        document.head.appendChild(style);
                    }
                    });

    }
    
    </script>
<script>
// Función para abrir modal (debugging)
function abrirModalDesactivacion(areaId, areaNombre) {
    console.log('Intentando abrir modal para área:', areaId, areaNombre);
    
    // Verificar si Bootstrap está cargado
    if (typeof bootstrap === 'undefined' && typeof $ === 'undefined') {
        console.error('Bootstrap no está cargado');
        alert('Error: Bootstrap no está cargado. Contacte al administrador.');
        return;
    }
    
    // Forzar apertura del modal si data-bs-toggle no funciona
    try {
        const modalElement = document.getElementById('modalDesactivarEvaluaciones' + areaId);
        console.log('Modal element encontrado:', modalElement);
        
        if (modalElement) {
            // Bootstrap 5
            if (typeof bootstrap !== 'undefined') {
                const modal = new bootstrap.Modal(modalElement);
                modal.show();
            }
            // jQuery/Bootstrap 4 (fallback)
            else if (typeof $ !== 'undefined') {
                $('#modalDesactivarEvaluaciones' + areaId).modal('show');
            }
        } else {
            console.error('Modal no encontrado:', 'modalDesactivarEvaluaciones' + areaId);
        }
    } catch (error) {
        console.error('Error al abrir modal:', error);
    }
}

// Función de validación mejorada
function validarFechas(areaId) {
    console.log('Validando fechas para área:', areaId);
    
    const fechaInicio = document.getElementById('fecha_inicio' + areaId).value;
    const fechaFin = document.getElementById('fecha_fin' + areaId).value;
    const btnConfirmar = document.getElementById('btnConfirmarDesactivacion' + areaId);
    const resumen = document.getElementById('resumenPeriodo' + areaId);
    
    if (fechaInicio && fechaFin) {
        const inicio = new Date(fechaInicio);
        const fin = new Date(fechaFin);
        
        if (fin <= inicio) {
            // Fecha fin debe ser posterior a fecha inicio
            document.getElementById('fecha_fin' + areaId).setCustomValidity('La fecha fin debe ser posterior a la fecha de inicio');
            btnConfirmar.disabled = true;
            resumen.innerHTML = '<span class="text-danger"><i class="fas fa-exclamation-triangle me-1"></i>La fecha fin debe ser posterior a la fecha de inicio.</span>';
        } else {
            // Validación correcta
            document.getElementById('fecha_fin' + areaId).setCustomValidity('');
            btnConfirmar.disabled = false;
            
            // Calcular días
            const timeDiff = fin.getTime() - inicio.getTime();
            const daysDiff = Math.ceil(timeDiff / (1000 * 3600 * 24));
            
            // Formatear fechas para mostrar
            const fechaInicioFormat = inicio.toLocaleDateString('es-ES', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
            
            const fechaFinFormat = fin.toLocaleDateString('es-ES', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
            
            resumen.innerHTML = `
                <strong>Período seleccionado:</strong><br>
                <i class="fas fa-play text-success me-1"></i> <strong>Inicio:</strong> ${fechaInicioFormat}<br>
                <i class="fas fa-stop text-danger me-1"></i> <strong>Fin:</strong> ${fechaFinFormat}<br>
                <i class="fas fa-calendar-day text-primary me-1"></i> <strong>Duración:</strong> ${daysDiff} día${daysDiff > 1 ? 's' : ''}
            `;
        }
    } else {
        btnConfirmar.disabled = true;
        resumen.innerHTML = 'Seleccione las fechas para ver el resumen del período de desactivación.';
    }
    
    // Actualizar min de fecha fin cuando cambia fecha inicio
    if (fechaInicio) {
        document.getElementById('fecha_fin' + areaId).min = fechaInicio;
    }
}

// Event listener para confirmación
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formDesactivarEvaluaciones{{$area->id}}');
    if (form) {
        form.addEventListener('submit', function(e) {
            const fechaInicio = document.getElementById('fecha_inicio{{$area->id}}').value;
            const fechaFin = document.getElementById('fecha_fin{{$area->id}}').value;
            
            const inicio = new Date(fechaInicio).toLocaleDateString('es-ES');
            const fin = new Date(fechaFin).toLocaleDateString('es-ES');
            
            if (!confirm(`¿Está seguro de desactivar las evaluaciones del área "{{$area->nombre}}" desde el ${inicio} hasta el ${fin}?`)) {
                e.preventDefault();
            }
        });
    }
});

// Debug: Verificar cuando se carga la página
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM cargado. Verificando elementos...');
    console.log('Botón:', document.getElementById('btn-desactivar-evaluaciones-{{$area->id}}'));
    console.log('Modal:', document.getElementById('modalDesactivarEvaluaciones{{$area->id}}'));
    console.log('Bootstrap disponible:', typeof bootstrap !== 'undefined');
    console.log('jQuery disponible:', typeof $ !== 'undefined');
});
</script>

<style>
#modalDesactivarEvaluaciones{{$area->id}} .form-control:focus {
    border-color: #00B3B0;
    box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25);
}

#modalDesactivarEvaluaciones{{$area->id}} .form-control-lg {
    font-size: 1.1rem;
    padding: 0.75rem 1rem;
}

#modalDesactivarEvaluaciones{{$area->id}} .card {
    border-left: 4px solid #00B3B0;
}

#btnConfirmarDesactivacion{{$area->id}}:not(:disabled):hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    transition: all 0.2s ease;
}

.modal-backdrop {
    z-index: 1040;
}

.modal {
    z-index: 1050;
}
</style>
</body>

</html>
