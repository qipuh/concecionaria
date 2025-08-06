<div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center mb-4">
    <div class="mb-3 mb-sm-0">
        <h2 class="h4 fw-bold mb-1" :class="darkMode ? 'text-light' : 'text-dark'">
            Total de Versiones: {{ $versiones->total() }}
        </h2>
        <p class="text-muted small mb-0">Gestiona las versiones de vehículos desde aquí</p>
    </div>
    <div>
        <a href="{{ route('admin.productos-servicios.vehiculos.caracteristicas.versiones.create') }}" class="btn btn-primary d-flex align-items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="me-2" style="height: 1rem; width: 1rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Agregar Versión
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
                <th scope="col" class="text-uppercase small">Marca</th>
                <th scope="col" class="text-uppercase small">Modelo</th>
                <th scope="col" class="text-uppercase small">Versión</th>
                <th scope="col" class="text-uppercase small">Carrocería</th>
                <th scope="col" class="text-uppercase small">Cilindrada</th>
                <th scope="col" class="text-uppercase small">Transmisión</th>
                <th scope="col" class="text-uppercase small">Tracción</th>
                <th scope="col" class="text-uppercase small">Combustible</th>
                <th scope="col" class="text-uppercase small text-end">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($versiones as $index => $version)
                <tr>
                    <td>{{ $versiones->firstItem() + $index }}</td>
                    <td>{{ $version->marca->nombre }}</td>
                    <td>{{ $version->modelo->nombre }}</td>
                    <td>{{ $version->nombre }}</td>
                    <td>{{ $version->carroceria }}</td>
                    <td>{{ $version->cilindrada }}</td>
                    <td>{{ $version->transmision }}</td>
                    <td>{{ $version->traccion }}</td>
                    <td>{{ $version->combustible->nombre }}</td>
                    <td class="text-end">
                        <div class="btn-group btn-group-sm">
                            <a href="{{ route('admin.productos-servicios.vehiculos.caracteristicas.versiones.edit', $version) }}" class="btn btn-outline-warning" title="Editar">
                                <svg xmlns="http://www.w3.org/2000/svg" style="height: 1rem; width: 1rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <form action="{{ route('admin.productos-servicios.vehiculos.caracteristicas.versiones.destroy', $version) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('¿Estás seguro de eliminar esta versión?')" class="btn btn-outline-danger" title="Eliminar">
                                    <svg xmlns="http://www.w3.org/2000/svg" style="height: 1rem; width: 1rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="py-5 text-center">
                        <div class="d-flex flex-column align-items-center justify-content-center">
                            <svg xmlns="http://www.w3.org/2000/svg" style="height: 3rem; width: 3rem;" class="text-muted mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-muted mb-2">No hay versiones registradas</p>
                            <a href="{{ route('admin.productos-servicios.vehiculos.caracteristicas.versiones.create') }}" class="btn btn-sm btn-link text-decoration-none">
                                Agregar una nueva versión
                            </a>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $versiones->links() }}
</div>