@extends('admin.layouts.app')

@section('title', 'Nuevo Traslado')

@section('header', 'Nuevo Traslado')

@section('content')
<div class="dashboard-hero" style="padding: 2rem 2rem; border-radius: 0 0 1.5rem 1.5rem; margin-bottom: 2.5rem;">
    <div class="hero-glow-alt" style="top: -50px; right: 0; filter: blur(60px); opacity: 0.2;"></div>
    <div class="container-fluid position-relative z-1">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center">
            <div class="mb-3 mb-lg-0">
                <div class="d-inline-flex align-items-center px-3 py-1 bg-white bg-opacity-10 rounded-pill fs-6 mb-3 border border-white border-opacity-25">
                    <i class="fas fa-boxes text-info me-2"></i> Inventario
                </div>
                <h2 class="fw-bold mb-1 tracking-tight text-white display-6 text-shadow-sm">Nuevo Traslado</h2>
                <p class="text-white-50 mb-0">Registra un traslado entre almacenes</p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('admin.inventario.traslados.index') }}" class="btn bg-white text-dark rounded-pill px-4 py-2 fw-bold shadow-sm border-0">
                    <i class="fa fa-arrow-left me-2"></i> Volver
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid px-3 px-lg-4 position-relative" style="top: -3.5rem; z-index: 10;">

    @if($errors->any())
        <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4 alert-dismissible fade show">
            <i class="fas fa-exclamation-triangle text-danger me-2"></i>
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card dashboard-card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
            <h6 class="fw-bold mb-0"><i class="fas fa-exchange-alt me-2 text-primary"></i> Datos del Traslado</h6>
        </div>
        <div class="card-body p-4">
            <form method="POST" action="{{ route('admin.inventario.traslados.store') }}">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="almacen_origen_id" class="form-label fw-semibold small text-uppercase text-muted">Almacén Origen <span class="text-danger">*</span></label>
                        <select class="form-select @error('almacen_origen_id') is-invalid @enderror" id="almacen_origen_id" name="almacen_origen_id" required>
                            <option value="">Seleccione un almacén</option>
                            @foreach($almacenes as $almacen)
                                <option value="{{ $almacen->id }}" {{ old('almacen_origen_id') == $almacen->id ? 'selected' : '' }}>
                                    {{ $almacen->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('almacen_origen_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="almacen_destino_id" class="form-label fw-semibold small text-uppercase text-muted">Almacén Destino <span class="text-danger">*</span></label>
                        <select class="form-select @error('almacen_destino_id') is-invalid @enderror" id="almacen_destino_id" name="almacen_destino_id" required>
                            <option value="">Seleccione un almacén</option>
                            @foreach($almacenes as $almacen)
                                <option value="{{ $almacen->id }}" {{ old('almacen_destino_id') == $almacen->id ? 'selected' : '' }}>
                                    {{ $almacen->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('almacen_destino_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="motivo" class="form-label fw-semibold small text-uppercase text-muted">Motivo del Traslado <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('motivo') is-invalid @enderror" id="motivo" name="motivo" rows="3" required>{{ old('motivo') }}</textarea>
                    @error('motivo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small text-uppercase text-muted">Tipo de Item <span class="text-danger">*</span></label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="tipo_item" id="tipo_parte" value="parte" {{ old('tipo_item', 'parte') == 'parte' ? 'checked' : '' }}>
                            <label class="form-check-label" for="tipo_parte">Parte/Repuesto</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="tipo_item" id="tipo_vehiculo" value="vehiculo" {{ old('tipo_item') == 'vehiculo' ? 'checked' : '' }}>
                            <label class="form-check-label" for="tipo_vehiculo">Vehículo</label>
                        </div>
                        @error('tipo_item')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Selector de Partes (visible cuando tipo_item = parte) -->
                <div class="row mb-3" id="parte_selector">
                    <div class="col-md-6">
                        <label for="parte_id" class="form-label fw-semibold small text-uppercase text-muted">Parte/Repuesto <span class="text-danger">*</span></label>
                        <select class="form-select @error('parte_id') is-invalid @enderror" id="parte_id" name="parte_id">
                            <option value="">Seleccione una parte</option>
                            @foreach($partes as $parte)
                                <option value="{{ $parte->id }}" {{ old('parte_id') == $parte->id ? 'selected' : '' }}>
                                    {{ $parte->codigo }} - {{ $parte->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('parte_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Selector de Vehículos (visible cuando tipo_item = vehiculo) -->
                <div class="row mb-3" id="vehiculo_selector" style="display: none;">
                    <div class="col-md-6">
                        <label for="vehiculo_id" class="form-label fw-semibold small text-uppercase text-muted">Vehículo <span class="text-danger">*</span></label>
                        <select class="form-select @error('vehiculo_id') is-invalid @enderror" id="vehiculo_id" name="vehiculo_id">
                            <option value="">Seleccione un vehículo</option>
                            @foreach($vehiculos as $vehiculo)
                                <option value="{{ $vehiculo->id }}" {{ old('vehiculo_id') == $vehiculo->id ? 'selected' : '' }}>
                                    {{ $vehiculo->marca->nombre ?? '' }} {{ $vehiculo->modelo->nombre ?? '' }} {{ $vehiculo->version->nombre ?? '' }} {{ $vehiculo->anioModelo->anio ?? '' }}
                                </option>
                            @endforeach
                        </select>
                        @error('vehiculo_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-3">
                        <label for="stock_actual" class="form-label fw-semibold small text-uppercase text-muted">Stock Actual</label>
                        <input type="text" class="form-control" id="stock_actual" readonly>
                    </div>

                    <div class="col-md-3">
                        <label for="cantidad" class="form-label fw-semibold small text-uppercase text-muted">Cantidad a Trasladar <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" min="0.01" class="form-control @error('cantidad') is-invalid @enderror" id="cantidad" name="cantidad" value="{{ old('cantidad') }}" required>
                        @error('cantidad')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.inventario.traslados.index') }}" class="btn btn-outline-secondary rounded-pill px-4 py-2 fw-bold border-0">Cancelar</a>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow-sm border-0">
                        <i class="fa fa-save me-2"></i> Guardar Traslado
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const almacenOrigenSelect = document.getElementById('almacen_origen_id');
        const tipoParte = document.getElementById('tipo_parte');
        const tipoVehiculo = document.getElementById('tipo_vehiculo');
        const parteSelector = document.getElementById('parte_selector');
        const vehiculoSelector = document.getElementById('vehiculo_selector');
        const parteSelect = document.getElementById('parte_id');
        const vehiculoSelect = document.getElementById('vehiculo_id');
        const stockActualInput = document.getElementById('stock_actual');
        const cantidadInput = document.getElementById('cantidad');

        function toggleItemSelectors() {
            if (tipoParte.checked) {
                parteSelector.style.display = 'flex';
                vehiculoSelector.style.display = 'none';
                vehiculoSelect.removeAttribute('required');
                parteSelect.setAttribute('required', 'required');
            } else if (tipoVehiculo.checked) {
                parteSelector.style.display = 'none';
                vehiculoSelector.style.display = 'flex';
                parteSelect.removeAttribute('required');
                vehiculoSelect.setAttribute('required', 'required');
            }
            getStockActual();
        }

        function getStockActual() {
            const almacenId = almacenOrigenSelect.value;
            let tipo = '';
            let itemId = '';

            if (tipoParte.checked) {
                tipo = 'parte';
                itemId = parteSelect.value;
            } else if (tipoVehiculo.checked) {
                tipo = 'vehiculo';
                itemId = vehiculoSelect.value;
            }

            if (almacenId && tipo && itemId) {
                fetch(`{{ url('admin/inventario/traslados/get-stock') }}?almacen_id=${almacenId}&tipo_item=${tipo}&item_id=${itemId}`)
                    .then(response => response.json())
                    .then(data => {
                        stockActualInput.value = data.stock;
                        validarCantidad();
                    })
                    .catch(error => {
                        stockActualInput.value = '0';
                    });
            } else {
                stockActualInput.value = '';
            }
        }

        function validarCantidad() {
            const stockActual = parseFloat(stockActualInput.value) || 0;
            const cantidad = parseFloat(cantidadInput.value) || 0;

            if (cantidad > stockActual) {
                cantidadInput.classList.add('is-invalid');
                const existingFeedback = cantidadInput.nextElementSibling;
                if (existingFeedback && existingFeedback.classList.contains('invalid-feedback')) {
                    existingFeedback.remove();
                }
                const feedbackDiv = document.createElement('div');
                feedbackDiv.classList.add('invalid-feedback');
                feedbackDiv.textContent = 'La cantidad a trasladar no puede ser mayor al stock disponible.';
                cantidadInput.parentNode.appendChild(feedbackDiv);
            } else {
                cantidadInput.classList.remove('is-invalid');
                const existingFeedback = cantidadInput.nextElementSibling;
                if (existingFeedback && existingFeedback.classList.contains('invalid-feedback')) {
                    existingFeedback.remove();
                }
            }
        }

        tipoParte.addEventListener('change', toggleItemSelectors);
        tipoVehiculo.addEventListener('change', toggleItemSelectors);
        almacenOrigenSelect.addEventListener('change', getStockActual);
        parteSelect.addEventListener('change', getStockActual);
        vehiculoSelect.addEventListener('change', getStockActual);
        cantidadInput.addEventListener('input', validarCantidad);

        const almacenDestinoSelect = document.getElementById('almacen_destino_id');

        function validarAlmacenesDiferentes() {
            const origenId = almacenOrigenSelect.value;
            const destinoId = almacenDestinoSelect.value;

            if (origenId && destinoId && origenId === destinoId) {
                almacenDestinoSelect.classList.add('is-invalid');
                const existingFeedback = almacenDestinoSelect.nextElementSibling;
                if (existingFeedback && existingFeedback.classList.contains('invalid-feedback')) {
                    existingFeedback.remove();
                }
                const feedbackDiv = document.createElement('div');
                feedbackDiv.classList.add('invalid-feedback');
                feedbackDiv.textContent = 'El almacén de destino debe ser diferente al de origen.';
                almacenDestinoSelect.parentNode.appendChild(feedbackDiv);
            } else {
                almacenDestinoSelect.classList.remove('is-invalid');
                const existingFeedback = almacenDestinoSelect.nextElementSibling;
                if (existingFeedback && existingFeedback.classList.contains('invalid-feedback')) {
                    existingFeedback.remove();
                }
            }
        }

        almacenOrigenSelect.addEventListener('change', validarAlmacenesDiferentes);
        almacenDestinoSelect.addEventListener('change', validarAlmacenesDiferentes);

        toggleItemSelectors();

        if (almacenOrigenSelect.value) {
            if ((tipoParte.checked && parteSelect.value) ||
                (tipoVehiculo.checked && vehiculoSelect.value)) {
                getStockActual();
            }
            if (almacenDestinoSelect.value) {
                validarAlmacenesDiferentes();
            }
        }
    });
</script>
@endpush
