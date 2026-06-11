<div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
            <tr>
                <th class="py-3 px-4 border-0 text-uppercase small">#</th>
                <th class="py-3 px-4 border-0 text-uppercase small">Tipo Doc.</th>
                <th class="py-3 px-4 border-0 text-uppercase small">Nro. Doc.</th>
                <th class="py-3 px-4 border-0 text-uppercase small">Proveedor</th>
                <th class="py-3 px-4 border-0 text-uppercase small">Categoría</th>
                <th class="py-3 px-4 border-0 text-uppercase small">Correos</th>
                <th class="py-3 px-4 border-0 text-uppercase small">Contactos</th>
                <th class="py-3 px-4 border-0 text-uppercase small">Cuentas</th>
                <th class="py-3 px-4 border-0 text-uppercase small text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($proveedores as $index => $proveedor)
            <tr>
                <td class="px-4 py-3 text-muted small">{{ $proveedores->firstItem() + $index }}</td>
                <td class="px-4 py-3">
                    <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3 small fw-semibold">
                        {{ $proveedor->tipo_documento }}
                    </span>
                </td>
                <td class="px-4 py-3 font-monospace small fw-semibold">{{ $proveedor->numero_documento }}</td>
                <td class="px-4 py-3 fw-semibold small">
                    @if ($proveedor->tipo_documento == 'DNI')
                        {{ $proveedor->apellido_paterno }} {{ $proveedor->apellido_materno }}, {{ $proveedor->nombres }}
                    @else
                        {{ $proveedor->razon_social }}
                    @endif
                </td>
                <td class="px-4 py-3">
                    <span class="badge bg-primary-subtle text-primary rounded-pill px-3 small">
                        {{ $proveedor->categoriaProveedor->nombre_categoria_proveedor }}
                    </span>
                </td>
                <td class="px-4 py-3">
                    <div class="d-flex flex-wrap gap-1">
                        @foreach ($proveedor->correos as $correo)
                            <span class="badge bg-info-subtle text-info rounded-pill px-2 small">
                                <i class="fas fa-envelope me-1" style="font-size:.65rem;"></i>{{ $correo->correo }}
                            </span>
                        @endforeach
                    </div>
                </td>
                <td class="px-4 py-3">
                    <div class="d-flex flex-wrap gap-1">
                        @foreach ($proveedor->contactos as $contacto)
                            <span class="badge bg-secondary-subtle text-secondary rounded-pill px-2 small">
                                {{ $contacto->nombre }}
                            </span>
                        @endforeach
                    </div>
                </td>
                <td class="px-4 py-3">
                    <div class="d-flex flex-wrap gap-1">
                        @foreach ($proveedor->cuentas as $cuenta)
                            <span class="badge bg-success-subtle text-success rounded-pill px-2 small">
                                {{ $cuenta->banco->nombre }}
                            </span>
                        @endforeach
                        @if($proveedor->cuentas->isEmpty())
                            <span class="text-muted small">—</span>
                        @endif
                    </div>
                </td>
                <td class="px-4 py-3 text-center">
                    <div class="d-flex gap-1 justify-content-center">
                        <button type="button"
                                class="btn btn-sm btn-outline-primary rounded-pill px-3"
                                data-bs-toggle="modal"
                                data-bs-target="#cuentaModal{{ $proveedor->id }}"
                                title="Gestionar Cuentas">
                            <i class="fas fa-university"></i>
                        </button>
                        <a href="{{ route('admin.compras.proveedores.edit', $proveedor) }}"
                           class="btn btn-sm btn-outline-warning rounded-pill px-3"
                           title="Editar">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <form action="{{ route('admin.compras.proveedores.destroy', $proveedor) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    onclick="return confirm('¿Eliminar este proveedor?')"
                                    class="btn btn-sm btn-outline-danger rounded-pill px-3"
                                    title="Eliminar">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="text-center py-5">
                    <div class="bg-light d-inline-flex p-4 rounded-circle mb-3">
                        <i class="fas fa-truck text-muted fa-2x"></i>
                    </div>
                    <h5 class="text-dark fw-bold">No hay proveedores registrados</h5>
                    <p class="text-muted mb-3">Agrega el primer proveedor para comenzar.</p>
                    <a href="{{ route('admin.compras.proveedores.create') }}"
                       class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow-sm border-0">
                        <i class="fas fa-plus me-2"></i> Agregar Proveedor
                    </a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
