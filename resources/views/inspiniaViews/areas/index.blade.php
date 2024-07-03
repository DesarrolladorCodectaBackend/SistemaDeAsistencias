<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>INSPINIA| Áreas Prueba</title>
</head>

<body>
    <div id="wrapper">
        @include('components.inspinia.side_nav_bar-inspinia')
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-10">
                <h2>Dashboards</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="">Home</a>
                    </li>
                    <li class="breadcrumb-item active">
                        <strong>Áreas</strong>
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
                                <form role="form" method="POST" action="{{ route('areas.store') }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-sm-6 b-r">
                                            <h3 class="m-t-none m-b">Ingrese los Datos</h3>
                                            <div class="form-group"><label>Especializacion</label> <input type="text"
                                                    placeholder="....." class="form-control" name="especializacion"
                                                    required>
                                            </div>
                                            <div class="form-group"><label>Descripcion</label> <input type="text"
                                                    placeholder="....." class="form-control" name="descripcion"
                                                    required>
                                            </div>
                                            <div class="form-group"><label>Color Hex</label>
                                                <input type="color" placeholder="....." class="form-control"
                                                    name="color_hex" required>
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
            <div class="row">
                @foreach ($areas as $index => $area)
                    <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3">
                        <div class="ibox">
                            <div class="ibox-content product-box">
                                <div class="product-imitation">
                                    <img src="{{ asset('storage/areas/' . $area->icono) }}" alt=""
                                        class="img-lg">
                                </div>
                                <div class="product-desc">
                                    <button class="btn btn-outline btn-primary dim float-right"
                                        type="button"><span>ON</span></button>
                                    <small class="text-muted">{{ $area->id }}</small>
                                    <a href="#" class="product-name">{{ $area->especializacion }}</a>
                                    <div class="small m-t-xs">
                                        {{ $area->descripcion }}
                                    </div>
                                    <div style="display: flex; gap: 4px" class="m-t text-left">
                                        <button class="btn btn-danger" type="button"
                                            onclick="confirmDelete({{ $area->id }})"><i
                                                class="fa fa-trash-o"></i></button>
                                        <button class="btn btn-info" type="button"
                                            href="#modal-form{{ $area->id }}" data-toggle="modal"><i
                                                class="fa fa-paste"></i> Edit</button>
                                        <form role="form" method="GET"
                                            action="{{ route('areas.getHorario', $area->id) }}">
                                            <button class="btn btn-primary fa fa-clock-o"
                                                style="font-size: 20px;"></button>
                                        </form>
                                        <form role="form" method="GET"
                                            action="{{ route('areas.getReuniones', $area->id) }}">
                                            <button class="btn btn-success fa fa-video-camera"
                                                style="font-size: 20px;"></button>
                                        </form>
                                        <div id="modal-form{{ $area->id }}" class="modal fade" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <form role="form" method="POST"
                                                            action="{{ route('areas.update', $area->id) }}"
                                                            enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="row">
                                                                <div class="col-sm-6 b-r">
                                                                    <h3 class="m-t-none m-b">Ingrese los Datos</h3>
                                                                    <div class="form-group">
                                                                        <label>Especializacion</label>
                                                                        <input type="text" placeholder="....."
                                                                            class="form-control"
                                                                            name="especializacion"
                                                                            id="especializacion"
                                                                            value="{{ old('especializacion', $area->especializacion) }}">
                                                                    </div>
                                                                    <div class="form-group"><label>Descripción</label>
                                                                        <input type="text" placeholder="....."
                                                                            class="form-control" name="descripcion"
                                                                            id="descripcion"
                                                                            value="{{ old('descripcion', $area->descripcion) }}">
                                                                    </div>
                                                                    <div class="form-group"><label>Color Hex</label>
                                                                        <input type="color" placeholder="....."
                                                                            class="form-control" name="color_hex"
                                                                            id="color_hex"
                                                                            value="{{ old('color_hex', $area->color_hex) }}">
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
                                                                    <div>
                                                                        <a href="areas"
                                                                            class="btn btn-white btn-sm m-t-n-xs float-left">Cancelar</a>
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
                @endforeach
            </div>


        </div>


        @include('components.inspinia.footer-inspinia')

    </div>
    </div>
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
                    form.action = `/areas/${id}`
                    form.innerHTML = '@csrf @method('DELETE')'
                    document.body.appendChild(form)
                    form.submit()
                } else {
                    return false
                }
            });
        }
    </script>


</body>

</html>
