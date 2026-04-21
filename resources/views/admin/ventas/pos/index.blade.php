@extends('admin.layouts.app')

@section('title', 'Punto de Venta')

@push('styles')
    @include('admin.ventas.pos.partials.styles')

    <style>
    /* ELIMINACIÓN TOTAL DE BACKDROP EN POS */
    .modal-backdrop,
    .modal-backdrop.fade,
    .modal-backdrop.show,
    div[class*="backdrop"] {
        display: none !important;
        visibility: hidden !important;
        opacity: 0 !important;
        z-index: -9999 !important;
    }

    body.modal-open {
        overflow: auto !important;
        padding-right: 0 !important;
    }
    </style>
@endpush

@section('content')
<div class="dashboard-hero" style="padding: 2rem 2rem; border-radius: 0 0 1.5rem 1.5rem; margin-bottom: 2.5rem;">
    <div class="hero-glow-alt" style="top: -50px; right: 0; filter: blur(60px); opacity: 0.2;"></div>
    <div class="container-fluid position-relative z-1">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center">
            <div class="mb-3 mb-lg-0">
                <div class="d-inline-flex align-items-center px-3 py-1 bg-white bg-opacity-10 rounded-pill fs-6 mb-3 border border-white border-opacity-25 backdrop-blur">
                    <i class="fas fa-desktop text-info me-2"></i> Terminal POS
                </div>
                <h2 class="fw-bold mb-1 tracking-tight text-white display-6 text-shadow-sm">Punto de Venta</h2>
                <p class="text-white-50 mb-0">Atención en mostrador y facturación rápida.</p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('admin.ventas.pos.ventas') }}" class="btn bg-white text-dark rounded-pill px-4 py-2 fw-bold shadow-sm transition hover:scale-105 border-0">
                    <i class="fas fa-history text-primary me-2"></i> Ver Historial de Ventas
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid px-3 px-lg-4 position-relative" style="top: -3.5rem; z-index: 10;">
    <div class="row">
        <!-- Panel izquierdo - Búsqueda y productos -->
        <div class="col-md-8">
            @include('admin.ventas.pos.partials.search-panel')
        </div>

        <!-- Panel derecho - Carrito de venta -->
        <div class="col-md-4">
            @include('admin.ventas.pos.partials.cart-panel')
        </div>
    </div>
</div>

<!-- Modales -->
@include('admin.ventas.pos.partials.modals.cliente-modal')
@include('admin.ventas.pos.partials.modals.item-modal')
@include('admin.ventas.pos.partials.modals.success-modal')

<!-- Container para notificaciones toast -->
<div id="toast-container" class="toast-container position-fixed top-0 end-0 p-3"></div>

@endsection

@push('scripts')
    @include('admin.ventas.pos.partials.scripts')
@endpush