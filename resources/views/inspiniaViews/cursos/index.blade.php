<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>INSPINIA| Cursos</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/plugins/dataTables/datatables.min.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
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
                        <strong>Curso</strong>
                    </li>
                </ol>
            </div>
            {{-- Inicio modal --}}
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
                                                placeholder="Ingrese categoria" name="categoria" class="form-control">
                                            </div>
                                            <div class="form-group"><label>Duracion</label> <input type="text"
                                                placeholder="Ingrese duracion" name="duracion" class="form-control">
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
            {{-- Término modal --}}

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
                    <div class="table-responsive">
                        <table class="table  table-striped table-bordered table-hover dataTables-example">
                            <thead>
                                <tr>
                                    <th class="col-lg-1">ID</th>
                                    <th class="col-lg-3">Curso</th>
                                    <th class="col-lg-3">Categoria</th>
                                    <th class="col-lg-1">Duracion</th>
                                    <th class="col-lg-1">Estado</th>
                                    <th class="col-lg-1 oculto">Editar</th>

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
                                            <span>{{ $curso->estado ? 'Activado' : 'Inactivo' }}</span>
                                        </button>
                                    </form></td>
                                    <td><button class="btn btn-info oculto" type="button" href="#modal-form{{ $curso->id }}" data-toggle="modal"><i
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

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
        </div>
        @include('components.inspinia.footer-inspinia')

    </div>
    </div>

    <script>
        <!-- Mainly scripts -->
        <script src="js/jquery-3.1.1.min.js"></script>
        <script src="js/popper.min.js"></script>
        <script src="js/bootstrap.js"></script>
        <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
        <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

        <script src="js/plugins/dataTables/datatables.min.js"></script>
        <script src="js/plugins/dataTables/dataTables.bootstrap4.min.js"></script>

        <!-- Custom and plugin javascript -->
        <script src="js/inspinia.js"></script>
        <script src="js/plugins/pace/pace.min.js"></script>

        <!-- Page-Level Scripts -->
        <script>
            $(document).ready(function(){
                $('.dataTables-example').DataTable({
                    pageLength: 25,
                    responsive: true,
                    dom: '<"html5buttons"B>lTfgitp',
                    buttons: [
                        { extend: 'copy', exportOptions: { columns: ':not(.oculto)' }},
                        { extend: 'csv', exportOptions: { columns: ':not(.oculto)' }},
                        { extend: 'excel', title: 'CURSOS', exportOptions: { columns: ':not(.oculto)' }},
                        { extend: 'pdf', title: 'CURSOS', exportOptions: { columns: ':not(.oculto)' }},
                        { extend: 'print',
                          customize: function (win){
                                $(win.document.body).addClass('white-bg');
                                $(win.document.body).css('font-size', '1px');
                                $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                          },
                          exportOptions: { columns: ':not(.no-export)' }
                        }
                    ]
                });
            });
        </script>

    </script>

</body>

</html>
