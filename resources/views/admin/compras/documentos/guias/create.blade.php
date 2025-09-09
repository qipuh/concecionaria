@extends('admin.layouts.app')

@section('title', 'Nueva Guía de Entrega')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Nueva Guía de Entrega</h5>
                    <a href="{{ route('admin.guias.index') }}" class="btn btn-sm btn-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left me-1" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                        </svg>
                        Volver
                    </a>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.guias.store') }}" method="POST" id="form-guia">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="numero" class="form-label">Número de Guía</label>
                                    <input type="text" class="form-control" id="numero" name="numero" placeholder="Se generará automáticamente" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="fecha" class="form-label">Fecha <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('fecha') is-invalid @enderror" 
                                           id="fecha" name="fecha" value="{{ old('fecha', date('Y-m-d')) }}" required>
                                    @error('fecha')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="proveedor_id" class="form-label">Proveedor <span class="text-danger">*</span></label>
                                    <select class="form-control @error('proveedor_id') is-invalid @enderror" 
                                            id="proveedor_id" name="proveedor_id" required>
                                        <option value="">Seleccione un proveedor</option>
                                        @foreach($proveedores as $proveedor)
                                            <option value="{{ $proveedor->id }}" {{ old('proveedor_id') == $proveedor->id ? 'selected' : '' }}>
                                                {{ $proveedor->razon_social }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('proveedor_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Información del transporte -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="transportista" class="form-label">Transportista</label>
                                    <input type="text" class="form-control @error('transportista') is-invalid @enderror" 
                                           id="transportista" name="transportista" value="{{ old('transportista') }}"
                                           placeholder="Nombre de la empresa transportista">
                                    @error('transportista')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="placa_vehiculo" class="form-label">Placa del Vehículo</label>
                                    <input type="text" class="form-control @error('placa_vehiculo') is-invalid @enderror" 
                                           id="placa_vehiculo" name="placa_vehiculo" value="{{ old('placa_vehiculo') }}"
                                           placeholder="ABC-123">
                                    @error('placa_vehiculo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="conductor" class="form-label">Conductor</label>
                                    <input type="text" class="form-control @error('conductor') is-invalid @enderror" 
                                           id="conductor" name="conductor" value="{{ old('conductor') }}"
                                           placeholder="Nombre completo del conductor">
                                    @error('conductor')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="dni_conductor" class="form-label">DNI del Conductor</label>
                                    <input type="text" class="form-control @error('dni_conductor') is-invalid @enderror" 
                                           id="dni_conductor" name="dni_conductor" value="{{ old('dni_conductor') }}"
                                           placeholder="12345678">
                                    @error('dni_conductor')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="observaciones" class="form-label">Observaciones</label>
                                    <textarea class="form-control @error('observaciones') is-invalid @enderror" 
                                              id="observaciones" name="observaciones" rows="3" 
                                              placeholder="Observaciones adicionales...">{{ old('observaciones') }}</textarea>
                                    @error('observaciones')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Sección de productos -->
                        <div class="row">
                            <div class="col-md-12">
                                <h6 class="border-bottom pb-2 mb-3">Productos a Entregar</h6>
                                <div id="productos-container">
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Agregue productos utilizando el botón "Agregar Producto" debajo.
                                    </div>
                                </div>
                                <button type="button" class="btn btn-outline-primary btn-sm" id="agregar-producto">
                                    <i class="fas fa-plus me-1"></i>
                                    Agregar Producto
                                </button>
                            </div>
                        </div>

                        <div class="text-end mt-4">
                            <a href="{{ route('admin.guias.index') }}" class="btn btn-secondary me-2">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Guardar Guía</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
let productoIndex = 0;

document.getElementById('agregar-producto').addEventListener('click', function() {
    agregarProducto();
});

function agregarProducto() {
    const container = document.getElementById('productos-container');
    const alertInfo = container.querySelector('.alert-info');
    if (alertInfo) {
        alertInfo.remove();
    }

    const productoHtml = `
        <div class="card mb-3 producto-item">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="mb-0">Producto ${productoIndex + 1}</h6>
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="eliminarProducto(this)">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label class="form-label">Tipo</label>
                            <select class="form-control" name="productos[${productoIndex}][tipo]" required>
                                <option value="">Seleccionar...</option>
                                <option value="parte">Parte</option>
                                <option value="vehiculo">Vehículo</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label class="form-label">ID Producto</label>
                            <input type="number" class="form-control" name="productos[${productoIndex}][id]" placeholder="ID" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group mb-3">
                            <label class="form-label">Cantidad</label>
                            <input type="number" step="0.01" min="0.01" class="form-control" name="productos[${productoIndex}][cantidad]" placeholder="0.00" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group mb-3">
                            <label class="form-label">Precio</label>
                            <input type="number" step="0.01" min="0" class="form-control" name="productos[${productoIndex}][precio]" placeholder="0.00" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group mb-3">
                            <label class="form-label">Subtotal</label>
                            <input type="text" class="form-control subtotal" readonly placeholder="0.00">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', productoHtml);
    
    // Agregar event listeners para cálculo automático
    const lastProduct = container.lastElementChild;
    const cantidadInput = lastProduct.querySelector('input[name*="[cantidad]"]');
    const precioInput = lastProduct.querySelector('input[name*="[precio]"]');
    const subtotalInput = lastProduct.querySelector('.subtotal');
    
    [cantidadInput, precioInput].forEach(input => {
        input.addEventListener('input', function() {
            calcularSubtotal(cantidadInput, precioInput, subtotalInput);
        });
    });
    
    productoIndex++;
}

function eliminarProducto(button) {
    const productoItem = button.closest('.producto-item');
    productoItem.remove();
    
    // Si no quedan productos, mostrar el mensaje informativo
    const container = document.getElementById('productos-container');
    if (container.children.length === 0) {
        container.innerHTML = `
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>
                Agregue productos utilizando el botón "Agregar Producto" debajo.
            </div>
        `;
    }
}

function calcularSubtotal(cantidadInput, precioInput, subtotalInput) {
    const cantidad = parseFloat(cantidadInput.value) || 0;
    const precio = parseFloat(precioInput.value) || 0;
    const subtotal = cantidad * precio;
    subtotalInput.value = subtotal.toFixed(2);
}

// Validación del formulario
document.getElementById('form-guia').addEventListener('submit', function(e) {
    const productosContainer = document.getElementById('productos-container');
    const productos = productosContainer.querySelectorAll('.producto-item');
    
    if (productos.length === 0) {
        e.preventDefault();
        alert('Debe agregar al menos un producto para crear la guía de entrega.');
        return false;
    }
});
</script>
@endpush

@endsection