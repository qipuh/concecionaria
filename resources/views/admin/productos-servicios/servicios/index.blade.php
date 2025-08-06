@extends('admin.layouts.app')

@section('title', 'Servicios Tercerizados')

@section('header', 'Registro de Servicios Tercerizados')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center mb-4">
                    <div class="mb-3 mb-sm-0">
                        <h2 class="h4 fw-bold mb-1" :class="darkMode ? 'text-light' : 'text-dark'">
                            Total de Servicios: {{ $totalServicios }}
                        </h2>
                        <p class="text-muted small mb-0">Gestiona los servicios tercerizados desde aquí</p>
                    </div>
                    <div>
                        <a href="{{ route('admin.productos-servicios.servicios.create') }}" class="btn btn-primary d-flex align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="me-2" style="height: 1rem; width: 1rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Agregar Servicio
                        </a>
                    </div>
                </div>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover align-middle" :class="darkMode ? 'table-dark' : ''">
                        <thead class="table-light" :class="darkMode ? 'table-dark' : ''">
                            <tr>
                                <th scope="col" class="text-uppercase small">#</th>
                                <th scope="col" class="text-uppercase small">Nombre</th>
                                <th scope="col" class="text-uppercase small">Categoría</th>
                                <th scope="col" class="text-uppercase small">Precio</th>
                                <th scope="col" class="text-uppercase small text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($servicios as $index => $servicio)
                                <tr>
                                    <td>{{ $servicios->firstItem() + $index }}</td>
                                    <td>{{ $servicio->nombre }}</td>
                                    <td>{{ $servicio->categoria->nombre ?? 'Sin categoría' }}</td>
                                    <td>{{ number_format($servicio->precio, 2) }} {{ $servicio->moneda }}</td>
                                    <td class="text-end">
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.productos-servicios.servicios.edit', $servicio) }}" class="btn btn-outline-warning" title="Editar">
                                                <!-- ícono editar -->
                                            </a>
                                            <form action="{{ route('admin.productos-servicios.servicios.destroy', $servicio) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('¿Estás seguro de eliminar este servicio?')" class="btn btn-outline-danger" title="Eliminar">
                                                    <!-- ícono eliminar -->
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-5 text-center">
                                        <div class="d-flex flex-column align-items-center justify-content-center">
                                            <!-- ícono vacío -->
                                            <p class="text-muted mb-2">No hay servicios tercerizados registrados</p>
                                            <a href="{{ route('admin.productos-servicios.servicios.create') }}" class="btn btn-sm btn-link text-decoration-none">
                                                Agregar un nuevo servicio
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $servicios->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection