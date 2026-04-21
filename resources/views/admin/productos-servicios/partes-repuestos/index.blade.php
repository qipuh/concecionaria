@extends('admin.layouts.app')

@section('title', 'Catálogo de Partes')

@section('content')
<div class="dashboard-hero" style="padding: 2rem 2rem; border-radius: 0 0 1.5rem 1.5rem; margin-bottom: 2.5rem;">
    <div class="hero-glow-alt" style="top: -50px; right: 0; filter: blur(60px); opacity: 0.2;"></div>
    <div class="container-fluid position-relative z-1">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center">
            <div class="mb-3 mb-lg-0">
                <div class="d-inline-flex align-items-center px-3 py-1 bg-white bg-opacity-10 rounded-pill fs-6 mb-3 border border-white border-opacity-25 backdrop-blur">
                    <i class="fas fa-cog text-info me-2"></i> Inventario de Partes
                </div>
                <h2 class="fw-bold mb-1 tracking-tight text-white display-6 text-shadow-sm d-flex align-items-center">
                    Catálogo de Partes
                </h2>
                <p class="text-white-50 mb-0">Total de registros: {{ $totalPartes }}</p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('admin.almacenes.partes.create') }}" class="btn bg-white text-dark rounded-pill px-4 py-2 fw-bold shadow-sm transition hover:scale-105 border-0">
                    <i class="fas fa-plus text-primary me-2"></i> Agregar Parte
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid px-3 px-lg-4 position-relative" style="top: -3.5rem; z-index: 10;">
    <div class="card dashboard-card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            @if (session('success'))
                <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="py-3 px-4 border-0 text-uppercase small">#</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Código</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Nombre</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Unidad</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Fabricante</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Proveedor</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Categoría</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Precio Venta</th>
                            <th class="py-3 px-4 border-0 text-uppercase small text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($partes as $index => $parte)
                            <tr>
                                <td class="px-4 py-3">{{ $partes->firstItem() + $index }}</td>
                                <td class="px-4 py-3 fw-bold text-primary">{{ $parte->codigo }}</td>
                                <td class="px-4 py-3">{{ $parte->nombre }}</td>
                                <td class="px-4 py-3">
                                    <span class="badge bg-light text-dark rounded-pill px-3">{{ $parte->unidad->nombre ?? 'N/A' }}</span>
                                </td>
                                <td class="px-4 py-3">{{ $parte->fabricante->nombre_fabricante ?? 'N/A' }}</td>
                                <td class="px-4 py-3">{{ $parte->proveedor ? $parte->proveedor->nombre_completo : 'N/A' }}</td>
                                <td class="px-4 py-3">
                                    <span class="badge bg-info bg-opacity-10 text-info rounded-pill px-3">{{ $parte->categoriaParte->nombre ?? 'N/A' }}</span>
                                </td>
                                <td class="px-4 py-3 fw-bold text-success">
                                    {{ number_format($parte->precio_venta, 2) }} {{ $parte->moneda_venta }}
                                </td>
                                <td class="px-4 py-3 text-end">
                                    <div class="btn-group shadow-sm rounded-pill overflow-hidden">
                                        <a href="{{ route('admin.almacenes.partes.edit', $parte) }}" class="btn btn-white btn-sm border-0 px-3 transition hover:bg-warning hover:text-white" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.almacenes.partes.destroy', $parte) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('¿Estás seguro de eliminar esta parte?')" class="btn btn-white btn-sm border-0 px-3 transition hover:bg-danger hover:text-white" title="Eliminar">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="py-5 text-center">
                                    <div class="bg-light d-inline-flex p-4 rounded-circle mb-3">
                                        <i class="fas fa-cog text-muted fa-3x"></i>
                                    </div>
                                    <h5 class="text-dark fw-bold">No hay partes registradas</h5>
                                    <p class="text-muted mb-0">Comienza agregando tu primera parte al catálogo</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4 d-flex justify-content-center">
                {{ $partes->links() }}
            </div>
        </div>
    </div>
</div>
@endsection