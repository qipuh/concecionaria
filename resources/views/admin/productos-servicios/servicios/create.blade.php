@extends('admin.layouts.app')

@section('title', 'Nuevo Servicio')

@section('header', 'Nuevo Servicio')

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
                            Crear Nuevo Servicio
                        </h2>
                        <p class="text-muted small mb-0">Registra un nuevo servicio desde aquí</p>
                    </div>
                </div>

                <!-- Formulario -->
                <form method="POST" action="{{ route('admin.almacenes.servicios-terceros.store') }}" class="needs-validation" novalidate>
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nombre" class="form-label small text-muted mb-1">Nombre *</label>
                            <input type="text" 
                                   name="nombre" 
                                   id="nombre" 
                                   class="form-control form-control-sm @error('nombre') is-invalid @enderror" 
                                   :class="darkMode ? 'bg-dark-subtle text-light border-secondary' : ''" 
                                   placeholder="Ingrese el nombre del servicio" 
                                   value="{{ old('nombre') }}" 
                                   required>
                            @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="precio" class="form-label small text-muted mb-1">Precio *</label>
                            <div class="input-group">
                                <input type="number" 
                                       name="precio" 
                                       id="precio" 
                                       class="form-control form-control-sm @error('precio') is-invalid @enderror" 
                                       :class="darkMode ? 'bg-dark-subtle text-light border-secondary' : ''" 
                                       placeholder="Ingrese el precio del servicio" 
                                       value="{{ old('precio') }}" 
                                       step="0.01" 
                                       min="0" 
                                       required>
                                <select name="moneda" 
                                        class="form-select form-control-sm @error('moneda') is-invalid @enderror" 
                                        :class="darkMode ? 'bg-dark-subtle text-light border-secondary' : ''" 
                                        style="max-width: 120px;" 
                                        required>
                                    <option value="SOL" {{ old('moneda') == 'SOL' ? 'selected' : '' }}>Soles</option>
                                    <option value="USD" {{ old('moneda') == 'USD' ? 'selected' : '' }}>Dólares</option>
                                </select>
                                @error('precio') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                @error('moneda') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="categoria_id" class="form-label small text-muted mb-1">Categoría *</label>
                            <select name="categoria_id" id="categoria_id"
                                    class="form-select form-control-sm @error('categoria_id') is-invalid @enderror"
                                    :class="darkMode ? 'bg-dark-subtle text-light border-secondary' : ''"
                                    required>
                                <option value="" disabled selected>Seleccione una categoría</option>
                                @foreach ($categorias as $categoria)
                                    <option value="{{ $categoria->id }}" {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                        {{ $categoria->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('categoria_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <!-- Botones de acción -->
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('admin.almacenes.servicios-terceros.index') }}" class="btn btn-outline-secondary btn-sm">
                            Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary btn-sm d-flex align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="me-2" style="height: 1rem; width: 1rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                            </svg>
                            Guardar Servicio
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
    </script>
@endpush