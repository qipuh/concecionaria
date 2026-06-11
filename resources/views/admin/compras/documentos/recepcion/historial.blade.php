@extends('admin.layouts.app')
@section('title', 'Historial de Recepciones')

@section('content')
<div class="dashboard-hero" style="padding: 2rem 2rem; border-radius: 0 0 1.5rem 1.5rem; margin-bottom: 2.5rem;">
    <div class="hero-glow-alt" style="top: -50px; right: 0; filter: blur(60px); opacity: 0.2;"></div>
    <div class="container-fluid position-relative z-1">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center">
            <div class="mb-3 mb-lg-0">
                <div class="d-inline-flex align-items-center px-3 py-1 bg-white bg-opacity-10 rounded-pill fs-6 mb-3 border border-white border-opacity-25 backdrop-blur">
                    <i class="fas fa-history text-info me-2"></i> Auditoría
                </div>
                <h2 class="fw-bold mb-1 tracking-tight text-white display-6 text-shadow-sm">
                    Historial de Recepciones
                </h2>
                <p class="text-white-50 mb-0">Registro completo de todas las recepciones realizadas</p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('admin.recepcion.index') }}"
                   class="btn bg-white text-dark rounded-pill px-4 py-2 fw-bold shadow-sm border-0">
                    <i class="fas fa-arrow-left text-primary me-2"></i> Volver a Recepciones
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid px-3 px-lg-4 position-relative" style="top: -3.5rem; z-index: 10;">

    {{-- Tarjetas resumen --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="card dashboard-card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3 p-3">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-circle flex-shrink-0">
                        <i class="fas fa-clipboard-check text-primary"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-0 small">Total recepciones</p>
                        <h4 class="mb-0 fw-bold text-primary">{{ $recepciones->count() }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card dashboard-card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3 p-3">
                    <div class="bg-success bg-opacity-10 p-3 rounded-circle flex-shrink-0">
                        <i class="fas fa-cubes text-success"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-0 small">Ítems recibidos</p>
                        <h4 class="mb-0 fw-bold text-success">{{ $recepciones->sum('cantidad_recibida') }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card dashboard-card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3 p-3">
                    <div class="bg-info bg-opacity-10 p-3 rounded-circle flex-shrink-0">
                        <i class="fas fa-file-alt text-info"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-0 small">Órdenes procesadas</p>
                        <h4 class="mb-0 fw-bold text-info">{{ $recepciones->pluck('detalleOrdenCompra.orden_compra_id')->unique()->count() }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card dashboard-card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3 p-3">
                    <div class="bg-warning bg-opacity-10 p-3 rounded-circle flex-shrink-0">
                        <i class="fas fa-calendar-week text-warning"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-0 small">Este mes</p>
                        <h4 class="mb-0 fw-bold text-warning">{{ $recepciones->where('fecha_recepcion', '>=', now()->startOfMonth())->count() }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabla principal --}}
    <div class="card dashboard-card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 pt-4 pb-0 px-4 d-flex align-items-center justify-content-between">
            <h5 class="mb-0 fw-bold"><i class="fas fa-clipboard-list me-2 text-primary"></i> Registro Detallado</h5>
            <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2">{{ $recepciones->count() }} registros</span>
        </div>
        <div class="card-body p-0">
            @if($recepciones->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="py-3 px-4 border-0 text-uppercase small">Fecha</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Orden</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Producto</th>
                            <th class="py-3 px-4 border-0 text-uppercase small text-center">Tipo</th>
                            <th class="py-3 px-4 border-0 text-uppercase small text-center">Cantidad</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Recibido por</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Observaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recepciones as $recepcion)
                        <tr>
                            <td class="px-4 py-3">
                                <div class="fw-bold">{{ \Carbon\Carbon::parse($recepcion->fecha_recepcion)->format('d/m/Y') }}</div>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($recepcion->fecha_recepcion)->diffForHumans() }}</small>
                            </td>
                            <td class="px-4 py-3">
                                <div class="fw-bold text-primary">#{{ $recepcion->detalleOrdenCompra->ordenCompra->codigo }}</div>
                                <small class="text-muted">{{ $recepcion->detalleOrdenCompra->ordenCompra->proveedor->nombre_completo ?? $recepcion->detalleOrdenCompra->ordenCompra->proveedor->razon_social ?? '—' }}</small>
                            </td>
                            <td class="px-4 py-3">
                                <div class="fw-semibold small">{{ $recepcion->detalleOrdenCompra->nombre_producto }}</div>
                                <small class="text-muted"><i class="fas fa-barcode me-1"></i>{{ $recepcion->detalleOrdenCompra->codigo }}</small>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="badge bg-light text-dark rounded-pill px-3 small">
                                    {{ ucfirst($recepcion->detalleOrdenCompra->tipo_item) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2 fw-bold fs-6">
                                    {{ $recepcion->cantidad_recibida }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold flex-shrink-0"
                                         style="width:36px;height:36px;background:linear-gradient(135deg,#667eea,#764ba2);">
                                        {{ strtoupper(substr($recepcion->recibidoPor->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-semibold small">{{ $recepcion->recibidoPor->name }}</div>
                                        <small class="text-muted">{{ $recepcion->recibidoPor->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                @if($recepcion->observaciones)
                                    <span class="text-muted small fst-italic">{{ $recepcion->observaciones }}</span>
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-5">
                <div class="bg-light d-inline-flex p-4 rounded-circle mb-3">
                    <i class="fas fa-inbox text-muted fa-2x"></i>
                </div>
                <h5 class="text-dark fw-bold">No hay recepciones registradas</h5>
                <p class="text-muted mb-0 small">Aún no se han realizado recepciones en el sistema.</p>
            </div>
            @endif
        </div>
    </div>

    {{-- Tendencias --}}
    @if($recepciones->count() > 0)
    <div class="card dashboard-card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
            <h5 class="mb-0 fw-bold"><i class="fas fa-chart-line me-2 text-primary"></i> Tendencia</h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="d-flex align-items-center gap-3 p-3 bg-light rounded-3">
                        <i class="fas fa-calendar-day text-primary fa-lg"></i>
                        <div>
                            <div class="small text-muted">Últimos 7 días</div>
                            <div class="fw-bold">{{ $recepciones->where('fecha_recepcion', '>=', now()->subDays(7))->count() }} recepciones</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex align-items-center gap-3 p-3 bg-light rounded-3">
                        <i class="fas fa-calendar-alt text-success fa-lg"></i>
                        <div>
                            <div class="small text-muted">Últimos 30 días</div>
                            <div class="fw-bold">{{ $recepciones->where('fecha_recepcion', '>=', now()->subDays(30))->count() }} recepciones</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex align-items-center gap-3 p-3 bg-light rounded-3">
                        <i class="fas fa-chart-bar text-warning fa-lg"></i>
                        <div>
                            <div class="small text-muted">Promedio diario</div>
                            @php
                                $dias = max(1, now()->diffInDays($recepciones->last()->created_at ?? now()));
                                $promedio = round($recepciones->count() / $dias, 1);
                            @endphp
                            <div class="fw-bold">{{ $promedio }}/día</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

</div>
@endsection
