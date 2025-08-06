@extends('admin.layouts.app')

@section('title', 'Nueva Parte')

@section('header', 'Nueva Parte')

@section('content')
<div class="row">
    <div class="col-12">
        <!-- Panel principal -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <!-- Header -->
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center mb-4">
                    <div class="mb-3 mb-sm-0">
                        <h2 class="h4 fw-bold mb-1" :class="darkMode ? 'text-light' : 'text-dark'">
                            Crear Nueva Parte
                        </h2>
                        <p class="text-muted small mb-0">Registra una nueva parte desde aquí</p>
                    </div>
                </div>

                <!-- Formulario -->
                <form method="POST" action="{{ route('admin.almacenes.partes.store') }}" class="needs-validation" novalidate>
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="codigo" class="form-label small text-muted mb-1">Código *</label>
                            <input type="text" 
                                   name="codigo" 
                                   id="codigo" 
                                   class="form-control form-control-sm @error('codigo') is-invalid @enderror" 
                                   :class="darkMode ? 'bg-dark-subtle text-light border-secondary' : ''" 
                                   placeholder="Ingrese el código de la parte" 
                                   value="{{ old('codigo', $nuevoCodigo) }}" 
                                   required>
                            @error('codigo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="autogenerar_codigo" class="form-label small text-muted mb-1">Autogenerar Código *</label>
                            <select name="autogenerar_codigo" 
                                    id="autogenerar_codigo" 
                                    class="form-select form-control-sm @error('autogenerar_codigo') is-invalid @enderror" 
                                    :class="darkMode ? 'bg-dark-subtle text-light border-secondary' : ''" 
                                    required>
                                <option value="1" {{ old('autogenerar_codigo') == '1' ? 'selected' : '' }}>Sí</option>
                                <option value="0" {{ old('autogenerar_codigo') == '0' ? 'selected' : '' }}>No</option>
                            </select>
                            @error('autogenerar_codigo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="nombre" class="form-label small text-muted mb-1">Nombre del Producto *</label>
                            <input type="text" 
                                   name="nombre" 
                                   id="nombre" 
                                   class="form-control form-control-sm @error('nombre') is-invalid @enderror" 
                                   :class="darkMode ? 'bg-dark-subtle text-light border-secondary' : ''" 
                                   placeholder="Ingrese el nombre del producto" 
                                   value="{{ old('nombre') }}" 
                                   required>
                            @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="unidad_id" class="form-label small text-muted mb-1">Unidad *</label>
                            <select name="unidad_id" 
                                    id="unidad_id" 
                                    class="form-select form-control-sm @error('unidad_id') is-invalid @enderror" 
                                    :class="darkMode ? 'bg-dark-subtle text-light border-secondary' : ''" 
                                    required>
                                <option value="">Seleccionar</option>
                                @foreach ($unidades as $unidad)
                                    <option value="{{ $unidad->id }}" {{ old('unidad_id') == $unidad->id ? 'selected' : '' }}>{{ $unidad->nombre }}</option>
                                @endforeach
                            </select>
                            @error('unidad_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="fabricante_id" class="form-label small text-muted mb-1">Fabricante *</label>
                            <select name="fabricante_id" 
                                    id="fabricante_id" 
                                    class="form-select form-control-sm @error('fabricante_id') is-invalid @enderror" 
                                    :class="darkMode ? 'bg-dark-subtle text-light border-secondary' : ''">
                                <option value="">Seleccionar</option>
                                @foreach ($fabricantes as $fabricante)
                                    <option value="{{ $fabricante->id }}" {{ old('fabricante_id') == $fabricante->id ? 'selected' : '' }}>{{ $fabricante->nombre_fabricante }}</option>
                                @endforeach
                            </select>
                            @error('fabricante_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <!-- Agregar esto dentro del formulario en create.blade.php, junto con los otros campos -->
                        <div class="col-md-4">
                            <label for="proveedor_id" class="form-label small text-muted mb-1">Proveedor</label>
                            <select name="proveedor_id" 
                                    id="proveedor_id" 
                                    class="form-select form-control-sm @error('proveedor_id') is-invalid @enderror" 
                                    :class="darkMode ? 'bg-dark-subtle text-light border-secondary' : ''">
                                <option value="">Seleccionar (Opcional)</option>
                                @foreach ($proveedores as $proveedor)
                                    <option value="{{ $proveedor->id }}" {{ old('proveedor_id') == $proveedor->id ? 'selected' : '' }}>
                                        {{ $proveedor->nombre_completo }} ({{ $proveedor->documento_formateado }})
                                    </option>
                                @endforeach
                            </select>
                            @error('proveedor_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="categoria_parte_id" class="form-label small text-muted mb-1">Categoría *</label>
                            <select name="categoria_parte_id" 
                                    id="categoria_parte_id" 
                                    class="form-select form-control-sm @error('categoria_parte_id') is-invalid @enderror" 
                                    :class="darkMode ? 'bg-dark-subtle text-light border-secondary' : ''" 
                                    required>
                                <option value="">Seleccionar</option>
                                @foreach ($categorias as $categoria)
                                    <option value="{{ $categoria->id }}" {{ old('categoria_parte_id') == $categoria->id ? 'selected' : '' }}>{{ $categoria->nombre }}</option>
                                @endforeach
                            </select>
                            @error('categoria_parte_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="precio_venta" class="form-label small text-muted mb-1">Precio de Venta *</label>
                            <div class="input-group">
                                <input type="number" 
                                       name="precio_venta" 
                                       id="precio_venta" 
                                       class="form-control form-control-sm @error('precio_venta') is-invalid @enderror" 
                                       :class="darkMode ? 'bg-dark-subtle text-light border-secondary' : ''" 
                                       placeholder="Ingrese el precio de venta" 
                                       value="{{ old('precio_venta') }}" 
                                       step="0.01" 
                                       min="0" 
                                       required>
                                <select name="moneda_venta" 
                                        class="form-select form-control-sm @error('moneda_venta') is-invalid @enderror" 
                                        :class="darkMode ? 'bg-dark-subtle text-light border-secondary' : ''" 
                                        style="max-width: 120px;" 
                                        required>
                                    <option value="SOL" {{ old('moneda_venta') == 'SOL' ? 'selected' : '' }}>Soles</option>
                                    <option value="USD" {{ old('moneda_venta') == 'USD' ? 'selected' : '' }}>Dólares</option>
                                </select>
                                @error('precio_venta') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                @error('moneda_venta') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="precio_compra" class="form-label small text-muted mb-1">Precio de Compra Referencial *</label>
                            <div class="input-group">
                                <input type="number" 
                                       name="precio_compra" 
                                       id="precio_compra" 
                                       class="form-control form-control-sm @error('precio_compra') is-invalid @enderror" 
                                       :class="darkMode ? 'bg-dark-subtle text-light border-secondary' : ''" 
                                       placeholder="Ingrese el precio de compra" 
                                       value="{{ old('precio_compra') }}" 
                                       step="0.01" 
                                       min="0" 
                                       required>
                                <select name="moneda_compra" 
                                        class="form-select form-control-sm @error('moneda_compra') is-invalid @enderror" 
                                        :class="darkMode ? 'bg-dark-subtle text-light border-secondary' : ''" 
                                        style="max-width: 120px;" 
                                        required>
                                    <option value="SOL" {{ old('moneda_compra') == 'SOL' ? 'selected' : '' }}>Soles</option>
                                    <option value="USD" {{ old('moneda_compra') == 'USD' ? 'selected' : '' }}>Dólares</option>
                                </select>
                                @error('precio_compra') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                @error('moneda_compra') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Botones de acción -->
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('admin.almacenes.partes.index') }}" class="btn btn-outline-secondary btn-sm">
                            Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary btn-sm d-flex align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="me-2" style="height: 1rem; width: 1rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                            </svg>
                            Guardar Parte
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <!-- Validación de formulario con Bootstrap -->
    <script>
        (function () {
            'use strict';
            window.addEventListener('load', function () {
                var forms = document.getElementsByClassName('needs-validation');
                Array.prototype.filter.call(forms, function (form) {
                    form.addEventListener('submit', function (event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();

        document.getElementById('autogenerar_codigo').addEventListener('change', function() {
            document.getElementById('codigo').readOnly = this.value == '1';
            if (this.value == '1') {
                document.getElementById('codigo').value = '{{ $nuevoCodigo }}';
            }
        });
    </script>
@endpush