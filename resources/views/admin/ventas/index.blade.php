{{-- resources/views/admin/ventas/index.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Gestión de Ventas')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-shopping-cart mr-2"></i>Gestión de Ventas
        </h1>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.ventas.pos.index') }}" class="btn btn-primary">
                <i class="fas fa-plus mr-1"></i>Nuevo POS
            </a>
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exportModal">
                <i class="fas fa-download mr-1"></i>Exportar
            </button>
        </div>
    </div>

    {{-- Estadísticas rápidas --}}
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Ventas
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($estadisticas->total_ventas) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Monto Total
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                S/ {{ number_format($estadisticas->monto_total, 2) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Promedio Venta
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                S/ {{ number_format($estadisticas->promedio_venta, 2) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Saldo Pendiente
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                S/ {{ number_format($estadisticas->total_pendiente, 2) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filtros --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filtros de Búsqueda</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.ventas.index') }}" id="filtrosForm">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="search" class="form-label">Buscar</label>
                        <input type="text" 
                               class="form-control" 
                               id="search" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Código, cliente, documento...">
                    </div>
                    
                    <div class="col-md-2 mb-3">
                        <label for="fecha_desde" class="form-label">Desde</label>
                        <input type="date" 
                               class="form-control" 
                               id="fecha_desde" 
                               name="fecha_desde" 
                               value="{{ request('fecha_desde') }}">
                    </div>
                    
                    <div class="col-md-2 mb-3">
                        <label for="fecha_hasta" class="form-label">Hasta</label>
                        <input type="date" 
                               class="form-control" 
                               id="fecha_hasta" 
                               name="fecha_hasta" 
                               value="{{ request('fecha_hasta') }}">
                    </div>
                    
                    <div class="col-md-2 mb-3">
                        <label for="estado" class="form-label">Estado</label>
                        <select class="form-control" id="estado" name="estado">
                            <option value="">Todos los estados</option>
                            @foreach($estados as $estado)
                                <option value="{{ $estado }}" 
                                        {{ request('estado') == $estado ? 'selected' : '' }}>
                                    {{ $estado }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-2 mb-3">
                        <label for="almacen_id" class="form-label">Almacén</label>
                        <select class="form-control" id="almacen_id" name="almacen_id">
                            <option value="">Todos los almacenes</option>
                            @foreach($almacenes as $almacen)
                                <option value="{{ $almacen->id }}" 
                                        {{ request('almacen_id') == $almacen->id ? 'selected' : '' }}>
                                    {{ $almacen->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-1 mb-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-2 mb-3">
                        <label for="moneda" class="form-label">Moneda</label>
                        <select class="form-control" id="moneda" name="moneda">
                            <option value="">Todas las monedas</option>
                            @foreach($monedas as $moneda)
                                <option value="{{ $moneda }}" 
                                        {{ request('moneda') == $moneda ? 'selected' : '' }}>
                                    {{ $moneda }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-2 mb-3">
                        <label for="tipo_pago" class="form-label">Tipo Pago</label>
                        <select class="form-control" id="tipo_pago" name="tipo_pago">
                            <option value="">Todos los tipos</option>
                            @foreach($tiposPago as $tipo)
                                <option value="{{ $tipo }}" 
                                        {{ request('tipo_pago') == $tipo ? 'selected' : '' }}>
                                    {{ $tipo }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-2 mb-3 d-flex align-items-end">
                        <a href="{{ route('admin.ventas.index') }}" class="btn btn-secondary btn-block">
                            <i class="fas fa-times mr-1"></i>Limpiar
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabla de ventas --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Listado de Ventas</h6>
            <div class="text-muted">
                Mostrando {{ $ventas->firstItem() ?? 0 }} - {{ $ventas->lastItem() ?? 0 }} 
                de {{ $ventas->total() }} ventas
            </div>
        </div>
        <div class="card-body">
            @if($ventas->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                        <thead class="thead-light">
                            <tr>
                                <th>Código</th>
                                <th>Fecha</th>
                                <th>Cliente</th>
                                <th>Usuario</th>
                                <th>Almacén</th>
                                <th>Total</th>
                                <th>Estado</th>
                                <th>% Pagado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ventas as $venta)
                                <tr>
                                    <td>
                                        <strong>{{ $venta->codigo }}</strong>
                                        @if($venta->cotizacion)
                                            <br><small class="text-muted">
                                                Cot: {{ $venta->cotizacion->codigo }}
                                            </small>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $venta->fecha->format('d/m/Y') }}
                                        <br><small class="text-muted">
                                            {{ $venta->fecha->format('H:i') }}
                                        </small>
                                    </td>
                                    <td>
                                        @if($venta->cliente)
                                            @if($venta->cliente->tipo_cliente == 'natural')
                                                <strong>
                                                    {{ trim(($venta->cliente->nombres ?? '') . ' ' . ($venta->cliente->apellido_paterno ?? '') . ' ' . ($venta->cliente->apellido_materno ?? '')) ?: 'Sin nombre' }}
                                                </strong>
                                            @else
                                                <strong>{{ $venta->cliente->razon_social ?? 'Cliente corporativo' }}</strong>
                                            @endif
                                            <br><small class="text-muted">
                                                {{ $venta->cliente->documento_identidad ?? 'Sin documento' }}
                                            </small>
                                        @else
                                            <span class="text-muted">Cliente no encontrado</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $venta->usuario->name ?? 'Usuario no encontrado' }}
                                    </td>
                                    <td>
                                        <span class="badge badge-info">
                                            {{ $venta->almacen->nombre ?? 'Almacén no encontrado' }}
                                        </span>
                                    </td>
                                    <td>
                                        <strong>
                                            {{ $venta->moneda == 'Soles' ? 'S/' : ' ' }} 
                                            {{ number_format($venta->total, 2) }}
                                        </strong>
                                        @if($venta->tipo_pago == 'Credito')
                                            <br><small class="text-muted">
                                                Abonado: {{ $venta->moneda == 'Soles' ? 'S/' : '$' }} {{ number_format($venta->monto_abonado, 2) }}
                                            </small>
                                        @endif
                                    </td>
                                    <td>
                                        @switch($venta->estado)
                                            @case('Completada')
                                                <span class="badge badge-success">{{ $venta->estado }}</span>
                                                @break
                                            @case('Parcial')
                                                <span class="badge badge-warning">{{ $venta->estado }}</span>
                                                @break
                                            @case('Cancelada')
                                                <span class="badge badge-danger">{{ $venta->estado }}</span>
                                                @break
                                            @default
                                                <span class="badge badge-secondary">{{ $venta->estado }}</span>
                                        @endswitch
                                        
                                        @if($venta->tipo_pago == 'Crédito')
                                            <br><small class="text-muted">{{ $venta->tipo_pago }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $porcentaje = $venta->getPorcentajeAbonadoAttribute();
                                        @endphp
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar 
                                                @if($porcentaje == 100) bg-success 
                                                @elseif($porcentaje >= 50) bg-warning 
                                                @else bg-danger @endif" 
                                                role="progressbar" 
                                                style="width: {{ $porcentaje }}%"
                                                aria-valuenow="{{ $porcentaje }}" 
                                                aria-valuemin="0" 
                                                aria-valuemax="100">
                                                {{ number_format($porcentaje, 1) }}%
                                            </div>
                                        </div>
                                        @if($venta->saldo_pendiente > 0)
                                            <small class="text-danger">
                                                Saldo: {{ $venta->moneda == 'Soles' ? 'S/' : ' ' }} {{ number_format($venta->saldo_pendiente, 2) }}
                                            </small>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.ventas.show', $venta->id) }}" 
                                               class="btn btn-sm btn-info" 
                                               title="Ver detalle">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            
                                            @if($venta->saldo_pendiente > 0 && $venta->estado != 'Cancelada')
                                                <button type="button" 
                                                        class="btn btn-sm btn-success" 
                                                        onclick="abrirModalPago({{ $venta->id }}, {{ $venta->saldo_pendiente }})"
                                                        title="Registrar pago">
                                                    <i class="fas fa-credit-card"></i>
                                                </button>
                                            @endif
                                            
                                            @if($venta->estado != 'Cancelada')
                                                <button type="button" 
                                                        class="btn btn-sm btn-danger" 
                                                        onclick="abrirModalAnular({{ $venta->id }})"
                                                        title="Anular venta">
                                                    <i class="fas fa-ban"></i>
                                                </button>
                                            @endif
                                            
                                            <a href="{{ route('admin.ventas.imprimir', $venta->id) }}" 
                                               class="btn btn-sm btn-secondary" 
                                               target="_blank"
                                               title="Imprimir">
                                                <i class="fas fa-print"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Paginación --}}
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted">
                        Mostrando {{ $ventas->firstItem() }} - {{ $ventas->lastItem() }} 
                        de {{ $ventas->total() }} resultados
                    </div>
                    {{ $ventas->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-shopping-cart fa-3x text-gray-300 mb-3"></i>
                    <h5 class="text-gray-600">No se encontraron ventas</h5>
                    <p class="text-muted">Prueba ajustando los filtros de búsqueda o 
                        <a href="{{ route('admin.ventas.pos.index') }}">crea una nueva venta</a>
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Modal para registrar pago --}}
<div class="modal fade" id="modalPago" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="formPago" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-credit-card mr-2"></i>Registrar Pago
                    </h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="monto">Monto a Pagar *</label>
                        <input type="number" 
                               class="form-control" 
                               id="monto" 
                               name="monto" 
                               step="0.01" 
                               min="0.01" 
                               required>
                        <small class="text-muted">Saldo pendiente: <span id="saldoPendiente"></span></small>
                    </div>
                    <div class="form-group">
                        <label for="referencia">Referencia</label>
                        <input type="text" 
                               class="form-control" 
                               id="referencia" 
                               name="referencia" 
                               placeholder="Nº de operación, banco, etc.">
                    </div>
                    <div class="form-group">
                        <label for="comentario">Comentario</label>
                        <textarea class="form-control" 
                                  id="comentario" 
                                  name="comentario" 
                                  rows="3" 
                                  placeholder="Observaciones del pago..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save mr-1"></i>Registrar Pago
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal para anular venta --}}
<div class="modal fade" id="modalAnular" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="formAnular" method="POST">
                @csrf
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-ban mr-2"></i>Anular Venta
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        Esta acción no se puede deshacer. La venta será marcada como cancelada.
                    </div>
                    <div class="form-group">
                        <label for="motivo">Motivo de la anulación *</label>
                        <textarea class="form-control" 
                                  id="motivo" 
                                  name="motivo" 
                                  rows="3" 
                                  required 
                                  placeholder="Describe el motivo por el cual se anula esta venta..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-ban mr-1"></i>Anular Venta
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal para exportar --}}
<div class="modal fade" id="exportModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="GET" action="#">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-download mr-2"></i>Exportar Ventas
                    </h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text-muted">Se exportarán las ventas con los filtros actuales aplicados.</p>
                    
                    {{-- Preservar filtros actuales --}}
                    @foreach(request()->query() as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                    
                    <div class="form-group">
                        <label>Filtros aplicados:</label>
                        <ul class="list-unstyled">
                            @if(request('search'))
                                <li><strong>Búsqueda:</strong> {{ request('search') }}</li>
                            @endif
                            @if(request('fecha_desde'))
                                <li><strong>Desde:</strong> {{ request('fecha_desde') }}</li>
                            @endif
                            @if(request('fecha_hasta'))
                                <li><strong>Hasta:</strong> {{ request('fecha_hasta') }}</li>
                            @endif
                            @if(request('estado'))
                                <li><strong>Estado:</strong> {{ request('estado') }}</li>
                            @endif
                            @if(request('almacen_id'))
                                <li><strong>Almacén:</strong> {{ $almacenes->find(request('almacen_id'))->nombre ?? 'N/A' }}</li>
                            @endif
                            @if(!request()->hasAny(['search', 'fecha_desde', 'fecha_hasta', 'estado', 'almacen_id']))
                                <li class="text-muted">Sin filtros específicos</li>
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-file-excel mr-1"></i>Descargar CSV
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
function abrirModalPago(ventaId, saldoPendiente) {
    document.getElementById('formPago').action = `/admin/ventas/${ventaId}/pago`;
    document.getElementById('monto').max = saldoPendiente;
    document.getElementById('monto').value = saldoPendiente;
    document.getElementById('saldoPendiente').textContent = `S/ ${saldoPendiente.toFixed(2)}`;
    $('#modalPago').modal('show');
}

function abrirModalAnular(ventaId) {
    document.getElementById('formAnular').action = `/admin/ventas/${ventaId}/anular`;
    document.getElementById('motivo').value = '';
    $('#modalAnular').modal('show');
}

// Auto-submit de filtros con delay
let timeoutId;
document.getElementById('search').addEventListener('input', function() {
    clearTimeout(timeoutId);
    timeoutId = setTimeout(function() {
        document.getElementById('filtrosForm').submit();
    }, 500);
});

// Confirmar antes de anular
document.getElementById('formAnular').addEventListener('submit', function(e) {
    if (!confirm('¿Estás seguro de que deseas anular esta venta? Esta acción no se puede deshacer.')) {
        e.preventDefault();
    }
});
</script>
@endsection