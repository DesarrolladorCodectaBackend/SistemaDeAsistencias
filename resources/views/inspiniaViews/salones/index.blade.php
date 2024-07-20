<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>INSPINIA | SALONES</title>
</head>

<body>
    <div id="wrapper">
        @include('components.inspinia.side_nav_bar-inspinia')
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-10">
                <h2>Salones</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="/dashboard">Home</a>
                    </li>
                    <li class="breadcrumb-item active">
                        <strong>Salones</strong>
                    </li>
                </ol>
            </div>
            <div class="col-lg-2">

                <div class="ibox-content">
                    <div class="text-center">
                        <a data-toggle="modal" class="btn btn-primary " href="#modal-form1"> Agregar <i
                                class="fa fa-long-arrow-right"></i></a>
                    </div>
                    <div id="modal-form1" class="modal fade" aria-hidden="true">
                        <form role="form" method="POST" action="{{ route('salones.store') }}">
                            @csrf
                            <input type="hidden" name="currentURL" value="{{ $pageData->currentURL }}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="row">

                                            <div class="col-sm-12 b-r">
                                                <div class="form-group" style="text-align: center"><label>
                                                        <h3 class="m-t-none m-b">Nombre</h3>
                                                    </label><input type="text" placeholder="Ingresa nombre"
                                                        class="form-control" name="nombre"></div>

                                                <div class="form-group" style="text-align: center"><label>
                                                        <h3 class="m-t-none m-b">Descripcion</h3>
                                                    </label><input type="text" placeholder="Ingresa Descripcion"
                                                        class="form-control" name="descripcion"></div>

                                                <div
                                                    style="display:flex; justify-content: center; align-items: center; gap: 15px">
                                                    <button class="btn btn-primary btn-sm m-t-n-xs float-right"
                                                        type="submit"><i
                                                            class="fa fa-check"></i>&nbsp;Confirmar</button>
                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight col-md-12">
            <div class="row">
                @foreach ($salones as $index => $salon)
                @if ($index % 4 == 0)
            </div>
            <div class="row">
                @endif
                <div class="col-md-3">
                    <div class="ibox">
                        <div class="ibox-content product-box">

                            <div class="product-imitation">
                                <img src="{{ asset('img/salon.svg') }}" alt="">
                            </div>
                            <div class="product-desc">
                                <span class="product-price" style="background: transparent">
                                    <form method="POST" action="{{ route('salones.activarInactivar', $salon->id) }}">
                                        @csrf
                                        <input type="hidden" name="currentURL" value="{{ $pageData->currentURL }}">
                                        <button type="submit"
                                            class="btn btn-{{ $salon->estado ? 'outline-success' : 'danger' }} btn-primary dim btn-xs">
                                            <span>{{ $salon->estado ? 'Activo' : 'Inactivo' }}</span>
                                        </button>
                                    </form>
                                </span>

                                <a href="#" class="product-name">
                                    <h2> {{ $salon->nombre }}</h2>
                                </a>



                                <small class="text-muted text-center">
                                    <h3><strong>Codigo</strong></h3>
                                </small>
                                <div class="small m-t-xs text-center">
                                    <h5>{{ $salon->id }}</h5>
                                </div>
                                <small class="text-muted text-center">
                                    <h3><strong>Descripcion</strong></h3>
                                </small>
                                <div class="small m-t-xs text-center">
                                    <h5>{{ $salon->descripcion }}</h5>
                                </div>
                                <small class="text-muted text-center">
                                    <h3><strong>Cantidad De Maquinas</strong></h3>
                                </small>
                                <div class="small m-t-xs text-center">
                                    <h5>{{$salon->cant_maquinas}}</h5>
                                </div>
                                <div class="m-t text-righ">

                                    <a href="#" data-toggle="model"> <i></i> </a>
                                    <div class="ibox-content">
                                        <div class="text-right">
                                            {{-- <button class="btn btn-primary btn-danger fa fa-trash"
                                                style="font-size: 20px;" type="button"
                                                onclick="confirmDelete({{ $salon->id }})"></button> --}}
                                            <a data-toggle="modal" class="btn btn-primary fa fa-edit"
                                                style="font-size: 20px;" href="#modal-form-update-{{ $salon->id }}"></a>
                                            <button type="button" class="btn btn-primary btn-success fa fa-eye"
                                                data-toggle="modal" data-target="#modal-form-view-{{ $salon->id }}"
                                                style="font-size: 20px;" data-salon-id="{{ $salon->id }}"></button>

                                        </div>
                                        <style>
                                            .modal-custom {
                                                max-width: 80%;

                                            }
                                        </style>
                                        <div class="modal fade" id="modal-form-view-{{ $salon->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-custom">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <div class="row text-center">
                                                            <div class="product-name col-sm-4">
                                                                <h3>ID: {{ $salon->id }}</h3>
                                                            </div>
                                                            <div class="product-name col-sm-4">
                                                                <h1><strong>{{ $salon->nombre }}</strong></h1>
                                                            </div>
                                                            <div class="product-name col-sm-4">
                                                                <h3>Descripción: {{ $salon->descripcion }}</h3>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div id="maquinas-content" class="row">
                                                            <!-- Aquí se cargarán dinámicamente las máquinas -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="modal-form-update-{{ $salon->id }}" class="modal fade"
                                            aria-hidden="true">
                                            <form role="form" method="POST"
                                                action="{{ route('salones.update', $salon->id) }}">
                                                @method('PUT')
                                                @csrf
                                                <input type="hidden" name="currentURL" value="{{ $pageData->currentURL }}">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-sm-12 b-r">
                                                                    <div class="form-group"><label>
                                                                            <h3 class="m-t-none m-b">Nombre</h3>
                                                                        </label><input type="text" name="nombre"
                                                                            class="form-control"
                                                                            value="{{ old('nombre', $salon->nombre) }}">
                                                                    </div>

                                                                    <div class="form-group"><label>
                                                                            <h3 class="m-t-none m-b">Descripcion</h3>
                                                                        </label><input type="text" name="descripcion"
                                                                            class="form-control"
                                                                            value="{{ old('descripcion', $salon->descripcion) }}">
                                                                    </div>

                                                                    <div>
                                                                        <button
                                                                            class="btn btn-primary btn-sm m-t-n-xs float-right"
                                                                            type="submit"><i
                                                                                class="fa fa-check"></i>&nbsp;Confirmar</button>

                                                                    </div>

                                                                </div>
                                                            </div>
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
                @endforeach
            </div>
            @if($hasPagination === true)
                <div class="row mb-5 mb-md-4">
                    <div class="col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-start align-items-center gap-10 my-3">
                        @if($pageData->lastPage > 2 && $pageData->currentPage !== 1)
                            <a href="{{ $salones->url(1) }}" class="btn btn-outline-dark rounded-5">
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



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const salon = document.getElementById('salones');
            if (salon) {
                salon.classList.add('active');
            } else {
                console.error("El elemento con el id 'salones' no se encontró en el DOM.");
            }
        });
    </script>

    <script>
        /*
        function confirmDelete(id) {
            alertify.confirm("¿Deseas eliminar este registro?", function(e) {
                if (e) {
                    let form = document.createElement('form')
                    form.method = 'POST'
                    form.action = `/salones/${id}`
                    form.innerHTML = '@csrf @method('DELETE')'
                    document.body.appendChild(form)
                    form.submit()
                } else {
                    return false
                }
            });
        }
        */
    </script>
    <script>
        $(document).ready(function() {
            $('.modal').on('show.bs.modal', function(event) {
                var salonId = $(event.relatedTarget).data('salon-id');
                var modal = $(this);
                $.ajax({
                    url: '/salones/' + salonId + '/maquinas',
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        var maquinasHtml = '';
                        $.each(response, function(index, maquina) {
                            maquinasHtml += '<div class="col-md-4">';
                            maquinasHtml += '<div class="ibox">';
                            maquinasHtml += '<div class="ibox-content product-box">';
                            maquinasHtml += '<div class="row">';
                            maquinasHtml += '<div class="col-sm-6 b-r>';

                            maquinasHtml += '<h2 class="text-center"> ' + maquina.nombre + '</h2>';
                            maquinasHtml += '<p class="text-center"><img src="{{asset('img/pc.jpg')}}" class="rounded-circle h-150"></p>';
                            
                            maquinasHtml += '<form method="POST" action="/salones/' + maquina.id + '/activar-inactivar-maquina">';
                            maquinasHtml += '@csrf'; 
                            maquinasHtml += '<button type="submit" class="btn btn-' + (maquina.estado ? 'outline-success' : 'danger') + ' btn-primary dim btn-xs">';
                            maquinasHtml += '<span>' + (maquina.estado ? 'Activo' : 'Inactivo') + '</span>';
                            maquinasHtml += '</button>';
                            maquinasHtml += '</form>';

                            maquinasHtml += '</div>';
                            maquinasHtml += '<div class="col-md-6">';
                            maquinasHtml += '<form role="form">';
                            maquinasHtml += '<dl class="row mb-2">';
                            maquinasHtml += '<div class="col-sm-12 text-sm-left">';
                            maquinasHtml += '<dt>ID:</dt>';
                            maquinasHtml += '<dd class="sm-2">' + maquina.id + '</dd>';
                            maquinasHtml += '</div>';
                            maquinasHtml += '</dl>';
                            maquinasHtml += '<dl class="row mb-2">';
                            maquinasHtml += '<div class="col-sm-12 text-sm-left">';
                            maquinasHtml += '<dt>Detalles Tecnicos:</dt>';
                            maquinasHtml += '<dd class="sm-2">' + maquina.detalles_tecnicos + '</dd>';
                            maquinasHtml += '</div>';
                            maquinasHtml += '</dl>';
                            maquinasHtml += '<dl class="row mb-2">';
                            maquinasHtml += '<div class="col-sm-12 text-sm-left">';
                            maquinasHtml += '<dt>Numero Identificador:</dt>';
                            maquinasHtml += '<dd class="sm-2">' + maquina.num_identificador + '</dd>';
                            maquinasHtml += '</div>';
                            maquinasHtml += '</dl>';
                            maquinasHtml += '<dl class="row mb-2">';
                            maquinasHtml += '<div class="col-sm-12 text-sm-left">';
                            maquinasHtml += '<dt>Salon Asignado</dt>';
                            maquinasHtml += '<dd class="sm-2">' + maquina.salon_id + '</dd>';
                            maquinasHtml += '</div>';
                            maquinasHtml += '</dl>';
                            maquinasHtml += '</div>';
                            maquinasHtml += '</form>';
                            
                            maquinasHtml += '</div>';
                            maquinasHtml += '</div>';
                            maquinasHtml += '</div>';
                            maquinasHtml += '</div>';
                        });
                        modal.find('#maquinas-content').html(maquinasHtml);
                    },
                    error: function() {
                        alert('Error al cargar las máquinas del salón.');
                    }
                });
            });
        });
    </script>


</body>

</html>