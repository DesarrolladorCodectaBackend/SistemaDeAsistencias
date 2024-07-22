<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>INSPINIA| Cursos</title>
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
                        <strong>Curso</strong>
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
                                <div class="row" style="display: flex; justify-content:center; align-items:center">
                                    <div class="col-sm-11">
                                        <h3 class="m-t-none m-b">Ingrese los Datos</h3>

                                        <!--
                                                                <p>Sign in today for more expirience.</p> 
                                                            -->

                                        <form role="form" method="POST" action="{{ route('cursos.store') }}">
                                            @csrf
                                            <div class="form-group"><label>Curso</label> <input type="text"
                                                    placeholder="Ingrese un nombre" name="nombre" class="form-control">
                                            </div>
                                            <div class="form-group"><label>Categoria</label> <input type="text"
                                                placeholder="Ingrese un nombre" name="categoria" class="form-control">
                                            </div>
                                            <div class="form-group"><label>Duracion</label> <input type="text"
                                                placeholder="Ingrese un nombre" name="duracion" class="form-control">
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
                                <th class="col-lg-3">Curso</th>
                                <th class="col-lg-3">Categoria</th>
                                <th class="col-lg-1">Duracion</th>
                                <th class="col-lg-1">Estado</th>
                                <th class="col-lg-1">Editar</th>
                                <th class="col-lg-1">Borrar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cursos as $curso)
                            <tr>
                                <td>{{ $curso->id }}</td>
                                <td>{{ $curso->nombre }}</td>
                                <td>{{ $curso->categoria }}</td>
                                <td>{{ $curso->duracion }}</td>
                                <td><form method="POST" action="{{ route('cursos.activarInactivar', $curso->id) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-{{ $curso->estado ? 'outline-success' : 'danger' }} btn-primary dim">
                                        <span>{{ $curso->estado ? 'Activo' : 'Inactivo' }}</span>
                                    </button>
                                </form></td>
                                <td><button class="btn btn-info" type="button" href="#modal-form{{ $curso->id }}" data-toggle="modal"><i
                                            class="fa fa-paste"></i></button></td>
                                <div id="modal-form{{ $curso->id }}" class="modal fade" aria-hidden="true">
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
                                                            action="{{ route('cursos.update', $curso->id) }}">
                                                            @csrf
                                                            @method('PUT')
                                                            <label class="col-form-label">Cursos</label>
                                                            <div class="form-group"><label>Nombre</label>
                                                                <input type="text" placeholder="....."
                                                                    class="form-control" name="nombre" id="nombre"
                                                                    value="{{ old('nombre', $curso->nombre) }}">
                                                            </div>
                                                            <div class="form-group"><label>Categoria</label> <input type="text"
                                                                placeholder="....." name="categoria" value="{{ old('categoria', $curso->categoria) }}" class="form-control">
                                                            </div>
                                                            <div class="form-group"><label>Duracion</label> <input type="text"
                                                                placeholder="....." name="duracion" value="{{ old('duracion', $curso->duracion) }}" class="form-control">
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
                                    onclick="confirmDelete({{ $curso->id }})"><i
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
            const curso = document.getElementById('cursos');
            if (curso) {
                curso.classList.add('active');
            } else {
                console.error("El elemento con el id 'cursos' no se encontró en el DOM.");
            }
        });
    </script>

    <script>
        function confirmDelete(id) {
            alertify.confirm("¿Deseas eliminar este registro?", function(e) {
                if (e) {
                    let form = document.createElement('form')
                    form.method = 'POST'
                    form.action = `/cursos/${id}`
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