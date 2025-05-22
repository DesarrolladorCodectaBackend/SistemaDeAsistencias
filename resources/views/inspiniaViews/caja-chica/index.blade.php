<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/caja-chica/index.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- SweetAlert2 para confirmaciones -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Editar Colaborador</title>
</head>

<body>
    <div id="wrapper">
        @include('components.inspinia.side_nav_bar-inspinia')
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{route('dashboard')}}">Inicio</a>
                    </li>
                    <li class="breadcrumb-item active">
                        <span>Personal</span>
                    </li>
                    <li class="breadcrumb-item active">
                        <strong>Caja Chica</strong>
                    </li>
                </ol>
            </div>
        </div>

        <main class="main-caja">
            <section class="section-caja m-3">
                @if(session('warning'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Advertencia!</strong> {{ session('warning') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>¡Éxito!</strong> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @elseif(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </section>

            <div class="transaccion-content m-3">
                <div class="saldo-content col-2 d-flex" readonly>
                    <label class="saldo-text">Saldo Actual:</label>
                    <label class="saldo-text"> S/{{ $saldoActual->saldo_actual ?? 0 }} </label>
                </div>

                <form id="filtrar-form">
                    <div class="filter-fecha-caja-content">
                        <div>
                            <label for="fecha_inicio">Fecha Inicio:</label>
                            <input type="date" id="fecha_inicio" name="fecha_inicio" value="{{ \Carbon\Carbon::today()->format('Y-m-d') }}" required>
                        </div>

                        <div>
                            <label for="fecha_fin">Fecha Fin:</label>
                            <input type="date" id="fecha_fin" name="fecha_fin" required>
                        </div>

                        <div class="btn-filter-content">
                            <button type="submit" class="btn-filter-montos btn-success">Filtrar</button>
                        </div>
                    </div>
                </form>

                <div class="total-ingresos-egresos-content row">
                    <div class="text-center total-in-content">
                        <h3>Total de Ingresos: S/<span id="total-ingresos">0</span></h3>
                    </div>

                    <div class="text-center total-e-content">
                        <h3>Total de Egresos: S/<span id="total-egresos">0</span></h3>
                    </div>
                </div>

                <div class="btns-transaccion-content">
                    @if($cajaAbierta)
                        <button class="btn btn-danger" onclick="cerrarCaja()">Cerrar Caja</button>
                        <!-- CORREGIDO: Bootstrap 5 sintaxis -->
                        <button type="button" class="btn btn-primary btn-add-registro" data-bs-toggle="modal" data-bs-target="#transaccionModal">
                            Agregar
                        </button>
                    @else
                        <button onclick="abrirCaja()" class="btn btn-primary">Abrir Caja</button>
                    @endif
                </div>
            </div>

            {{-- modal registro transaccion - CORREGIDO --}}
            <div class="modal fade" id="transaccionModal" tabindex="-1" aria-labelledby="transaccionModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="transaccionModalLabel">Pagos Depósito-Caja</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                        </div>
                        <form method="POST" action="{{ route('caja.registroTransaccion') }}">
                            @csrf
                            <div class="registro-content">
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label class="form-label" for="fecha">Fecha:</label>
                                        <input type="date" class="form-control" name="fecha" value="{{ \Carbon\Carbon::today()->format('Y-m-d') }}" readonly>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="nombres">Nombres:</label>
                                        <div class="d-flex">
                                            <input type="text" name="nombres" id="nombres" class="form-control">
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalUsuarios">
                                                ...
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="dni">DNI:</label>
                                        <input type="number" name="dni" class="form-control">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label" for="descripcion">Descripción:</label>
                                        <input type="text" name="descripcion" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="tipo_transaccion">Tipo de Transacción:</label>
                                        <select name="tipo_transaccion_id" id="tipo_transaccion" class="form-control">
                                            <option value="selected">Seleccionar tipo</option>
                                            <option value="1">Depósito</option>
                                            <option value="2">Caja</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label class="form-label" for="monto">Monto:</label>
                                        <div class="text-soles">
                                            <h3>S/</h3>
                                            <input type="number" name="monto" class="form-control" step="0.01" required>
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <label class="form-label"><b>Observaciones:</b></label>
                                        <textarea class="form-control observaciones" name="observaciones"></textarea>
                                    </div>
                                </div>

                                <div class="btn-registro-content">
                                    <button type="submit" class="btn btn-primary">Registrar Transacción</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- modal seleccion usuario --}}
            <div class="modal fade" id="modalUsuarios" tabindex="-1" aria-labelledby="modalUsuariosLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalUsuariosLabel">Seleccionar Usuario</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="text" id="buscarUsuario" class="form-control mb-3" placeholder="Buscar usuario...">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Nombres</th>
                                        <th>Correo</th>
                                        <th>DNI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $index => $user)
                                        <tr class="seleccionar-usuario usuario-fila {{ $index < count($users) - 3 ? 'd-none' : '' }}"
                                            data-nombre="{{ $user->name }} {{ $user->apellido }}"
                                            data-dni="{{ $user->dni }}"
                                            data-filtro="{{ strtolower($user->name . ' ' . $user->apellido . ' ' . $user->email . ' ' . $user->dni) }}"
                                            style="cursor: pointer;">
                                            <td>{{ $user->name }} {{ $user->apellido }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->dni }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div id="noResultados" class="d-none text-center">
                                <p>No se encontraron usuarios</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Resto del contenido de la tabla... --}}
            <table class="table table-bordered" cellpadding="10" cellspacing="0" id="tabla-colaboradores">
                <thead>
                    <tr>
                        <th>NRO. PAGO</th>
                        <th>FECHA</th>
                        <th>DNI</th>
                        <th>NOMBRES</th>
                        <th>TIPO</th>
                        <th>INGRESOS</th>
                        <th>EGRESOS</th>
                        <th>ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Aquí irían tus loops de datos -->
                </tbody>
            </table>
        </main>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // JAVASCRIPT CORREGIDO - SIN JQUERY PARA EVITAR CONFLICTOS
        document.addEventListener('DOMContentLoaded', function() {

            // Filtro de fechas
            document.getElementById('filtrar-form').addEventListener('submit', function(event) {
                event.preventDefault();

                let fechaInicio = document.getElementById('fecha_inicio').value;
                let fechaFin = document.getElementById('fecha_fin').value;

                fetch("{{ route('caja.filtrarFecha') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        fecha_inicio: fechaInicio,
                        fecha_fin: fechaFin
                    })
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('total-ingresos').textContent = data.ingresos;
                    document.getElementById('total-egresos').textContent = data.egresos;
                })
                .catch(error => {
                    console.error("Error al filtrar:", error);
                });
            });

            // Búsqueda de usuarios
            document.getElementById('buscarUsuario').addEventListener('input', function() {
                var value = this.value.toLowerCase();
                var hasResults = false;
                var filas = document.querySelectorAll('.usuario-fila');

                if (value === '') {
                    filas.forEach(function(fila, index) {
                        if (index < filas.length - 3) {
                            fila.classList.add('d-none');
                        } else {
                            fila.classList.remove('d-none');
                        }
                    });
                    hasResults = true;
                } else {
                    filas.forEach(function(fila) {
                        var filtro = fila.dataset.filtro;
                        if (filtro.includes(value)) {
                            fila.classList.remove('d-none');
                            hasResults = true;
                        } else {
                            fila.classList.add('d-none');
                        }
                    });
                }

                var noResultados = document.getElementById('noResultados');
                if (hasResults) {
                    if (noResultados) noResultados.classList.add('d-none');
                } else {
                    if (noResultados) noResultados.classList.remove('d-none');
                }
            });

            // Selección de usuario
            document.addEventListener('click', function(e) {
                if (e.target.closest('.seleccionar-usuario')) {
                    var fila = e.target.closest('.seleccionar-usuario');
                    var nombre = fila.dataset.nombre;
                    var dni = fila.dataset.dni;

                    document.getElementById('nombres').value = nombre;
                    document.querySelector('input[name="dni"]').value = dni;

                    // Cerrar modal usando Bootstrap 5 API
                    var modal = bootstrap.Modal.getInstance(document.getElementById('modalUsuarios'));
                    if (modal) {
                        modal.hide();
                    }
                }
            });

            // Limpiar búsqueda al cerrar modal
            document.getElementById('modalUsuarios').addEventListener('hidden.bs.modal', function() {
                document.getElementById('buscarUsuario').value = '';
                var filas = document.querySelectorAll('.usuario-fila');
                filas.forEach(function(fila, index) {
                    if (index < filas.length - 3) {
                        fila.classList.add('d-none');
                    } else {
                        fila.classList.remove('d-none');
                    }
                });
                var noResultados = document.getElementById('noResultados');
                if (noResultados) noResultados.classList.add('d-none');
            });
        });

        // Funciones de caja
        function cerrarCaja() {
            fetch("{{ route('caja.cerrar') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json",
                },
            }).then(() => location.reload());
        }

        function abrirCaja() {
            fetch("{{ route('caja.abrir') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json",
                },
            }).then(() => location.reload());
        }

        // Función de confirmación para anular
        function confirmAnular(id) {
            Swal.fire({
                title: "¿Deseas anular esta transacción?",
                showCancelButton: true,
                confirmButtonText: "Anular",
                cancelButtonText: "Cancelar",
            }).then((result) => {
                if (result.isConfirmed) {
                    let form = document.createElement('form');
                    form.method = 'POST';
                    let routeTemplate = "<?php echo route('caja.anularTransaccionColab', ':id'); ?>";
                    form.action = routeTemplate.replace(':id', id);
                    form.innerHTML = `@csrf`;
                    document.body.appendChild(form);
                    form.submit();
                } else {
                    Swal.fire({
                        title: "Acción cancelada",
                        text: "La transacción no fue cancelada",
                        icon: "info"
                    });
                }
            });
        }
    </script>
</body>
</html>
