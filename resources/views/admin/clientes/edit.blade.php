@extends('admin.layouts.app')
@section('title', 'Editar Cliente')

@push('styles')
<style>
#documento-loading .spinner-border { width: 1rem; height: 1rem; }
</style>
@endpush

@section('content')
<div class="dashboard-hero" style="padding: 2rem 2rem; border-radius: 0 0 1.5rem 1.5rem; margin-bottom: 2.5rem;">
    <div class="hero-glow-alt" style="top: -50px; right: 0; filter: blur(60px); opacity: 0.2;"></div>
    <div class="container-fluid position-relative z-1">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center">
            <div class="mb-3 mb-lg-0">
                <div class="d-inline-flex align-items-center px-3 py-1 bg-white bg-opacity-10 rounded-pill fs-6 mb-3 border border-white border-opacity-25">
                    <i class="fas fa-user-edit text-info me-2"></i> Clientes
                </div>
                <h2 class="fw-bold mb-1 tracking-tight text-white display-6 text-shadow-sm">
                    Editar Cliente
                </h2>
                <p class="text-white-50 mb-0">
                    @if($cliente->tipo_cliente === 'juridica')
                        {{ $cliente->razon_social }}
                    @else
                        {{ $cliente->apellido_paterno }} {{ $cliente->apellido_materno }}, {{ $cliente->nombres }}
                    @endif
                </p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('admin.clientes.show', $cliente) }}"
                   class="btn bg-white text-dark rounded-pill px-4 py-2 fw-bold shadow-sm border-0">
                    <i class="fas fa-eye text-info me-2"></i> Ver Cliente
                </a>
                <a href="{{ route('admin.clientes.index') }}"
                   class="btn bg-white text-dark rounded-pill px-4 py-2 fw-bold shadow-sm border-0">
                    <i class="fas fa-arrow-left text-primary me-2"></i> Volver al Listado
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid px-3 px-lg-4 position-relative" style="top: -3.5rem; z-index: 10;">
<div class="row justify-content-center">
<div class="col-12 col-lg-10">

    @if($errors->any())
        <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4">
            <div class="fw-bold mb-1"><i class="fas fa-exclamation-circle me-2"></i>Corrija los siguientes errores:</div>
            <ul class="mb-0 ps-3 small">
                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.clientes.update', $cliente) }}" class="needs-validation" novalidate>
        @csrf
        @method('PUT')

        {{-- Sección: Documento --}}
        <div class="card dashboard-card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                <h6 class="fw-bold mb-0"><i class="fas fa-id-card me-2 text-primary"></i> Identificación</h6>
            </div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="tipo_cliente" class="form-label fw-semibold small text-uppercase text-muted">
                            Tipo de Cliente <span class="text-danger">*</span>
                        </label>
                        <select name="tipo_cliente" id="tipo_cliente"
                                class="form-select @error('tipo_cliente') is-invalid @enderror" required>
                            <option value="">Seleccione</option>
                            <option value="natural"  {{ old('tipo_cliente', $cliente->tipo_cliente) == 'natural'  ? 'selected' : '' }}>Persona Natural (DNI)</option>
                            <option value="juridica" {{ old('tipo_cliente', $cliente->tipo_cliente) == 'juridica' ? 'selected' : '' }}>Persona Jurídica (RUC)</option>
                        </select>
                        @error('tipo_cliente') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="documento_identidad" class="form-label fw-semibold small text-uppercase text-muted">
                            Número de Documento <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <input type="text" name="documento_identidad" id="documento_identidad"
                                   class="form-control @error('documento_identidad') is-invalid @enderror"
                                   value="{{ old('documento_identidad', $cliente->documento_identidad) }}"
                                   required maxlength="11" autocomplete="off">
                            <span class="input-group-text bg-white border-start-0" id="documento-loading" style="display: none;">
                                <div class="spinner-border spinner-border-sm text-primary" role="status">
                                    <span class="visually-hidden">Cargando...</span>
                                </div>
                            </span>
                        </div>
                        @error('documento_identidad') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <div class="form-text small mt-1" id="documento-hint"></div>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="button" id="validar_documento"
                                class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow-sm border-0 w-100">
                            <i class="fas fa-search me-2"></i> Validar Datos
                        </button>
                    </div>

                    {{-- Campos DNI --}}
                    <div class="col-12 dni-fields"
                         style="display: {{ old('tipo_cliente', $cliente->tipo_cliente) === 'natural' ? 'block' : 'none' }};">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="apellido_paterno" class="form-label fw-semibold small text-uppercase text-muted">Apellido Paterno</label>
                                <input type="text" name="apellido_paterno" id="apellido_paterno"
                                       class="form-control @error('apellido_paterno') is-invalid @enderror"
                                       value="{{ old('apellido_paterno', $cliente->apellido_paterno) }}">
                                @error('apellido_paterno') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="apellido_materno" class="form-label fw-semibold small text-uppercase text-muted">Apellido Materno</label>
                                <input type="text" name="apellido_materno" id="apellido_materno"
                                       class="form-control @error('apellido_materno') is-invalid @enderror"
                                       value="{{ old('apellido_materno', $cliente->apellido_materno) }}">
                                @error('apellido_materno') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="nombres" class="form-label fw-semibold small text-uppercase text-muted">Nombres</label>
                                <input type="text" name="nombres" id="nombres"
                                       class="form-control @error('nombres') is-invalid @enderror"
                                       value="{{ old('nombres', $cliente->nombres) }}">
                                @error('nombres') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Campos RUC --}}
                    <div class="col-12 ruc-fields"
                         style="display: {{ old('tipo_cliente', $cliente->tipo_cliente) === 'juridica' ? 'block' : 'none' }};">
                        <label for="razon_social" class="form-label fw-semibold small text-uppercase text-muted">Razón Social</label>
                        <input type="text" name="razon_social" id="razon_social"
                               class="form-control @error('razon_social') is-invalid @enderror"
                               value="{{ old('razon_social', $cliente->razon_social) }}">
                        @error('razon_social') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Sección: Ubicación --}}
        <div class="card dashboard-card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                <h6 class="fw-bold mb-0"><i class="fas fa-map-marker-alt me-2 text-primary"></i> Ubicación</h6>
            </div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="departamento" class="form-label fw-semibold small text-uppercase text-muted">
                            Departamento <span class="text-danger">*</span>
                        </label>
                        <select name="departamento" id="departamento"
                                class="form-select @error('departamento') is-invalid @enderror" required>
                            <option value="">Seleccione</option>
                            @foreach ($departamentos as $departamento)
                                <option value="{{ $departamento }}"
                                    {{ old('departamento', $cliente->departamento) == $departamento ? 'selected' : '' }}>
                                    {{ $departamento }}
                                </option>
                            @endforeach
                        </select>
                        @error('departamento') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="provincia" class="form-label fw-semibold small text-uppercase text-muted">
                            Provincia <span class="text-danger">*</span>
                        </label>
                        <select name="provincia" id="provincia"
                                class="form-select @error('provincia') is-invalid @enderror" required>
                            <option value="">Seleccione</option>
                            @foreach ($provincias as $provincia)
                                <option value="{{ $provincia }}"
                                    {{ old('provincia', $cliente->provincia) == $provincia ? 'selected' : '' }}>
                                    {{ $provincia }}
                                </option>
                            @endforeach
                        </select>
                        @error('provincia') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="distrito" class="form-label fw-semibold small text-uppercase text-muted">
                            Distrito <span class="text-danger">*</span>
                        </label>
                        <select name="distrito" id="distrito"
                                class="form-select @error('distrito') is-invalid @enderror" required>
                            <option value="">Seleccione</option>
                            @foreach ($distritos as $distrito)
                                <option value="{{ $distrito }}"
                                    {{ old('distrito', $cliente->distrito) == $distrito ? 'selected' : '' }}>
                                    {{ $distrito }}
                                </option>
                            @endforeach
                        </select>
                        @error('distrito') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Sección: Datos de Contacto --}}
        <div class="card dashboard-card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                <h6 class="fw-bold mb-0"><i class="fas fa-address-book me-2 text-primary"></i> Datos de Contacto</h6>
            </div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="correo" class="form-label fw-semibold small text-uppercase text-muted">Correo Electrónico</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0 text-muted"><i class="fas fa-envelope small"></i></span>
                            <input type="email" name="correo" id="correo"
                                   class="form-control border-start-0 @error('correo') is-invalid @enderror"
                                   placeholder="cliente@dominio.com"
                                   value="{{ old('correo', $cliente->correo) }}">
                        </div>
                        @error('correo') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="categoria_cliente_id" class="form-label fw-semibold small text-uppercase text-muted">
                            Categoría <span class="text-danger">*</span>
                        </label>
                        <select name="categoria_cliente_id" id="categoria_cliente_id"
                                class="form-select @error('categoria_cliente_id') is-invalid @enderror" required>
                            <option value="">Seleccione</option>
                            @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->id }}"
                                    {{ old('categoria_cliente_id', $cliente->categoria_cliente_id) == $categoria->id ? 'selected' : '' }}>
                                    {{ $categoria->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('categoria_cliente_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold small text-uppercase text-muted">
                            Canal de Captación <span class="text-danger">*</span>
                        </label>
                        <div class="d-flex flex-wrap gap-2 mt-1">
                            @foreach ($canales as $canal)
                                <input type="radio" class="btn-check" name="canal_captacion_id"
                                       id="canal_{{ $canal->id }}" value="{{ $canal->id }}"
                                       {{ old('canal_captacion_id', $cliente->canal_captacion_id) == $canal->id ? 'checked' : '' }} required>
                                <label class="btn btn-outline-primary rounded-pill px-4 py-2 fw-semibold"
                                       for="canal_{{ $canal->id }}">
                                    {{ $canal->nombre }}
                                </label>
                            @endforeach
                        </div>
                        @error('canal_captacion_id') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Sección: Teléfonos --}}
        <div class="card dashboard-card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                <h6 class="fw-bold mb-0"><i class="fas fa-phone me-2 text-primary"></i> Teléfonos Fijos</h6>
            </div>
            <div class="card-body p-4">
                <div id="telefonos-container" class="mb-3">
                    @if($cliente->telefonos->where('tipo', 'telefono')->count() > 0)
                        @foreach($cliente->telefonos->where('tipo', 'telefono') as $tel)
                        <div class="d-flex gap-2 mb-2 telefono-entry">
                            <div class="input-group flex-grow-1">
                                <span class="input-group-text bg-light border-0 text-muted"><i class="fas fa-phone-alt small"></i></span>
                                <input type="text" name="telefonos[]" class="form-control border-start-0"
                                       placeholder="Ej: 01234567" value="{{ $tel->numero }}">
                            </div>
                            <button type="button" class="btn btn-outline-danger rounded-circle flex-shrink-0 remove-telefono"
                                    style="width:38px;height:38px;" title="Eliminar">
                                <i class="fas fa-trash small"></i>
                            </button>
                        </div>
                        @endforeach
                    @else
                    <div class="d-flex gap-2 mb-2 telefono-entry">
                        <div class="input-group flex-grow-1">
                            <span class="input-group-text bg-light border-0 text-muted"><i class="fas fa-phone-alt small"></i></span>
                            <input type="text" name="telefonos[]" class="form-control border-start-0" placeholder="Ej: 01234567">
                        </div>
                        <button type="button" class="btn btn-outline-danger rounded-circle flex-shrink-0 remove-telefono"
                                style="width:38px;height:38px;" title="Eliminar">
                            <i class="fas fa-trash small"></i>
                        </button>
                    </div>
                    @endif
                </div>
                <button type="button" id="add-telefono"
                        class="btn btn-outline-primary rounded-pill px-3 py-2 fw-semibold small">
                    <i class="fas fa-plus me-1"></i> Agregar Teléfono
                </button>
            </div>
        </div>

        {{-- Sección: Celulares --}}
        <div class="card dashboard-card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                <h6 class="fw-bold mb-0"><i class="fas fa-mobile-alt me-2 text-primary"></i> Celulares</h6>
            </div>
            <div class="card-body p-4">
                <div id="celulares-container" class="mb-3">
                    @if($cliente->telefonos->where('tipo', 'celular')->count() > 0)
                        @foreach($cliente->telefonos->where('tipo', 'celular') as $cel)
                        <div class="d-flex gap-2 mb-2 celular-entry">
                            <div class="input-group flex-grow-1">
                                <span class="input-group-text bg-light border-0 text-muted"><i class="fas fa-mobile-alt small"></i></span>
                                <input type="text" name="celulares[]" class="form-control border-start-0"
                                       placeholder="Ej: 987654321" value="{{ $cel->numero }}">
                            </div>
                            <button type="button" class="btn btn-outline-danger rounded-circle flex-shrink-0 remove-celular"
                                    style="width:38px;height:38px;" title="Eliminar">
                                <i class="fas fa-trash small"></i>
                            </button>
                        </div>
                        @endforeach
                    @else
                    <div class="d-flex gap-2 mb-2 celular-entry">
                        <div class="input-group flex-grow-1">
                            <span class="input-group-text bg-light border-0 text-muted"><i class="fas fa-mobile-alt small"></i></span>
                            <input type="text" name="celulares[]" class="form-control border-start-0" placeholder="Ej: 987654321">
                        </div>
                        <button type="button" class="btn btn-outline-danger rounded-circle flex-shrink-0 remove-celular"
                                style="width:38px;height:38px;" title="Eliminar">
                            <i class="fas fa-trash small"></i>
                        </button>
                    </div>
                    @endif
                </div>
                <button type="button" id="add-celular"
                        class="btn btn-outline-primary rounded-pill px-3 py-2 fw-semibold small">
                    <i class="fas fa-plus me-1"></i> Agregar Celular
                </button>
            </div>
        </div>

        {{-- Botones --}}
        <div class="d-flex justify-content-end gap-2 pb-4">
            <a href="{{ route('admin.clientes.show', $cliente) }}"
               class="btn btn-outline-secondary rounded-pill px-4 py-2 fw-bold border-0">
                <i class="fas fa-times me-2"></i> Cancelar
            </a>
            <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow-sm border-0">
                <i class="fas fa-save me-2"></i> Guardar Cambios
            </button>
        </div>

    </form>
</div>
</div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    'use strict';

    // Bootstrap validation
    var forms = document.getElementsByClassName('needs-validation');
    Array.prototype.filter.call(forms, function (form) {
        form.addEventListener('submit', function (event) {
            if (form.checkValidity() === false) { event.preventDefault(); event.stopPropagation(); }
            form.classList.add('was-validated');
        }, false);
    });

    const tipoClienteSelect = document.getElementById('tipo_cliente');

    function mostrarCamposSegunTipo() {
        const tipo = tipoClienteSelect.value;
        document.querySelectorAll('.dni-fields').forEach(f => f.style.display = tipo === 'natural'  ? 'block' : 'none');
        document.querySelectorAll('.ruc-fields').forEach(f => f.style.display = tipo === 'juridica' ? 'block' : 'none');
    }

    tipoClienteSelect.addEventListener('change', mostrarCamposSegunTipo);

    // Validar manualmente
    document.getElementById('validar_documento').addEventListener('click', function () {
        const tipo   = tipoClienteSelect.value;
        const numero = document.getElementById('documento_identidad').value;
        if (!tipo || !numero) { alert('Seleccione el tipo de cliente y proporcione el número de documento.'); return; }
        validarAPI(tipo === 'natural' ? 'DNI' : 'RUC', numero);
    });

    function validarAPI(tipoDoc, numeroDoc) {
        const btn     = document.getElementById('validar_documento');
        const spinner = document.getElementById('documento-loading');
        const hint    = document.getElementById('documento-hint');

        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Validando...';
        spinner.style.display = 'flex';

        fetch('{{ route('admin.clientes.validar-documento') }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ tipo_documento: tipoDoc, numero_documento: numeroDoc }),
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                procesarDatos(data.data, tipoDoc);
                hint.innerHTML = '<i class="fas fa-check text-success"></i> Validación exitosa';
            } else {
                alert(data.message || 'No se encontraron datos.');
            }
        })
        .catch(() => { alert('Error al validar el documento. Intente nuevamente.'); })
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-search me-2"></i> Validar Datos';
            spinner.style.display = 'none';
        });
    }

    function procesarDatos(data, tipoDoc) {
        if (tipoDoc === 'DNI') {
            document.querySelectorAll('.dni-fields').forEach(f => f.style.display = 'block');
            document.querySelectorAll('.ruc-fields').forEach(f => f.style.display = 'none');
            document.getElementById('apellido_paterno').value = data.apellido_paterno || '';
            document.getElementById('apellido_materno').value = data.apellido_materno || '';
            document.getElementById('nombres').value = data.nombres || '';
            document.getElementById('razon_social').value = '';
        } else {
            document.querySelectorAll('.dni-fields').forEach(f => f.style.display = 'none');
            document.querySelectorAll('.ruc-fields').forEach(f => f.style.display = 'block');
            document.getElementById('razon_social').value = data.nombre_o_razon_social || '';
            document.getElementById('apellido_paterno').value = '';
            document.getElementById('apellido_materno').value = '';
            document.getElementById('nombres').value = '';
            if (data.departamento) {
                const depSel = document.getElementById('departamento');
                depSel.value = data.departamento;
                depSel.dispatchEvent(new Event('change'));
                setTimeout(() => {
                    document.getElementById('provincia').value = data.provincia || '';
                    document.getElementById('provincia').dispatchEvent(new Event('change'));
                    setTimeout(() => { document.getElementById('distrito').value = data.distrito || ''; }, 500);
                }, 500);
            }
        }
    }

    // Cargar provincias/distritos via AJAX cuando cambia el departamento
    document.getElementById('departamento').addEventListener('change', function () {
        const dep     = this.value;
        const provSel = document.getElementById('provincia');
        const distSel = document.getElementById('distrito');

        // Preserve current values for re-selection
        const currentProv = provSel.value || '{{ $cliente->provincia }}';
        const currentDist = distSel.value || '{{ $cliente->distrito }}';

        provSel.innerHTML = '<option value="">Seleccione</option>';
        distSel.innerHTML = '<option value="">Seleccione</option>';
        if (!dep) return;

        provSel.disabled = true;
        provSel.innerHTML = '<option value="">Cargando...</option>';
        fetch('{{ route('admin.clientes.provincias') }}?departamento=' + encodeURIComponent(dep))
            .then(r => r.ok ? r.json() : Promise.reject())
            .then(list => {
                provSel.disabled = false;
                provSel.innerHTML = '<option value="">Seleccione</option>';
                list.forEach(p => provSel.innerHTML += `<option value="${p}">${p}</option>`);
                if (currentProv) {
                    provSel.value = currentProv;
                    if (provSel.value) provSel.dispatchEvent(new Event('change'));
                }
            })
            .catch(() => { provSel.disabled = false; provSel.innerHTML = '<option value="">Error — intente de nuevo</option>'; });
    });

    document.getElementById('provincia').addEventListener('change', function () {
        const dep     = document.getElementById('departamento').value;
        const prov    = this.value;
        const distSel = document.getElementById('distrito');

        const currentDist = distSel.value || '{{ $cliente->distrito }}';

        distSel.innerHTML = '<option value="">Seleccione</option>';
        if (!dep || !prov) return;

        distSel.disabled = true;
        distSel.innerHTML = '<option value="">Cargando...</option>';
        fetch('{{ route('admin.clientes.distritos') }}?departamento=' + encodeURIComponent(dep) + '&provincia=' + encodeURIComponent(prov))
            .then(r => r.ok ? r.json() : Promise.reject())
            .then(list => {
                distSel.disabled = false;
                distSel.innerHTML = '<option value="">Seleccione</option>';
                list.forEach(d => distSel.innerHTML += `<option value="${d}">${d}</option>`);
                if (currentDist) distSel.value = currentDist;
            })
            .catch(() => { distSel.disabled = false; distSel.innerHTML = '<option value="">Error — intente de nuevo</option>'; });
    });

    // Teléfonos dinámicos
    function entradaTelefono() {
        return `<div class="d-flex gap-2 mb-2 telefono-entry">
            <div class="input-group flex-grow-1">
                <span class="input-group-text bg-light border-0 text-muted"><i class="fas fa-phone-alt small"></i></span>
                <input type="text" name="telefonos[]" class="form-control border-start-0" placeholder="Ej: 01234567">
            </div>
            <button type="button" class="btn btn-outline-danger rounded-circle flex-shrink-0 remove-telefono" style="width:38px;height:38px;" title="Eliminar">
                <i class="fas fa-trash small"></i>
            </button>
        </div>`;
    }

    document.getElementById('add-telefono').addEventListener('click', function () {
        document.getElementById('telefonos-container').insertAdjacentHTML('beforeend', entradaTelefono());
    });

    document.addEventListener('click', function (e) {
        if (e.target.closest('.remove-telefono') && document.querySelectorAll('.telefono-entry').length > 1)
            e.target.closest('.telefono-entry').remove();
    });

    // Celulares dinámicos
    function entradaCelular() {
        return `<div class="d-flex gap-2 mb-2 celular-entry">
            <div class="input-group flex-grow-1">
                <span class="input-group-text bg-light border-0 text-muted"><i class="fas fa-mobile-alt small"></i></span>
                <input type="text" name="celulares[]" class="form-control border-start-0" placeholder="Ej: 987654321">
            </div>
            <button type="button" class="btn btn-outline-danger rounded-circle flex-shrink-0 remove-celular" style="width:38px;height:38px;" title="Eliminar">
                <i class="fas fa-trash small"></i>
            </button>
        </div>`;
    }

    document.getElementById('add-celular').addEventListener('click', function () {
        document.getElementById('celulares-container').insertAdjacentHTML('beforeend', entradaCelular());
    });

    document.addEventListener('click', function (e) {
        if (e.target.closest('.remove-celular') && document.querySelectorAll('.celular-entry').length > 1)
            e.target.closest('.celular-entry').remove();
    });
});
</script>
@endpush
