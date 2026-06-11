@extends('admin.layouts.app')

@section('title', 'Detalles del Técnico')

@section('header', 'Detalles del Técnico')

@section('content')
<div class="dashboard-hero" style="padding: 2rem 2rem; border-radius: 0 0 1.5rem 1.5rem; margin-bottom: 2.5rem;">
    <div class="hero-glow-alt" style="top: -50px; right: 0; filter: blur(60px); opacity: 0.2;"></div>
    <div class="container-fluid position-relative z-1">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center">
            <div class="mb-3 mb-lg-0">
                <div class="d-inline-flex align-items-center px-3 py-1 bg-white bg-opacity-10 rounded-pill fs-6 mb-3 border border-white border-opacity-25">
                    <i class="fas fa-tools text-warning me-2"></i> Mantenimiento
                </div>
                <h2 class="fw-bold mb-1 tracking-tight text-white display-6 text-shadow-sm">{{ $tecnico->user->name }}</h2>
                <p class="text-white-50 mb-0">Código: {{ $tecnico->codigo }}</p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('admin.mantenimiento.tecnicos.edit', $tecnico) }}" class="btn bg-white text-dark rounded-pill px-4 py-2 fw-bold shadow-sm border-0">
                    <i class="fas fa-edit me-2"></i> Editar
                </a>
                <a href="{{ route('admin.mantenimiento.tecnicos.index') }}" class="btn btn-outline-secondary rounded-pill px-4 py-2 fw-bold border-0" style="color:white; border-color: rgba(255,255,255,0.5);">
                    <i class="fas fa-arrow-left me-2"></i> Volver
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid px-3 px-lg-4 position-relative" style="top: -3.5rem; z-index: 10;">

    <div class="row g-4 mb-4">
        <!-- Información Personal -->
        <div class="col-md-6">
            <div class="card dashboard-card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                    <h6 class="fw-bold mb-0"><i class="fas fa-user me-2 text-primary"></i> Información Personal</h6>
                </div>
                <div class="card-body p-4">
                    <ul class="list-unstyled mb-0">
                        <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
                            <span class="text-muted small fw-semibold">Código</span>
                            <span class="fw-bold text-primary">{{ $tecnico->codigo }}</span>
                        </li>
                        <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
                            <span class="text-muted small fw-semibold">Nombre</span>
                            <span class="fw-semibold">{{ $tecnico->user->name }}</span>
                        </li>
                        <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
                            <span class="text-muted small fw-semibold">Email</span>
                            <span class="fw-semibold">{{ $tecnico->user->email }}</span>
                        </li>
                        <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
                            <span class="text-muted small fw-semibold">Teléfono</span>
                            <span class="fw-semibold">{{ $tecnico->telefono ?? '-' }}</span>
                        </li>
                        <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
                            <span class="text-muted small fw-semibold">Tel. Emergencia</span>
                            <span class="fw-semibold">{{ $tecnico->telefono_emergencia ?? '-' }}</span>
                        </li>
                        <li class="d-flex justify-content-between align-items-center py-2">
                            <span class="text-muted small fw-semibold">Estado</span>
                            @switch($tecnico->estado)
                                @case('activo')
                                    <span class="badge bg-success-subtle text-success rounded-pill px-3">Activo</span>
                                    @break
                                @case('inactivo')
                                    <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3">Inactivo</span>
                                    @break
                                @case('vacaciones')
                                    <span class="badge bg-warning-subtle text-warning rounded-pill px-3">Vacaciones</span>
                                    @break
                                @case('licencia')
                                    <span class="badge bg-info-subtle text-info rounded-pill px-3">Licencia</span>
                                    @break
                            @endswitch
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Información Profesional -->
        <div class="col-md-6">
            <div class="card dashboard-card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                    <h6 class="fw-bold mb-0"><i class="fas fa-tools me-2 text-primary"></i> Información Profesional</h6>
                </div>
                <div class="card-body p-4">
                    <ul class="list-unstyled mb-0">
                        <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
                            <span class="text-muted small fw-semibold">Especialidad</span>
                            @if($tecnico->especialidad)
                                <span class="badge bg-info-subtle text-info rounded-pill px-3">{{ $tecnico->especialidad }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </li>
                        <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
                            <span class="text-muted small fw-semibold">Cédula Profesional</span>
                            <span class="fw-semibold">{{ $tecnico->cedula_profesional ?? '-' }}</span>
                        </li>
                        <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
                            <span class="text-muted small fw-semibold">Fecha de Ingreso</span>
                            <span class="fw-semibold">{{ $tecnico->fecha_ingreso ? $tecnico->fecha_ingreso->format('d/m/Y') : '-' }}</span>
                        </li>
                        <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
                            <span class="text-muted small fw-semibold">Antigüedad</span>
                            <span class="fw-semibold">{{ $tecnico->fecha_ingreso ? $tecnico->fecha_ingreso->diffForHumans() : '-' }}</span>
                        </li>
                        <li class="d-flex justify-content-between align-items-center py-2">
                            <span class="text-muted small fw-semibold">Fecha de Registro</span>
                            <span class="fw-semibold">{{ $tecnico->created_at->format('d/m/Y') }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Certificaciones, Habilidades y Notas -->
    @if($tecnico->certificaciones || $tecnico->habilidades || $tecnico->notas)
    <div class="row g-4 mb-4">
        @if($tecnico->certificaciones)
        <div class="col-md-{{ ($tecnico->habilidades) ? '6' : '12' }}">
            <div class="card dashboard-card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                    <h6 class="fw-bold mb-0"><i class="fas fa-certificate me-2 text-primary"></i> Certificaciones</h6>
                </div>
                <div class="card-body p-4">
                    <p class="text-muted small mb-0">{{ $tecnico->certificaciones }}</p>
                </div>
            </div>
        </div>
        @endif

        @if($tecnico->habilidades)
        <div class="col-md-{{ ($tecnico->certificaciones) ? '6' : '12' }}">
            <div class="card dashboard-card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                    <h6 class="fw-bold mb-0"><i class="fas fa-star me-2 text-primary"></i> Habilidades</h6>
                </div>
                <div class="card-body p-4">
                    <p class="text-muted small mb-0">{{ $tecnico->habilidades }}</p>
                </div>
            </div>
        </div>
        @endif

        @if($tecnico->notas)
        <div class="col-12">
            <div class="card dashboard-card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                    <h6 class="fw-bold mb-0"><i class="fas fa-sticky-note me-2 text-primary"></i> Notas Adicionales</h6>
                </div>
                <div class="card-body p-4">
                    <p class="text-muted small mb-0">{{ $tecnico->notas }}</p>
                </div>
            </div>
        </div>
        @endif
    </div>
    @endif

    <!-- Órdenes de Trabajo Recientes -->
    <div class="card dashboard-card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
            <h6 class="fw-bold mb-0"><i class="fas fa-clipboard-list me-2 text-primary"></i> Órdenes de Trabajo Recientes</h6>
        </div>
        <div class="card-body p-0">
            @if($tecnico->ordenesTrabajoMantenimiento->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="py-3 px-4 border-0 text-uppercase small">Código</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Cliente</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Vehículo</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Estado</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Fecha Ingreso</th>
                            <th class="py-3 px-4 border-0 text-uppercase small text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tecnico->ordenesTrabajoMantenimiento as $orden)
                        <tr>
                            <td class="px-4 fw-semibold text-primary">{{ $orden->codigo_orden }}</td>
                            <td class="px-4">{{ $orden->cliente->nombre ?? '-' }}</td>
                            <td class="px-4">
                                @if($orden->vehiculo)
                                    {{ $orden->vehiculo->marca }} {{ $orden->vehiculo->modelo }}
                                    <br>
                                    <small class="text-muted">{{ $orden->vehiculo->placa }}</small>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-4">
                                @switch($orden->estado)
                                    @case('pendiente')
                                        <span class="badge bg-warning-subtle text-warning rounded-pill px-3">Pendiente</span>
                                        @break
                                    @case('en_progreso')
                                        <span class="badge bg-info-subtle text-info rounded-pill px-3">En Progreso</span>
                                        @break
                                    @case('completado')
                                        <span class="badge bg-success-subtle text-success rounded-pill px-3">Completado</span>
                                        @break
                                    @case('cancelado')
                                        <span class="badge bg-danger-subtle text-danger rounded-pill px-3">Cancelado</span>
                                        @break
                                    @default
                                        <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3">{{ $orden->estado }}</span>
                                @endswitch
                            </td>
                            <td class="px-4 small text-muted">{{ $orden->fecha_ingreso ? $orden->fecha_ingreso->format('d/m/Y') : '-' }}</td>
                            <td class="px-4 text-center">
                                <a href="{{ route('admin.mantenimiento.ordenes.show', $orden) }}"
                                   class="btn btn-sm btn-outline-info rounded-pill px-3"
                                   title="Ver orden">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-5">
                <div class="bg-light d-inline-flex p-4 rounded-circle mb-3"><i class="fas fa-clipboard text-muted fa-2x"></i></div>
                <h5 class="text-dark fw-bold">Sin órdenes asignadas</h5>
                <p class="text-muted mb-0">No hay órdenes de trabajo asignadas a este técnico</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
