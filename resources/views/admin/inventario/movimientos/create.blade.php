@extends('admin.layouts.app')

@section('content')
<div class="dashboard-hero" style="padding: 2rem 2rem; border-radius: 0 0 1.5rem 1.5rem; margin-bottom: 2.5rem;">
    <div class="hero-glow-alt" style="top: -50px; right: 0; filter: blur(60px); opacity: 0.2;"></div>
    <div class="container-fluid position-relative z-1">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center">
            <div class="mb-3 mb-lg-0">
                <div class="d-inline-flex align-items-center px-3 py-1 bg-white bg-opacity-10 rounded-pill fs-6 mb-3 border border-white border-opacity-25">
                    <i class="fas fa-boxes text-info me-2"></i> Inventario
                </div>
                <h2 class="fw-bold mb-1 tracking-tight text-white display-6 text-shadow-sm">Nuevo Movimiento</h2>
                <p class="text-white-50 mb-0">Registra un movimiento de almacén</p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('admin.inventario.movimientos.index') }}" class="btn bg-white text-dark rounded-pill px-4 py-2 fw-bold shadow-sm border-0">
                    <i class="fas fa-arrow-left me-2"></i> Volver
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid px-3 px-lg-4 position-relative" style="top: -3.5rem; z-index: 10;">
    <div class="card dashboard-card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
            <h6 class="fw-bold mb-0"><i class="fas fa-plus-circle me-2 text-primary"></i> Datos del Movimiento</h6>
        </div>
        <div class="card-body p-4">
            <form action="{{ isset($movimiento) ? route('admin.inventario.movimientos.update', $movimiento) : route('admin.inventario.movimientos.store') }}" method="POST">
                @csrf
                @if(isset($movimiento))
                    @method('PUT')
                @endif

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="tipo_movimiento_id" class="form-label fw-semibold small text-uppercase text-muted">Tipo de Movimiento</label>
                        <select class="form-select" id="tipo_movimiento_id" name="tipo_movimiento_id" required>
                            <option value="">Seleccione...</option>
                            @foreach($tiposMovimiento as $tipo)
                            <option value="{{ $tipo->id }}" {{ (isset($movimiento) && $movimiento->tipo_movimiento_id == $tipo->id) ? 'selected' : '' }}>
                                {{ $tipo->nombre }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="parte_id" class="form-label fw-semibold small text-uppercase text-muted">Parte/Producto</label>
                        <select class="form-select" id="parte_id" name="parte_id" required>
                            <option value="">Seleccione...</option>
                            @foreach($partes as $parte)
                            <option value="{{ $parte->id }}" {{ (isset($movimiento) && $movimiento->parte_id == $parte->id) ? 'selected' : '' }}>
                                {{ $parte->codigo }} - {{ $parte->nombre }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="almacen_id" class="form-label fw-semibold small text-uppercase text-muted">Almacén</label>
                        <select class="form-select" id="almacen_id" name="almacen_id" required>
                            <option value="">Seleccione...</option>
                            @foreach($almacenes as $almacen)
                            <option value="{{ $almacen->id }}" {{ (isset($movimiento) && $movimiento->almacen_id == $almacen->id) ? 'selected' : '' }}>
                                {{ $almacen->nombre }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="centro_costo_id" class="form-label fw-semibold small text-uppercase text-muted">Centro de Costo</label>
                        <select class="form-select" id="centro_costo_id" name="centro_costo_id" required>
                            <option value="">Seleccione...</option>
                            @foreach($centrosCostos as $centro)
                            <option value="{{ $centro->id }}" {{ (isset($movimiento) && $movimiento->centro_costo_id == $centro->id) ? 'selected' : '' }}>
                                {{ $centro->codigo }} - {{ $centro->nombre }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="cantidad" class="form-label fw-semibold small text-uppercase text-muted">Cantidad</label>
                        <input type="number" class="form-control" id="cantidad" name="cantidad"
                               value="{{ $movimiento->cantidad ?? old('cantidad') }}" min="1" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="documento_referencia" class="form-label fw-semibold small text-uppercase text-muted">Documento Referencia</label>
                        <input type="text" class="form-control" id="documento_referencia" name="documento_referencia"
                               value="{{ $movimiento->documento_referencia ?? old('documento_referencia') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="fecha_movimiento" class="form-label fw-semibold small text-uppercase text-muted">Fecha Movimiento</label>
                        <input type="datetime-local" class="form-control" id="fecha_movimiento" name="fecha_movimiento"
                               value="{{ isset($movimiento) ? $movimiento->fecha_movimiento->format('Y-m-d\TH:i') : old('fecha_movimiento', now()->format('Y-m-d\TH:i')) }}" required>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="observaciones" class="form-label fw-semibold small text-uppercase text-muted">Observaciones</label>
                        <textarea class="form-control" id="observaciones" name="observaciones" rows="3">{{ $movimiento->observaciones ?? old('observaciones') }}</textarea>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.inventario.movimientos.index') }}" class="btn btn-outline-secondary rounded-pill px-4 py-2 fw-bold border-0">Cancelar</a>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow-sm border-0">
                        <i class="fas fa-save me-2"></i> {{ isset($movimiento) ? 'Actualizar' : 'Guardar' }} Movimiento
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
