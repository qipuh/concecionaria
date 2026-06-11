<!-- resources/views/admin/mantenimiento/citas/index.blade.php -->
@extends('admin.layouts.app')

@section('title', 'Listado de Citas de Mantenimiento')

@section('content')
<div class="dashboard-hero" style="padding: 2rem 2rem; border-radius: 0 0 1.5rem 1.5rem; margin-bottom: 2.5rem;">
    <div class="hero-glow-alt" style="top: -50px; right: 0; filter: blur(60px); opacity: 0.2;"></div>
    <div class="container-fluid position-relative z-1">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center">
            <div class="mb-3 mb-lg-0">
                <div class="d-inline-flex align-items-center px-3 py-1 bg-white bg-opacity-10 rounded-pill fs-6 mb-3 border border-white border-opacity-25">
                    <i class="fas fa-tools text-warning me-2"></i> Mantenimiento
                </div>
                <h2 class="fw-bold mb-1 tracking-tight text-white display-6 text-shadow-sm">Citas de Mantenimiento</h2>
                <p class="text-white-50 mb-0">Gestión de citas agendadas</p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('admin.mantenimiento.citas.create') }}" class="btn bg-white text-dark rounded-pill px-4 py-2 fw-bold shadow-sm border-0">
                    <i class="fas fa-plus me-2"></i> Nueva Cita
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid px-3 px-lg-4 position-relative" style="top: -3.5rem; z-index: 10;">
    <div class="card dashboard-card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 pt-4 pb-0 px-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h6 class="fw-bold mb-0"><i class="fas fa-list me-2 text-primary"></i> Listado de Citas</h6>
            <form action="{{ route('admin.mantenimiento.citas.index') }}" method="GET" class="d-flex gap-2">
                <input type="text" name="search" class="form-control form-control-sm rounded-pill" placeholder="Buscar..." value="{{ request('search') }}" style="min-width: 200px;">
                <button type="submit" class="btn btn-sm btn-outline-secondary rounded-pill px-3 border-0">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="py-3 px-4 border-0 text-uppercase small">ID</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Cliente</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Vehículo</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Fecha y Hora</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Motivo</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Estado</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Técnico</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($citas as $cita)
                            <tr>
                                <td class="px-4 text-muted small">{{ $cita->id }}</td>
                                <td class="px-4 fw-semibold">
                                    @if($cita->cliente->tipo_cliente == 'persona')
                                        {{ $cita->cliente->nombres }} {{ $cita->cliente->apellido_paterno }} {{ $cita->cliente->apellido_materno }}
                                    @else
                                        {{ $cita->cliente->razon_social }}
                                    @endif
                                </td>
                                <td class="px-4">
                                    {{ $cita->vehiculo->marca->nombre ?? 'N/A' }}
                                    {{ $cita->vehiculo->modelo->nombre ?? 'N/A' }}
                                    ({{ $cita->vehiculo->nro_placa ?? 'N/A' }})
                                </td>
                                <td class="px-4 small fw-semibold">{{ \Carbon\Carbon::parse($cita->fecha_hora_cita)->format('d/m/Y H:i') }}</td>
                                <td class="px-4">{{ $cita->motivo_visita }}</td>
                                <td class="px-4">
                                    @switch($cita->estado)
                                        @case('pendiente')
                                            <span class="badge bg-warning-subtle text-warning rounded-pill px-3">Pendiente</span>
                                            @break
                                        @case('confirmada')
                                            <span class="badge bg-primary-subtle text-primary rounded-pill px-3">Confirmada</span>
                                            @break
                                        @case('en_progreso')
                                            <span class="badge bg-info-subtle text-info rounded-pill px-3">En Progreso</span>
                                            @break
                                        @case('completada')
                                            <span class="badge bg-success-subtle text-success rounded-pill px-3">Completada</span>
                                            @break
                                        @case('cancelada')
                                            <span class="badge bg-danger-subtle text-danger rounded-pill px-3">Cancelada</span>
                                            @break
                                        @default
                                            <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3">{{ $cita->estado }}</span>
                                    @endswitch
                                </td>
                                <td class="px-4 small text-muted">{{ $cita->tecnico->name ?? 'Sin asignar' }}</td>
                                <td class="px-4">
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('admin.mantenimiento.citas.show', $cita) }}" class="btn btn-sm btn-outline-info rounded-pill px-3">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.mantenimiento.citas.edit', $cita) }}" class="btn btn-sm btn-outline-warning rounded-pill px-3">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if($cita->estado === 'pendiente')
                                            <button type="button" class="btn btn-sm btn-outline-success rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#confirmarCitaModal{{ $cita->id }}">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        @endif
                                        @if(!$cita->ordenTrabajo)
                                            <form action="{{ route('admin.mantenimiento.citas.destroy', $cita) }}" method="POST" onsubmit="return confirm('¿Está seguro de eliminar esta cita?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>

                            <!-- Modal para confirmar cita -->
                            @if($cita->estado === 'pendiente')
                                <div class="modal fade" id="confirmarCitaModal{{ $cita->id }}" tabindex="-1" aria-labelledby="confirmarCitaModalLabel{{ $cita->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('admin.mantenimiento.citas.confirmar', $cita) }}" method="POST">
                                                @csrf
                                                <div class="modal-header border-0 pb-0">
                                                    <h5 class="modal-title fw-bold" id="confirmarCitaModalLabel{{ $cita->id }}"><i class="fas fa-check-circle me-2 text-success"></i>Confirmar Cita</h5>
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
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <div class="bg-light d-inline-flex p-4 rounded-circle mb-3"><i class="fas fa-calendar-times text-muted fa-2x"></i></div>
                                    <h5 class="text-dark fw-bold">No hay citas registradas</h5>
                                    <p class="text-muted mb-3">Agenda la primera cita de mantenimiento</p>
                                    <a href="{{ route('admin.mantenimiento.citas.create') }}" class="btn btn-primary rounded-pill px-4 py-2 fw-bold border-0">
                                        <i class="fas fa-plus me-2"></i> Nueva Cita
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-0 px-4 py-3">
            {{ $citas->links() }}
        </div>
    </div>
</div>
@endsection
