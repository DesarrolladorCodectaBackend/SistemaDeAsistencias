<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="{{ asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/fullcalendar/fullcalendar.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/fullcalendar/fullcalendar.print.css') }}" rel='stylesheet' media='print'>
    <title>INSPINIA | REUNIONES ÁREAS</title>
</head>

<body>
    <div id="wrapper">
        @include('components.inspinia.side_nav_bar-inspinia')
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-10">
                <h2>Reuniones Horarios</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{route('dashboard')}}">Inicio</a>
                    </li>
                    <li class="breadcrumb-item active">
                        <strong>Reuniones Generales</strong>
                    </li>
                </ol>
            </div>


        </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tabs-container">
                        <ul class="nav nav-tabs" role="tablist">
                            <a data-toggle="tab" href="#tab-1"></a>
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
                                                                font-size: 12px !important;
                                                                padding: 5px !important; /* Espaciado interno */
                                                            }

                                                            /* Aumenta la altura de las filas en la vista de agenda (slots de 30min) */
                                                            .fc-time-grid .fc-slats td {
                                                                height: 2em !important;
                                                            }

                                                            /* Asegura que los eventos se muestren en toda la anchura disponible */
                                                            .fc .fc-event-container {
                                                                width: 100% !important;
                                                            }

                                                            /* Oculta la barra de herramientas superior (botones, título de rango de fechas) */
                                                            .fc-toolbar {
                                                                display: none;
                                                            }

                                                            /* Oculta los headers de los días en la vista actual (si lo deseas) */
                                                            .fc-day-header {
                                                                display: none !important;

                                                            }

                                                            .fc-bg {
                                                                display: flex !important;
                                                                justify-content: center !important;
                                                                align-items: center !important;
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


                            <div id="meetingModal" class="modal fade" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Detalles de la Reunión</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p><strong>Área:</strong> <span id="modalAreaName"></span></p>
                                            <p><strong>Día:</strong> <span id="modalMeetingDay"></span></p>
                                            <p><strong>Horario:</strong> <span id="modalMeetingTime"></span></p>
                                            <p><strong>Disponibilidad:</strong> <span id="modalMeetingAvailability"></span></p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
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
    <style>
        .fc-toolbar {
            display: none;
        }
    </style>

<script>
    $(document).ready(function() {

        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
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
        var reunionesAreas = <?php echo json_encode($reuniones); ?>;

        var eventosHorarios = reunionesAreas.map(function(reunion) {
            var numeroDia;
            if (reunion.horario_modificado.dia === "Lunes") {
                numeroDia = 5;
            } else if (reunion.horario_modificado.dia === "Martes") {
                numeroDia = 6;
            } else if (reunion.horario_modificado.dia === "Miércoles") {
                numeroDia = 7;
            } else if (reunion.horario_modificado.dia === "Jueves") {
                numeroDia = 8;
            } else if (reunion.horario_modificado.dia === "Viernes") {
                numeroDia = 9;
            } else if (reunion.horario_modificado.dia === "Sábado") {
                numeroDia = 10;
            } else if (reunion.horario_modificado.dia === "Domingo") {
                numeroDia = 4;
            } else {
                numeroDia = 4;
            }
            var abreviado = reunion.area.especializacion.match(/[A-Z]/g);
            breviado = abreviado ? abreviado.join('.') : reunion.area.especializacion;
            return {
                // En el calendario, solo se mostrará este title
                title: abreviado,
                start: new Date(2024, 1, numeroDia, reunion.horario_modificado.hora_inicial, 0),
                end: new Date(2024, 1, numeroDia, reunion.horario_modificado.hora_final, 0),
                allDay: false,
                color: reunion.area.color_hex,
                editable: false,
                // Guardamos la información completa para usarla en el modal
                reunionData: reunion
            };
        });

        var eventos = [
            {
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
                title: 'Miércoles',
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
            // IMPORTANTE: Deja el formato de hora vacío para no mostrar las horas
            timeFormat: '',
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
            minTime: '01:00:00',
            maxTime: '24:00:01',
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
            },
            eventClick: function(calEvent, jsEvent, view) {
                // Mostramos el modal con toda la información real
                if (calEvent.reunionData) {
                    var reunionDetallada = calEvent.reunionData;
                    $('#modalAreaName').text(reunionDetallada.area.nombre || reunionDetallada.area.especializacion);
                    $('#modalAreaSpecialization').text(reunionDetallada.area.especializacion);
                    $('#modalMeetingDay').text(reunionDetallada.horario_modificado.dia);
                    $('#modalMeetingTime').text(
                        reunionDetallada.horario_modificado.hora_inicial + ':00 - ' +
                        reunionDetallada.horario_modificado.hora_final + ':00'
                    );
                    $('#modalMeetingAvailability').text(reunionDetallada.disponibilidad);

                    $('#meetingModal').modal('show');
                }
            }
        });
    });
</script>





</body>

</html>
