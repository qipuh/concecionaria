@extends('admin.layouts.app')
@section('title', 'Editar Vale ' . $devolucion->numero)

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
                    <i class="fas fa-pencil-alt text-info me-2"></i> Editar Documento
                </div>
                <h2 class="fw-bold mb-1 tracking-tight text-white display-6 text-shadow-sm">
                    Editar {{ $devolucion->numero }}
                </h2>
                <p class="text-white-50 mb-0">Modificar datos del vale de devolución en estado pendiente</p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('admin.devoluciones.show', $devolucion->id) }}"
                   class="btn bg-white bg-opacity-10 text-white rounded-pill px-4 py-2 fw-bold shadow-sm border border-white border-opacity-25">
                    <i class="fas fa-eye me-2"></i> Ver
                </a>
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

    <form action="{{ route('admin.devoluciones.update', $devolucion->id) }}" method="POST" id="form-devolucion">
        @csrf
        @method('PUT')

        {{-- Datos generales --}}
        <div class="card dashboard-card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                <h6 class="fw-bold mb-0"><i class="fas fa-file-alt me-2 text-primary"></i> Datos del Vale</h6>
            </div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-md-2">
                        <label class="form-label fw-semibold small text-uppercase text-muted">Número</label>
                        <input type="text" class="form-control bg-light border-0" value="{{ $devolucion->numero }}" disabled>
                    </div>
                    <div class="col-md-2">
                        <label for="fecha" class="form-label fw-semibold small text-uppercase text-muted">
                            Fecha <span class="text-danger">*</span>
                        </label>
                        <input type="date" class="form-control @error('fecha') is-invalid @enderror"
                               id="fecha" name="fecha" value="{{ old('fecha', $devolucion->fecha->format('Y-m-d')) }}" required>
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
                                <option value="{{ $proveedor->id }}"
                                    {{ old('proveedor_id', $devolucion->proveedor_id) == $proveedor->id ? 'selected' : '' }}>
                                    {{ $proveedor->razon_social }}
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
                               id="motivo" name="motivo"
                               value="{{ old('motivo', $devolucion->motivo) }}"
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
                                  placeholder="Observaciones adicionales (opcional)">{{ old('observaciones', $devolucion->observaciones) }}</textarea>
                        @error('observaciones')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Productos (solo lectura) --}}
        <div class="card dashboard-card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 pt-4 pb-0 px-4 d-flex align-items-center justify-content-between">
                <h6 class="fw-bold mb-0"><i class="fas fa-boxes me-2 text-primary"></i> Productos en el Vale</h6>
                <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3 py-1 small">
                    {{ $devolucion->detalles->count() }} ítems
                </span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="py-3 px-4 border-0 text-uppercase small">Producto</th>
                                <th class="py-3 px-4 border-0 text-uppercase small">Código</th>
                                <th class="py-3 px-4 border-0 text-uppercase small text-center">Tipo</th>
                                <th class="py-3 px-4 border-0 text-uppercase small text-center">Cantidad</th>
                                <th class="py-3 px-4 border-0 text-uppercase small text-end">Precio Unit.</th>
                                <th class="py-3 px-4 border-0 text-uppercase small text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($devolucion->detalles as $index => $detalle)
                            <tr>
                                <td class="px-4 py-3 fw-semibold small">{{ $detalle->nombre_producto }}</td>
                                <td class="px-4 py-3 font-monospace small text-muted">{{ $detalle->codigo_producto }}</td>
                                <td class="px-4 py-3 text-center">
                                    <span class="badge bg-primary-subtle text-primary rounded-pill px-3 small">
                                        {{ ucfirst($detalle->tipo_producto) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center">{{ number_format($detalle->cantidad, 2) }}</td>
                                <td class="px-4 py-3 text-end">S/. {{ number_format($detalle->precio_unitario, 2) }}</td>
                                <td class="px-4 py-3 text-end fw-bold text-primary">
                                    S/. {{ number_format($detalle->subtotal ?? ($detalle->cantidad * $detalle->precio_unitario), 2) }}
                                </td>

                                {{-- Hidden inputs para mantener los productos al actualizar --}}
                                <input type="hidden" name="productos[{{ $index }}][id]" value="{{ $detalle->producto_id }}">
                                <input type="hidden" name="productos[{{ $index }}][tipo]" value="{{ $detalle->tipo_producto }}">
                                <input type="hidden" name="productos[{{ $index }}][cantidad]" value="{{ $detalle->cantidad }}">
                                <input type="hidden" name="productos[{{ $index }}][precio]" value="{{ $detalle->precio_unitario }}">
                                <input type="hidden" name="productos[{{ $index }}][motivo]" value="{{ $detalle->motivo_detalle }}">
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <td colspan="5" class="px-4 py-3 text-end fw-bold text-uppercase small">Total</td>
                                <td class="px-4 py-3 text-end fw-bold text-primary">
                                    S/. {{ number_format($devolucion->total ?? 0, 2) }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="px-4 py-3 border-top bg-light">
                    <div class="text-muted small">
                        <i class="fas fa-info-circle me-1 text-primary"></i>
                        Para modificar los productos, elimine este vale y cree uno nuevo.
                    </div>
                </div>
            </div>
        </div>

        {{-- Botones --}}
        <div class="d-flex justify-content-end gap-2 pb-4">
            <a href="{{ route('admin.devoluciones.show', $devolucion->id) }}"
               class="btn btn-outline-secondary rounded-pill px-4 py-2 fw-bold border-0">
                <i class="fas fa-times me-2"></i> Cancelar
            </a>
            <button type="submit"
                    class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow-sm border-0">
                <i class="fas fa-save me-2"></i> Actualizar Vale
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('#proveedor_id').select2({
        theme: 'bootstrap-5',
        placeholder: 'Seleccione un proveedor',
        allowClear: true,
        width: '100%'
    });
});
</script>
@endpush
