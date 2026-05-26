{{--
    Árbol granular de permisos con UX mejorada:
      - Sidebar con módulos (sticky, con scrollspy y conteo)
      - Acciones con badges coloreados (Ver/Crear/Editar/Eliminar/Especial)
      - Estado indeterminate en checkboxes parcialmente seleccionados
      - Presets rápidos por submódulo (Solo lectura, CRUD básico, Todo)
      - Búsqueda en vivo con resaltado y auto-expansión

    Variables:
      $permissions  -> Permission::groupedByModuleAndSubmodule()
      $assignedIds  -> (opcional) ids ya asignados
--}}
@php
    $assignedIds = $assignedIds ?? [];

    $moduleIcons = [
        'sistema' => 'fas fa-cog',
        'usuarios' => 'fas fa-users-cog',
        'ventas' => 'fas fa-shopping-cart',
        'clientes' => 'fas fa-user-tie',
        'compras' => 'fas fa-truck-loading',
        'almacenes' => 'fas fa-warehouse',
        'inventario' => 'fas fa-boxes',
        'mantenimiento' => 'fas fa-tools',
        'productos-servicios' => 'fas fa-car',
        'configuracion' => 'fas fa-sliders-h',
        'establecimientos' => 'fas fa-store',
        'talleres' => 'fas fa-wrench',
    ];

    $totalPerms = 0;
    $selectedPerms = 0;
    foreach ($permissions as $m) {
        foreach ($m['submodules'] as $s) {
            $totalPerms += count($s['permissions']);
            foreach ($s['permissions'] as $p) {
                if (in_array($p->id, $assignedIds)) $selectedPerms++;
            }
        }
    }
@endphp

<style>
    .perm-wrapper { position: relative; }
    .perm-sidebar {
        position: sticky; top: 80px; max-height: calc(100vh - 140px);
        overflow-y: auto; border-right: 1px solid #e5e7eb;
    }
    .perm-sidebar .nav-link {
        display: flex; align-items: center; padding: 8px 12px;
        color: #475569; border-radius: 6px; margin-bottom: 2px;
        cursor: pointer; font-size: 13px; transition: all .15s;
    }
    .perm-sidebar .nav-link:hover { background: #f1f5f9; color: #1e293b; }
    .perm-sidebar .nav-link.active {
        background: #2563eb; color: white;
    }
    .perm-sidebar .nav-link.active .text-muted,
    .perm-sidebar .nav-link.active .badge { color: white !important; background: rgba(255,255,255,.25) !important; }
    .perm-sidebar .nav-icon { width: 20px; text-align: center; margin-right: 8px; }

    .perm-module-card {
        border: 1px solid #e5e7eb; border-radius: 10px; margin-bottom: 16px;
        background: white; overflow: hidden;
        box-shadow: 0 1px 2px rgba(0,0,0,.04);
    }
    .perm-module-header {
        padding: 14px 18px; background: linear-gradient(180deg, #f8fafc, #f1f5f9);
        border-bottom: 1px solid #e5e7eb; display: flex; align-items: center;
        cursor: pointer; user-select: none;
    }
    .perm-module-header:hover { background: linear-gradient(180deg, #f1f5f9, #e2e8f0); }
    .perm-module-header .module-icon {
        width: 36px; height: 36px; border-radius: 8px; background: #2563eb;
        color: white; display: flex; align-items: center; justify-content: center;
        margin-right: 12px; font-size: 16px;
    }
    .perm-module-title { font-weight: 600; color: #0f172a; font-size: 15px; }
    .perm-module-meta { font-size: 12px; color: #64748b; }
    .perm-module-body { padding: 14px; }
    .perm-module-body.collapsed { display: none; }

    .perm-sub-card {
        border: 1px solid #e2e8f0; border-radius: 8px; margin-bottom: 10px;
        background: #fafbfc;
    }
    .perm-sub-header {
        padding: 10px 14px; border-bottom: 1px solid #e2e8f0;
        display: flex; align-items: center; gap: 8px; flex-wrap: wrap;
    }
    .perm-sub-title { font-weight: 600; color: #1e293b; font-size: 14px; flex: 1; }
    .perm-sub-presets { display: flex; gap: 4px; flex-wrap: wrap; }
    .perm-sub-presets .btn { font-size: 11px; padding: 2px 8px; }
    .perm-sub-body { padding: 12px 14px; background: white; border-radius: 0 0 8px 8px; }

    .perm-chip {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 5px 10px; border-radius: 999px; border: 1.5px solid #e2e8f0;
        background: #f8fafc; font-size: 12.5px; cursor: pointer; transition: all .15s;
        user-select: none; margin: 0;
    }
    .perm-chip:hover { border-color: #cbd5e1; background: #f1f5f9; }
    .perm-chip input { display: none; }
    .perm-chip .chip-dot {
        width: 14px; height: 14px; border-radius: 50%;
        border: 2px solid #cbd5e1; background: white; flex-shrink: 0;
        position: relative; transition: all .15s;
    }
    .perm-chip input:checked + .chip-dot { background: #2563eb; border-color: #2563eb; }
    .perm-chip input:checked + .chip-dot::after {
        content: ''; position: absolute; left: 3px; top: 0px;
        width: 4px; height: 8px; border: solid white; border-width: 0 2px 2px 0;
        transform: rotate(45deg);
    }
    .perm-chip:has(input:checked) {
        background: #eff6ff; border-color: #93c5fd; color: #1e40af; font-weight: 500;
    }

    /* Colores por acción */
    .perm-chip[data-action-type="ver"]:has(input:checked) { background: #e0f2fe; border-color: #38bdf8; color: #075985; }
    .perm-chip[data-action-type="crear"]:has(input:checked) { background: #dcfce7; border-color: #4ade80; color: #166534; }
    .perm-chip[data-action-type="editar"]:has(input:checked) { background: #fef3c7; border-color: #fbbf24; color: #92400e; }
    .perm-chip[data-action-type="eliminar"]:has(input:checked) { background: #fee2e2; border-color: #f87171; color: #991b1b; }
    .perm-chip[data-action-type="ver"]:has(input:checked) .chip-dot { background: #0284c7; border-color: #0284c7; }
    .perm-chip[data-action-type="crear"]:has(input:checked) .chip-dot { background: #16a34a; border-color: #16a34a; }
    .perm-chip[data-action-type="editar"]:has(input:checked) .chip-dot { background: #d97706; border-color: #d97706; }
    .perm-chip[data-action-type="eliminar"]:has(input:checked) .chip-dot { background: #dc2626; border-color: #dc2626; }

    .perm-master {
        width: 18px; height: 18px; margin-right: 10px;
        accent-color: #2563eb; cursor: pointer;
    }

    .perm-counter-badge {
        display: inline-block; padding: 2px 8px; border-radius: 999px;
        background: #e2e8f0; color: #475569; font-size: 11px; font-weight: 600;
    }
    .perm-counter-badge.partial { background: #fef3c7; color: #92400e; }
    .perm-counter-badge.full { background: #dcfce7; color: #166534; }

    .perm-floating-bar {
        position: sticky; bottom: 0; z-index: 10;
        background: white; border-top: 1px solid #e5e7eb;
        padding: 12px 16px; margin: 16px -16px -16px;
        display: flex; align-items: center; gap: 12px; flex-wrap: wrap;
        box-shadow: 0 -4px 12px rgba(0,0,0,.05);
    }

    .perm-highlight { background: yellow !important; padding: 0 2px; border-radius: 2px; }
    .perm-hidden { display: none !important; }
    .perm-chevron { transition: transform .2s; margin-left: auto; color: #64748b; }
    .perm-module-card.collapsed .perm-chevron { transform: rotate(-90deg); }

    @media (max-width: 991px) {
        .perm-sidebar { position: static; max-height: none; border-right: none; border-bottom: 1px solid #e5e7eb; margin-bottom: 16px; }
    }
</style>

<div class="perm-wrapper">
    {{-- Toolbar superior --}}
    <div class="d-flex flex-wrap gap-2 align-items-center mb-3 p-3 rounded" style="background: #f8fafc; border: 1px solid #e5e7eb;">
        <div class="input-group input-group-sm" style="max-width: 340px;">
            <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
            <input type="text" id="permSearch" class="form-control" placeholder="Buscar permiso, módulo, submódulo...">
            <button type="button" class="btn btn-outline-secondary" id="clearSearch" style="display:none;">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="btn-group btn-group-sm" role="group">
            <button type="button" class="btn btn-outline-success" id="selectAllPerms" title="Seleccionar todos los permisos">
                <i class="fas fa-check-double"></i> Todo
            </button>
            <button type="button" class="btn btn-outline-info" id="selectAllRead" title="Solo permisos de lectura (Ver)">
                <i class="fas fa-eye"></i> Solo lectura
            </button>
            <button type="button" class="btn btn-outline-danger" id="deselectAllPerms" title="Quitar todos">
                <i class="fas fa-eraser"></i> Limpiar
            </button>
        </div>

        <div class="btn-group btn-group-sm" role="group">
            <button type="button" class="btn btn-outline-primary" id="expandAllMods">
                <i class="fas fa-angle-double-down"></i> Expandir
            </button>
            <button type="button" class="btn btn-outline-secondary" id="collapseAllMods">
                <i class="fas fa-angle-double-up"></i> Colapsar
            </button>
        </div>

        <div class="ms-auto d-flex align-items-center gap-2">
            <small class="text-muted">Total:</small>
            <span class="badge bg-primary fs-6" id="permTotalCounter">{{ $selectedPerms }} / {{ $totalPerms }}</span>
        </div>
    </div>

    <div class="row g-3">
        {{-- Sidebar de módulos --}}
        <div class="col-lg-3">
            <div class="perm-sidebar pe-2">
                <div class="small text-muted text-uppercase fw-bold mb-2 px-2">Módulos del sistema</div>
                <nav class="nav flex-column" id="permModuleNav">
                    @foreach ($permissions as $moduleKey => $moduleData)
                        @php
                            $modulePermIds = collect($moduleData['submodules'])->flatMap(fn($s) => collect($s['permissions'])->pluck('id'))->toArray();
                            $modTotal = count($modulePermIds);
                            $modSel = count(array_intersect($modulePermIds, $assignedIds));
                            $icon = $moduleIcons[$moduleKey] ?? 'fas fa-folder';
                        @endphp
                        <a class="nav-link" data-target-module="{{ $moduleKey }}">
                            <span class="nav-icon"><i class="{{ $icon }}"></i></span>
                            <span class="flex-grow-1 text-truncate">{{ $moduleData['label'] }}</span>
                            <span class="badge perm-counter-badge sidebar-counter ms-2"
                                  data-module="{{ $moduleKey }}">{{ $modSel }}/{{ $modTotal }}</span>
                        </a>
                    @endforeach
                </nav>
            </div>
        </div>

        {{-- Contenido principal --}}
        <div class="col-lg-9">
            <div id="permModulesContainer">
                @forelse ($permissions as $moduleKey => $moduleData)
                    @php
                        $modulePermIds = collect($moduleData['submodules'])->flatMap(fn($s) => collect($s['permissions'])->pluck('id'))->toArray();
                        $modTotal = count($modulePermIds);
                        $modSel = count(array_intersect($modulePermIds, $assignedIds));
                        $icon = $moduleIcons[$moduleKey] ?? 'fas fa-folder';
                        $startCollapsed = $modSel === 0;
                    @endphp
                    <div class="perm-module-card {{ $startCollapsed ? 'collapsed' : '' }}"
                         id="module-{{ $moduleKey }}"
                         data-module="{{ $moduleKey }}"
                         data-search="{{ strtolower($moduleData['label'] . ' ' . $moduleKey) }}">
                        <div class="perm-module-header" data-toggle-module="{{ $moduleKey }}">
                            <input type="checkbox" class="perm-master module-master"
                                   data-module="{{ $moduleKey }}"
                                   onclick="event.stopPropagation();"
                                   {{ $modSel === $modTotal && $modTotal > 0 ? 'checked' : '' }}>
                            <div class="module-icon"><i class="{{ $icon }}"></i></div>
                            <div class="flex-grow-1">
                                <div class="perm-module-title">{{ $moduleData['label'] }}</div>
                                <div class="perm-module-meta">
                                    <span class="module-counter" data-module="{{ $moduleKey }}">
                                        <strong>{{ $modSel }}</strong> de <strong>{{ $modTotal }}</strong> permisos
                                    </span>
                                    · {{ count($moduleData['submodules']) }} submódulo(s)
                                </div>
                            </div>
                            <i class="fas fa-chevron-down perm-chevron"></i>
                        </div>

                        <div class="perm-module-body {{ $startCollapsed ? 'collapsed' : '' }}">
                            @foreach ($moduleData['submodules'] as $subKey => $subData)
                                @php
                                    $subPermIds = collect($subData['permissions'])->pluck('id')->toArray();
                                    $subTotal = count($subPermIds);
                                    $subSel = count(array_intersect($subPermIds, $assignedIds));
                                @endphp
                                <div class="perm-sub-card"
                                     data-module="{{ $moduleKey }}"
                                     data-submodule="{{ $subKey }}"
                                     data-search="{{ strtolower($subData['label'] . ' ' . $subKey) }}">
                                    <div class="perm-sub-header">
                                        <input type="checkbox" class="perm-master submodule-master"
                                               data-module="{{ $moduleKey }}"
                                               data-submodule="{{ $subKey }}"
                                               {{ $subSel === $subTotal && $subTotal > 0 ? 'checked' : '' }}>
                                        <span class="perm-sub-title">{{ $subData['label'] }}</span>
                                        <span class="badge perm-counter-badge submodule-counter"
                                              data-submodule="{{ $moduleKey }}.{{ $subKey }}">
                                            {{ $subSel }}/{{ $subTotal }}
                                        </span>
                                        <div class="perm-sub-presets">
                                            <button type="button" class="btn btn-outline-info preset-btn"
                                                    data-preset="read"
                                                    data-module="{{ $moduleKey }}"
                                                    data-submodule="{{ $subKey }}"
                                                    title="Solo Ver">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-success preset-btn"
                                                    data-preset="crud"
                                                    data-module="{{ $moduleKey }}"
                                                    data-submodule="{{ $subKey }}"
                                                    title="CRUD básico (Ver/Crear/Editar/Eliminar)">
                                                <i class="fas fa-pen"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-primary preset-btn"
                                                    data-preset="all"
                                                    data-module="{{ $moduleKey }}"
                                                    data-submodule="{{ $subKey }}"
                                                    title="Todo">
                                                <i class="fas fa-check-double"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-secondary preset-btn"
                                                    data-preset="none"
                                                    data-module="{{ $moduleKey }}"
                                                    data-submodule="{{ $subKey }}"
                                                    title="Limpiar">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="perm-sub-body">
                                        <div class="d-flex flex-wrap gap-2">
                                            @foreach ($subData['permissions'] as $permission)
                                                @php
                                                    $actionType = 'otro';
                                                    $n = strtolower($permission->name);
                                                    if (str_ends_with($n, '.ver')) $actionType = 'ver';
                                                    elseif (str_ends_with($n, '.crear')) $actionType = 'crear';
                                                    elseif (str_ends_with($n, '.editar')) $actionType = 'editar';
                                                    elseif (str_ends_with($n, '.eliminar')) $actionType = 'eliminar';
                                                @endphp
                                                <label class="perm-chip permission-item"
                                                       data-action-type="{{ $actionType }}"
                                                       data-search="{{ strtolower($permission->display_name . ' ' . $permission->name) }}"
                                                       title="{{ $permission->name }}">
                                                    <input type="checkbox"
                                                           class="permission-checkbox"
                                                           name="permissions[]"
                                                           value="{{ $permission->id }}"
                                                           data-module="{{ $moduleKey }}"
                                                           data-submodule="{{ $subKey }}"
                                                           data-action-type="{{ $actionType }}"
                                                           {{ in_array($permission->id, $assignedIds) ? 'checked' : '' }}>
                                                    <span class="chip-dot"></span>
                                                    <span class="chip-label">{{ $permission->display_name }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <div class="alert alert-warning">
                        No hay permisos registrados. Ejecuta <code>php artisan db:seed --class=RolesPermissionsSeeder</code>.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
(function(){
    const wrapper = document.querySelector('.perm-wrapper');
    if (!wrapper) return;

    function setIndeterminate(checkbox, total, selected) {
        if (!checkbox) return;
        checkbox.checked = total > 0 && selected === total;
        checkbox.indeterminate = selected > 0 && selected < total;
    }

    function updateCounters(){
        let grandTotal = 0, grandSel = 0, grandAll = 0;

        wrapper.querySelectorAll('.perm-module-card').forEach(mod => {
            const moduleKey = mod.dataset.module;
            const perms = mod.querySelectorAll('.permission-checkbox');
            const checked = mod.querySelectorAll('.permission-checkbox:checked');
            grandTotal += perms.length;
            grandSel += checked.length;
            grandAll += perms.length;

            const counter = mod.querySelector('.module-counter');
            if (counter) counter.innerHTML = `<strong>${checked.length}</strong> de <strong>${perms.length}</strong> permisos`;

            const sideCounter = document.querySelector(`.sidebar-counter[data-module="${moduleKey}"]`);
            if (sideCounter) {
                sideCounter.textContent = `${checked.length}/${perms.length}`;
                sideCounter.classList.remove('partial', 'full');
                if (checked.length === perms.length && perms.length > 0) sideCounter.classList.add('full');
                else if (checked.length > 0) sideCounter.classList.add('partial');
            }

            setIndeterminate(mod.querySelector('.module-master'), perms.length, checked.length);

            mod.querySelectorAll('.perm-sub-card').forEach(sub => {
                const sp = sub.querySelectorAll('.permission-checkbox');
                const sc = sub.querySelectorAll('.permission-checkbox:checked');
                const sCounter = sub.querySelector('.submodule-counter');
                if (sCounter) {
                    sCounter.textContent = `${sc.length}/${sp.length}`;
                    sCounter.classList.remove('partial', 'full');
                    if (sc.length === sp.length && sp.length > 0) sCounter.classList.add('full');
                    else if (sc.length > 0) sCounter.classList.add('partial');
                }
                setIndeterminate(sub.querySelector('.submodule-master'), sp.length, sc.length);
            });
        });

        const tc = document.getElementById('permTotalCounter');
        if (tc) tc.textContent = `${grandSel} / ${grandAll}`;
    }

    // Toggle módulo expand/collapse
    wrapper.querySelectorAll('.perm-module-header').forEach(h => {
        h.addEventListener('click', function(e){
            if (e.target.closest('input, button, .perm-master')) return;
            const card = this.closest('.perm-module-card');
            const body = card.querySelector('.perm-module-body');
            card.classList.toggle('collapsed');
            body.classList.toggle('collapsed');
        });
    });

    // Module master checkbox
    wrapper.querySelectorAll('.module-master').forEach(cb => {
        cb.addEventListener('change', function(){
            const mod = this.closest('.perm-module-card');
            mod.querySelectorAll('.permission-checkbox').forEach(p => p.checked = this.checked);
            updateCounters();
        });
    });

    // Submodule master
    wrapper.querySelectorAll('.submodule-master').forEach(cb => {
        cb.addEventListener('change', function(){
            const sub = this.closest('.perm-sub-card');
            sub.querySelectorAll('.permission-checkbox').forEach(p => p.checked = this.checked);
            updateCounters();
        });
    });

    // Permisos individuales
    wrapper.querySelectorAll('.permission-checkbox').forEach(cb => {
        cb.addEventListener('change', updateCounters);
    });

    // Presets por submódulo
    wrapper.querySelectorAll('.preset-btn').forEach(btn => {
        btn.addEventListener('click', function(){
            const mod = this.dataset.module;
            const sub = this.dataset.submodule;
            const preset = this.dataset.preset;
            const subCard = wrapper.querySelector(`.perm-sub-card[data-module="${mod}"][data-submodule="${sub}"]`);
            if (!subCard) return;
            subCard.querySelectorAll('.permission-checkbox').forEach(p => {
                const type = p.dataset.actionType;
                if (preset === 'all') p.checked = true;
                else if (preset === 'none') p.checked = false;
                else if (preset === 'read') p.checked = (type === 'ver');
                else if (preset === 'crud') p.checked = ['ver','crear','editar','eliminar'].includes(type);
            });
            updateCounters();
        });
    });

    // Botones globales
    document.getElementById('selectAllPerms')?.addEventListener('click', () => {
        wrapper.querySelectorAll('.permission-checkbox').forEach(p => p.checked = true);
        updateCounters();
    });
    document.getElementById('selectAllRead')?.addEventListener('click', () => {
        wrapper.querySelectorAll('.permission-checkbox').forEach(p => {
            p.checked = p.dataset.actionType === 'ver';
        });
        updateCounters();
    });
    document.getElementById('deselectAllPerms')?.addEventListener('click', () => {
        if (!confirm('¿Quitar TODOS los permisos seleccionados?')) return;
        wrapper.querySelectorAll('.permission-checkbox').forEach(p => p.checked = false);
        updateCounters();
    });
    document.getElementById('expandAllMods')?.addEventListener('click', () => {
        wrapper.querySelectorAll('.perm-module-card').forEach(c => c.classList.remove('collapsed'));
        wrapper.querySelectorAll('.perm-module-body').forEach(b => b.classList.remove('collapsed'));
    });
    document.getElementById('collapseAllMods')?.addEventListener('click', () => {
        wrapper.querySelectorAll('.perm-module-card').forEach(c => c.classList.add('collapsed'));
        wrapper.querySelectorAll('.perm-module-body').forEach(b => b.classList.add('collapsed'));
    });

    // Sidebar nav: scroll y activación
    wrapper.querySelectorAll('#permModuleNav .nav-link').forEach(link => {
        link.addEventListener('click', function(e){
            e.preventDefault();
            const target = wrapper.querySelector(`#module-${this.dataset.targetModule}`);
            if (!target) return;
            // Asegurar que esté expandido
            target.classList.remove('collapsed');
            target.querySelector('.perm-module-body')?.classList.remove('collapsed');
            // Scroll suave
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            // Marcar activo
            wrapper.querySelectorAll('#permModuleNav .nav-link').forEach(l => l.classList.remove('active'));
            this.classList.add('active');
        });
    });

    // Búsqueda en vivo
    const search = document.getElementById('permSearch');
    const clearBtn = document.getElementById('clearSearch');

    function applySearch(q) {
        q = q.trim().toLowerCase();
        clearBtn.style.display = q ? 'inline-block' : 'none';

        wrapper.querySelectorAll('.perm-module-card').forEach(mod => {
            let modVisible = false;
            mod.querySelectorAll('.perm-sub-card').forEach(sub => {
                let subVisible = false;
                sub.querySelectorAll('.permission-item').forEach(item => {
                    const match = q === '' ||
                        item.dataset.search.includes(q) ||
                        sub.dataset.search.includes(q) ||
                        mod.dataset.search.includes(q);
                    item.classList.toggle('perm-hidden', !match);
                    if (match) subVisible = true;
                });
                sub.classList.toggle('perm-hidden', !subVisible);
                if (subVisible) modVisible = true;
            });
            mod.classList.toggle('perm-hidden', !modVisible);
            if (q !== '' && modVisible) {
                mod.classList.remove('collapsed');
                mod.querySelector('.perm-module-body')?.classList.remove('collapsed');
            }
        });
    }

    search?.addEventListener('input', e => applySearch(e.target.value));
    clearBtn?.addEventListener('click', () => {
        search.value = '';
        applySearch('');
        search.focus();
    });

    // ScrollSpy: resaltar módulo en sidebar al hacer scroll
    const navLinks = wrapper.querySelectorAll('#permModuleNav .nav-link');
    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const moduleKey = entry.target.dataset.module;
                navLinks.forEach(l => l.classList.toggle('active', l.dataset.targetModule === moduleKey));
            }
        });
    }, { rootMargin: '-30% 0px -60% 0px' });
    wrapper.querySelectorAll('.perm-module-card').forEach(c => observer.observe(c));

    updateCounters();
})();
</script>
@endpush
