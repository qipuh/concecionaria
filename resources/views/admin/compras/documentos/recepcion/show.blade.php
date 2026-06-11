@extends('admin.layouts.app')
@section('title', 'Recepcionar Orden #' . $orden->codigo)

@section('content')
<div class="dashboard-hero" style="padding: 2rem 2rem; border-radius: 0 0 1.5rem 1.5rem; margin-bottom: 2.5rem;">
    <div class="hero-glow-alt" style="top: -50px; right: 0; filter: blur(60px); opacity: 0.2;"></div>
    <div class="container-fluid position-relative z-1">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center">
            <div class="mb-3 mb-lg-0">
                <div class="d-inline-flex align-items-center px-3 py-1 bg-white bg-opacity-10 rounded-pill fs-6 mb-3 border border-white border-opacity-25 backdrop-blur">
                    <i class="fas fa-truck-loading text-info me-2"></i> Recepción en Proceso
                </div>
                <h2 class="fw-bold mb-1 tracking-tight text-white display-6 text-shadow-sm">
                    Orden #{{ $orden->codigo }}
                </h2>
                @php
                    $estado = $orden->estado_recepcion ?? 'pendiente';
                    $badgeMap = ['completo' => 'success', 'completo_con_faltantes' => 'warning', 'parcial' => 'info', 'pendiente' => 'secondary'];
                    $badgeColor = $badgeMap[$estado] ?? 'secondary';
                @endphp
                <span class="badge rounded-pill bg-{{ $badgeColor }} px-3 py-2 fw-bold mt-1">
                    <i class="fas fa-circle me-1 small"></i>
                    @if($estado === 'completo_con_faltantes') COMPLETO CON FALTANTES
                    @else {{ strtoupper($estado) }}
                    @endif
                </span>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('admin.recepcion.index') }}" class="btn bg-white text-dark rounded-pill px-4 py-2 fw-bold shadow-sm border-0">
                    <i class="fas fa-arrow-left text-primary me-2"></i> Volver
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid px-3 px-lg-4 position-relative" style="top: -3.5rem; z-index: 10;"
     x-data="recepcionForm({{ $orden->detalles->toJson() }})">

    {{-- Info cards --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="card dashboard-card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3 p-3">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-circle flex-shrink-0">
                        <i class="fas fa-building text-primary"></i>
                    </div>
                    <div class="overflow-hidden">
                        <p class="text-muted mb-0 small">Proveedor</p>
                        <h6 class="mb-0 fw-bold text-truncate">{{ $orden->proveedor->nombre_completo ?? $orden->proveedor->razon_social ?? 'Sin proveedor' }}</h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card dashboard-card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3 p-3">
                    <div class="bg-info bg-opacity-10 p-3 rounded-circle flex-shrink-0">
                        <i class="fas fa-calendar text-info"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-0 small">Fecha orden</p>
                        <h6 class="mb-0 fw-bold">{{ $orden->created_at->format('d/m/Y') }}</h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card dashboard-card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3 p-3">
                    <div class="bg-success bg-opacity-10 p-3 rounded-circle flex-shrink-0">
                        <i class="fas fa-warehouse text-success"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-0 small">Almacén destino</p>
                        <h6 class="mb-0 fw-bold">{{ $orden->almacen->nombre ?? 'Sin almacén' }}</h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card dashboard-card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3 p-3">
                    <div class="bg-warning bg-opacity-10 p-3 rounded-circle flex-shrink-0">
                        <i class="fas fa-boxes text-warning"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-0 small">Total ítems</p>
                        <h6 class="mb-0 fw-bold">{{ $orden->detalles->sum('cantidad_en_compra') }}</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Alertas --}}
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Errores:</strong>
            <ul class="mb-0 mt-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Barra de resumen reactiva --}}
    <div class="card dashboard-card border-0 shadow-sm mb-3"
         x-show="totalARecibir > 0"
         x-transition>
        <div class="card-body py-3 px-4">
            <div class="d-flex flex-wrap align-items-center gap-3">
                <div class="d-flex align-items-center gap-2">
                    <i class="fas fa-box-open text-primary"></i>
                    <span class="fw-bold">Resumen de esta recepción:</span>
                </div>
                <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2">
                    <span x-text="totalARecibir"></span> ítems a ingresar
                </span>
                <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">
                    <span x-text="lineasCompletas"></span> líneas completadas
                </span>
                <span class="badge bg-warning-subtle text-warning rounded-pill px-3 py-2">
                    <span x-text="lineasParciales"></span> líneas parciales
                </span>
                <div class="flex-grow-1 d-none d-md-block">
                    <div class="progress rounded-pill" style="height:6px;">
                        <div class="progress-bar bg-primary rounded-pill" :style="'width:' + porcentajeRecibido + '%'"></div>
                    </div>
                </div>
                <small class="text-muted fw-semibold" x-text="porcentajeRecibido + '%'"></small>
            </div>
        </div>
    </div>

    {{-- Tabla de ítems --}}
    <div class="card dashboard-card border-0 shadow-sm mb-4">
        <form action="{{ route('admin.recepcion.store', $orden->id) }}" method="POST" id="recepcionForm">
            @csrf
            <input type="hidden" name="tipo_recepcion" id="tipoRecepcion" value="normal">

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="py-3 px-4 border-0 text-uppercase small">Producto</th>
                            <th class="py-3 px-4 border-0 text-uppercase small text-center">Pedida</th>
                            <th class="py-3 px-4 border-0 text-uppercase small text-center">Recibida</th>
                            <th class="py-3 px-4 border-0 text-uppercase small text-center">A recibir</th>
                            <th class="py-3 px-4 border-0 text-uppercase small text-center">Pendiente</th>
                            <th class="py-3 px-4 border-0 text-uppercase small text-center">Estado</th>
                            <th class="py-3 px-4 border-0 text-uppercase small">Observaciones</th>
                            <th class="py-3 px-4 border-0 text-uppercase small text-center">Devolver</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orden->detalles as $detalle)
                        @php
                            $completado = in_array($detalle->estado_recepcion, ['completo','completo_con_faltantes']);
                            $pendiente  = $detalle->cantidad_en_compra - ($detalle->cantidad_recibida ?? 0);
                            $estadoDet  = $detalle->estado_recepcion ?? 'pendiente';
                            $colorDet   = ['completo' => 'success', 'completo_con_faltantes' => 'warning', 'parcial' => 'info', 'pendiente' => 'secondary'][$estadoDet] ?? 'secondary';
                            $inicial    = strtoupper(substr($detalle->nombre_producto, 0, 1));
                        @endphp
                        <tr :class="getRowClass({{ $detalle->id }})">
                            <td class="px-4 py-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold flex-shrink-0"
                                         style="width:40px;height:40px;background:linear-gradient(135deg,#667eea,#764ba2);">
                                        {{ $inicial }}
                                    </div>
                                    <div>
                                        <div class="fw-bold small">{{ $detalle->nombre_producto }}</div>
                                        <div class="text-muted small"><i class="fas fa-barcode me-1"></i>{{ $detalle->codigo }}</div>
                                        <span class="badge bg-light text-dark rounded-pill small">{{ ucfirst($detalle->tipo_item) }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2 fw-bold">{{ $detalle->cantidad_en_compra }}</span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2 fw-bold">{{ $detalle->cantidad_recibida ?? 0 }}</span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if(!$completado)
                                <input type="number"
                                       name="recepciones[{{ $detalle->id }}][cantidad_recibida]"
                                       class="form-control form-control-sm text-center fw-bold rounded-3"
                                       style="width:90px;margin:auto;"
                                       min="0"
                                       max="{{ $pendiente }}"
                                       value="0"
                                       x-model.number="items[{{ $detalle->id }}].aRecibir"
                                       @input="actualizarItem({{ $detalle->id }}, {{ $detalle->cantidad_en_compra }}, {{ $detalle->cantidad_recibida ?? 0 }})">
                                @else
                                <span class="text-muted small">Completado</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="badge bg-warning-subtle text-warning rounded-pill px-3 py-2 fw-bold"
                                      x-text="items[{{ $detalle->id }}]?.pendiente ?? {{ $pendiente }}">
                                    {{ $pendiente }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="badge rounded-pill px-3 py-2 small fw-bold"
                                      :class="getEstadoBadge({{ $detalle->id }})">
                                    <span x-text="items[{{ $detalle->id }}]?.estadoLabel ?? '{{ $estadoDet }}'"></span>
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                @if(!$completado)
                                <textarea name="recepciones[{{ $detalle->id }}][observaciones]"
                                          class="form-control form-control-sm rounded-3"
                                          rows="2"
                                          placeholder="Notas..."></textarea>
                                @else
                                <span class="text-muted small">—</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if(($detalle->cantidad_recibida ?? 0) > 0)
                                <button type="button"
                                        class="btn btn-outline-danger btn-sm rounded-pill px-3"
                                        @click="abrirDevolucion({{ $detalle->id }}, '{{ addslashes($detalle->nombre_producto) }}', {{ $detalle->cantidad_recibida }})"
                                        title="Devolver ítems">
                                    <i class="fas fa-undo"></i>
                                </button>
                                @else
                                <span class="text-muted">—</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Footer del formulario --}}
            <div class="card-footer bg-white border-top p-4 rounded-bottom-4">
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="fecha_recepcion" class="form-label fw-bold small text-uppercase text-muted">
                            <i class="fas fa-calendar-alt me-1 text-primary"></i> Fecha de Recepción
                        </label>
                        <input type="date" name="fecha_recepcion" id="fecha_recepcion"
                               class="form-control rounded-3"
                               value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="observaciones_generales" class="form-label fw-bold small text-uppercase text-muted">
                            <i class="fas fa-sticky-note me-1 text-primary"></i> Observaciones Generales
                        </label>
                        <textarea name="observaciones_generales" id="observaciones_generales"
                                  class="form-control rounded-3" rows="2"
                                  placeholder="Comentarios sobre la recepción..."></textarea>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <a href="{{ route('admin.recepcion.index') }}"
                       class="btn btn-outline-secondary rounded-pill px-4 py-2 fw-bold border-0">
                        <i class="fas fa-arrow-left me-2"></i> Volver
                    </a>
                    <div class="d-flex gap-2 flex-wrap">
                        @if(!in_array($orden->estado_recepcion, ['completo','completo_con_faltantes']))
                        <button type="button"
                                class="btn btn-warning rounded-pill px-4 py-2 fw-bold shadow-sm border-0"
                                @click="modalFaltantes = true">
                            <i class="fas fa-exclamation-triangle me-2"></i> Completar con Faltantes
                        </button>
                        @endif
                        <button type="submit" id="btnSubmit"
                                class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow-sm border-0">
                            <i class="fas fa-save me-2"></i> Registrar Recepción
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- Modal: Completar con faltantes --}}
    <div class="modal fade" id="modalFaltantes" tabindex="-1" x-ref="modalFaltantes"
         :class="{ show: modalFaltantes }" :style="modalFaltantes ? 'display:block;' : 'display:none;'"
         @keydown.escape.window="modalFaltantes = false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">
                        <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                        Completar con Faltantes
                    </h5>
                    <button type="button" class="btn-close" @click="modalFaltantes = false"></button>
                </div>
                <form @submit.prevent="submitFaltantes">
                    <div class="modal-body pt-3">
                        <p class="text-muted small mb-3">
                            Esta acción marcará la orden como completa aunque algunos ítems no hayan sido recibidos.
                            <strong class="text-danger">No se puede deshacer.</strong>
                        </p>
                        <div>
                            <label class="form-label fw-bold small text-uppercase text-muted">Motivo de los faltantes</label>
                            <textarea x-model="motivoFaltantes" class="form-control rounded-3" rows="3"
                                      placeholder="Describe el motivo..." required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-outline-secondary rounded-pill px-4 border-0"
                                @click="modalFaltantes = false">Cancelar</button>
                        <button type="submit" class="btn btn-warning rounded-pill px-4 fw-bold border-0"
                                :disabled="!motivoFaltantes.trim()">
                            <i class="fas fa-check me-2"></i> Confirmar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade show" x-show="modalFaltantes" x-cloak style="z-index:1040;"></div>

    {{-- Modal: Devolución --}}
    <div class="modal fade" id="modalDevolucion" tabindex="-1"
         :class="{ show: modalDevolucion }" :style="modalDevolucion ? 'display:block;' : 'display:none;'"
         @keydown.escape.window="modalDevolucion = false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">
                        <i class="fas fa-undo text-danger me-2"></i> Devolver Ítems
                    </h5>
                    <button type="button" class="btn-close" @click="modalDevolucion = false"></button>
                </div>
                <form :action="'{{ route('admin.recepcion.devolver', $orden->id) }}'" method="POST">
                    @csrf
                    <div class="modal-body pt-3">
                        <input type="hidden" name="detalle_id" :value="devolucion.detalleId">

                        <div class="alert alert-light border rounded-3 mb-3 small">
                            <strong>Producto:</strong> <span x-text="devolucion.nombre"></span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-uppercase text-muted">Cantidad a devolver</label>
                            <input type="number" name="cantidad_devolver"
                                   class="form-control rounded-3"
                                   x-model="devolucion.cantidad"
                                   :max="devolucion.max" min="1" required>
                            <div class="form-text">Máximo: <span x-text="devolucion.max"></span> ítems recibidos.</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-uppercase text-muted">Motivo</label>
                            <textarea name="motivo" class="form-control rounded-3" rows="3"
                                      placeholder="Describe el motivo..." required></textarea>
                        </div>
                        <div>
                            <label class="form-label fw-bold small text-uppercase text-muted">Fecha de devolución</label>
                            <input type="date" name="fecha_devolucion" class="form-control rounded-3"
                                   value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-outline-secondary rounded-pill px-4 border-0"
                                @click="modalDevolucion = false">Cancelar</button>
                        <button type="submit" class="btn btn-danger rounded-pill px-4 fw-bold border-0">
                            <i class="fas fa-undo me-2"></i> Registrar Devolución
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade show" x-show="modalDevolucion" x-cloak style="z-index:1040;"></div>

</div>

@push('scripts')
<script>
function recepcionForm(detallesData) {
    const items = {};
    detallesData.forEach(d => {
        const pedida   = d.cantidad_en_compra;
        const recibida = d.cantidad_recibida || 0;
        const pendiente = pedida - recibida;
        items[d.id] = {
            aRecibir:    0,
            pedida,
            recibida,
            pendiente,
            estadoOriginal: d.estado_recepcion || 'pendiente',
            estadoLabel: d.estado_recepcion || 'pendiente',
        };
    });

    return {
        items,
        modalFaltantes: false,
        motivoFaltantes: '',
        modalDevolucion: false,
        devolucion: { detalleId: null, nombre: '', max: 0, cantidad: 1 },

        get totalARecibir() {
            return Object.values(this.items).reduce((s, i) => s + (i.aRecibir || 0), 0);
        },
        get lineasCompletas() {
            return Object.values(this.items).filter(i => (i.recibida + (i.aRecibir || 0)) >= i.pedida).length;
        },
        get lineasParciales() {
            return Object.values(this.items).filter(i => {
                const total = i.recibida + (i.aRecibir || 0);
                return total > 0 && total < i.pedida;
            }).length;
        },
        get porcentajeRecibido() {
            const totalPedido   = Object.values(this.items).reduce((s, i) => s + i.pedida, 0);
            const totalRecibido = Object.values(this.items).reduce((s, i) => s + i.recibida + (i.aRecibir || 0), 0);
            return totalPedido > 0 ? Math.round((totalRecibido / totalPedido) * 100) : 0;
        },

        actualizarItem(id, pedida, recibidaAntes) {
            const v = this.items[id];
            if (!v) return;
            const aRecibir  = Math.max(0, Math.min(v.aRecibir || 0, pedida - recibidaAntes));
            v.aRecibir      = aRecibir;
            const totalRec  = recibidaAntes + aRecibir;
            v.pendiente     = pedida - totalRec;
            if (totalRec >= pedida)       { v.estadoLabel = 'completo'; }
            else if (totalRec > 0)        { v.estadoLabel = 'parcial'; }
            else                          { v.estadoLabel = v.estadoOriginal; }
        },

        getEstadoBadge(id) {
            const label = this.items[id]?.estadoLabel || 'pendiente';
            const map = { completo: 'bg-success-subtle text-success', parcial: 'bg-info-subtle text-info',
                          pendiente: 'bg-secondary-subtle text-secondary', completo_con_faltantes: 'bg-warning-subtle text-warning' };
            return map[label] || 'bg-secondary-subtle text-secondary';
        },

        getRowClass(id) {
            const label = this.items[id]?.estadoLabel || '';
            if (label === 'completo') return 'table-success bg-opacity-25';
            if (label === 'parcial')  return 'table-warning bg-opacity-10';
            return '';
        },

        abrirDevolucion(detalleId, nombre, max) {
            this.devolucion = { detalleId, nombre, max, cantidad: 1 };
            this.modalDevolucion = true;
        },

        submitFaltantes() {
            if (!this.motivoFaltantes.trim()) return;
            const form = document.getElementById('recepcionForm');
            document.getElementById('tipoRecepcion').value = 'completa_con_faltantes';
            const inp = document.createElement('input');
            inp.type  = 'hidden';
            inp.name  = 'motivo_faltantes';
            inp.value = this.motivoFaltantes.trim();
            form.appendChild(inp);
            this.modalFaltantes = false;
            form.submit();
        },

        init() {
            document.getElementById('recepcionForm').addEventListener('submit', e => {
                const hayRecepciones = Object.values(this.items).some(i => (i.aRecibir || 0) > 0);
                if (!hayRecepciones && document.getElementById('tipoRecepcion').value === 'normal') {
                    e.preventDefault();
                    const alert = document.createElement('div');
                    alert.className = 'alert alert-warning border-0 rounded-4 shadow-sm mb-4';
                    alert.innerHTML = '<i class="fas fa-exclamation-triangle me-2"></i> Ingresa al menos una cantidad mayor a 0, o usa <strong>Completar con Faltantes</strong>.';
                    document.querySelector('.container-fluid').prepend(alert);
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                    return;
                }
                const btn = document.getElementById('btnSubmit');
                btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Procesando...';
                btn.disabled  = true;
            });
        }
    };
}
</script>
@endpush
@endsection
