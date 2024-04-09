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
                        <a href="index.html">Home</a>
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
                                <div class="row">
                                    <div class="col-sm-6 b-r">
                                        <h3 class="m-t-none m-b">Ingrese los Datos</h3>

                                        <!--
                                                                <p>Sign in today for more expirience.</p> 
                                                            -->

                                        <form role="form">
                                            <div class="form-group"><label>Nombre</label> <input type="text"
                                                    placeholder="Ingrese un nombre" class="form-control"></div>
                                            <div class="form-group"><label>Descripcion</label> <input type="text"
                                                    placeholder="....." class="form-control"></div>
                                            <div class="form-group"><label>Codigo</label> <input type="text"
                                                    placeholder="....." class="form-control"></div>
                                            <div>
                                                <button class="btn btn-white btn-sm m-t-n-xs float-left"
                                                    type="submit">Cancelar</button>
                                                <button class="btn btn-primary btn-sm m-t-n-xs float-right"
                                                    type="submit"><i class="fa fa-check"></i>&nbsp;Confirmar</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-sm-6">
                                        <h4>Subir Icono</h4>
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
                <div class="col-md-3">
                    <div class="ibox">
                        <div class="ibox-content product-box">
                            <div class="product-imitation">
                                <img src="svg/001.svg" alt="" class="img-lg">
                            </div>
                            <div class="product-desc">
                                <!---<span class="product-price">
                                    ON
                                </span>
                                -->
                                <button class="btn btn-outline btn-primary dim float-right"
                                    type="button"><span>ON</span></i></button>
                                <small class="text-muted">001</small>
                                <a href="#" class="product-name"> Programacion</a>
                                <div class="small m-t-xs">
                                    Many desktop publishing packages and web page editors now.
                                </div>
                                <div class="m-t text-righ">
                                    <button class="btn btn-danger" type="button"><i class="fa fa-trash-o"></i></button>
                                    <button class="btn btn-info" type="button" href="#modal-form" data-toggle="modal"><i
                                            class="fa fa-paste"></i> Edit</button>
                                    <div id="modal-form" class="modal fade" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-sm-6 b-r">
                                                            <h3 class="m-t-none m-b">Editar</h3>

                                                            <!--
                                                                <p>Sign in today for more expirience.</p> 
                                                            -->

                                                            <form role="form">
                                                                <div class="form-group"><label>Nombre</label> <input
                                                                        type="text" placeholder="Ingrese un nombre"
                                                                        class="form-control"></div>
                                                                <div class="form-group"><label>Descripcion</label>
                                                                    <input type="text" placeholder="....."
                                                                        class="form-control">
                                                                </div>
                                                                <div class="form-group"><label>Codigo</label> <input
                                                                        type="text" placeholder="....."
                                                                        class="form-control"></div>
                                                                <div>
                                                                    <button
                                                                        class="btn btn-white btn-sm m-t-n-xs float-left"
                                                                        type="submit">Cancelar</button>
                                                                    <button
                                                                        class="btn btn-primary btn-sm m-t-n-xs float-right"
                                                                        type="submit"><i
                                                                            class="fa fa-check"></i>&nbsp;Confirmar</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <h4>Cambiar Icono</h4>
                                                            <p class="text-center">
                                                                <a href=""><i
                                                                        class="fa fa-cloud-download big-icon"></i></a>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="ibox">
                        <div class="ibox-content product-box">

                            <div class="product-imitation">
                                <img id="previewImage" src="svg/002.svg" alt="" class="img-lg">
                            </div>
                            <div class="product-desc">
                                <button class="btn btn-outline-success btn-primary dim float-right"
                                    type="button"><span>ON</span></i></button>
                                <small class="text-muted">002</small>
                                <a href="#" class="product-name"> Analisis</a>
                                <div class="small m-t-xs">
                                    Many desktop publishing packages and web page editors now.
                                </div>
                                <div class="m-t text-righ">
                                    <button class="btn btn-danger" type="button"><i class="fa fa-trash-o"></i></button>
                                    <button class="btn btn-info" type="button" href="#modal-form-edit"
                                        data-toggle="modal"><i class="fa fa-paste"></i> Edit</button>
                                    <div id="modal-form-edit" class="modal fade" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-sm-6 b-r">
                                                            <h3 class="m-t-none m-b">Editar los Datos</h3>

                                                            <!--
                                                                <p>Sign in today for more expirience.</p> 
                                                            -->

                                                            <form role="form">
                                                                <div class="form-group"><label>Nombre</label> <input
                                                                        type="text" placeholder="Ingrese un nombre"
                                                                        class="form-control"></div>
                                                                <div class="form-group"><label>Descripcion</label>
                                                                    <input type="text" placeholder="....."
                                                                        class="form-control">
                                                                </div>
                                                                <div class="form-group"><label>Codigo</label> <input
                                                                        type="text" placeholder="....."
                                                                        class="form-control"></div>
                                                                <div>
                                                                    <button
                                                                        class="btn btn-white btn-sm m-t-n-xs float-left"
                                                                        type="submit">Cancelar</button>
                                                                    <button
                                                                        class="btn btn-primary btn-sm m-t-n-xs float-right"
                                                                        type="submit"><i
                                                                            class="fa fa-check"></i>&nbsp;Confirmar</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <h4>Cambiar Icono</h4>
                                                            <p class="text-center">
                                                                <!---<a href=""><i class="fa fa-cloud-download big-icon"></i></a>-->
                                                            <div class="input-group">
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input"
                                                                        id="inputGroupFile" accept="image/*">
                                                                    <label class="custom-file-label"
                                                                        for="inputGroupFile"></label>
                                                                </div>
                                                            </div>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="ibox">
                        <div class="ibox-content product-box">

                            <div class="product-imitation">
                                <img src="svg/003.svg" alt="" class="img-lg">
                            </div>
                            <div class="product-desc">
                                <button class="btn btn-outline-success btn-primary dim float-right"
                                    type="button"><span>ON</span></i></button>
                                <small class="text-muted">003</small>
                                <a href="#" class="product-name"> Planeacion</a>
                                <div class="small m-t-xs">
                                    Many desktop publishing packages and web page editors now.
                                </div>
                                <div class="m-t text-righ">
                                    <button class="btn btn-danger" type="button"><i class="fa fa-trash-o"></i></button>
                                    <button class="btn btn-info" type="button" href="#modal-form" data-toggle="modal"><i
                                            class="fa fa-paste"></i> Edit</button>
                                    <div id="modal-form" class="modal fade" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-sm-6 b-r">
                                                            <h3 class="m-t-none m-b">Editar</h3>

                                                            <!--
                                                                <p>Sign in today for more expirience.</p> 
                                                            -->

                                                            <form role="form">
                                                                <div class="form-group"><label>Nombre</label> <input
                                                                        type="text" placeholder="Ingrese un nombre"
                                                                        class="form-control"></div>
                                                                <div class="form-group"><label>Descripcion</label>
                                                                    <input type="text" placeholder="....."
                                                                        class="form-control">
                                                                </div>
                                                                <div class="form-group"><label>Codigo</label> <input
                                                                        type="text" placeholder="....."
                                                                        class="form-control"></div>
                                                                <div>
                                                                    <button
                                                                        class="btn btn-white btn-sm m-t-n-xs float-left"
                                                                        type="submit">Cancelar</button>
                                                                    <button
                                                                        class="btn btn-primary btn-sm m-t-n-xs float-right"
                                                                        type="submit"><i
                                                                            class="fa fa-check"></i>&nbsp;Confirmar</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <h4>Cambiar Icono</h4>
                                                            <p class="text-center">
                                                                <a href=""><i
                                                                        class="fa fa-cloud-download big-icon"></i></a>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="ibox">
                        <div class="ibox-content product-box">

                            <div class="product-imitation">
                                <img src="svg/004.svg" alt="" class="img-lg">
                            </div>
                            <div class="product-desc">
                                <button class="btn btn-outline-success btn-primary dim float-right"
                                    type="button"><span>ON</span></i></button>
                                <small class="text-muted">004</small>
                                <a href="#" class="product-name"> Diseño</a>
                                <div class="small m-t-xs">
                                    Many desktop publishing packages and web page editors now.
                                </div>
                                <div class="m-t text-righ">
                                    <button class="btn btn-danger" type="button"><i class="fa fa-trash-o"></i></button>
                                    <button class="btn btn-info" type="button" href="#modal-form" data-toggle="modal"><i
                                            class="fa fa-paste"></i> Edit</button>
                                    <div id="modal-form" class="modal fade" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-sm-6 b-r">
                                                            <h3 class="m-t-none m-b">Editar</h3>

                                                            <!--
                                                                <p>Sign in today for more expirience.</p> 
                                                            -->

                                                            <form role="form">
                                                                <div class="form-group"><label>Nombre</label> <input
                                                                        type="text" placeholder="Ingrese un nombre"
                                                                        class="form-control"></div>
                                                                <div class="form-group"><label>Descripcion</label>
                                                                    <input type="text" placeholder="....."
                                                                        class="form-control">
                                                                </div>
                                                                <div class="form-group"><label>Codigo</label> <input
                                                                        type="text" placeholder="....."
                                                                        class="form-control"></div>
                                                                <div>
                                                                    <button
                                                                        class="btn btn-white btn-sm m-t-n-xs float-left"
                                                                        type="submit">Cancelar</button>
                                                                    <button
                                                                        class="btn btn-primary btn-sm m-t-n-xs float-right"
                                                                        type="submit"><i
                                                                            class="fa fa-check"></i>&nbsp;Confirmar</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <h4>Cambiar Icono</h4>
                                                            <p class="text-center">
                                                                <a href=""><i
                                                                        class="fa fa-cloud-download big-icon"></i></a>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
            <div class="row">

                <div class="col-md-3">
                    <div class="ibox">
                        <div class="ibox-content product-box">

                            <div class="product-imitation">
                                <img src="svg/005.svg" alt="" class="img-lg">
                            </div>
                            <div class="product-desc">
                                <button class="btn btn-outline-success btn-primary dim float-right"
                                    type="button"><span>ON</span></i></button>
                                <small class="text-muted">005</small>
                                <a href="#" class="product-name"> Arquitectura</a>
                                <div class="small m-t-xs">
                                    Many desktop publishing packages and web page editors now.
                                </div>
                                <div class="m-t text-righ">
                                    <button class="btn btn-danger" type="button"><i class="fa fa-trash-o"></i></button>
                                    <button class="btn btn-info" type="button" href="#modal-form" data-toggle="modal"><i
                                            class="fa fa-paste"></i> Edit</button>
                                    <div id="modal-form" class="modal fade" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-sm-6 b-r">
                                                            <h3 class="m-t-none m-b">Editar</h3>

                                                            <!--
                                                                <p>Sign in today for more expirience.</p> 
                                                            -->

                                                            <form role="form">
                                                                <div class="form-group"><label>Nombre</label> <input
                                                                        type="text" placeholder="Ingrese un nombre"
                                                                        class="form-control"></div>
                                                                <div class="form-group"><label>Descripcion</label>
                                                                    <input type="text" placeholder="....."
                                                                        class="form-control">
                                                                </div>
                                                                <div class="form-group"><label>Codigo</label> <input
                                                                        type="text" placeholder="....."
                                                                        class="form-control"></div>
                                                                <div>
                                                                    <button
                                                                        class="btn btn-white btn-sm m-t-n-xs float-left"
                                                                        type="submit">Cancelar</button>
                                                                    <button
                                                                        class="btn btn-primary btn-sm m-t-n-xs float-right"
                                                                        type="submit"><i
                                                                            class="fa fa-check"></i>&nbsp;Confirmar</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <h4>Cambiar Icono</h4>
                                                            <p class="text-center">
                                                                <a href=""><i
                                                                        class="fa fa-cloud-download big-icon"></i></a>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="ibox">
                        <div class="ibox-content product-box">

                            <div class="product-imitation">
                                <img src="svg/006.svg" alt="" class="img-lg">
                            </div>
                            <div class="product-desc">
                                <button class="btn btn-outline-success btn-primary dim float-right"
                                    type="button"><span>ON</span></i></button>
                                <small class="text-muted">006</small>
                                <a href="#" class="product-name"> Android</a>



                                <div class="small m-t-xs">
                                    Many desktop publishing packages and web page editors now.
                                </div>
                                <div class="m-t text-righ">
                                    <button class="btn btn-danger" type="button"><i class="fa fa-trash-o"></i></button>
                                    <button class="btn btn-info" type="button" href="#modal-form" data-toggle="modal"><i
                                            class="fa fa-paste"></i> Edit</button>
                                    <div id="modal-form" class="modal fade" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-sm-6 b-r">
                                                            <h3 class="m-t-none m-b">Editar</h3>

                                                            <!--
                                                                <p>Sign in today for more expirience.</p> 
                                                            -->

                                                            <form role="form">
                                                                <div class="form-group"><label>Nombre</label> <input
                                                                        type="text" placeholder="Ingrese un nombre"
                                                                        class="form-control"></div>
                                                                <div class="form-group"><label>Descripcion</label>
                                                                    <input type="text" placeholder="....."
                                                                        class="form-control">
                                                                </div>
                                                                <div class="form-group"><label>Codigo</label> <input
                                                                        type="text" placeholder="....."
                                                                        class="form-control"></div>
                                                                <div>
                                                                    <button
                                                                        class="btn btn-white btn-sm m-t-n-xs float-left"
                                                                        type="submit">Cancelar</button>
                                                                    <button
                                                                        class="btn btn-primary btn-sm m-t-n-xs float-right"
                                                                        type="submit"><i
                                                                            class="fa fa-check"></i>&nbsp;Confirmar</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <h4>Cambiar Icono</h4>
                                                            <p class="text-center">
                                                                <a href=""><i
                                                                        class="fa fa-cloud-download big-icon"></i></a>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="ibox">
                        <div class="ibox-content product-box">

                            <div class="product-imitation">
                                <img src="svg/007.svg" alt="" class="img-lg">
                            </div>
                            <div class="product-desc">
                                <button class="btn btn-outline-success btn-primary dim float-right"
                                    type="button"><span>ON</span></i></button>
                                <small class="text-muted">007</small>
                                <a href="#" class="product-name"> Inteligencia Artificial</a>



                                <div class="small m-t-xs">
                                    Many desktop publishing packages and web page editors now.
                                </div>
                                <div class="m-t text-righ">
                                    <button class="btn btn-danger" type="button"><i class="fa fa-trash-o"></i></button>
                                    <button class="btn btn-info" type="button" href="#modal-form" data-toggle="modal"><i
                                            class="fa fa-paste"></i> Edit</button>
                                    <div id="modal-form" class="modal fade" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-sm-6 b-r">
                                                            <h3 class="m-t-none m-b">Editar</h3>

                                                            <!--
                                                                <p>Sign in today for more expirience.</p> 
                                                            -->

                                                            <form role="form">
                                                                <div class="form-group"><label>Nombre</label> <input
                                                                        type="text" placeholder="Ingrese un nombre"
                                                                        class="form-control"></div>
                                                                <div class="form-group"><label>Descripcion</label>
                                                                    <input type="text" placeholder="....."
                                                                        class="form-control">
                                                                </div>
                                                                <div class="form-group"><label>Codigo</label> <input
                                                                        type="text" placeholder="....."
                                                                        class="form-control"></div>
                                                                <div>
                                                                    <button
                                                                        class="btn btn-white btn-sm m-t-n-xs float-left"
                                                                        type="submit">Cancelar</button>
                                                                    <button
                                                                        class="btn btn-primary btn-sm m-t-n-xs float-right"
                                                                        type="submit"><i
                                                                            class="fa fa-check"></i>&nbsp;Confirmar</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <h4>Cambiar Icono</h4>
                                                            <p class="text-center">
                                                                <a href=""><i
                                                                        class="fa fa-cloud-download big-icon"></i></a>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="ibox">
                        <div class="ibox-content product-box">

                            <div class="product-imitation">
                                <img src="svg/008.svg" alt="" class="img-lg">
                            </div>
                            <div class="product-desc">
                                <button class="btn btn-outline-success btn-primary dim float-right"
                                    type="button"><span>ON</span></i></button>
                                <small class="text-muted">008</small>
                                <a href="#" class="product-name"> Programacion Web</a>
                                <div class="small m-t-xs">
                                    Many desktop publishing packages and web page editors now.
                                </div>
                                <div class="m-t text-righ">
                                    <button class="btn btn-danger" type="button"><i class="fa fa-trash-o"></i></button>
                                    <button class="btn btn-info" type="button" href="#modal-form" data-toggle="modal"><i
                                            class="fa fa-paste"></i> Edit</button>
                                    <div id="modal-form" class="modal fade" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-sm-6 b-r">
                                                            <h3 class="m-t-none m-b">Editar</h3>

                                                            <!--
                                                                <p>Sign in today for more expirience.</p> 
                                                            -->

                                                            <form role="form">
                                                                <div class="form-group"><label>Nombre</label> <input
                                                                        type="text" placeholder="Ingrese un nombre"
                                                                        class="form-control"></div>
                                                                <div class="form-group"><label>Descripcion</label>
                                                                    <input type="text" placeholder="....."
                                                                        class="form-control">
                                                                </div>
                                                                <div class="form-group"><label>Codigo</label> <input
                                                                        type="text" placeholder="....."
                                                                        class="form-control"></div>
                                                                <div>
                                                                    <button
                                                                        class="btn btn-white btn-sm m-t-n-xs float-left"
                                                                        type="submit">Cancelar</button>
                                                                    <button
                                                                        class="btn btn-primary btn-sm m-t-n-xs float-right"
                                                                        type="submit"><i
                                                                            class="fa fa-check"></i>&nbsp;Confirmar</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <h4>Cambiar Icono</h4>
                                                            <p class="text-center">
                                                                <a href=""><i
                                                                        class="fa fa-cloud-download big-icon"></i></a>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="ibox">
                        <div class="ibox-content product-box">

                            <div class="product-imitation">
                                <img src="svg/009.svg" alt="" class="img-lg">
                            </div>
                            <div class="product-desc">
                                <button class="btn btn-outline btn-primary dim float-right"
                                    type="button"><span>ON</span></i></button>
                                <small class="text-muted">009</small>
                                <a href="#" class="product-name"> Videojuegos</a>
                                <div class="small m-t-xs">
                                    Many desktop publishing packages and web page editors now.
                                </div>
                                <div class="m-t text-righ">
                                    <button class="btn btn-danger" type="button"><i class="fa fa-trash-o"></i></button>
                                    <button class="btn btn-info" type="button" href="#modal-form" data-toggle="modal"><i
                                            class="fa fa-paste"></i> Edit</button>
                                    <div id="modal-form" class="modal fade" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-sm-6 b-r">
                                                            <h3 class="m-t-none m-b">Editar</h3>

                                                            <!--
                                                                <p>Sign in today for more expirience.</p> 
                                                            -->

                                                            <form role="form">
                                                                <div class="form-group"><label>Nombre</label> <input
                                                                        type="text" placeholder="Ingrese un nombre"
                                                                        class="form-control"></div>
                                                                <div class="form-group"><label>Descripcion</label>
                                                                    <input type="text" placeholder="....."
                                                                        class="form-control">
                                                                </div>
                                                                <div class="form-group"><label>Codigo</label> <input
                                                                        type="text" placeholder="....."
                                                                        class="form-control"></div>
                                                                <div>
                                                                    <button
                                                                        class="btn btn-white btn-sm m-t-n-xs float-left"
                                                                        type="submit">Cancelar</button>
                                                                    <button
                                                                        class="btn btn-primary btn-sm m-t-n-xs float-right"
                                                                        type="submit"><i
                                                                            class="fa fa-check"></i>&nbsp;Confirmar</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <h4>Cambiar Icono</h4>
                                                            <p class="text-center">
                                                                <a href=""><i
                                                                        class="fa fa-cloud-download big-icon"></i></a>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="wrapper wrapper-content">
            <div class="row">
                <div class="col-lg-8">
                </div>
                <div class="footer">
                    <div class="float-right">
                        10GB of <strong>250GB</strong> Free.
                    </div>
                    <div>
                        <strong>Copyright</strong> Example Company &copy; 2014-2018
                    </div>
                </div>
            </div>
            <div id="right-sidebar">
                <div class="sidebar-container">

                    <ul class="nav nav-tabs navs-3">
                        <li>
                            <a class="nav-link active" data-toggle="tab" href="#tab-1"> Notes </a>
                        </li>
                        <li>
                            <a class="nav-link" data-toggle="tab" href="#tab-2"> Projects </a>
                        </li>
                        <li>
                            <a class="nav-link" data-toggle="tab" href="#tab-3"> <i class="fa fa-gear"></i> </a>
                        </li>
                    </ul>

                    <div class="tab-content">


                        <div id="tab-1" class="tab-pane active">

                            <div class="sidebar-title">
                                <h3> <i class="fa fa-comments-o"></i> Latest Notes</h3>
                                <small><i class="fa fa-tim"></i> You have 10 new message.</small>
                            </div>

                            <div>

                                <div class="sidebar-message">
                                    <a href="#">
                                        <div class="float-left text-center">
                                            <img alt="image" class="rounded-circle message-avatar" src="img/a1.jpg">

                                            <div class="m-t-xs">
                                                <i class="fa fa-star text-warning"></i>
                                                <i class="fa fa-star text-warning"></i>
                                            </div>
                                        </div>
                                        <div class="media-body">

                                            There are many variations of passages of Lorem Ipsum available.
                                            <br>
                                            <small class="text-muted">Today 4:21 pm</small>
                                        </div>
                                    </a>
                                </div>
                                <div class="sidebar-message">
                                    <a href="#">
                                        <div class="float-left text-center">
                                            <img alt="image" class="rounded-circle message-avatar" src="img/a2.jpg">
                                        </div>
                                        <div class="media-body">
                                            The point of using Lorem Ipsum is that it has a more-or-less normal.
                                            <br>
                                            <small class="text-muted">Yesterday 2:45 pm</small>
                                        </div>
                                    </a>
                                </div>
                                <div class="sidebar-message">
                                    <a href="#">
                                        <div class="float-left text-center">
                                            <img alt="image" class="rounded-circle message-avatar" src="img/a3.jpg">

                                            <div class="m-t-xs">
                                                <i class="fa fa-star text-warning"></i>
                                                <i class="fa fa-star text-warning"></i>
                                                <i class="fa fa-star text-warning"></i>
                                            </div>
                                        </div>
                                        <div class="media-body">
                                            Mevolved over the years, sometimes by accident, sometimes on purpose
                                            (injected humour and the like).
                                            <br>
                                            <small class="text-muted">Yesterday 1:10 pm</small>
                                        </div>
                                    </a>
                                </div>
                                <div class="sidebar-message">
                                    <a href="#">
                                        <div class="float-left text-center">
                                            <img alt="image" class="rounded-circle message-avatar" src="img/a4.jpg">
                                        </div>

                                        <div class="media-body">
                                            Lorem Ipsum, you need to be sure there isn't anything embarrassing
                                            hidden in the
                                            <br>
                                            <small class="text-muted">Monday 8:37 pm</small>
                                        </div>
                                    </a>
                                </div>
                                <div class="sidebar-message">
                                    <a href="#">
                                        <div class="float-left text-center">
                                            <img alt="image" class="rounded-circle message-avatar" src="img/a8.jpg">
                                        </div>
                                        <div class="media-body">

                                            All the Lorem Ipsum generators on the Internet tend to repeat.
                                            <br>
                                            <small class="text-muted">Today 4:21 pm</small>
                                        </div>
                                    </a>
                                </div>
                                <div class="sidebar-message">
                                    <a href="#">
                                        <div class="float-left text-center">
                                            <img alt="image" class="rounded-circle message-avatar" src="img/a7.jpg">
                                        </div>
                                        <div class="media-body">
                                            Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit
                                            amet..", comes from a line in section 1.10.32.
                                            <br>
                                            <small class="text-muted">Yesterday 2:45 pm</small>
                                        </div>
                                    </a>
                                </div>
                                <div class="sidebar-message">
                                    <a href="#">
                                        <div class="float-left text-center">
                                            <img alt="image" class="rounded-circle message-avatar" src="img/a3.jpg">

                                            <div class="m-t-xs">
                                                <i class="fa fa-star text-warning"></i>
                                                <i class="fa fa-star text-warning"></i>
                                                <i class="fa fa-star text-warning"></i>
                                            </div>
                                        </div>
                                        <div class="media-body">
                                            The standard chunk of Lorem Ipsum used since the 1500s is reproduced
                                            below.
                                            <br>
                                            <small class="text-muted">Yesterday 1:10 pm</small>
                                        </div>
                                    </a>
                                </div>
                                <div class="sidebar-message">
                                    <a href="#">
                                        <div class="float-left text-center">
                                            <img alt="image" class="rounded-circle message-avatar" src="img/a4.jpg">
                                        </div>
                                        <div class="media-body">
                                            Uncover many web sites still in their infancy. Various versions have.
                                            <br>
                                            <small class="text-muted">Monday 8:37 pm</small>
                                        </div>
                                    </a>
                                </div>
                            </div>

                        </div>

                        <div id="tab-2" class="tab-pane">

                            <div class="sidebar-title">
                                <h3> <i class="fa fa-cube"></i> Latest projects</h3>
                                <small><i class="fa fa-tim"></i> You have 14 projects. 10 not completed.</small>
                            </div>

                            <ul class="sidebar-list">
                                <li>
                                    <a href="#">
                                        <div class="small float-right m-t-xs">9 hours ago</div>
                                        <h4>Business valuation</h4>
                                        It is a long established fact that a reader will be distracted.

                                        <div class="small">Completion with: 22%</div>
                                        <div class="progress progress-mini">
                                            <div style="width: 22%;" class="progress-bar progress-bar-warning">
                                            </div>
                                        </div>
                                        <div class="small text-muted m-t-xs">Project end: 4:00 pm - 12.06.2014</div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="small float-right m-t-xs">9 hours ago</div>
                                        <h4>Contract with Company </h4>
                                        Many desktop publishing packages and web page editors.

                                        <div class="small">Completion with: 48%</div>
                                        <div class="progress progress-mini">
                                            <div style="width: 48%;" class="progress-bar"></div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="small float-right m-t-xs">9 hours ago</div>
                                        <h4>Meeting</h4>
                                        By the readable content of a page when looking at its layout.

                                        <div class="small">Completion with: 14%</div>
                                        <div class="progress progress-mini">
                                            <div style="width: 14%;" class="progress-bar progress-bar-info"></div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <span class="label label-primary float-right">NEW</span>
                                        <h4>The generated</h4>
                                        <!--<div class="small float-right m-t-xs">9 hours ago</div>-->
                                        There are many variations of passages of Lorem Ipsum available.
                                        <div class="small">Completion with: 22%</div>
                                        <div class="small text-muted m-t-xs">Project end: 4:00 pm - 12.06.2014</div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="small float-right m-t-xs">9 hours ago</div>
                                        <h4>Business valuation</h4>
                                        It is a long established fact that a reader will be distracted.

                                        <div class="small">Completion with: 22%</div>
                                        <div class="progress progress-mini">
                                            <div style="width: 22%;" class="progress-bar progress-bar-warning">
                                            </div>
                                        </div>
                                        <div class="small text-muted m-t-xs">Project end: 4:00 pm - 12.06.2014</div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="small float-right m-t-xs">9 hours ago</div>
                                        <h4>Contract with Company </h4>
                                        Many desktop publishing packages and web page editors.

                                        <div class="small">Completion with: 48%</div>
                                        <div class="progress progress-mini">
                                            <div style="width: 48%;" class="progress-bar"></div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="small float-right m-t-xs">9 hours ago</div>
                                        <h4>Meeting</h4>
                                        By the readable content of a page when looking at its layout.

                                        <div class="small">Completion with: 14%</div>
                                        <div class="progress progress-mini">
                                            <div style="width: 14%;" class="progress-bar progress-bar-info"></div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <span class="label label-primary float-right">NEW</span>
                                        <h4>The generated</h4>
                                        <!--<div class="small float-right m-t-xs">9 hours ago</div>-->
                                        There are many variations of passages of Lorem Ipsum available.
                                        <div class="small">Completion with: 22%</div>
                                        <div class="small text-muted m-t-xs">Project end: 4:00 pm - 12.06.2014</div>
                                    </a>
                                </li>

                            </ul>

                        </div>

                        <div id="tab-3" class="tab-pane">

                            <div class="sidebar-title">
                                <h3><i class="fa fa-gears"></i> Settings</h3>
                                <small><i class="fa fa-tim"></i> You have 14 projects. 10 not completed.</small>
                            </div>

                            <div class="setings-item">
                                <span>
                                    Show notifications
                                </span>
                                <div class="switch">
                                    <div class="onoffswitch">
                                        <input type="checkbox" name="collapsemenu" class="onoffswitch-checkbox"
                                            id="example">
                                        <label class="onoffswitch-label" for="example">
                                            <span class="onoffswitch-inner"></span>
                                            <span class="onoffswitch-switch"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="setings-item">
                                <span>
                                    Disable Chat
                                </span>
                                <div class="switch">
                                    <div class="onoffswitch">
                                        <input type="checkbox" name="collapsemenu" checked class="onoffswitch-checkbox"
                                            id="example2">
                                        <label class="onoffswitch-label" for="example2">
                                            <span class="onoffswitch-inner"></span>
                                            <span class="onoffswitch-switch"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</body>

</html>