@extends('admin.layouts.app')
@section('title', 'Recepción de Órdenes')
@section('header', 'Recepción de Órdenes de Compra')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Header -->
    <div class="card mb-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; border-radius: 16px;">
        <div class="card-body text-white p-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="mb-2 fw-bold">
                        📦 Recepción de Órdenes
                    </h1>
                    <p class="mb-0 opacity-75">Gestiona y recepciona las órdenes de compra</p>
                </div>
                <div class="col-md-4 text-end">
                    <a href="{{ route('admin.recepcion.historial') }}" 
                       class="btn btn-light text-dark fw-bold px-4 py-2" 
                       style="border-radius: 12px;">
                        <i class="fas fa-history me-2"></i> Historial
                    </a>
                </div>
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3>Generar Reporte Kardex</h3>
                        <a href="{{ route('admin.inventario.kardex.consulta') }}" class="btn btn-info">
                            <i class="fas fa-search me-2"></i>Consultar Movimientos
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs Navigation -->
    <div class="card border-0 shadow mb-4" style="border-radius: 16px;">
        <div class="card-body p-0">
            <ul class="nav nav-tabs nav-fill" id="recepcionTabs" role="tablist" style="border-bottom: 2px solid #f1f5f9;">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active fw-bold px-4 py-3" 
                            id="pendientes-tab" 
                            data-bs-toggle="tab" 
                            data-bs-target="#pendientes" 
                            type="button" 
                            role="tab" 
                            style="border: none; border-radius: 16px 0 0 0;">
                        <i class="fas fa-clock me-2"></i>
                        Pendientes
                        <span class="badge bg-warning ms-2">{{ $ordenes->where('estado_recepcion', '!=', 'completo')->count() }}</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-bold px-4 py-3" 
                            id="parciales-tab" 
                            data-bs-toggle="tab" 
                            data-bs-target="#parciales" 
                            type="button" 
                            role="tab"
                            style="border: none;">
                        <i class="fas fa-pause-circle me-2"></i>
                        Parciales
                        <span class="badge bg-info ms-2">{{ $ordenes->where('estado_recepcion', 'parcial')->count() }}</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-bold px-4 py-3" 
                            id="completas-tab" 
                            data-bs-toggle="tab" 
                            data-bs-target="#completas" 
                            type="button" 
                            role="tab"
                            style="border: none;">
                        <i class="fas fa-check-circle me-2"></i>
                        Completas
                        <span class="badge bg-success ms-2">{{ $ordenes->where('estado_recepcion', 'completo')->count() }}</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-bold px-4 py-3" 
                            id="todas-tab" 
                            data-bs-toggle="tab" 
                            data-bs-target="#todas" 
                            type="button" 
                            role="tab"
                            style="border: none; border-radius: 0 16px 0 0;">
                        <i class="fas fa-list me-2"></i>
                        Todas
                        <span class="badge bg-primary ms-2">{{ $ordenes->count() }}</span>
                    </button>
                </li>
            </ul>
        </div>
    </div>

    <!-- Tab Content -->
    <div class="tab-content" id="recepcionTabsContent">
        <!-- Pendientes Tab -->
        <div class="tab-pane fade show active" id="pendientes" role="tabpanel">
            @include('admin.compras.documentos.recepcion.partials.table', [
                'ordenes' => $ordenes->where('estado_recepcion', '!=', 'completo'),
                'titulo' => 'Órdenes Pendientes de Recepción',
                'mostrarAcciones' => true
            ])
        </div>

        <!-- Parciales Tab -->
        <div class="tab-pane fade" id="parciales" role="tabpanel">
            @include('admin.compras.documentos.recepcion.partials.table', [
                'ordenes' => $ordenes->where('estado_recepcion', 'parcial'),
                'titulo' => 'Órdenes con Recepción Parcial',
                'mostrarAcciones' => true
            ])
        </div>

        <!-- Completas Tab -->
        <div class="tab-pane fade" id="completas" role="tabpanel">
            @include('admin.compras.documentos.recepcion.partials.table', [
                'ordenes' => $ordenes->where('estado_recepcion', 'completo'),
                'titulo' => 'Órdenes Completamente Recibidas',
                'mostrarAcciones' => false
            ])
        </div>

        <!-- Todas Tab -->
        <div class="tab-pane fade" id="todas" role="tabpanel">
            @include('admin.compras.documentos.recepcion.partials.table', [
                'ordenes' => $ordenes,
                'titulo' => 'Todas las Órdenes',
                'mostrarAcciones' => true
            ])
        </div>
    </div>

    <!-- Statistics Cards -->
    @if($ordenes->count() > 0)
    <div class="row mt-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 text-center h-100" 
                 style="background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%); 
                        border-radius: 16px; box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);">
                <div class="card-body p-4">
                    <div class="text-primary mb-3">
                        <i class="fas fa-shopping-cart fa-3x"></i>
                    </div>
                    <h2 class="fw-bold text-primary mb-2">{{ $ordenes->count() }}</h2>
                    <p class="text-muted mb-0 small text-uppercase fw-bold">Total Órdenes</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 text-center h-100" 
                 style="background: linear-gradient(135deg, rgba(255, 193, 7, 0.1) 0%, rgba(255, 152, 0, 0.1) 100%); 
                        border-radius: 16px; box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);">
                <div class="card-body p-4">
                    <div class="text-warning mb-3">
                        <i class="fas fa-clock fa-3x"></i>
                    </div>
                    <h2 class="fw-bold text-warning mb-2">{{ $ordenes->where('estado_recepcion', 'parcial')->count() }}</h2>
                    <p class="text-muted mb-0 small text-uppercase fw-bold">Recepciones Parciales</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 text-center h-100" 
                 style="background: linear-gradient(135deg, rgba(13, 202, 240, 0.1) 0%, rgba(108, 117, 125, 0.1) 100%); 
                        border-radius: 16px; box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);">
                <div class="card-body p-4">
                    <div class="text-info mb-3">
                        <i class="fas fa-boxes fa-3x"></i>
                    </div>
                    <h2 class="fw-bold text-info mb-2">{{ $ordenes->sum(function($orden) { return $orden->detalles->sum('cantidad_en_compra'); }) }}</h2>
                    <p class="text-muted mb-0 small text-uppercase fw-bold">Items Totales</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 text-center h-100" 
                 style="background: linear-gradient(135deg, rgba(25, 135, 84, 0.1) 0%, rgba(16, 185, 129, 0.1) 100%); 
                        border-radius: 16px; box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);">
                <div class="card-body p-4">
                    <div class="text-success mb-3">
                        <i class="fas fa-check-double fa-3x"></i>
                    </div>
                    <h2 class="fw-bold text-success mb-2">{{ $ordenes->sum(function($orden) { return $orden->detalles->sum('cantidad_recibida'); }) }}</h2>
                    <p class="text-muted mb-0 small text-uppercase fw-bold">Items Recibidos</p>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Efecto hover para las tarjetas de estadísticas
    const statCards = document.querySelectorAll('.col-lg-3 .card');
    statCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(0px)';
            this.style.transition = 'all 0.3s ease';
            this.style.boxShadow = '0 8px 32px rgba(0, 0, 0, 0.15)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '0 4px 16px rgba(0, 0, 0, 0.08)';
        });
    });
    
    // Animación de entrada para las estadísticas
    const animateCounters = () => {
        const counters = document.querySelectorAll('.col-lg-3 h2');
        counters.forEach(counter => {
            const target = parseInt(counter.textContent);
            const duration = 1500;
            const step = target / (duration / 16);
            let current = 0;
            
            const updateCounter = () => {
                current += step;
                if (current < target) {
                    counter.textContent = Math.floor(current);
                    requestAnimationFrame(updateCounter);
                } else {
                    counter.textContent = target;
                }
            };
            
            updateCounter();
        });
    };
    
    // Observador para activar animación cuando las estadísticas sean visibles
    const statsObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounters();
                statsObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });
    
    const statsSection = document.querySelector('.row.mt-4');
    if (statsSection) {
        statsObserver.observe(statsSection);
    }
});
</script>
@endpush
@endsection