@extends('admin.layouts.app')

@section('title', 'Gestión de Cotizaciones')

@section('header', 'Gestión de Cotizaciones')

@section('content')
<div class="container-fluid px-2 px-lg-4">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-primary text-white py-2">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-semibold">COTIZACIONES ({{ $cotizaciones->total() }})</h5>
                <div>
                    <a href="{{ route('admin.ventas.cotizaciones.create') }}" class="btn btn-sm btn-light">
                        <i class="fas fa-plus me-1"></i> Nueva Cotización
                    </a>
                </div>
            </div>
        </div>
        
        <div class="card-body p-3">
            <!-- Filtros -->
            <div class="row mb-3">
                <div class="col-md-12">
                    <form action="{{ route('admin.ventas.cotizaciones.index') }}" method="GET" class="row g-2">
                        <!-- Fecha -->
                        <div class="col-md-2">
                            <div class="input-group input-group-sm">
                                <input type="date" class="form-control" placeholder="Fecha" name="fecha" value="{{ request('fecha') }}">
                                <button class="btn btn-outline-secondary" type="button" onclick="this.previousElementSibling.value = ''">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Búsqueda -->
                        <div class="col-md-3">
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control" placeholder="Documento o nombre" name="busqueda" value="{{ request('busqueda') }}">
                            </div>
                        </div>
                        
                        <!-- Filtro por estado -->
                        <div class="col-md-3">
                            <select class="form-select form-select-sm" name="estado_id">
                                <option value="">Seleccione un estado</option>
                                @foreach(\App\Models\EstadoCotizacion::all() as $estado)
                                    <option value="{{ $estado->id }}" {{ request('estado_id') == $estado->id ? 'selected' : '' }}>
                                        {{ $estado->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Botones de acción -->
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fas fa-search"></i> Filtrar
                            </button>
                        </div>
                        
                        <div class="col-auto">
                            <a href="{{ route('admin.ventas.cotizaciones.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-broom"></i> Limpiar
                            </a>
                        </div>
                        
                        <div class="col-auto">
                            <a href="{{ route('admin.ventas.cotizaciones.index', ['export' => 'excel']) }}" class="btn btn-success btn-sm">
                                <i class="fas fa-file-excel"></i> Descargar Lista
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Tabla de cotizaciones -->
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="tablaCotizaciones">
                    <thead class="bg-light">
                        <tr>
                            <th>Cliente</th>
                            <th>Concesionario</th>
                            <th>Modelo/Origen</th>
                            <th width="10%">Estado</th>
                            <th width="8%">Comentarios</th>
                            <th width="8%">Acciones</th>
                            <th width="2%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cotizaciones as $cotizacion)
                        <tr>
                            <td>
                                <div class="d-flex flex-column">
                                    <span class="fw-semibold mb-1">
                                        @if($cotizacion->cliente->tipo_cliente === 'natural')
                                            {{ $cotizacion->cliente->nombres }} {{ $cotizacion->cliente->apellido_paterno }}
                                        @else
                                            {{ $cotizacion->cliente->razon_social }}
                                        @endif
                                    </span>
                                    <small class="text-muted">
                                        <strong>Doc:</strong> {{ $cotizacion->cliente->documento_identidad }}<br>
                                        <strong>Tel:</strong> {{ $cotizacion->cliente->telefonos->first()->numero ?? 'N/A' }}<br>
                                        <strong>Email:</strong> {{ $cotizacion->cliente->correo ?? 'N/A' }}
                                    </small>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <span class="fw-semibold">{{ $cotizacion->almacen->nombre ?? 'No especificado' }}</span>
                                    <small class="text-muted">
                                        {{ $cotizacion->created_at->format('d/m/Y H:i') }}
                                    </small>
                                </div>
                            </td>
                            <td>
                                @if($cotizacion->detalles && $cotizacion->detalles->first())
                                    <div class="d-flex flex-column">
                                        <span class="fw-semibold">{{ $cotizacion->detalles->first()->descripcion }}</span>
                                        <small class="text-muted">Prueba</small>
                                    </div>
                                @else
                                    <span class="text-muted">Sin detalles</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-{{ $cotizacion->estado->color ?? 'secondary' }} rounded-pill">
                                    {{ $cotizacion->estado->nombre ?? 'Sin estado' }}
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-info rounded-pill">
                                    {{ $cotizacion->seguimientos->count() }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex justify-content-end">
                                    <!--a href="{{ route('admin.ventas.cotizaciones.show', $cotizacion) }}" 
                                       class="btn btn-sm btn-outline-dark me-1" 
                                       data-bs-toggle="tooltip" 
                                       title="Ver detalle">
                                        <i class="fas fa-eye"></i>
                                    </a-->
                                    
                                    <a href="{{ route('admin.ventas.cotizaciones.gestionar', $cotizacion) }}" 
                                       class="btn btn-sm btn-primary" 
                                       data-bs-toggle="tooltip" 
                                       title="Gestionar">
                                        GESTIONAR
                                    </a>
                                </div>
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-light" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <!--a class="dropdown-item" href="{{ route('admin.ventas.cotizaciones.edit', $cotizacion) }}">
                                            <i class="fas fa-edit me-2 text-primary"></i> Editar
                                        </a-->
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.ventas.cotizaciones.show', ['cotizacion' => $cotizacion, 'format' => 'pdf']) }}">
                                            <i class="fas fa-file-pdf me-2 text-danger"></i> Descargar PDF
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('admin.ventas.cotizaciones.destroy', $cotizacion) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger" onclick="return confirm('¿Está seguro de eliminar esta cotización?')">
                                                <i class="fas fa-trash-alt me-2"></i> Eliminar
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <i class="fas fa-folder-open fa-2x mb-2 text-muted"></i>
                                <p class="text-muted">No hay cotizaciones que coincidan con los filtros aplicados</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Paginación -->
            <div class="d-flex justify-content-center mt-3">
                {{ $cotizaciones->appends(request()->query())->links() }}
            </div>
            
            <!-- Resumen y estadísticas -->
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm mb-3">
                        <div class="card-header bg-light py-2">
                            <h6 class="mb-0">Funnel de Gestión</h6>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-column">
                                <div class="funnel-item bg-primary text-center text-white py-2 rounded mb-2">
                                    <strong>GESTIONADOS</strong>
                                    <div class="fw-bold">{{ isset($estadisticas) ? $estadisticas['porcentajeGestionados'] : '0' }}%</div>
                                </div>
                                <div class="funnel-item bg-info text-center text-white py-2 rounded mb-2" style="width: 90%; margin: 0 auto;">
                                    <strong>CONTACTABLES</strong>
                                    <div class="fw-bold">{{ isset($estadisticas) ? $estadisticas['porcentajeContactables'] : '0' }}%</div>
                                </div>
                                <div class="funnel-item bg-warning text-center text-white py-2 rounded" style="width: 70%; margin: 0 auto;">
                                    <strong>InteresadoS</strong>
                                    <div class="fw-bold">{{ isset($estadisticas) ? $estadisticas['porcentajeInteresados'] : '0' }}%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-light py-2">
                            <h6 class="mb-0">Prioridad de Gestión</h6>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-md-4">
                                    <div class="priority-circle rounded-circle mx-auto mb-2 border" style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; border-color: #dc3545 !important;">
                                        <div class="text-center">
                                            <div style="font-size: 1.5rem;">{{ isset($estadisticas) ? $estadisticas['vencidos'] : '0' }}</div>
                                            <small>{{ isset($estadisticas) ? $estadisticas['porcentajeVencidos'] : '0' }}%</small>
                                        </div>
                                    </div>
                                    <p class="mb-0 small">Vencido</p>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="priority-circle rounded-circle mx-auto mb-2 border" style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; border-color: #ffc107 !important;">
                                        <div class="text-center">
                                            <div style="font-size: 1.5rem;">{{ isset($estadisticas) ? $estadisticas['porVencer'] : '0' }}</div>
                                            <small>{{ isset($estadisticas) ? $estadisticas['porcentajePorVencer'] : '0' }}%</small>
                                        </div>
                                    </div>
                                    <p class="mb-0 small">Por vencer</p>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="priority-circle rounded-circle mx-auto mb-2 border" style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; border-color: #198754 !important;">
                                        <div class="text-center">
                                            <div style="font-size: 1.5rem;">{{ isset($estadisticas) ? $estadisticas['aTiempo'] : '0' }}</div>
                                            <small>{{ isset($estadisticas) ? $estadisticas['porcentajeATiempo'] : '0' }}%</small>
                                        </div>
                                    </div>
                                    <p class="mb-0 small">A Tiempo</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Estilos para el funnel */
    .funnel-item {
        transition: all 0.3s ease;
    }
    
    .funnel-item:hover {
        transform: scale(1.02);
    }
    
    /* Estilos para los círculos de prioridad */
    .priority-circle {
        transition: all 0.3s ease;
    }
    
    .priority-circle:hover {
        transform: scale(1.05);
    }
    
    /* Responsive */
    @media (max-width: 767.98px) {
        .funnel-item, .priority-circle {
            margin-bottom: 1rem !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        // Inicializar tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        // Highlight de filas al pasar el mouse
        $('#tablaCotizaciones tbody tr').hover(
            function() {
                $(this).addClass('bg-light');
            },
            function() {
                $(this).removeClass('bg-light');
            }
        );
    });
</script>
@endpush