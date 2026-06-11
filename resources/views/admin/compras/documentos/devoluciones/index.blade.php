@extends('admin.layouts.app')
@section('title', 'Vales de Devolución')

@section('content')
@php
    $totalCount     = \App\Models\ValeDevolucion::count();
    $pendienteCount = \App\Models\ValeDevolucion::where('estado', 'pendiente')->count();
    $aprobadoCount  = \App\Models\ValeDevolucion::where('estado', 'aprobado')->count();
    $procesadoCount = \App\Models\ValeDevolucion::where('estado', 'procesado')->count();
@endphp

<div class="dashboard-hero" style="padding: 2rem 2rem; border-radius: 0 0 1.5rem 1.5rem; margin-bottom: 2.5rem;">
    <div class="hero-glow-alt" style="top: -50px; right: 0; filter: blur(60px); opacity: 0.2;"></div>
    <div class="container-fluid position-relative z-1">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center">
            <div class="mb-3 mb-lg-0">
                <div class="d-inline-flex align-items-center px-3 py-1 bg-white bg-opacity-10 rounded-pill fs-6 mb-3 border border-white border-opacity-25">
                    <i class="fas fa-undo text-info me-2"></i> Documentos de Compra
                </div>
                <h2 class="fw-bold mb-1 tracking-tight text-white display-6 text-shadow-sm">
                    Vales de Devolución
                </h2>
                <p class="text-white-50 mb-0">Gestiona las devoluciones de mercancía a proveedores</p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('admin.devoluciones.create') }}"
                   class="btn bg-white text-dark rounded-pill px-4 py-2 fw-bold shadow-sm border-0">
                    <i class="fas fa-plus text-primary me-2"></i> Nuevo Vale
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid px-3 px-lg-4 position-relative" style="top: -3.5rem; z-index: 10;">

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4 d-flex align-items-center gap-2">
            <i class="fas fa-check-circle text-success"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4 d-flex align-items-center gap-2">
            <i class="fas fa-exclamation-circle text-danger"></i> {{ session('error') }}
        </div>
    @endif

    {{-- Tarjetas resumen --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="card dashboard-card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3 p-3">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-circle flex-shrink-0">
                        <i class="fas fa-file-alt text-primary"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-0 small">Total Vales</p>
                        <h4 class="mb-0 fw-bold text-primary">{{ $totalCount }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card dashboard-card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3 p-3">
                    <div class="bg-warning bg-opacity-10 p-3 rounded-circle flex-shrink-0">
                        <i class="fas fa-clock text-warning"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-0 small">Pendientes</p>
                        <h4 class="mb-0 fw-bold text-warning">{{ $pendienteCount }}</h4>
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
                        <p class="text-muted mb-0 small">Aprobados</p>
                        <h4 class="mb-0 fw-bold text-success">{{ $aprobadoCount }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card dashboard-card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3 p-3">
                    <div class="bg-info bg-opacity-10 p-3 rounded-circle flex-shrink-0">
                        <i class="fas fa-box-check text-info"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-0 small">Procesados</p>
                        <h4 class="mb-0 fw-bold text-info">{{ $procesadoCount }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabla principal con búsqueda Alpine --}}
    <div class="card dashboard-card border-0 shadow-sm" x-data="devolucionIndex()">
        <div class="card-header bg-white border-0 pt-4 pb-2 px-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-list me-2 text-primary"></i> Registro de Vales
                    <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-1 ms-2 small">
                        {{ $devoluciones->total() }} total
                    </span>
                </h5>
                <div class="input-group" style="max-width: 320px;">
                    <span class="input-group-text bg-light border-0 text-muted">
                        <i class="fas fa-search small"></i>
                    </span>
                    <input type="text" class="form-control bg-light border-0 ps-0"
                           placeholder="Buscar por número, proveedor, estado..."
                           x-model="search" @input="filterRows()">
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            @if($devoluciones->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="py-3 px-4 border-0 text-uppercase small">Número</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Fecha</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Proveedor</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Motivo</th>
                            <th class="py-3 px-4 border-0 text-uppercase small text-center">Estado</th>
                            <th class="py-3 px-4 border-0 text-uppercase small text-end">Total</th>
                            <th class="py-3 px-4 border-0 text-uppercase small text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($devoluciones as $devolucion)
                        @php
                            $badgeMap = [
                                'pendiente' => ['warning', 'clock'],
                                'aprobado'  => ['success', 'check-circle'],
                                'rechazado' => ['danger', 'times-circle'],
                                'procesado' => ['info', 'box'],
                            ];
                            [$color, $icon] = $badgeMap[$devolucion->estado] ?? ['secondary', 'circle'];
                            $searchText = strtolower(
                                $devolucion->numero . ' ' .
                                ($devolucion->proveedor->razon_social ?? '') . ' ' .
                                $devolucion->motivo . ' ' .
                                $devolucion->estado
                            );
                        @endphp
                        <tr class="dev-row" data-search="{{ $searchText }}">
                            <td class="px-4 py-3">
                                <span class="fw-bold text-primary font-monospace">{{ $devolucion->numero }}</span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="fw-semibold small">{{ $devolucion->fecha->format('d/m/Y') }}</div>
                                <small class="text-muted">{{ $devolucion->fecha->diffForHumans() }}</small>
                            </td>
                            <td class="px-4 py-3">
                                <div class="fw-semibold small">{{ $devolucion->proveedor->razon_social ?? '—' }}</div>
                                <small class="text-muted">{{ $devolucion->usuario->name ?? '—' }}</small>
                            </td>
                            <td class="px-4 py-3">
                                <span class="text-muted small" style="max-width:200px; display:block; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                    {{ $devolucion->motivo }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="badge bg-{{ $color }}-subtle text-{{ $color }} rounded-pill px-3 py-2 fw-bold small">
                                    <i class="fas fa-{{ $icon }} me-1"></i>
                                    {{ ucfirst($devolucion->estado) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-end">
                                <span class="fw-bold">
                                    S/. {{ number_format($devolucion->total ?? 0, 2) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <a href="{{ route('admin.devoluciones.show', $devolucion->id) }}"
                                       class="btn btn-sm btn-outline-primary rounded-pill px-3"
                                       title="Ver detalle">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($devolucion->estado === 'pendiente')
                                    <a href="{{ route('admin.devoluciones.edit', $devolucion->id) }}"
                                       class="btn btn-sm btn-outline-secondary rounded-pill px-3"
                                       title="Editar">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        <tr class="no-results-msg d-none">
                            <td colspan="7" class="text-center py-4">
                                <i class="fas fa-search text-muted fa-lg mb-2 d-block"></i>
                                <span class="text-muted">Sin resultados para tu búsqueda</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            @if($devoluciones->hasPages())
            <div class="px-4 py-3 border-top bg-light">
                {{ $devoluciones->links() }}
            </div>
            @endif

            @else
            <div class="text-center py-5">
                <div class="bg-light d-inline-flex p-4 rounded-circle mb-3">
                    <i class="fas fa-undo text-muted fa-2x"></i>
                </div>
                <h5 class="text-dark fw-bold">No hay vales de devolución registrados</h5>
                <p class="text-muted mb-3">Crea el primer vale de devolución para comenzar.</p>
                <a href="{{ route('admin.devoluciones.create') }}"
                   class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow-sm border-0">
                    <i class="fas fa-plus me-2"></i> Nuevo Vale
                </a>
            </div>
            @endif
        </div>
    </div>

</div>

@push('scripts')
<script>
function devolucionIndex() {
    return {
        search: '',
        filterRows() {
            const s = this.search.toLowerCase();
            const rows = document.querySelectorAll('tr.dev-row');
            let visible = 0;
            rows.forEach(row => {
                const text = row.dataset.search || '';
                const show = s === '' || text.includes(s);
                row.style.display = show ? '' : 'none';
                if (show) visible++;
            });
            const noResults = document.querySelector('tr.no-results-msg');
            if (noResults) noResults.classList.toggle('d-none', visible > 0);
        }
    };
}
</script>
@endpush
@endsection
