@extends('admin.layouts.app')

@section('content')
<div class="dashboard-hero" style="padding: 2rem 2rem; border-radius: 0 0 1.5rem 1.5rem; margin-bottom: 2.5rem;">
    <div class="hero-glow-alt" style="top: -50px; right: 0; filter: blur(60px); opacity: 0.2;"></div>
    <div class="container-fluid position-relative z-1">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center">
            <div class="mb-3 mb-lg-0">
                <div class="d-inline-flex align-items-center px-3 py-1 bg-white bg-opacity-10 rounded-pill fs-6 mb-3 border border-white border-opacity-25">
                    <i class="fas fa-boxes text-info me-2"></i> Inventario
                </div>
                <h2 class="fw-bold mb-1 tracking-tight text-white display-6 text-shadow-sm">Movimientos de Almacén</h2>
                <p class="text-white-50 mb-0">Registro de entradas y salidas de inventario</p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('admin.inventario.movimientos.create') }}" class="btn bg-white text-dark rounded-pill px-4 py-2 fw-bold shadow-sm border-0">
                    <i class="fas fa-plus me-2"></i> Nuevo Movimiento
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid px-3 px-lg-4 position-relative" style="top: -3.5rem; z-index: 10;">
    <div class="card dashboard-card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
            <h6 class="fw-bold mb-0"><i class="fas fa-list me-2 text-primary"></i> Listado de Movimientos</h6>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="py-3 px-4 border-0 text-uppercase small">ID</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Tipo</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Parte</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Almacén</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Cantidad</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Documento</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Fecha</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Usuario</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($movimientos as $movimiento)
                        <tr>
                            <td class="px-4">{{ $movimiento->id }}</td>
                            <td class="px-4">
                                <span class="badge bg-primary-subtle text-primary rounded-pill px-3">{{ $movimiento->tipoMovimiento->nombre }}</span>
                            </td>
                            <td class="px-4">{{ $movimiento->parte->nombre }}</td>
                            <td class="px-4">{{ $movimiento->almacen->nombre }}</td>
                            <td class="px-4 fw-semibold">{{ $movimiento->cantidad }}</td>
                            <td class="px-4">{{ $movimiento->documento_referencia ?? 'N/A' }}</td>
                            <td class="px-4">{{ \Carbon\Carbon::parse($movimiento->fecha_movimiento)->format('d/m/Y H:i') }}</td>
                            <td class="px-4">{{ $movimiento->usuario->name }}</td>
                            <td class="px-4">
                                <div class="d-flex gap-1">
                                    <a href="{{ route('admin.inventario.movimientos.edit', $movimiento) }}" class="btn btn-sm btn-outline-warning rounded-pill px-3">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.inventario.movimientos.destroy', $movimiento) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="return confirm('¿Eliminar este movimiento?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $movimientos->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
