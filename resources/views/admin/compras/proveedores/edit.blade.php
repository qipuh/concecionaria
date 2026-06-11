@extends('admin.layouts.app')
@section('title', 'Editar Proveedor')

@push('styles')
<style>
.form-check-input { width: 2.5em; height: 1.25em; }
.form-check-label { margin-left: 0.5em; }
</style>
@endpush

@section('content')
<div class="dashboard-hero" style="padding: 2rem 2rem; border-radius: 0 0 1.5rem 1.5rem; margin-bottom: 2.5rem;">
    <div class="hero-glow-alt" style="top: -50px; right: 0; filter: blur(60px); opacity: 0.2;"></div>
    <div class="container-fluid position-relative z-1">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center">
            <div class="mb-3 mb-lg-0">
                <div class="d-inline-flex align-items-center px-3 py-1 bg-white bg-opacity-10 rounded-pill fs-6 mb-3 border border-white border-opacity-25">
                    <i class="fas fa-edit text-info me-2"></i> Editar Proveedor
                </div>
                <h2 class="fw-bold mb-1 tracking-tight text-white display-6 text-shadow-sm">
                    {{ $proveedor->razon_social ?? ($proveedor->nombres . ' ' . $proveedor->apellido_paterno) }}
                </h2>
                <p class="text-white-50 mb-0">Modifica la información de contacto o del documento.</p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('admin.compras.proveedores.index') }}"
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
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.compras.proveedores.update', $proveedor) }}" class="needs-validation" novalidate>
        @csrf
        @method('PUT')

        {{-- Sección: Documento --}}
        <div class="card dashboard-card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                <h6 class="fw-bold mb-0"><i class="fas fa-id-card me-2 text-primary"></i> Información del Documento</h6>
            </div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="tipo_documento" class="form-label fw-semibold small text-uppercase text-muted">
                            Tipo de Documento <span class="text-danger">*</span>
                        </label>
                        <select name="tipo_documento" id="tipo_documento"
                                class="form-select @error('tipo_documento') is-invalid @enderror" required>
                            <option value="">Seleccione</option>
                            <option value="DNI" {{ $proveedor->tipo_documento == 'DNI' ? 'selected' : '' }}>DNI</option>
                            <option value="RUC" {{ $proveedor->tipo_documento == 'RUC' ? 'selected' : '' }}>RUC</option>
                        </select>
                        @error('tipo_documento') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="numero_documento" class="form-label fw-semibold small text-uppercase text-muted">
                            Número de Documento <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="numero_documento" id="numero_documento"
                               class="form-control @error('numero_documento') is-invalid @enderror"
                               value="{{ $proveedor->numero_documento }}" required>
                        @error('numero_documento') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="button" id="validar_documento"
                                class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow-sm border-0 w-100">
                            <i class="fas fa-search me-2"></i> Validar Datos
                        </button>
                    </div>

                    {{-- Campos DNI --}}
                    <div class="col-12 dni-fields" style="display: {{ $proveedor->tipo_documento == 'DNI' ? 'block' : 'none' }};">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="apellido_paterno" class="form-label fw-semibold small text-uppercase text-muted">Apellido Paterno</label>
                                <input type="text" name="apellido_paterno" id="apellido_paterno"
                                       class="form-control bg-light @error('apellido_paterno') is-invalid @enderror"
                                       value="{{ $proveedor->apellido_paterno }}" readonly>
                                @error('apellido_paterno') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="apellido_materno" class="form-label fw-semibold small text-uppercase text-muted">Apellido Materno</label>
                                <input type="text" name="apellido_materno" id="apellido_materno"
                                       class="form-control bg-light @error('apellido_materno') is-invalid @enderror"
                                       value="{{ $proveedor->apellido_materno }}" readonly>
                                @error('apellido_materno') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="nombres" class="form-label fw-semibold small text-uppercase text-muted">Nombres</label>
                                <input type="text" name="nombres" id="nombres"
                                       class="form-control bg-light @error('nombres') is-invalid @enderror"
                                       value="{{ $proveedor->nombres }}" readonly>
                                @error('nombres') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Campos RUC --}}
                    <div class="col-12 ruc-fields" style="display: {{ $proveedor->tipo_documento == 'RUC' ? 'block' : 'none' }};">
                        <label for="razon_social" class="form-label fw-semibold small text-uppercase text-muted">Razón Social</label>
                        <input type="text" name="razon_social" id="razon_social"
                               class="form-control bg-light @error('razon_social') is-invalid @enderror"
                               value="{{ $proveedor->razon_social }}" readonly>
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
                    <div class="col-md-6">
                        <label for="direccion" class="form-label fw-semibold small text-uppercase text-muted">Dirección</label>
                        <input type="text" name="direccion" id="direccion"
                               class="form-control @error('direccion') is-invalid @enderror"
                               value="{{ $proveedor->direccion }}" placeholder="Av. Ejemplo 123">
                        @error('direccion') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-2">
                        <label for="departamento" class="form-label fw-semibold small text-uppercase text-muted">
                            Departamento <span class="text-danger">*</span>
                        </label>
                        <select name="departamento" id="departamento"
                                class="form-select @error('departamento') is-invalid @enderror" required>
                            <option value="">Seleccione</option>
                            @foreach ($departamentos as $departamento)
                                <option value="{{ $departamento }}" {{ $proveedor->departamento == $departamento ? 'selected' : '' }}>
                                    {{ $departamento }}
                                </option>
                            @endforeach
                        </select>
                        @error('departamento') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-2">
                        <label for="provincia" class="form-label fw-semibold small text-uppercase text-muted">
                            Provincia <span class="text-danger">*</span>
                        </label>
                        <select name="provincia" id="provincia"
                                class="form-select @error('provincia') is-invalid @enderror" required>
                            <option value="">Seleccione</option>
                            @foreach ($provincias as $provincia)
                                <option value="{{ $provincia }}" {{ $proveedor->provincia == $provincia ? 'selected' : '' }}>
                                    {{ $provincia }}
                                </option>
                            @endforeach
                        </select>
                        @error('provincia') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-2">
                        <label for="distrito" class="form-label fw-semibold small text-uppercase text-muted">
                            Distrito <span class="text-danger">*</span>
                        </label>
                        <select name="distrito" id="distrito"
                                class="form-select @error('distrito') is-invalid @enderror" required>
                            <option value="">Seleccione</option>
                            @foreach ($distritos as $distrito)
                                <option value="{{ $distrito }}" {{ $proveedor->distrito == $distrito ? 'selected' : '' }}>
                                    {{ $distrito }}
                                </option>
                            @endforeach
                        </select>
                        @error('distrito') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Sección: Detalles --}}
        <div class="card dashboard-card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                <h6 class="fw-bold mb-0"><i class="fas fa-sliders-h me-2 text-primary"></i> Detalles del Proveedor</h6>
            </div>
            <div class="card-body p-4">
                <div class="row g-3 align-items-center">
                    <div class="col-md-4">
                        <label for="categoria_proveedor_id" class="form-label fw-semibold small text-uppercase text-muted">
                            Categoría <span class="text-danger">*</span>
                        </label>
                        <select name="categoria_proveedor_id" id="categoria_proveedor_id"
                                class="form-select @error('categoria_proveedor_id') is-invalid @enderror" required>
                            <option value="">Seleccione</option>
                            @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->id }}"
                                    {{ $proveedor->categoria_proveedor_id == $categoria->id ? 'selected' : '' }}>
                                    {{ $categoria->nombre_categoria_proveedor }}
                                </option>
                            @endforeach
                        </select>
                        @error('categoria_proveedor_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small text-uppercase text-muted d-block">
                            ¿Cubre Garantías? <span class="text-danger">*</span>
                        </label>
                        <div class="form-check form-switch mt-1">
                            <input class="form-check-input" type="checkbox" name="cubre_garantias"
                                   id="cubre_garantias" value="Sí"
                                   {{ $proveedor->cubre_garantias == 'Sí' ? 'checked' : '' }}>
                            <label class="form-check-label" for="cubre_garantias" id="cubre_garantias_label">
                                {{ $proveedor->cubre_garantias == 'Sí' ? 'Sí' : 'No' }}
                            </label>
                        </div>
                        @error('cubre_garantias') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small text-uppercase text-muted d-block">
                            ¿Es Aseguradora? <span class="text-danger">*</span>
                        </label>
                        <div class="form-check form-switch mt-1">
                            <input class="form-check-input" type="checkbox" name="es_aseguradora"
                                   id="es_aseguradora" value="Sí"
                                   {{ $proveedor->es_aseguradora == 'Sí' ? 'checked' : '' }}>
                            <label class="form-check-label" for="es_aseguradora" id="es_aseguradora_label">
                                {{ $proveedor->es_aseguradora == 'Sí' ? 'Sí' : 'No' }}
                            </label>
                        </div>
                        @error('es_aseguradora') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Sección: Correos --}}
        <div class="card dashboard-card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                <h6 class="fw-bold mb-0"><i class="fas fa-envelope me-2 text-primary"></i> Correos de Contacto</h6>
            </div>
            <div class="card-body p-4">
                <div id="correos-container" class="mb-3">
                    @foreach ($proveedor->correos as $correo)
                    <div class="d-flex gap-2 mb-2 correo-entry">
                        <input type="email" name="correos[]" class="form-control"
                               value="{{ $correo->correo }}" placeholder="Ej: proveedor@dominio.com" required>
                        <button type="button"
                                class="btn btn-outline-danger rounded-circle flex-shrink-0 remove-correo"
                                style="width:38px;height:38px;" title="Eliminar">
                            <i class="fas fa-trash small"></i>
                        </button>
                    </div>
                    @endforeach
                    @if ($proveedor->correos->isEmpty())
                    <div class="d-flex gap-2 mb-2 correo-entry">
                        <input type="email" name="correos[]" class="form-control"
                               placeholder="Ej: proveedor@dominio.com" required>
                        <button type="button"
                                class="btn btn-outline-danger rounded-circle flex-shrink-0 remove-correo"
                                style="width:38px;height:38px;" title="Eliminar">
                            <i class="fas fa-trash small"></i>
                        </button>
                    </div>
                    @endif
                </div>
                <button type="button" id="add-correo"
                        class="btn btn-outline-primary rounded-pill px-3 py-2 fw-semibold small">
                    <i class="fas fa-plus me-1"></i> Agregar Correo
                </button>
            </div>
        </div>

        {{-- Sección: Contactos --}}
        <div class="card dashboard-card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                <h6 class="fw-bold mb-0"><i class="fas fa-phone me-2 text-primary"></i> Contactos</h6>
            </div>
            <div class="card-body p-4">
                <div id="contactos-container" class="mb-3">
                    @foreach ($proveedor->contactos as $index => $contacto)
                    <div class="d-flex gap-2 mb-2 align-items-center contacto-entry">
                        <input type="text" name="contactos[{{ $index }}][nombre]" class="form-control"
                               value="{{ $contacto->nombre }}" placeholder="Nombre del contacto" required>
                        <input type="text" name="contactos[{{ $index }}][telefono]" class="form-control"
                               value="{{ $contacto->telefono }}" placeholder="Teléfono" required>
                        <button type="button"
                                class="btn btn-outline-danger rounded-circle flex-shrink-0 remove-contacto"
                                style="width:38px;height:38px;" title="Eliminar">
                            <i class="fas fa-trash small"></i>
                        </button>
                    </div>
                    @endforeach
                    @if ($proveedor->contactos->isEmpty())
                    <div class="d-flex gap-2 mb-2 align-items-center contacto-entry">
                        <input type="text" name="contactos[0][nombre]" class="form-control"
                               placeholder="Nombre del contacto" required>
                        <input type="text" name="contactos[0][telefono]" class="form-control"
                               placeholder="Teléfono" required>
                        <button type="button"
                                class="btn btn-outline-danger rounded-circle flex-shrink-0 remove-contacto"
                                style="width:38px;height:38px;" title="Eliminar">
                            <i class="fas fa-trash small"></i>
                        </button>
                    </div>
                    @endif
                </div>
                <button type="button" id="add-contacto"
                        class="btn btn-outline-primary rounded-pill px-3 py-2 fw-semibold small">
                    <i class="fas fa-plus me-1"></i> Agregar Contacto
                </button>
            </div>
        </div>

        {{-- Botones --}}
        <div class="d-flex justify-content-end gap-2 pb-4">
            <a href="{{ route('admin.compras.proveedores.index') }}"
               class="btn btn-outline-secondary rounded-pill px-4 py-2 fw-bold border-0">
                <i class="fas fa-times me-2"></i> Cancelar
            </a>
            <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow-sm border-0">
                <i class="fas fa-save me-2"></i> Actualizar Proveedor
            </button>
        </div>

    </form>
</div>
</div>
</div>
@endsection

@push('scripts')
<script>
(function () {
    'use strict';

    function updateSwitchLabels() {
        document.querySelectorAll('.form-check-input').forEach(sw => {
            const label = sw.nextElementSibling;
            if (label) label.textContent = sw.checked ? 'Sí' : 'No';
        });
    }

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

        const departamentoSelect = document.getElementById('departamento');
        const provinciaSelect    = document.getElementById('provincia');
        if (departamentoSelect.value) departamentoSelect.dispatchEvent(new Event('change'));
        if (provinciaSelect.value)    provinciaSelect.dispatchEvent(new Event('change'));

        updateSwitchLabels();
    });

    function resetForm() {
        document.getElementById('numero_documento').value = '';
        document.getElementById('apellido_paterno').value = '';
        document.getElementById('apellido_materno').value = '';
        document.getElementById('nombres').value = '';
        document.getElementById('razon_social').value = '';
        document.getElementById('direccion').value = '';
        document.getElementById('departamento').value = '';
        document.getElementById('provincia').innerHTML = '<option value="">Seleccione</option>';
        document.getElementById('distrito').innerHTML  = '<option value="">Seleccione</option>';
        document.getElementById('categoria_proveedor_id').value = '';
        document.getElementById('cubre_garantias').checked = false;
        document.getElementById('es_aseguradora').checked  = false;
        updateSwitchLabels();

        document.querySelectorAll('.dni-fields').forEach(f => f.style.display = 'none');
        document.querySelectorAll('.ruc-fields').forEach(f => f.style.display = 'none');

        document.getElementById('correos-container').innerHTML = `
            <div class="d-flex gap-2 mb-2 correo-entry">
                <input type="email" name="correos[]" class="form-control" placeholder="Ej: proveedor@dominio.com" required>
                <button type="button" class="btn btn-outline-danger rounded-circle flex-shrink-0 remove-correo" style="width:38px;height:38px;" title="Eliminar">
                    <i class="fas fa-trash small"></i>
                </button>
            </div>`;
        correoIndex = 1;

        document.getElementById('contactos-container').innerHTML = `
            <div class="d-flex gap-2 mb-2 align-items-center contacto-entry">
                <input type="text" name="contactos[0][nombre]" class="form-control" placeholder="Nombre del contacto" required>
                <input type="text" name="contactos[0][telefono]" class="form-control" placeholder="Teléfono" required>
                <button type="button" class="btn btn-outline-danger rounded-circle flex-shrink-0 remove-contacto" style="width:38px;height:38px;" title="Eliminar">
                    <i class="fas fa-trash small"></i>
                </button>
            </div>`;
        contactoIndex = 1;

        document.querySelector('form.needs-validation').classList.remove('was-validated');
    }

    document.getElementById('tipo_documento').addEventListener('change', resetForm);

    document.getElementById('validar_documento').addEventListener('click', function () {
        const tipoDocumento   = document.getElementById('tipo_documento').value;
        const numeroDocumento = document.getElementById('numero_documento').value;

        if (!tipoDocumento || !numeroDocumento) {
            alert('Por favor, seleccione el tipo de documento y proporcione el número.');
            return;
        }

        const btn = this;
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Validando...';

        fetch('{{ route('admin.compras.proveedores.validar.documento') }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ tipo_documento: tipoDocumento, numero_documento: numeroDocumento }),
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                if (tipoDocumento === 'DNI') {
                    document.querySelectorAll('.dni-fields').forEach(f => f.style.display = 'block');
                    document.querySelectorAll('.ruc-fields').forEach(f => f.style.display = 'none');
                    document.getElementById('apellido_paterno').value = data.data.apellido_paterno || '';
                    document.getElementById('apellido_materno').value = data.data.apellido_materno || '';
                    document.getElementById('nombres').value = data.data.nombres || '';
                } else if (tipoDocumento === 'RUC') {
                    document.querySelectorAll('.dni-fields').forEach(f => f.style.display = 'none');
                    document.querySelectorAll('.ruc-fields').forEach(f => f.style.display = 'block');
                    document.getElementById('razon_social').value = data.data.nombre_o_razon_social || '';
                    document.getElementById('apellido_paterno').value = '';
                    document.getElementById('apellido_materno').value = '';
                    document.getElementById('nombres').value = '';
                    document.getElementById('direccion').value = data.data.direccion || '';
                    document.getElementById('departamento').value = data.data.departamento || '';
                    document.getElementById('departamento').dispatchEvent(new Event('change'));
                    setTimeout(() => {
                        document.getElementById('provincia').value = data.data.provincia || '';
                        document.getElementById('provincia').dispatchEvent(new Event('change'));
                        setTimeout(() => { document.getElementById('distrito').value = data.data.distrito || ''; }, 500);
                    }, 500);
                }
            } else {
                alert(data.message);
            }
        })
        .catch(() => alert('Error al validar el documento.'))
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-search me-2"></i> Validar Datos';
        });
    });

    document.getElementById('departamento').addEventListener('change', function () {
        const dep = this.value;
        const provSel  = document.getElementById('provincia');
        const distSel  = document.getElementById('distrito');
        provSel.innerHTML = '<option value="">Seleccione</option>';
        distSel.innerHTML = '<option value="">Seleccione</option>';
        if (!dep) return;
        fetch('{{ route('admin.compras.proveedores.provincias') }}?departamento=' + encodeURIComponent(dep))
            .then(r => r.json())
            .then(provincias => provincias.forEach(p => provSel.innerHTML += `<option value="${p}">${p}</option>`))
            .catch(() => alert('Error al cargar las provincias.'));
    });

    document.getElementById('provincia').addEventListener('change', function () {
        const dep  = document.getElementById('departamento').value;
        const prov = this.value;
        const distSel = document.getElementById('distrito');
        distSel.innerHTML = '<option value="">Seleccione</option>';
        if (!dep || !prov) return;
        fetch('{{ route('admin.compras.proveedores.distritos') }}?departamento=' + encodeURIComponent(dep) + '&provincia=' + encodeURIComponent(prov))
            .then(r => r.json())
            .then(distritos => distritos.forEach(d => distSel.innerHTML += `<option value="${d}">${d}</option>`))
            .catch(() => alert('Error al cargar los distritos.'));
    });

    let correoIndex = {{ $proveedor->correos->count() ?: 1 }};
    document.getElementById('add-correo').addEventListener('click', function () {
        document.getElementById('correos-container').insertAdjacentHTML('beforeend', `
            <div class="d-flex gap-2 mb-2 correo-entry">
                <input type="email" name="correos[]" class="form-control" placeholder="Ej: proveedor@dominio.com" required>
                <button type="button" class="btn btn-outline-danger rounded-circle flex-shrink-0 remove-correo" style="width:38px;height:38px;" title="Eliminar">
                    <i class="fas fa-trash small"></i>
                </button>
            </div>`);
        correoIndex++;
    });

    document.addEventListener('click', function (e) {
        if (e.target.closest('.remove-correo')) {
            if (document.querySelectorAll('.correo-entry').length > 1)
                e.target.closest('.correo-entry').remove();
        }
    });

    let contactoIndex = {{ $proveedor->contactos->count() ?: 1 }};
    document.getElementById('add-contacto').addEventListener('click', function () {
        document.getElementById('contactos-container').insertAdjacentHTML('beforeend', `
            <div class="d-flex gap-2 mb-2 align-items-center contacto-entry">
                <input type="text" name="contactos[${contactoIndex}][nombre]" class="form-control" placeholder="Nombre del contacto" required>
                <input type="text" name="contactos[${contactoIndex}][telefono]" class="form-control" placeholder="Teléfono" required>
                <button type="button" class="btn btn-outline-danger rounded-circle flex-shrink-0 remove-contacto" style="width:38px;height:38px;" title="Eliminar">
                    <i class="fas fa-trash small"></i>
                </button>
            </div>`);
        contactoIndex++;
    });

    document.addEventListener('click', function (e) {
        if (e.target.closest('.remove-contacto')) {
            if (document.querySelectorAll('.contacto-entry').length > 1)
                e.target.closest('.contacto-entry').remove();
        }
    });

    document.querySelectorAll('.form-check-input').forEach(sw => {
        sw.addEventListener('change', function () {
            const label = this.nextElementSibling;
            if (label) label.textContent = this.checked ? 'Sí' : 'No';
        });
    });
})();
</script>
@endpush
