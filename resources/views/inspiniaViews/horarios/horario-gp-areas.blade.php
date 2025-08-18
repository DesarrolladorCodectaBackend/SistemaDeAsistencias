<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>INSPINIA | Horario - Áreas</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/plugins/iCheck/custom.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <style>
        .fc-slats tr[data-time="12:30:00"] td {
        background: #2f75b5 !important; 
        color: white !important;
        text-align: center;
        font-weight: bold;
    }

    </style>
</head>

<body>

<div id="wrapper">
    @include('components.inspinia.side_nav_bar-inspinia')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-8">
            <h2>Horario General</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{route('dashboard')}}">Inicio</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>Horario General</strong>
                </li>
            </ol>
        </div>
    </div>

    {{-- btn descargar excel --}}
    <div id="button-container" style="text-align: center; margin-top: 20px; display: flex; justify-content: end;">
        
    </div>

    <div class="wrapper wrapper-content">
        <div class="row animated fadeInDown">
            <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-content">
                    <h1 class="titulo">Horario General Presencial - Áreas</h1>
                    <br>
                    <div class="container">
                    <table>

                        <tr class="m1">
                            <th class="hm">Hora / Area</th>
                            <th id="A1">Domingo</th>
                            <th id="A2">Lunes</th>
                            <th id="A3">Martes</th>
                            <th id="A4">Miércoles</th>
                            <th id="A5">Jueves</th>
                            <th id="A6">Viernes</th>
                            <th id="A7">Sábado</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="celdas">
                            <th rowspan="4" >8:30 am - 12:30 pm</th>
                            <td id="c1"></td>
                            <td id="c2"></td>
                            <td id="c3"></td>
                            <td id="c4"></td>
                            <td id="c5"></td>
                            <td id="c6"></td>
                            <td id="c7"></td>
                        </tr>
                        <tr class="celdas">
                            <td id="c8"></td>
                            <td id="c9"></td>
                            <td id="c10"></td>
                            <td id="c11"></td>
                            <td id="c12"></td>
                            <td id="c13"></td>
                            <td id="c14"></td>
                        </tr>
                        <tr class="celdas">
                            <td id="c14"></td>
                            <td id="c15"></td>
                            <td id="c16"></td>
                            <td id="c17"></td>
                            <td id="c18"> </td>
                            <td id="c19"> </td>
                            <td id="c20"> </td>
                        </tr>
                        <tr class="celdas">
                            <td id="c21"></td>
                            <td id="c22"></td>
                            <td id="c23"></td>
                            <td id="c24"></td>
                            <td id="c25"> </td>
                            <td id="c26"> </td>
                            <td id="c27"> </td>
                        </tr>
                        <tr>
                            <th>12:30 pm - 2:00 pm</th>
                            <td class="receso" colspan="8">RECESO</td>
                        </tr>
                        <tr class="celdas">
                            <th rowspan="4" >2:00 pm - 6:00 pm</th>
                            <td id="c28" ></td>
                            <td id="c29" ></td>
                            <td id="c30" > </td>
                            <td id="c31" > </td>
                            <td id="c32"> </td>
                            <td id="c33"> </td>
                            <td id="c34"> </td>
                        </tr>
                        <tr class="celdas">
                            <td id="c35" ></td>
                            <td id="c36" ></td>
                            <td id="c37" ></td>
                            <td id="c38" ></td>
                            <td id="c39"> </td>
                            <td id="c40"> </td>
                            <td id="c41"> </td>
                        </tr>
                        <tr class="celdas">
                            <td id="c41" ></td>
                            <td id="c42" ></td>
                            <td id="c43" ></td>
                            <td id="c44" ></td>
                            <td id="c45"></td>
                            <td id="c46"></td>
                            <td id="c47"></td>
                        </tr>
                        <tr class="celdas">
                            <td id="c48" ></td>
                            <td id="c49" ></td>
                            <td id="c50" ></td>
                            <td id="c51" ></td>
                            <td id="c52"></td>
                            <td id="c53"> </td>
                            <td id="c54"> </td>
                        </tr>
                        </tbody>
                    </table >
                    </div>
                    <style>
                    .container {
                    width: 1400px;

                    margin: 0 auto;
                    font-family: sans-serif;
                    }

                    h1 {
                        text-align: center;
                    }

                    .fecha {
                        text-align: center;
                        color: white;
                    }

                    table {
                        width: 100%;
                        border-collapse: collapse;
                    }

                    th, td {
                        border: 1px solid black;
                        padding: 5px;
                        color: black;
                        height: 40px;
                    }

                    th {
                        text-align: center;
                        min-width: 100px;


                    }
                    .m1{
                        background-color: #4e7bbf;
                        color: white;

                    }
                    .hm{
                        background-color: #4e7bbf;
                        width: 200px;
                        color: white;
                    }
                    .titulo{
                        font-weight: 600;
                    }
                    .receso{
                        background-color: #4e7bbf;
                        font-size: 25px;
                        font-weight: 600;
                        color: white;
                        height: 100px;
                    }
                    td {
                        text-align: center;
                    }
                    #A4{
                        background-color: #bbd5ff;

                    }
                    #A2{
                        background-color: #bbd5ff;
                    }
                    #A1{
                        background-color: #bbd5ff;
                    }
                    #A3{
                        background-color: #bbd5ff;
                    }

                    #A4{
                        background-color: #bbd5ff;
                    }

                    #A5{
                        background-color: #bbd5ff;
                    }

                    #A6{
                        background-color: #bbd5ff;
                    }

                    #A7{
                        background-color: #bbd5ff;
                    }
                    .celdas{
                        background-color: hsla(0, 0%, 100%, 0.884);
                        height: 40px;
                    }

                    </style>
                    
            </div>
            </div>
        </div>
        </div>
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
</div>

<!-- Mainly scripts -->
<!-- <script src="js/plugins/fullcalendar/moment.min.js"></script> -->
<script src="js/jquery-3.1.1.min.js"></script>
<script src="js/popper.min.js"></script>
    <script src="js/bootstrap.js"></script>
<script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<!-- Custom and plugin javascript -->
<script src="js/inspinia.js"></script>
<script src="js/plugins/pace/pace.min.js"></script>

<!-- jQuery UI  -->
<script src="js/plugins/jquery-ui/jquery-ui.min.js"></script>

<!-- iCheck -->
<script src="js/plugins/iCheck/icheck.min.js"></script>

<!-- Full Calendar -->
<!-- <script src="js/plugins/fullcalendar/fullcalendar.min.js"></script> -->




</body>


</html>

<!-- <script>
    $.ajax({
    url: "{{ route('areas.horarioCreate') }}",
    method: "POST",
    data: {
        _token: $('meta[name="csrf-token"]').attr('content'),
        area_id: area_id,
        dia: dia,
        hora_inicio: hora_inicio,
        hora_fin: hora_fin
    },
    success: function() {
        $('#calendar').fullCalendar('refetchEvents');
        Swal.fire("¡Éxito!", "Horario guardado.", "success");
    }
});
</script> -->