<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>INSPINIA| Objetos</title>
</head>

<body>
    <div id="wrapper">
        @include('components.inspinia.side_nav_bar-inspinia')

        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-10">
                <h2>Dashboards</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="/dashboard">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="/ajustes">Ajustes</a>
                    </li>
                    <li class="breadcrumb-item active">
                        <strong>Objeto</strong>
                    </li>
                </ol>
            </div>
            <!-- MODAL REGISTRO NOMBRE -->
            <div class="col-lg-2">
                <button class="btn btn-success dim float-right" href="#modal-form-add" data-toggle="modal"
                    type="button">Agregar</button>
                <div id="modal-form-add" class="modal fade" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="row" style="display: flex; justify-content:center; align-items:center">
                                    <div class="col-sm-11">
                                        <h3 class="m-t-none m-b">Ingrese los Datos</h3>

                                        <!--
                                                                <p>Sign in today for more expirience.</p>
                                                            -->

                                        <form role="form" method="POST" action="{{ route('objeto.store') }}">
                                            @csrf
                                            <input type="hidden" name="currentURL" value="{{ $pageData->currentURL }}">
                                            <div class="form-group"><label>Objeto</label> <input type="text"
                                                    placeholder="Ingrese un nombre" name="nombre" class="form-control">
                                            </div>
                                            <div class="form-group"><input type="text"
                                                placeholder="Ingrese una descripción" name="descripcion" class="form-control">
                                        </div>
                                            <div>
                                                <button class="btn btn-primary btn-sm m-t-n-xs float-right"
                                                    type="submit"><i class="fa fa-check"></i>&nbsp;Confirmar</button>
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

        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Border Table </h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#" class="dropdown-item">Config option 1</a>
                            </li>
                            <li><a href="#" class="dropdown-item">Config option 2</a>
                            </li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>

                <div class="ibox-content">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="col-lg-1">ID</th>
                                <th class="col-lg-2">Objeto</th>
                                <th class="col-lg-3">Descripción</th>
                                <th class="col-lg-1">Estado</th>
                                <th class="col-lg-1">Editar</th>
                                {{-- <th class="col-lg-1">Borrar</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                           {{-- ARRAY INSTITUCIONES --}}
                            @foreach ($objetos as $obj)
                            <tr>
                                <td>{{ $obj->id }}</td>
                                <td>{{ $obj->nombre }}</td>
                                <td>{{ $obj->descripcion }}</td>
                                <td><form method="POST" action="{{ route('objeto.activarInactivar', $obj->id) }}">
                                    <input type="hidden" name="currentURL" value="{{ $pageData->currentURL }}">
                                    @csrf
                                    <button type="submit" class="btn btn-{{ $obj->estado ? 'outline-success' : 'danger' }} btn-primary dim">
                                        <span>{{ $obj->estado ? 'Activo' : 'Inactivo' }}</span>
                                    </button>
                                </form></td>
                                <td><button class="btn btn-info" type="button" href="#modal-form{{ $obj->id }}" data-toggle="modal"><i
                                            class="fa fa-paste"></i></button></td>
                                <div id="modal-form{{ $obj->id }}" class="modal fade" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <div class="row" style="display: flex; justify-content:center; align-items:center">
                                                    <div class="col-sm-11 b-r">
                                                        <h3 class="m-t-none m-b">Editar</h3>

                                                        <!--
                                                            <p>Sign in today for more expirience.</p>
                                                        -->

                                                        <form role="form" method="POST"
                                                            action="{{ route('objeto.update', $obj->id) }}">
                                                            @csrf
                                                            @method('PUT')
                                                            {{-- nombre del request "name" --}}
                                                            <input type="hidden" name="currentURL" value="{{ $pageData->currentURL }}">
                                                            <label class="col-form-label">Objeto</label>
                                                            <div class="form-group"><label>Nombre</label>
                                                                <input type="text" placeholder="....."
                                                                    class="form-control" name="nombre" id="nombre"
                                                                    value="{{ old('nombre', $obj->nombre) }}">
                                                            </div>
                                                            <div class="form-group"><label>Descripción</label>
                                                                <input type="text" placeholder="....."
                                                                    class="form-control" name="descripcion" id="descripcion"
                                                                    value="{{ old('descripcion', $obj->descripcion) }}">
                                                            </div>
                                                            <div>
                                                                <button
                                                                    class="btn btn-primary btn-sm m-t-n-xs float-right"
                                                                    type="submit"><i
                                                                        class="fa fa-check"></i>&nbsp;Confirmar</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- <td><button class="btn btn-danger" type="button"
                                    onclick="confirmDelete({{ $insti->id }})"><i
                                        class="fa fa-trash-o"></i></button>
                                </td> --}}
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @if($hasPagination === true)
                <div class="row mb-5 mb-md-4">
                    <div class="col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-start align-items-center gap-10 my-3">
                        @if($pageData->lastPage > 2 && $pageData->currentPage !== 1)
                            <a href="{{ $objeto->url(1) }}" class="btn btn-outline-dark rounded-5">
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
        // function confirmDelete(id) {
        //     alertify.confirm("¿Deseas eliminar este registro?", function(e) {
        //         if (e) {
        //             let form = document.createElement('form')
        //             form.method = 'POST'
        //             form.action = `/institucion/${id}`
        //             form.innerHTML = '@csrf @method('DELETE')'
        //             document.body.appendChild(form)
        //             form.submit()
        //         } else {
        //             return false
        //         }
        //     });
        // }
    </script>


</body>

</html>
