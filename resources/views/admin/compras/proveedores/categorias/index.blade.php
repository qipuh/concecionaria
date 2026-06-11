@extends('admin.layouts.app')
@section('title', 'Categorías de Proveedor')

@section('content')
<div class="dashboard-hero" style="padding: 2rem 2rem; border-radius: 0 0 1.5rem 1.5rem; margin-bottom: 2.5rem;">
    <div class="hero-glow-alt" style="top: -50px; right: 0; filter: blur(60px); opacity: 0.2;"></div>
    <div class="container-fluid position-relative z-1">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center">
            <div class="mb-3 mb-lg-0">
                <div class="d-inline-flex align-items-center px-3 py-1 bg-white bg-opacity-10 rounded-pill fs-6 mb-3 border border-white border-opacity-25">
                    <i class="fas fa-tags text-info me-2"></i> Proveedores
                </div>
                <h2 class="fw-bold mb-1 tracking-tight text-white display-6 text-shadow-sm">
                    Categorías de Proveedor
                </h2>
                <p class="text-white-50 mb-0">{{ $categorias->total() }} categorías registradas</p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('admin.compras.proveedores.categorias.create') }}"
                   class="btn bg-white text-dark rounded-pill px-4 py-2 fw-bold shadow-sm border-0">
                    <i class="fas fa-plus text-primary me-2"></i> Nueva Categoría
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid px-3 px-lg-4 position-relative" style="top: -3.5rem; z-index: 10;">

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4 d-flex align-items-center gap-2">
            <i class="fas fa-check-circle text-success"></i> {{ session('success') }}
        </div>
    @endif

    <div class="card dashboard-card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 pt-4 pb-0 px-4 d-flex align-items-center justify-content-between">
            <h6 class="fw-bold mb-0"><i class="fas fa-list me-2 text-primary"></i> Listado de Categorías</h6>
            <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-1 small">
                {{ $categorias->total() }} registros
            </span>
        </div>
        <div class="card-body p-0">
            @if($categorias->count())
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="py-3 px-4 border-0 text-uppercase small">#</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Nombre de la Categoría</th>
                            <th class="py-3 px-4 border-0 text-uppercase small text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categorias as $categoria)
                        <tr>
                            <td class="px-4 py-3 text-muted small">{{ $categoria->id }}</td>
                            <td class="px-4 py-3 fw-semibold">{{ $categoria->nombre_categoria_proveedor }}</td>
                            <td class="px-4 py-3 text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <a href="{{ route('admin.compras.proveedores.categorias.edit', $categoria) }}"
                                       class="btn btn-sm btn-outline-warning rounded-pill px-3" title="Editar">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <form action="{{ route('admin.compras.proveedores.categorias.destroy', $categoria) }}"
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('¿Eliminar esta categoría?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-sm btn-outline-danger rounded-pill px-3" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($categorias->hasPages())
            <div class="px-4 py-3 border-top bg-light">
                {{ $categorias->links() }}
            </div>
            @endif
            @else
            <div class="text-center py-5">
                <div class="bg-light d-inline-flex p-4 rounded-circle mb-3">
                    <i class="fas fa-tags text-muted fa-2x"></i>
                </div>
                <h5 class="text-dark fw-bold">Sin categorías registradas</h5>
                <p class="text-muted mb-3">Crea la primera categoría de proveedor.</p>
                <a href="{{ route('admin.compras.proveedores.categorias.create') }}"
                   class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow-sm border-0">
                    <i class="fas fa-plus me-2"></i> Nueva Categoría
                </a>
            </div>
            @endif
        </div>
    </div>

</div>
@endsection
