@extends('admin.layouts.app')
@section('title', 'Detalle de Recepción')
@section('header', 'Detalle de Recepción')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Header -->
    <div class="card mb-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; border-radius: 15px;">
        <div class="card-body text-white p-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="mb-2 fw-bold">
                        <i class="fas fa-list-alt me-3"></i>
                        Detalle de Recepción #{{ $orden->codigo }}
                    </h2>
                    <p class="mb-0 opacity-75">Historial completo de recepciones y devoluciones</p>
                </div>
                <div class="col-md-4 text-end">
                    @php
                        $estado = $orden->estado_recepcion ?? 'pendiente';
                        $badgeClass = $estado == 'completo' ? 'success' : 
                                    ($estado == 'completo_con_faltantes' ? 'warning' : 
                                    ($estado == 'parcial' ? 'info' : 'secondary'));
                    @endphp
                    <span class="badge bg-{{ $badgeClass }} px-3 py-2 fs-6">
                        {{ $estado == 'completo_con_faltantes' ? 'Completo con Faltantes' : ucfirst($estado) }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Summary -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card h-100 border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-boxes text-primary fa-2x"></i>
                        </div>
                        <div class="ms-3">
                            <p class="text-muted mb-1 small">Items Pedidos</p>
                            <h4 class="mb-0 fw-bold text-primary">{{ $orden->detalles->sum('cantidad_en_compra') }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card h-100 border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-success fa-2x"></i>
                        </div>
                        <div class="ms-3">
                            <p class="text-muted mb-1 small">Items Recibidos</p>
                            <h4 class="mb-0 fw-bold text-success">{{ $orden->detalles->sum('cantidad_recibida') }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card h-100 border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-undo text-warning fa-2x"></i>
                        </div>
                        <div class="ms-3">
                            <p class="text-muted mb-1 small">Items Devueltos</p>
                            <h4 class="mb-0 fw-bold text-warning">
                                {{ $orden->detalles->sum(function($detalle) { 
                                    return $detalle->devoluciones->sum('cantidad_devuelta'); 
                                }) }}
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card h-100 border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-clock text-secondary fa-2x"></i>
                        </div>
                        <div class="ms-3">
                            <p class="text-muted mb-1 small">Items Pendientes</p>
                            <h4 class="mb-0 fw-bold text-secondary">
                                {{ $orden->detalles->sum('cantidad_en_compra') - $orden->detalles->sum('cantidad_recibida') }}
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detalles por Producto -->
    <div class="card border-0 shadow mb-4" style="border-radius: 15px;">
        <div class="card-header bg-light" style="border-radius: 15px 15px 0 0;">
            <h5 class="mb-0 fw-bold">
                <i class="fas fa-list me-2"></i>
                Detalle por Producto
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <tr>
                            <th class="text-white py-3 px-4" style="border: none;">Producto</th>
                            <th class="text-white py-3 px-4 text-center" style="border: none;">Pedida</th>
                            <th class="text-white py-3 px-4 text-center" style="border: none;">Recibida</th>
                            <th class="text-white py-3 px-4 text-center" style="border: none;">Devuelta</th>
                            <th class="text-white py-3 px-4 text-center" style="border: none;">Pendiente</th>
                            <th class="text-white py-3 px-4 text-center" style="border: none;">Estado</th>
                            <th class="text-white py-3 px-4" style="border: none;">Recepciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orden->detalles as $detalle)
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <td class="py-4 px-4">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold" 
                                             style="width: 50px; height: 50px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                            {{ strtoupper(substr($detalle->nombre_producto, 0, 1)) }}
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="mb-1 fw-bold">{{ $detalle->nombre_producto }}</h6>
                                        <p class="mb-1 text-muted small">
                                            <i class="fas fa-barcode me-1"></i>{{ $detalle->codigo }}
                                        </p>
                                        <span class="badge bg-light text-dark">{{ ucfirst($detalle->tipo_item) }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center py-4 px-4">
                                <span class="badge bg-primary px-3 py-2 fs-6">
                                    {{ $detalle->cantidad_en_compra }}
                                </span>
                            </td>
                            <td class="text-center py-4 px-4">
                                <span class="badge bg-success px-3 py-2 fs-6">
                                    {{ $detalle->cantidad_recibida ?? 0 }}
                                </span>
                            </td>
                            <td class="text-center py-4 px-4">
                                <span class="badge bg-warning px-3 py-2 fs-6">
                                    {{ $detalle->devoluciones->sum('cantidad_devuelta') }}
                                </span>
                            </td>
                            <td class="text-center py-4 px-4">
                                <span class="badge bg-secondary px-3 py-2 fs-6">
                                    {{ $detalle->cantidad_en_compra - ($detalle->cantidad_recibida ?? 0) }}
                                </span>
                            </td>
                            <td class="text-center py-4 px-4">
                                <span class="badge px-3 py-2 fs-6 
                                    @if($detalle->estado_recepcion == 'completo') bg-success
                                    @elseif($detalle->estado_recepcion == 'completo_con_faltantes') bg-warning
                                    @elseif($detalle->estado_recepcion == 'parcial') bg-info
                                    @else bg-secondary
                                    @endif">
                                    @if($detalle->estado_recepcion == 'completo_con_faltantes')
                                        Completo c/Faltantes
                                    @else
                                        {{ ucfirst($detalle->estado_recepcion ?? 'pendiente') }}
                                    @endif
                                </span>
                            </td>
                            <td class="py-4 px-4">
                                @if($detalle->recepciones->count() > 0)
                                    <button class="btn btn-outline-primary btn-sm" 
                                            type="button" 
                                            data-bs-toggle="collapse" 
                                            data-bs-target="#recepciones-{{ $detalle->id }}">
                                        <i class="fas fa-eye me-1"></i>
                                        Ver {{ $detalle->recepciones->count() }} recepciones
                                    </button>
                                @else
                                    <span class="text-muted">Sin recepciones</span>
                                @endif
                            </td>
                        </tr>
                        
                        @if($detalle->recepciones->count() > 0)
                        <tr>
                            <td colspan="7" class="p-0" style="border: none;">
                                <div class="collapse" id="recepciones-{{ $detalle->id }}">
                                    <div class="p-4" style="background: #f8f9fa;">
                                        <h6 class="fw-bold mb-3">
                                            <i class="fas fa-history me-2"></i>
                                            Historial de Recepciones
                                        </h6>
                                        <div class="row">
                                            @foreach($detalle->recepciones as $recepcion)
                                            <div class="col-md-6 mb-3">
                                                <div class="card border-0 shadow-sm">
                                                    <div class="card-body p-3">
                                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                                            <span class="badge bg-success">
                                                                {{ $recepcion->cantidad_recibida }} items
                                                            </span>
                                                            <small class="text-muted">
                                                                {{ $recepcion->fecha_recepcion->format('d/m/Y') }}
                                                            </small>
                                                        </div>
                                                        <p class="mb-2">
                                                            <strong>Recibido por:</strong> {{ $recepcion->recibidoPor->name }}
                                                        </p>
                                                        @if($recepcion->observaciones)
                                                        <p class="mb-0 small text-muted">
                                                            <strong>Observaciones:</strong> {{ $recepcion->observaciones }}
                                                        </p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                        
                                        @if($detalle->devoluciones->count() > 0)
                                        <h6 class="fw-bold mb-3 mt-4">
                                            <i class="fas fa-undo me-2"></i>
                                            Historial de Devoluciones
                                        </h6>
                                        <div class="row">
                                            @foreach($detalle->devoluciones as $devolucion)
                                            <div class="col-md-6 mb-3">
                                                <div class="card border-warning">
                                                    <div class="card-body p-3">
                                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                                            <span class="badge bg-warning">
                                                                {{ $devolucion->cantidad_devuelta }} items devueltos
                                                            </span>
                                                            <small class="text-muted">
                                                                {{ $devolucion->fecha_devolucion->format('d/m/Y') }}
                                                            </small>
                                                        </div>
                                                        <p class="mb-2">
                                                            <strong>Devuelto por:</strong> {{ $devolucion->devueltoPor->name }}
                                                        </p>
                                                        <p class="mb-0 small">
                                                            <strong>Motivo:</strong> {{ $devolucion->motivo }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="d-flex justify-content-between align-items-center">
        <a href="{{ route('admin.recepcion.index') }}" 
           class="btn btn-secondary btn-lg px-4 py-2" 
           style="border-radius: 10px;">
            <i class="fas fa-arrow-left me-2"></i>
            Volver al Listado
        </a>
        
        @if($orden->estado_recepcion != 'completo' && $orden->estado_recepcion != 'completo_con_faltantes')
        <a href="{{ route('admin.recepcion.show', $orden->id) }}" 
           class="btn btn-primary btn-lg px-4 py-2" 
           style="border-radius: 10px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
            <i class="fas fa-edit me-2"></i>
            Continuar Recepción
        </a>
        @endif
    </div>
</div>
@endsection