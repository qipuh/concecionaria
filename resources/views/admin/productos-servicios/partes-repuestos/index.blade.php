@extends('admin.layouts.app')

@section('title', 'Catálogo de Partes')

@section('content')
<div class="dashboard-hero" style="padding: 2rem 2rem; border-radius: 0 0 1.5rem 1.5rem; margin-bottom: 2.5rem;">
    <div class="hero-glow-alt" style="top: -50px; right: 0; filter: blur(60px); opacity: 0.2;"></div>
    <div class="container-fluid position-relative z-1">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center">
            <div class="mb-3 mb-lg-0">
                <div class="d-inline-flex align-items-center px-3 py-1 bg-white bg-opacity-10 rounded-pill fs-6 mb-3 border border-white border-opacity-25 backdrop-blur">
                    <i class="fas fa-cog text-info me-2"></i> Inventario de Partes
                </div>
                <h2 class="fw-bold mb-1 tracking-tight text-white display-6 text-shadow-sm d-flex align-items-center">
                    Catálogo de Partes
                </h2>
                <p class="text-white-50 mb-0">Total de registros: {{ $totalPartes }}</p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('admin.almacenes.partes.create') }}" class="btn bg-white text-dark rounded-pill px-4 py-2 fw-bold shadow-sm transition hover:scale-105 border-0">
                    <i class="fas fa-plus text-primary me-2"></i> Agregar Parte
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid px-3 px-lg-4 position-relative" style="top: -3.5rem; z-index: 10;">
    <div class="card dashboard-card border-0 shadow-sm mb-4">
        <div class="card-body p-0">

            <!-- Pestañas -->
            <ul class="nav nav-tabs nav-fill border-0 premium-tabs" id="partesTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link fw-bold py-3 {{ !session('success') && !session('error') ? 'active' : '' }}" id="lista-tab"
                       data-bs-target="#lista" type="button" role="tab">
                        <i class="fas fa-list me-2"></i> Lista de Partes
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link fw-bold py-3 {{ session('success') || session('error') ? 'active' : '' }}" id="importar-tab"
                       data-bs-target="#importar" type="button" role="tab">
                        <i class="fas fa-file-import me-2"></i> Importar
                    </a>
                </li>
            </ul>

            <div class="tab-content" id="partesTabContent">

                <!-- Lista -->
                <div class="tab-pane fade {{ !session('success') && !session('error') ? 'show active' : '' }} p-4" id="lista" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="py-3 px-4 border-0 text-uppercase small">#</th>
                                    <th class="py-3 px-4 border-0 text-uppercase small">Código</th>
                                    <th class="py-3 px-4 border-0 text-uppercase small">Nombre</th>
                                    <th class="py-3 px-4 border-0 text-uppercase small">Unidad</th>
                                    <th class="py-3 px-4 border-0 text-uppercase small">Fabricante</th>
                                    <th class="py-3 px-4 border-0 text-uppercase small">Proveedor</th>
                                    <th class="py-3 px-4 border-0 text-uppercase small">Categoría</th>
                                    <th class="py-3 px-4 border-0 text-uppercase small">Precio Venta</th>
                                    <th class="py-3 px-4 border-0 text-uppercase small text-end">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($partes as $index => $parte)
                                    <tr>
                                        <td class="px-4 py-3">{{ $partes->firstItem() + $index }}</td>
                                        <td class="px-4 py-3 fw-bold text-primary">{{ $parte->codigo }}</td>
                                        <td class="px-4 py-3">{{ $parte->nombre }}</td>
                                        <td class="px-4 py-3">
                                            <span class="badge bg-light text-dark rounded-pill px-3">{{ $parte->unidad->nombre ?? 'N/A' }}</span>
                                        </td>
                                        <td class="px-4 py-3">{{ $parte->fabricante->nombre_fabricante ?? 'N/A' }}</td>
                                        <td class="px-4 py-3">{{ $parte->proveedor ? $parte->proveedor->nombre_completo : 'N/A' }}</td>
                                        <td class="px-4 py-3">
                                            <span class="badge bg-info bg-opacity-10 text-info rounded-pill px-3">{{ $parte->categoriaParte->nombre ?? 'N/A' }}</span>
                                        </td>
                                        <td class="px-4 py-3 fw-bold text-success">
                                            {{ number_format($parte->precio_venta, 2) }} {{ $parte->moneda_venta }}
                                        </td>
                                        <td class="px-4 py-3 text-end">
                                            <div class="btn-group shadow-sm rounded-pill overflow-hidden">
                                                <a href="{{ route('admin.almacenes.partes.edit', $parte) }}" class="btn btn-white btn-sm border-0 px-3" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.almacenes.partes.destroy', $parte) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onclick="return confirm('¿Estás seguro de eliminar esta parte?')" class="btn btn-white btn-sm border-0 px-3" title="Eliminar">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="py-5 text-center">
                                            <div class="bg-light d-inline-flex p-4 rounded-circle mb-3">
                                                <i class="fas fa-cog text-muted fa-3x"></i>
                                            </div>
                                            <h5 class="text-dark fw-bold">No hay partes registradas</h5>
                                            <p class="text-muted mb-0">Comienza agregando tu primera parte al catálogo</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4 d-flex justify-content-center">
                        {{ $partes->links() }}
                    </div>
                </div>

                <!-- Importar -->
                <div class="tab-pane fade {{ session('success') || session('error') ? 'show active' : '' }} p-4" id="importar" role="tabpanel">

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
                                    <form action="{{ route('admin.almacenes.partes.import') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="file" class="form-label small text-muted text-uppercase fw-bold mb-2">Seleccionar archivo Excel (.xlsx, .xls)</label>
                                            <input type="file" name="file" id="file" accept=".xlsx,.xls" class="form-control rounded-3 shadow-sm border-0">
                                        </div>
                                        <button type="submit" class="btn btn-primary rounded-pill w-100 fw-bold py-2 shadow-sm border-0 mb-3">
                                            <i class="fas fa-file-import me-2"></i> Procesar Importación
                                        </button>
                                    </form>
                                    <a href="{{ route('admin.almacenes.partes.import.template') }}" class="btn btn-outline-success rounded-pill w-100 fw-bold py-2 border-2">
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
                                                <li class="list-group-item small py-2"><span class="badge bg-primary-subtle text-primary me-1">1</span><strong>Codigo</strong>: Texto (opcional)</li>
                                                <li class="list-group-item small py-2"><span class="badge bg-primary-subtle text-primary me-1">2</span><strong>Nombre</strong>: Nombre de la parte</li>
                                                <li class="list-group-item small py-2"><span class="badge bg-primary-subtle text-primary me-1">3</span><strong>Marca</strong>: Marca (opcional)</li>
                                                <li class="list-group-item small py-2"><span class="badge bg-primary-subtle text-primary me-1">4</span><strong>Codigo OEM</strong>: Código OEM (opcional)</li>
                                                <li class="list-group-item small py-2"><span class="badge bg-primary-subtle text-primary me-1">5</span><strong>Unidad</strong>: Debe existir en el sistema</li>
                                                <li class="list-group-item small py-2"><span class="badge bg-primary-subtle text-primary me-1">6</span><strong>Fabricante</strong>: Nombre fabricante (opcional)</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <ul class="list-group list-group-flush rounded-3 overflow-hidden border">
                                                <li class="list-group-item small py-2"><span class="badge bg-primary-subtle text-primary me-1">7</span><strong>Categoria</strong>: Debe existir en el sistema</li>
                                                <li class="list-group-item small py-2"><span class="badge bg-primary-subtle text-primary me-1">8</span><strong>Proveedor</strong>: Razón social del proveedor</li>
                                                <li class="list-group-item small py-2"><span class="badge bg-primary-subtle text-primary me-1">9</span><strong>Precio Venta</strong>: Decimal (ej. 45.00)</li>
                                                <li class="list-group-item small py-2"><span class="badge bg-primary-subtle text-primary me-1">10</span><strong>Moneda Venta</strong>: SOL o USD</li>
                                                <li class="list-group-item small py-2"><span class="badge bg-primary-subtle text-primary me-1">11</span><strong>Precio Compra</strong>: Decimal (ej. 28.00)</li>
                                                <li class="list-group-item small py-2"><span class="badge bg-primary-subtle text-primary me-1">12</span><strong>Moneda Compra</strong>: SOL o USD</li>
                                                <li class="list-group-item small py-2"><span class="badge bg-success-subtle text-success me-1">13</span><strong>Almacen</strong>: Nombre exacto del almacén</li>
                                                <li class="list-group-item small py-2"><span class="badge bg-success-subtle text-success me-1">14</span><strong>Stock</strong>: Cantidad inicial (entero)</li>
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
                                    <table class="table table-sm table-hover align-middle border rounded-3 overflow-hidden">
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

@push('styles')
<style>
    .premium-tabs .nav-link {
        color: #6c757d;
        border: none;
        border-bottom: 3px solid transparent;
        transition: all 0.3s ease;
        cursor: pointer;
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
document.addEventListener('DOMContentLoaded', function () {
    const REQUIRED_COLS = ['Nombre', 'Unidad', 'Categoria', 'Proveedor', 'Precio Venta', 'Moneda Venta', 'Precio Compra', 'Moneda Compra', 'Almacen', 'Stock'];

    // Cambio de pestañas
    document.querySelectorAll('#partesTab a').forEach(function (tab) {
        tab.addEventListener('click', function () {
            document.querySelectorAll('#partesTab a').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('#partesTabContent .tab-pane').forEach(p => p.classList.remove('show', 'active'));
            this.classList.add('active');
            document.querySelector(this.getAttribute('data-bs-target')).classList.add('show', 'active');
        });
    });

    // Previsualización
    document.getElementById('file').addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (!file) { document.getElementById('preview-section').classList.add('d-none'); return; }

        const reader = new FileReader();
        reader.onload = function (evt) {
            try {
                const wb = XLSX.read(evt.target.result, { type: 'binary', cellDates: true });
                const ws = wb.Sheets[wb.SheetNames[0]];
                const data = XLSX.utils.sheet_to_json(ws, { header: 1, raw: false });

                if (!data || data.length < 2) { showPreviewError('El archivo está vacío o no tiene datos suficientes.'); return; }

                const headers = data[0];
                const rows = data.slice(1).filter(r => r.some(c => c !== '' && c != null));

                const missingCols = REQUIRED_COLS.filter(col => !headers.includes(col));
                const errorsEl = document.getElementById('preview-errors');
                if (missingCols.length > 0) {
                    errorsEl.className = 'mx-4 mt-3 alert alert-warning border-0 rounded-3 small';
                    errorsEl.innerHTML = '<i class="fas fa-exclamation-triangle me-2"></i><strong>Columnas faltantes:</strong> ' + missingCols.join(', ');
                } else {
                    errorsEl.className = 'mx-4 mt-3 d-none';
                    errorsEl.innerHTML = '';
                }

                document.getElementById('preview-head').innerHTML = headers.map(h => `<th class="small px-3 py-2">${h || ''}</th>`).join('');

                const tbody = document.getElementById('preview-body');
                tbody.innerHTML = rows.slice(0, 10).map(row => {
                    const errs = validateRow(row, headers);
                    const cls = errs.length > 0 ? 'table-danger' : '';
                    const cells = headers.map((h, i) => `<td class="small px-3 py-1">${row[i] !== undefined ? row[i] : ''}</td>`).join('');
                    const tip = errs.length > 0 ? ` title="${errs.join('; ')}" data-bs-toggle="tooltip"` : '';
                    return `<tr class="${cls}"${tip}>${cells}</tr>`;
                }).join('');

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
        const get = col => row[headers.indexOf(col)];
        if (!get('Nombre') || String(get('Nombre')).trim() === '') errors.push('Nombre requerido');
        if (!get('Unidad') || String(get('Unidad')).trim() === '') errors.push('Unidad requerida');
        if (!get('Categoria') || String(get('Categoria')).trim() === '') errors.push('Categoría requerida');
        if (!get('Proveedor') || String(get('Proveedor')).trim() === '') errors.push('Proveedor requerido');
        if (!get('Precio Venta') || isNaN(parseFloat(get('Precio Venta')))) errors.push('Precio Venta inválido');
        if (!['SOL', 'USD'].includes(get('Moneda Venta'))) errors.push('Moneda Venta debe ser SOL o USD');
        if (!get('Precio Compra') || isNaN(parseFloat(get('Precio Compra')))) errors.push('Precio Compra inválido');
        if (!['SOL', 'USD'].includes(get('Moneda Compra'))) errors.push('Moneda Compra debe ser SOL o USD');
        if (!get('Almacen') || String(get('Almacen')).trim() === '') errors.push('Almacén requerido');
        const stock = get('Stock');
        if (stock === undefined || stock === '' || isNaN(parseInt(stock)) || parseInt(stock) < 0) errors.push('Stock inválido (entero ≥ 0)');
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
