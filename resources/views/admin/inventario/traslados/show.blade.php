@extends('admin.layouts.app')

@section('title', 'Detalle del Traslado')

@section('header', 'Detalle del Traslado')

@section('content')
<div class="dashboard-hero" style="padding: 2rem 2rem; border-radius: 0 0 1.5rem 1.5rem; margin-bottom: 2.5rem;">
    <div class="hero-glow-alt" style="top: -50px; right: 0; filter: blur(60px); opacity: 0.2;"></div>
    <div class="container-fluid position-relative z-1">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center">
            <div class="mb-3 mb-lg-0">
                <div class="d-inline-flex align-items-center px-3 py-1 bg-white bg-opacity-10 rounded-pill fs-6 mb-3 border border-white border-opacity-25">
                    <i class="fas fa-boxes text-info me-2"></i> Inventario
                </div>
                <h2 class="fw-bold mb-1 tracking-tight text-white display-6 text-shadow-sm">Traslado #{{ $traslado->id }}</h2>
                <p class="text-white-50 mb-0">Detalle completo del traslado</p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('admin.inventario.traslados.index') }}" class="btn bg-white text-dark rounded-pill px-4 py-2 fw-bold shadow-sm border-0">
                    <i class="fa fa-arrow-left me-2"></i> Volver
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid px-3 px-lg-4 position-relative" style="top: -3.5rem; z-index: 10;">

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card dashboard-card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                    <h6 class="fw-bold mb-0"><i class="fas fa-info-circle me-2 text-primary"></i> Información del Traslado</h6>
                </div>
                <div class="card-body p-4">
                    <dl class="row mb-0">
                        <dt class="col-sm-4 text-muted small text-uppercase">ID:</dt>
                        <dd class="col-sm-8 fw-semibold">{{ $traslado->id }}</dd>

                        <dt class="col-sm-4 text-muted small text-uppercase">Fecha:</dt>
                        <dd class="col-sm-8">{{ $traslado->fecha_traslado->format('d/m/Y H:i') }}</dd>

                        <dt class="col-sm-4 text-muted small text-uppercase">Estado:</dt>
                        <dd class="col-sm-8">
                            @if($traslado->estado == 'pendiente')
                                <span class="badge bg-warning-subtle text-warning rounded-pill px-3">Pendiente</span>
                            @elseif($traslado->estado == 'completado')
                                <span class="badge bg-success-subtle text-success rounded-pill px-3">Completado</span>
                            @elseif($traslado->estado == 'cancelado')
                                <span class="badge bg-danger-subtle text-danger rounded-pill px-3">Cancelado</span>
                            @endif
                        </dd>

                        <dt class="col-sm-4 text-muted small text-uppercase">Usuario:</dt>
                        <dd class="col-sm-8">{{ $traslado->usuario->name }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card dashboard-card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                    <h6 class="fw-bold mb-0"><i class="fas fa-warehouse me-2 text-primary"></i> Almacenes</h6>
                </div>
                <div class="card-body p-4">
                    <dl class="row mb-0">
                        <dt class="col-sm-4 text-muted small text-uppercase">Origen:</dt>
                        <dd class="col-sm-8 fw-semibold">{{ $traslado->almacenOrigen->nombre }}</dd>

                        <dt class="col-sm-4 text-muted small text-uppercase">Destino:</dt>
                        <dd class="col-sm-8 fw-semibold">{{ $traslado->almacenDestino->nombre }}</dd>

                        <dt class="col-sm-4 text-muted small text-uppercase">Motivo:</dt>
                        <dd class="col-sm-8">{{ $traslado->motivo }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <div class="card dashboard-card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
            <h6 class="fw-bold mb-0"><i class="fas fa-list me-2 text-primary"></i> Productos Trasladados</h6>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="py-3 px-4 border-0 text-uppercase small">Tipo</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Código</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Descripción</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Cantidad</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Unidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($traslado->items as $item)
                            <tr>
                                <td class="px-4">
                                    <span class="badge bg-info-subtle text-info rounded-pill px-3">
                                        {{ $item->tipo_item == 'parte' ? 'Parte/Repuesto' : 'Vehículo' }}
                                    </span>
                                </td>
                                <td class="px-4">{{ $item->getCodigoItemAttribute() }}</td>
                                <td class="px-4">{{ $item->getNombreItemAttribute() }}</td>
                                <td class="px-4">{{ number_format($item->cantidad, 2) }}</td>
                                <td class="px-4">
                                    @if($item->tipo_item == 'parte')
                                        {{ $item->parte->unidad->nombre ?? 'N/A' }}
                                    @else
                                        Unidad
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if($traslado->estado == 'pendiente')
    <div class="d-flex justify-content-end gap-2 mb-4">
        <form method="POST" action="{{ route('admin.inventario.traslados.cambiar-estado', $traslado) }}">
            @csrf
            <input type="hidden" name="estado" value="completado">
            <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow-sm border-0" onclick="return confirm('¿Confirmar traslado como completado?')">
                <i class="fa fa-check me-2"></i> Completar Traslado
            </button>
        </form>

        <form method="POST" action="{{ route('admin.inventario.traslados.cambiar-estado', $traslado) }}">
            @csrf
            <input type="hidden" name="estado" value="cancelado">
            <button type="submit" class="btn btn-outline-secondary rounded-pill px-4 py-2 fw-bold border-0" onclick="return confirm('¿Cancelar este traslado? Esta acción revertirá los movimientos de inventario.')">
                <i class="fa fa-times me-2"></i> Cancelar Traslado
            </button>
        </form>
    </div>
    @endif
</div>
@endsection
