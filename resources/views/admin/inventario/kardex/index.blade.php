@extends('admin.layouts.app')
@section('title', 'Kardex')
@section('header', 'Kardex')
@section('content')
<div class="dashboard-hero" style="padding: 2rem 2rem; border-radius: 0 0 1.5rem 1.5rem; margin-bottom: 2.5rem;">
    <div class="hero-glow-alt" style="top: -50px; right: 0; filter: blur(60px); opacity: 0.2;"></div>
    <div class="container-fluid position-relative z-1">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center">
            <div class="mb-3 mb-lg-0">
                <div class="d-inline-flex align-items-center px-3 py-1 bg-white bg-opacity-10 rounded-pill fs-6 mb-3 border border-white border-opacity-25">
                    <i class="fas fa-boxes text-info me-2"></i> Inventario
                </div>
                <h2 class="fw-bold mb-1 tracking-tight text-white display-6 text-shadow-sm">Generar Reporte Kardex</h2>
                <p class="text-white-50 mb-0">Consulta el historial de movimientos de inventario</p>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid px-3 px-lg-4 position-relative" style="top: -3.5rem; z-index: 10;">
    <div class="card dashboard-card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
            <h6 class="fw-bold mb-0"><i class="fas fa-chart-line me-2 text-primary"></i> Parámetros del Reporte</h6>
        </div>
        <div class="card-body p-4">
            <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="partes-tab" data-bs-toggle="tab" data-bs-target="#partes" type="button" role="tab" aria-controls="partes" aria-selected="true">Partes</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="vehiculos-tab" data-bs-toggle="tab" data-bs-target="#vehiculos" type="button" role="tab" aria-controls="vehiculos" aria-selected="false">Vehículos</button>
                </li>
            </ul>

            <div class="tab-content" id="myTabContent">
                <!-- Tab de Partes -->
                <div class="tab-pane fade show active" id="partes" role="tabpanel" aria-labelledby="partes-tab">
                    <form action="{{ route('admin.inventario.kardex.reporte') }}" method="GET">
                        <input type="hidden" name="tipo_reporte" value="parte">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-6">
                                <label for="parte_id" class="form-label fw-semibold small text-uppercase text-muted">Producto/Parte:</label>
                                <select name="parte_id" id="parte_id" class="form-select select2" required>
                                    <option value="">Seleccione un producto</option>
                                    @foreach($partes as $parte)
                                    <option value="{{ $parte->id }}">{{ $parte->codigo }} - {{ $parte->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="almacen_id" class="form-label fw-semibold small text-uppercase text-muted">Almacén (opcional):</label>
                                <select name="almacen_id" id="almacen_id" class="form-select select2">
                                    <option value="">Todos los almacenes</option>
                                    @foreach($almacenes as $almacen)
                                    <option value="{{ $almacen->id }}">{{ $almacen->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="fecha_inicio" class="form-label fw-semibold small text-uppercase text-muted">Fecha Inicio:</label>
                                <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label for="fecha_fin" class="form-label fw-semibold small text-uppercase text-muted">Fecha Fin:</label>
                                <input type="date" name="fecha_fin" id="fecha_fin" class="form-control">
                            </div>

                            <div class="col-12 text-center mt-3">
                                <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow-sm border-0">
                                    <i class="fas fa-chart-bar me-2"></i> Generar Reporte
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Tab de Vehículos -->
                <div class="tab-pane fade" id="vehiculos" role="tabpanel" aria-labelledby="vehiculos-tab">
                    <form action="{{ route('admin.inventario.kardex.reporte') }}" method="GET">
                        <input type="hidden" name="tipo_reporte" value="vehiculo">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-6">
                                <label for="vehiculo_id" class="form-label fw-semibold small text-uppercase text-muted">Vehículo:</label>
                                <select name="vehiculo_id" id="vehiculo_id" class="form-select select2" required>
                                    <option value="">Seleccione un vehículo</option>
                                    @foreach($vehiculos as $vehiculo)
                                    <option value="{{ $vehiculo->id }}">
                                        {{ $vehiculo->marca->nombre ?? 'N/A' }} -
                                        {{ $vehiculo->modelo->nombre ?? 'N/A' }} -
                                        {{ $vehiculo->version->nombre ?? 'N/A' }} -
                                        {{ $vehiculo->anioModelo->nombre ?? 'N/A' }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="almacen_id_vehiculo" class="form-label fw-semibold small text-uppercase text-muted">Almacén (opcional):</label>
                                <select name="almacen_id" id="almacen_id_vehiculo" class="form-select select2">
                                    <option value="">Todos los almacenes</option>
                                    @foreach($almacenes as $almacen)
                                    <option value="{{ $almacen->id }}">{{ $almacen->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="fecha_inicio_vehiculo" class="form-label fw-semibold small text-uppercase text-muted">Fecha Inicio:</label>
                                <input type="date" name="fecha_inicio" id="fecha_inicio_vehiculo" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label for="fecha_fin_vehiculo" class="form-label fw-semibold small text-uppercase text-muted">Fecha Fin:</label>
                                <input type="date" name="fecha_fin" id="fecha_fin_vehiculo" class="form-control">
                            </div>

                            <div class="col-12 text-center mt-3">
                                <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow-sm border-0">
                                    <i class="fas fa-chart-bar me-2"></i> Generar Reporte
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Seleccione una opción",
            allowClear: true
        });

        $('#myTab button').on('shown.bs.tab', function (e) {
            var target = $(e.target).attr("id");
            if (target === 'vehiculos-tab') {
                $('input[name="tipo_reporte"]').val('vehiculo');
            } else {
                $('input[name="tipo_reporte"]').val('parte');
            }
        });
    });
</script>
@endpush
