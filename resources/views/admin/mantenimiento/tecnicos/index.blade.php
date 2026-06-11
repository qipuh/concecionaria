@extends('admin.layouts.app')

@section('title', 'Técnicos')

@section('header', 'Gestión de Técnicos')

@section('content')
<div class="dashboard-hero" style="padding: 2rem 2rem; border-radius: 0 0 1.5rem 1.5rem; margin-bottom: 2.5rem;">
    <div class="hero-glow-alt" style="top: -50px; right: 0; filter: blur(60px); opacity: 0.2;"></div>
    <div class="container-fluid position-relative z-1">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center">
            <div class="mb-3 mb-lg-0">
                <div class="d-inline-flex align-items-center px-3 py-1 bg-white bg-opacity-10 rounded-pill fs-6 mb-3 border border-white border-opacity-25">
                    <i class="fas fa-tools text-warning me-2"></i> Mantenimiento
                </div>
                <h2 class="fw-bold mb-1 tracking-tight text-white display-6 text-shadow-sm">Técnicos del Taller</h2>
                <p class="text-white-50 mb-0">Gestiona la información de los técnicos — Total: {{ $tecnicos->total() }}</p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('admin.mantenimiento.tecnicos.create') }}" class="btn bg-white text-dark rounded-pill px-4 py-2 fw-bold shadow-sm border-0">
                    <i class="fas fa-plus me-2"></i> Agregar Técnico
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid px-3 px-lg-4 position-relative" style="top: -3.5rem; z-index: 10;">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card dashboard-card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
            <h6 class="fw-bold mb-0"><i class="fas fa-user-cog me-2 text-primary"></i> Listado de Técnicos</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="py-3 px-4 border-0 text-uppercase small">Código</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Nombre</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Email</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Especialidad</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Teléfono</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Estado</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Fecha Ingreso</th>
                            <th class="py-3 px-4 border-0 text-uppercase small text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tecnicos as $tecnico)
                        <tr>
                            <td class="px-4">
                                <span class="fw-bold text-primary">{{ $tecnico->codigo }}</span>
                            </td>
                            <td class="px-4 fw-semibold">{{ $tecnico->user->name }}</td>
                            <td class="px-4 small text-muted">{{ $tecnico->user->email }}</td>
                            <td class="px-4">
                                @if($tecnico->especialidad)
                                    <span class="badge bg-info-subtle text-info rounded-pill px-3">{{ $tecnico->especialidad }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="px-4 small text-muted">{{ $tecnico->telefono ?? '-' }}</td>
                            <td class="px-4">
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
                            </td>
                            <td class="px-4 small text-muted">{{ $tecnico->fecha_ingreso ? $tecnico->fecha_ingreso->format('d/m/Y') : '-' }}</td>
                            <td class="px-4 text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <a href="{{ route('admin.mantenimiento.tecnicos.show', $tecnico) }}"
                                       class="btn btn-sm btn-outline-info rounded-pill px-3"
                                       title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.mantenimiento.tecnicos.edit', $tecnico) }}"
                                       class="btn btn-sm btn-outline-primary rounded-pill px-3"
                                       title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button"
                                            class="btn btn-sm btn-outline-danger rounded-pill px-3"
                                            onclick="confirmarEliminacion({{ $tecnico->id }})"
                                            title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>

                                <form id="delete-form-{{ $tecnico->id }}"
                                      action="{{ route('admin.mantenimiento.tecnicos.destroy', $tecnico) }}"
                                      method="POST"
                                      class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <div class="bg-light d-inline-flex p-4 rounded-circle mb-3"><i class="fas fa-users text-muted fa-2x"></i></div>
                                <h5 class="text-dark fw-bold">No hay técnicos registrados</h5>
                                <p class="text-muted mb-3">Agrega el primer técnico del taller</p>
                                <a href="{{ route('admin.mantenimiento.tecnicos.create') }}" class="btn btn-primary rounded-pill px-4 py-2 fw-bold border-0">
                                    <i class="fas fa-plus me-2"></i> Agregar Técnico
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-0 px-4 py-3">
            {{ $tecnicos->links() }}
        </div>
    </div>
</div>

@push('scripts')
<script>
function confirmarEliminacion(tecnicoId) {
    if (confirm('¿Está seguro de que desea eliminar este técnico? Esta acción no se puede deshacer.')) {
        document.getElementById('delete-form-' + tecnicoId).submit();
    }
}
</script>
@endpush
@endsection
