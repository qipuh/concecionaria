<!-- resources/views/admin/mantenimiento/citas/show.blade.php -->
@extends('admin.layouts.app')

@section('title', 'Detalle de Cita de Mantenimiento')

@section('content')
<div class="dashboard-hero" style="padding: 2rem 2rem; border-radius: 0 0 1.5rem 1.5rem; margin-bottom: 2.5rem;">
    <div class="hero-glow-alt" style="top: -50px; right: 0; filter: blur(60px); opacity: 0.2;"></div>
    <div class="container-fluid position-relative z-1">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center">
            <div class="mb-3 mb-lg-0">
                <div class="d-inline-flex align-items-center px-3 py-1 bg-white bg-opacity-10 rounded-pill fs-6 mb-3 border border-white border-opacity-25">
                    <i class="fas fa-tools text-warning me-2"></i> Mantenimiento
                </div>
                <h2 class="fw-bold mb-1 tracking-tight text-white display-6 text-shadow-sm">Detalle de Cita #{{ $cita->id }}</h2>
                <p class="text-white-50 mb-0">Información completa de la cita de mantenimiento</p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('admin.mantenimiento.citas.edit', $cita) }}" class="btn bg-white text-dark rounded-pill px-4 py-2 fw-bold shadow-sm border-0">
                    <i class="fas fa-edit me-2"></i> Editar
                </a>
                @if($cita->estado === 'pendiente')
                    <button type="button" class="btn bg-white bg-opacity-10 text-white rounded-pill px-4 py-2 fw-bold border border-white border-opacity-25" data-bs-toggle="modal" data-bs-target="#confirmarCitaModal">
                        <i class="fas fa-check me-2"></i> Confirmar Cita
                    </button>
                @endif
                @if(!$cita->ordenTrabajo)
                    <button type="button" class="btn btn-outline-danger rounded-pill px-4 py-2 fw-bold border-0" style="border-color: rgba(255,255,255,0.5); color: white;" data-bs-toggle="modal" data-bs-target="#eliminarCitaModal">
                        <i class="fas fa-trash me-2"></i> Eliminar
                    </button>
                @endif
                <a href="{{ route('admin.mantenimiento.citas.index') }}" class="btn btn-outline-secondary rounded-pill px-4 py-2 fw-bold border-0" style="color:white; border-color: rgba(255,255,255,0.5);">
                    <i class="fas fa-arrow-left me-2"></i> Volver
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid px-3 px-lg-4 position-relative" style="top: -3.5rem; z-index: 10;">

    <!-- Estado de la Cita -->
    <div class="card dashboard-card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
            <h6 class="fw-bold mb-0"><i class="fas fa-info-circle me-2 text-primary"></i> Estado de la Cita</h6>
        </div>
        <div class="card-body p-4">
            <div class="row g-4">
                <div class="col-md-4">
                    <p class="text-muted small fw-semibold text-uppercase mb-1">Estado Actual</p>
                    @switch($cita->estado)
                        @case('pendiente')
                            <span class="badge bg-warning-subtle text-warning rounded-pill px-3 fs-6">Pendiente</span>
                            @break
                        @case('confirmada')
                            <span class="badge bg-primary-subtle text-primary rounded-pill px-3 fs-6">Confirmada</span>
                            @break
                        @case('en_progreso')
                            <span class="badge bg-info-subtle text-info rounded-pill px-3 fs-6">En Progreso</span>
                            @break
                        @case('completada')
                            <span class="badge bg-success-subtle text-success rounded-pill px-3 fs-6">Completada</span>
                            @break
                        @case('cancelada')
                            <span class="badge bg-danger-subtle text-danger rounded-pill px-3 fs-6">Cancelada</span>
                            @break
                        @case('diagnostico')
                            <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3 fs-6">Diagnóstico</span>
                            @break
                        @case('presupuestado')
                            <span class="badge bg-info-subtle text-info rounded-pill px-3 fs-6">Presupuestado</span>
                            @break
                        @case('en_reparacion')
                            <span class="badge bg-primary-subtle text-primary rounded-pill px-3 fs-6">En Reparación</span>
                            @break
                        @case('finalizado')
                            <span class="badge bg-success-subtle text-success rounded-pill px-3 fs-6">Finalizado</span>
                            @break
                        @default
                            <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3 fs-6">{{ $cita->estado }}</span>
                    @endswitch
                </div>
                <div class="col-md-4">
                    <p class="text-muted small fw-semibold text-uppercase mb-1">Fecha y Hora</p>
                    <p class="fw-semibold mb-0">{{ \Carbon\Carbon::parse($cita->fecha_hora_cita)->format('d/m/Y H:i') }}</p>
                </div>
                <div class="col-md-4">
                    <p class="text-muted small fw-semibold text-uppercase mb-1">Técnico Asignado</p>
                    <p class="fw-semibold mb-0">{{ $cita->tecnico->name ?? 'Sin asignar' }}</p>
                </div>
            </div>

            @if($cita->ordenTrabajo)
                <div class="alert alert-info rounded-4 border-0 mt-4 mb-0">
                    <i class="fas fa-tools me-2"></i> Esta cita tiene una <strong>Orden de Trabajo</strong> asociada.
                    <a href="{{ route('admin.mantenimiento.ordenes.show', $cita->ordenTrabajo) }}" class="btn btn-sm btn-info rounded-pill px-3 ms-2">
                        Ver Orden #{{ $cita->ordenTrabajo->id }}
                    </a>
                </div>
            @endif
        </div>
    </div>

    <div class="row g-4 mb-4">
        <!-- Datos del Cliente -->
        <div class="col-md-6">
            <div class="card dashboard-card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                    <h6 class="fw-bold mb-0"><i class="fas fa-user me-2 text-primary"></i> Datos del Cliente</h6>
                </div>
                <div class="card-body p-4">
                    <p class="text-muted small fw-semibold text-uppercase mb-2">Información Personal</p>
                    <ul class="list-unstyled mb-0">
                        <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
                            <span class="text-muted small fw-semibold">Nombre</span>
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
                        <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
                            <span class="text-muted small fw-semibold">Ubicación</span>
                            <span class="fw-semibold">{{ $cita->cliente->departamento }}, {{ $cita->cliente->provincia }}, {{ $cita->cliente->distrito }}</span>
                        </li>
                        <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
                            <span class="text-muted small fw-semibold">Correo</span>
                            <span class="fw-semibold">{{ $cita->cliente->correo ?? 'No registrado' }}</span>
                        </li>
                        @if($cita->cliente->telefonos->count() > 0)
                        <li class="d-flex justify-content-between align-items-start py-2">
                            <span class="text-muted small fw-semibold">Teléfonos</span>
                            <div class="text-end">
                                @foreach($cita->cliente->telefonos as $telefono)
                                    <div class="fw-semibold small">{{ ucfirst($telefono->tipo) }}: {{ $telefono->numero }}</div>
                                @endforeach
                            </div>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>

        <!-- Datos del Vehículo -->
        <div class="col-md-6">
            <div class="card dashboard-card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                    <h6 class="fw-bold mb-0"><i class="fas fa-car me-2 text-primary"></i> Datos del Vehículo</h6>
                </div>
                <div class="card-body p-4">
                    <ul class="list-unstyled mb-0">
                        <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
                            <span class="text-muted small fw-semibold">Marca y Modelo</span>
                            <span class="fw-semibold">{{ $cita->vehiculo->marca->nombre ?? 'N/A' }} {{ $cita->vehiculo->modelo->nombre ?? 'N/A' }}</span>
                        </li>
                        <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
                            <span class="text-muted small fw-semibold">Año</span>
                            <span class="fw-semibold">{{ $cita->vehiculo->anio ?? 'N/A' }}</span>
                        </li>
                        <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
                            <span class="text-muted small fw-semibold">Placa</span>
                            <span class="fw-semibold">{{ $cita->vehiculo->nro_placa }}</span>
                        </li>
                        <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
                            <span class="text-muted small fw-semibold">Color</span>
                            <span class="fw-semibold">{{ $cita->vehiculo->color }}</span>
                        </li>
                        <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
                            <span class="text-muted small fw-semibold">N° Motor</span>
                            <span class="fw-semibold">{{ $cita->vehiculo->motor }}</span>
                        </li>
                        <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
                            <span class="text-muted small fw-semibold">N° Chasis</span>
                            <span class="fw-semibold">{{ $cita->vehiculo->serie_vim }}</span>
                        </li>
                        <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
                            <span class="text-muted small fw-semibold">Kilometraje</span>
                            <span class="fw-semibold">{{ number_format($cita->vehiculo->kilometraje, 0, '.', ',') }} km</span>
                        </li>
                        <li class="d-flex justify-content-between align-items-center py-2">
                            <span class="text-muted small fw-semibold">Combustible</span>
                            <span class="fw-semibold">{{ $cita->vehiculo->combustible->nombre ?? 'N/A' }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Detalles de la Cita -->
    <div class="card dashboard-card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
            <h6 class="fw-bold mb-0"><i class="fas fa-clipboard-list me-2 text-primary"></i> Detalles de la Cita</h6>
        </div>
        <div class="card-body p-4">
            <ul class="list-unstyled mb-0">
                <li class="d-flex justify-content-between align-items-start py-2 border-bottom">
                    <span class="text-muted small fw-semibold">Motivo de visita</span>
                    <span class="fw-semibold text-end" style="max-width: 65%;">{{ $cita->motivo_visita }}</span>
                </li>
                @if($cita->descripcion_problema)
                <li class="d-flex justify-content-between align-items-start py-2 border-bottom">
                    <span class="text-muted small fw-semibold">Descripción del problema</span>
                    <span class="fw-semibold text-end" style="max-width: 65%;">{{ $cita->descripcion_problema }}</span>
                </li>
                @endif
                @if($cita->notas_adicionales)
                <li class="d-flex justify-content-between align-items-start py-2">
                    <span class="text-muted small fw-semibold">Observaciones</span>
                    <span class="fw-semibold text-end" style="max-width: 65%;">{{ $cita->notas_adicionales }}</span>
                </li>
                @endif
            </ul>
        </div>
    </div>

    <!-- Registro de Adelanto -->
    @if($cita->estado === 'pendiente' || $cita->estado === 'confirmada')
        <div class="card dashboard-card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                <h6 class="fw-bold mb-0"><i class="fas fa-money-bill-wave me-2 text-primary"></i> Registrar Adelanto</h6>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.mantenimiento.citas.adelanto', $cita) }}" method="POST">
                    @csrf
                    <div class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <label for="monto" class="form-label fw-semibold small text-uppercase text-muted">Monto</label>
                            <div class="input-group">
                                <span class="input-group-text">S/</span>
                                <input type="number" name="monto" id="monto" class="form-control" min="0" step="0.01" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="metodo_pago" class="form-label fw-semibold small text-uppercase text-muted">Método de Pago</label>
                            <select name="metodo_pago" id="metodo_pago" class="form-select" required>
                                <option value="efectivo">Efectivo</option>
                                <option value="tarjeta">Tarjeta de Crédito/Débito</option>
                                <option value="transferencia">Transferencia Bancaria</option>
                                <option value="yape">Yape</option>
                                <option value="plin">Plin</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow-sm border-0 w-100">
                                <i class="fas fa-save me-2"></i> Registrar Adelanto
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>

<!-- Modal para confirmar cita -->
@if($cita->estado === 'pendiente')
<div class="modal fade" id="confirmarCitaModal" tabindex="-1" aria-labelledby="confirmarCitaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.mantenimiento.citas.confirmar', $cita) }}" method="POST">
                @csrf
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" id="confirmarCitaModalLabel"><i class="fas fa-check-circle me-2 text-success"></i>Confirmar Cita</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-4">
                    <div class="mb-3">
                        <label for="tecnico_id" class="form-label fw-semibold small text-uppercase text-muted">Técnico Asignado</label>
                        <select name="tecnico_id" id="tecnico_id" class="form-select" required>
                            <option value="">Seleccione un técnico</option>
                            @foreach(\App\Models\User::whereHas('roles', function($query) {
                                $query->where('name', 'tecnico');
                            })->get() as $tecnico)
                                <option value="{{ $tecnico->id }}">{{ $tecnico->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="box" class="form-label fw-semibold small text-uppercase text-muted">Box Asignado</label>
                        <input type="text" name="box" id="box" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="kilometraje" class="form-label fw-semibold small text-uppercase text-muted">Kilometraje Actual</label>
                        <div class="input-group">
                            <input type="number" name="kilometraje" id="kilometraje" class="form-control"
                                value="{{ $cita->vehiculo->kilometraje ?? 0 }}" min="{{ $cita->vehiculo->kilometraje ?? 0 }}">
                            <span class="input-group-text">km</span>
                        </div>
                        <small class="form-text text-muted">Último registrado: {{ number_format($cita->vehiculo->kilometraje ?? 0, 0, '.', ',') }} km</small>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4 border-0" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success rounded-pill px-4 fw-bold border-0">
                        <i class="fas fa-check me-2"></i> Confirmar y Crear Orden
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<!-- Modal para eliminar cita -->
@if(!$cita->ordenTrabajo)
    <div class="modal fade" id="eliminarCitaModal" tabindex="-1" aria-labelledby="eliminarCitaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.mantenimiento.citas.destroy', $cita) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title fw-bold" id="eliminarCitaModalLabel"><i class="fas fa-trash me-2 text-danger"></i>Eliminar Cita</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-4">
                        <p>¿Está seguro de eliminar esta cita de mantenimiento?</p>
                        <p class="text-danger mb-0"><i class="fas fa-exclamation-triangle me-1"></i>Esta acción no se puede deshacer.</p>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-outline-secondary rounded-pill px-4 border-0" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger rounded-pill px-4 fw-bold border-0">
                            <i class="fas fa-trash me-2"></i> Eliminar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif
@endsection
