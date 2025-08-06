@extends('admin.layouts.app')

@section('title', 'Detalle de Orden de Compra')
@section('header', 'Orden de Compra #' . $orden->codigo)

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <!-- Mensajes de éxito/error -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Estado de la orden -->
                <div class="mb-4">
                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center">
                        <h5 class="fw-bold mb-3" :class="darkMode ? 'text-light' : 'text-dark'">
                            Estado: 
                            @if($orden->estado == 'en espera')
                                <span class="badge bg-warning text-dark">En Espera</span>
                            @elseif($orden->estado == 'aprobada')
                                <span class="badge bg-success">Aprobada</span>
                            @elseif($orden->estado == 'rechazada')
                                <span class="badge bg-danger">Rechazada</span>
                            @endif
                        </h5>
                        <div>
                            @if($orden->estado == 'en espera')
                                <div class="btn-group">
                                    <form action="{{ route('admin.compras.ordenes.aprobar', $orden) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('¿Estás seguro de aprobar esta orden?')">
                                            <svg xmlns="http://www.w3.org/2000/svg" style="height: 1rem; width: 1rem;" class="me-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            Aprobar
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.compras.ordenes.rechazar', $orden) }}" method="POST" class="d-inline ms-2">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de rechazar esta orden?')">
                                            <svg xmlns="http://www.w3.org/2000/svg" style="height: 1rem; width: 1rem;" class="me-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            Rechazar
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Información General -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5 class="fw-bold mb-3" :class="darkMode ? 'text-light' : 'text-dark'">Información de la Orden</h5>
                        <dl class="row mb-0">
                            <dt class="col-sm-4">Código</dt>
                            <dd class="col-sm-8">{{ $orden->codigo }}</dd>
                            
                            <dt class="col-sm-4">Requerimiento</dt>
                            <dd class="col-sm-8">
                                <a href="{{ url('admin/compras/requerimientos/' . $orden->requerimiento_id) }}">
                                    #{{ $orden->requerimiento_id }}
                                </a>
                            </dd>
                            
                            <dt class="col-sm-4">Fecha de Creación</dt>
                            <dd class="col-sm-8">{{ $orden->created_at->format('d/m/Y H:i') }}</dd>
                            
                            <dt class="col-sm-4">Almacén Destino</dt>
                            <dd class="col-sm-8">{{ $orden->almacen->nombre ?? 'N/A' }}</dd>
                            
                            <dt class="col-sm-4">Requerido por</dt>
                            <dd class="col-sm-8">{{ $orden->usuario->name ?? 'N/A' }}</dd>
                            
                            <dt class="col-sm-4">Moneda</dt>
                            <dd class="col-sm-8">{{ $orden->moneda }}</dd>
                        </dl>
                    </div>
                    
                    <div class="col-md-6">
                        <h5 class="fw-bold mb-3" :class="darkMode ? 'text-light' : 'text-dark'">Información del Proveedor</h5>
                        <dl class="row mb-0">
                            <dt class="col-sm-4">Proveedor</dt>
                            <dd class="col-sm-8">{{ $orden->proveedor->razon_social ?? 'No especificado' }}</dd>
                            
                            <dt class="col-sm-4">RUC/DNI</dt>
                            <dd class="col-sm-8">{{ $orden->proveedor->numero_documento ?? 'No especificado' }}</dd>
                            
                            @if($orden->estado != 'en espera')
                                <dt class="col-sm-4">Aprobado por</dt>
                                <dd class="col-sm-8">{{ $orden->aprobador->name ?? 'N/A' }}</dd>
                                
                                <dt class="col-sm-4">Fecha de Aprobación</dt>
                                <dd class="col-sm-8">{{ $orden->fecha_aprobacion ? date('d/m/Y', strtotime($orden->fecha_aprobacion)) : 'N/A' }}</dd>
                            @endif
                            
                            <dt class="col-sm-4">Observaciones</dt>
                            <dd class="col-sm-8">{{ $orden->observaciones ?: 'Sin observaciones' }}</dd>
                        </dl>
                    </div>
                </div>

                <!-- Detalles del Pedido -->
                <div class="mb-4">
                    <h5 class="fw-bold mb-3" :class="darkMode ? 'text-light' : 'text-dark'">Productos</h5>
                    <div class="table-responsive">
                        <table class="table table-hover" :class="darkMode ? 'table-dark' : ''">
                            <thead class="table-light" :class="darkMode ? 'table-dark' : ''">
                                <tr>
                                    <th class="small text-uppercase">Nro.</th>
                                    <th class="small text-uppercase">Código</th>
                                    <th class="small text-uppercase">Producto</th>
                                    <th class="small text-uppercase">Tipo</th>
                                    <th class="small text-uppercase">Cant. Requerida</th>
                                    <th class="small text-uppercase">Cant. Compra</th>
                                    <th class="small text-uppercase">Unidad</th>
                                    <th class="small text-uppercase">Precio</th>
                                    <th class="small text-uppercase">Descuento</th>
                                    <th class="small text-uppercase">Total</th>
                                    <th class="small text-uppercase">IGV</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($orden->detalles as $index => $detalle)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $detalle->codigo }}</td>
                                        <td>{{ $detalle->nombre_producto }}</td>
                                        <td>{{ ucfirst($detalle->tipo_item) }}</td>
                                        <td>{{ $detalle->cantidad_requerida }}</td>
                                        <td>{{ $detalle->cantidad_en_compra }}</td>
                                        <td>{{ $detalle->unidad }}</td>
                                        <td>{{ $orden->moneda }} {{ number_format($detalle->precio_compra, 2) }}</td>
                                        <td>{{ $orden->moneda }} {{ number_format($detalle->descuento, 2) }}</td>
                                        <td>{{ $orden->moneda }} {{ number_format($detalle->total, 2) }}</td>
                                        <td>{{ $detalle->afecto_igv ? 'Sí' : 'No' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="11" class="text-center py-3">No hay productos en esta orden.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="9" class="text-end"><strong>Total:</strong></td>
                                    <td colspan="2"><strong>{{ $orden->moneda }} {{ number_format($orden->total, 2) }}</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- Botones de Acción -->
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.compras.ordenes.index') }}" class="btn btn-outline-secondary btn-sm">Volver</a>
                    @if($orden->estado == 'en espera')
                        <a href="{{ route('admin.compras.ordenes.edit', $orden) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('admin.compras.ordenes.destroy', $orden) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar esta orden?')">Eliminar</button>
                        </form>
                    @endif
                    <button onclick="window.print()" class="btn btn-primary btn-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" style="height: 1rem; width: 1rem;" class="me-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                        Imprimir
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        body * {
            visibility: hidden;
        }
        .card, .card * {
            visibility: visible;
        }
        .card {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
        .btn, .btn-group, form button {
            display: none !important;
        }
    }
</style>
@endsection