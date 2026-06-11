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
                <h2 class="fw-bold mb-1 tracking-tight text-white display-6 text-shadow-sm">Devoluciones a Proveedores</h2>
                <p class="text-white-50 mb-0">Gestión de devoluciones de productos</p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('admin.inventario.devoluciones.create') }}" class="btn bg-white text-dark rounded-pill px-4 py-2 fw-bold shadow-sm border-0">
                    <i class="fas fa-plus me-2"></i> Nueva Devolución
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

    <div class="card dashboard-card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
            <h6 class="fw-bold mb-0"><i class="fas fa-list me-2 text-primary"></i> Listado de Devoluciones</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="py-3 px-4 border-0 text-uppercase small">Código</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Proveedor</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Fecha Emisión</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Motivo</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Almacén</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Estado</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($devoluciones as $devolucion)
                            <tr>
                                <td class="px-4 fw-semibold">{{ $devolucion->codigo }}</td>
                                <td class="px-4">{{ $devolucion->proveedor->nombre_completo }}</td>
                                <td class="px-4 text-muted small">{{ $devolucion->fecha_emision ? $devolucion->fecha_emision->format('d/m/Y') : '-' }}</td>
                                <td class="px-4">{{ $devolucion->motivo }}</td>
                                <td class="px-4">{{ $devolucion->almacen->nombre }}</td>
                                <td class="px-4">
                                    @if($devolucion->estado == 'PENDIENTE')
                                        <span class="badge bg-warning-subtle text-warning rounded-pill px-3">Pendiente</span>
                                    @elseif($devolucion->estado == 'PROCESADA')
                                        <span class="badge bg-success-subtle text-success rounded-pill px-3">Procesada</span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3">{{ $devolucion->estado }}</span>
                                    @endif
                                </td>
                                <td class="px-4">
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('admin.inventario.devoluciones.show', $devolucion->id) }}"
                                           class="btn btn-sm btn-outline-info rounded-pill px-3"
                                           title="Ver Detalles">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        @if($devolucion->estado == 'PENDIENTE')
                                            <a href="{{ route('admin.inventario.devoluciones.edit', $devolucion->id) }}"
                                               class="btn btn-sm btn-outline-warning rounded-pill px-3"
                                               title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <form action="{{ route('admin.inventario.devoluciones.confirmar', $devolucion->id) }}"
                                                  method="POST"
                                                  class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit"
                                                        class="btn btn-sm btn-outline-success rounded-pill px-3"
                                                        title="Confirmar Devolución"
                                                        onclick="return confirm('¿Estás seguro de confirmar esta devolución? Esta acción no se puede deshacer.')">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>

                                            <form action="{{ route('admin.inventario.devoluciones.destroy', $devolucion->id) }}"
                                                  method="POST"
                                                  class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="btn btn-sm btn-outline-danger rounded-pill px-3"
                                                        title="Eliminar"
                                                        onclick="return confirm('¿Estás seguro de eliminar esta devolución?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="bg-light d-inline-flex p-4 rounded-circle mb-3"><i class="fas fa-undo-alt text-muted fa-2x"></i></div>
                                    <h5 class="text-dark fw-bold">No hay devoluciones registradas</h5>
                                    <p class="text-muted mb-3">Registra la primera devolución a proveedor</p>
                                    <a href="{{ route('admin.inventario.devoluciones.create') }}" class="btn btn-primary rounded-pill px-4 py-2 fw-bold border-0">
                                        <i class="fas fa-plus me-2"></i> Nueva Devolución
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($devoluciones->hasPages())
        <div class="card-footer bg-white border-0 px-4 py-3">
            {{ $devoluciones->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
