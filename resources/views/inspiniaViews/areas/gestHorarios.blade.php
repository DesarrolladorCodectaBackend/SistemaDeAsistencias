<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <link href="{{ asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/fullcalendar/fullcalendar.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/fullcalendar/fullcalendar.print.css') }}" rel='stylesheet' media='print'>
    <title>INSPINIA | HORARIO AREA</title>
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
                        <strong>Horario Área</strong>
                    </li>
                </ol>
            </div>


        </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tabs-container">
                        <ul class="nav nav-tabs" role="tablist">
                            <li><a class="nav-link active" data-toggle="tab" href="#tab-1"> Ver</a></li>
                            <li><a class="nav-link" data-toggle="tab" href="#tab-2">Agregar</a></li>
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" id="tab-1" class="tab-pane active">
                                <div class="panel-body">
                                    <div class="wrapper wrapper-content">
                                        <div class="row animated fadeInDown">
                                            <div class="col-lg-12">
                                                <div class="ibox ">

                                                    <div class="ibox-content">
                                                        <style>
                                                            .fc-event {
                                                                text-align: right;
                                                                font-size: 15px;
                                                                display: flex;
                                                                align-items: center;
                                                                justify-content: center;

                                                            }

                                                            .fc-day-header {
                                                                display: none !important;
                                                            }
                                                        </style>
                                                        <div id="calendar"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div role="tabpanel" id="tab-2" class="tab-pane">
                                <div class="panel-body">
                                    <div class="wrapper wrapper-content animated fadeInRight">
                                        <div class="row">




                                        </div>
                                    </div>
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



    <script>
        $(document).ready(function() {
    
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green'
            });
    
            /* initialize the external events -----------------------------------------------------------------*/
            $('#external-events div.external-event').each(function() {
                $(this).data('event', {
                    title: $.trim($(this).text()),
                    stick: true
                });
    
                $(this).draggable({
                    zIndex: 1111999,
                    revert: true,
                    revertDuration: 0
                });
            });
    
            /* initialize the calendar -----------------------------------------------------------------*/
            var date = new Date();
            var d = date.getDate();
            var m = date.getMonth();
            var y = date.getFullYear();
            var horariosFormateados = <?php echo json_encode($horariosFormateados); ?>;
    
            
            var eventosHorarios = horariosFormateados.map(function(horario) {
                var numeroDia;
                if(horario.dia == "Lunes"){
                    numeroDia = 5;
                } else if(horario.dia == "Martes"){
                    numeroDia = 6;
                } else if(horario.dia == "Miercoles"){
                    numeroDia = 7;
                } else if(horario.dia == "Jueves"){
                    numeroDia = 8;
                } else if(horario.dia == "Viernes"){
                    numeroDia = 9;
                } else if(horario.dia == "Sabado"){
                    numeroDia = 10;
                } else if(horario.dia == "Domingo"){
                    numeroDia = 4;
                } else{
                    numeroDia = 4;
                }
                return {
                    title: "Clases",
                    start: new Date(2024, 1, numeroDia, horario.hora_inicial, 0),
                    end: new Date(2024, 1, numeroDia, horario.hora_final, 0),
                    allDay: false,
                    editable: false
                };
            });
            
           /*
            var eventosHorarios = horarioAsignado.map(function(horario) {
                var numeroDia;
                if(horario.horario_presencial.dia == "Lunes"){
                    numeroDia = 5;
                } else if(horario.horario_presencial.dia == "Martes"){
                    numeroDia = 6;
                } else if(horario.horario_presencial.dia == "Miercoles"){
                    numeroDia = 7;
                } else if(horario.horario_presencial.dia == "Jueves"){
                    numeroDia = 8;
                } else if(horario.horario_presencial.dia == "Viernes"){
                    numeroDia = 9;
                } else if(horario.horario_presencial.dia == "Sabado"){
                    numeroDia = 10;
                } else if(horario.horario_presencial.dia == "Domingo"){
                    numeroDia = 4;
                } else{
                    numeroDia = 4;
                }
                console.log(horario.horario_presencial.hora_final);
                return {
                    title: "Clases",
                    start: new Date(2024, 1, numeroDia, horario.horario_presencial.hora_inicial, 0),
                    end: new Date(2024, 1, numeroDia, horario.horario_presencial.hora_final, 0),
                    allDay: false,
                    editable: false
                };
            });
            */
    
            var eventos = [{
                    title: 'Domingo',
                    start: new Date(2024, 1, 4, 0, 0),
                    end: new Date(2024, 1, 4, 13, 30),
                    allDay: true,
                    color: '#a0d6f4',
                    editable: false
                },
                {
                    title: 'Lunes',
                    start: new Date(2024, 1, 5, 9, 0),
                    end: new Date(2024, 1, 5, 13, 30),
                    allDay: true,
                    color: '#a0d6f4',
                    editable: false
                },
                {
                    title: 'Martes',
                    start: new Date(2024, 1, 6, 9, 0),
                    end: new Date(2024, 1, 6, 13, 30),
                    allDay: true,
                    color: '#a0d6f4',
                    editable: false
                },
                {
                    title: 'Miercoles',
                    start: new Date(2024, 1, 7, 9, 0),
                    end: new Date(2024, 1, 7, 13, 30),
                    allDay: true,
                    color: '#a0d6f4',
                    editable: false
                },
                {
                    title: 'Jueves',
                    start: new Date(2024, 1, 8, 9, 0),
                    end: new Date(2024, 1, 8, 13, 30),
                    allDay: true,
                    color: '#a0d6f4',
                    editable: false
                },
                {
                    title: 'Viernes',
                    start: new Date(2024, 1, 9, 9, 0),
                    end: new Date(2024, 1, 9, 13, 30),
                    allDay: true,
                    color: '#a0d6f4',
                    editable: false
                },
                {
                    title: 'Sabado',
                    start: new Date(2024, 1, 10, 9, 0),
                    end: new Date(2024, 1, 10, 13, 30),
                    allDay: true,
                    color: '#a0d6f4',
                    editable: false
                }
            ].concat(eventosHorarios);
    
            $('#calendar').fullCalendar({
                locale: 'es',
                defaultView: 'agendaWeek',
                weekNumbers: false,
                weekNumbersWithinDays: 7,
                viewRender: function(view, element) {
                    var startDate = moment('2024-02-04');
                    var endDate = moment(startDate).add(6, 'weeks');
                    if (view.end.isAfter(endDate)) {
                        $('#calendar').fullCalendar('gotoDate', startDate);
                    }
                },
                header: {
                    left: '',
                    center: 'title',
                    right: ''
                },
                allDayText: 'Hora/Area',
                slotDuration: '00:30:00',
                slotLabelInterval: '01:00',
                minTime: '07:00:00',
                maxTime: '22:00:00',
                contentHeight: 'auto',
                eventOverlap: true,
                slotEventOverlap: false,
                editable: true,
                droppable: true,
                allDaySlot: true,
                drop: function() {
                    if ($('#drop-remove').is(':checked')) {
                        $(this).remove();
                    }
                },
                events: eventos,
                eventRender: function(event, element) {
                    var daysToShow = 4;
                    var columnWidth = $('.fc-day-grid-container').width() / daysToShow;
                    element.css('width', columnWidth);
                }
            });
        });
    </script>



</body>

</html>