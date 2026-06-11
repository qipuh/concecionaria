@extends('admin.layouts.app')
@section('title', 'Nuevo Vale de Devolución')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
@endpush

@section('content')
<div class="dashboard-hero" style="padding: 2rem 2rem; border-radius: 0 0 1.5rem 1.5rem; margin-bottom: 2.5rem;">
    <div class="hero-glow-alt" style="top: -50px; right: 0; filter: blur(60px); opacity: 0.2;"></div>
    <div class="container-fluid position-relative z-1">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center">
            <div class="mb-3 mb-lg-0">
                <div class="d-inline-flex align-items-center px-3 py-1 bg-white bg-opacity-10 rounded-pill fs-6 mb-3 border border-white border-opacity-25">
                    <i class="fas fa-undo text-info me-2"></i> Documentos de Compra
                </div>
                <h2 class="fw-bold mb-1 tracking-tight text-white display-6 text-shadow-sm">
                    Nuevo Vale de Devolución
                </h2>
                <p class="text-white-50 mb-0">Registra la devolución de mercancía a un proveedor</p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('admin.devoluciones.index') }}"
                   class="btn bg-white text-dark rounded-pill px-4 py-2 fw-bold shadow-sm border-0">
                    <i class="fas fa-arrow-left text-primary me-2"></i> Volver
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid px-3 px-lg-4 position-relative" style="top: -3.5rem; z-index: 10;">

    @if($errors->any())
        <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4">
            <div class="fw-bold mb-1"><i class="fas fa-exclamation-circle me-2"></i> Corrija los siguientes errores:</div>
            <ul class="mb-0 ps-3 small">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.devoluciones.store') }}" method="POST" id="form-devolucion">
        @csrf

        {{-- Datos generales --}}
        <div class="card dashboard-card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                <h6 class="fw-bold mb-0"><i class="fas fa-file-alt me-2 text-primary"></i> Datos del Vale</h6>
            </div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-md-2">
                        <label class="form-label fw-semibold small text-uppercase text-muted">Número</label>
                        <input type="text" class="form-control bg-light border-0" value="Automático" readonly>
                    </div>
                    <div class="col-md-2">
                        <label for="fecha" class="form-label fw-semibold small text-uppercase text-muted">
                            Fecha <span class="text-danger">*</span>
                        </label>
                        <input type="date" class="form-control @error('fecha') is-invalid @enderror"
                               id="fecha" name="fecha" value="{{ old('fecha', date('Y-m-d')) }}" required>
                        @error('fecha')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="proveedor_id" class="form-label fw-semibold small text-uppercase text-muted">
                            Proveedor <span class="text-danger">*</span>
                        </label>
                        <select class="form-select @error('proveedor_id') is-invalid @enderror"
                                id="proveedor_id" name="proveedor_id" required>
                            <option value="">Seleccione un proveedor</option>
                            @foreach($proveedores as $proveedor)
                                <option value="{{ $proveedor->id }}" {{ old('proveedor_id') == $proveedor->id ? 'selected' : '' }}>
                                    {{ $proveedor->razon_social }} — {{ $proveedor->ruc }}
                                </option>
                            @endforeach
                        </select>
                        @error('proveedor_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="motivo" class="form-label fw-semibold small text-uppercase text-muted">
                            Motivo <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control @error('motivo') is-invalid @enderror"
                               id="motivo" name="motivo" value="{{ old('motivo') }}"
                               placeholder="Ej: Productos defectuosos, Error en pedido..." required>
                        @error('motivo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label for="observaciones" class="form-label fw-semibold small text-uppercase text-muted">
                            Observaciones
                        </label>
                        <textarea class="form-control @error('observaciones') is-invalid @enderror"
                                  id="observaciones" name="observaciones" rows="2"
                                  placeholder="Observaciones adicionales (opcional)">{{ old('observaciones') }}</textarea>
                        @error('observaciones')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Búsqueda de productos --}}
        <div class="card dashboard-card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                <h6 class="fw-bold mb-0"><i class="fas fa-search me-2 text-primary"></i> Buscar y Agregar Productos</h6>
            </div>
            <div class="card-body p-4">
                <label for="buscar_producto_select" class="form-label fw-semibold small text-uppercase text-muted">
                    Buscar por código o nombre
                </label>
                <select class="form-control" id="buscar_producto_select">
                    <option value="">Escriba para buscar...</option>
                </select>
                <div class="text-muted small mt-2">
                    <i class="fas fa-info-circle me-1"></i>
                    Escriba al menos 2 caracteres. Los productos se agregan a la lista de abajo al seleccionarlos.
                </div>
            </div>
        </div>

        {{-- Productos agregados --}}
        <div class="card dashboard-card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 pt-4 pb-0 px-4 d-flex align-items-center justify-content-between">
                <h6 class="fw-bold mb-0"><i class="fas fa-boxes me-2 text-primary"></i> Productos a Devolver</h6>
                <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-1 small" id="contador-productos">0 productos</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="py-3 px-4 border-0 text-uppercase small">Tipo</th>
                                <th class="py-3 px-4 border-0 text-uppercase small">Código</th>
                                <th class="py-3 px-4 border-0 text-uppercase small">Nombre</th>
                                <th class="py-3 px-4 border-0 text-uppercase small text-center">Cantidad</th>
                                <th class="py-3 px-4 border-0 text-uppercase small text-end">Precio Unit.</th>
                                <th class="py-3 px-4 border-0 text-uppercase small text-end">Subtotal</th>
                                <th class="py-3 px-4 border-0 border-0"></th>
                            </tr>
                        </thead>
                        <tbody id="tabla-productos">
                            <tr id="sin-productos">
                                <td colspan="7" class="text-center py-5">
                                    <div class="bg-light d-inline-flex p-3 rounded-circle mb-2">
                                        <i class="fas fa-inbox text-muted fa-lg"></i>
                                    </div>
                                    <p class="mb-0 text-muted small">Sin productos agregados</p>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot id="tabla-footer" style="display: none;">
                            <tr class="table-light">
                                <td colspan="5" class="px-4 py-3 text-end fw-bold text-uppercase small">Total</td>
                                <td class="px-4 py-3 text-end fw-bold text-primary" id="total-general">S/. 0.00</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        {{-- Botones --}}
        <div class="d-flex justify-content-end gap-2 pb-4">
            <a href="{{ route('admin.devoluciones.index') }}"
               class="btn btn-outline-secondary rounded-pill px-4 py-2 fw-bold border-0">
                <i class="fas fa-times me-2"></i> Cancelar
            </a>
            <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow-sm border-0" id="btn-guardar">
                <i class="fas fa-save me-2"></i> Guardar Vale de Devolución
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    let productos = [];

    // Select2 en proveedor
    $('#proveedor_id').select2({
        theme: 'bootstrap-5',
        placeholder: 'Seleccione un proveedor',
        allowClear: true,
        width: '100%'
    });

    // Select2 AJAX para búsqueda de productos
    $('#buscar_producto_select').select2({
        theme: 'bootstrap-5',
        placeholder: 'Buscar por código o nombre...',
        allowClear: true,
        width: '100%',
        ajax: {
            url: '{{ route("admin.devoluciones.buscar-productos") }}',
            dataType: 'json',
            delay: 300,
            data: function(params) {
                return { search: params.term || '', tipo: '' };
            },
            processResults: function(data) {
                return {
                    results: data.map(item => ({
                        id: `${item.tipo}_${item.id}`,
                        text: `${item.codigo} - ${item.nombre}`,
                        tipo: item.tipo,
                        producto_id: item.id,
                        codigo: item.codigo,
                        nombre: item.nombre,
                        stock: item.stock,
                        precio: item.precio
                    }))
                };
            },
            cache: true
        },
        minimumInputLength: 2,
        templateResult: formatProductoSelect,
        templateSelection: function(item) { return item.text || 'Buscar producto...'; }
    });

    $('#buscar_producto_select').on('select2:select', function(e) {
        const data = e.params.data;
        agregarProducto({
            id: data.producto_id,
            tipo: data.tipo,
            codigo: data.codigo,
            nombre: data.nombre,
            precio: parseFloat(data.precio),
            stock: data.stock
        });
        $(this).val(null).trigger('change');
    });

    function formatProductoSelect(item) {
        if (item.loading) return item.text;
        const tipo = item.tipo || 'parte';
        const badgeClass = tipo === 'vehiculo' ? 'bg-info' : 'bg-primary';
        return $(`
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div>
                        <span class="badge ${badgeClass} small">${tipo.toUpperCase()}</span>
                        <strong>${item.codigo}</strong> — ${item.nombre}
                    </div>
                    <small class="text-muted">Stock: ${item.stock} | Precio: S/. ${parseFloat(item.precio).toFixed(2)}</small>
                </div>
            </div>
        `);
    }

    function agregarProducto(producto) {
        const existe = productos.find(p => p.id === producto.id && p.tipo === producto.tipo);
        if (existe) {
            if (typeof toastr !== 'undefined') toastr.warning('Este producto ya fue agregado');
            return;
        }
        productos.push({ ...producto, cantidad: 1, subtotal: producto.precio });
        actualizarTabla();
        if (typeof toastr !== 'undefined') toastr.success('Producto agregado');
    }

    function actualizarTabla() {
        const tbody = $('#tabla-productos');
        if (productos.length === 0) {
            tbody.html(`
                <tr id="sin-productos">
                    <td colspan="7" class="text-center py-5">
                        <div class="bg-light d-inline-flex p-3 rounded-circle mb-2">
                            <i class="fas fa-inbox text-muted fa-lg"></i>
                        </div>
                        <p class="mb-0 text-muted small">Sin productos agregados</p>
                    </td>
                </tr>
            `);
            $('#tabla-footer').hide();
            $('#contador-productos').text('0 productos');
            return;
        }

        let html = '';
        let total = 0;
        productos.forEach((producto, index) => {
            const subtotal = producto.cantidad * producto.precio;
            total += subtotal;
            const badgeClass = producto.tipo === 'vehiculo' ? 'bg-info-subtle text-info' : 'bg-primary-subtle text-primary';
            html += `
                <tr>
                    <td class="px-4 py-3">
                        <span class="badge ${badgeClass} rounded-pill px-3 small">${producto.tipo.toUpperCase()}</span>
                        <input type="hidden" name="productos[${index}][id]" value="${producto.id}">
                        <input type="hidden" name="productos[${index}][tipo]" value="${producto.tipo}">
                    </td>
                    <td class="px-4 py-3 font-monospace small">${producto.codigo}</td>
                    <td class="px-4 py-3 fw-semibold small">${producto.nombre}</td>
                    <td class="px-4 py-3 text-center">
                        <input type="number" class="form-control form-control-sm text-center cantidad-input"
                               name="productos[${index}][cantidad]"
                               value="${producto.cantidad}"
                               min="0.01" step="0.01"
                               data-index="${index}" required style="max-width:90px;margin:auto;">
                    </td>
                    <td class="px-4 py-3 text-end">
                        <input type="number" class="form-control form-control-sm text-end precio-input"
                               name="productos[${index}][precio]"
                               value="${producto.precio}"
                               min="0" step="0.01"
                               data-index="${index}" required style="max-width:110px;margin:auto;">
                    </td>
                    <td class="px-4 py-3 text-end fw-bold text-primary">S/. ${subtotal.toFixed(2)}</td>
                    <td class="px-4 py-3 text-center">
                        <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-2 btn-eliminar" data-index="${index}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
        });

        tbody.html(html);
        $('#total-general').text(`S/. ${total.toFixed(2)}`);
        $('#tabla-footer').show();
        $('#contador-productos').text(`${productos.length} producto${productos.length !== 1 ? 's' : ''}`);

        $('.cantidad-input, .precio-input').on('input', function() {
            const index = $(this).data('index');
            productos[index].cantidad = parseFloat($(`input[name="productos[${index}][cantidad]"]`).val()) || 0;
            productos[index].precio   = parseFloat($(`input[name="productos[${index}][precio]"]`).val()) || 0;
            productos[index].subtotal = productos[index].cantidad * productos[index].precio;
            actualizarTabla();
        });

        $('.btn-eliminar').on('click', function() {
            const index = $(this).data('index');
            if (confirm('¿Eliminar este producto?')) {
                productos.splice(index, 1);
                actualizarTabla();
            }
        });
    }

    $('#form-devolucion').on('submit', function(e) {
        if (productos.length === 0) {
            e.preventDefault();
            if (typeof toastr !== 'undefined') toastr.error('Debe agregar al menos un producto');
            return false;
        }
        const invalido = productos.some(p => p.cantidad <= 0 || p.precio < 0);
        if (invalido) {
            e.preventDefault();
            if (typeof toastr !== 'undefined') toastr.error('Cantidad y precio deben ser válidos');
            return false;
        }
        $('#btn-guardar').prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i> Guardando...');
    });
});
</script>
@endpush
