@extends('admin.layouts.app')

@section('title', 'Punto de Venta')

@push('styles')
    @include('admin.ventas.pos.partials.styles')
@endpush

@section('content')
<div class="container-fluid px-4">
    <!-- Header -->
    

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