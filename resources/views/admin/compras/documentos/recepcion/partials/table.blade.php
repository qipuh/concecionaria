<div class="table-responsive">
    @if($ordenes->count() > 0)
    <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
            <tr>
                <th class="py-3 px-4 border-0 text-uppercase small">Orden</th>
                <th class="py-3 px-4 border-0 text-uppercase small">Proveedor</th>
                <th class="py-3 px-4 border-0 text-uppercase small">Fecha</th>
                <th class="py-3 px-4 border-0 text-uppercase small text-center">Estado</th>
                <th class="py-3 px-4 border-0 text-uppercase small text-center">Items</th>
                <th class="py-3 px-4 border-0 text-uppercase small text-center">Recibidos</th>
                <th class="py-3 px-4 border-0 text-uppercase small">Progreso</th>
                @if($mostrarAcciones)
                <th class="py-3 px-4 border-0 text-uppercase small text-end">Acciones</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($ordenes as $orden)
            @php
                $estado = $orden->estado_recepcion ?? 'pendiente';
                $totalItems = $orden->detalles->sum('cantidad_en_compra');
                $recibidos  = $orden->detalles->sum('cantidad_recibida');
                $porcentaje = $totalItems > 0 ? round(($recibidos / $totalItems) * 100, 1) : 0;
                $progressColor = $porcentaje == 100 ? 'success' : ($porcentaje > 0 ? 'warning' : 'secondary');
                $badgeMap = ['completo' => 'success', 'completo_con_faltantes' => 'warning', 'parcial' => 'info', 'pendiente' => 'secondary'];
                $badgeColor = $badgeMap[$estado] ?? 'secondary';
                $searchText = strtolower($orden->codigo . ' ' . ($orden->proveedor->nombre_completo ?? $orden->proveedor->razon_social ?? ''));
            @endphp
            <tr class="orden-row" data-search="{{ $searchText }}">
                <td class="px-4 py-3">
                    <div class="fw-bold text-primary">#{{ $orden->codigo }}</div>
                    <small class="text-muted">ID: {{ $orden->id }}</small>
                </td>
                <td class="px-4 py-3">
                    <div class="d-flex align-items-center gap-2">
                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                             style="width:36px;height:36px;">
                            <i class="fas fa-building text-muted small"></i>
                        </div>
                        <span class="fw-medium">{{ $orden->proveedor->nombre_completo ?? $orden->proveedor->razon_social ?? 'Sin proveedor' }}</span>
                    </div>
                </td>
                <td class="px-4 py-3">
                    <div class="fw-medium">{{ $orden->created_at->format('d/m/Y') }}</div>
                    <small class="text-muted">{{ $orden->created_at->diffForHumans() }}</small>
                </td>
                <td class="px-4 py-3 text-center">
                    <span class="badge bg-{{ $badgeColor }}-subtle text-{{ $badgeColor }} rounded-pill px-3 py-2 small fw-bold text-uppercase">
                        @if($estado === 'completo_con_faltantes') C/Faltantes
                        @else {{ $estado }}
                        @endif
                    </span>
                </td>
                <td class="px-4 py-3 text-center">
                    <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-1 fw-bold">{{ $totalItems }}</span>
                </td>
                <td class="px-4 py-3 text-center">
                    <span class="badge bg-success-subtle text-success rounded-pill px-3 py-1 fw-bold">{{ $recibidos }}</span>
                </td>
                <td class="px-4 py-3" style="min-width:160px;">
                    <div class="d-flex align-items-center gap-2">
                        <div class="progress flex-grow-1 rounded-pill" style="height:8px;">
                            <div class="progress-bar bg-{{ $progressColor }} rounded-pill"
                                 style="width:{{ $porcentaje }}%"></div>
                        </div>
                        <small class="fw-bold text-muted" style="min-width:36px;">{{ $porcentaje }}%</small>
                    </div>
                </td>
                @if($mostrarAcciones)
                <td class="px-4 py-3 text-end">
                    <div class="d-flex justify-content-end gap-2 flex-wrap">
                        @if(!in_array($estado, ['completo','completo_con_faltantes']))
                            <a href="{{ route('admin.recepcion.show', $orden->id) }}"
                               class="btn btn-primary btn-sm rounded-pill px-3 fw-bold border-0 shadow-sm">
                                <i class="fas fa-box-open me-1"></i> Recepcionar
                            </a>
                        @endif
                        @if($recibidos > 0)
                            <a href="{{ route('admin.recepcion.detalle', $orden->id) }}"
                               class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                                <i class="fas fa-eye me-1"></i> Detalle
                            </a>
                        @endif
                        @if($estado === 'completo')
                            <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">
                                <i class="fas fa-check me-1"></i> Completado
                            </span>
                        @elseif($estado === 'completo_con_faltantes')
                            <span class="badge bg-warning-subtle text-warning rounded-pill px-3 py-2">
                                <i class="fas fa-exclamation-triangle me-1"></i> C/Faltantes
                            </span>
                        @endif
                    </div>
                </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Mensaje cuando la búsqueda no tiene resultados --}}
    <div class="no-results-filter text-center py-5 d-none">
        <i class="fas fa-search text-muted fa-2x mb-3 d-block"></i>
        <p class="text-muted mb-0">No se encontraron órdenes que coincidan con la búsqueda.</p>
    </div>

    @else
    <div class="text-center py-5">
        <div class="bg-light d-inline-flex p-4 rounded-circle mb-3">
            <i class="fas fa-inbox text-muted fa-2x"></i>
        </div>
        <h5 class="text-dark fw-bold">No hay órdenes en esta categoría</h5>
        <p class="text-muted mb-0 small">Las órdenes aprobadas aparecerán aquí cuando estén listas para recibir.</p>
    </div>
    @endif
</div>
