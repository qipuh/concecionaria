@extends('admin.layouts.app')

@section('title', 'Proveedores')

@section('header', 'Proveedores')

@section('content')
<div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center mb-4">
    <div class="mb-3 mb-sm-0">
        <h2 class="h4 fw-bold mb-1" :class="darkMode ? 'text-light' : 'text-dark'">
            Total de Proveedores: <span id="total-proveedores">{{ $proveedores->total() }}</span>
        </h2>
        <p class="text-muted small mb-0">Gestiona los proveedores desde aquí</p>
    </div>
    <div>
        <a href="{{ route('admin.compras.proveedores.create') }}" class="btn btn-primary d-flex align-items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="me-2" style="height: 1rem; width: 1rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Agregar Proveedor
        </a>
    </div>
</div>

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

<!-- Formulario de Filtros -->
<div class="card mb-4">
    <div class="card-body">
        <form id="filter-form" class="row g-3">
            <div class="col-md-1">
                <label for="cubre_garantias" class="form-label small text-muted">¿Cubre Garantías?</label>
                <div class="form-check form-switch">
                    <input class="form-check-input filter-input" type="checkbox" name="cubre_garantias" id="cubre_garantias" value="Sí" {{ request('cubre_garantias') == 'Sí' ? 'checked' : '' }}>
                    <label class="form-check-label" for="cubre_garantias" id="cubre_garantias_label">
                        {{ request('cubre_garantias') == 'Sí' ? 'Sí' : 'No' }}
                    </label>
                </div>
            </div>
            <div class="col-md-1">
                <label for="es_aseguradora" class="form-label small text-muted">¿Es Aseguradora?</label>
                <div class="form-check form-switch">
                    <input class="form-check-input filter-input" type="checkbox" name="es_aseguradora" id="es_aseguradora" value="Sí" {{ request('es_aseguradora') == 'Sí' ? 'checked' : '' }}>
                    <label class="form-check-label" for="es_aseguradora" id="es_aseguradora_label">
                        {{ request('es_aseguradora') == 'Sí' ? 'Sí' : 'No' }}
                    </label>
                </div>
            </div>
            <div class="col-md-2">
                <label for="categoria_proveedor_id" class="form-label small text-muted">Categoría</label>
                <select name="categoria_proveedor_id" id="categoria_proveedor_id" class="form-select form-select-sm filter-input">
                    <option value="">Todas</option>
                    @foreach ($categorias as $categoria)
                        <option value="{{ $categoria->id }}" {{ request('categoria_proveedor_id') == $categoria->id ? 'selected' : '' }}>
                            {{ $categoria->nombre_categoria_proveedor }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label for="tipo_documento" class="form-label small text-muted">Tipo de Documento</label>
                <select name="tipo_documento" id="tipo_documento" class="form-select form-select-sm filter-input">
                    <option value="">Todos</option>
                    <option value="DNI" {{ request('tipo_documento') == 'DNI' ? 'selected' : '' }}>DNI</option>
                    <option value="RUC" {{ request('tipo_documento') == 'RUC' ? 'selected' : '' }}>RUC</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="search" class="form-label small text-muted">Buscar por Nro. Documento o Proveedor</label>
                <div class="input-group input-group-sm">
                    <input type="text" name="search" id="search" class="form-control filter-input" placeholder="Buscar..." value="{{ request('search') }}">
                    <button type="button" class="btn btn-primary" id="clear-search">
                        <svg xmlns="http://www.w3.org/2000/svg" style="height: 1rem; width: 1rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="col-md-3 text-end">
                <a href="{{ route('admin.compras.proveedores.index') }}" class="btn btn-sm btn-outline-secondary mt-3">Limpiar Filtros</a>
            </div>
        </form>
    </div>
</div>

<div class="table-responsive" id="proveedores-table">
    @include('admin.compras.proveedores.partials.table')
</div>

<div class="mt-4" id="proveedores-pagination">
    @include('admin.compras.proveedores.partials.pagination')
</div>
@endsection

@push('styles')
    <style>
        .form-check-input {
            width: 2.5em;
            height: 1.25em;
        }
        .form-check-label {
            margin-left: 0.5em;
        }
        .table-responsive {
            position: relative;
        }
        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 10;
            display: none;
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