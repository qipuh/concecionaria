@extends('admin.layouts.app')

@section('title', 'Devoluciones a Proveedores')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Devoluciones a Proveedores</h5>
                    <a href="{{ route('admin.inventario.devoluciones.create') }}" class="btn btn-sm btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                            <path d="M8 0a1 1 0 0 1 1 1v6h6a1 1 0 1 1 0 2H9v6a1 1 0 1 1-2 0V9H1a1 1 0 0 1 0-2h6V1a1 1 0 0 1 1-1z"/>
                        </svg>
                        Nueva Devolución
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Proveedor</th>
                                    <th>Fecha Emisión</th>
                                    <th>Motivo</th>
                                    <th>Almacén</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($devoluciones as $devolucion)
                                    <tr>
                                        <td>{{ $devolucion->codigo }}</td>
                                        <td>{{ $devolucion->proveedor->nombre_completo }}</td>
                                        <td>{{ $devolucion->fecha_emision->format('d/m/Y') }}</td>
                                        <td>{{ $devolucion->motivo }}</td>
                                        <td>{{ $devolucion->almacen->nombre }}</td>
                                        <td>
                                            @if($devolucion->estado == 'PENDIENTE')
                                                <span class="badge bg-warning">Pendiente</span>
                                            @elseif($devolucion->estado == 'PROCESADA')
                                                <span class="badge bg-success">Procesada</span>
                                            @else
                                                <span class="badge bg-secondary">{{ $devolucion->estado }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Acciones
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a href="{{ route('admin.inventario.devoluciones.show', $devolucion->id) }}" class="dropdown-item">
                                                            Ver Detalles
                                                        </a>
                                                    </li>
                                                    @if($devolucion->estado == 'PENDIENTE')
                                                        <li>
                                                            <a href="{{ route('admin.inventario.devoluciones.edit', $devolucion->id) }}" class="dropdown-item">
                                                                Editar
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <form action="{{ route('admin.inventario.devoluciones.confirmar', $devolucion->id) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('PUT')
                                                                <button type="submit" class="dropdown-item" onclick="return confirm('¿Estás seguro de confirmar esta devolución? Esta acción no se puede deshacer.')">
                                                                    Confirmar Devolución
                                                                </button>
                                                            </form>
                                                        </li>
                                                        <li>
                                                            <form action="{{ route('admin.inventario.devoluciones.destroy', $devolucion->id) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item text-danger" onclick="return confirm('¿Estás seguro de eliminar esta devolución?')">
                                                                    Eliminar
                                                                </button>
                                                            </form>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No hay devoluciones registradas</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-center mt-3">
                        {{ $devoluciones->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection