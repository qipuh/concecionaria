@extends('admin.layouts.app')
@section('title', 'Recepción de Órdenes')

@section('content')
<div class="dashboard-hero" style="padding: 2rem 2rem; border-radius: 0 0 1.5rem 1.5rem; margin-bottom: 2.5rem;">
    <div class="hero-glow-alt" style="top: -50px; right: 0; filter: blur(60px); opacity: 0.2;"></div>
    <div class="container-fluid position-relative z-1">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center">
            <div class="mb-3 mb-lg-0">
                <div class="d-inline-flex align-items-center px-3 py-1 bg-white bg-opacity-10 rounded-pill fs-6 mb-3 border border-white border-opacity-25 backdrop-blur">
                    <i class="fas fa-truck-loading text-info me-2"></i> Documentos
                </div>
                <h2 class="fw-bold mb-1 tracking-tight text-white display-6 text-shadow-sm">
                    Recepción de Órdenes
                </h2>
                <p class="text-white-50 mb-0">Gestiona y recepciona las órdenes de compra aprobadas</p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('admin.inventario.kardex.consulta') }}" class="btn bg-white bg-opacity-10 text-white rounded-pill px-4 py-2 fw-bold shadow-sm border border-white border-opacity-25">
                    <i class="fas fa-search me-2"></i> Kardex
                </a>
                <a href="{{ route('admin.recepcion.historial') }}" class="btn bg-white text-dark rounded-pill px-4 py-2 fw-bold shadow-sm border-0">
                    <i class="fas fa-history text-primary me-2"></i> Historial
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid px-3 px-lg-4 position-relative" style="top: -3.5rem; z-index: 10;"
     x-data="recepcionIndex()">

    {{-- Tarjetas de estadísticas --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="card dashboard-card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3 p-3">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-circle flex-shrink-0">
                        <i class="fas fa-shopping-cart text-primary"></i>
                    </div>
                    <div>
                        <div class="fw-bold fs-4 text-primary">{{ $ordenes->count() }}</div>
                        <div class="text-muted small text-uppercase fw-semibold">Total</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card dashboard-card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3 p-3">
                    <div class="bg-secondary bg-opacity-10 p-3 rounded-circle flex-shrink-0">
                        <i class="fas fa-clock text-secondary"></i>
                    </div>
                    <div>
                        <div class="fw-bold fs-4 text-secondary">{{ $ordenes->whereNotIn('estado_recepcion', ['parcial','completo','completo_con_faltantes'])->count() }}</div>
                        <div class="text-muted small text-uppercase fw-semibold">Pendientes</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card dashboard-card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3 p-3">
                    <div class="bg-warning bg-opacity-10 p-3 rounded-circle flex-shrink-0">
                        <i class="fas fa-pause-circle text-warning"></i>
                    </div>
                    <div>
                        <div class="fw-bold fs-4 text-warning">{{ $ordenes->where('estado_recepcion', 'parcial')->count() }}</div>
                        <div class="text-muted small text-uppercase fw-semibold">Parciales</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card dashboard-card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3 p-3">
                    <div class="bg-success bg-opacity-10 p-3 rounded-circle flex-shrink-0">
                        <i class="fas fa-check-circle text-success"></i>
                    </div>
                    <div>
                        <div class="fw-bold fs-4 text-success">{{ $ordenes->where('estado_recepcion', 'completo')->count() }}</div>
                        <div class="text-muted small text-uppercase fw-semibold">Completas</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Card principal con tabs --}}
    <div class="card dashboard-card border-0 shadow-sm">
        <div class="card-body p-0">

            {{-- Barra superior: tabs + búsqueda --}}
            <div class="d-flex flex-column flex-md-row align-items-md-center border-bottom">
                <ul class="nav premium-tabs nav-fill flex-grow-1 border-0" id="recepcionTabs" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link fw-bold py-3 active" data-bs-toggle="tab" data-bs-target="#pendientes"
                                @click="tabActivo = 'pendientes'" type="button">
                            <i class="fas fa-clock me-2"></i> Pendientes
                            <span class="badge bg-secondary-subtle text-secondary ms-1 rounded-pill">{{ $ordenes->whereNotIn('estado_recepcion', ['parcial','completo','completo_con_faltantes'])->count() }}</span>
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link fw-bold py-3" data-bs-toggle="tab" data-bs-target="#parciales"
                                @click="tabActivo = 'parciales'" type="button">
                            <i class="fas fa-pause-circle me-2"></i> Parciales
                            <span class="badge bg-warning-subtle text-warning ms-1 rounded-pill">{{ $ordenes->where('estado_recepcion', 'parcial')->count() }}</span>
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link fw-bold py-3" data-bs-toggle="tab" data-bs-target="#completas"
                                @click="tabActivo = 'completas'" type="button">
                            <i class="fas fa-check-circle me-2"></i> Completas
                            <span class="badge bg-success-subtle text-success ms-1 rounded-pill">{{ $ordenes->where('estado_recepcion', 'completo')->count() }}</span>
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link fw-bold py-3" data-bs-toggle="tab" data-bs-target="#todas"
                                @click="tabActivo = 'todas'" type="button">
                            <i class="fas fa-list me-2"></i> Todas
                            <span class="badge bg-primary-subtle text-primary ms-1 rounded-pill">{{ $ordenes->count() }}</span>
                        </button>
                    </li>
                </ul>
                <div class="px-3 py-2">
                    <div class="input-group input-group-sm" style="min-width: 220px;">
                        <span class="input-group-text bg-light border-0 rounded-start-pill">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-0 bg-light rounded-end-pill"
                               placeholder="Buscar orden o proveedor..."
                               x-model="busqueda">
                    </div>
                </div>
            </div>

            <div class="tab-content">
                <div class="tab-pane fade show active" id="pendientes">
                    @include('admin.compras.documentos.recepcion.partials.table', [
                        'ordenes' => $ordenes->whereNotIn('estado_recepcion', ['parcial','completo','completo_con_faltantes']),
                        'mostrarAcciones' => true
                    ])
                </div>
                <div class="tab-pane fade" id="parciales">
                    @include('admin.compras.documentos.recepcion.partials.table', [
                        'ordenes' => $ordenes->where('estado_recepcion', 'parcial'),
                        'mostrarAcciones' => true
                    ])
                </div>
                <div class="tab-pane fade" id="completas">
                    @include('admin.compras.documentos.recepcion.partials.table', [
                        'ordenes' => $ordenes->where('estado_recepcion', 'completo'),
                        'mostrarAcciones' => false
                    ])
                </div>
                <div class="tab-pane fade" id="todas">
                    @include('admin.compras.documentos.recepcion.partials.table', [
                        'ordenes' => $ordenes,
                        'mostrarAcciones' => true
                    ])
                </div>
            </div>

        </div>
    </div>
</div>

@push('styles')
<style>
.premium-tabs .nav-link {
    color: #6c757d;
    border: none;
    border-bottom: 3px solid transparent;
    border-radius: 0;
    transition: all 0.25s ease;
}
.premium-tabs .nav-link:hover {
    background-color: rgba(13, 110, 253, 0.04);
    color: #0d6efd;
}
.premium-tabs .nav-link.active {
    color: #0d6efd;
    background-color: transparent;
    border-bottom-color: #0d6efd;
}
</style>
@endpush

@push('scripts')
<script>
function recepcionIndex() {
    return {
        busqueda: '',
        tabActivo: 'pendientes',
        init() {
            this.$watch('busqueda', val => this.filtrar(val));
        },
        filtrar(val) {
            const term = val.toLowerCase();
            document.querySelectorAll('.tab-pane.active .orden-row').forEach(row => {
                const texto = row.dataset.search || '';
                row.style.display = texto.includes(term) ? '' : 'none';
            });
            // Actualizar mensaje vacío
            document.querySelectorAll('.tab-pane.active').forEach(pane => {
                const visibles = pane.querySelectorAll('.orden-row:not([style*="none"])').length;
                const noResults = pane.querySelector('.no-results-filter');
                if (noResults) noResults.style.display = visibles === 0 && term ? '' : 'none';
            });
        }
    }
}
</script>
@endpush
@endsection
