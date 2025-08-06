<!-- resources/views/admin/ventas/clientes/partials/table.blade.php -->
<div class="table-responsive">
    <table class="table table-hover align-middle" :class="darkMode ? 'table-dark' : ''">
        <thead class="table-light" :class="darkMode ? 'table-dark' : ''">
            <tr>
                <th scope="col" class="text-uppercase small">#</th>
                <th scope="col" class="text-uppercase small">Documento</th>
                <th scope="col" class="text-uppercase small">Nombre / Razón Social</th>
                <th scope="col" class="text-uppercase small">Tipo</th>
                <th scope="col" class="text-uppercase small">Categoría</th>
                <th scope="col" class="text-uppercase small">Canal</th>
                <th scope="col" class="text-uppercase small text-end">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($clientes as $index => $cliente)
                <tr>
                    <td>{{ $clientes->firstItem() + $index }}</td>
                    <td>{{ $cliente->documento_identidad }}</td>
                    <td class="fw-medium">
                        @if ($cliente->tipo_cliente == 'natural')
                            {{ $cliente->nombres }} {{ $cliente->apellido_paterno }} {{ $cliente->apellido_materno }}
                        @else
                            {{ $cliente->razon_social ?? $cliente->documento_identidad }}
                        @endif
                    </td>
                    <td>
                        <span class="badge {{ $cliente->tipo_cliente == 'natural' ? 'bg-success' : 'bg-primary' }} rounded-pill small">
                            {{ ucfirst($cliente->tipo_cliente) }}
                        </span>
                    </td>
                    <td>{{ $cliente->categoria->nombre }}</td>
                    <td>{{ $cliente->canalCaptacion->nombre }}</td>
                    <td class="text-end">
                        <div class="btn-group btn-group-sm">
                            <!--a href="{{ route('admin.clientes.show', $cliente) }}" class="btn btn-outline-primary" title="Ver detalles">
                                <svg xmlns="http://www.w3.org/2000/svg" style="height: 1rem; width: 1rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a-->
                            <a href="{{ route('admin.clientes.edit', $cliente) }}" class="btn btn-outline-warning" title="Editar">
                                <svg xmlns="http://www.w3.org/2000/svg" style="height: 1rem; width: 1rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <form action="{{ route('admin.clientes.destroy', $cliente) }}" method="POST" class="d-inline">
                                @csrf 
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('¿Estás seguro de eliminar este cliente?')" class="btn btn-outline-danger" title="Eliminar">
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
                    <td colspan="7" class="py-5 text-center">
                        <div class="d-flex flex-column align-items-center justify-content-center">
                            <svg xmlns="http://www.w3.org/2000/svg" style="height: 3rem; width: 3rem;" class="text-muted mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-muted mb-2">No hay clientes que coincidan con los filtros</p>
                            <a href="{{ route('admin.clientes.create') }}" class="btn btn-sm btn-link text-decoration-none">
                                Agregar un nuevo cliente
                            </a>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>