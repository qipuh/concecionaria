@extends('admin.layouts.app')

@section('title', 'Kardex - Reporte de Movimientos')

@section('header', 'Reporte Kardex')

@section('content')
<div class="dashboard-hero" style="padding: 2rem 2rem; border-radius: 0 0 1.5rem 1.5rem; margin-bottom: 2.5rem;">
    <div class="hero-glow-alt" style="top: -50px; right: 0; filter: blur(60px); opacity: 0.2;"></div>
    <div class="container-fluid position-relative z-1">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center">
            <div class="mb-3 mb-lg-0">
                <div class="d-inline-flex align-items-center px-3 py-1 bg-white bg-opacity-10 rounded-pill fs-6 mb-3 border border-white border-opacity-25">
                    <i class="fas fa-chart-line text-info me-2"></i> Inventario
                </div>
                <h2 class="fw-bold mb-1 tracking-tight text-white display-6 text-shadow-sm">Reporte Kardex</h2>
                <p class="text-white-50 mb-0">Control detallado de movimientos de inventario - {{ $parte->codigo }}</p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <button class="btn bg-white text-dark rounded-pill px-4 py-2 fw-bold shadow-sm border-0" onclick="window.print()">
                    <i class="fas fa-print me-2"></i> Imprimir
                </button>
                <a href="{{ route('admin.inventario.kardex.form') }}" class="btn btn-outline-secondary rounded-pill px-4 py-2 fw-bold border-0" style="color:white; border-color: rgba(255,255,255,0.5);">
                    <i class="fas fa-arrow-left me-2"></i> Volver
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid px-3 px-lg-4 position-relative" style="top: -3.5rem; z-index: 10;">

    <div class="row mb-4">
        <!-- Información del Producto -->
        <div class="col-md-6 mb-4 mb-md-0">
            <div class="card dashboard-card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                    <h6 class="fw-bold mb-0"><i class="fas fa-cube me-2 text-primary"></i> Información del Producto</h6>
                </div>
                <div class="card-body p-4">
                    <ul class="list-unstyled mb-0">
                        <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
                            <span class="text-muted small fw-semibold">Código</span>
                            <span class="fw-semibold">{{ $parte->codigo }}</span>
                        </li>
                        <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
                            <span class="text-muted small fw-semibold">Nombre</span>
                            <span class="fw-semibold">{{ $parte->nombre }}</span>
                        </li>
                        <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
                            <span class="text-muted small fw-semibold">Unidad</span>
                            <span class="fw-semibold">{{ $parte->unidad->nombre }}</span>
                        </li>
                        @if(isset($parte->categoria))
                        <li class="d-flex justify-content-between align-items-center py-2">
                            <span class="text-muted small fw-semibold">Categoría</span>
                            <span class="fw-semibold">{{ $parte->categoria->nombre }}</span>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>

        <!-- Stock Actual -->
        <div class="col-md-6">
            <div class="card dashboard-card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                    <h6 class="fw-bold mb-0"><i class="fas fa-warehouse me-2 text-primary"></i> Stock por Almacén</h6>
                </div>
                <div class="card-body p-4">
                    @if($stockActual->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="py-2 border-0 text-uppercase small">Almacén</th>
                                        <th class="py-2 border-0 text-uppercase small text-end">Disponible</th>
                                        <th class="py-2 border-0 text-uppercase small text-end">Reservado</th>
                                        <th class="py-2 border-0 text-uppercase small text-end">Mínimo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($stockActual as $stock)
                                    <tr>
                                        <td>{{ $stock->almacen->nombre }}</td>
                                        <td class="text-end fw-bold text-success">{{ number_format($stock->stock_disponible, 2) }}</td>
                                        <td class="text-end fw-semibold text-warning">{{ number_format($stock->stock_reservado, 2) }}</td>
                                        <td class="text-end fw-semibold text-danger">{{ number_format($stock->stock_minimo, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <div class="bg-light d-inline-flex p-3 rounded-circle mb-2"><i class="fas fa-box-open text-muted fa-2x"></i></div>
                            <p class="text-muted mb-0">No hay stock registrado en ningún almacén</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de Movimientos -->
    <div class="card dashboard-card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
            <h6 class="fw-bold mb-0">
                <i class="fas fa-exchange-alt me-2 text-primary"></i>
                Movimientos {{ $almacen ? 'en '.$almacen->nombre : 'en todos los almacenes' }}
            </h6>
        </div>
        <div class="card-body p-4">
            @if($movimientos->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="py-3 px-4 border-0 text-uppercase small">Fecha</th>
                                <th class="py-3 px-4 border-0 text-uppercase small">Tipo</th>
                                <th class="py-3 px-4 border-0 text-uppercase small">Documento</th>
                                <th class="py-3 px-4 border-0 text-uppercase small">Almacén</th>
                                <th class="py-3 px-4 border-0 text-uppercase small text-end">Entrada</th>
                                <th class="py-3 px-4 border-0 text-uppercase small text-end">Salida</th>
                                <th class="py-3 px-4 border-0 text-uppercase small text-end">Existencia</th>
                                <th class="py-3 px-4 border-0 text-uppercase small text-end">Costo Unit.</th>
                                <th class="py-3 px-4 border-0 text-uppercase small text-end">Valor Total</th>
                                <th class="py-3 px-4 border-0 text-uppercase small">Usuario</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($movimientos as $movimiento)
                            <tr>
                                <td class="px-4 fw-semibold text-muted small">
                                    {{ \Carbon\Carbon::parse($movimiento->fecha_movimiento)->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-4">
                                    @php
                                        $tipoClass = 'bg-warning-subtle text-warning';
                                        if($movimiento->tipoMovimiento->afecta_stock > 0) {
                                            $tipoClass = 'bg-success-subtle text-success';
                                        } elseif($movimiento->tipoMovimiento->afecta_stock < 0) {
                                            $tipoClass = 'bg-danger-subtle text-danger';
                                        }
                                    @endphp
                                    <span class="badge {{ $tipoClass }} rounded-pill px-3">
                                        {{ $movimiento->tipoMovimiento->nombre }}
                                    </span>
                                </td>
                                <td class="px-4">
                                    <code class="bg-light px-2 py-1 rounded small">{{ $movimiento->documento_referencia }}</code>
                                </td>
                                <td class="px-4">{{ $movimiento->almacen->nombre }}</td>
                                <td class="px-4 text-end">
                                    @if($movimiento->tipoMovimiento->afecta_stock > 0)
                                        <span class="fw-bold text-success">+{{ number_format($movimiento->cantidad, 2) }}</span>
                                    @endif
                                </td>
                                <td class="px-4 text-end">
                                    @if($movimiento->tipoMovimiento->afecta_stock < 0)
                                        <span class="fw-bold text-danger">-{{ number_format($movimiento->cantidad, 2) }}</span>
                                    @endif
                                </td>
                                <td class="px-4 text-end">
                                    <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3">{{ number_format($movimiento->stock_resultante, 2) }}</span>
                                </td>
                                <td class="px-4 text-end">S/ {{ number_format($movimiento->costo_unitario, 2) }}</td>
                                <td class="px-4 text-end fw-semibold">
                                    S/ {{ number_format($movimiento->cantidad * $movimiento->costo_unitario, 2) }}
                                </td>
                                <td class="px-4">
                                    <span class="text-muted small"><i class="fas fa-user me-1"></i>{{ $movimiento->usuario->name }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <div class="bg-light d-inline-flex p-4 rounded-circle mb-3"><i class="fas fa-file-alt text-muted fa-2x"></i></div>
                    <h5 class="text-dark fw-bold">No hay movimientos registrados</h5>
                    <p class="text-muted mb-0">Este producto aún no tiene movimientos en el rango de fechas seleccionado</p>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    window.addEventListener('beforeprint', function() {
        document.querySelectorAll('.table-responsive').forEach(function(element) {
            element.style.overflow = 'visible';
        });
    });

    window.addEventListener('afterprint', function() {
        document.querySelectorAll('.table-responsive').forEach(function(element) {
            element.style.overflow = 'auto';
        });
    });
</script>
@endsection
