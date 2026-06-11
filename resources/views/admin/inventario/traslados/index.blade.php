@extends('admin.layouts.app')

@section('title', 'Traslados de Inventario')

@section('header', 'Traslados de Inventario')

@section('content')
<div class="dashboard-hero" style="padding: 2rem 2rem; border-radius: 0 0 1.5rem 1.5rem; margin-bottom: 2.5rem;">
    <div class="hero-glow-alt" style="top: -50px; right: 0; filter: blur(60px); opacity: 0.2;"></div>
    <div class="container-fluid position-relative z-1">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center">
            <div class="mb-3 mb-lg-0">
                <div class="d-inline-flex align-items-center px-3 py-1 bg-white bg-opacity-10 rounded-pill fs-6 mb-3 border border-white border-opacity-25">
                    <i class="fas fa-boxes text-info me-2"></i> Inventario
                </div>
                <h2 class="fw-bold mb-1 tracking-tight text-white display-6 text-shadow-sm">Traslados de Inventario</h2>
                <p class="text-white-50 mb-0">Gestión de traslados entre almacenes</p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('admin.inventario.traslados.create') }}" class="btn bg-white text-dark rounded-pill px-4 py-2 fw-bold shadow-sm border-0">
                    <i class="fas fa-plus me-2"></i> Nuevo Traslado
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid px-3 px-lg-4 position-relative" style="top: -3.5rem; z-index: 10;">

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4 d-flex align-items-center gap-2 alert-dismissible fade show">
            <i class="fas fa-check-circle text-success"></i> {{ session('success') }}
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4 d-flex align-items-center gap-2 alert-dismissible fade show">
            <i class="fas fa-exclamation-circle text-danger"></i> {{ session('error') }}
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card dashboard-card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
            <h6 class="fw-bold mb-0"><i class="fas fa-exchange-alt me-2 text-primary"></i> Listado de Traslados</h6>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="py-3 px-4 border-0 text-uppercase small">#</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Fecha</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Almacén Origen</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Almacén Destino</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Estado</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Usuario</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($traslados as $traslado)
                            <tr>
                                <td class="px-4">{{ $traslado->id }}</td>
                                <td class="px-4">{{ $traslado->fecha_traslado->format('d/m/Y H:i') }}</td>
                                <td class="px-4">{{ $traslado->almacenOrigen->nombre }}</td>
                                <td class="px-4">{{ $traslado->almacenDestino->nombre }}</td>
                                <td class="px-4">
                                    @if($traslado->estado == 'pendiente')
                                        <span class="badge bg-warning-subtle text-warning rounded-pill px-3">Pendiente</span>
                                    @elseif($traslado->estado == 'completado')
                                        <span class="badge bg-success-subtle text-success rounded-pill px-3">Completado</span>
                                    @elseif($traslado->estado == 'cancelado')
                                        <span class="badge bg-danger-subtle text-danger rounded-pill px-3">Cancelado</span>
                                    @endif
                                </td>
                                <td class="px-4">{{ $traslado->usuario->name }}</td>
                                <td class="px-4">
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('admin.inventario.traslados.show', $traslado) }}" class="btn btn-sm btn-outline-info rounded-pill px-3">
                                            <i class="fa fa-eye"></i>
                                        </a>

                                        @if($traslado->estado == 'pendiente')
                                            <form method="POST" action="{{ route('admin.inventario.traslados.cambiar-estado', $traslado) }}" class="d-inline">
                                                @csrf
                                                <input type="hidden" name="estado" value="completado">
                                                <button type="submit" class="btn btn-sm btn-outline-success rounded-pill px-3" onclick="return confirm('¿Confirmar traslado como completado?')">
                                                    <i class="fa fa-check"></i>
                                                </button>
                                            </form>

                                            <form method="POST" action="{{ route('admin.inventario.traslados.cambiar-estado', $traslado) }}" class="d-inline">
                                                @csrf
                                                <input type="hidden" name="estado" value="cancelado">
                                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="return confirm('¿Cancelar este traslado? Esta acción revertirá los movimientos de inventario.')">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="bg-light d-inline-flex p-4 rounded-circle mb-3"><i class="fas fa-exchange-alt text-muted fa-2x"></i></div>
                                    <h5 class="text-dark fw-bold">No hay traslados registrados</h5>
                                    <p class="text-muted mb-3">Registra el primer traslado entre almacenes</p>
                                    <a href="{{ route('admin.inventario.traslados.create') }}" class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow-sm border-0"><i class="fas fa-plus me-2"></i> Nuevo Traslado</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $traslados->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
