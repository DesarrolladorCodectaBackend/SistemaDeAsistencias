<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('font-awesome/css/font-awesome.css') }}">

    <link href="{{ asset('css/plugins/switchery/switchery.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">
    <link href="{{asset('css/plugins/select2/select2.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@3.0.1/dist/css/multi-select-tag.css">

    <link rel="stylesheet" href="{{ asset('css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/alertify.min.css') }}">
    <link href="{{ asset('css/plugins/chartist/chartist.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/inspinia.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/fullcalendar/fullcalendar.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/fullcalendar/fullcalendar.print.css') }}" rel='stylesheet' media='print'>

</head>

@php
    use App\Http\Controllers\FunctionHelperController;
    $userData = FunctionHelperController::getUserRol();
    $user = $userData['user'];
@endphp


<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <img alt="image" class="rounded-circle img-lg" src="{{asset('img/image.png')}}" />
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="block m-t-xs font-bold">{{$userData['user']['name']}}</span>
                        <span class="text-muted text-xs block">Art Director <b class="caret"></b></span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a class="dropdown-item" href="">Profile</a></li>
                        <li><a class="dropdown-item" href="">Contacts</a></li>
                        <li><a class="dropdown-item" href="">Mailbox</a></li>
                        <li class="dropdown-divider"></li>
                        <li><a class="dropdown-item"
                                onclick="document.getElementById('logoutForm').submit();">Logout</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    IN+
                </div>
            </li>
            <li>
                <a href="/dashboard"><i class="fa fa-th-large"></i> <span class="nav-label">Inicio</span></a>
            </li>
            @if($userData['isAdmin'])
            <li>
                <a href="/horarioGeneral"><i class="fa fa-clock-o"></i> <span class="nav-label">Horarios
                        Generales</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="/horarioGeneral">Presencial</a></li>
                    <li><a href="/ReunionesAreas">Reuniones Áreas</a></li>
                </ul>
            </li>
            <li>
                <a href="/ReunionesProgramadas"><i class="fa fa-video-camera"></i> <span class="nav-label">Reu.
                        Programadas</span></a>
            </li>
            <li>
                <a href="/Reportes"><i class="fa fa-book"></i> <span class="nav-label">Reportes</span></a>
            </li>
            <li id="personalCont">
                <a href=""><i class="fa fa-group"></i> <span class="nav-label">Personal</span><span
                        class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li id="candidatos">
                        <a href="/candidatos">Candidatos</a>
                    </li>
                    <li id="colaboradores">
                        <a href="/colaboradores">Colaboradores</a>
                    </li>
                </ul>

            </li>
            <li id="areas">
                <a href="/areas"><i class="fa fa-tags"></i> <span class="nav-label">Áreas</span></a>
            </li>
            @endif
            @if($userData['isAdmin'] || $userData['isBoss'])
            <li>
                <a href="/responsabilidades"><i class="fa fa-list-alt"></i> <span
                        class="nav-label">Responsabilidades</span></a>
            </li>
            @endif
            @if($userData['isAdmin'])
            <li id="maquinas">
                <a href="/maquinas"><i class="fa fa-desktop"></i> <span class="nav-label">Maquinas</span></a>
            </li>
            <li id="salones">
                <a href="/salones"><i class="fa fa-address-card-o"></i> <span class="nav-label">Salones</span></a>
            </li>
            <li id="ajustes">
                <a href="/ajustes"><i class="fa fa-cog"></i> <span class="nav-label">Ajustes</span></a>
            </li>
            @endif
            <li>
                <form id="logoutForm" method="POST" action="http://127.0.0.1:8000/logout">
                    @csrf
                </form>

                <a href="#" onclick="document.getElementById('logoutForm').submit();">
                    <i class="fa fa-sign-out"></i>
                    <span class="nav-label">Cerrar Sesión</span>
                </a>
            </li>
        </ul>

    </div>
</nav>

<div id="page-wrapper" class="gray-bg">
    <div class="row border-bottom">
        <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i>
                </a>

            </div>
            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                        <i style="font-size: 20px" class="fa fa-bell "></i>
                        <span id="notificationsCountContainer" class="label label-primary" hidden>8</span>
                    </a>
                    <ul id="notificationsContainer" class="dropdown-menu dropdown-alerts max-height-scrollable">

                    </ul>
                </li>


                <li>

                    <a href="#" onclick="document.getElementById('logoutForm').submit();">
                        <i class="fa fa-sign-out"></i>Log Out
                    </a>

                </li>
            </ul>

        </nav>
    </div>
    @if($user['estado'] == 0)
        <script>
            console.log('baneado');
            document.getElementById('logoutForm').submit();
        </script>
    @endif
    <style>
        .max-height-scrollable {
            max-height: 300px;
            overflow-y: auto;
        }
    </style>


    <!-- Mainly scripts -->
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/alertify.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>


    <!-- jQuery UI  -->
    <script class="jQuery UI" src="{{ asset('js/plugins/jquery-ui/jquery-ui.min.js') }}"></script>


    <!-- iCheck -->
    <script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>

    <!-- Full Calendar -->
    <script src="{{ asset('js/plugins/fullcalendar/moment.min.js') }}"></script>
    <script src="{{ asset('js/plugins/fullcalendar/fullcalendar.min.js') }}"></script>

    <!-- Select2 -->
    <script src="{{asset('js/plugins/select2/select2.full.min.js')}} "></script>

    <!-- Chartist -->
    <script src="{{asset('js/plugins/chartist/chartist.min.js')}}"></script>

    <!--
    <script class="Flot" src="{{ asset('js/plugins/flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.tooltip.min.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.spline.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.pie.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.symbol.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.time.js') }}"></script>


    <script class="Peity" src="{{ asset('js/plugins/peity/jquery.peity.min.js') }}"></script>
    <script src="{{ asset('js/demo/peity-demo.js') }}"></script>





    <script class="Jvectormap" src="{{ asset('js/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
    <script src="{{ asset('js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>


    <script class="EayPIE" src="{{ asset('js/plugins/easypiechart/jquery.easypiechart.js') }}"></script>


    <script class="Sparkline" src="{{ asset('js/plugins/sparkline/jquery.sparkline.min.js') }}"></script>


    <script class="Sparkline demo data" src="{{ asset('js/demo/sparkline-demo.js') }}"></script>
    -->

    <script>
        let notificationsContainer = document.getElementById('notificationsContainer');
        let notificationsCountContainer = document.getElementById('notificationsCountContainer');

        const UserToken = <?php echo json_encode(session('api_token')); ?>;
        const notificationCard = (icon, message, url) => {
            let card = `<li>
                            <a href="${url}" class="dropdown-item">
                                <div class="text-wrap">
                                    <i class="${icon}"></i> ${message}
                                </div>
                            </a>
                        </li>`;
            notificationsContainer.innerHTML += card;
        };
        const nothingCard = () => {
            let card = `<li>
                            <div class="dropdown-item">
                                <div class="text-wrap">
                                    <i class="fa fa-question-circle"></i> No hay notificaciones pendientes para hoy.
                                </div>
                            </div>
                        </li>`;
            notificationsContainer.innerHTML += card;
        };

        let data = null;
        fetch('http://127.0.0.1:8000/api/notificaciones', {
            headers: {
                'Authorization': 'Bearer '+UserToken
            }
        })
            .then(response => response.json())
            .then(responseData => {
                data = responseData;
                // console.log(data);

                data.notifications.map(notification => {
                    notificationCard(notification.icon, notification.message, notification.url);
                });
                if (data.notifications.length === 0) {
                nothingCard()
                }
                notificationsCountContainer.removeAttribute('hidden');
                notificationsCountContainer.innerText = data.notifications.length;
            })
            .catch(error => console.error('Error:', error));


    </script>
