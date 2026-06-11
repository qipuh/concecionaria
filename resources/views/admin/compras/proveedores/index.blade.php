@extends('admin.layouts.app')

@section('title', 'Proveedores')

@section('header', 'Proveedores')

@section('content')
<div class="dashboard-hero" style="padding: 2rem 2rem; border-radius: 0 0 1.5rem 1.5rem; margin-bottom: 2.5rem;">
    <div class="hero-glow-alt" style="top: -50px; right: 0; filter: blur(60px); opacity: 0.2;"></div>
    <div class="container-fluid position-relative z-1">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center">
            <div class="mb-3 mb-lg-0">
                <div class="d-inline-flex align-items-center px-3 py-1 bg-white bg-opacity-10 rounded-pill fs-6 mb-3 border border-white border-opacity-25 backdrop-blur">
                    <i class="fas fa-truck text-info me-2"></i> Adquisiciones
                </div>
                <h2 class="fw-bold mb-1 tracking-tight text-white display-6 text-shadow-sm d-flex align-items-center">
                    Proveedores
                </h2>
                <p class="text-white-50 mb-0">Total registrados: <span id="total-proveedores">{{ $proveedores->total() }}</span> proveedores en el sistema.</p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('admin.compras.proveedores.create') }}" class="btn bg-white text-dark rounded-pill px-4 py-2 fw-bold shadow-sm transition hover:scale-105 border-0">
                    <i class="fas fa-plus text-primary me-2"></i> Agregar Proveedor
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid px-3 px-lg-4 position-relative" style="top: -3.5rem; z-index: 10;">

@if (session('success'))
    <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4 d-flex align-items-center gap-2 alert-dismissible fade show">
        <i class="fas fa-check-circle text-success"></i> {{ session('success') }}
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
    </div>
@endif
@if (session('error'))
    <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4 d-flex align-items-center gap-2 alert-dismissible fade show">
        <i class="fas fa-exclamation-circle text-danger"></i> {{ session('error') }}
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- Filtros --}}
<div class="card dashboard-card border-0 shadow-sm mb-4">
    <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
        <h6 class="fw-bold mb-0"><i class="fas fa-filter me-2 text-primary"></i> Filtros</h6>
    </div>
    <div class="card-body p-4">
        <form id="filter-form" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label for="search" class="form-label fw-semibold small text-uppercase text-muted">Buscar</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-0 text-muted"><i class="fas fa-search small"></i></span>
                    <input type="text" name="search" id="search"
                           class="form-control bg-light border-0 ps-0 filter-input"
                           placeholder="Nro. documento o proveedor..."
                           value="{{ request('search') }}">
                    <button type="button" class="btn btn-light border-0 text-muted" id="clear-search" title="Limpiar">
                        <i class="fas fa-times small"></i>
                    </button>
                </div>
            </div>
            <div class="col-md-2">
                <label for="categoria_proveedor_id" class="form-label fw-semibold small text-uppercase text-muted">Categoría</label>
                <select name="categoria_proveedor_id" id="categoria_proveedor_id" class="form-select filter-input">
                    <option value="">Todas</option>
                    @foreach ($categorias as $categoria)
                        <option value="{{ $categoria->id }}" {{ request('categoria_proveedor_id') == $categoria->id ? 'selected' : '' }}>
                            {{ $categoria->nombre_categoria_proveedor }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label for="tipo_documento" class="form-label fw-semibold small text-uppercase text-muted">Tipo Doc.</label>
                <select name="tipo_documento" id="tipo_documento" class="form-select filter-input">
                    <option value="">Todos</option>
                    <option value="DNI" {{ request('tipo_documento') == 'DNI' ? 'selected' : '' }}>DNI</option>
                    <option value="RUC" {{ request('tipo_documento') == 'RUC' ? 'selected' : '' }}>RUC</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold small text-uppercase text-muted d-block">Cubre Garantías</label>
                <div class="form-check form-switch mt-1">
                    <input class="form-check-input filter-input" type="checkbox" name="cubre_garantias"
                           id="cubre_garantias" value="Sí" {{ request('cubre_garantias') == 'Sí' ? 'checked' : '' }}>
                    <label class="form-check-label" for="cubre_garantias" id="cubre_garantias_label">
                        {{ request('cubre_garantias') == 'Sí' ? 'Sí' : 'No' }}
                    </label>
                </div>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold small text-uppercase text-muted d-block">Es Aseguradora</label>
                <div class="form-check form-switch mt-1">
                    <input class="form-check-input filter-input" type="checkbox" name="es_aseguradora"
                           id="es_aseguradora" value="Sí" {{ request('es_aseguradora') == 'Sí' ? 'checked' : '' }}>
                    <label class="form-check-label" for="es_aseguradora" id="es_aseguradora_label">
                        {{ request('es_aseguradora') == 'Sí' ? 'Sí' : 'No' }}
                    </label>
                </div>
            </div>
            <div class="col-md-1 text-end">
                <a href="{{ route('admin.compras.proveedores.index') }}"
                   class="btn btn-outline-secondary rounded-pill px-3 py-2 small fw-semibold border-0">
                    <i class="fas fa-redo me-1"></i> Limpiar
                </a>
            </div>
        </form>
    </div>
</div>

{{-- Tabla --}}
<div class="card dashboard-card border-0 shadow-sm mb-4">
    <div class="card-header bg-white border-0 pt-4 pb-0 px-4 d-flex align-items-center justify-content-between">
        <h6 class="fw-bold mb-0"><i class="fas fa-list me-2 text-primary"></i> Proveedores</h6>
        <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-1 small" id="total-badge">
            <span id="total-proveedores">{{ $proveedores->total() }}</span> registros
        </span>
    </div>
    <div class="card-body p-0" id="proveedores-table">
        @include('admin.compras.proveedores.partials.table')
    </div>
</div>

<div class="px-4 py-3" id="proveedores-pagination">
    @include('admin.compras.proveedores.partials.pagination')
</div>

</div>

<!-- Contenedor para los modales -->
<div id="proveedores-modals">
    @include('admin.compras.proveedores.partials.table-modals')
</div>

@endsection

@push('styles')
<style>
.form-check-input { width: 2.5em; height: 1.25em; }
.form-check-label  { margin-left: 0.5em; }
#proveedores-table { position: relative; }
.loading-overlay {
    position: absolute; top: 0; left: 0; width: 100%; height: 100%;
    background: rgba(255,255,255,0.75); display: none;
    justify-content: center; align-items: center; z-index: 10;
}
</style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Función para aplicar los filtros con AJAX
            function applyFilters(page = 1) {
                const form = document.getElementById('filter-form');
                const formData = new FormData(form);
                formData.append('page', page);

                // Mostrar overlay de carga
                const tableContainer = document.getElementById('proveedores-table');
                let loadingOverlay = tableContainer.querySelector('.loading-overlay');
                if (!loadingOverlay) {
                    loadingOverlay = document.createElement('div');
                    loadingOverlay.className = 'loading-overlay';
                    loadingOverlay.innerHTML = '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Cargando...</span></div>';
                    tableContainer.appendChild(loadingOverlay);
                }
                loadingOverlay.style.display = 'flex';

                fetch('{{ route('admin.compras.proveedores.index') }}', {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                    body: new URLSearchParams(formData).toString(),
                })
                .then(response => response.json())
                .then(data => {
                    // Actualizar la tabla
                    document.getElementById('proveedores-table').innerHTML = data.table;
                    // Actualizar la paginación
                    document.getElementById('proveedores-pagination').innerHTML = data.pagination;
                    // Actualizar los modales
                    let modalsContainer = document.getElementById('proveedores-modals');
                    if (!modalsContainer) {
                        modalsContainer = document.createElement('div');
                        modalsContainer.id = 'proveedores-modals';
                        document.body.appendChild(modalsContainer);
                    }
                    modalsContainer.innerHTML = data.modals;
                    // Actualizar el total de proveedores
                    document.getElementById('total-proveedores').textContent = data.total;
                    // Ocultar overlay de carga
                    loadingOverlay.style.display = 'none';

                    // Reasignar eventos a los botones de paginación
                    assignPaginationEvents();
                    // Reasignar eventos a los botones de los modales
                    assignModalEvents();
                })
                .catch(error => {
                    console.error('Error al aplicar los filtros:', error);
                    loadingOverlay.style.display = 'none';
                });
            }

            // Función para asignar eventos a los botones de paginación
            function assignPaginationEvents() {
                document.querySelectorAll('#proveedores-pagination a').forEach(link => {
                    link.addEventListener('click', function (e) {
                        e.preventDefault();
                        const url = new URL(this.href);
                        const page = url.searchParams.get('page') || 1;
                        applyFilters(page);
                    });
                });
            }

            // Función para asignar eventos a los botones de los modales
            function assignModalEvents() {
                document.querySelectorAll('.edit-cuenta-btn').forEach(button => {
                    button.addEventListener('click', function () {
                        const cuentaItem = this.closest('.list-group-item');
                        const cuentaId = cuentaItem.dataset.cuentaId;
                        const proveedorId = this.closest('.modal').id.replace('cuentaModal', '');

                        fetch(`{{ url('admin/compras/proveedores') }}/${proveedorId}/cuentas/${cuentaId}/edit`)
                            .then(response => response.json())
                            .then(data => {
                                const cuenta = data.cuenta;
                                const form = document.getElementById(`cuenta-form-${proveedorId}`);
                                const formTitle = document.getElementById(`form-title-${proveedorId}`);
                                const formMethod = document.getElementById(`form-method-${proveedorId}`);
                                const cuentaIdInput = document.getElementById(`cuenta-id-${proveedorId}`);

                                form.action = `{{ url('admin/compras/proveedores') }}/${proveedorId}/cuentas/${cuentaId}`;
                                formMethod.value = 'PUT';
                                cuentaIdInput.value = cuentaId;
                                formTitle.textContent = 'Editar Cuenta';

                                document.getElementById(`banco_id_${proveedorId}`).value = cuenta.banco_id;
                                document.getElementById(`moneda_${proveedorId}`).value = cuenta.moneda;
                                document.getElementById(`tipo_cuenta_${proveedorId}`).value = cuenta.tipo_cuenta;
                                document.getElementById(`numero_cuenta_${proveedorId}`).value = cuenta.numero_cuenta;
                                document.getElementById(`cci_${proveedorId}`).value = cuenta.cci;
                            })
                            .catch(error => {
                                console.error('Error al cargar los datos de la cuenta:', error);
                                alert('Error al cargar los datos de la cuenta. Por favor, intenta de nuevo.');
                            });
                    });
                });

                document.querySelectorAll('.delete-cuenta-form').forEach(form => {
                    form.addEventListener('submit', function (event) {
                        if (!confirm('¿Estás seguro de eliminar esta cuenta?')) {
                            event.preventDefault();
                        }
                    });
                });
            }

            // Escuchar cambios en los filtros
            const filterInputs = document.querySelectorAll('.filter-input');
            filterInputs.forEach(input => {
                if (input.type === 'text') {
                    // Para el campo de búsqueda, usamos un debounce para evitar múltiples solicitudes
                    let timeout;
                    input.addEventListener('input', function () {
                        clearTimeout(timeout);
                        timeout = setTimeout(() => {
                            applyFilters();
                        }, 500); // 500ms de retraso
                    });
                } else {
                    // Para los switches y selects, aplicamos el filtro inmediatamente
                    input.addEventListener('change', function () {
                        applyFilters();
                    });
                }
            });

            // Actualizar etiquetas de los switches en tiempo real
            document.querySelectorAll('.form-check-input').forEach(switchInput => {
                switchInput.addEventListener('change', function () {
                    const label = this.nextElementSibling;
                    label.textContent = this.checked ? 'Sí' : 'No';
                });
            });

            // Limpiar el campo de búsqueda
            document.getElementById('clear-search').addEventListener('click', function () {
                document.getElementById('search').value = '';
                applyFilters();
            });

            // Validación del formulario de cuentas
            const forms = document.querySelectorAll('.needs-validation');
            forms.forEach(form => {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });

            // Resetear el formulario al hacer clic en "Cancelar"
            document.querySelectorAll('.reset-form-btn').forEach(button => {
                button.addEventListener('click', function () {
                    const proveedorId = this.closest('.modal').id.replace('cuentaModal', '');
                    const form = document.getElementById(`cuenta-form-${proveedorId}`);
                    const formTitle = document.getElementById(`form-title-${proveedorId}`);
                    const formMethod = document.getElementById(`form-method-${proveedorId}`);
                    const cuentaIdInput = document.getElementById(`cuenta-id-${proveedorId}`);

                    form.reset();
                    form.action = `{{ url('admin/compras/proveedores') }}/${proveedorId}/cuentas`;
                    formMethod.value = 'POST';
                    cuentaIdInput.value = '';
                    formTitle.textContent = 'Agregar Nueva Cuenta';
                    form.classList.remove('was-validated');
                });
            });

            // Asignar eventos iniciales a los botones de paginación y modales
            assignPaginationEvents();
            assignModalEvents();
        });
    </script>
@endpush