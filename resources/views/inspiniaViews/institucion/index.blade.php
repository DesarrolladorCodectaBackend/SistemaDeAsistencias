<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>INSPINIA| Instituciones</title>
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
                        <a href="configuracion.html">Ajustes</a>
                    </li>
                    <li class="breadcrumb-item active">
                        <strong>Institucion</strong>
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
                                <div class="row">
                                    <div class="col-sm-6">
                                        <h3 class="m-t-none m-b">Ingrese los Datos</h3>

                                        <!--
                                                                <p>Sign in today for more expirience.</p> 
                                                            -->

                                        <form role="form" method="POST" action="{{ route('institucion.store') }}">
                                            @csrf
                                            <div class="form-group"><label>Institucion</label> <input type="text"
                                                    placeholder="Ingrese un nombre" name="nombre" class="form-control">
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
                                <th class="col-lg-5">Institucion</th>
                                <th class="col-lg-1">Estado</th>
                                <th class="col-lg-1">Editar</th>
                                <th class="col-lg-1">Borrar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($institucion as $insti)
                            <tr>
                                <td>{{ $insti->id }}</td>
                                <td>{{ $insti->nombre }}</td>
                                <td><form method="POST" action="{{ route('institucion.activarInactivar', $insti->id) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-{{ $insti->estado ? 'outline-success' : 'danger' }} btn-primary dim">
                                        <span>{{ $insti->estado ? 'Activo' : 'Inactivo' }}</span>
                                    </button>
                                </form></td>
                                <td><button class="btn btn-info" type="button" href="#modal-form{{ $insti->id }}" data-toggle="modal"><i
                                            class="fa fa-paste"></i></button></td>
                                <div id="modal-form{{ $insti->id }}" class="modal fade" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-sm-6 b-r">
                                                        <h3 class="m-t-none m-b">Editar</h3>

                                                        <!--
                                                            <p>Sign in today for more expirience.</p> 
                                                        -->

                                                        <form role="form" method="POST"
                                                            action="{{ route('institucion.update', $insti->id) }}">
                                                            @csrf
                                                            @method('PUT')
                                                            <label class="col-form-label">Institucion</label>
                                                            <div class="form-group"><label>Nombre</label>
                                                                <input type="text" placeholder="....."
                                                                    class="form-control" name="nombre" id="nombre"
                                                                    value="{{ old('nombre', $insti->nombre) }}">
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
                                <td><button class="btn btn-danger" type="button"
                                    onclick="confirmDelete({{ $insti->id }})"><i
                                        class="fa fa-trash-o"></i></button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        



























        @include('components.inspinia.footer-inspinia')

    </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ajustes = document.getElementById('ajustesCont');
            if (ajustes) {
                ajustes.classList.add('active');
            } else {
                console.error("El elemento con el id 'ajustesCont' no se encontró en el DOM.");
            }
        });
        document.addEventListener('DOMContentLoaded', function() {
            const institucion = document.getElementById('instituciones');
            if (institucion) {
                institucion.classList.add('active');
            } else {
                console.error("El elemento con el id 'instituciones' no se encontró en el DOM.");
            }
        });
    </script>

    <script>
        function confirmDelete(id) {
            alertify.confirm("¿Deseas eliminar este registro?", function(e) {
                if (e) {
                    let form = document.createElement('form')
                    form.method = 'POST'
                    form.action = `/institucion/${id}`
                    form.innerHTML = '@csrf @method('DELETE')'
                    document.body.appendChild(form)
                    form.submit()
                } else {
                    return false
                }
            });
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var estadoCheckbox = document.getElementById('estado');
            var estadoHidden = document.getElementById('estado_hidden');
            
            estadoCheckbox.addEventListener('change', function () {
                if (this.checked) {
                    estadoHidden.value = '1';
                } else {
                    estadoHidden.value = '0';
                }
            });
        });
    </script>


</body>

</html>