<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>DASHBOARD</title>
</head>

<body>
    <div id="wrapper">
        @include('components.inspinia.side_nav_bar-inspinia')
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-12">
                <h2 class="font-bold">PÁGINA DE INICIO</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active">
                        <strong>Inicio</strong>
                    </li>
                </ol>
            </div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="ibox">
                                <div class="ibox-title">
                                    <h5>Reuniones del día</h5>
                                </div>
                                <div class="ibox-content">
                                    <div id="ReunionesCalendar"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="ibox">
                                <div class="ibox-title">
                                    <h5>Áreas de hoy</h5>
                                </div>
                                <div class="ibox-content">
                                    <div id="AreasCalendar"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <h5>Promedios Áreas</h5>
                        </div>
                        <div class="ibox-content">
                            <div style="width: 100%; overflow-x: scroll;">
                                <div id="areasMetrics" style="height: 500px;" style="width: 1000px;"></div>
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
</style>

<script>
    // Datos para el calendario de reuniones
    $(document).ready(function() {
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green'
            });
    
            // initialize the external events
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
    
            // initialize the calendar
            var date = new Date();
            var d = date.getDate();
            var m = date.getMonth();
            var y = date.getFullYear();

            var reunionesProgramadas = <?php echo json_encode($reunionesProgramadas); ?>;
    
            var eventosHorarios = reunionesProgramadas.map(function(reunion) {
                let hf = reunion.horario_modificado;
                return {
                    title: reunion.descripcion,
                    start: new Date(hf.year, hf.month, hf.day, hf.hora_inicial, 0),
                    end: new Date(hf.year, hf.month, hf.day, hf.hora_final, 0),
                    allDay: false,
                    editable: false,
                    url: hf.url
                };
            });
    
            $('#ReunionesCalendar').fullCalendar({
                header: {
                    left: '',
                    center: 'title',
                    right: ''
                },
                editable: false,
                droppable: false, 
                defaultView: 'agendaDay',
                timeFormat: 'h:mm A',
                columnHeaderFormat: 'ddd M/D',
                drop: function() {
                    if ($('#drop-remove').is(':checked')) {
                        $(this).remove();
                    }
                },
                events: eventosHorarios,
            });
        });
</script>
<script>
    // Datos para las áreas asistentes
    $(document).ready(function() {
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green'
            });
    
            // initialize the external events
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
    
            // initialize the calendar
            var date = new Date();
            var d = date.getDate();
            var m = date.getMonth();
            var y = date.getFullYear();

            var areas = <?php echo json_encode($areas); ?>;
    
            var eventosHorarios = areas.map(function(area) {
                return {
                    title: area.especializacion,
                    start: new Date(y, m, d, area.hora_inicial, 0),
                    end: new Date(y, m, d, area.hora_final, 0),
                    allDay: false,
                    color: area.color,
                    editable: false,
                    url: area.url
                };
            });
    
            $('#AreasCalendar').fullCalendar({
                header: {
                    left: '',
                    center: 'title',
                    right: ''
                },
                editable: false,
                droppable: false, 
                defaultView: 'agendaDay',
                timeFormat: 'h:mm A',
                columnHeaderFormat: 'ddd M/D',
                drop: function() {
                    if ($('#drop-remove').is(':checked')) {
                        $(this).remove();
                    }
                },
                events: eventosHorarios,
            });
        });
</script>

<script>
    // Datos de ejemplo para el gráfico de barras
    let areasProm = <?php echo json_encode($areasProm); ?>;
    // Array Nombres áreas
    let nombresAreas = areasProm.map(areaProm => areaProm.area.especializacion);
    let coloresAreas = areasProm.map(areaProm => areaProm.area.color_hex);
    let promediosAreas = areasProm.map(areaProm => areaProm.promedio);

    new Chartist.Bar('#areasMetrics', 
        {
            labels: nombresAreas/*.concat(nombresAreas).concat(nombresAreas).concat(nombresAreas).concat(nombresAreas)*/, //Nombres de las áreas en la parte inferior
            series: [
                promediosAreas/*.concat(promediosAreas).concat(promediosAreas).concat(promediosAreas).concat(promediosAreas)*/,  // Notas de cada área 
            ]
        }, {
            stackBars: false,
            axisY: {
                low: 0,           // Valor mínimo
                high: 20,         // Valor máximo
                onlyInteger: true, // Para asegurarse de que sólo haya enteros en la escala
                labelInterpolationFnc: function(value) {
                    return value;  // Mostrar los valores tal cual
                }
            }
        }).on('draw', function(data) {
            if (data.type === 'bar') {
                // Cambiar el ancho de las barras
                data.element.attr({
                    style: 'stroke: ' + coloresAreas[data.index] + '; stroke-width: 40px'
                });
                // Verifica que el valor existe antes de crear el texto
                if (typeof data.value !== 'undefined') {
                    // Agregar el valor encima de cada barra
                    data.group.append(new Chartist.Svg('text', {
                        x: data.x1 + (data.element.width() / 2),
                        y: data.y1 - 10, // Ajustar la posición vertical del texto
                        style: 'text-anchor: middle',
                        'font-size': '12px',
                        'font-weight': 'bold',
                        fill: '#000' // Color del texto
                    }, 'ct-bar-label').text(data.value));
                }
            }
        });
</script>

</html>