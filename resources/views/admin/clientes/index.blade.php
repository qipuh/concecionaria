@extends('admin.layouts.app')

@section('title', 'Clientes')

@section('header', 'Gestión de Clientes')

@section('content')
<div class="row">
    <div class="col-12">
        <!-- Panel principal -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <!-- Header con botón de acción -->
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center mb-4">
                    <div class="mb-3 mb-sm-0">
                        <h2 class="h4 fw-bold mb-1" :class="darkMode ? 'text-light' : 'text-dark'">
                            Total de Clientes: <span id="total-clientes">{{ $totalClientes }}</span>
                        </h2>
                        <p class="text-muted small mb-0">Gestiona la información de tus clientes desde aquí</p>
                    </div>
                    <div>
                        <a href="{{ route('admin.clientes.create') }}" class="btn btn-primary d-flex align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="me-2" style="height: 1rem; width: 1rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Agregar Cliente
                        </a>
                    </div>
                </div>

                <!-- Filtros con diseño mejorado -->
                <div class="card mb-4 border-0 bg-light" :class="darkMode ? 'bg-dark-subtle text-light' : ''">
                    <div class="card-body p-3">
                        <h6 class="fw-semibold mb-3 small" :class="darkMode ? 'text-light' : 'text-dark'">
                            Filtros de búsqueda
                        </h6>
                        <div id="filtros-form">
                            <div class="row g-3">
                                <div class="col-md-6 col-lg-3">
                                    <label for="tipo_cliente" class="form-label small text-muted mb-1">Tipo de Cliente</label>
                                    <select id="tipo_cliente" name="tipo_cliente" class="form-select form-select-sm filtro-campo" :class="darkMode ? 'bg-dark-subtle text-light border-secondary' : ''">
                                        <option value="">Todos</option>
                                        <option value="natural" {{ request('tipo_cliente') == 'natural' ? 'selected' : '' }}>Persona Natural</option>
                                        <option value="juridica" {{ request('tipo_cliente') == 'juridica' ? 'selected' : '' }}>Persona Jurídica</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-6 col-lg-3">
                                    <label for="categoria_cliente_id" class="form-label small text-muted mb-1">Categoría</label>
                                    <select id="categoria_cliente_id" name="categoria_cliente_id" class="form-select form-select-sm filtro-campo" :class="darkMode ? 'bg-dark-subtle text-light border-secondary' : ''">
                                        <option value="">Todas</option>
                                        @foreach ($categorias as $categoria)
                                            <option value="{{ $categoria->id }}" {{ request('categoria_cliente_id') == $categoria->id ? 'selected' : '' }}>
                                                {{ $categoria->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="col-md-6 col-lg-3">
                                    <label for="canal_captacion_id" class="form-label small text-muted mb-1">Canal de Captación</label>
                                    <select id="canal_captacion_id" name="canal_captacion_id" class="form-select form-select-sm filtro-campo" :class="darkMode ? 'bg-dark-subtle text-light border-secondary' : ''">
                                        <option value="">Todos</option>
                                        @foreach ($canales as $canal)
                                            <option value="{{ $canal->id }}" {{ request('canal_captacion_id') == $canal->id ? 'selected' : '' }}>
                                                {{ $canal->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="col-md-6 col-lg-3">
                                    <label for="query" class="form-label small text-muted mb-1">Buscar</label>
                                    <input type="text" id="query" name="query" class="form-control form-control-sm filtro-campo" :class="darkMode ? 'bg-dark-subtle text-light border-secondary' : ''" placeholder="Documento, nombre..." value="{{ request('query') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mensaje de éxito (si existe) -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Tabla de clientes con diseño mejorado -->
                <div id="resultados-container">
                    @include('admin.clientes.partials.table', ['clientes' => $clientes])
                </div>

                <!-- Paginación -->
                <div id="pagination-container">
                    @include('admin.clientes.partials.pagination', ['clientes' => $clientes])
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Seleccionar todos los elementos de filtro
    const filtrosCampos = document.querySelectorAll('.filtro-campo');
    
    // Añadir listener para cada campo
    filtrosCampos.forEach(campo => {
        campo.addEventListener('change', function() {
            aplicarFiltros();
        });
        
        // Para el campo de búsqueda, añadir un retardo para no realizar peticiones con cada tecla
        if (campo.id === 'query') {
            campo.addEventListener('input', debounce(function() {
                aplicarFiltros();
            }, 500));
        }
    });
    
    // Función para aplicar los filtros con AJAX
    function aplicarFiltros() {
        // Mostrar indicador de carga
        document.getElementById('resultados-container').innerHTML = '<div class="text-center p-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Cargando...</span></div></div>';
        
        // Obtener los valores de los filtros
        const tipo_cliente = document.getElementById('tipo_cliente').value;
        const categoria_cliente_id = document.getElementById('categoria_cliente_id').value;
        const canal_captacion_id = document.getElementById('canal_captacion_id').value;
        const query = document.getElementById('query').value;
        
        // Construir la URL con los parámetros
        const url = `{{ route('admin.clientes.index') }}?tipo_cliente=${encodeURIComponent(tipo_cliente)}&categoria_cliente_id=${encodeURIComponent(categoria_cliente_id)}&canal_captacion_id=${encodeURIComponent(canal_captacion_id)}&query=${encodeURIComponent(query)}`;
        
        // Actualizar la URL del navegador sin recargar la página
        window.history.pushState({}, '', url);
        
        // Realizar la petición AJAX
        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            // Actualizar el contenido de la tabla
            document.getElementById('resultados-container').innerHTML = data.table;
            
            // Actualizar la paginación
            document.getElementById('pagination-container').innerHTML = data.pagination;
            
            // Actualizar el contador de clientes
            document.getElementById('total-clientes').textContent = data.totalClientes;
        })
        .catch(error => {
            console.error('Error al filtrar clientes:', error);
            document.getElementById('resultados-container').innerHTML = '<div class="alert alert-danger">Error al cargar los datos. Por favor, intente nuevamente.</div>';
        });
    }
    
    // Función debounce para evitar múltiples peticiones al escribir
    function debounce(func, wait) {
        let timeout;
        return function(...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), wait);
        };
    }
    
    // Manejar la paginación de forma dinámica (delegación de eventos)
    document.addEventListener('click', function(e) {
        // Verificar si se hizo clic en un enlace de paginación
        if (e.target.closest('.pagination a')) {
            e.preventDefault();
            const url = e.target.closest('.pagination a').href;
            
            // Realizar la petición AJAX a la página seleccionada
            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                // Actualizar el contenido de la tabla
                document.getElementById('resultados-container').innerHTML = data.table;
                
                // Actualizar la paginación
                document.getElementById('pagination-container').innerHTML = data.pagination;
                
                // Actualizar la URL del navegador
                window.history.pushState({}, '', url);
            })
            .catch(error => {
                console.error('Error al cambiar de página:', error);
            });
        }
    });
});
</script>
@endpush