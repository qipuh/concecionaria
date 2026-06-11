@extends('admin.layouts.app')

@section('title', 'Devoluciones a Proveedores')

@section('content')
<div class="dashboard-hero" style="padding: 2rem 2rem; border-radius: 0 0 1.5rem 1.5rem; margin-bottom: 2.5rem;">
    <div class="hero-glow-alt" style="top: -50px; right: 0; filter: blur(60px); opacity: 0.2;"></div>
    <div class="container-fluid position-relative z-1">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center">
            <div class="mb-3 mb-lg-0">
                <div class="d-inline-flex align-items-center px-3 py-1 bg-white bg-opacity-10 rounded-pill fs-6 mb-3 border border-white border-opacity-25">
                    <i class="fas fa-boxes text-info me-2"></i> Inventario
                </div>
                <h2 class="fw-bold mb-1 tracking-tight text-white display-6 text-shadow-sm">Devolución {{ $devolucion->codigo }}</h2>
                <p class="text-white-50 mb-0">Detalle completo de la devolución a proveedor</p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                @if($devolucion->estado == 'PENDIENTE')
                    <a href="{{ route('admin.inventario.devoluciones.edit', $devolucion->id) }}" class="btn bg-white text-dark rounded-pill px-4 py-2 fw-bold shadow-sm border-0">
                        <i class="fas fa-edit me-2"></i> Editar
                    </a>
                @endif
                <a href="{{ route('admin.inventario.devoluciones.index') }}" class="btn btn-outline-secondary rounded-pill px-4 py-2 fw-bold border-0" style="color:white; border-color: rgba(255,255,255,0.5);">
                    <i class="fas fa-arrow-left me-2"></i> Volver
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid px-3 px-lg-4 position-relative" style="top: -3.5rem; z-index: 10;">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row mb-4">
        <!-- Información General -->
        <div class="col-md-6 mb-4 mb-md-0">
            <div class="card dashboard-card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                    <h6 class="fw-bold mb-0"><i class="fas fa-info-circle me-2 text-primary"></i> Información General</h6>
                </div>
                <div class="card-body p-4">
                    <ul class="list-unstyled mb-0">
                        <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
                            <span class="text-muted small fw-semibold">Código</span>
                            <span class="fw-semibold">{{ $devolucion->codigo }}</span>
                        </li>
                        <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
                            <span class="text-muted small fw-semibold">Proveedor</span>
                            <span class="fw-semibold">{{ $devolucion->proveedor->nombre_completo }}</span>
                        </li>
                        <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
                            <span class="text-muted small fw-semibold">Motivo</span>
                            <span class="fw-semibold">{{ $devolucion->motivo }}</span>
                        </li>
                        <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
                            <span class="text-muted small fw-semibold">Fecha de Emisión</span>
                            <span class="fw-semibold">{{ $devolucion->fecha_emision ? $devolucion->fecha_emision->format('d/m/Y') : '-' }}</span>
                        </li>
                        <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
                            <span class="text-muted small fw-semibold">Almacén</span>
                            <span class="fw-semibold">{{ $devolucion->almacen->nombre }}</span>
                        </li>
                        <li class="d-flex justify-content-between align-items-center py-2">
                            <span class="text-muted small fw-semibold">Estado</span>
                            @if($devolucion->estado == 'PENDIENTE')
                                <span class="badge bg-warning-subtle text-warning rounded-pill px-3">Pendiente</span>
                            @elseif($devolucion->estado == 'PROCESADA')
                                <span class="badge bg-success-subtle text-success rounded-pill px-3">Procesada</span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3">{{ $devolucion->estado }}</span>
                            @endif
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Información Adicional -->
        <div class="col-md-6">
            <div class="card dashboard-card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                    <h6 class="fw-bold mb-0"><i class="fas fa-clipboard me-2 text-primary"></i> Información Adicional</h6>
                </div>
                <div class="card-body p-4">
                    <ul class="list-unstyled mb-0">
                        <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
                            <span class="text-muted small fw-semibold">Creado por</span>
                            <span class="fw-semibold">{{ $devolucion->usuario->name }}</span>
                        </li>
                        <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
                            <span class="text-muted small fw-semibold">Fecha de Creación</span>
                            <span class="fw-semibold">{{ $devolucion->created_at->format('d/m/Y H:i:s') }}</span>
                        </li>
                        <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
                            <span class="text-muted small fw-semibold">Última Actualización</span>
                            <span class="fw-semibold">{{ $devolucion->updated_at->format('d/m/Y H:i:s') }}</span>
                        </li>
                        <li class="d-flex justify-content-between align-items-start py-2">
                            <span class="text-muted small fw-semibold">Observaciones</span>
                            <span class="fw-semibold text-end" style="max-width: 60%;">{{ $devolucion->observaciones ?? 'Sin observaciones' }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Productos Devueltos -->
    <div class="card dashboard-card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
            <h6 class="fw-bold mb-0"><i class="fas fa-boxes me-2 text-primary"></i> Productos Devueltos</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="py-3 px-4 border-0 text-uppercase small">#</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Producto</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Código</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Tipo</th>
                            <th class="py-3 px-4 border-0 text-uppercase small text-end">Cantidad</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Motivo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($devolucion->detalles as $index => $detalle)
                        <tr>
                            <td class="px-4 text-muted">{{ $index + 1 }}</td>
                            <td class="px-4 fw-semibold">{{ $detalle->nombre }}</td>
                            <td class="px-4">
                                <code class="bg-light px-2 py-1 rounded small">{{ $detalle->codigo }}</code>
                            </td>
                            <td class="px-4">
                                @if($detalle->tipo_item == 'parte')
                                    <span class="badge bg-info-subtle text-info rounded-pill px-3">Parte</span>
                                @elseif($detalle->tipo_item == 'vehiculo')
                                    <span class="badge bg-primary-subtle text-primary rounded-pill px-3">Vehículo</span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3">{{ $detalle->tipo_item }}</span>
                                @endif
                            </td>
                            <td class="px-4 text-end fw-bold">{{ number_format($detalle->cantidad, 2) }}</td>
                            <td class="px-4">{{ $detalle->motivo_detalle ?? 'Sin especificar' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="bg-light d-inline-flex p-4 rounded-circle mb-3"><i class="fas fa-box-open text-muted fa-2x"></i></div>
                                <h5 class="text-dark fw-bold">No hay productos en esta devolución</h5>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if($devolucion->estado == 'PENDIENTE')
    <div class="d-flex justify-content-end gap-2 mb-4">
        <form action="{{ route('admin.inventario.devoluciones.confirmar', $devolucion->id) }}" method="POST" class="d-inline">
            @csrf
            @method('PUT')
            <button type="submit" class="btn btn-success rounded-pill px-4 py-2 fw-bold shadow-sm border-0"
                    onclick="return confirm('¿Estás seguro de confirmar esta devolución? Esta acción no se puede deshacer.')">
                <i class="fas fa-check me-2"></i> Confirmar Devolución
            </button>
        </form>
        <form action="{{ route('admin.inventario.devoluciones.destroy', $devolucion->id) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger rounded-pill px-4 py-2 fw-bold shadow-sm border-0"
                    onclick="return confirm('¿Estás seguro de eliminar esta devolución?')">
                <i class="fas fa-trash me-2"></i> Eliminar
            </button>
        </form>
    </div>
    @endif
</div>
@endsection
