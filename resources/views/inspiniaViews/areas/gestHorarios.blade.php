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
                            <li><a class="nav-link" data-toggle="tab" href="#tab-2">Gestionar</a></li>
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

                                                            .fc-content {
                                                                text-align: center;
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
                                            <div class="col-lg-12">
                                                <div class="ibox ">
                                                    <div class="ibox-content">
                                                        @if($hasHorario)
                                                        <h2>Cambiar Horario</h2>
                                                        <?php $asignado = $horarioAsignado->first(); ?>
                                                        <form action="{{ route('areas.horarioUpdate', $asignado->id) }}"
                                                            role="form" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <input value="{{ $area->id }}" name="area_id"
                                                                type="hidden" />
                                                            <h3 class="m-t-none m-b">Seleccione uno de los horarios
                                                                disponibles:</h3>
                                                            <div class="row">
                                                                @foreach($horariosDisponibles as $index => $horario)
                                                                @if($index % 4 == 0)
                                                            </div>
                                                            <div class="row">
                                                                @endif
                                                                <div class="col-md-3">
                                                                    <div class="ibox">
                                                                        <div style="cursor: pointer"
                                                                            class="ibox-content product-box"
                                                                            onclick="toggleCheckbox(event, {{ $horario->id }})">
                                                                            <div class="product-desc">
                                                                                <div style="display: flex; gap:60%">
                                                                                    <h1 class="product-name">{{
                                                                                        $horario->dia }}
                                                                                        @if($horario->actual === true)
                                                                                        <span
                                                                                            style="color: #f00; font-size: 13px">(Actual)</span>
                                                                                        @endif
                                                                                    </h1>
                                                                                    <input type="checkbox"
                                                                                        value="{{ $horario->id }}"
                                                                                        name="horario_presencial_id"
                                                                                        class="horario-checkbox"
                                                                                        id="checkbox-{{ $horario->id }}"
                                                                                        onchange="updateSubmitButton()" />
                                                                                </div>
                                                                                <div class="m-t-xs">Desde: {{
                                                                                    $horario->hora_inicial }}</div>
                                                                                <div class="m-t-xs">Hasta: {{
                                                                                    $horario->hora_final }}</div>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @endforeach
                                                            </div>
                                                            <button class="btn btn-primary btn-sm m-t-n-xs float-right"
                                                                type="submit" id="submit-button" disabled>
                                                                <i class="fa fa-check"></i>&nbsp;Enviar
                                                            </button>
                                                        </form>

                                                        @else
                                                        <h2>Asignar Horario</h2>
                                                        <form action="{{ route('areas.horarioCreate') }}" role="form"
                                                            method="POST">
                                                            @csrf
                                                            <input value="{{ $area->id }}" name="area_id"
                                                                type="hidden" />
                                                            <h3 class="m-t-none m-b">Seleccione uno de los horarios
                                                                disponibles:</h3>
                                                            <div class="row">
                                                                @foreach($horariosDisponibles as $index => $horario)
                                                                @if($index % 4 == 0)
                                                            </div>
                                                            <div class="row">
                                                                @endif
                                                                <div class="col-md-3">
                                                                    <div class="ibox">
                                                                        <div style="cursor: pointer"
                                                                            class="ibox-content product-box"
                                                                            onclick="toggleCheckbox(event, {{ $horario->id }})">
                                                                            <div class="product-desc">
                                                                                <div style="display: flex; gap:60%">
                                                                                    <h1 class="product-name">{{
                                                                                        $horario->dia }}</h1>
                                                                                    <input type="checkbox"
                                                                                        value="{{ $horario->id }}"
                                                                                        name="horario_presencial_id"
                                                                                        class="horario-checkbox"
                                                                                        id="checkbox-{{ $horario->id }}"
                                                                                        onchange="updateSubmitButton()" />
                                                                                </div>
                                                                                <div class="m-t-xs">Desde: {{
                                                                                    $horario->hora_inicial }}</div>
                                                                                <div class="m-t-xs">Hasta: {{
                                                                                    $horario->hora_final }}</div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @endforeach
                                                            </div>
                                                            <button class="btn btn-primary btn-sm m-t-n-xs float-right"
                                                                type="submit" id="submit-button" disabled>
                                                                <i class="fa fa-check"></i>&nbsp;Enviar
                                                            </button>
                                                        </form>

                                                        @endif
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










        @include('components.inspinia.footer-inspinia')
    </div>
    </div>
    <style>
        /*Ocultar la fecha del calendario*/
        .fc-toolbar {
            display: none;
        }
    </style>
    <script>
        function toggleCheckbox(event, id) {
            if (event.target.tagName !== 'INPUT') {
                const checkbox = document.getElementById(`checkbox-${id}`);
                checkbox.checked = !checkbox.checked;
                updateSubmitButton();
            }
            uncheckOthers(id);
        }
    
        function uncheckOthers(id) {
            const checkboxes = document.querySelectorAll('.horario-checkbox');
            checkboxes.forEach(checkbox => {
                if (checkbox.id !== `checkbox-${id}`) {
                    checkbox.checked = false;
                }
            });
        }
    
        function updateSubmitButton() {
            const checkboxes = document.querySelectorAll('.horario-checkbox');
            const submitButton = document.getElementById('submit-button');
            let isAnyChecked = false;
            checkboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    isAnyChecked = true;
                }
            });
            submitButton.disabled = !isAnyChecked;
        }
    </script>



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
            const area = <?php echo json_encode($area); ?>;
            
            var eventosHorarios = horariosFormateados.map(function(horario) {
                var numeroDia;
                if(horario.dia == "Lunes"){
                    numeroDia = 5;
                } else if(horario.dia == "Martes"){
                    numeroDia = 6;
                } else if(horario.dia == "Miércoles"){
                    numeroDia = 7;
                } else if(horario.dia == "Jueves"){
                    numeroDia = 8;
                } else if(horario.dia == "Viernes"){
                    numeroDia = 9;
                } else if(horario.dia == "Sábado"){
                    numeroDia = 10;
                } else if(horario.dia == "Domingo"){
                    numeroDia = 4;
                } else{
                    numeroDia = 4;
                }
                return {
                    title: area.especializacion,
                    start: new Date(2024, 1, numeroDia, horario.hora_inicial, 0),
                    end: new Date(2024, 1, numeroDia, horario.hora_final, 0),
                    allDay: false,
                    color: area.color_hex,
                    editable: false
                };
            });
            
    
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
                minTime: '08:00:00',
                maxTime: '18:00:01',
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