<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>INSPINIA | RESPONSABILIDADES MESES</title>
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
                        <a href="/responsabilidades">Responsabilidades</a>
                    </li>
                    <li class="breadcrumb-item active">
                        <strong>Meses</strong>
                    </li>
                </ol>
            </div>
        </div>

        <div class="wrapper wrapper-content animated fadeInRight">

            <div class="row">
                @foreach ($agrupadosPorMes as $mes => $infoMes)
                @if ($loop->iteration % 4 == 1 && !$loop->first)
            </div>
            <div class="row">
                @endif
                <div class="col-md-3">
                    <div class="ibox">
                        <div class="ibox-content product-box">
                            <div class="product-desc text-center">
                                <a href="#" class="product-name">{{ $mes }}</a>
                                <div class="text-lg m-t-xs">
                                    Semanas Evaluadas: {{ $infoMes['semanas_evaluadas'] }}
                                </div>
                                <div class="text-lg m-t-xs">
                                    Semanas sin Evaluar: {{ $infoMes['semanas_sin_evaluar'] }}
                                </div>
                                @if($infoMes['total_semanas'] == 0)

                                <div class="m-t text-righ">
                                    <button class="btn btn-gray btn-circle" type="button">
                                    </button>
                                    <a class="" href="">Próximo</a>
                                </div>
                                @elseif($infoMes['total_semanas'] == $infoMes['semanas_evaluadas'])
                                <div class="m-t text-righ">
                                    <button class="btn btn-danger btn-circle" type="button">
                                    </button>
                                    <a class="" href="">Terminado</a>
                                </div>
                                <div class="m-t text-righ">
                                    <a class="btn btn-success" href="">Ver</a>
                                </div>
                                @else
                                <div class="m-t text-righ">
                                    <button class="btn btn-primary btn-circle" type="button">
                                    </button>
                                    <a class="" href="">Activo</a>
                                </div>
                                <div class="m-t text-righ">
                                    <form method="post" action="{{ route('responsabilidades.asis', $mes) }}">
                                        @csrf
                                        <input type="hidden" name="area_id" value="{{ $area_id }}">
                                        <button type="submit" class="btn btn-success">Evaluar</button>
                                    </form>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        @include('components.inspinia.footer-inspinia')
    </div>
</body>

</html>