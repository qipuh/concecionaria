@extends('admin.layouts.app')

@section('title', 'Categorías de Proveedor')
@section('header', 'Listado de Categorías de Proveedor')

@section('content')
<div class="row">
    <div class="col-12">
        <!-- Panel principal -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="h4 fw-bold mb-0">Categorías de Proveedor</h2>
                <a href="{{ route('admin.compras.proveedores.categorias.create') }}" class="btn btn-primary btn-sm">
                    Nueva Categoría
                </a>
            </div>
            <div class="card-body p-4">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if($categorias->count())
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Nombre de la Categoría</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categorias as $categoria)
                                    <tr>
                                        <td>{{ $categoria->id }}</td>
                                        <td>{{ $categoria->nombre_categoria_proveedor }}</td>
                                        <td>
                                            <a href="{{ route('admin.compras.proveedores.categorias.edit', $categoria) }}" class="btn btn-outline-secondary btn-sm">
                                                Editar
                                            </a>
                                            <form action="{{ route('admin.compras.proveedores.categorias.destroy', $categoria) }}" method="POST" class="d-inline-block" onsubmit="return confirm('¿Está seguro de eliminar esta categoría?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                                    Eliminar
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $categorias->links() }}
                @else
                    <p class="text-center">No se encontraron categorías de proveedor.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
