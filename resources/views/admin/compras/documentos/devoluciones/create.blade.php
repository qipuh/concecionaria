@extends('admin.layouts.app')

@section('title', 'Nuevo Vale de Devolución')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Nuevo Vale de Devolución</h5>
                    <a href="{{ route('admin.devoluciones.index') }}" class="btn btn-sm btn-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left me-1" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                        </svg>
                        Volver
                    </a>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Módulo en desarrollo:</strong> El formulario para crear vales de devolución está siendo implementado.
                    </div>

                    <form action="{{ route('admin.devoluciones.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="numero" class="form-label">Número de Vale</label>
                                    <input type="text" class="form-control" id="numero" name="numero" placeholder="Número automático" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="fecha" class="form-label">Fecha</label>
                                    <input type="date" class="form-control" id="fecha" name="fecha" value="{{ date('Y-m-d') }}" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="proveedor" class="form-label">Proveedor</label>
                                    <select class="form-control" id="proveedor" name="proveedor_id" disabled>
                                        <option value="">Seleccione un proveedor</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="motivo" class="form-label">Motivo de Devolución</label>
                                    <select class="form-control" id="motivo" name="motivo" disabled>
                                        <option value="">Seleccione el motivo</option>
                                        <option value="producto_defectuoso">Producto defectuoso</option>
                                        <option value="producto_incorrecto">Producto incorrecto</option>
                                        <option value="exceso_inventario">Exceso de inventario</option>
                                        <option value="otros">Otros</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="observaciones" class="form-label">Observaciones</label>
                                    <textarea class="form-control" id="observaciones" name="observaciones" rows="3" placeholder="Observaciones adicionales" disabled></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" disabled>Cancelar</button>
                            <button type="button" class="btn btn-primary" disabled>Guardar Vale</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection