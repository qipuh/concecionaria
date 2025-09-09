@extends('admin.layouts.app')

@section('title', 'Dashboard Principal')

@push('styles')
<style>
    .dashboard-hero {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 3rem 0;
        margin: -1.5rem -1.5rem 2rem -1.5rem;
        border-radius: 0 0 1.5rem 1.5rem;
    }
    
    .stat-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: none;
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        border-radius: 1rem;
    }
    
    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 10px 10px -5px rgb(0 0 0 / 0.04);
    }
    
    .stat-icon {
        font-size: 2.5rem;
        opacity: 0.9;
    }
    
    .dashboard-card {
        border: none;
        box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
        border-radius: 1rem;
    }
    
    .dashboard-card .card-header {
        background-color: transparent;
        border-bottom: 1px solid #e5e7eb;
        border-radius: 1rem 1rem 0 0;
        padding: 1.5rem 1.5rem 1rem 1.5rem;
    }
    
    .quick-action-btn {
        transition: all 0.3s ease;
        border-radius: 0.75rem;
    }
    
    .quick-action-btn:hover {
        transform: translateY(-2px);
    }
    
    .progress-ring {
        transform: rotate(-90deg);
    }
    
    .progress-ring-circle {
        transition: stroke-dashoffset 0.35s;
        stroke-linecap: round;
    }
    
    @media (max-width: 768px) {
        .dashboard-hero {
            padding: 2rem 0;
            margin: -1rem -1rem 1.5rem -1rem;
        }
        
        .stat-card .card-body {
            padding: 1.25rem;
        }
        
        .stat-icon {
            font-size: 2rem;
        }
    }
</style>
@endpush

@section('content')
    <!-- Hero Section -->
    <div class="dashboard-hero">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-3">¡Bienvenido a MSA Automotriz!</h1>
                    <p class="lead mb-0 opacity-75">Sistema integral de gestión automotriz - Panel de control principal</p>
                </div>
                <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                    <div class="d-inline-block text-center">
                        <div class="fs-1 fw-bold">{{ \Carbon\Carbon::now()->format('d') }}</div>
                        <div class="small opacity-75">{{ \Carbon\Carbon::now()->format('M Y') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Estadísticas principales -->
    <div class="row g-4 mb-5">
        <div class="col-xl-3 col-md-6">
            <div class="card stat-card bg-primary text-white h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="card-title text-uppercase text-white-50 mb-2">Total Usuarios</h6>
                            <h2 class="mb-0 fw-bold">{{ $totalUsuarios ?? 0 }}</h2>
                            <p class="small mb-0 text-white-50">Sistema activo</p>
                        </div>
                        <div class="col-auto">
                            <div class="stat-icon">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <a href="{{ route('admin.usuarios.usuarios.index') }}" class="text-white text-decoration-none small">
                        <i class="fas fa-external-link-alt me-1"></i>Ver usuarios
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card stat-card bg-success text-white h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="card-title text-uppercase text-white-50 mb-2">Ventas del Mes</h6>
                            <h2 class="mb-0 fw-bold">S/ {{ number_format($ventasMes ?? 0, 2) }}</h2>
                            <p class="small mb-0 text-white-50">Facturación actual</p>
                        </div>
                        <div class="col-auto">
                            <div class="stat-icon">
                                <i class="fas fa-chart-line"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <a href="{{ route('admin.ventas.index') }}" class="text-white text-decoration-none small">
                        <i class="fas fa-external-link-alt me-1"></i>Ver ventas
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card stat-card bg-warning text-white h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="card-title text-uppercase text-white-50 mb-2">Órdenes Pendientes</h6>
                            <h2 class="mb-0 fw-bold">{{ $ordenesPendientes ?? 0 }}</h2>
                            <p class="small mb-0 text-white-50">Requieren atención</p>
                        </div>
                        <div class="col-auto">
                            <div class="stat-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <a href="{{ route('admin.mantenimiento.ordenes.index') }}" class="text-white text-decoration-none small">
                        <i class="fas fa-external-link-alt me-1"></i>Ver órdenes
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card stat-card bg-info text-white h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="card-title text-uppercase text-white-50 mb-2">Stock Crítico</h6>
                            <h2 class="mb-0 fw-bold">{{ $stockCritico ?? 0 }}</h2>
                            <p class="small mb-0 text-white-50">Items por reponer</p>
                        </div>
                        <div class="col-auto">
                            <div class="stat-icon">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <a href="{{ route('admin.inventario.index') }}" class="text-white text-decoration-none small">
                        <i class="fas fa-external-link-alt me-1"></i>Ver inventario
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Acciones rápidas -->
    <div class="row g-4 mb-5">
        <div class="col-12">
            <div class="card dashboard-card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-bolt text-warning me-2"></i>
                        <h5 class="mb-0">Acciones Rápidas</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-lg-2 col-md-4 col-6">
                            <a href="{{ route('admin.ventas.cotizaciones.create') }}" class="btn btn-outline-primary quick-action-btn w-100 py-3">
                                <i class="fas fa-file-invoice fa-2x d-block mb-2"></i>
                                <small class="fw-semibold">Nueva Cotización</small>
                            </a>
                        </div>
                        <div class="col-lg-2 col-md-4 col-6">
                            <a href="{{ route('admin.ventas.pos.index') }}" class="btn btn-outline-success quick-action-btn w-100 py-3">
                                <i class="fas fa-cash-register fa-2x d-block mb-2"></i>
                                <small class="fw-semibold">Punto de Venta</small>
                            </a>
                        </div>
                        <div class="col-lg-2 col-md-4 col-6">
                            <a href="{{ route('admin.mantenimiento.citas.create') }}" class="btn btn-outline-info quick-action-btn w-100 py-3">
                                <i class="fas fa-calendar-plus fa-2x d-block mb-2"></i>
                                <small class="fw-semibold">Agendar Cita</small>
                            </a>
                        </div>
                        <div class="col-lg-2 col-md-4 col-6">
                            <a href="{{ route('admin.clientes.create') }}" class="btn btn-outline-warning quick-action-btn w-100 py-3">
                                <i class="fas fa-user-plus fa-2x d-block mb-2"></i>
                                <small class="fw-semibold">Nuevo Cliente</small>
                            </a>
                        </div>
                        <div class="col-lg-2 col-md-4 col-6">
                            <a href="{{ route('admin.compras.ordenes.create') }}" class="btn btn-outline-secondary quick-action-btn w-100 py-3">
                                <i class="fas fa-shopping-cart fa-2x d-block mb-2"></i>
                                <small class="fw-semibold">Nueva Compra</small>
                            </a>
                        </div>
                        <div class="col-lg-2 col-md-4 col-6">
                            <a href="{{ route('admin.inventario.movimientos.create') }}" class="btn btn-outline-dark quick-action-btn w-100 py-3">
                                <i class="fas fa-exchange-alt fa-2x d-block mb-2"></i>
                                <small class="fw-semibold">Movimiento</small>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Actividad reciente -->
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card dashboard-card">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-chart-bar text-primary me-2"></i>
                            <h5 class="mb-0">Actividad del Sistema</h5>
                        </div>
                        <span class="badge bg-primary">Últimos 30 días</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <div class="fs-3 fw-bold text-primary">{{ $actividadReciente['cotizaciones'] ?? 0 }}</div>
                                <small class="text-muted">Cotizaciones</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <div class="fs-3 fw-bold text-success">{{ $actividadReciente['ventas'] ?? 0 }}</div>
                                <small class="text-muted">Ventas</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <div class="fs-3 fw-bold text-warning">{{ $actividadReciente['ordenes'] ?? 0 }}</div>
                                <small class="text-muted">Órdenes</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <div class="fs-3 fw-bold text-info">{{ $actividadReciente['clientes'] ?? 0 }}</div>
                                <small class="text-muted">Nuevos Clientes</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card dashboard-card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-bell text-danger me-2"></i>
                        <h5 class="mb-0">Notificaciones</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center p-3 bg-light rounded mb-3">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-warning fa-lg"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="small fw-semibold">Stock Bajo</div>
                            <div class="small text-muted">{{ $stockCritico ?? 0 }} productos necesitan reposición</div>
                        </div>
                    </div>
                    
                    <div class="d-flex align-items-center p-3 bg-light rounded mb-3">
                        <div class="flex-shrink-0">
                            <i class="fas fa-clock text-info fa-lg"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="small fw-semibold">Citas Pendientes</div>
                            <div class="small text-muted">{{ $citasPendientes ?? 0 }} citas programadas para hoy</div>
                        </div>
                    </div>
                    
                    <div class="d-flex align-items-center p-3 bg-light rounded">
                        <div class="flex-shrink-0">
                            <i class="fas fa-tools text-success fa-lg"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="small fw-semibold">Órdenes Activas</div>
                            <div class="small text-muted">{{ $ordenesPendientes ?? 0 }} en proceso</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection