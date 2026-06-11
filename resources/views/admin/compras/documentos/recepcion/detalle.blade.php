@extends('admin.layouts.app')
@section('title', 'Detalle de Recepción #' . $orden->codigo)

@section('content')
<div class="dashboard-hero" style="padding: 2rem 2rem; border-radius: 0 0 1.5rem 1.5rem; margin-bottom: 2.5rem;">
    <div class="hero-glow-alt" style="top: -50px; right: 0; filter: blur(60px); opacity: 0.2;"></div>
    <div class="container-fluid position-relative z-1">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center">
            <div class="mb-3 mb-lg-0">
                <div class="d-inline-flex align-items-center px-3 py-1 bg-white bg-opacity-10 rounded-pill fs-6 mb-3 border border-white border-opacity-25 backdrop-blur">
                    <i class="fas fa-list-alt text-info me-2"></i> Reporte Detallado
                </div>
                <h2 class="fw-bold mb-1 tracking-tight text-white display-6 text-shadow-sm">
                    Recepción #{{ $orden->codigo }}
                </h2>
                @php
                    $estado = $orden->estado_recepcion ?? 'pendiente';
                    $badgeMap = ['completo' => 'success', 'completo_con_faltantes' => 'warning', 'parcial' => 'info', 'pendiente' => 'secondary'];
                    $badgeColor = $badgeMap[$estado] ?? 'secondary';
                @endphp
                <span class="badge rounded-pill bg-{{ $badgeColor }} px-3 py-2 fw-bold mt-1">
                    <i class="fas fa-circle me-1 small"></i>
                    @if($estado === 'completo_con_faltantes') COMPLETO CON FALTANTES
                    @else {{ strtoupper($estado) }}
                    @endif
                </span>
            </div>
            <div class="d-flex flex-wrap gap-2">
                @if(!in_array($orden->estado_recepcion, ['completo','completo_con_faltantes']))
                <a href="{{ route('admin.recepcion.show', $orden->id) }}"
                   class="btn bg-white bg-opacity-10 text-white rounded-pill px-4 py-2 fw-bold shadow-sm border border-white border-opacity-25">
                    <i class="fas fa-edit me-2"></i> Continuar Recepción
                </a>
                @endif
                <a href="{{ route('admin.recepcion.index') }}"
                   class="btn bg-white text-dark rounded-pill px-4 py-2 fw-bold shadow-sm border-0">
                    <i class="fas fa-arrow-left text-primary me-2"></i> Volver
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid px-3 px-lg-4 position-relative" style="top: -3.5rem; z-index: 10;">

    {{-- Tarjetas resumen --}}
    @php
        $totalPedidos  = $orden->detalles->sum('cantidad_en_compra');
        $totalRecibido = $orden->detalles->sum('cantidad_recibida');
        $totalDevuelto = $orden->detalles->sum(fn($d) => $d->devoluciones->sum('cantidad_devuelta'));
        $totalPendiente = $totalPedidos - $totalRecibido;
    @endphp
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="card dashboard-card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3 p-3">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-circle flex-shrink-0">
                        <i class="fas fa-boxes text-primary"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-0 small">Pedidos</p>
                        <h4 class="mb-0 fw-bold text-primary">{{ $totalPedidos }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card dashboard-card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3 p-3">
                    <div class="bg-success bg-opacity-10 p-3 rounded-circle flex-shrink-0">
                        <i class="fas fa-check-circle text-success"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-0 small">Recibidos</p>
                        <h4 class="mb-0 fw-bold text-success">{{ $totalRecibido }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card dashboard-card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3 p-3">
                    <div class="bg-warning bg-opacity-10 p-3 rounded-circle flex-shrink-0">
                        <i class="fas fa-undo text-warning"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-0 small">Devueltos</p>
                        <h4 class="mb-0 fw-bold text-warning">{{ $totalDevuelto }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card dashboard-card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3 p-3">
                    <div class="bg-secondary bg-opacity-10 p-3 rounded-circle flex-shrink-0">
                        <i class="fas fa-clock text-secondary"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-0 small">Pendientes</p>
                        <h4 class="mb-0 fw-bold text-secondary">{{ $totalPendiente }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabla de detalle por producto --}}
    <div class="card dashboard-card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 pt-4 pb-2 px-4">
            <h5 class="mb-0 fw-bold"><i class="fas fa-list me-2 text-primary"></i> Detalle por Producto</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="py-3 px-4 border-0 text-uppercase small">Producto</th>
                            <th class="py-3 px-4 border-0 text-uppercase small text-center">Pedida</th>
                            <th class="py-3 px-4 border-0 text-uppercase small text-center">Recibida</th>
                            <th class="py-3 px-4 border-0 text-uppercase small text-center">Devuelta</th>
                            <th class="py-3 px-4 border-0 text-uppercase small text-center">Pendiente</th>
                            <th class="py-3 px-4 border-0 text-uppercase small text-center">Estado</th>
                            <th class="py-3 px-4 border-0 text-uppercase small text-center">Historial</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orden->detalles as $detalle)
                        @php
                            $estadoDet  = $detalle->estado_recepcion ?? 'pendiente';
                            $colorDet   = ['completo' => 'success', 'completo_con_faltantes' => 'warning', 'parcial' => 'info', 'pendiente' => 'secondary'][$estadoDet] ?? 'secondary';
                            $devueltos  = $detalle->devoluciones->sum('cantidad_devuelta');
                            $pendienteDet = $detalle->cantidad_en_compra - ($detalle->cantidad_recibida ?? 0);
                        @endphp
                        <tr>
                            <td class="px-4 py-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold flex-shrink-0"
                                         style="width:40px;height:40px;background:linear-gradient(135deg,#667eea,#764ba2);">
                                        {{ strtoupper(substr($detalle->nombre_producto, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold small">{{ $detalle->nombre_producto }}</div>
                                        <div class="text-muted small"><i class="fas fa-barcode me-1"></i>{{ $detalle->codigo }}</div>
                                        <span class="badge bg-light text-dark rounded-pill small">{{ ucfirst($detalle->tipo_item) }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2 fw-bold">{{ $detalle->cantidad_en_compra }}</span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2 fw-bold">{{ $detalle->cantidad_recibida ?? 0 }}</span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="badge bg-warning-subtle text-warning rounded-pill px-3 py-2 fw-bold">{{ $devueltos }}</span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3 py-2 fw-bold">{{ $pendienteDet }}</span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="badge bg-{{ $colorDet }}-subtle text-{{ $colorDet }} rounded-pill px-3 py-2 small fw-bold text-uppercase">
                                    @if($estadoDet === 'completo_con_faltantes') C/Faltantes
                                    @else {{ $estadoDet }}
                                    @endif
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if($detalle->recepciones->count() > 0)
                                <button class="btn btn-outline-primary btn-sm rounded-pill px-3"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#hist-{{ $detalle->id }}">
                                    <i class="fas fa-history me-1"></i> {{ $detalle->recepciones->count() }}
                                </button>
                                @else
                                <span class="text-muted small">Sin registros</span>
                                @endif
                            </td>
                        </tr>

                        {{-- Historial colapsable --}}
                        @if($detalle->recepciones->count() > 0)
                        <tr>
                            <td colspan="7" class="p-0 border-0">
                                <div class="collapse" id="hist-{{ $detalle->id }}">
                                    <div class="bg-light px-4 py-3">
                                        <h6 class="fw-bold mb-3 text-muted small text-uppercase">
                                            <i class="fas fa-history me-2"></i>Recepciones registradas
                                        </h6>
                                        <div class="row g-2 mb-3">
                                            @foreach($detalle->recepciones as $rec)
                                            <div class="col-md-6 col-lg-4">
                                                <div class="card border-0 shadow-sm rounded-3">
                                                    <div class="card-body p-3">
                                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                                            <span class="badge bg-success-subtle text-success rounded-pill px-2">{{ $rec->cantidad_recibida }} ítems</span>
                                                            <small class="text-muted">{{ $rec->fecha_recepcion->format('d/m/Y') }}</small>
                                                        </div>
                                                        <div class="small fw-semibold">{{ $rec->recibidoPor->name }}</div>
                                                        @if($rec->observaciones)
                                                        <div class="small text-muted mt-1 fst-italic">{{ $rec->observaciones }}</div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>

                                        @if($detalle->devoluciones->count() > 0)
                                        <h6 class="fw-bold mb-2 text-muted small text-uppercase">
                                            <i class="fas fa-undo me-2"></i>Devoluciones
                                        </h6>
                                        <div class="row g-2">
                                            @foreach($detalle->devoluciones as $dev)
                                            <div class="col-md-6 col-lg-4">
                                                <div class="card border-warning border-0 shadow-sm rounded-3">
                                                    <div class="card-body p-3">
                                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                                            <span class="badge bg-warning-subtle text-warning rounded-pill px-2">{{ $dev->cantidad_devuelta }} devueltos</span>
                                                            <small class="text-muted">{{ $dev->fecha_devolucion->format('d/m/Y') }}</small>
                                                        </div>
                                                        <div class="small fw-semibold">{{ $dev->devueltoPor->name }}</div>
                                                        <div class="small text-muted mt-1">{{ $dev->motivo }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 pb-4">
        <a href="{{ route('admin.recepcion.index') }}"
           class="btn btn-outline-secondary rounded-pill px-4 py-2 fw-bold border-0">
            <i class="fas fa-arrow-left me-2"></i> Volver al Listado
        </a>
        @if(!in_array($orden->estado_recepcion, ['completo','completo_con_faltantes']))
        <a href="{{ route('admin.recepcion.show', $orden->id) }}"
           class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow-sm border-0">
            <i class="fas fa-edit me-2"></i> Continuar Recepción
        </a>
        @endif
    </div>
</div>
@endsection
