@extends('admin.layouts.app')
@section('title', 'Kardex de Inventario')
@section('header', 'Kardex de Inventario')

@section('content')
<div class="dashboard-hero" style="padding: 2rem 2rem; border-radius: 0 0 1.5rem 1.5rem; margin-bottom: 2.5rem;">
    <div class="hero-glow-alt" style="top: -50px; right: 0; filter: blur(60px); opacity: 0.2;"></div>
    <div class="container-fluid position-relative z-1">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center">
            <div class="mb-3 mb-lg-0">
                <div class="d-inline-flex align-items-center px-3 py-1 bg-white bg-opacity-10 rounded-pill fs-6 mb-3 border border-white border-opacity-25">
                    <i class="fas fa-boxes text-info me-2"></i> Inventario
                </div>
                <h2 class="fw-bold mb-1 tracking-tight text-white display-6 text-shadow-sm">Kardex de Inventario</h2>
                <p class="text-white-50 mb-0">Historial detallado de movimientos de inventario</p>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid px-3 px-lg-4 position-relative" style="top: -3.5rem; z-index: 10;">

    <!-- Filtros -->
    <div class="card dashboard-card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
            <h6 class="fw-bold mb-0"><i class="fas fa-filter me-2 text-primary"></i> Filtros</h6>
        </div>
        <div class="card-body p-4">
            <form method="GET" action="{{ route('admin.inventario.kardex.form') }}">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold small text-uppercase text-muted">Inventario</label>
                        <select name="inventario_id" class="form-select">
                            <option value="">Seleccionar inventario</option>
                            @forelse($inventarios as $inventario)
                                <option value="{{ $inventario->id }}" {{ request('inventario_id') == $inventario->id ? 'selected' : '' }}>
                                    {{ $inventario->parte ? $inventario->parte->nombre : ($inventario->vehiculo ? $inventario->vehiculo->marca->nombre . ' ' . $inventario->vehiculo->modelo->nombre : 'N/A') }}
                                </option>
                            @empty
                                <option value="" disabled>No hay inventarios disponibles</option>
                            @endforelse
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-semibold small text-uppercase text-muted">Almacén</label>
                        <select name="almacen_id" class="form-select">
                            <option value="">Todos los almacenes</option>
                            @foreach($almacenes as $almacen)
                            <option value="{{ $almacen->id }}" {{ request('almacen_id') == $almacen->id ? 'selected' : '' }}>
                                {{ $almacen->nombre }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold small text-uppercase text-muted">Tipo Item</label>
                        <select name="tipo_item" class="form-select">
                            <option value="">Todos</option>
                            <option value="parte" {{ request('tipo_item') == 'parte' ? 'selected' : '' }}>Partes</option>
                            <option value="vehiculo" {{ request('tipo_item') == 'vehiculo' ? 'selected' : '' }}>Vehículos</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-semibold small text-uppercase text-muted">Fecha Desde</label>
                        <input type="date" name="fecha_desde" class="form-control" value="{{ request('fecha_desde') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-semibold small text-uppercase text-muted">Fecha Hasta</label>
                        <input type="date" name="fecha_hasta" class="form-control" value="{{ request('fecha_hasta') }}">
                    </div>
                </div>
                <div class="d-flex gap-2 mt-3">
                    <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 fw-bold border-0">
                        <i class="fas fa-search me-2"></i>Filtrar
                    </button>
                    <a href="{{ route('admin.inventario.kardex.form') }}" class="btn btn-outline-secondary rounded-pill px-4 py-2 fw-bold border-0">
                        <i class="fas fa-redo me-2"></i>Limpiar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla Kardex -->
    <div class="card dashboard-card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
            <h6 class="fw-bold mb-0"><i class="fas fa-exchange-alt me-2 text-primary"></i> Movimientos</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="py-3 px-4 border-0 text-uppercase small">Fecha</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Item</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Almacén</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Movimiento</th>
                            <th class="py-3 px-4 border-0 text-uppercase small text-center">Entrada</th>
                            <th class="py-3 px-4 border-0 text-uppercase small text-center">Salida</th>
                            <th class="py-3 px-4 border-0 text-uppercase small text-center">Stock</th>
                            <th class="py-3 px-4 border-0 text-uppercase small text-end">Costo Unit.</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Documento</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($movimientos as $movimiento)
                        <tr>
                            <td class="py-3 px-4">
                                @php
                                    try {
                                        $fecha = $movimiento->fecha_movimiento;
                                        if (is_string($fecha)) {
                                            $fecha = \Carbon\Carbon::parse($fecha);
                                        }
                                        if (!$fecha) {
                                            $fecha = \Carbon\Carbon::now();
                                        }
                                    } catch (\Exception $e) {
                                        $fecha = \Carbon\Carbon::now();
                                    }
                                @endphp
                                <strong>{{ $fecha->format('d/m/Y') }}</strong>
                                <br>
                                <small class="text-muted">{{ $fecha->format('H:i') }}</small>
                            </td>

                            <td class="py-3 px-4">
                                @if($movimiento->parte)
                                    <strong>{{ $movimiento->parte->nombre }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $movimiento->parte->codigo }}</small>
                                    <br>
                                    <span class="badge bg-primary-subtle text-primary rounded-pill px-2">Parte</span>
                                @elseif($movimiento->vehiculo)
                                    <strong>{{ $movimiento->vehiculo->marca->nombre ?? '' }} {{ $movimiento->vehiculo->modelo->nombre ?? '' }}</strong>
                                    <br>
                                    <small class="text-muted">VIN: {{ $movimiento->vehiculo->serie_vin }}</small>
                                    <br>
                                    <span class="badge bg-info-subtle text-info rounded-pill px-2">Vehículo</span>
                                @endif
                            </td>
                            <td class="py-3 px-4">{{ $movimiento->almacen->nombre }}</td>
                            <td class="py-3 px-4">
                                @php
                                    $badgeClass = $movimiento->tipo_movimiento == 'ENTRADA' ? 'bg-success-subtle text-success' :
                                                ($movimiento->tipo_movimiento == 'SALIDA' ? 'bg-danger-subtle text-danger' : 'bg-warning-subtle text-warning');
                                @endphp
                                <span class="badge {{ $badgeClass }} rounded-pill px-2">{{ $movimiento->tipo_movimiento }}</span>
                                <br>
                                <small class="text-muted">{{ $movimiento->concepto }}</small>
                            </td>
                            <td class="text-center py-3 px-4">
                                @if($movimiento->cantidad_entrada > 0)
                                    <span class="text-success fw-bold">+{{ number_format($movimiento->cantidad_entrada, 2) }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-center py-3 px-4">
                                @if($movimiento->cantidad_salida > 0)
                                    <span class="text-danger fw-bold">-{{ number_format($movimiento->cantidad_salida, 2) }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-center py-3 px-4">
                                <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3 fw-bold">{{ number_format($movimiento->stock_actual, 2) }}</span>
                            </td>
                            <td class="text-end py-3 px-4">
                                @if($movimiento->costo_unitario > 0)
                                    <span class="fw-bold">S/ {{ number_format($movimiento->costo_unitario, 2) }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                <code class="bg-light px-2 py-1 rounded small">{{ $movimiento->numero_documento }}</code>
                                @if($movimiento->observaciones)
                                    <br>
                                    <small class="text-muted">{{ $movimiento->observaciones }}</small>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-5">
                                <div class="bg-light d-inline-flex p-4 rounded-circle mb-3"><i class="fas fa-inbox text-muted fa-2x"></i></div>
                                <h5 class="text-dark fw-bold">No se encontraron movimientos</h5>
                                <p class="text-muted mb-0">Ajusta los filtros para ver los movimientos de kardex</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($movimientos->hasPages())
        <div class="card-footer bg-white border-0 px-4 py-3">
            {{ $movimientos->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
