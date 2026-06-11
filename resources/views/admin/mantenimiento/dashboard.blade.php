<!-- resources/views/admin/mantenimiento/dashboard.blade.php -->
@extends('admin.layouts.app')

@section('title', 'Dashboard de Mantenimiento')

@section('content')
<div class="dashboard-hero" style="padding: 2rem 2rem; border-radius: 0 0 1.5rem 1.5rem; margin-bottom: 2.5rem;">
    <div class="hero-glow-alt" style="top: -50px; right: 0; filter: blur(60px); opacity: 0.2;"></div>
    <div class="container-fluid position-relative z-1">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center">
            <div class="mb-3 mb-lg-0">
                <div class="d-inline-flex align-items-center px-3 py-1 bg-white bg-opacity-10 rounded-pill fs-6 mb-3 border border-white border-opacity-25">
                    <i class="fas fa-tools text-warning me-2"></i> Mantenimiento
                </div>
                <h2 class="fw-bold mb-1 tracking-tight text-white display-6 text-shadow-sm">Dashboard de Mantenimiento</h2>
                <p class="text-white-50 mb-0">Monitoreo en tiempo real de operaciones del taller</p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <button type="button" class="btn bg-white bg-opacity-10 text-white rounded-pill px-4 py-2 fw-bold border border-white border-opacity-25" id="refreshData">
                    <i class="fas fa-sync-alt me-1"></i>
                    <span class="d-none d-sm-inline">Actualizar</span>
                </button>
                <div class="dropdown">
                    <button class="btn bg-white bg-opacity-10 text-white rounded-pill px-4 py-2 fw-bold border border-white border-opacity-25 dropdown-toggle" type="button" id="periodDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-calendar me-1"></i>
                        <span class="d-none d-sm-inline">Esta semana</span>
                        <span class="d-sm-none">Semana</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="periodDropdown">
                        <li><a class="dropdown-item" href="#" data-period="day">Hoy</a></li>
                        <li><a class="dropdown-item active" href="#" data-period="week">Esta semana</a></li>
                        <li><a class="dropdown-item" href="#" data-period="month">Este mes</a></li>
                        <li><a class="dropdown-item" href="#" data-period="year">Este año</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid px-3 px-lg-4 position-relative" style="top: -3.5rem; z-index: 10;">

    <!-- Tarjetas de estadísticas -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card dashboard-card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="bg-primary-subtle d-inline-flex p-3 rounded-3">
                            <i class="fas fa-calendar-alt text-primary fa-lg"></i>
                        </div>
                        <span class="badge bg-primary-subtle text-primary rounded-pill px-3">Citas</span>
                    </div>
                    <h2 class="fw-bold mb-1" id="citasCount">{{ $estadisticas['citas_pendientes'] }}</h2>
                    <p class="text-muted small mb-0">Pendientes de atención</p>
                </div>
                <div class="card-footer bg-white border-0 pb-3 pt-0 px-4">
                    <a href="{{ route('admin.mantenimiento.citas.index') }}" class="text-primary text-decoration-none small fw-semibold">
                        Ver detalles <i class="fas fa-angle-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card dashboard-card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="bg-warning-subtle d-inline-flex p-3 rounded-3">
                            <i class="fas fa-tools text-warning fa-lg"></i>
                        </div>
                        <span class="badge bg-warning-subtle text-warning rounded-pill px-3">En Proceso</span>
                    </div>
                    <h2 class="fw-bold mb-1" id="ordenesProcesoCount">{{ $estadisticas['ordenes_en_proceso'] }}</h2>
                    <p class="text-muted small mb-0">En diagnóstico o trabajo</p>
                </div>
                <div class="card-footer bg-white border-0 pb-3 pt-0 px-4">
                    <a href="{{ route('admin.mantenimiento.ordenes.index', ['estado' => 'en_proceso']) }}" class="text-warning text-decoration-none small fw-semibold">
                        Ver detalles <i class="fas fa-angle-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card dashboard-card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="bg-success-subtle d-inline-flex p-3 rounded-3">
                            <i class="fas fa-check-circle text-success fa-lg"></i>
                        </div>
                        <span class="badge bg-success-subtle text-success rounded-pill px-3">Completadas</span>
                    </div>
                    <h2 class="fw-bold mb-1" id="ordenesCompletadasCount">{{ $estadisticas['ordenes_completadas'] }}</h2>
                    <p class="text-muted small mb-0">En el período actual</p>
                </div>
                <div class="card-footer bg-white border-0 pb-3 pt-0 px-4">
                    <a href="{{ route('admin.mantenimiento.ordenes.index', ['estado' => 'completado']) }}" class="text-success text-decoration-none small fw-semibold">
                        Ver detalles <i class="fas fa-angle-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card dashboard-card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="bg-info-subtle d-inline-flex p-3 rounded-3">
                            <i class="fas fa-file-invoice-dollar text-info fa-lg"></i>
                        </div>
                        <span class="badge bg-info-subtle text-info rounded-pill px-3">Facturación</span>
                    </div>
                    <h2 class="fw-bold mb-1" id="facturacionTotal">S/ {{ number_format($estadisticas['facturacion_total'], 2) }}</h2>
                    <p class="text-muted small mb-0">En el período actual</p>
                </div>
                <div class="card-footer bg-white border-0 pb-3 pt-0 px-4">
                    <a href="{{ route('admin.mantenimiento.ordenes.index', ['estado' => 'facturado']) }}" class="text-info text-decoration-none small fw-semibold">
                        Ver detalles <i class="fas fa-angle-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráficos de análisis -->
    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="card dashboard-card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                    <h6 class="fw-bold mb-0"><i class="fas fa-chart-pie me-2 text-primary"></i> Órdenes por Estado</h6>
                </div>
                <div class="card-body p-4">
                    <div style="position: relative; height: 300px;">
                        <canvas id="estadoOrdenesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card dashboard-card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                    <h6 class="fw-bold mb-0"><i class="fas fa-chart-line me-2 text-success"></i> Facturación Mensual</h6>
                </div>
                <div class="card-body p-4">
                    <div style="position: relative; height: 300px;">
                        <canvas id="facturacionMensualChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tablas de actividad reciente -->
    <div class="row g-4 mb-4">
        <!-- Citas Próximas -->
        <div class="col-xl-6">
            <div class="card dashboard-card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-4 pb-0 px-4 d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0"><i class="fas fa-calendar-check me-2 text-info"></i> Próximas Citas</h6>
                    <span class="badge bg-info-subtle text-info rounded-pill px-3">{{ count($proximasCitas) }}</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive" style="max-height: 350px; overflow-y: auto;">
                        <table class="table table-hover table-sm align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="py-3 px-4 border-0 text-uppercase small">Fecha</th>
                                    <th class="py-3 px-4 border-0 text-uppercase small">Cliente</th>
                                    <th class="py-3 px-4 border-0 text-uppercase small d-none d-md-table-cell">Vehículo</th>
                                    <th class="py-3 px-4 border-0 text-uppercase small d-none d-lg-table-cell">Motivo</th>
                                    <th class="py-3 px-4 border-0 text-uppercase small text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($proximasCitas as $cita)
                                    <tr>
                                        <td class="px-4 small">
                                            <div class="fw-semibold">{{ \Carbon\Carbon::parse($cita->fecha_hora_cita)->format('d/m') }}</div>
                                            <div class="text-muted">{{ \Carbon\Carbon::parse($cita->fecha_hora_cita)->format('H:i') }}</div>
                                        </td>
                                        <td class="px-4 small fw-semibold">
                                            @if($cita->cliente->tipo_cliente == 'persona')
                                                {{ $cita->cliente->nombres }} {{ $cita->cliente->apellido_paterno }}
                                            @else
                                                {{ $cita->cliente->razon_social }}
                                            @endif
                                        </td>
                                        <td class="px-4 small fw-semibold d-none d-md-table-cell">{{ $cita->vehiculo->nro_placa }}</td>
                                        <td class="px-4 small text-muted d-none d-lg-table-cell">{{ Str::limit($cita->motivo_visita, 25) }}</td>
                                        <td class="px-4 text-center">
                                            <a href="{{ route('admin.mantenimiento.citas.show', $cita) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <div class="bg-light d-inline-flex p-3 rounded-circle mb-2"><i class="fas fa-calendar-times text-muted fa-2x"></i></div>
                                            <div class="text-muted">No hay citas próximas</div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Órdenes en Progreso -->
        <div class="col-xl-6">
            <div class="card dashboard-card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-4 pb-0 px-4 d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0"><i class="fas fa-cogs me-2 text-warning"></i> Órdenes en Progreso</h6>
                    <span class="badge bg-warning-subtle text-warning rounded-pill px-3">{{ count($ordenesEnProgreso) }}</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive" style="max-height: 350px; overflow-y: auto;">
                        <table class="table table-hover table-sm align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="py-3 px-4 border-0 text-uppercase small">Código</th>
                                    <th class="py-3 px-4 border-0 text-uppercase small">Cliente</th>
                                    <th class="py-3 px-4 border-0 text-uppercase small d-none d-md-table-cell">Vehículo</th>
                                    <th class="py-3 px-4 border-0 text-uppercase small d-none d-lg-table-cell">Estado</th>
                                    <th class="py-3 px-4 border-0 text-uppercase small d-none d-xl-table-cell">Técnico</th>
                                    <th class="py-3 px-4 border-0 text-uppercase small text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($ordenesEnProgreso as $orden)
                                    <tr>
                                        <td class="px-4 small">
                                            <span class="fw-semibold text-primary">{{ $orden->codigo_orden }}</span>
                                        </td>
                                        <td class="px-4 small fw-semibold">
                                            @if($orden->cliente->tipo_cliente == 'persona')
                                                {{ $orden->cliente->nombres }} {{ $orden->cliente->apellido_paterno }}
                                            @else
                                                {{ $orden->cliente->razon_social }}
                                            @endif
                                        </td>
                                        <td class="px-4 small fw-semibold d-none d-md-table-cell">{{ $orden->vehiculo->nro_placa }}</td>
                                        <td class="px-4 small d-none d-lg-table-cell">
                                            @switch($orden->estado)
                                                @case('diagnostico')
                                                    <span class="badge bg-info-subtle text-info rounded-pill px-2">Diagnóstico</span>
                                                    @break
                                                @case('espera_aprobacion')
                                                    <span class="badge bg-warning-subtle text-warning rounded-pill px-2">Esperando</span>
                                                    @break
                                                @case('en_progreso')
                                                    <span class="badge bg-primary-subtle text-primary rounded-pill px-2">En Progreso</span>
                                                    @break
                                            @endswitch
                                        </td>
                                        <td class="px-4 small text-muted d-none d-xl-table-cell">{{ $orden->tecnico->name ?? 'Sin asignar' }}</td>
                                        <td class="px-4 text-center">
                                            <a href="{{ route('admin.mantenimiento.ordenes.show', $orden) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5">
                                            <div class="bg-light d-inline-flex p-3 rounded-circle mb-2"><i class="fas fa-tools text-muted fa-2x"></i></div>
                                            <div class="text-muted">No hay órdenes en progreso</div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Rankings y estadísticas detalladas -->
    <div class="row g-4 mb-4">
        <!-- Top Servicios -->
        <div class="col-xl-6">
            <div class="card dashboard-card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                    <h6 class="fw-bold mb-0"><i class="fas fa-trophy me-2 text-success"></i> Servicios Más Solicitados</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive" style="max-height: 350px; overflow-y: auto;">
                        <table class="table table-hover table-sm align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="py-3 px-4 border-0 text-uppercase small text-center" width="60">#</th>
                                    <th class="py-3 px-4 border-0 text-uppercase small">Servicio</th>
                                    <th class="py-3 px-4 border-0 text-uppercase small text-center">Cantidad</th>
                                    <th class="py-3 px-4 border-0 text-uppercase small text-end">Ingresos</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topServicios as $index => $servicio)
                                    <tr>
                                        <td class="px-4 text-center">
                                            <span class="badge {{ $index == 0 ? 'bg-warning-subtle text-warning' : ($index == 1 ? 'bg-secondary-subtle text-secondary' : ($index == 2 ? 'bg-danger-subtle text-danger' : 'bg-light text-dark')) }} rounded-pill">
                                                {{ $index + 1 }}
                                            </span>
                                        </td>
                                        <td class="px-4 small fw-semibold">{{ Str::limit($servicio->descripcion, 35) }}</td>
                                        <td class="px-4 text-center">
                                            <span class="badge bg-primary-subtle text-primary rounded-pill px-3">{{ $servicio->cantidad }}</span>
                                        </td>
                                        <td class="px-4 text-end fw-semibold text-success">S/ {{ number_format($servicio->total, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">
                                            <i class="fas fa-chart-bar fa-2x mb-2"></i>
                                            <div>No hay datos disponibles</div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Repuestos -->
        <div class="col-xl-6">
            <div class="card dashboard-card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                    <h6 class="fw-bold mb-0"><i class="fas fa-cog me-2 text-primary"></i> Repuestos Más Utilizados</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive" style="max-height: 350px; overflow-y: auto;">
                        <table class="table table-hover table-sm align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="py-3 px-4 border-0 text-uppercase small text-center" width="60">#</th>
                                    <th class="py-3 px-4 border-0 text-uppercase small">Repuesto</th>
                                    <th class="py-3 px-4 border-0 text-uppercase small text-center">Cantidad</th>
                                    <th class="py-3 px-4 border-0 text-uppercase small text-end">Ingresos</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topRepuestos as $index => $repuesto)
                                    <tr>
                                        <td class="px-4 text-center">
                                            <span class="badge {{ $index == 0 ? 'bg-warning-subtle text-warning' : ($index == 1 ? 'bg-secondary-subtle text-secondary' : ($index == 2 ? 'bg-danger-subtle text-danger' : 'bg-light text-dark')) }} rounded-pill">
                                                {{ $index + 1 }}
                                            </span>
                                        </td>
                                        <td class="px-4 small fw-semibold">{{ Str::limit($repuesto->descripcion, 35) }}</td>
                                        <td class="px-4 text-center">
                                            <span class="badge bg-info-subtle text-info rounded-pill px-3">{{ $repuesto->cantidad }}</span>
                                        </td>
                                        <td class="px-4 text-end fw-semibold text-success">S/ {{ number_format($repuesto->total, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">
                                            <i class="fas fa-wrench fa-2x mb-2"></i>
                                            <div>No hay datos disponibles</div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const estadoOrdenesData = {
                labels: ['Diagnóstico', 'Esperando Aprobación', 'En Progreso', 'Finalizado', 'Facturado', 'Entregado'],
                datasets: [{
                    label: 'Órdenes de Trabajo',
                    data: [
                        {{ $estadisticas['ordenes_diagnostico'] }},
                        {{ $estadisticas['ordenes_espera_aprobacion'] }},
                        {{ $estadisticas['ordenes_en_proceso'] }},
                        {{ $estadisticas['ordenes_finalizadas'] }},
                        {{ $estadisticas['ordenes_facturadas'] }},
                        {{ $estadisticas['ordenes_entregadas'] }}
                    ],
                    backgroundColor: [
                        'rgba(23, 162, 184, 0.7)',
                        'rgba(255, 193, 7, 0.7)',
                        'rgba(0, 123, 255, 0.7)',
                        'rgba(40, 167, 69, 0.7)',
                        'rgba(108, 117, 125, 0.7)',
                        'rgba(52, 58, 64, 0.7)'
                    ],
                    borderColor: [
                        'rgba(23, 162, 184, 1)',
                        'rgba(255, 193, 7, 1)',
                        'rgba(0, 123, 255, 1)',
                        'rgba(40, 167, 69, 1)',
                        'rgba(108, 117, 125, 1)',
                        'rgba(52, 58, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            };

            const facturacionMensualData = {
                labels: {!! json_encode($estadisticas['facturacion_mensual_labels']) !!},
                datasets: [{
                    label: 'Facturación Mensual (S/)',
                    data: {!! json_encode($estadisticas['facturacion_mensual_valores']) !!},
                    backgroundColor: 'rgba(0, 123, 255, 0.3)',
                    borderColor: 'rgba(0, 123, 255, 1)',
                    borderWidth: 1,
                    tension: 0.4,
                    fill: true
                }]
            };

            const estadoOrdenesConfig = {
                type: 'pie',
                data: estadoOrdenesData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.raw || 0;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = Math.round((value / total) * 100);
                                    return `${label}: ${value} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            };

            const facturacionMensualConfig = {
                type: 'line',
                data: facturacionMensualData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `S/ ${context.raw.toLocaleString('es-PE', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'S/ ' + value.toLocaleString('es-PE');
                                }
                            }
                        }
                    }
                }
            };

            const estadoOrdenesChart = new Chart(
                document.getElementById('estadoOrdenesChart'),
                estadoOrdenesConfig
            );

            const facturacionMensualChart = new Chart(
                document.getElementById('facturacionMensualChart'),
                facturacionMensualConfig
            );

            const periodButtons = document.querySelectorAll('[data-period]');
            periodButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    periodButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                    const periodText = this.textContent;
                    document.getElementById('periodDropdown').innerHTML = `<i class="fas fa-calendar"></i> ${periodText}`;
                    const period = this.getAttribute('data-period');
                    actualizarDatosPorPeriodo(period);
                });
            });

            function actualizarDatosPorPeriodo(period) {
                fetch(`/admin/mantenimiento/dashboard/datos?period=${period}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('citasCount').textContent = data.citas_pendientes;
                    document.getElementById('ordenesProcesoCount').textContent = data.ordenes_en_proceso;
                    document.getElementById('ordenesCompletadasCount').textContent = data.ordenes_completadas;
                    document.getElementById('facturacionTotal').textContent = `S/ ${parseFloat(data.facturacion_total).toLocaleString('es-PE', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;

                    estadoOrdenesChart.data.datasets[0].data = [
                        data.ordenes_diagnostico,
                        data.ordenes_espera_aprobacion,
                        data.ordenes_en_progreso,
                        data.ordenes_finalizadas,
                        data.ordenes_facturadas,
                        data.ordenes_entregadas
                    ];
                    estadoOrdenesChart.update();

                    facturacionMensualChart.data.labels = data.facturacion_mensual_labels;
                    facturacionMensualChart.data.datasets[0].data = data.facturacion_mensual_valores;
                    facturacionMensualChart.update();
                })
                .catch(error => { /* silent fail */ });
            }

            document.getElementById('refreshData').addEventListener('click', function() {
                const activeButton = document.querySelector('[data-period].active');
                const period = activeButton ? activeButton.getAttribute('data-period') : 'week';
                actualizarDatosPorPeriodo(period);
            });
        });
    </script>
@endpush
