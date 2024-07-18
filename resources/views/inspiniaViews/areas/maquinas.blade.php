<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>INSPINIA | AREA MAQUINAS</title>
</head>

<body>
    <div id="wrapper">
        @include('components.inspinia.side_nav_bar-inspinia')

        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-10">
                <h2>Área Máquinas</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.html">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a>Area</a>
                    </li>
                    <li class="breadcrumb-item active">
                        <strong>Maquinas</strong>
                    </li>
                </ol>
            </div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight col-md-12">
            <div class="row">
                @foreach ($maquinas as $index => $maquina)
                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 {{ $maquina->otraArea ? 'disabled' : '' }} ">
                    <div class="ibox">
                        <div class="ibox-content product-box">

                            <div class="product-imitation">
                                <img src="{{ asset('img/pc.jpg') }}" class="rounded-circle" alt="">
                            </div>
                            <div class="product-desc">
                                <div style="display: flex; justify-content:space-around;" class="product-name">
                                    <h2> {{ $maquina->nombre }}</h2>

                                </div>

                                <small class="text-muted text-center mt-5">
                                    <h4>
                                        <strong>Colaborador Asignado:</strong> <span>{{ $maquina->colaborador }}</span>
                                    </h4>
                                </small>
                                <hr>
                                <div class="d-flex justify-content-around align-items-center">
                                    <button class="btn btn-success btn-md"
                                        href="#ModalAsignColabMachine-{{$maquina->id}}" data-toggle="modal"
                                        type="button">
                                        Asignar Colaborador
                                    </button>
                                    <div id="ModalAsignColabMachine-{{$maquina->id}}" class="modal fade"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <form method="POST"
                                                        action="{{route('areas.asignarMaquinaColab', ['area_id' => $area->id, 'maquina_id' => $maquina->id])}}"
                                                        role="form">
                                                        @csrf
                                                        <div class="d-flex flex-column gap-20">
                                                            <div>
                                                                <h1>Asignar Colaborador</h1>
                                                                <h3>Maquina ID: {{$maquina->id}}</h3>
                                                            </div>
                                                            <div>
                                                                <select class="form-control" name="colaborador_area_id">
                                                                    @foreach($colaboradoresArea as $key => $colaborador)
                                                                    @if($colaborador->id === $maquina->colaborador_id)
                                                                    <option value="{{$colaborador->id}}" selected>
                                                                        {{$colaborador->nombre}}</option>
                                                                    @endif
                                                                    @if($colaborador->hasMaquina == false)
                                                                    <option value="{{$colaborador->id}}">
                                                                        {{$colaborador->nombre}}</option>
                                                                    @endif
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div>
                                                                <button class="btn btn-success"
                                                                    type="submit">Asignar</button>
                                                                <a href="" class="btn btn-secondary">Cancelar</a>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>\
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


</body>

</html>