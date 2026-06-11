@extends('admin.layouts.app')

@section('title', 'Catálogo de Vehículos')

@section('content')
<div class="dashboard-hero" style="padding: 2rem 2rem; border-radius: 0 0 1.5rem 1.5rem; margin-bottom: 2.5rem;">
    <div class="hero-glow-alt" style="top: -50px; right: 0; filter: blur(60px); opacity: 0.2;"></div>
    <div class="container-fluid position-relative z-1">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center">
            <div class="mb-3 mb-lg-0">
                <div class="d-inline-flex align-items-center px-3 py-1 bg-white bg-opacity-10 rounded-pill fs-6 mb-3 border border-white border-opacity-25 backdrop-blur">
                    <i class="fas fa-car text-info me-2"></i> Gestión de Productos
                </div>
                <h2 class="fw-bold mb-1 tracking-tight text-white display-6 text-shadow-sm d-flex align-items-center">
                    Catálogo de Vehículos
                </h2>
                <p class="text-white-50 mb-0">Administra marcas, modelos, versiones y características técnicas</p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('admin.productos-servicios.vehiculos.import.form') }}" class="btn bg-white bg-opacity-10 text-white rounded-pill px-4 py-2 fw-bold shadow-sm transition hover:scale-105 border border-white border-opacity-25 backdrop-blur me-2">
                    <i class="fas fa-file-excel me-2"></i> Importar Datos
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid px-3 px-lg-4 position-relative" style="top: -3.5rem; z-index: 10;">
    <div class="card dashboard-card border-0 shadow-sm mb-4">
        <div class="card-body p-0">
            <!-- Pestañas Modernas -->
            <ul class="nav nav-tabs nav-fill border-0 premium-tabs" id="vehiculosTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link fw-bold py-3 {{ !session('success') && !session('error') ? 'active' : '' }}" id="vehiculoscat-tab" data-bs-toggle="tab" data-bs-target="#vehiculoscat"
                       href="{{ route('admin.productos-servicios.vehiculos.caracteristicas.vehiculo.index') }}" type="button" role="tab">
                       <i class="fas fa-car-side me-2"></i> Catálogo
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link fw-bold py-3" id="marcas-tab" data-bs-toggle="tab" data-bs-target="#marcas" 
                       href="{{ route('admin.productos-servicios.vehiculos.caracteristicas.marcas.index') }}" type="button" role="tab">
                       <i class="fas fa-copyright me-2"></i> Marcas
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link fw-bold py-3" id="modelos-tab" data-bs-toggle="tab" data-bs-target="#modelos" 
                       href="{{ route('admin.productos-servicios.vehiculos.caracteristicas.modelos.index') }}" type="button" role="tab">
                       <i class="fas fa-tags me-2"></i> Modelos
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link fw-bold py-3" id="versiones-tab" data-bs-toggle="tab" data-bs-target="#versiones" 
                       href="{{ route('admin.productos-servicios.vehiculos.caracteristicas.versiones.index') }}" type="button" role="tab">
                       <i class="fas fa-code-branch me-2"></i> Versiones
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link fw-bold py-3" id="anios-modelo-tab" data-bs-toggle="tab" data-bs-target="#anios-modelo" 
                       href="{{ route('admin.productos-servicios.vehiculos.caracteristicas.anios-modelo.index') }}" type="button" role="tab">
                       <i class="fas fa-calendar-alt me-2"></i> Años
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link fw-bold py-3" id="colores-tab" data-bs-toggle="tab" data-bs-target="#colores" 
                       href="{{ route('admin.productos-servicios.vehiculos.caracteristicas.colores.index') }}" type="button" role="tab">
                       <i class="fas fa-palette me-2"></i> Colores
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link fw-bold py-3 {{ session('success') || session('error') ? 'active' : '' }}" id="importar-tab" data-bs-toggle="tab" data-bs-target="#importar"
                       href="{{ route('admin.productos-servicios.vehiculos.import.form') }}" type="button" role="tab">
                       <i class="fas fa-file-import me-2"></i> Importar
                    </a>
                </li>
            </ul>

            <div class="p-4">
                <!-- Contenido de las Pestañas -->
                <div class="tab-content" id="vehiculosTabContent">
                    <!-- Vehículos Catálogo -->
                    <div class="tab-pane fade {{ !session('success') && !session('error') ? 'show active' : '' }}" id="vehiculoscat" role="tabpanel">
                        <div id="vehiculoscat-content">
                            <div class="text-center py-5">
                                <div class="spinner-border text-primary mb-3" role="status"></div>
                                <p class="text-muted">Cargando catálogo...</p>
                            </div>
                        </div>
                    </div>
                    <!-- Marcas -->
                    <div class="tab-pane fade" id="marcas" role="tabpanel">
                        <div id="marcas-content"></div>
                    </div>
                    <!-- Modelos -->
                    <div class="tab-pane fade" id="modelos" role="tabpanel">
                        <div id="modelos-content"></div>
                    </div>
                    <!-- Versiones -->
                    <div class="tab-pane fade" id="versiones" role="tabpanel">
                        <div id="versiones-content"></div>
                    </div>
                    <!-- Años de Modelo -->
                    <div class="tab-pane fade" id="anios-modelo" role="tabpanel">
                        <div id="anios-modelo-content"></div>
                    </div>
                    <!-- Colores -->
                    <div class="tab-pane fade" id="colores" role="tabpanel">
                        <div id="colores-content"></div>
                    </div>
                    <!-- Importar Excel -->
                    <div class="tab-pane fade {{ session('success') || session('error') ? 'show active' : '' }}" id="importar" role="tabpanel">
                        <div id="importar-content">
                            @if (session('success'))
                                <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">
                                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                                </div>
                            @endif
                            @if (session('error'))
                                <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4">
                                    <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
                                </div>
                            @endif

                            <div class="row g-3 mb-4">
                                <!-- Subida -->
                                <div class="col-lg-5">
                                    <div class="card bg-light border-0 rounded-4 h-100">
                                        <div class="card-body p-4">
                                            <h5 class="fw-bold mb-3 d-flex align-items-center text-primary">
                                                <i class="fas fa-cloud-upload-alt me-2"></i> Subida de Archivo
                                            </h5>
                                            <form id="importForm" action="{{ route('admin.productos-servicios.vehiculos.import') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="file" class="form-label small text-muted text-uppercase fw-bold mb-2">Seleccionar archivo Excel (.xlsx, .xls)</label>
                                                    <input type="file" name="file" id="file" accept=".xlsx,.xls" class="form-control rounded-3 shadow-sm border-0 @error('file') is-invalid @enderror">
                                                    @error('file')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <button type="submit" class="btn btn-primary rounded-pill w-100 fw-bold py-2 shadow-sm border-0 mb-3">
                                                    <i class="fas fa-file-import me-2"></i> Procesar Importación
                                                </button>
                                            </form>
                                            <a href="{{ route('admin.productos-servicios.vehiculos.import.template') }}" class="btn btn-outline-success rounded-pill w-100 fw-bold py-2 border-2">
                                                <i class="fas fa-file-excel me-2"></i> Descargar Plantilla Excel
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Guía -->
                                <div class="col-lg-7">
                                    <div class="card border-light rounded-4 h-100">
                                        <div class="card-body p-4">
                                            <h5 class="fw-bold mb-3 text-dark">
                                                <i class="fas fa-info-circle text-info me-2"></i> Guía de Formato Excel
                                            </h5>
                                            <p class="text-muted small mb-3">Tu archivo debe tener las siguientes columnas (usa la plantilla como base):</p>
                                            <div class="row g-2">
                                                <div class="col-md-6">
                                                    <ul class="list-group list-group-flush rounded-3 overflow-hidden border">
                                                        <li class="list-group-item small py-2"><span class="badge bg-primary-subtle text-primary me-1">1</span><strong>Fecha de compra</strong>: YYYY-MM-DD</li>
                                                        <li class="list-group-item small py-2"><span class="badge bg-primary-subtle text-primary me-1">2</span><strong>Precio compra</strong>: Decimal (ej. 25000.50)</li>
                                                        <li class="list-group-item small py-2"><span class="badge bg-primary-subtle text-primary me-1">3</span><strong>Nro de factura</strong>: Texto</li>
                                                        <li class="list-group-item small py-2"><span class="badge bg-primary-subtle text-primary me-1">4</span><strong>Marca</strong>: Nombre de marca</li>
                                                        <li class="list-group-item small py-2"><span class="badge bg-primary-subtle text-primary me-1">5</span><strong>Modelo</strong>: Nombre de modelo</li>
                                                    </ul>
                                                </div>
                                                <div class="col-md-6">
                                                    <ul class="list-group list-group-flush rounded-3 overflow-hidden border">
                                                        <li class="list-group-item small py-2"><span class="badge bg-primary-subtle text-primary me-1">6</span><strong>Version</strong>: Nombre de versión</li>
                                                        <li class="list-group-item small py-2"><span class="badge bg-primary-subtle text-primary me-1">7</span><strong>Año</strong>: Año (ej. 2023)</li>
                                                        <li class="list-group-item small py-2"><span class="badge bg-primary-subtle text-primary me-1">8</span><strong>Serie VIN</strong>: Código VIN (único)</li>
                                                        <li class="list-group-item small py-2"><span class="badge bg-primary-subtle text-primary me-1">9</span><strong>Color</strong>: Nombre del color</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Previsualización -->
                            <div id="preview-section" class="d-none">
                                <div class="card border-0 shadow-sm rounded-4">
                                    <div class="card-header bg-white border-0 rounded-top-4 pt-4 pb-2 px-4 d-flex align-items-center justify-content-between">
                                        <h5 class="fw-bold mb-0 text-dark">
                                            <i class="fas fa-eye text-primary me-2"></i> Previsualización del archivo
                                        </h5>
                                        <span id="preview-count" class="badge bg-primary-subtle text-primary rounded-pill fs-6"></span>
                                    </div>
                                    <div class="card-body p-0 pb-3">
                                        <div id="preview-errors" class="mx-4 mt-3 d-none"></div>
                                        <div class="table-responsive px-4 mt-3">
                                            <table class="table table-sm table-hover align-middle border rounded-3 overflow-hidden" id="preview-table">
                                                <thead class="table-primary">
                                                    <tr id="preview-head"></tr>
                                                </thead>
                                                <tbody id="preview-body"></tbody>
                                            </table>
                                        </div>
                                        <p class="text-muted small px-4 mb-0"><i class="fas fa-info-circle me-1"></i> Se muestran hasta las primeras 10 filas. Las filas con errores se marcan en rojo.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .premium-tabs .nav-link {
        color: #6c757d;
        border: none;
        border-bottom: 3px solid transparent;
        transition: all 0.3s ease;
    }
    .premium-tabs .nav-link:hover {
        background-color: rgba(0, 123, 255, 0.05);
        color: #0d6efd;
    }
    .premium-tabs .nav-link.active {
        color: #0d6efd;
        background-color: transparent;
        border-bottom-color: #0d6efd;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const REQUIRED_COLS = ['Fecha de compra','Precio compra','Nro de factura','Marca','Modelo','Version','Año','Serie VIN','Color'];
    const hasFlash = {{ session('success') || session('error') ? 'true' : 'false' }};

    // Si hay mensaje flash, activar pestaña importar
    if (hasFlash) {
        activateTab('importar');
    } else {
        loadTabContent('vehiculoscat');
    }

    // Manejar clics en las pestañas
    document.querySelectorAll('#vehiculosTab a').forEach(function(tab) {
        tab.addEventListener('click', function(e) {
            e.preventDefault();
            let tabId = this.getAttribute('id').replace('-tab', '');
            activateTab(tabId);
            if (tabId !== 'importar') {
                loadTabContent(tabId);
            }
        });
    });

    function activateTab(tabId) {
        document.querySelectorAll('#vehiculosTab a').forEach(function(t) {
            t.classList.remove('active');
            let panel = document.querySelector(t.getAttribute('data-bs-target'));
            if (panel) panel.classList.remove('show', 'active');
        });
        let activeTab = document.getElementById(tabId + '-tab');
        if (activeTab) activeTab.classList.add('active');
        let activePanel = document.getElementById(tabId);
        if (activePanel) activePanel.classList.add('show', 'active');
    }

    function loadTabContent(tabId) {
        let contentContainer = document.getElementById(tabId + '-content');
        contentContainer.innerHTML = '<div class="text-center py-5"><div class="spinner-border text-primary mb-3" role="status"></div><p class="text-muted">Cargando...</p></div>';
        let url = document.getElementById(tabId + '-tab').getAttribute('href');

        fetch(url)
            .then(response => {
                if (!response.ok) throw new Error('Error al cargar datos del servidor');
                return response.text();
            })
            .then(html => {
                let tempDiv = document.createElement('div');
                tempDiv.innerHTML = html;
                let mainContent = tempDiv.querySelector('.card-body') || tempDiv.querySelector('.container') || tempDiv.querySelector('#app');
                if (mainContent) {
                    mainContent.querySelectorAll('script').forEach(s => s.remove());
                    contentContainer.innerHTML = mainContent.innerHTML;
                } else {
                    tempDiv.querySelector('head')?.remove();
                    contentContainer.innerHTML = tempDiv.innerHTML;
                }
                if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
                    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => new bootstrap.Tooltip(el));
                }
            })
            .catch(error => {
                contentContainer.innerHTML = '<div class="alert alert-danger border-0 rounded-4 shadow-sm"><i class="fas fa-exclamation-circle me-2"></i> No se pudo cargar la información: ' + error.message + '</div>';
            });
    }

    // Previsualización del archivo Excel
    document.getElementById('file').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) {
            document.getElementById('preview-section').classList.add('d-none');
            return;
        }

        const reader = new FileReader();
        reader.onload = function(evt) {
            try {
                const wb = XLSX.read(evt.target.result, { type: 'binary', cellDates: true });
                const ws = wb.Sheets[wb.SheetNames[0]];
                const data = XLSX.utils.sheet_to_json(ws, { header: 1, raw: false, dateNF: 'YYYY-MM-DD' });

                if (!data || data.length < 2) {
                    showPreviewError('El archivo está vacío o no tiene datos suficientes.');
                    return;
                }

                const headers = data[0];
                const rows = data.slice(1).filter(r => r.some(c => c !== '' && c != null));

                // Validar columnas
                const missingCols = REQUIRED_COLS.filter(col => !headers.includes(col));
                const errorsEl = document.getElementById('preview-errors');

                if (missingCols.length > 0) {
                    errorsEl.className = 'mx-4 mt-3 alert alert-warning border-0 rounded-3 small';
                    errorsEl.innerHTML = '<i class="fas fa-exclamation-triangle me-2"></i><strong>Columnas faltantes:</strong> ' + missingCols.join(', ');
                } else {
                    errorsEl.className = 'mx-4 mt-3 d-none';
                    errorsEl.innerHTML = '';
                }

                // Renderizar encabezados
                const thead = document.getElementById('preview-head');
                thead.innerHTML = headers.map(h => `<th class="small px-3 py-2">${h || ''}</th>`).join('');

                // Renderizar filas (máximo 10)
                const tbody = document.getElementById('preview-body');
                const previewRows = rows.slice(0, 10);
                tbody.innerHTML = previewRows.map((row, idx) => {
                    const rowErrors = validateRow(row, headers);
                    const rowClass = rowErrors.length > 0 ? 'table-danger' : '';
                    const cells = headers.map((h, i) => {
                        const val = row[i] !== undefined ? row[i] : '';
                        return `<td class="small px-3 py-1">${val}</td>`;
                    }).join('');
                    const tooltip = rowErrors.length > 0 ? ` title="${rowErrors.join('; ')}" data-bs-toggle="tooltip"` : '';
                    return `<tr class="${rowClass}"${tooltip}>${cells}</tr>`;
                }).join('');

                // Reiniciar tooltips
                if (typeof bootstrap !== 'undefined') {
                    document.querySelectorAll('#preview-body [data-bs-toggle="tooltip"]').forEach(el => new bootstrap.Tooltip(el));
                }

                document.getElementById('preview-count').textContent = rows.length + ' fila(s) detectada(s)';
                document.getElementById('preview-section').classList.remove('d-none');

            } catch (err) {
                showPreviewError('No se pudo leer el archivo: ' + err.message);
            }
        };
        reader.readAsBinaryString(file);
    });

    function validateRow(row, headers) {
        const errors = [];
        const get = (col) => row[headers.indexOf(col)];

        const fecha = get('Fecha de compra');
        if (!fecha || !/^\d{4}-\d{2}-\d{2}$/.test(fecha)) errors.push('Fecha inválida (use YYYY-MM-DD)');

        const precio = get('Precio compra');
        if (!precio || isNaN(parseFloat(precio))) errors.push('Precio compra inválido');

        const nroFac = get('Nro de factura');
        if (!nroFac || String(nroFac).trim() === '') errors.push('Nro de factura requerido');

        ['Marca','Modelo','Version','Color'].forEach(col => {
            if (!get(col) || String(get(col)).trim() === '') errors.push(`${col} requerido`);
        });

        const anio = get('Año');
        const anioNum = parseInt(anio);
        if (!anio || isNaN(anioNum) || anioNum < 1900 || anioNum > new Date().getFullYear() + 1) errors.push('Año inválido');

        const vin = get('Serie VIN');
        if (!vin || String(vin).trim() === '') errors.push('Serie VIN requerido');

        return errors;
    }

    function showPreviewError(msg) {
        const errorsEl = document.getElementById('preview-errors');
        errorsEl.className = 'mx-4 mt-3 alert alert-danger border-0 rounded-3 small';
        errorsEl.innerHTML = '<i class="fas fa-times-circle me-2"></i>' + msg;
        document.getElementById('preview-head').innerHTML = '';
        document.getElementById('preview-body').innerHTML = '';
        document.getElementById('preview-count').textContent = '';
        document.getElementById('preview-section').classList.remove('d-none');
    }
});
</script>
@endpush
@endsection