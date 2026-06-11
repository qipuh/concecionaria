@extends('admin.layouts.app')
@section('title', 'Vale de Devolución ' . $devolucion->numero)

@section('content')
@php
    $badgeMap = [
        'pendiente' => ['warning', 'clock'],
        'aprobado'  => ['success', 'check-circle'],
        'rechazado' => ['danger', 'times-circle'],
        'procesado' => ['info', 'box'],
    ];
    [$color, $icon] = $badgeMap[$devolucion->estado] ?? ['secondary', 'circle'];
@endphp

<div class="dashboard-hero" style="padding: 2rem 2rem; border-radius: 0 0 1.5rem 1.5rem; margin-bottom: 2.5rem;">
    <div class="hero-glow-alt" style="top: -50px; right: 0; filter: blur(60px); opacity: 0.2;"></div>
    <div class="container-fluid position-relative z-1">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center">
            <div class="mb-3 mb-lg-0">
                <div class="d-inline-flex align-items-center px-3 py-1 bg-white bg-opacity-10 rounded-pill fs-6 mb-3 border border-white border-opacity-25">
                    <i class="fas fa-undo text-info me-2"></i> Vale de Devolución
                </div>
                <h2 class="fw-bold mb-1 tracking-tight text-white display-6 text-shadow-sm">
                    {{ $devolucion->numero }}
                </h2>
                <span class="badge bg-{{ $color }} rounded-pill px-3 py-2 fw-bold mt-1">
                    <i class="fas fa-{{ $icon }} me-1 small"></i>
                    {{ strtoupper($devolucion->estado) }}
                </span>
            </div>
            <div class="d-flex flex-wrap gap-2">
                {{-- Aprobar: solo cuando pendiente --}}
                @if($devolucion->estado === 'pendiente')
                <form action="{{ route('admin.devoluciones.aprobar', $devolucion->id) }}" method="POST" class="d-inline">
                    @csrf @method('PATCH')
                    <button type="submit"
                            class="btn bg-success text-white rounded-pill px-4 py-2 fw-bold shadow-sm border-0"
                            onclick="return confirm('¿Aprobar este vale?')">
                        <i class="fas fa-check me-2"></i> Aprobar
                    </button>
                </form>
                <a href="{{ route('admin.devoluciones.edit', $devolucion->id) }}"
                   class="btn bg-white bg-opacity-10 text-white rounded-pill px-4 py-2 fw-bold shadow-sm border border-white border-opacity-25">
                    <i class="fas fa-pencil-alt me-2"></i> Editar
                </a>
                @endif

                {{-- Procesar: solo cuando aprobado --}}
                @if($devolucion->estado === 'aprobado')
                <form action="{{ route('admin.devoluciones.procesar', $devolucion->id) }}" method="POST" class="d-inline">
                    @csrf @method('PATCH')
                    <button type="submit"
                            class="btn bg-info text-white rounded-pill px-4 py-2 fw-bold shadow-sm border-0"
                            onclick="return confirm('¿Marcar como procesado?')">
                        <i class="fas fa-box me-2"></i> Procesar
                    </button>
                </form>
                @endif

                {{-- Rechazar: pendiente o aprobado --}}
                @if(in_array($devolucion->estado, ['pendiente', 'aprobado']))
                <form action="{{ route('admin.devoluciones.rechazar', $devolucion->id) }}" method="POST" class="d-inline">
                    @csrf @method('PATCH')
                    <button type="submit"
                            class="btn bg-white bg-opacity-10 text-white rounded-pill px-4 py-2 fw-bold shadow-sm border border-white border-opacity-25"
                            onclick="return confirm('¿Rechazar este vale? Esta acción no se puede deshacer.')">
                        <i class="fas fa-times me-2"></i> Rechazar
                    </button>
                </form>
                @endif

                {{-- Eliminar: solo pendiente --}}
                @if($devolucion->estado === 'pendiente')
                <form action="{{ route('admin.devoluciones.destroy', $devolucion->id) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="btn bg-danger text-white rounded-pill px-4 py-2 fw-bold shadow-sm border-0"
                            onclick="return confirm('¿Eliminar este vale de forma permanente?')">
                        <i class="fas fa-trash me-2"></i> Eliminar
                    </button>
                </form>
                @endif

                <a href="{{ route('admin.devoluciones.index') }}"
                   class="btn bg-white text-dark rounded-pill px-4 py-2 fw-bold shadow-sm border-0">
                    <i class="fas fa-arrow-left text-primary me-2"></i> Volver
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid px-3 px-lg-4 position-relative" style="top: -3.5rem; z-index: 10;">

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4 d-flex align-items-center gap-2">
            <i class="fas fa-check-circle text-success"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4 d-flex align-items-center gap-2">
            <i class="fas fa-exclamation-circle text-danger"></i> {{ session('error') }}
        </div>
    @endif

    {{-- Tarjetas resumen --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="card dashboard-card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3 p-3">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-circle flex-shrink-0">
                        <i class="fas fa-boxes text-primary"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-0 small">Productos</p>
                        <h4 class="mb-0 fw-bold text-primary">{{ $devolucion->detalles->count() }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card dashboard-card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3 p-3">
                    <div class="bg-success bg-opacity-10 p-3 rounded-circle flex-shrink-0">
                        <i class="fas fa-dollar-sign text-success"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-0 small">Total</p>
                        <h4 class="mb-0 fw-bold text-success">S/. {{ number_format($devolucion->total ?? 0, 2) }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card dashboard-card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3 p-3">
                    <div class="bg-{{ $color }} bg-opacity-10 p-3 rounded-circle flex-shrink-0">
                        <i class="fas fa-{{ $icon }} text-{{ $color }}"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-0 small">Estado</p>
                        <h6 class="mb-0 fw-bold text-{{ $color }}">{{ ucfirst($devolucion->estado) }}</h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card dashboard-card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3 p-3">
                    <div class="bg-secondary bg-opacity-10 p-3 rounded-circle flex-shrink-0">
                        <i class="fas fa-calendar text-secondary"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-0 small">Fecha</p>
                        <h6 class="mb-0 fw-bold">{{ $devolucion->fecha->format('d/m/Y') }}</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Información general --}}
    <div class="row g-3 mb-4">
        <div class="col-lg-6">
            <div class="card dashboard-card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                    <h6 class="fw-bold mb-0"><i class="fas fa-info-circle me-2 text-primary"></i> Información General</h6>
                </div>
                <div class="card-body px-4">
                    <dl class="row mb-0">
                        <dt class="col-5 text-muted fw-normal small text-uppercase">Número</dt>
                        <dd class="col-7 fw-bold font-monospace">{{ $devolucion->numero }}</dd>

                        <dt class="col-5 text-muted fw-normal small text-uppercase">Proveedor</dt>
                        <dd class="col-7 fw-semibold">{{ $devolucion->proveedor->razon_social ?? '—' }}</dd>

                        <dt class="col-5 text-muted fw-normal small text-uppercase">Motivo</dt>
                        <dd class="col-7">{{ $devolucion->motivo }}</dd>

                        <dt class="col-5 text-muted fw-normal small text-uppercase">Estado</dt>
                        <dd class="col-7">
                            <span class="badge bg-{{ $color }}-subtle text-{{ $color }} rounded-pill px-3 py-1 fw-bold small">
                                {{ ucfirst($devolucion->estado) }}
                            </span>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card dashboard-card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                    <h6 class="fw-bold mb-0"><i class="fas fa-user me-2 text-primary"></i> Trazabilidad</h6>
                </div>
                <div class="card-body px-4">
                    <dl class="row mb-0">
                        <dt class="col-5 text-muted fw-normal small text-uppercase">Creado por</dt>
                        <dd class="col-7 fw-semibold">{{ $devolucion->usuario->name ?? '—' }}</dd>

                        <dt class="col-5 text-muted fw-normal small text-uppercase">Fecha creación</dt>
                        <dd class="col-7">{{ $devolucion->created_at->format('d/m/Y H:i') }}</dd>

                        @if($devolucion->aprobadoPor)
                        <dt class="col-5 text-muted fw-normal small text-uppercase">Aprobado por</dt>
                        <dd class="col-7 fw-semibold">{{ $devolucion->aprobadoPor->name }}</dd>

                        <dt class="col-5 text-muted fw-normal small text-uppercase">Fecha aprobación</dt>
                        <dd class="col-7">{{ $devolucion->fecha_aprobacion?->format('d/m/Y H:i') ?? '—' }}</dd>
                        @endif

                        @if($devolucion->observaciones)
                        <dt class="col-5 text-muted fw-normal small text-uppercase">Observaciones</dt>
                        <dd class="col-7 fst-italic text-muted small">{{ $devolucion->observaciones }}</dd>
                        @endif
                    </dl>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabla de productos --}}
    <div class="card dashboard-card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 pt-4 pb-2 px-4 d-flex align-items-center justify-content-between">
            <h6 class="fw-bold mb-0"><i class="fas fa-boxes me-2 text-primary"></i> Productos a Devolver</h6>
            <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-1 small">
                {{ $devolucion->detalles->count() }} ítems
            </span>
        </div>
        <div class="card-body p-0">
            @if($devolucion->detalles->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="py-3 px-4 border-0 text-uppercase small">#</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Producto</th>
                            <th class="py-3 px-4 border-0 text-uppercase small text-center">Tipo</th>
                            <th class="py-3 px-4 border-0 text-uppercase small text-center">Cantidad</th>
                            <th class="py-3 px-4 border-0 text-uppercase small text-end">Precio Unit.</th>
                            <th class="py-3 px-4 border-0 text-uppercase small text-end">Subtotal</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Motivo detalle</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($devolucion->detalles as $index => $detalle)
                        <tr>
                            <td class="px-4 py-3 text-muted small">{{ $index + 1 }}</td>
                            <td class="px-4 py-3">
                                <div class="fw-semibold small">{{ $detalle->nombre_producto }}</div>
                                <small class="text-muted font-monospace"><i class="fas fa-barcode me-1"></i>{{ $detalle->codigo_producto }}</small>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="badge bg-primary-subtle text-primary rounded-pill px-3 small">
                                    {{ ucfirst($detalle->tipo_producto) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3 py-2 fw-bold">
                                    {{ number_format($detalle->cantidad, 2) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-end fw-semibold">
                                S/. {{ number_format($detalle->precio_unitario, 2) }}
                            </td>
                            <td class="px-4 py-3 text-end fw-bold text-primary">
                                S/. {{ number_format($detalle->subtotal ?? ($detalle->cantidad * $detalle->precio_unitario), 2) }}
                            </td>
                            <td class="px-4 py-3 text-muted small fst-italic">
                                {{ $detalle->motivo_detalle ?: '—' }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <td colspan="5" class="px-4 py-3 text-end fw-bold text-uppercase small">Total</td>
                            <td class="px-4 py-3 text-end fw-bold text-primary fs-6">
                                S/. {{ number_format($devolucion->total ?? 0, 2) }}
                            </td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            @else
            <div class="text-center py-5">
                <div class="bg-light d-inline-flex p-4 rounded-circle mb-3">
                    <i class="fas fa-box-open text-muted fa-2x"></i>
                </div>
                <h6 class="text-dark fw-bold">Sin productos registrados</h6>
                <p class="text-muted mb-0 small">No se encontraron ítems en este vale.</p>
            </div>
            @endif
        </div>
    </div>

    <div class="d-flex justify-content-start pb-4">
        <a href="{{ route('admin.devoluciones.index') }}"
           class="btn btn-outline-secondary rounded-pill px-4 py-2 fw-bold border-0">
            <i class="fas fa-arrow-left me-2"></i> Volver al Listado
        </a>
    </div>

</div>
@endsection
