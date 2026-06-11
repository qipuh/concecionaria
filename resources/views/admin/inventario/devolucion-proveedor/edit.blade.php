@extends('admin.layouts.app')

@section('title', 'Devoluciones a Proveedores')

@section('content')
<div class="dashboard-hero" style="padding: 2rem 2rem; border-radius: 0 0 1.5rem 1.5rem; margin-bottom: 2.5rem;">
    <div class="hero-glow-alt" style="top: -50px; right: 0; filter: blur(60px); opacity: 0.2;"></div>
    <div class="container-fluid position-relative z-1">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center">
            <div class="mb-3 mb-lg-0">
                <div class="d-inline-flex align-items-center px-3 py-1 bg-white bg-opacity-10 rounded-pill fs-6 mb-3 border border-white border-opacity-25">
                    <i class="fas fa-boxes text-info me-2"></i> Inventario
                </div>
                <h2 class="fw-bold mb-1 tracking-tight text-white display-6 text-shadow-sm">Editar Devolución a Proveedor</h2>
                <p class="text-white-50 mb-0">Modifica los datos de la devolución</p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('admin.inventario.devoluciones.index') }}" class="btn bg-white text-dark rounded-pill px-4 py-2 fw-bold shadow-sm border-0">
                    <i class="fas fa-arrow-left me-2"></i> Volver
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid px-3 px-lg-4 position-relative" style="top: -3.5rem; z-index: 10;">

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form action="{{ route('admin.inventario.devoluciones.update', $devolucion->id) }}" method="POST" id="devolucionForm">
        @csrf
        @method('PUT')

        <div class="card dashboard-card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                <h6 class="fw-bold mb-0"><i class="fas fa-info-circle me-2 text-primary"></i> Datos de la Devolución</h6>
            </div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="proveedor_id" class="form-label fw-semibold small text-uppercase text-muted">Proveedor <span class="text-danger">*</span></label>
                        <select name="proveedor_id" id="proveedor_id" class="form-select @error('proveedor_id') is-invalid @enderror" required>
                            <option value="">Seleccione un proveedor</option>
                            @foreach($proveedores as $proveedor)
                                <option value="{{ $proveedor->id }}" {{ (old('proveedor_id', $devolucion->proveedor_id) == $proveedor->id) ? 'selected' : '' }}>
                                    {{ $proveedor->nombre_completo }}
                                </option>
                            @endforeach
                        </select>
                        @error('proveedor_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="almacen_id" class="form-label fw-semibold small text-uppercase text-muted">Almacén <span class="text-danger">*</span></label>
                        <select name="almacen_id" id="almacen_id" class="form-select @error('almacen_id') is-invalid @enderror" required>
                            <option value="">Seleccione un almacén</option>
                            @foreach($almacenes as $almacen)
                                <option value="{{ $almacen->id }}" {{ (old('almacen_id', $devolucion->almacen_id) == $almacen->id) ? 'selected' : '' }}>
                                    {{ $almacen->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('almacen_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="motivo" class="form-label fw-semibold small text-uppercase text-muted">Motivo <span class="text-danger">*</span></label>
                        <input type="text" name="motivo" id="motivo" class="form-control @error('motivo') is-invalid @enderror" value="{{ old('motivo', $devolucion->motivo) }}" required>
                        @error('motivo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="fecha_emision" class="form-label fw-semibold small text-uppercase text-muted">Fecha de Emisión <span class="text-danger">*</span></label>
                        <input type="date" name="fecha_emision" id="fecha_emision" class="form-control @error('fecha_emision') is-invalid @enderror" value="{{ old('fecha_emision', $devolucion->fecha_emision ? $devolucion->fecha_emision->format('Y-m-d') : '') }}" required>
                        @error('fecha_emision')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label for="observaciones" class="form-label fw-semibold small text-uppercase text-muted">Observaciones</label>
                        <textarea name="observaciones" id="observaciones" class="form-control @error('observaciones') is-invalid @enderror" rows="3">{{ old('observaciones', $devolucion->observaciones) }}</textarea>
                        @error('observaciones')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="card dashboard-card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 pt-4 pb-0 px-4 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0"><i class="fas fa-boxes me-2 text-primary"></i> Productos a Devolver</h6>
                <button type="button" id="agregarProductoBtn" class="btn btn-sm btn-primary rounded-pill px-3 fw-bold border-0">
                    <i class="fas fa-plus me-1"></i> Agregar Producto
                </button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="tablaItems">
                        <thead class="table-light">
                            <tr>
                                <th class="py-3 px-4 border-0 text-uppercase small">Producto</th>
                                <th class="py-3 px-4 border-0 text-uppercase small">Código</th>
                                <th class="py-3 px-4 border-0 text-uppercase small">Unidad</th>
                                <th class="py-3 px-4 border-0 text-uppercase small">Cantidad</th>
                                <th class="py-3 px-4 border-0 text-uppercase small">Motivo</th>
                                <th class="py-3 px-4 border-0 text-uppercase small">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($devolucion->detalles as $index => $detalle)
                            <tr id="row-{{ $index }}">
                                <td class="px-4 fw-semibold">{{ $detalle->nombre }}</td>
                                <td class="px-4"><code class="bg-light px-2 py-1 rounded small">{{ $detalle->codigo }}</code></td>
                                <td class="px-4">{{ $detalle->item->unidad->nombre ?? 'N/A' }}</td>
                                <td class="px-4">
                                    <input type="number" name="items[{{ $index }}][cantidad]" value="{{ $detalle->cantidad }}" min="0.01" step="0.01" class="form-control form-control-sm" style="width: 90px;" required>
                                    <input type="hidden" name="items[{{ $index }}][id]" value="{{ $detalle->item_id }}">
                                    <input type="hidden" name="items[{{ $index }}][tipo]" value="{{ $detalle->tipo_item }}">
                                </td>
                                <td class="px-4">
                                    <input type="text" name="items[{{ $index }}][motivo_detalle]" value="{{ $detalle->motivo_detalle }}" class="form-control form-control-sm">
                                </td>
                                <td class="px-4">
                                    <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-3 eliminar-item" data-row="{{ $index }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr id="noItemsRow">
                                <td colspan="6" class="text-center py-4 text-muted">No hay productos agregados</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white border-0 px-4 pb-4 pt-0 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow-sm border-0" id="submitBtn">
                    <i class="fas fa-save me-2"></i> Actualizar Devolución
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Modal para seleccionar producto -->
<div class="modal fade" id="productosModal" tabindex="-1" aria-labelledby="productosModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" id="productosModalLabel"><i class="fas fa-search me-2 text-primary"></i>Seleccionar Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4">
                <div class="mb-3">
                    <label for="buscarProducto" class="form-label fw-semibold small text-uppercase text-muted">Buscar Producto</label>
                    <select id="buscarProducto" class="form-control select2-productos" style="width: 100%"></select>
                </div>

                <div id="detalleProducto" class="d-none">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="modalCantidad" class="form-label fw-semibold small text-uppercase text-muted">Cantidad a Devolver</label>
                            <input type="number" id="modalCantidad" class="form-control" min="0.01" step="0.01" value="1">
                        </div>
                        <div class="col-md-6">
                            <label for="modalMotivo" class="form-label fw-semibold small text-uppercase text-muted">Motivo del Detalle</label>
                            <input type="text" id="modalMotivo" class="form-control" placeholder="Ej: Producto dañado, error en pedido, etc.">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-4 fw-bold border-0" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary rounded-pill px-4 fw-bold border-0" id="agregarItemBtn" disabled>
                    <i class="fas fa-plus me-2"></i> Agregar
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('.select2-productos').select2({
            dropdownParent: $('#productosModal'),
            placeholder: 'Buscar por nombre o código',
            minimumInputLength: 2,
            ajax: {
                url: '{{ route("admin.inventario.devoluciones.buscar-items") }}',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term
                    };
                },
                processResults: function(data) {
                    return {
                        results: data.results
                    };
                },
                cache: true
            }
        });

        $('#buscarProducto').on('change', function() {
            let data = $(this).select2('data')[0];
            if (data) {
                $('#detalleProducto').removeClass('d-none');
                $('#agregarItemBtn').prop('disabled', false);
            } else {
                $('#detalleProducto').addClass('d-none');
                $('#agregarItemBtn').prop('disabled', true);
            }
        });

        $('#agregarProductoBtn').on('click', function() {
            $('#buscarProducto').val(null).trigger('change');
            $('#detalleProducto').addClass('d-none');
            $('#modalCantidad').val(1);
            $('#modalMotivo').val('');
            $('#agregarItemBtn').prop('disabled', true);
            $('#productosModal').modal('show');
        });

        let itemCounter = {{ count($devolucion->detalles) }};

        $('#agregarItemBtn').on('click', function() {
            const itemData = $('#buscarProducto').select2('data')[0];
            const cantidad = parseFloat($('#modalCantidad').val());
            const motivo = $('#modalMotivo').val();

            if (!itemData || isNaN(cantidad) || cantidad <= 0) {
                alert('Por favor ingrese datos válidos');
                return;
            }

            $('#noItemsRow').hide();

            const newRow = `
                <tr id="row-${itemCounter}">
                    <td class="px-4 fw-semibold">${itemData.nombre}</td>
                    <td class="px-4"><code class="bg-light px-2 py-1 rounded small">${itemData.codigo}</code></td>
                    <td class="px-4">${itemData.unidad}</td>
                    <td class="px-4">
                        <input type="number" name="items[${itemCounter}][cantidad]" value="${cantidad}" min="0.01" step="0.01" class="form-control form-control-sm" style="width: 90px;" required>
                        <input type="hidden" name="items[${itemCounter}][id]" value="${itemData.id}">
                        <input type="hidden" name="items[${itemCounter}][tipo]" value="${itemData.tipo}">
                    </td>
                    <td class="px-4">
                        <input type="text" name="items[${itemCounter}][motivo_detalle]" value="${motivo}" class="form-control form-control-sm">
                    </td>
                    <td class="px-4">
                        <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-3 eliminar-item" data-row="${itemCounter}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;

            $('#tablaItems tbody').append(newRow);
            itemCounter++;
            $('#productosModal').modal('hide');
        });

        $(document).on('click', '.eliminar-item', function() {
            const rowId = $(this).data('row');
            $(`#row-${rowId}`).remove();
            if ($('#tablaItems tbody tr').length === 0) {
                $('#tablaItems tbody').append('<tr id="noItemsRow"><td colspan="6" class="text-center py-4 text-muted">No hay productos agregados</td></tr>');
            }
        });

        $('#devolucionForm').on('submit', function(e) {
            const rowCount = $('#tablaItems tbody tr').length - $('#noItemsRow:visible').length;
            if (rowCount === 0) {
                e.preventDefault();
                alert('Debe agregar al menos un producto a la devolución');
                return false;
            }
            return true;
        });

        $('#proveedor_id, #almacen_id').select2({
            placeholder: 'Seleccione una opción',
            width: '100%'
        });
    });
</script>
@endpush
