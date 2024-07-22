<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>DASHBOARD PRUEBA</title>
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
                        <a href="/ajustes"><strong>Ajustes</strong></a>
                    </li>
                </ol>
            </div>
            <div class="col-lg-2">
                <button class="btn btn-success dim float-right" href="#modal-form-add" data-toggle="modal" type="button">Agregar</button>
                                    <div id="modal-form-add" class="modal fade" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-sm-6 b-r"><h3 class="m-t-none m-b">Ingrese los Datos</h3>
        
                                                            <!--
                                                                <p>Sign in today for more expirience.</p> 
                                                            -->
        
                                                            <form role="form">
                                                                <div class="form-group"><label>Tipo de Configuracion</label> <input type="text" placeholder="Ingrese un nombre" class="form-control"></div>                                                              
                                                                <div>
                                                                    <button class="btn btn-primary btn-sm m-t-n-xs float-right" type="submit"><i class="fa fa-check"></i>&nbsp;Confirmar</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class="col-sm-6"><h4>Subir Icono</h4>
                                                            <p class="text-center">
                                                                <a href=""><i class="fa fa-cloud-download big-icon"></i></a>
                                                            </p>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                </div>
            </div>

        </div>
        
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-5">
                    <div class="ibox ">    
                        <div class="show-grid container-fluid">
                            <div class="row">
                                <div class="col-sm-3">
                                    <img src="{{asset('img/svg/apariencia.svg')}}" class="">
                                </div>
                                <div class="col-sm">
                                    <h4><strong>Tipo de Configuracion</strong></h4>
                                    <p>Apariencias</p>
                                </div>
                                <div class="col-sm-2">
                                    <a class="btn btn-success" href=""><i class="fa fa-cog"></i></a>
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
                                    <img src={{asset('img/svg/usuarios.svg')}} class="">
                                </div>
                                <div class="col-sm">
                                    <h4><strong>Tipo de Configuracion</strong></h4>
                                    <p>Usuarios</p>
                                </div>
                                <div class="col-sm-2">
                                    <a class="btn btn-success" href=""><i class="fa fa-cog"></i></a>
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
                                    <img src={{asset('img/svg/institucion.svg')}} class="">
                                </div>
                                <div class="col-sm">
                                    <h4><strong>Tipo de Configuracion</strong></h4>
                                    <p>Institucion</p>
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
                                    <h4><strong>Tipo de Configuracion</strong></h4>
                                    <p>Carrera</p>
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
                                    <h4><strong>Tipo de Configuracion</strong></h4>
                                    <p>Curso</p>
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
                                    <h4><strong>Tipo de Configuracion</strong></h4>
                                    <p>Programas</p>
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
                                    <h4><strong>Tipo de Configuracion</strong></h4>
                                    <p>Herramientas</p>
                                </div>
                                <div class="col-sm-2">
                                    <a class="btn btn-success" href=""><i class="fa fa-cog"></i></a>
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