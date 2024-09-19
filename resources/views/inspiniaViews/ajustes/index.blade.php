<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AJUSTES</title>
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
                    <li class="breadcrumb-item active">
                        <a href="/ajustes"><strong>Ajustes</strong></a>
                    </li>
                </ol>
            </div>
        </div>

        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-5">
                    <div class="ibox ">
                        <div class="show-grid container-fluid">
                            <div class="row">
                                <div class="col-sm-3">
                                    <img src={{asset('img/svg/institucion.svg')}} class="">
                                </div>
                                <div class="col-sm">
                                    <h4><strong>Institución</strong></h4>
                                    <p>Tabla de instituciones</p>
                                </div>
                                <div class="col-sm-2">
                                    <a class="btn btn-success" href="/institucion"><i class="fa fa-cog"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="ibox ">
                        <div class="show-grid container-fluid">
                            <div class="row">
                                <div class="col-sm-3">
                                    <img src={{asset('img/svg/carrera.svg')}} class="">
                                </div>
                                <div class="col-sm">
                                    <h4><strong>Carrera</strong></h4>
                                    <p>Tabla de carreras academicas</p>
                                </div>
                                <div class="col-sm-2">
                                    <a class="btn btn-success" href="/carreras"><i class="fa fa-cog"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <div class="row">
                <div class="col-lg-5">
                    <div class="ibox ">
                        <div class="show-grid container-fluid">
                            <div class="row">
                                <div class="col-sm-3">
                                    <img src={{asset('img/svg/curso.svg')}} class="">
                                </div>
                                <div class="col-sm">
                                    <h4><strong>Cursos</strong></h4>
                                    <p>Tabla de cursos</p>
                                </div>
                                <div class="col-sm-2">
                                    <a class="btn btn-success" href="/cursos"><i class="fa fa-cog"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="ibox ">
                        <div class="show-grid container-fluid">
                            <div class="row">
                                <div class="col-sm-3">
                                    <img src={{asset('img/svg/programa.svg')}} class="">
                                </div>
                                <div class="col-sm">
                                    <h4><strong>Programas</strong></h4>
                                    <p>Tabla de programas</p>
                                </div>
                                <div class="col-sm-2">
                                    <a class="btn btn-success" href="/programas"><i class="fa fa-cog"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="ibox ">
                        <div class="show-grid container-fluid">
                            <div class="row">
                                <div class="col-sm-3">
                                    <img src={{asset('img/svg/herramienta.svg')}} class="img-md">
                                </div>
                                <div class="col-sm">
                                    <h4><strong>Sedes</strong></h4>
                                    <p>Tabla de sedes</p>
                                </div>
                                <div class="col-sm-2">
                                    <a class="btn btn-success" href="/sedes"><i class="fa fa-cog"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="ibox ">
                        <div class="show-grid container-fluid">
                            <div class="row">
                                <div class="col-sm-3">
                                    <img src={{asset('img/svg/herramienta.svg')}} class="img-md">
                                </div>
                                <div class="col-sm">
                                    <h4><strong>Objetos</strong></h4>
                                    <p>Tabla de objetos de la empresa</p>
                                </div>
                                <div class="col-sm-2">
                                    <a class="btn btn-success" href="/objeto"><i class="fa fa-cog"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="ibox ">
                        <div class="show-grid container-fluid">
                            <div class="row">
                                <div class="col-sm-3">
                                    <img src={{asset('img/svg/carrera.svg')}} class="">
                                </div>
                                <div class="col-sm">
                                    <h4><strong>Actividades</strong></h4>
                                    <p>Tabla de Actividades Recreativas</p>
                                </div>
                                <div class="col-sm-2">
                                    <a class="btn btn-success" href="/actividades"><i class="fa fa-cog"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="ibox ">
                        <div class="show-grid container-fluid">
                            <div class="row">
                                <div class="col-sm-3">
                                    <img src={{asset('img/svg/herramienta.svg')}} class="img-md">
                                </div>
                                <div class="col-sm">
                                    <h4><strong>Responsabilidades</strong></h4>
                                    <p>Tabla de Responsabilidades</p>
                                </div>
                                <div class="col-sm-2">
                                    <a class="btn btn-success" href="/responsabilidad"><i class="fa fa-cog"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        @include('components.inspinia.footer-inspinia')
    </div>
    </div>

</body>

</html>
