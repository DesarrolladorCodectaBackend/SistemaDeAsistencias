<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('font-awesome/css/font-awesome.css') }}">

    <link href="{{ asset('css/plugins/switchery/switchery.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">
    <link href="{{asset('css/plugins/select2/select2.min.css') }}" rel="stylesheet">
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@3.0.1/dist/css/multi-select-tag.css">

    <link rel="stylesheet" href="{{ asset('css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/alertify.min.css') }}">
    <link href="{{ asset('css/inspinia.css') }}" rel="stylesheet">
</head>


<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <img alt="image" class="rounded-circle img-lg" src="{{asset('img/image.png')}}" />
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="block m-t-xs font-bold">Administrador</span>
                        <span class="text-muted text-xs block">Art Director <b class="caret"></b></span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a class="dropdown-item" href="profile.html">Profile</a></li>
                        <li><a class="dropdown-item" href="contacts.html">Contacts</a></li>
                        <li><a class="dropdown-item" href="mailbox.html">Mailbox</a></li>
                        <li class="dropdown-divider"></li>
                        <li><a class="dropdown-item">Logout</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    IN+
                </div>
            </li>
            <li>
                <a href="/dashboard"><i class="fa fa-th-large"></i> <span class="nav-label">Inicio</span></a>
            </li>
            <li>
                <a href="/horarioGeneral"><i class="fa fa-clock-o"></i> <span class="nav-label">Horarios
                        Generales</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="/horarioGeneral">Presencial</a></li>
                    <li><a href="/ReunionesAreas">Reuniones</a></li>
                </ul>
            </li>
            <li>
                <a href="/horarioGeneral"><i class="fa fa-clock-o"></i> <span class="nav-label">Horarios
                        G.Virtual</span></a>
            </li>
            <li id="personalCont">
                <a href="layouts.html"><i class="fa fa-group"></i> <span class="nav-label">Personal</span><span
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
            <li>
                <a href="/responsabilidades"><i class="fa fa-list-alt"></i> <span
                        class="nav-label">Responsabilidades</span></a>
            </li>
            <li id="maquinas">
                <a href="/maquinas"><i class="fa fa-desktop"></i> <span class="nav-label">Maquinas</span></a>
            </li>
            <li id="salones">
                <a href="/salones"><i class="fa fa-address-card-o"></i> <span class="nav-label">Salones</span></a>
            </li>
            <li id="ajustes">
                <a href="/ajustes"><i class="fa fa-cog"></i> <span class="nav-label">Ajustes</span></a>
            </li>
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
                <form role="search" class="navbar-form-custom" action="search_results.html">
                    <div class="form-group">
                        <input type="text" placeholder="Search for something..." class="form-control" name="top-search"
                            id="top-search">
                    </div>
                </form>
            </div>
            <ul class="nav navbar-top-links navbar-right">
                <li>
                    <span class="m-r-sm text-muted welcome-message">Welcome to INSPINIA+ Admin Theme.</span>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                        <i class="fa fa-envelope"></i> <span class="label label-warning">16</span>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
                        <li>
                            <div class="dropdown-messages-box">
                                <a class="dropdown-item float-left" href="#">
                                    <img alt="image" class="rounded-circle" src="">
                                </a>
                                <div>
                                    <small class="float-right">46h ago</small>
                                    <strong>Mike Loreipsum</strong> started following <strong>Monica
                                        Smith</strong>. <br>
                                    <small class="text-muted">3 days ago at 7:58 pm - 10.06.2014</small>
                                </div>
                            </div>
                        </li>
                        <li class="dropdown-divider"></li>
                        <li>
                            <div class="dropdown-messages-box">
                                <a class="dropdown-item float-left" href="#">
                                    <img alt="image" class="rounded-circle" src="">
                                </a>
                                <div>
                                    <small class="float-right text-navy">5h ago</small>
                                    <strong>Chris Johnatan Overtunk</strong> started following <strong>Monica
                                        Smith</strong>. <br>
                                    <small class="text-muted">Yesterday 1:21 pm - 11.06.2014</small>
                                </div>
                            </div>
                        </li>
                        <li class="dropdown-divider"></li>
                        <li>
                            <div class="dropdown-messages-box">
                                <a class="dropdown-item float-left" href="#">
                                    <img alt="image" class="rounded-circle" src="">
                                </a>
                                <div>
                                    <small class="float-right">23h ago</small>
                                    <strong>Monica Smith</strong> love <strong>Kim Smith</strong>. <br>
                                    <small class="text-muted">2 days ago at 2:30 am - 11.06.2014</small>
                                </div>
                            </div>
                        </li>
                        <li class="dropdown-divider"></li>
                        <li>
                            <div class="text-center link-block">
                                <a href="#" class="dropdown-item">
                                    <i class="fa fa-envelope"></i> <strong>Read All Messages</strong>
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell"></i> <span class="label label-primary">8</span>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                        <li>
                            <a href="#" class="dropdown-item">
                                <div>
                                    <i class="fa fa-envelope fa-fw"></i> You have 16 messages
                                    <span class="float-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="dropdown-divider"></li>
                        <li>
                            <a href="#" class="dropdown-item">
                                <div>
                                    <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                    <span class="float-right text-muted small">12 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="dropdown-divider"></li>
                        <li>
                            <a href="#" class="dropdown-item">
                                <div>
                                    <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                    <span class="float-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="dropdown-divider"></li>
                        <li>
                            <div class="text-center link-block">
                                <a href="#" class="dropdown-item">
                                    <strong>See All Alerts</strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>


                <li>

                    <a href="#" onclick="document.getElementById('logoutForm').submit();">
                        <i class="fa fa-sign-out"></i>Log Out
                    </a>

                </li>
                <li>
                    <a class="right-sidebar-toggle">
                        <i class="fa fa-tasks"></i>
                    </a>
                </li>
            </ul>

        </nav>
    </div>



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
    <!--
    <script>
        $(document).ready(function() {
            $('.chart').easyPieChart({
                barColor: '#f8ac59',
                //                scaleColor: false,
                scaleLength: 5,
                lineWidth: 4,
                size: 80
            });

            $('.chart2').easyPieChart({
                barColor: '#1c84c6',
                //                scaleColor: false,
                scaleLength: 5,
                lineWidth: 4,
                size: 80
            });

            var data2 = [
                [gd(2012, 1, 1), 7],
                [gd(2012, 1, 2), 6],
                [gd(2012, 1, 3), 4],
                [gd(2012, 1, 4), 8],
                [gd(2012, 1, 5), 9],
                [gd(2012, 1, 6), 7],
                [gd(2012, 1, 7), 5],
                [gd(2012, 1, 8), 4],
                [gd(2012, 1, 9), 7],
                [gd(2012, 1, 10), 8],
                [gd(2012, 1, 11), 9],
                [gd(2012, 1, 12), 6],
                [gd(2012, 1, 13), 4],
                [gd(2012, 1, 14), 5],
                [gd(2012, 1, 15), 11],
                [gd(2012, 1, 16), 8],
                [gd(2012, 1, 17), 8],
                [gd(2012, 1, 18), 11],
                [gd(2012, 1, 19), 11],
                [gd(2012, 1, 20), 6],
                [gd(2012, 1, 21), 6],
                [gd(2012, 1, 22), 8],
                [gd(2012, 1, 23), 11],
                [gd(2012, 1, 24), 13],
                [gd(2012, 1, 25), 7],
                [gd(2012, 1, 26), 9],
                [gd(2012, 1, 27), 9],
                [gd(2012, 1, 28), 8],
                [gd(2012, 1, 29), 5],
                [gd(2012, 1, 30), 8],
                [gd(2012, 1, 31), 25]
            ];

            var data3 = [
                [gd(2012, 1, 1), 800],
                [gd(2012, 1, 2), 500],
                [gd(2012, 1, 3), 600],
                [gd(2012, 1, 4), 700],
                [gd(2012, 1, 5), 500],
                [gd(2012, 1, 6), 456],
                [gd(2012, 1, 7), 800],
                [gd(2012, 1, 8), 589],
                [gd(2012, 1, 9), 467],
                [gd(2012, 1, 10), 876],
                [gd(2012, 1, 11), 689],
                [gd(2012, 1, 12), 700],
                [gd(2012, 1, 13), 500],
                [gd(2012, 1, 14), 600],
                [gd(2012, 1, 15), 700],
                [gd(2012, 1, 16), 786],
                [gd(2012, 1, 17), 345],
                [gd(2012, 1, 18), 888],
                [gd(2012, 1, 19), 888],
                [gd(2012, 1, 20), 888],
                [gd(2012, 1, 21), 987],
                [gd(2012, 1, 22), 444],
                [gd(2012, 1, 23), 999],
                [gd(2012, 1, 24), 567],
                [gd(2012, 1, 25), 786],
                [gd(2012, 1, 26), 666],
                [gd(2012, 1, 27), 888],
                [gd(2012, 1, 28), 900],
                [gd(2012, 1, 29), 178],
                [gd(2012, 1, 30), 555],
                [gd(2012, 1, 31), 993]
            ];


            var dataset = [{
                label: "Number of orders",
                data: data3,
                color: "#1ab394",
                bars: {
                    show: true,
                    align: "center",
                    barWidth: 24 * 60 * 60 * 600,
                    lineWidth: 0
                }

            }, {
                label: "Payments",
                data: data2,
                yaxis: 2,
                color: "#1C84C6",
                lines: {
                    lineWidth: 1,
                    show: true,
                    fill: true,
                    fillColor: {
                        colors: [{
                            opacity: 0.2
                        }, {
                            opacity: 0.4
                        }]
                    }
                },
                splines: {
                    show: false,
                    tension: 0.6,
                    lineWidth: 1,
                    fill: 0.1
                },
            }];


            var options = {
                xaxis: {
                    mode: "time",
                    tickSize: [3, "day"],
                    tickLength: 0,
                    axisLabel: "Date",
                    axisLabelUseCanvas: true,
                    axisLabelFontSizePixels: 12,
                    axisLabelFontFamily: 'Arial',
                    axisLabelPadding: 10,
                    color: "#d5d5d5"
                },
                yaxes: [{
                    position: "left",
                    max: 1070,
                    color: "#d5d5d5",
                    axisLabelUseCanvas: true,
                    axisLabelFontSizePixels: 12,
                    axisLabelFontFamily: 'Arial',
                    axisLabelPadding: 3
                }, {
                    position: "right",
                    clolor: "#d5d5d5",
                    axisLabelUseCanvas: true,
                    axisLabelFontSizePixels: 12,
                    axisLabelFontFamily: ' Arial',
                    axisLabelPadding: 67
                }],
                legend: {
                    noColumns: 1,
                    labelBoxBorderColor: "#000000",
                    position: "nw"
                },
                grid: {
                    hoverable: false,
                    borderWidth: 0
                }
            };

            function gd(year, month, day) {
                return new Date(year, month - 1, day).getTime();
            }

            var previousPoint = null,
                previousLabel = null;

            $.plot($("#flot-dashboard-chart"), dataset, options);

            var mapData = {
                "US": 298,
                "SA": 200,
                "DE": 220,
                "FR": 540,
                "CN": 120,
                "AU": 760,
                "BR": 550,
                "IN": 200,
                "GB": 120,
            };

            $('#world-map').vectorMap({
                map: 'world_mill_en',
                backgroundColor: "transparent",
                regionStyle: {
                    initial: {
                        fill: '#e4e4e4',
                        "fill-opacity": 0.9,
                        stroke: 'none',
                        "stroke-width": 0,
                        "stroke-opacity": 0
                    }
                },

                series: {
                    regions: [{
                        values: mapData,
                        scale: ["#1ab394", "#22d6b1"],
                        normalizeFunction: 'polynomial'
                    }]
                },
            });
        });
    </script>
    -->