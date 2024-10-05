<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>INSPINIA| Sedes</title>
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
                <h2>Gestión Sedes</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="/dashboard">Inicio</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="/Ajustes">Ajustes</a>
                    </li>
                    <li class="breadcrumb-item active">
                        <strong>Sedes</strong>
                    </li>
                </ol>
            </div>
            {{--Inicio Modal--}}
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
                                        <form role="form" method="POST" action="{{ route('sedes.store') }}">
                                            @csrf
                                            <div class="form-group">
                                                <label>Nombre: </label>
                                                <input type="text" placeholder="Ingrese un nombre" name="nombre"
                                                    class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Institución: </label>
                                                <select class="form-control" name="institucion_id">
                                                    @foreach($instituciones as $institucion)
                                                    <option value="{{$institucion->id}}">{{$institucion->nombre}}
                                                    </option>
                                                    @endforeach
                                                </select>
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
            {{--Término Modal--}}

        </div>

        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Tabla</h5>
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
                    <table class="table table-striped table-bordered table-hover dataTables-example">
                        <thead>
                            <tr>

                                <th class="col-lg-1 text-center">ID</th>
                                <th class="col-lg-5 text-center">Sede</th>
                                <th class="col-lg-4 text-center">Institución</th>
                                <th class="col-lg-1 text-center">Estado</th>
                                <th class="col-lg-1 text-center oculto">Editar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sedes as $sede)
                            <tr>
                                <td class="text-center">{{ $sede->id }}</td>
                                <td>{{ $sede->nombre }}</td>
                                <td>{{ $sede->institucion->nombre }}</td>
                                <td class="text-center">
                                    <form method="POST" action="{{ route('sedes.activarInactivar', $sede->id) }}">
                                        @csrf
                                        <button type="submit"
                                            class="btn btn-{{ $sede->estado ? 'outline-success' : 'danger' }} btn-primary dim">
                                            <span>{{ $sede->estado ? 'Activado' : 'Inactivo' }}</span>
                                        </button>
                                    </form>
                                </td>
                                <td class="text-center oculto"><button class="btn btn-info" type="button"
                                        href="#modal-form{{ $sede->id }}" data-toggle="modal"><i
                                            class="fa fa-paste"></i></button></td>
                                <div id="modal-form{{ $sede->id }}" class="modal fade" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <div class="row"
                                                    style="display: flex; justify-content:center; align-items:center">
                                                    <div class="col-sm-11 b-r">
                                                        <h3 class="m-t-none m-b">Editar</h3>
                                                        <form role="form" method="POST"
                                                            action="{{ route('sedes.update', $sede->id) }}">
                                                            @csrf
                                                            @method('PUT')
                                                            <label class="col-form-label">Institución</label>
                                                            <div class="form-group"><label>Nombre</label>
                                                                <input type="text" placeholder="....."
                                                                    class="form-control" name="nombre" id="nombre"
                                                                    value="{{ old('nombre', $sede->nombre) }}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Institución: </label>
                                                                <select class="form-control" name="institucion_id">
                                                                    @foreach($instituciones as $institucion)

                                                                    <option value="{{$institucion->id}}"
                                                                        @if($sede->institucion_id === $institucion->id)
                                                                        selected
                                                                        @endif>
                                                                        {{$institucion->nombre}}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
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
                    pageLength: 10,
                    responsive: true,
                    dom: '<"html5buttons"B>lTfgitp',
                    buttons: [
                        { extend: 'copy', exportOptions: { columns: ':not(.oculto)' }},
                        { extend: 'csv', exportOptions: { columns: ':not(.oculto)' }},
                        { extend: 'excel', title: 'SEDES', exportOptions: { columns: ':not(.oculto)' }},
                        { extend: 'pdf',
                        title: 'SEDES',
                        exportOptions: { columns: ':not(.oculto)' },
                        customize: function(doc) {
                            // tamaño fuente
                            doc.defaultStyle.fontSize = 10;

                            // Ajustar el ancho de las columnas para ocupar todo el espacio disponible
                            var columnCount = doc.content[1].table.body[0].length;
                            var columnWidths = [];
                            if (columnCount <= 4) {
                                columnWidths = Array(columnCount).fill('*');
                            } else {
                                columnWidths = Array(columnCount).fill('auto');
                            }
                            doc.content[1].table.widths = columnWidths;

                            // Estilo de la cabecera
                            doc.styles.tableHeader = {
                                fillColor: '#4682B4',
                                color: 'white',
                                alignment: 'center',
                                bold: true,
                                fontSize: 12
                            };

                            // Ajustar los márgenes de la página
                            doc.pageMargins = [20, 20, 20, 20]; }},
                        { extend: 'print',
                          customize: function (win){
                                $(win.document.body).addClass('white-bg');
                                $(win.document.body).css('font-size', '10px');
                                $(win.document.body).find('table')
                                    .addClass('compact');
                                $(win.document.body).find('thead th.oculto').css('display', 'none');
                                $(win.document.body).find('tbody td.oculto').css('display', 'none');
                          },
                          exportOptions: { columns: ':not(.oculto)' }
                        }
                    ],
                    language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
                }
                });
            });
        </script>

    </script>
</body>

</html>
