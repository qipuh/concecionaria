<!-- resources/views/admin/mantenimiento/ordenes/index.blade.php -->
@extends('admin.layouts.app')

@section('title', 'Listado de Órdenes de Trabajo')

@section('content')
<div class="dashboard-hero" style="padding: 2rem 2rem; border-radius: 0 0 1.5rem 1.5rem; margin-bottom: 2.5rem;">
    <div class="hero-glow-alt" style="top: -50px; right: 0; filter: blur(60px); opacity: 0.2;"></div>
    <div class="container-fluid position-relative z-1">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center">
            <div class="mb-3 mb-lg-0">
                <div class="d-inline-flex align-items-center px-3 py-1 bg-white bg-opacity-10 rounded-pill fs-6 mb-3 border border-white border-opacity-25">
                    <i class="fas fa-tools text-warning me-2"></i> Mantenimiento
                </div>
                <h2 class="fw-bold mb-1 tracking-tight text-white display-6 text-shadow-sm">Órdenes de Trabajo</h2>
                <p class="text-white-50 mb-0">Control y seguimiento de órdenes de mantenimiento</p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('admin.mantenimiento.citas.create') }}" class="btn bg-white text-dark rounded-pill px-4 py-2 fw-bold shadow-sm border-0">
                    <i class="fas fa-plus me-2"></i> Nueva Cita
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid px-3 px-lg-4 position-relative" style="top: -3.5rem; z-index: 10;">

    <!-- Filtros -->
    <div class="card dashboard-card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
            <h6 class="fw-bold mb-0"><i class="fas fa-filter me-2 text-primary"></i> Filtros de Búsqueda</h6>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('admin.mantenimiento.ordenes.index') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-12">
                        <input type="text" name="search" class="form-control" placeholder="Buscar por código o cliente..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold small text-uppercase text-muted">Estado</label>
                        <select name="estado" id="estado" class="form-select">
                            <option value="">Todos</option>
                            <option value="diagnostico" {{ request('estado') === 'diagnostico' ? 'selected' : '' }}>Diagnóstico</option>
                            <option value="espera_aprobacion" {{ request('estado') === 'espera_aprobacion' ? 'selected' : '' }}>Esperando Aprobación</option>
                            <option value="en_progreso" {{ request('estado') === 'en_progreso' ? 'selected' : '' }}>En Progreso</option>
                            <option value="finalizado" {{ request('estado') === 'finalizado' ? 'selected' : '' }}>Finalizado</option>
                            <option value="facturado" {{ request('estado') === 'facturado' ? 'selected' : '' }}>Facturado</option>
                            <option value="entregado" {{ request('estado') === 'entregado' ? 'selected' : '' }}>Entregado</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold small text-uppercase text-muted">Técnico</label>
                        <select name="tecnico_id" id="tecnico_id" class="form-select">
                            <option value="">Todos</option>
                            @foreach(\App\Models\User::whereHas('roles', function($q) { $q->where('name', 'tecnico'); })->get() as $tecnico)
                                <option value="{{ $tecnico->id }}" {{ request('tecnico_id') == $tecnico->id ? 'selected' : '' }}>{{ $tecnico->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold small text-uppercase text-muted">Fecha Desde</label>
                        <input type="date" name="fecha_desde" id="fecha_desde" class="form-control" value="{{ request('fecha_desde') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold small text-uppercase text-muted">Fecha Hasta</label>
                        <input type="date" name="fecha_hasta" id="fecha_hasta" class="form-control" value="{{ request('fecha_hasta') }}">
                    </div>
                </div>
                <div class="d-flex justify-content-end gap-2 mt-3">
                    <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 fw-bold border-0">
                        <i class="fas fa-filter me-2"></i> Filtrar
                    </button>
                    <a href="{{ route('admin.mantenimiento.ordenes.index') }}" class="btn btn-outline-secondary rounded-pill px-4 py-2 fw-bold border-0">
                        <i class="fas fa-eraser me-2"></i> Limpiar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla -->
    <div class="card dashboard-card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
            <h6 class="fw-bold mb-0"><i class="fas fa-list me-2 text-primary"></i> Listado de Órdenes</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="py-3 px-4 border-0 text-uppercase small">Código</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Cliente</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Vehículo</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Fecha Ingreso</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Estado</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Técnico</th>
                            <th class="py-3 px-4 border-0 text-uppercase small text-end">Total</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ordenes as $orden)
                            <tr>
                                <td class="px-4 fw-semibold text-primary">{{ $orden->codigo_orden }}</td>
                                <td class="px-4">
                                    @if($orden->cliente->tipo_cliente == 'natural')
                                        {{ $orden->cliente->nombres }} {{ $orden->cliente->apellido_paterno }}
                                    @else
                                        {{ $orden->cliente->razon_social }}
                                    @endif
                                </td>
                                <td class="px-4">
                                    {{ $orden->vehiculo->marca->nombre ?? 'N/A' }}
                                    {{ $orden->vehiculo->modelo->nombre ?? 'N/A' }}
                                    ({{ $orden->vehiculo->nro_placa }})
                                </td>
                                <td class="px-4 small text-muted">{{ \Carbon\Carbon::parse($orden->fecha_ingreso)->format('d/m/Y') }}</td>
                                <td class="px-4">
                                    @switch($orden->estado)
                                        @case('diagnostico')
                                            <span class="badge bg-info-subtle text-info rounded-pill px-3">Diagnóstico</span>
                                            @break
                                        @case('espera_aprobacion')
                                            <span class="badge bg-warning-subtle text-warning rounded-pill px-3">Esperando Aprobación</span>
                                            @break
                                        @case('en_progreso')
                                            <span class="badge bg-primary-subtle text-primary rounded-pill px-3">En Progreso</span>
                                            @break
                                        @case('finalizado')
                                            <span class="badge bg-success-subtle text-success rounded-pill px-3">Finalizado</span>
                                            @break
                                        @case('facturado')
                                            <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3">Facturado</span>
                                            @break
                                        @case('entregado')
                                            <span class="badge bg-dark text-white rounded-pill px-3">Entregado</span>
                                            @break
                                        @default
                                            <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3">{{ $orden->estado }}</span>
                                    @endswitch
                                </td>
                                <td class="px-4 small text-muted">{{ $orden->tecnico->name ?? 'Sin asignar' }}</td>
                                <td class="px-4 text-end fw-semibold text-success">S/ {{ number_format($orden->getTotalOrdenAttribute(), 2) }}</td>
                                <td class="px-4">
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('admin.mantenimiento.ordenes.show', ['orden' => $orden->id]) }}" class="btn btn-sm btn-outline-info rounded-pill px-3">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.mantenimiento.ordenes.imprimir', ['orden' => $orden->id]) }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3" target="_blank">
                                            <i class="fas fa-print"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <div class="bg-light d-inline-flex p-4 rounded-circle mb-3"><i class="fas fa-clipboard-list text-muted fa-2x"></i></div>
                                    <h5 class="text-dark fw-bold">No hay órdenes de trabajo registradas</h5>
                                    <p class="text-muted mb-0">Las órdenes se crean al confirmar una cita</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-0 px-4 py-3">
            {{ $ordenes->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection
