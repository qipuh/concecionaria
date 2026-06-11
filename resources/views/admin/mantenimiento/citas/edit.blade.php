<!-- resources/views/admin/mantenimiento/citas/edit.blade.php -->
@extends('admin.layouts.app')

@section('title', 'Editar Cita de Mantenimiento')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
@endpush

@section('content')
<div class="dashboard-hero" style="padding: 2rem 2rem; border-radius: 0 0 1.5rem 1.5rem; margin-bottom: 2.5rem;">
    <div class="hero-glow-alt" style="top: -50px; right: 0; filter: blur(60px); opacity: 0.2;"></div>
    <div class="container-fluid position-relative z-1">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center">
            <div class="mb-3 mb-lg-0">
                <div class="d-inline-flex align-items-center px-3 py-1 bg-white bg-opacity-10 rounded-pill fs-6 mb-3 border border-white border-opacity-25">
                    <i class="fas fa-tools text-warning me-2"></i> Mantenimiento
                </div>
                <h2 class="fw-bold mb-1 tracking-tight text-white display-6 text-shadow-sm">Editar Cita #{{ $cita->id }}</h2>
                <p class="text-white-50 mb-0">Modifica los datos de la cita</p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('admin.mantenimiento.citas.show', $cita) }}" class="btn bg-white text-dark rounded-pill px-4 py-2 fw-bold shadow-sm border-0">
                    <i class="fas fa-arrow-left me-2"></i> Volver
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid px-3 px-lg-4 position-relative" style="top: -3.5rem; z-index: 10;">
    <form action="{{ route('admin.mantenimiento.citas.update', $cita) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row g-4 mb-4">
            <!-- Información del Cliente -->
            <div class="col-md-6">
                <div class="card dashboard-card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                        <h6 class="fw-bold mb-0"><i class="fas fa-user me-2 text-primary"></i> Datos del Cliente</h6>
                    </div>
                    <div class="card-body p-4">
                        <ul class="list-unstyled mb-0">
                            <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                <span class="text-muted small fw-semibold">Cliente</span>
                                <span class="fw-semibold">
                                    @if($cita->cliente->tipo_cliente == 'persona')
                                        {{ $cita->cliente->nombres }} {{ $cita->cliente->apellido_paterno }} {{ $cita->cliente->apellido_materno }}
                                    @else
                                        {{ $cita->cliente->razon_social }}
                                    @endif
                                </span>
                            </li>
                            <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                <span class="text-muted small fw-semibold">Documento</span>
                                <span class="fw-semibold">{{ $cita->cliente->tipo_cliente == 'persona' ? 'DNI: ' : 'RUC: ' }}{{ $cita->cliente->documento_identidad }}</span>
                            </li>
                            <li class="d-flex justify-content-between align-items-center py-2">
                                <span class="text-muted small fw-semibold">Contacto</span>
                                <span class="fw-semibold">
                                    {{ $cita->cliente->correo ?? 'No registrado' }}
                                    @if($cita->cliente->telefonos->count() > 0)
                                        <br><small>{{ $cita->cliente->telefonos->first()->numero }}</small>
                                    @endif
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Información del Vehículo -->
            <div class="col-md-6">
                <div class="card dashboard-card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                        <h6 class="fw-bold mb-0"><i class="fas fa-car me-2 text-primary"></i> Datos del Vehículo</h6>
                    </div>
                    <div class="card-body p-4">
                        <ul class="list-unstyled mb-0">
                            <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                <span class="text-muted small fw-semibold">Vehículo</span>
                                <span class="fw-semibold">{{ $cita->vehiculo->marca->nombre ?? 'N/A' }} {{ $cita->vehiculo->modelo->nombre ?? 'N/A' }}</span>
                            </li>
                            <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                <span class="text-muted small fw-semibold">Placa</span>
                                <span class="fw-semibold">{{ $cita->vehiculo->nro_placa }}</span>
                            </li>
                            <li class="d-flex justify-content-between align-items-center py-2">
                                <span class="text-muted small fw-semibold">Kilometraje</span>
                                <span class="fw-semibold">{{ number_format($cita->vehiculo->kilometraje, 0, '.', ',') }} km</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Datos de la Cita -->
        <div class="card dashboard-card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                <h6 class="fw-bold mb-0"><i class="fas fa-calendar-alt me-2 text-primary"></i> Datos de la Cita</h6>
            </div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="fecha_hora_cita" class="form-label fw-semibold small text-uppercase text-muted">Fecha y Hora de la Cita</label>
                        <input type="text" name="fecha_hora_cita" id="fecha_hora_cita" class="form-control" value="{{ $cita->fecha_hora_cita }}" required>
                    </div>
                    <div class="col-md-4">
                        <label for="estado" class="form-label fw-semibold small text-uppercase text-muted">Estado</label>
                        <select name="estado" id="estado" class="form-select" required>
                            <option value="pendiente" {{ $cita->estado === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="confirmada" {{ $cita->estado === 'confirmada' ? 'selected' : '' }}>Confirmada</option>
                            <option value="en_progreso" {{ $cita->estado === 'en_progreso' ? 'selected' : '' }}>En Progreso</option>
                            <option value="completada" {{ $cita->estado === 'completada' ? 'selected' : '' }}>Completada</option>
                            <option value="cancelada" {{ $cita->estado === 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="tecnico_id" class="form-label fw-semibold small text-uppercase text-muted">Técnico Asignado</label>
                        <select name="tecnico_id" id="tecnico_id" class="form-select">
                            <option value="">Sin asignar</option>
                            @foreach($tecnicos as $tecnico)
                                <option value="{{ $tecnico->id }}" {{ $cita->tecnico_id === $tecnico->id ? 'selected' : '' }}>{{ $tecnico->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label for="motivo_visita" class="form-label fw-semibold small text-uppercase text-muted">Motivo de la Visita</label>
                        <input type="text" name="motivo_visita" id="motivo_visita" class="form-control" value="{{ $cita->motivo_visita }}" required>
                    </div>
                    <div class="col-md-12">
                        <label for="descripcion_problema" class="form-label fw-semibold small text-uppercase text-muted">Descripción del Problema</label>
                        <textarea name="descripcion_problema" id="descripcion_problema" class="form-control" rows="3">{{ $cita->descripcion_problema }}</textarea>
                    </div>
                    <div class="col-md-12">
                        <label for="notas_adicionales" class="form-label fw-semibold small text-uppercase text-muted">Observaciones</label>
                        <textarea name="notas_adicionales" id="notas_adicionales" class="form-control" rows="2">{{ $cita->notas_adicionales }}</textarea>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('admin.mantenimiento.citas.show', $cita) }}" class="btn btn-outline-secondary rounded-pill px-4 py-2 fw-bold border-0">Cancelar</a>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow-sm border-0">
                        <i class="fas fa-save me-2"></i> Guardar Cambios
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            flatpickr("#fecha_hora_cita", {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                locale: "es",
                time_24hr: true
            });

            $('.form-select').select2({
                theme: 'bootstrap-5'
            });
        });
    </script>
@endpush
