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



            <div class="transaccion-content m-3">

                <div class="fecha-content">

                    <div class="fecha-date-content d-flex flex-column">

                        <div class="saldo-content" readonly>
                            <label class="saldo-text">Saldo Actual:</label>
                            <label class="saldo-text"> S/{{ $saldoActual->saldo_actual ?? 0 }} </label>
                        </div>

                        <div>
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
                        </div>

                        <div>
                            <h3>Total de Ingresos: S/<span id="total-ingresos">0</span></h3>
                            <h3>Total de Egresos: S/<span id="total-egresos">0</span></h3>
                        </div>

                    </div>




                </div>

                <div class="btns-transaccion-content">
                    @if($cajaAbierta)
                        <button class="btn btn-danger" onclick="cerrarCaja()">Cerrar Caja</button>

                        <button type="button" class="btn btn-primary btn-add-registro" data-toggle="modal" data-target="#transaccionModal">
                            Agregar
                        </button>
                    @else
                        <button onclick="abrirCaja()" class="btn btn-primary">Abrir Caja</button>
                    @endif
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
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombres</th>
                                        <th>Correo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr class="seleccionar-usuario" data-nombre="{{ $user->name }} {{ $user->apellido }}" data-dni="{{ $user->dni }}">
                                            <td>{{ $user->id }}</td>
                                            <td>{{ $user->name }} {{ $user->apellido }}</td>
                                            <td>{{ $user->email }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- tabla transacciones --}}
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

    </script>

    <script>
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
    </script>

    <script>
        $(document).on("click", ".seleccionar-usuario", function () {
            let nombreCompleto = $(this).data("nombre");

            $("#nombres").val(nombreCompleto);
            // Cerrar el modal
            $("#modalUsuarios").modal("hide");
        });
    </script>


</body>
</html>
