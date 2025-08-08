<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/responsabilidades/index.css') }}">
    <title>INSPINIA | RESPONSABILIDADES</title>
</head>

<body>
    <div id="wrapper">
        @include('components.inspinia.side_nav_bar-inspinia')

        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-10">
                <h2>Responsabilidades</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{route('dashboard')}}">Inicio</a>
                    </li>
                    <li class="breadcrumb-item active">
                        <strong>Responsabilidades - Áreas</strong>
                    </li>
                </ol>
            </div>
        </div>

        @if(!empty($warning))
            <div class="alert alert-warning">
                <strong>Advertencia:</strong> {{ $warning }}
            </div>
        @endif




        <div class="search-container">
            <div class="search-bar">
                <form method="GET" action="{{ route('buscar.responsabilidades') }}" class="d-flex form-content">
                    <input
                        type="text"
                        name="buscar_responsabilidad"
                        class="form-control me-2"
                        placeholder="Responsabilidad..."
                        value="{{ request('buscar.responsabilidades') }}"
                        autocomplete="off"
                        id="buscar"
                    >

                    <button type="submit" class="btn-buscar">
                        <div class="search-icon">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                height="24"
                                viewBox="0 0 24 24"
                                width="24"
                            >
                                <path d="M0 0h24v24H0z" fill="none"></path>
                                <path
                                    d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zM9.5 14C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"
                                ></path>
                            </svg>
                        </div>
                    </button>
                    <button type="button" id="limpiar" class="btn-limpiar">
                        <div class="search-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24" width="24" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M16.24 3c-.39 0-.77.15-1.06.44L3.44 15.18c-.59.59-.59 1.54 0 2.12l3.3 3.3c.59.59 1.54.59 2.12 0L21.24 8.24c.59-.59.59-1.54 0-2.12l-3.3-3.3A1.49 1.49 0 0 0 16.24 3zM7.88 20 4 16.12 13.06 7.06 17 11l-9.12 9z"/>
                            </svg>

                            <path d="M0 0h24v24H0z" fill="none"></path>
                            <path
                                M16.24 3c-.39 0-.77.15-1.06.44L3.44 15.18c-.59.59-.59 1.54 0 2.12l3.3 3.3c.59.59 1.54.59 2.12 0L21.24 8.24c.59-.59.59-1.54 0-2.12l-3.3-3.3A1.49 1.49 0 0 0 16.24 3zM7.88 20 4 16.12 13.06 7.06 17 11l-9.12 9z
                            ></path>
                        </svg>
                        </div>
                    </button>

                </form>
            </div>
        </div>


        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                @foreach ($areas as $index => $area)
                    <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3">
                        <div class="ibox">
                            <div class="ibox-content product-box">
                                <div class="product-imitation" style="object-fit: cover; padding: 0px; height: 225px;" onclick="onClickArea('{{ $area->id }}')">
                                    <img src="{{ asset('storage/areas/' . $area->icono) }}" alt="" style="height: 100%; width: 100%; object-fit: cover"  class="img-cover">
                                </div>
                                <div class="product-desc">
                                    {{-- <button class="btn btn-outline btn-primary dim float-right"
                                        type="button"><span>ON</span></button> --}}
                                    <small class="text-muted">{{ $area->id }}</small>
                                    <a href="#" class="product-name">{{ $area->especializacion }}</a>
                                    <div class="small m-t-xs">
                                        {{ $area->descripcion }}
                                    </div>

                                    <div class="m-t text-righ flex-centered gap-20">
                                        @if ($countYears > 1)
                                            <form method="GET"
                                                action="{{ route('responsabilidades.years', $area->id) }}">
                                                <button class="btn btn-success" type="submit"><i
                                                        class="fa fa-paste"></i>
                                                    Años</button>
                                            </form>
                                        @endif
                                        <form method="GET"
                                            action="{{ route('responsabilidades.meses', ['year' => $currentYear, 'area_id' => $area->id]) }}">
                                            <button class="btn btn-success" type="submit"><i class="fa fa-paste"></i>
                                                Meses</button>
                                        </form>
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
                            <a href="{{ $areas->url(1) }}" class="btn btn-outline-dark rounded-5">
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

<script>
    const buscador = document.getElementById("buscar");
    const btnLimpiar = document.getElementById("limpiar");

    function limpiarBuscador(){
    buscador.value = "";
    }

    limpiar.addEventListener("click",limpiarBuscador)
</script>
</body>

</html>
