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
                @foreach ($meses as $index => $mes)
                    @if ($index % 4 == 0)
            </div>
            <div class="row">
                @endif
                <div class="col-md-3">
                    <div class="ibox">
                        <div class="ibox-content product-box">
                            <div class="product-desc text-center">
                                <!---<span class="product-price">
                                    ON
                                </span>
                                -->


                                <a href="#" class="product-name">{{$mes['nombre']}}</a>

                                <div class="text-lg m-t-xs">
                                    Semanas Evaluadas: 4
                                </div>
                                <div class="text-lg m-t-xs">
                                    Semanas sin Evaluar: 0
                                </div>
                                <div class="m-t text-righ">
                                    <button class="btn btn-danger btn-circle" type="button">
                                    </button>
                                    <a class="" href="responsabilidades-asis.html">Terminado</a>
                                </div>

                                </button>
                                <div class="m-t text-righ">
                                    <a class="btn btn-success" href="responsabilidades-terminado.html">Ver</a>
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
