<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>INSPINIA| Programas</title>
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <link href="../../font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="../../css/plugins/switchery/switchery.css" rel="stylesheet">

    <!-- Toastr style -->
    <link href="../../css/plugins/toastr/toastr.min.css" rel="stylesheet">

    <link href="../../css/animate.css" rel="stylesheet">
    <link href="../../css/style.css" rel="stylesheet">
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
                        <strong>Programas</strong>
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
                                <form role="form" method="POST" action="{{ route('programas.store') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-sm-6 b-r">
                                            <h3 class="m-t-none m-b">Ingrese los Datos</h3>
                                            <div class="form-group"><label>Programa</label> <input type="text"
                                                    placeholder="....." class="form-control" name="nombre">
                                            </div>
                                            <div class="form-group"><label>Descripcion</label> <input type="text"
                                                    placeholder="....." class="form-control" name="descripcion">
                                            </div>

                                        </div>
                                        <div class="col-sm-6">
                                            <h4>Subir Icono</h4>
                                            <input type="file" class="form-control-file" id="icono"
                                                name="icono" style="display: none;">
                                            <!-- Icono que simula el clic en el botón de subir archivos -->
                                            <button type="button" class="btn btn-link" id="icon-upload">
                                                <i class="fa fa-cloud-download big-icon"></i>
                                            </button>
                                        </div>
                                        <div>
                                            <a href="areas"
                                                class="btn btn-white btn-sm m-t-n-xs float-left">Cancelar</a>
                                            <button class="btn btn-primary btn-sm m-t-n-xs float-right"
                                                type="submit"><i class="fa fa-check"></i>&nbsp;Confirmar</button>
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
                                <th class="col-lg-4">Programa</th>
                                <th class="col-lg-5">Descripcion</th>
                                <th class="col-lg-1 child-center">Estado</th>
                                <th class="col-lg-1 child-center">Imagen</th>
                                <th class="col-lg-1 child-center">Editar</th>
                                <th class="col-lg-1 child-center">Borrar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($programas as $programa)
                                <tr>
                                    <td>{{ $programa->id }}</td>
                                    <td>{{ $programa->nombre }}</td>
                                    <td>{{ $programa->descripcion }}</td>
                                    <td class="child-center">
                                        <form method="POST"
                                            action="{{ route('programas.activarInactivar', $programa->id) }}">
                                            @csrf
                                            <button type="submit"
                                                class="btn btn-{{ $programa->estado ? 'outline-success' : 'danger' }} btn-primary dim">
                                                <span>{{ $programa->estado ? 'Activo' : 'Inactivo' }}</span>
                                            </button>
                                        </form>
                                    </td>
                                    <td class="child-center"><img src="{{ asset('storage/programas/' . $programa->icono) }}"
                                            style="height: 50px; width: 50px; border-radius: 10px" class="img-cover" alt=""></td>
                                    <td class="child-center"><button class="btn btn-info" type="button"
                                            href="#modal-form{{ $programa->id }}" data-toggle="modal"><i
                                                class="fa fa-paste"></i></button></td>
                                    <div id="modal-form{{ $programa->id }}" class="modal fade" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <form role="form" method="POST"
                                                        action="{{ route('programas.update', $programa->id) }}" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="row">
                                                            <div class="col-sm-6 b-r">
                                                                <h3 class="m-t-none m-b">Editar</h3>
                                                                <label class="col-form-label">Programas</label>
                                                                <div class="form-group"><label>Nombre</label>
                                                                    <input type="text" placeholder="....."
                                                                        class="form-control" name="nombre"
                                                                        id="nombre"
                                                                        value="{{ old('nombre', $programa->nombre) }}">
                                                                </div>
                                                                <div class="form-group"><label>Descripcion</label>
                                                                    <input type="text" placeholder="....."
                                                                        class="form-control" name="descripcion"
                                                                        id="descripcion"
                                                                        value="{{ old('nombre', $programa->nombre) }}">
                                                                </div>

                                                            </div>
                                                            <div class="col-sm-6 b-r">
                                                                <h4>Subir Icono</h4>
                                                                <input type="file" class="form-control-file"
                                                                    id="icono-{{ $programa->id }}" name="icono"
                                                                    value="{{ old('icono', $programa->icono) }}"
                                                                    style="display: none;">
                                                                <button type="button" class="btn btn-link"
                                                                    id="icon-upload-{{ $programa->id }}">
                                                                    <i class="fa fa-cloud-download big-icon"></i>
                                                                </button>
                                                                <script>
                                                                    document.getElementById('icon-upload-{{ $programa->id }}').addEventListener('click', function() {
                                                                        document.getElementById('icono-{{ $programa->id }}').click();
                                                                    });
                                                                </script>
                                                                <button
                                                                    class="btn btn-primary btn-sm m-t-n-xs float-right"
                                                                    type="submit"><i
                                                                        class="fa fa-check"></i>&nbsp;Confirmar</button>
                                                            </div>
                                                        </div>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <td class="child-center"><button class="btn btn-danger" type="button"
                                            onclick="confirmDelete({{ $programa->id }})"><i
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
        const hiddenFileInput = document.getElementById('icono');
        const iconUploadButton = document.getElementById('icon-upload');

        iconUploadButton.addEventListener('click', function() {
            hiddenFileInput.click();
        });
    </script>
    <script>
        function confirmDelete(id) {
            alertify.confirm("¿Deseas eliminar este registro?", function(e) {
                if (e) {
                    let form = document.createElement('form')
                    form.method = 'POST'
                    form.action = `/programas/${id}`
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
        document.addEventListener('DOMContentLoaded', function() {
            var estadoCheckbox = document.getElementById('estado');
            var estadoHidden = document.getElementById('estado_hidden');

            estadoCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    // Si está marcado, establecer el valor del campo oculto como 1 (true)
                    estadoHidden.value = '1';
                } else {
                    // Si no está marcado, establecer el valor del campo oculto como 0 (false)
                    estadoHidden.value = '0';
                }
            });
        });
    </script>

    <!-- Mainly scripts -->
    <script src="../../jsjquery-3.1.1.min.js"></script>
    <script src="../../jspopper.min.js"></script>
    <script src="../../jsbootstrap.js"></script>
    <script src="../../jsplugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="../../jsplugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="../../jsplugins/switchery/switchery.js"></script>

    <!-- Flot -->
    <script src="../../jsplugins/flot/jquery.flot.js"></script>
    <script src="../../jsplugins/flot/jquery.flot.tooltip.min.js"></script>
    <script src="../../jsplugins/flot/jquery.flot.spline.js"></script>
    <script src="../../jsplugins/flot/jquery.flot.resize.js"></script>
    <script src="../../jsplugins/flot/jquery.flot.pie.js"></script>
    <script src="../../jsplugins/flot/jquery.flot.symbol.js"></script>
    <script src="../../jsplugins/flot/jquery.flot.time.js"></script>

    <!-- Peity -->
    <script src="../../jsplugins/peity/jquery.peity.min.js"></script>
    <script src="../../jsdemo/peity-demo.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="../../jsinspinia.js"></script>
    <script src="../../jsplugins/pace/pace.min.js"></script>

    <!-- jQuery UI -->
    <script src="../../jsplugins/jquery-ui/jquery-ui.min.js"></script>

    <!-- Jvectormap -->
    <script src="../../jsplugins/jvectormap/jquery-jvectormap-2.0.2.min.js"></script>
    <script src="../../jsplugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>

    <!-- EayPIE -->
    <script src="../../jsplugins/easypiechart/jquery.easypiechart.js"></script>

    <!-- Sparkline -->
    <script src="../../jsplugins/sparkline/jquery.sparkline.min.js"></script>

    <!-- Sparkline demo data  -->
    <script src="../../jsdemo/sparkline-demo.js"></script>

    <script>
        var elem = document.querySelector('.js-switch');
        var switchery = new Switchery(elem, {
            color: '#1AB394'
        });

        var elem_2 = document.querySelector('.js-switch_2');
        var switchery_2 = new Switchery(elem_2, {
            color: '#ED5565'
        });

        var elem_3 = document.querySelector('.js-switch_3');
        var switchery_3 = new Switchery(elem_3, {
            color: '#1AB394'
        });

        var elem_4 = document.querySelector('.js-switch_4');
        var switchery_4 = new Switchery(elem_4, {
            color: '#f8ac59'
        });
        switchery_4.disable();
        var elem_5 = document.querySelector('.js-switch_5');
        var switchery_5 = new Switchery(elem_5, {
            color: '#f8ac59'
        });
        switchery_5.disable();
    </script>


</body>

</html>
