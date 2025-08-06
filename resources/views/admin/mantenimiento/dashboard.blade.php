<!-- resources/views/admin/mantenimiento/dashboard.blade.php -->
@extends('admin.layouts.app')

@section('title', 'Dashboard de Mantenimiento')

@push('styles')
<style>
    .stat-card {
        transition: transform 0.3s;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
    }
    
    .stat-icon {
        font-size: 2.5rem;
        opacity: 0.8;
    }
    
    .progress {
        height: 10px;
    }
    
    .table-responsive {
        max-height: 300px;
        overflow-y: auto;
    }
</style>
@endpush

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard de Mantenimiento</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <button type="button" class="btn btn-sm btn-outline-secondary" id="refreshData">
                    <i class="fas fa-sync-alt"></i> Actualizar
                </button>
            </div>
            <div class="dropdown">
                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="periodDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-calendar"></i> Esta semana
                </button>
                <ul class="dropdown-menu" aria-labelledby="periodDropdown">
                    <li><a class="dropdown-item" href="#" data-period="day">Hoy</a></li>
                    <li><a class="dropdown-item active" href="#" data-period="week">Esta semana</a></li>
                    <li><a class="dropdown-item" href="#" data-period="month">Este mes</a></li>
                    <li><a class="dropdown-item" href="#" data-period="year">Este año</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Tarjetas de estadísticas -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card stat-card bg-primary text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Citas Agendadas</h6>
                            <h2 class="mt-2 mb-0" id="citasCount">{{ $estadisticas['citas_pendientes'] }}</h2>
                            <p class="small mb-0">Pendientes de atención</p>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a href="{{ route('admin.mantenimiento.citas.index') }}" class="text-white text-decoration-none small">Ver detalles</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card bg-warning text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Órdenes en Proceso</h6>
                            <h2 class="mt-2 mb-0" id="ordenesProcesoCount">{{ $estadisticas['ordenes_en_proceso'] }}</h2>
                            <p class="small mb-0">En diagnóstico o trabajo</p>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-tools"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a href="{{ route('admin.mantenimiento.ordenes.index', ['estado' => 'en_proceso']) }}" class="text-white text-decoration-none small">Ver detalles</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card bg-success text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Órdenes Completadas</h6>
                            <h2 class="mt-2 mb-0" id="ordenesCompletadasCount">{{ $estadisticas['ordenes_completadas'] }}</h2>
                            <p class="small mb-0">En el período actual</p>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a href="{{ route('admin.mantenimiento.ordenes.index', ['estado' => 'completado']) }}" class="text-white text-decoration-none small">Ver detalles</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card bg-info text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Facturación</h6>
                            <h2 class="mt-2 mb-0" id="facturacionTotal">S/ {{ number_format($estadisticas['facturacion_total'], 2) }}</h2>
                            <p class="small mb-0">En el período actual</p>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-file-invoice-dollar"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a href="{{ route('admin.mantenimiento.ordenes.index', ['estado' => 'facturado']) }}" class="text-white text-decoration-none small">Ver detalles</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <!-- Gráfico de Órdenes de Trabajo por Estado -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">Órdenes de Trabajo por Estado</h5>
                </div>
                <div class="card-body">
                    <canvas id="estadoOrdenesChart" height="250"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Gráfico de Facturación Mensual -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">Facturación Mensual</h5>
                </div>
                <div class="card-body">
                    <canvas id="facturacionMensualChart" height="250"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <!-- Citas Próximas -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">Próximas Citas</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Cliente</th>
                                    <th>Vehículo</th>
                                    <th>Motivo</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($proximasCitas as $cita)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($cita->fecha_hora_cita)->format('d/m/Y H:i') }}</td>
                                        <td>
                                            @if($cita->cliente->tipo_cliente == 'persona')
                                                {{ $cita->cliente->nombres }} {{ $cita->cliente->apellido_paterno }}
                                            @else
                                                {{ $cita->cliente->razon_social }}
                                            @endif
                                        </td>
                                        <td>{{ $cita->vehiculo->nro_placa }}</td>
                                        <td>{{ Str::limit($cita->motivo_visita, 30) }}</td>
                                        <td>
                                            <a href="{{ route('admin.mantenimiento.citas.show', $cita) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No hay citas próximas</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Órdenes en Progreso -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">Órdenes en Progreso</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Cliente</th>
                                    <th>Vehículo</th>
                                    <th>Estado</th>
                                    <th>Técnico</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($ordenesEnProgreso as $orden)
                                    <tr>
                                        <td>{{ $orden->codigo_orden }}</td>
                                        <td>
                                            @if($orden->cliente->tipo_cliente == 'persona')
                                                {{ $orden->cliente->nombres }} {{ $orden->cliente->apellido_paterno }}
                                            @else
                                                {{ $orden->cliente->razon_social }}
                                            @endif
                                        </td>
                                        <td>{{ $orden->vehiculo->nro_placa }}</td>
                                        <td>
                                            @switch($orden->estado)
                                                @case('diagnostico')
                                                    <span class="badge bg-info">Diagnóstico</span>
                                                    @break
                                                @case('espera_aprobacion')
                                                    <span class="badge bg-warning">Esperando Aprobación</span>
                                                    @break
                                                @case('en_progreso')
                                                    <span class="badge bg-primary">En Progreso</span>
                                                    @break
                                            @endswitch
                                        </td>
                                        <td>{{ $orden->tecnico->name ?? 'Sin asignar' }}</td>
                                        <td>
                                            <a href="{{ route('admin.mantenimiento.ordenes.show', $orden) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No hay órdenes en progreso</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <!-- Top Servicios -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">Servicios Más Solicitados</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Servicio</th>
                                    <th>Cantidad</th>
                                    <th>Ingresos</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topServicios as $index => $servicio)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $servicio->descripcion }}</td>
                                        <td>{{ $servicio->cantidad }}</td>
                                        <td>S/ {{ number_format($servicio->total, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">No hay datos disponibles</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Top Repuestos -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">Repuestos Más Utilizados</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Repuesto</th>
                                    <th>Cantidad</th>
                                    <th>Ingresos</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topRepuestos as $index => $repuesto)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $repuesto->descripcion }}</td>
                                        <td>{{ $repuesto->cantidad }}</td>
                                        <td>S/ {{ number_format($repuesto->total, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">No hay datos disponibles</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
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
            // Datos para los gráficos
            const estadoOrdenesData = {
                labels: ['Diagnóstico', 'Esperando Aprobación', 'En Progreso', 'Finalizado', 'Facturado', 'Entregado'],
                datasets: [{
                    label: 'Órdenes de Trabajo',
                    data: [
                        {{ $estadisticas['ordenes_diagnostico'] }}, 
                        {{ $estadisticas['ordenes_espera_aprobacion'] }}, 
                        {{ $estadisticas['ordenes_en_progreso'] }}, 
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
            
            // Configuración de los gráficos
            const estadoOrdenesConfig = {
                type: 'pie',
                data: estadoOrdenesData,
                options: {
                    responsive: true,
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
            
            // Inicializar los gráficos
            const estadoOrdenesChart = new Chart(
                document.getElementById('estadoOrdenesChart'),
                estadoOrdenesConfig
            );
            
            const facturacionMensualChart = new Chart(
                document.getElementById('facturacionMensualChart'),
                facturacionMensualConfig
            );
            
            // Cambiar período
            const periodButtons = document.querySelectorAll('[data-period]');
            periodButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Actualizar estado activo
                    periodButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                    
                    // Actualizar texto del botón
                    const periodText = this.textContent;
                    document.getElementById('periodDropdown').innerHTML = `<i class="fas fa-calendar"></i> ${periodText}`;
                    
                    // Aquí iría la lógica para actualizar los datos según el período seleccionado
                    // mediante una petición AJAX
                    const period = this.getAttribute('data-period');
                    actualizarDatosPorPeriodo(period);
                });
            });
            
            // Función para actualizar datos
            function actualizarDatosPorPeriodo(period) {
                fetch(`/admin/mantenimiento/dashboard/datos?period=${period}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Actualizar tarjetas de estadísticas
                    document.getElementById('citasCount').textContent = data.citas_pendientes;
                    document.getElementById('ordenesProcesoCount').textContent = data.ordenes_en_proceso;
                    document.getElementById('ordenesCompletadasCount').textContent = data.ordenes_completadas;
                    document.getElementById('facturacionTotal').textContent = `S/ ${parseFloat(data.facturacion_total).toLocaleString('es-PE', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
                    
                    // Actualizar gráficos
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
                .catch(error => console.error('Error al actualizar datos:', error));
            }
            
            // Botón de actualización
            document.getElementById('refreshData').addEventListener('click', function() {
                const activeButton = document.querySelector('[data-period].active');
                const period = activeButton ? activeButton.getAttribute('data-period') : 'week';
                actualizarDatosPorPeriodo(period);
            });
        });
    </script>
@endpush