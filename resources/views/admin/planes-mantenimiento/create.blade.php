@extends('admin.layouts.app')

@section('title', 'Crear Plan de Mantenimiento')

@section('content')
<div class="container-fluid">
    <form id="planMantenimientoForm" action="{{ route('admin.planes-mantenimiento.store') }}" method="POST">
        @csrf
        
        <!-- Header -->
        <div class="row mb-3">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h2>
                        <i class="fas fa-wrench mr-2"></i>
                        Crear Plan de Mantenimiento
                    </h2>
                    <div>
                        <a href="{{ route('admin.planes-mantenimiento.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left mr-1"></i>
                            Volver
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i>
                            Guardar Plan
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección 1: Información General -->
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">1. Información General del Plan</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nombre" class="required">Nombre del Plan</label>
                                    <input type="text" name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror" 
                                           value="{{ old('nombre') }}" required>
                                    @error('nombre')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="modelo_vehiculo" class="required">Modelo de Vehículo</label>
                                    <select name="modelo_vehiculo" id="modelo_vehiculo" 
                                            class="form-control @error('modelo_vehiculo') is-invalid @enderror" required>
                                        <option value="">Seleccionar modelo</option>
                                        @foreach($modelos as $modelo)
                                            <option value="{{ $modelo->nombre }}" 
                                                    {{ old('modelo_vehiculo') == $modelo->nombre ? 'selected' : '' }}>
                                                {{ $modelo->nombre }}
                                                @if($modelo->marca)
                                                    - {{ $modelo->marca->nombre }}
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('modelo_vehiculo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="ano_modelo" class="required">Año del Modelo</label>
                                    <input type="number" name="ano_modelo" id="ano_modelo" 
                                           class="form-control @error('ano_modelo') is-invalid @enderror" 
                                           min="1990" max="{{ date('Y') + 2 }}" 
                                           value="{{ old('ano_modelo', date('Y')) }}" required>
                                    @error('ano_modelo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="required">Tipo de Transmisión</label>
                                    <div class="d-flex">
                                        <div class="form-check form-check-inline">
                                            <input type="radio" name="tipo_transmision" value="MT" id="trans_mt" 
                                                   class="form-check-input @error('tipo_transmision') is-invalid @enderror"
                                                   {{ old('tipo_transmision', 'MT') == 'MT' ? 'checked' : '' }} required>
                                            <label class="form-check-label" for="trans_mt">MT</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" name="tipo_transmision" value="AT" id="trans_at" 
                                                   class="form-check-input"
                                                   {{ old('tipo_transmision') == 'AT' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="trans_at">AT</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" name="tipo_transmision" value="CVT" id="trans_cvt" 
                                                   class="form-check-input"
                                                   {{ old('tipo_transmision') == 'CVT' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="trans_cvt">CVT</label>
                                        </div>
                                    </div>
                                    @error('tipo_transmision')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tono_vehiculo">Tono del Vehículo</label>
                                    <input type="text" name="tono_vehiculo" id="tono_vehiculo" 
                                           class="form-control @error('tono_vehiculo') is-invalid @enderror" 
                                           value="{{ old('tono_vehiculo') }}" placeholder="Ej: Comercial, Pasajeros">
                                    @error('tono_vehiculo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="descripcion">Descripción</label>
                                    <textarea name="descripcion" id="descripcion" rows="3" 
                                              class="form-control @error('descripcion') is-invalid @enderror"
                                              placeholder="Descripción detallada del plan de mantenimiento">{{ old('descripcion') }}</textarea>
                                    @error('descripcion')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sección 2: Configuración de Intervalos -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">2. Configuración de Intervalos</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="intervalo_base" class="required">Intervalo Base (km)</label>
                            <input type="number" name="intervalo_base" id="intervalo_base" 
                                   class="form-control @error('intervalo_base') is-invalid @enderror" 
                                   min="1000" step="1000" value="{{ old('intervalo_base', 5000) }}" required>
                            @error('intervalo_base')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="kilometraje_maximo" class="required">Máximo Kilometraje (km)</label>
                            <input type="number" name="kilometraje_maximo" id="kilometraje_maximo" 
                                   class="form-control @error('kilometraje_maximo') is-invalid @enderror" 
                                   min="5000" step="5000" value="{{ old('kilometraje_maximo', 100000) }}" required>
                            @error('kilometraje_maximo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="relacion_horas_km" class="required">Relación Horas-Km</label>
                            <input type="number" name="relacion_horas_km" id="relacion_horas_km" 
                                   class="form-control @error('relacion_horas_km') is-invalid @enderror" 
                                   min="50" value="{{ old('relacion_horas_km', 250) }}" required>
                            <small class="form-text text-muted">Horas por cada 5000 km</small>
                            @error('relacion_horas_km')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección 3: Componentes de Mantenimiento -->
        <div class="row mt-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">3. Componentes de Mantenimiento</h4>
                        <button type="button" id="btnAgregarComponente" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus mr-1"></i>
                            Agregar Componente
                        </button>
                    </div>
                    <div class="card-body">
                        <div id="componentesContainer">
                            <!-- Los componentes se agregarán dinámicamente aquí -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección 4: Programación por Intervalos -->
        <div class="row mt-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">4. Programación por Intervalos</h4>
                        <small class="text-muted">Configure qué componentes aplican en cada intervalo de kilometraje</small>
                    </div>
                    <div class="card-body">
                        <div id="intervalosContainer" class="table-responsive">
                            <!-- La tabla de intervalos se generará dinámicamente -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección 5: Parámetros de Costeo -->
        <div class="row mt-3">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">5. Parámetros de Costeo</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tarifa_mano_obra">Tarifa de Mano de Obra</label>
                                    <div class="input-group">
                                        <input type="number" name="tarifa_mano_obra" id="tarifa_mano_obra" 
                                               class="form-control @error('tarifa_mano_obra') is-invalid @enderror" 
                                               min="0" step="0.01" value="{{ old('tarifa_mano_obra', 0) }}">
                                        <div class="input-group-append">
                                            <span class="input-group-text">por hora</span>
                                        </div>
                                    </div>
                                    @error('tarifa_mano_obra')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="impuestos" class="required">Impuestos (%)</label>
                                    <input type="number" name="impuestos" id="impuestos" 
                                           class="form-control @error('impuestos') is-invalid @enderror" 
                                           min="0" max="100" step="0.01" value="{{ old('impuestos', 18) }}" required>
                                    @error('impuestos')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="margen_beneficio">Margen de Beneficio (%)</label>
                                    <input type="number" name="margen_beneficio" id="margen_beneficio" 
                                           class="form-control @error('margen_beneficio') is-invalid @enderror" 
                                           min="0" max="100" step="0.01" value="{{ old('margen_beneficio', 0) }}">
                                    @error('margen_beneficio')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sección 6: Configuraciones Adicionales -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">6. Configuraciones Adicionales</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="required">Moneda Principal</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" name="moneda_principal" value="PEN" id="moneda_pen" 
                                                   class="form-check-input @error('moneda_principal') is-invalid @enderror"
                                                   {{ old('moneda_principal', 'PEN') == 'PEN' ? 'checked' : '' }} required>
                                            <label class="form-check-label" for="moneda_pen">Soles (PEN)</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" name="moneda_principal" value="USD" id="moneda_usd" 
                                                   class="form-check-input"
                                                   {{ old('moneda_principal') == 'USD' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="moneda_usd">Dólares (USD)</label>
                                        </div>
                                    </div>
                                    @error('moneda_principal')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="proveedor_predeterminado_id">Proveedor Predeterminado</label>
                                    <select name="proveedor_predeterminado_id" id="proveedor_predeterminado_id" 
                                            class="form-control @error('proveedor_predeterminado_id') is-invalid @enderror">
                                        <option value="">Seleccionar proveedor</option>
                                        @foreach($proveedores as $proveedor)
                                            <option value="{{ $proveedor->id }}" 
                                                    {{ old('proveedor_predeterminado_id') == $proveedor->id ? 'selected' : '' }}>
                                                {{ $proveedor->nombre_completo }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('proveedor_predeterminado_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="form-check">
                                        <input type="checkbox" name="mostrar_precios" id="mostrar_precios" 
                                               class="form-check-input" value="1" 
                                               {{ old('mostrar_precios', true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="mostrar_precios">
                                            Mostrar precios en el plan
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="form-check">
                                        <input type="checkbox" name="activo" id="activo" 
                                               class="form-check-input" value="1" 
                                               {{ old('activo', true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="activo">
                                            Plan activo
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botones de acción -->
        <div class="row mt-3">
            <div class="col-12">
                <div class="text-center">
                    <a href="{{ route('admin.planes-mantenimiento.index') }}" class="btn btn-secondary btn-lg mr-3">
                        <i class="fas fa-times mr-1"></i>
                        Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save mr-1"></i>
                        Guardar Plan de Mantenimiento
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    // Variables globales
    let componenteIndex = 0;
    let partes = @json($partes);
    let proveedores = @json($proveedores);
    let tipoCambio = @json($tipoCambio);
    
    $(document).ready(function() {
        console.log('Partes disponibles:', partes.length);
        console.log('Proveedores disponibles:', proveedores.length);
        initPlanMantenimiento();
    });

    function initPlanMantenimiento() {
        // Event listeners
        $('#btnAgregarComponente').on('click', function(e) {
            e.preventDefault();
            agregarComponente();
        });
        
        $('#intervalo_base, #kilometraje_maximo').on('change', generarTablaIntervalos);
        
        // Generar tabla inicial
        generarTablaIntervalos();
    }

    function agregarComponente() {
        let componenteHtml = `
            <div class="componente-item" id="componente_${componenteIndex}">
                <div class="componente-header d-flex justify-content-between align-items-center mb-3">
                    <h5 class="componente-nombre">Componente ${componenteIndex + 1}</h5>
                    <button type="button" class="btn btn-danger btn-sm" onclick="eliminarComponente(${componenteIndex})">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="required">Componente/Parte</label>
                            <select name="componentes[${componenteIndex}][parte_id]" id="componente_${componenteIndex}_parte_id" 
                                    class="form-control" required onchange="actualizarComponenteNombre(${componenteIndex})">
                                <option value="">Seleccionar componente</option>`;
        
        // Agregar opciones de partes
        partes.forEach(parte => {
            componenteHtml += `<option value="${parte.id}">${parte.nombre}`;
            if (parte.marca) {
                componenteHtml += ` - ${parte.marca}`;
            }
            componenteHtml += `</option>`;
        });
        
        componenteHtml += `
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="required">Cantidad</label>
                            <input type="number" name="componentes[${componenteIndex}][cantidad]" 
                                   class="form-control" min="0.01" step="0.01" value="1" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="required">Unidad</label>
                            <select name="componentes[${componenteIndex}][unidad_medida]" class="form-control" required>
                                <option value="Unidades">Unidades</option>
                                <option value="Litros">Litros</option>
                                <option value="Galones">Galones</option>
                                <option value="Lb">Libras</option>
                                <option value="Kg">Kilogramos</option>
                                <option value="Metros">Metros</option>
                                <option value="Pies">Pies</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="required">Acción</label>
                            <select name="componentes[${componenteIndex}][accion]" class="form-control" required>
                                <option value="Reemplazar">Reemplazar (R)</option>
                                <option value="Inspeccionar">Inspeccionar (I)</option>
                                <option value="Lubricar">Lubricar (L)</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="required">Moneda</label>
                            <select name="componentes[${componenteIndex}][moneda]" class="form-control" required>
                                <option value="PEN">Soles (PEN)</option>
                                <option value="USD">Dólares (USD)</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Proveedor</label>
                            <select name="componentes[${componenteIndex}][proveedor_id]" id="componente_${componenteIndex}_proveedor_id" 
                                    class="form-control">
                                <option value="">Usar proveedor predeterminado</option>`;
        
        // Agregar opciones de proveedores
        proveedores.forEach(proveedor => {
            componenteHtml += `<option value="${proveedor.id}">${proveedor.nombre_completo}</option>`;
        });
        
        componenteHtml += `
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Precio Base</label>
                            <input type="number" name="componentes[${componenteIndex}][precio_base]" 
                                   class="form-control" min="0" step="0.01" placeholder="0.00">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label>Observaciones</label>
                            <textarea name="componentes[${componenteIndex}][observaciones]" class="form-control" rows="2" 
                                      placeholder="Notas adicionales sobre este componente"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        $('#componentesContainer').append(componenteHtml);
        
        console.log('Componente agregado:', componenteIndex);
        
        componenteIndex++;
        generarTablaIntervalos();
    }

    function eliminarComponente(index) {
        $(`#componente_${index}`).remove();
        generarTablaIntervalos();
    }

    function generarTablaIntervalos() {
        const intervaloBase = parseInt($('#intervalo_base').val()) || 5000;
        const kmMaximo = parseInt($('#kilometraje_maximo').val()) || 100000;
        
        if (intervaloBase <= 0 || kmMaximo <= 0 || intervaloBase >= kmMaximo) {
            $('#intervalosContainer').html('<div class="alert alert-warning">Configure correctamente los intervalos base y máximo</div>');
            return;
        }
        
        // Generar intervalos
        let intervalos = [];
        for (let km = intervaloBase; km <= kmMaximo; km += intervaloBase) {
            intervalos.push(km);
        }
        
        // Construir tabla
        let tablaHtml = '<table class="table table-bordered table-sm">';
        tablaHtml += '<thead><tr>';
        tablaHtml += '<th>Componente</th>';
        
        intervalos.forEach(km => {
            tablaHtml += `<th class="text-center">${km.toLocaleString()} km</th>`;
        });
        
        tablaHtml += '</tr></thead><tbody>';
        
        // Obtener componentes actuales
        $('#componentesContainer .componente-item').each(function(index) {
            const componenteNombre = $(this).find('.componente-nombre').text() || `Componente ${index + 1}`;
            
            tablaHtml += '<tr>';
            tablaHtml += `<td><strong>${componenteNombre}</strong></td>`;
            
            intervalos.forEach(km => {
                tablaHtml += '<td class="text-center">';
                tablaHtml += `<div class="form-check">`;
                tablaHtml += `<input type="checkbox" name="intervalos[${index}][${km}][aplica]" value="1" class="form-check-input">`;
                tablaHtml += `</div>`;
                tablaHtml += `<input type="number" name="intervalos[${index}][${km}][cantidad_especifica]" placeholder="Cant." class="form-control form-control-sm mt-1" style="font-size: 10px;">`;
                tablaHtml += `<input type="number" name="intervalos[${index}][${km}][precio_especifico]" placeholder="Precio" class="form-control form-control-sm mt-1" style="font-size: 10px;" step="0.01">`;
                tablaHtml += '</td>';
            });
            
            tablaHtml += '</tr>';
        });
        
        tablaHtml += '</tbody></table>';
        
        $('#intervalosContainer').html(tablaHtml);
    }

    function actualizarComponenteNombre(index) {
        const parteId = $(`#componente_${index}_parte_id`).val();
        const parte = partes.find(p => p.id == parteId);
        const nombreParte = parte ? parte.nombre : `Componente ${index + 1}`;
        
        $(`#componente_${index} .componente-nombre`).text(nombreParte);
        generarTablaIntervalos();
    }
    
    // Hacer las funciones globales para que puedan ser llamadas desde el HTML
    window.eliminarComponente = eliminarComponente;
    window.actualizarComponenteNombre = actualizarComponenteNombre;
</script>
@endsection

@section('styles')
<style>
    .required::after {
        content: ' *';
        color: red;
    }
    
    .componente-item {
        border: 1px solid #dee2e6;
        border-radius: 0.25rem;
        margin-bottom: 15px;
        padding: 15px;
        background-color: #f8f9fa;
    }
    
    .componente-header {
        display: flex;
        justify-content: between;
        align-items: center;
        margin-bottom: 15px;
    }
    
    #intervalosContainer table th,
    #intervalosContainer table td {
        white-space: nowrap;
        min-width: 120px;
    }
    
    #intervalosContainer .form-control-sm {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
    }
</style>
@endsection