@extends('admin.layouts.app')
@section('title', 'Gestión de Inventario')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="h5 mb-0">Inventario General</h2>
                    <a href="{{ route('admin.inventario.kardex.form') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-file-alt"></i> Generar Reporte Kardex
                    </a>
                </div>
            </div>
            <div class="card-body">
                <!-- Filtros -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <form id="filterForm" action="{{ route('admin.inventario.index') }}" method="GET" class="row g-3">
                            <div class="col-md-3">
                                <label for="tipo" class="form-label">Tipo</label>
                                <select class="form-select form-select-sm" id="tipo" name="tipo" onchange="this.form.submit()">
                                    <option value="" {{ !request('tipo') ? 'selected' : '' }}>Todos</option>
                                    <option value="partes" {{ request('tipo') == 'partes' ? 'selected' : '' }}>Partes</option>
                                    <option value="vehiculos" {{ request('tipo') == 'vehiculos' ? 'selected' : '' }}>Vehículos</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="almacen_id" class="form-label">Almacén</label>
                                <select class="form-select form-select-sm" id="almacen_id" name="almacen_id" onchange="this.form.submit()">
                                    <option value="">Todos los almacenes</option>
                                    @foreach($almacenes as $almacen)
                                        <option value="{{ $almacen->id }}" {{ request('almacen_id') == $almacen->id ? 'selected' : '' }}>
                                            {{ $almacen->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="centro_costo_id" class="form-label">Centro de Costo</label>
                                <select class="form-select form-select-sm" id="centro_costo_id" name="centro_costo_id" onchange="this.form.submit()">
                                    <option value="">Todos los centros</option>
                                    @foreach($centrosCostos as $centro)
                                        <option value="{{ $centro->id }}" {{ request('centro_costo_id') == $centro->id ? 'selected' : '' }}>
                                            {{ $centro->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="search" class="form-label">Buscar</label>
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control" id="search" name="search" 
                                           placeholder="Buscar..." value="{{ request('search') }}">
                                    <button class="btn btn-outline-secondary" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Tabla de Inventario -->
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Nombre</th>
                                <th>Código</th>
                                <th>Tipo</th>
                                <th>Almacén</th>
                                <th>Centro Costo</th>
                                <th class="text-end">Disponible</th>
                                <th class="text-end">Reservado</th>
                                <th class="text-end">Mínimo</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($inventarios as $inventario)
                            <tr>
                                <td>
                                    @if(isset($inventario->parte_id))
                                        {{ $inventario->parte->nombre ?? 'N/A' }}
                                    @elseif(isset($inventario->vehiculo_id))
                                        {{ $inventario->vehiculo->marca->nombre ?? 'N/A' }} 
                                        {{ $inventario->vehiculo->modelo->nombre ?? '' }}
                                        {{ $inventario->vehiculo->version->nombre ?? '' }}
                                    @endif
                                </td>
                                <td>
                                    @if(isset($inventario->parte_id))
                                        {{ $inventario->parte->codigo ?? 'N/A' }}
                                    @elseif(isset($inventario->vehiculo_id))
                                        {{ $inventario->vehiculo->codigo ?? 'N/A' }}
                                    @endif
                                </td>
                                <td>
                                    @if(isset($inventario->parte_id))
                                        <span class="badge bg-info">Parte</span>
                                    @elseif(isset($inventario->vehiculo_id))
                                        <span class="badge bg-primary">Vehículo</span>
                                    @endif
                                </td>
                                <td>{{ $inventario->almacen->nombre ?? 'N/A' }}</td>
                                <td>{{ $inventario->almacen->centroCosto->nombre ?? 'N/A' }}</td>
                                <td class="text-end">{{ number_format($inventario->stock_disponible, 2) }}</td>
                                <td class="text-end">{{ number_format($inventario->stock_reservado, 2) }}</td>
                                <td class="text-end">{{ number_format($inventario->stock_minimo, 2) }}</td>
                                <td>
                                    <a href="{{ route('admin.inventario.kardex', $inventario) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-history"></i> Kardex
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center py-4">No se encontraron registros</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Paginación -->
                <div class="d-flex justify-content-end mt-3">
                    {{ $inventarios->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializar selects con clases para mejor UI
        if (typeof $ !== 'undefined' && $.fn.select2) {
            $('#tipo, #almacen_id, #centro_costo_id').select2({
                theme: 'bootstrap-5',
                width: '100%'
            });
        }
        
        // Para formularios sin AJAX
        // Los selects ya tienen el atributo onchange para enviar automáticamente
        
        // Para búsqueda con Enter
        document.getElementById('search').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                document.getElementById('filterForm').submit();
            }
        });
    });
</script>
@endpush