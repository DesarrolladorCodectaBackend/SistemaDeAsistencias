<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/caja-chica/index.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
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
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>¡Éxito!</strong> {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @elseif(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
            </section>

            <p>INGRESOS: S/{{ $ingresos }}</p>
            <p>EGRESOS: S/{{ $egresos }}</p>


            <div class="transaccion-content m-3">
                <div class="fecha-content">
                    <label class="fecha-text">Fecha:</label>
                    <input type="text" id="semana" class="fecha-input" readonly>

                    <div class="saldo-content" readonly>
                        <label class="saldo-text">Saldo Actual:</label>
                        <label> S/{{ $saldoActual->saldo_actual ?? 0 }} </label>
                    </div>
                </div>

                <div class="btns-transaccion-content">
                    <button type="button" class="btn btn-primary btn-add-registro" data-toggle="modal" data-target="#transaccionModal">
                        Agregar
                    </button>

                    <button type="button" class="btn btn-danger btn-cerrar-caja" onclick="confirmarCierre()">
                        Cerrar Caja
                    </button>
                </div>
            </div>

            {{-- modal registro transaccion --}}
            <div class="modal fade" id="transaccionModal" tabindex="-1" role="dialog" aria-labelledby="transaccionModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="transaccionModalLabel">Pagos Depósito-Caja</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                <span aria-hidden="true">&times;</span>
                            </button>
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
                                        <input type="text" name="nombres" class="form-control">
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

            <table class="table table-bordered" cellpadding="10" cellspacing="0">
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
                    @foreach ($depositos as $deposito)
                        <tr>
                            <td>{{ str_pad($deposito->nro_pago, 4, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ $deposito->fecha}}</td>
                            <td>{{ $deposito->dni }}</td>
                            <td>{{ $deposito->nombres }}</td>
                            <td>{{ $deposito->tipo_transaccion->descripcion }}</td>
                            <td>{{ $deposito->monto}} </td>
                            <td>0</td>
                            <td>
                                <button class="btn btn-secondary btn-sm" disabled>Pagado</button>
                                <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#verdepositoModal{{ $deposito->id }}"
                                >
                                    Ver
                                </button>
                            </td>
                        </tr>

                        {{-- modal ver transaccion deposito --}}
                        <div class="modal fade" id="verdepositoModal{{ $deposito->id }}" tabindex="-1" role="dialog" aria-labelledby="verdepositoModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title" id="pagoModalLabel{{ $deposito->id }}">Pago-Depósito</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                    </div>
                                        <div class="registro-content">
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label class="form-label" for="fecha">Fecha:</label>
                                                    <input type="date" class="form-control" value="{{ $deposito->fecha ?? 'Pendiente' }}" readonly>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label" for="nombres">Nombres:</label>
                                                    <input type="text" class="form-control" value="{{ $deposito->nombres }}" readonly>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label" for="dni">DNI:</label>
                                                    <input type="number" class="form-control" value="{{ $deposito->dni }}" readonly>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label class="form-label" for="descripcion">Descripción:</label>
                                                    <input type="text" class="form-control" value="{{ $deposito->descripcion }}" readonly>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label" for="tipo_transaccion">Tipo de Transacción:</label>
                                                    <input type="text" class="form-control" value={{ $deposito->tipo_transaccion->descripcion }} readonly>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-3">
                                                    <label class="form-label" for="monto">Monto:</label>
                                                    <div class="text-soles">
                                                        <h3>S/</h3>
                                                        <input type="number" class="form-control" value="{{ $deposito->monto }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-9">
                                                    <label class="form-label"><b>Observaciones:</b></label>
                                                    <textarea class="form-control observaciones" readonly>{{ $deposito->observaciones}}</textarea>
                                                </div>
                                            </div>

                                        </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    @foreach($cajas as $caja)
                        <tr>
                            <td>{{ str_pad($caja->nro_pago, 4, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ $caja->fecha ?? 'Pendiente' }}</td>
                            <td>{{ $caja->dni }}</td>
                            <td>{{ $caja->nombres }}</td>
                            <td>{{ $caja->tipo_transaccion->descripcion }}</td>
                            <td>0</td>
                            <td>{{ $caja->monto}}</td>
                            <td>
                                <button class="btn btn-secondary btn-sm" disabled>Pagado</button>
                                <button class="btn btn-success btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#vercajaModal{{ $caja->id }}"
                                >
                                    Ver
                                </button>
                            </td>
                        </tr>

                        {{-- ver transaccion caja --}}
                        <div class="modal fade" id="vercajaModal{{ $caja->id }}" tabindex="-1" role="dialog" aria-labelledby="vercajaModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title" id="pagoModalLabel{{ $caja->id }}">Pago Caja</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                    </div>
                                        <div class="registro-content">
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label class="form-label" for="fecha">Fecha:</label>
                                                    <input type="date" class="form-control" value="{{ $caja->fecha ?? 'Pendiente' }}" readonly>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label" for="nombres">Nombres:</label>
                                                    <input type="text" class="form-control" value="{{ $caja->nombres }}" readonly>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label" for="dni">DNI:</label>
                                                    <input type="number" class="form-control" value="{{ $caja->dni }}" readonly>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label class="form-label" for="descripcion">Descripción:</label>
                                                    <input type="text" class="form-control" value="{{ $caja->descripcion }}" readonly>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label" for="tipo_transaccion">Tipo de Transacción:</label>
                                                    <input type="text" class="form-control" value={{ $caja->tipo_transaccion->descripcion }} readonly>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-3">
                                                    <label class="form-label" for="monto">Monto:</label>
                                                    <div class="text-soles">
                                                        <h3>S/</h3>
                                                        <input type="number" class="form-control" value="{{ $caja->monto }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-9">
                                                    <label class="form-label"><b>Observaciones:</b></label>
                                                    <textarea class="form-control observaciones" readonly>{{ $caja->observaciones}}</textarea>
                                                </div>
                                            </div>

                                        </div>

                                </div>
                            </div>
                        </div>
                    @endforeach

                    @foreach($colaboradores as $colaborador)
                        <tr>
                            <td>
                                @isset($colaborador->transaccion)
                                    {{ str_pad($colaborador->transaccion->nro_pago, 4, '0', STR_PAD_LEFT) }}
                                @else
                                    N/A
                                @endisset
                            </td>
                            <td>
                                @if ($colaborador->transaccion && $colaborador->transaccion->fecha)
                                    {{ $colaborador->transaccion->fecha }}
                                @else
                                    Pendiente
                                @endif
                            </td>

                            <td>{{ $colaborador->candidato->dni ?? 'Sin DNI'}}</td>
                            <td>{{ $colaborador->candidato->nombre . " " . $colaborador->candidato->apellido }}</td>
                            <td>Colaborador</td>
                            <td>0</td>
                            <td>{{ $colaborador->transaccion->monto ?? $colaborador->total_monto }}</td>

                            <td>
                                @if($colaborador->pagado)
                                    <button class="btn btn-secondary btn-sm" disabled>Pagado</button>
                                    <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#verpagoModal{{ $colaborador->id }}"
                                            data-descripcion="{{ implode(' - ', $colaborador->pago_colaborador->pluck('descripcion')->toArray()) }}">
                                        Ver
                                    </button>
                                @else
                                    <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#pagoModal{{ $colaborador->id }}"
                                            data-descripcion="{{ implode(' - ', $colaborador->pago_colaborador->pluck('descripcion')->toArray()) }}">
                                        Pagar
                                    </button>
                                @endif
                            </td>
                        </tr>

                        {{-- modal ver transaccion colaborador --}}
                        <div class="modal fade" id="verpagoModal{{ $colaborador->id }}" tabindex="-1"
                            aria-labelledby="verpagoModalLabel{{ $colaborador->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title" id="pagoModalLabel{{ $colaborador->id }}">Pago Colaborador</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                    </div>
                                    <div class="modal-body">

                                            <div class="transaccion-colab-content">
                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <label class="form-label"><b>Fecha:</b></label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $colaborador->transaccion ? $colaborador->transaccion->fecha : 'Pendiente' }}"
                                                            readonly>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="form-label"><b>Nombres:</b></label>
                                                        <input type="text" class="form-control" value="{{ $colaborador->candidato->nombre . ' ' . $colaborador->candidato->apellido }}" readonly>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="form-label"><b>DNI:</b></label>
                                                        <input type="number" class="form-control" value="{{ $colaborador->candidato->dni }}" readonly>
                                                    </div>
                                                </div>


                                                <div class="row mb-3">
                                                    <div class="col-md-8">
                                                        <label class="form-label"><b>Descripción:</b></label>
                                                        <input class="form-control descripcion-pago" type="text" value="{{ implode(' - ', $colaborador->pago_colaborador->pluck('descripcion')->toArray()) }}" readonly>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="form-label"><b>Tipo:</b></label>
                                                        <input class="form-control descripcion-pago" type="text" value="Colaborador" readonly>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <label class="form-label"><b>Método de Pago:</b></label>
                                                        <input type="text" class="form-control" value="{{ $colaborador->transaccion_detalle->metodo_pago ?? '...'}}" readonly>
                                                    </div>

                                                    <div class="col-md-5">
                                                        <label class="form-label"><b>Nro. Operación:</b></label>
                                                        <input type="text" class="form-control"
                                                        value="{{ $colaborador->transaccion_detalle ? $colaborador->transaccion_detalle->nro_operacion : '...' }}"
                                                        readonly>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <label class="form-label"><b>Monto:</b></label>
                                                        <div class="text-soles">
                                                            <h3>S/</h3>
                                                            <input type="text" class="form-control" value="{{ $colaborador->total_monto }}" readonly>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <label class="form-label"><b>Comprobante:</b></label>
                                                        @if (!empty($colaborador->transaccion_detalle->comprobante))
                                                            <div class="comprobante d-flex">
                                                                <a href="{{ asset('storage/comprobantes-pagos/' . $colaborador->transaccion_detalle->comprobante) }}"
                                                                    class="btn btn-success"
                                                                    download="{{ $colaborador->transaccion_detalle->comprobante }}"
                                                                    style="color: black;">
                                                                     <strong>Descargar Comprobante</strong>
                                                                 </a>
                                                            </div>
                                                        @else
                                                            <p class="text-muted">No hay comprobante disponible</p>
                                                        @endif
                                                    </div>

                                                    <div class="col-md-8">
                                                        <label class="form-label"><b>Observaciones:</b></label>
                                                        <textarea class="form-control observaciones" readonly>{{ $colaborador->transaccion ? $colaborador->transaccion->observaciones : '' }}</textarea>
                                                    </div>
                                                </div>
                                            </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- modal transaccion colaborador --}}
                        <div class="modal fade" id="pagoModal{{ $colaborador->id }}" tabindex="-1"
                            aria-labelledby="pagoModalLabel{{ $colaborador->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title" id="pagoModalLabel{{ $colaborador->id }}">Realizar Pago Colaborador</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('caja.transaccionColab', $colaborador->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="colaborador_id" value="{{ $colaborador->id }}">

                                            <div class="transaccion-colab-content">
                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <label class="form-label"><b>Fecha:</b></label>
                                                        <input type="date" class="form-control" name="fecha" value="{{ \Carbon\Carbon::today()->format('Y-m-d') }}" readonly>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="form-label"><b>Nombres:</b></label>
                                                        <input type="text" class="form-control" name="nombre" value="{{ $colaborador->candidato->nombre . ' ' . $colaborador->candidato->apellido }}" readonly>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="form-label"><b>DNI:</b></label>
                                                        <input type="number" class="form-control" name="dni" value="{{ $colaborador->candidato->dni }}" readonly>
                                                    </div>
                                                </div>


                                                <div class="row mb-3">
                                                    <div class="col-md-8">
                                                        <label class="form-label"><b>Descripción:</b></label>
                                                        <input class="form-control descripcion-pago" type="text" name="descripcion" value="{{ implode(' - ', $colaborador->pago_colaborador->pluck('descripcion')->toArray()) }}" readonly>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="form-label"><b>Tipo:</b></label>
                                                        <input class="form-control descripcion-pago" type="text" value="Colaborador" readonly>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label class="form-label"><b>Método de Pago:</b></label>
                                                        <div class="btn-group" role="group" aria-label="Método de Pago">
                                                            <input type="radio" class="btn-check" name="metodo_pago" id="yape{{ $colaborador->id }}" value="Yape" required>
                                                            <label class="btn" for="yape{{ $colaborador->id }}">Yape</label>

                                                            <input type="radio" class="btn-check" name="metodo_pago" id="plin{{ $colaborador->id }}" value="Plin" required>
                                                            <label class="btn" for="plin{{ $colaborador->id }}">Plin</label>

                                                            <input type="radio" class="btn-check" name="metodo_pago" id="transferencia{{ $colaborador->id }}" value="Transferencia" required>
                                                            <label class="btn" for="transferencia{{ $colaborador->id }}">Transferencia</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-5">
                                                        <label class="form-label"><b>Nro. Operación:</b></label>
                                                        <input type="number" class="form-control" name="nro_operacion">
                                                    </div>

                                                    <div class="col-md-3">
                                                        <label class="form-label"><b>Monto:</b></label>
                                                        <div class="text-soles">
                                                            <h3>S/</h3>
                                                            <input type="text" class="form-control" name="total_monto" value="{{ $colaborador->total_monto }}" readonly>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <label class="form-label"><b>Comprobante:</b></label>
                                                        <input type="file" name="comprobante" class="form-control img-text" required>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <label class="form-label"><b>Observaciones:</b></label>
                                                        <textarea class="form-control observaciones" name="observaciones"></textarea>
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    <button type="submit" class="btn btn-success">Confirmar Pago</button>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>

        </main>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function confirmarCierre() {
            Swal.fire({
                title: "¿Deseas cerrar la caja? La caja cerrará la semana actual.",
                showCancelButton: true,
                confirmButtonText: "Cerrar Caja",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    let form = document.createElement('form');
                    form.method = 'POST';

                    form.action = "<?php echo route('caja.cerrarSemana'); ?>";

                    let csrfTokenInput = document.createElement('input');
                    csrfTokenInput.type = 'hidden';
                    csrfTokenInput.name = '_token';
                    csrfTokenInput.value = "<?php echo csrf_token(); ?>";
                    form.appendChild(csrfTokenInput);

                    let methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'PUT';
                    form.appendChild(methodInput);

                    document.body.appendChild(form);
                    form.submit();
                } else {
                    Swal.fire({
                        title: "Acción cancelada",
                        text: "La caja no fue cerrada",
                        icon: "info",
                        customClass: {
                            content: 'swal-content'
                        }
                    });
                    const style = document.createElement('style');
                    style.innerHTML = `
                        .swal2-html-container{
                            color: #FFFFFF;
                        }
                    `;
                    document.head.appendChild(style);
                }
            });
        }
    </script>

    <script>
        function obtenerSemana() {
            var fechaHoy = new Date();
            var diaSemana = fechaHoy.getDay();
            var diferencia = (diaSemana == 0 ? 6 : diaSemana - 1);

            fechaHoy.setDate(fechaHoy.getDate() - diferencia);
            var lunes = new Date(fechaHoy);
            var lunesFormato = lunes.getDate().toString().padStart(2, '0') + '/' + (lunes.getMonth() + 1).toString().padStart(2, '0') + '/' + lunes.getFullYear();

            var siguienteLunes = new Date(lunes);
            siguienteLunes.setDate(lunes.getDate() + 7);
            var siguienteLunesFormato = siguienteLunes.getDate().toString().padStart(2, '0') + '/' + (siguienteLunes.getMonth() + 1).toString().padStart(2, '0') + '/' +  siguienteLunes.getFullYear();

            return lunesFormato + ' - ' + siguienteLunesFormato;
        }

        document.getElementById('semana').value = obtenerSemana();
    </script>

</body>
</html>
