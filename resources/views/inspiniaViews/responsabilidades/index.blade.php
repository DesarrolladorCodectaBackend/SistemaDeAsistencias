<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>INSPINIA | RESPONSABILIDADES</title>
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
                        <strong>Áreas</strong>
                    </li>
                </ol>
            </div>
        </div>

        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                @foreach ($areas as $index => $area)
                    @if ($index % 4 == 0)
            </div>
            <div class="row">
                @endif
                <div class="col-md-3">
                    <div class="ibox">
                        <div class="ibox-content product-box">
                            <div class="product-imitation">
                                <img src="{{ asset('storage/areas/' . $area->icono) }}" alt="" class="img-lg">
                            </div>
                            <div class="product-desc">
                                <button class="btn btn-outline btn-primary dim float-right"
                                    type="button"><span>ON</span></button>
                                <small class="text-muted">{{ $area->id }}</small>
                                <a href="#" class="product-name">{{ $area->especializacion }}</a>
                                <div class="small m-t-xs">
                                    {{ $area->descripcion }}
                                </div>
                                <div class="m-t text-righ">
                                    <form method="GET"
                                        action="{{ route('responsabilidades.meses', $area->id) }}">
                                        <button class="btn btn-success" type="submit"><i class="fa fa-paste"></i> Meses</button>
                                    </form>
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