{{-- resources/views/admin/ventas/pos/partials/cart/config-section.blade.php --}}
<div class="p-3 border-bottom">
    <h6 class="mb-3">
        <i class="fas fa-cog me-2 text-primary"></i>Configuración
    </h6>
   
    <!-- Configuración principal en una línea -->
    <div class="d-flex gap-2 mb-3">
        <!-- Moneda -->
        <div class="flex-fill">
            <label class="form-label small fw-bold mb-1">
                <i class="fas fa-coins me-1"></i>Moneda
            </label>
            <div class="btn-group w-100" role="group" id="moneda-group">
                <input type="radio" class="btn-check" name="moneda" id="moneda-soles" value="Soles" checked>
                <label class="btn btn-outline-primary btn-sm" for="moneda-soles">
                    <i class="fas fa-money-bill me-1"></i>S/
                </label>
                
                <input type="radio" class="btn-check" name="moneda" id="moneda-dolares" value="Dólares">
                <label class="btn btn-outline-primary btn-sm" for="moneda-dolares">
                    <i class="fas fa-dollar-sign me-1"></i>US$
                </label>
            </div>
        </div>
        
        <!-- Forma de Pago -->
        <div class="flex-fill">
            <label class="form-label small fw-bold mb-1">
                <i class="fas fa-credit-card me-1"></i>Pago
            </label>
            <div class="btn-group w-100" role="group" id="forma-pago-group">
                <input type="radio" class="btn-check" name="forma_pago" id="pago-contado" value="Contado" checked>
                <label class="btn btn-outline-success btn-sm" for="pago-contado">
                    <i class="fas fa-money-bills me-1"></i>Contado
                </label>
                
                <input type="radio" class="btn-check" name="forma_pago" id="pago-credito" value="Crédito">
                <label class="btn btn-outline-warning btn-sm" for="pago-credito">
                    <i class="fas fa-calendar-days me-1"></i>Crédito
                </label>
            </div>
        </div>
    </div>
    
    <!-- Porcentaje de Abono (solo visible en crédito) -->
    <div class="mb-3 d-none" id="abono-section">
        <div class="d-flex align-items-center gap-2">
            <label class="form-label small fw-bold mb-0">
                <i class="fas fa-percentage me-1"></i>Abono:
            </label>
            <div class="input-group input-group-sm" style="max-width: 120px;">
                <button class="btn btn-outline-secondary" type="button" id="btn-abono-menos">
                    <i class="fas fa-minus"></i>
                </button>
                <input type="number" class="form-control text-center" id="porcentaje-abono" 
                       value="50" min="0" max="100" step="5">
                <span class="input-group-text">%</span>
                <button class="btn btn-outline-secondary" type="button" id="btn-abono-mas">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
            <div class="d-flex gap-1">
                <button class="btn btn-outline-primary btn-xs" onclick="setAbono(0)">0%</button>
                <button class="btn btn-outline-primary btn-xs" onclick="setAbono(50)">50%</button>
                <button class="btn btn-outline-primary btn-xs" onclick="setAbono(100)">100%</button>
            </div>
        </div>
        <small class="text-muted mt-1 d-block" id="abono-info">
            Abono: <span id="abono-monto">S/ 0.00</span> | 
            Saldo: <span id="saldo-monto">S/ 0.00</span>
        </small>
    </div>
    
    <!-- Opciones y acciones en una línea -->
    <div class="d-flex justify-content-between align-items-center">
        <div class="d-flex gap-3">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="habilitar-descuentos">
                <label class="form-check-label small" for="habilitar-descuentos">
                    <i class="fas fa-percent me-1"></i>Habilitar descuentos
                </label>
            </div>
        </div>
    </div>
</div>

<style>
.btn-xs {
    padding: 0.125rem 0.375rem;
    font-size: 0.7rem;
}

.btn-group .btn {
    transition: all 0.2s ease;
}

.btn-check:checked + .btn {
    transform: scale(0.98);
    box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);
}

tiny {
    font-size: 0.65rem;
    line-height: 1;
}

.form-check-switch .form-check-input {
    width: 2em;
}

#abono-section {
    background: #f8f9fa;
    padding: 0.75rem;
    border-radius: 0.375rem;
    border: 1px solid #dee2e6;
}

.config-section-animation {
    animation: slideInUp 0.3s ease-out;
}

@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>

<script>
$(document).ready(function() {
    console.log('⚙️ Inicializando panel de configuración...');
    
    // Configuración por defecto
    let config = {
        moneda: 'Soles',
        forma_pago: 'Contado',
        porcentaje_abono: 100,
        habilitar_descuentos: false
    };
    
    // Inicializar configuración
    function initConfig() {
        // Cargar configuración guardada si existe
        const savedConfig = localStorage.getItem('pos_config');
        if (savedConfig) {
            try {
                config = { ...config, ...JSON.parse(savedConfig) };
                console.log('📁 Configuración cargada:', config);
            } catch (e) {
                console.warn('⚠️ Error al cargar configuración guardada');
            }
        }
        
        // Aplicar configuración a la interfaz
        applyConfigToUI();
        updateCartTotals();
    }
    
    // Aplicar configuración a la interfaz
    function applyConfigToUI() {
        // Moneda
        $(`input[name="moneda"][value="${config.moneda}"]`).prop('checked', true);
        
        // Forma de pago
        $(`input[name="forma_pago"][value="${config.forma_pago}"]`).prop('checked', true);
        
        // Porcentaje de abono
        $('#porcentaje-abono').val(config.porcentaje_abono);
        
        // Opciones
        $('#habilitar-descuentos').prop('checked', config.habilitar_descuentos);
        
        // Mostrar/ocultar sección de abono
        toggleAbonoSection();
    }
    
    // Event listeners para cambios de configuración
    function setupEventListeners() {
        // Cambio de moneda
        $('input[name="moneda"]').on('change', function() {
            config.moneda = $(this).val();
            console.log('💱 Moneda cambiada a:', config.moneda);
            updateCartTotals();
            triggerConfigChange();
        });
        
        // Cambio de forma de pago
        $('input[name="forma_pago"]').on('change', function() {
            config.forma_pago = $(this).val();
            console.log('💳 Forma de pago cambiada a:', config.forma_pago);
            toggleAbonoSection();
            updateCartTotals();
            triggerConfigChange();
        });
        
        // Cambio de porcentaje de abono
        $('#porcentaje-abono').on('input change', function() {
            let value = parseInt($(this).val()) || 0;
            value = Math.max(0, Math.min(100, value));
            $(this).val(value);
            config.porcentaje_abono = value;
            updateCartTotals();
            triggerConfigChange();
        });
        
        // Botones de abono
        $('#btn-abono-menos').on('click', function() {
            const current = parseInt($('#porcentaje-abono').val()) || 0;
            const newValue = Math.max(0, current - 5);
            setAbono(newValue);
        });
        
        $('#btn-abono-mas').on('click', function() {
            const current = parseInt($('#porcentaje-abono').val()) || 0;
            const newValue = Math.min(100, current + 5);
            setAbono(newValue);
        });
        
        // Opciones adicionales
        $('#habilitar-descuentos').on('change', function() {
            config.habilitar_descuentos = $(this).is(':checked');
            console.log('💰 Habilitar descuentos:', config.habilitar_descuentos);
            
            // Mostrar/ocultar controles de descuento en items del carrito
            if (config.habilitar_descuentos) {
                $('.discount-controls').removeClass('d-none');
                showNotification('Descuentos habilitados - Disponibles en el carrito', 'info');
            } else {
                $('.discount-controls').addClass('d-none');
                showNotification('Descuentos deshabilitados', 'info');
            }
            
            triggerConfigChange();
        });
        
        // Acciones rápidas
        $('#btn-limpiar-carrito').on('click', function() {
            if (confirm('¿Está seguro de que desea limpiar el carrito?')) {
                limpiarCarrito();
            }
        });
        
        $('#btn-guardar-configuracion').on('click', function() {
            guardarConfiguracion();
        });
    }
    
    // Mostrar/ocultar sección de abono
    function toggleAbonoSection() {
        const abonoSection = $('#abono-section');
        
        if (config.forma_pago === 'Crédito') {
            abonoSection.removeClass('d-none').addClass('config-section-animation');
            // En crédito, permitir abono parcial (por defecto 50%)
            if (config.porcentaje_abono === 100) {
                config.porcentaje_abono = 50;
            }
            console.log('💳 Modo CRÉDITO activado - Se permite pago parcial');
            showNotification('Modo Crédito: Se permite pago parcial', 'info');
        } else {
            abonoSection.addClass('d-none');
            config.porcentaje_abono = 100; // En contado siempre es 100%
            console.log('💰 Modo CONTADO activado - Pago completo requerido');
            showNotification('Modo Contado: Pago completo requerido', 'info');
        }
        
        $('#porcentaje-abono').val(config.porcentaje_abono);
        updateCartTotals();
    }
    
    // Establecer porcentaje de abono
    function setAbono(porcentaje) {
        config.porcentaje_abono = porcentaje;
        $('#porcentaje-abono').val(porcentaje);
        updateCartTotals();
        triggerConfigChange();
    }
    
    // Actualizar totales del carrito
// Actualizar totales del carrito
function updateCartTotals() {
    let items = [];
    
    // Verificar si window.pos existe y tiene el método obtenerItems
    if (window.pos && typeof window.pos.obtenerItems === 'function') {
        try {
            items = window.pos.obtenerItems();
        } catch (error) {
            console.error('Error al obtener items del carrito:', error);
            items = [];
        }
    } else {
        console.warn('⚠️ window.pos.obtenerItems no está disponible, usando array vacío');
        // Intentar obtener items de fuentes alternativas si están disponibles
        items = window.cartItems || [];
    }
    
    let subtotal = 0;
    
    if (Array.isArray(items)) {
        items.forEach(item => {
            const precio = parseFloat(item.precio || 0);
            const cantidad = parseInt(item.cantidad || 1);
            const descuento = parseFloat(item.descuento || 0);
            
            // Calcular el precio después del descuento si está habilitado
            let precioFinal = precio;
            if (config.habilitar_descuentos && descuento > 0) {
                precioFinal = precio * (1 - (descuento / 100));
            }
            
            subtotal += precioFinal * cantidad;
        });
    }
    
    const impuestos = subtotal * 0.18;
    const total = subtotal + impuestos;
    const abono = total * (config.porcentaje_abono / 100);
    const saldo = total - abono;
    
    const simboloMoneda = config.moneda === 'Dólares' ? 'US$' : 'S/';
    
    // Actualizar información de abono
    $('#abono-monto').text(`${simboloMoneda} ${abono.toFixed(2)}`);
    $('#saldo-monto').text(`${simboloMoneda} ${saldo.toFixed(2)}`);
    
    // Trigger evento para otros componentes
    $(document).trigger('configUpdated', [config, { subtotal, impuestos, total, abono, saldo }]);
}
    
    // Limpiar carrito
    function limpiarCarrito() {
        if (window.pos && window.pos.limpiarCarrito) {
            window.pos.limpiarCarrito();
            console.log('🧹 Carrito limpiado desde configuración');
            showNotification('Carrito limpiado', 'info');
        }
    }
    
    // Guardar configuración
    function guardarConfiguracion() {
        try {
            localStorage.setItem('pos_config', JSON.stringify(config));
            console.log('💾 Configuración guardada:', config);
            showNotification('Configuración guardada', 'success');
            
            // Animar botón
            const btn = $('#btn-guardar-configuracion');
            btn.html('<i class="fas fa-check me-1"></i>Guardado');
            setTimeout(() => {
                btn.html('<i class="fas fa-save me-1"></i>Guardar configuración');
            }, 2000);
        } catch (e) {
            console.error('❌ Error al guardar configuración:', e);
            showNotification('Error al guardar configuración', 'error');
        }
    }
    
    // Trigger cambio de configuración
    function triggerConfigChange() {
        console.log('📡 Emitiendo evento configChanged con configuración:', config);
        $(document).trigger('configChanged', [config]);
        updateCartTotals();
        
        // También actualizar directamente los totales como fallback
        if (window.totalesSection && window.totalesSection.updateConfig) {
            console.log('🔄 Actualizando totales directamente como fallback');
            window.totalesSection.updateConfig(config);
        }
    }
    
    // Obtener configuración actual
    function getConfig() {
        return { ...config };
    }
    
    // Mostrar notificaciones
    function showNotification(message, type = 'info') {
        if (typeof window.mostrarNotificacion === 'function') {
            window.mostrarNotificacion(message, type);
        } else {
            console.log(`📢 ${type.toUpperCase()}: ${message}`);
        }
    }
    
    // Exponer funciones globalmente
    window.posConfig = {
        getConfig: getConfig,
        setAbono: setAbono,
        updateTotals: updateCartTotals,
        save: guardarConfiguracion,
        clear: limpiarCarrito
    };
    
    // Hacer setAbono global para los botones
    window.setAbono = setAbono;
    
    // Escuchar cambios del carrito
    $(document).on('cartUpdated', function(event, items) {
        console.log('🔄 Carrito actualizado, recalculando totales...');
        updateCartTotals();
    });
    
    // Inicializar
    initConfig();
    setupEventListeners();
    
    console.log('✅ Panel de configuración inicializado');
    console.log('⚙️ Configuración actual:', config);
});
</script>