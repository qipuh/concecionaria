{{-- resources/views/admin/ventas/pos/partials/scripts.blade.php --}}
<script>
/**
 * Sistema de Punto de Venta - JavaScript Principal
 * Archivo separado para facilitar el mantenimiento
 */

// Incluir meta token CSRF si no existe
if (!$('meta[name="csrf-token"]').length) {
    $('head').append('<meta name="csrf-token" content="{{ csrf_token() }}">');
}

$(document).ready(function() {
    // Configuración global
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    // Variables globales
    let selectedCategoriaParteId = '';
    let selectedCategoriaServicioId = '';
    let itemsSeleccionados = [];
    let tipoActivo = 'todo';
    let generarRequerimiento = false;
    let porcentajeAbono = 100;
    let searchTimeout;
    let clienteSearchTimeout;
    
    const SEARCH_DELAY = 300;
    
    // Inicialización
    init();
    
    function init() {
        configurarEventos();
        cargarItemsPopulares();
        actualizarReloj();
        setInterval(actualizarReloj, 60000);
        mostrarMensajeInicial();
    }
    
    function mostrarMensajeInicial() {
        $('#search-results').html(`
            <div class="d-flex justify-content-center align-items-center" style="min-height: 300px;">
                <div class="text-center text-muted">
                    <i class="fas fa-search fa-4x mb-3 text-primary opacity-50"></i>
                    <h5>Busque productos o servicios</h5>
                    <p>Use la barra de búsqueda para encontrar items o navegue por categorías</p>
                </div>
            </div>
        `);
    }
    
    function configurarEventos() {
        // Eventos de filtro por tipo
        $('#btn-todo, #btn-partes, #btn-servicios').off('click').on('click', cambiarTipoFiltro);
        
        // Eventos de búsqueda
        $('#search-items').off('input').on('input', manejarBusquedaEnTiempoReal);
        $('#search-items').off('keypress').on('keypress', manejarEnterBusqueda);
        $('#btn-search').off('click').on('click', ejecutarBusqueda);
        
        // Eventos de configuración
        $('#generar-requerimiento').off('change').on('change', toggleGenerarRequerimiento);
        $('#porcentaje-abono').off('input').on('input', actualizarPorcentajeAbono);
        $('#almacen, #moneda').off('change').on('change', function() {
            calcularTotales();
            cargarItemsPopulares();
        });
        
        // Botones de acción
        $('#btn-cancelar').off('click').on('click', cancelarVenta);
        $('#btn-procesar').off('click').on('click', procesarVenta);
        
        // Eventos de cliente
        configurarEventosCliente();
        
        // Eventos dinámicos
        configurarEventosDinamicos();
        
        // Eventos del modal de item
        configurarEventosModalItem();
    }
    
    function configurarEventosDinamicos() {
        $(document).off('click', '.item-card').on('click', '.item-card', seleccionarItem);
        $(document).off('click', '.popular-item').on('click', '.popular-item', seleccionarItem);
        $(document).off('click', '.btn-edit-item').on('click', '.btn-edit-item', editarItem);
        $(document).off('click', '.btn-remove-item').on('click', '.btn-remove-item', removerItem);
        $(document).off('click', '.btn-select-cliente').on('click', '.btn-select-cliente', seleccionarCliente);
        $(document).off('click', '.categoria-parte').on('click', '.categoria-parte', filtrarPorCategoriaParte);
        $(document).off('click', '.categoria-servicio').on('click', '.categoria-servicio', filtrarPorCategoriaServicio);
        $(document).off('click', '#btn-nueva-venta').on('click', '#btn-nueva-venta', function() {
            location.reload();
        });
    }
    
    // =============================================
    // FUNCIONES DE BÚSQUEDA
    // =============================================
    
    function cambiarTipoFiltro() {
        $('#btn-todo, #btn-partes, #btn-servicios').removeClass('active');
        $(this).addClass('active');
        
        tipoActivo = $(this).attr('id').replace('btn-', '');
        mostrarFiltrosSegunTipo();
        
        const searchText = $('#search-items').val().trim();
        if (searchText) {
            ejecutarBusqueda();
        } else {
            mostrarMensajeInicial();
        }
    }
    
    function mostrarFiltrosSegunTipo() {
        if (tipoActivo === 'todo') {
            $('#filter-categorias-partes, #filter-categorias-servicios').show();
        } else if (tipoActivo === 'partes') {
            $('#filter-categorias-partes').show();
            $('#filter-categorias-servicios').hide();
        } else if (tipoActivo === 'servicios') {
            $('#filter-categorias-partes').hide();
            $('#filter-categorias-servicios').show();
        }
    }
    
    function manejarBusquedaEnTiempoReal() {
        const query = $(this).val().trim();
        clearTimeout(searchTimeout);
        
        if (query.length >= 2) {
            searchTimeout = setTimeout(() => {
                ejecutarBusqueda();
            }, SEARCH_DELAY);
        } else if (query.length === 0) {
            mostrarMensajeInicial();
        }
    }
    
    function manejarEnterBusqueda(e) {
        if (e.which === 13) {
            e.preventDefault();
            ejecutarBusqueda();
        }
    }
    
    function ejecutarBusqueda() {
        const query = $('#search-items').val().trim();
        
        if (!query) {
            mostrarMensajeInicial();
            return;
        }
        
        mostrarCargandoResultados();
        realizarBusqueda(query);
    }
    
    function mostrarCargandoResultados() {
        $('#search-results').html(`
            <div class="d-flex justify-content-center align-items-center" style="min-height: 300px;">
                <div class="text-center">
                    <div class="spinner-border text-primary mb-3" role="status">
                        <span class="visually-hidden">Buscando...</span>
                    </div>
                    <h5>Buscando productos...</h5>
                    <p class="text-muted">Por favor espere</p>
                </div>
            </div>
        `);
    }
    
    function realizarBusqueda(query) {
        // Por ahora mostrar un mensaje de ejemplo
        setTimeout(() => {
            $('#search-results').html(`
                <div class="text-center text-muted p-5">
                    <i class="fas fa-exclamation-circle fa-4x mb-3 text-warning"></i>
                    <h5>Función en desarrollo</h5>
                    <p>La búsqueda de productos se implementará cuando los endpoints estén listos.</p>
                    <p class="small">Query: "${query}" | Tipo: ${tipoActivo}</p>
                    <button class="btn btn-outline-primary btn-sm" onclick="$('#search-items').val('').trigger('input')">
                        Limpiar búsqueda
                    </button>
                </div>
            `);
        }, 1000);
    }
    
    function filtrarPorCategoriaParte() {
        selectedCategoriaParteId = $(this).data('id') || '';
        const categoriaTexto = $(this).text();
        $('#filter-categorias-partes .dropdown-toggle').html(`<i class="fas fa-filter me-1"></i>${categoriaTexto}`);
        
        const query = $('#search-items').val().trim();
        if (query) {
            ejecutarBusqueda();
        }
        mostrarFiltrosActivos();
    }
    
    function filtrarPorCategoriaServicio() {
        selectedCategoriaServicioId = $(this).data('id') || '';
        const categoriaTexto = $(this).text();
        $('#filter-categorias-servicios .dropdown-toggle').html(`<i class="fas fa-filter me-1"></i>${categoriaTexto}`);
        
        const query = $('#search-items').val().trim();
        if (query) {
            ejecutarBusqueda();
        }
        mostrarFiltrosActivos();
    }
    
    function mostrarFiltrosActivos() {
        const hayFiltros = selectedCategoriaParteId || selectedCategoriaServicioId;
        $('#active-filters').toggleClass('d-none', !hayFiltros);
    }
    
    // =============================================
    // FUNCIONES DE ITEMS
    // =============================================
    
    function seleccionarItem() {
        const $card = $(this);
        const itemData = {
            id: $card.data('id') || 'demo-' + Date.now(),
            tipo: $card.data('tipo') || 'parte',
            nombre: $card.data('nombre') || $card.find('.card-title').text() || 'Producto Demo',
            codigo: $card.data('codigo') || 'DEMO-001',
            precio: parseFloat($card.data('precio')) || 100.00,
            moneda: $card.data('moneda') || 'SOL',
            unidad: $card.data('unidad') || 'UND'
        };
        
        abrirModalAgregarItem(itemData);
    }
    
    function abrirModalAgregarItem(itemData) {
        $('#item-id').val(itemData.id);
        $('#item-tipo').val(itemData.tipo);
        $('#item-nombre').val(itemData.nombre);
        $('#item-codigo').val(itemData.codigo);
        $('#item-precio').val(itemData.precio.toFixed(2));
        
        const titulo = itemData.tipo === 'parte' ? 'Agregar Parte' : 'Agregar Servicio';
        $('#modal-item-title').html(`<i class="fas fa-plus me-2"></i>${titulo}`);
        
        const simboloMoneda = obtenerSimboloMoneda(itemData.moneda);
        $('#span-moneda').text(simboloMoneda);
        
        if (itemData.tipo === 'parte') {
            $('#stock-container').show();
            $('#item-stock').val('10'); // Demo
        } else {
            $('#stock-container').hide();
        }
        
        $('#item-cantidad').val(1);
        $('#item-descuento').val(0);
        $('#descuento-valor').text('0%');
        
        actualizarResumenModal();
        $('#agregarItemModal').modal('show');
    }
    
    function configurarEventosModalItem() {
        $('#form-agregar-item').off('submit').on('submit', agregarItemAVenta);
        $('#item-cantidad, #item-precio, #item-descuento').off('input').on('input', actualizarResumenModal);
        
        $('#agregarItemModal').on('shown.bs.modal', function() {
            actualizarResumenModal();
        });
    }
    
    function agregarItemAVenta(e) {
        e.preventDefault();
        
        const itemData = {
            id: $('#item-id').val(),
            tipo: $('#item-tipo').val(),
            nombre: $('#item-nombre').val(),
            codigo: $('#item-codigo').val(),
            cantidad: parseInt($('#item-cantidad').val()) || 1,
            precio: parseFloat($('#item-precio').val()) || 0,
            descuento: parseFloat($('#item-descuento').val()) || 0
        };
        
        if (!validarItemParaAgregar(itemData)) {
            return;
        }
        
        const existeIndex = itemsSeleccionados.findIndex(item => 
            item.id === itemData.id && item.tipo === itemData.tipo
        );
        
        if (existeIndex >= 0) {
            itemsSeleccionados[existeIndex].cantidad += itemData.cantidad;
            itemsSeleccionados[existeIndex].total = calcularTotalItem(itemsSeleccionados[existeIndex]);
            mostrarNotificacion(`Cantidad actualizada para "${itemData.nombre}"`, 'success');
        } else {
            itemData.total = calcularTotalItem(itemData);
            itemsSeleccionados.push(itemData);
            mostrarNotificacion(`"${itemData.nombre}" agregado al carrito`, 'success');
        }
        
        actualizarListaItems();
        calcularTotales();
        verificarEstadoProcesar();
        $('#agregarItemModal').modal('hide');
    }
    
    function validarItemParaAgregar(itemData) {
        if (!itemData.nombre) {
            mostrarNotificacion('Error: Datos del item incompletos', 'error');
            return false;
        }
        
        if (itemData.cantidad <= 0) {
            mostrarNotificacion('La cantidad debe ser mayor a 0', 'error');
            return false;
        }
        
        if (itemData.precio <= 0) {
            mostrarNotificacion('El precio debe ser mayor a 0', 'error');
            return false;
        }
        
        return true;
    }
    
    function calcularTotalItem(item) {
        const subtotal = item.cantidad * item.precio;
        const descuentoMonto = subtotal * (item.descuento / 100);
        return subtotal - descuentoMonto;
    }
    
    function actualizarListaItems() {
        if (itemsSeleccionados.length === 0) {
            $('#items-placeholder').removeClass('d-none');
            $('#items-list').addClass('d-none');
            $('#item-count').text('0');
            return;
        }
        
        $('#items-placeholder').addClass('d-none');
        $('#items-list').removeClass('d-none');
        $('#item-count').text(itemsSeleccionados.length);
        
        let html = '';
        const simboloMoneda = obtenerSimboloMonedaActual();
        
        itemsSeleccionados.forEach((item, index) => {
            html += generarHTMLItemVenta(item, index, simboloMoneda);
        });
        
        $('#items-list').html(html);
    }
    
    function generarHTMLItemVenta(item, index, simboloMoneda) {
        const iconoTipo = item.tipo === 'parte' ? 'fas fa-cog text-info' : 'fas fa-tools text-success';
        const subtotal = item.cantidad * item.precio;
        const descuentoMonto = subtotal * (item.descuento / 100);
        
        return `
            <div class="item-row p-3 mb-2 border rounded">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div class="flex-grow-1">
                        <div class="d-flex align-items-center mb-1">
                            <i class="${iconoTipo} me-2"></i>
                            <h6 class="mb-0">${item.nombre}</h6>
                        </div>
                        <small class="text-muted">Código: ${item.codigo}</small>
                    </div>
                    <div class="d-flex">
                        <button type="button" class="btn btn-sm btn-outline-primary btn-edit-item me-1" 
                                data-index="${index}" title="Editar">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-danger btn-remove-item" 
                                data-index="${index}" title="Eliminar">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                
                <div class="row g-2 small">
                    <div class="col-4">
                        <span class="text-muted d-block">Cantidad</span>
                        <span class="fw-bold">${item.cantidad}</span>
                    </div>
                    <div class="col-4">
                        <span class="text-muted d-block">Precio Unit.</span>
                        <span>${simboloMoneda}${item.precio.toFixed(2)}</span>
                    </div>
                    <div class="col-4">
                        <span class="text-muted d-block">Total</span>
                        <span class="fw-bold text-primary">${simboloMoneda}${item.total.toFixed(2)}</span>
                    </div>
                </div>
                
                ${item.descuento > 0 ? `
                    <div class="mt-2">
                        <small class="text-success">
                            <i class="fas fa-tag me-1"></i>
                            Descuento: ${item.descuento}% (-${simboloMoneda}${descuentoMonto.toFixed(2)})
                        </small>
                    </div>
                ` : ''}
            </div>
        `;
    }
    
    function editarItem() {
        const index = $(this).data('index');
        const item = itemsSeleccionados[index];
        
        if (!item) {
            mostrarNotificacion('Error: Item no encontrado', 'error');
            return;
        }
        
        // Llenar modal con datos del item
        $('#item-id').val(item.id);
        $('#item-tipo').val(item.tipo);
        $('#item-nombre').val(item.nombre);
        $('#item-codigo').val(item.codigo);
        $('#item-cantidad').val(item.cantidad);
        $('#item-precio').val(item.precio.toFixed(2));
        $('#item-descuento').val(item.descuento);
        $('#descuento-valor').text(item.descuento + '%');
        
        const titulo = item.tipo === 'parte' ? 'Editar Parte' : 'Editar Servicio';
        $('#modal-item-title').html(`<i class="fas fa-edit me-2"></i>${titulo}`);
        
        const simboloMoneda = obtenerSimboloMonedaActual();
        $('#span-moneda').text(simboloMoneda);
        
        if (item.tipo === 'parte') {
            $('#stock-container').show();
            $('#item-stock').val('10'); // Demo
        } else {
            $('#stock-container').hide();
        }
        
        // Remover item temporalmente
        itemsSeleccionados.splice(index, 1);
        actualizarListaItems();
        calcularTotales();
        verificarEstadoProcesar();
        
        actualizarResumenModal();
        $('#agregarItemModal').modal('show');
    }
    
    function removerItem() {
        const index = $(this).data('index');
        const item = itemsSeleccionados[index];
        
        if (!item) {
            mostrarNotificacion('Error: Item no encontrado', 'error');
            return;
        }
        
        if (confirm(`¿Está seguro de eliminar "${item.nombre}" del carrito?`)) {
            itemsSeleccionados.splice(index, 1);
            actualizarListaItems();
            calcularTotales();
            verificarEstadoProcesar();
            mostrarNotificacion('Item eliminado del carrito', 'info');
        }
    }
    
    function calcularTotales() {
        if (itemsSeleccionados.length === 0) {
            const simboloMoneda = obtenerSimboloMonedaActual();
            $('#subtotal').text(`${simboloMoneda} 0.00`);
            $('#igv').text(`${simboloMoneda} 0.00`);
            $('#total').text(`${simboloMoneda} 0.00`);
            $('#abono-info').addClass('d-none');
            return;
        }
        
        let subtotal = 0;
        itemsSeleccionados.forEach(item => {
            subtotal += item.total;
        });
        
        const igv = subtotal * 0.18;
        const total = subtotal + igv;
        
        const simboloMoneda = obtenerSimboloMonedaActual();
        $('#subtotal').text(`${simboloMoneda} ${subtotal.toFixed(2)}`);
        $('#igv').text(`${simboloMoneda} ${igv.toFixed(2)}`);
        $('#total').text(`${simboloMoneda} ${total.toFixed(2)}`);
        
        calcularInfoAbono(total, simboloMoneda);
    }
    
    function calcularInfoAbono(total, simboloMoneda) {
        if (porcentajeAbono < 100) {
            const abonoMonto = total * (porcentajeAbono / 100);
            const saldoPendiente = total - abonoMonto;
            
            $('#abono-monto').text(`${simboloMoneda} ${abonoMonto.toFixed(2)}`);
            $('#saldo-pendiente').text(`${simboloMoneda} ${saldoPendiente.toFixed(2)}`);
            $('#abono-info').removeClass('d-none');
        } else {
            $('#abono-info').addClass('d-none');
        }
    }
    
    // =============================================
    // FUNCIONES DE CLIENTES
    // =============================================
    
    function configurarEventosCliente() {
        $('#cliente-search').off('input').on('input', function() {
            const query = $(this).val().trim();
            clearTimeout(clienteSearchTimeout);
            
            if (query.length >= 2) {
                clienteSearchTimeout = setTimeout(() => {
                    buscarClientes(query);
                }, 300);
            } else if (query.length === 0) {
                cargarClientesRecientes();
            }
        });
        
        $('#btn-search-cliente').off('click').on('click', function() {
            const query = $('#cliente-search').val().trim();
            if (query.length >= 2) {
                buscarClientes(query);
            } else {
                mostrarNotificacion('Ingrese al menos 2 caracteres para buscar', 'warning');
            }
        });
        
        $('#form-nuevo-cliente').off('submit').on('submit', crearNuevoCliente);
        $('input[name="tipo_cliente"]').off('change').on('change', toggleTipoCliente);
        $('#btn-remove-cliente').off('click').on('click', removerCliente);
        
        $('#clienteModal').off('show.bs.modal').on('show.bs.modal', function() {
            limpiarFormularioCliente();
            cargarClientesRecientes();
        });
        
        configurarValidacionesCliente();
    }
    
    function buscarClientes(query) {
        mostrarCargandoClientes();
        
        // Simulación de búsqueda
        setTimeout(() => {
            const clientesDemo = [
                {
                    id: 1,
                    nombre: 'Juan Pérez García',
                    documento: '12345678',
                    tipo: 'natural',
                    telefono: '999 888 777',
                    correo: 'juan@email.com'
                },
                {
                    id: 2,
                    nombre: 'Empresa ABC S.A.C.',
                    documento: '20123456789',
                    tipo: 'juridico',
                    telefono: '01 234 5678',
                    correo: 'info@abc.com'
                }
            ];
            
            mostrarResultadosClientes(clientesDemo, query);
        }, 1000);
    }
    
    function cargarClientesRecientes() {
        mostrarCargandoClientes();
        setTimeout(() => {
            buscarClientes('');
        }, 500);
    }
    
    function mostrarCargandoClientes() {
        $('#cliente-results').html(`
            <tr>
                <td colspan="5" class="text-center py-4">
                    <div class="spinner-border spinner-border-sm text-primary me-2" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                    Buscando clientes...
                </td>
            </tr>
        `);
    }
    
    function mostrarResultadosClientes(clientes, query = '') {
        if (!clientes || clientes.length === 0) {
            const mensaje = query ? 
                `No se encontraron clientes que coincidan con "${query}"` : 
                'No hay clientes registrados';
                
            $('#cliente-results').html(`
                <tr>
                    <td colspan="5" class="text-center py-4 text-muted">
                        <i class="fas fa-user-slash fa-2x mb-2"></i>
                        <br>${mensaje}
                    </td>
                </tr>
            `);
            return;
        }
        
        let html = '';
        clientes.forEach(cliente => {
            const tipoClase = cliente.tipo === 'natural' ? 'bg-info' : 'bg-warning';
            const tipoTexto = cliente.tipo === 'natural' ? 'Persona' : 'Empresa';
            
            html += `
                <tr class="cliente-row">
                    <td>
                        <strong class="text-primary">${cliente.documento}</strong>
                    </td>
                    <td>
                        <strong>${cliente.nombre}</strong>
                        ${cliente.correo ? `<br><small class="text-muted"><i class="fas fa-envelope me-1"></i>${cliente.correo}</small>` : ''}
                    </td>
                    <td>
                        <span class="badge ${tipoClase}">${tipoTexto}</span>
                    </td>
                    <td>
                        ${cliente.telefono ? `<i class="fas fa-phone text-success me-1"></i>${cliente.telefono}` : '<span class="text-muted">Sin teléfono</span>'}
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-success btn-select-cliente" 
                            data-id="${cliente.id}" 
                            data-nombre="${cliente.nombre}" 
                            data-documento="${cliente.documento}"
                            title="Seleccionar cliente">
                            <i class="fas fa-check"></i>
                        </button>
                    </td>
                </tr>
            `;
        });
        
        $('#cliente-results').html(html);
    }
    
    function seleccionarCliente() {
        const id = $(this).data('id');
        const nombre = $(this).data('nombre');
        const documento = $(this).data('documento');
        
        $('#cliente-id').val(id);
        $('.nombre-cliente').text(nombre);
        $('.documento-cliente').text(`DOC: ${documento}`);
        
        $('#cliente-placeholder').addClass('d-none');
        $('#cliente-seleccionado').removeClass('d-none');
        
        $('#clienteModal').modal('hide');
        mostrarNotificacion(`Cliente "${nombre}" seleccionado correctamente`, 'success');
        verificarEstadoProcesar();
    }
    
    function removerCliente() {
        if (confirm('¿Está seguro de remover el cliente seleccionado?')) {
            $('#cliente-id').val('');
            $('#cliente-seleccionado').addClass('d-none');
            $('#cliente-placeholder').removeClass('d-none');
            
            mostrarNotificacion('Cliente removido', 'info');
            verificarEstadoProcesar();
        }
    }
    
    function crearNuevoCliente(e) {
        e.preventDefault();
        
        if (!validarFormularioCompleto()) {
            return;
        }
        
        const $submitBtn = $('#form-nuevo-cliente button[type="submit"]');
        const originalText = $submitBtn.html();
        
        $submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Creando...');
        
        // Simulación de creación
        setTimeout(() => {
            const tipoCliente = $('input[name="tipo_cliente"]:checked').val();
            let nombre = '';
            
            if (tipoCliente === 'natural') {
                nombre = `${$('#nombres').val()} ${$('#apellido_paterno').val()} ${$('#apellido_materno').val()}`.trim();
            } else {
                nombre = $('#razon_social').val();
            }
            
            const clienteId = Date.now();
            const documento = $('#documento_identidad').val();
            
            $('#cliente-id').val(clienteId);
            $('.nombre-cliente').text(nombre);
            $('.documento-cliente').text(`DOC: ${documento}`);
            
            $('#cliente-placeholder').addClass('d-none');
            $('#cliente-seleccionado').removeClass('d-none');
            
            $('#clienteModal').modal('hide');
            limpiarFormularioCliente();
            
            mostrarNotificacion(`Cliente "${nombre}" creado y seleccionado`, 'success');
            verificarEstadoProcesar();
            
            $submitBtn.prop('disabled', false).html(originalText);
        }, 2000);
    }
    
    function toggleTipoCliente() {
        const tipoNatural = $('#tipo-natural').is(':checked');
        
        if (tipoNatural) {
            $('#datos-natural').removeClass('d-none');
            $('#datos-juridico').addClass('d-none');
            $('#nombres, #apellido_paterno').prop('required', true);
            $('#razon_social').prop('required', false);
        } else {
            $('#datos-natural').addClass('d-none');
            $('#datos-juridico').removeClass('d-none');
            $('#nombres, #apellido_paterno').prop('required', false);
            $('#razon_social').prop('required', true);
        }
    }
    
    function limpiarFormularioCliente() {
        $('#form-nuevo-cliente')[0].reset();
        $('#tipo-natural').prop('checked', true);
        toggleTipoCliente();
        $('#form-nuevo-cliente .is-invalid').removeClass('is-invalid');
        $('#form-nuevo-cliente .is-valid').removeClass('is-valid');
    }
    
    function configurarValidacionesCliente() {
        $('#documento_identidad').off('input').on('input', function() {
            const valor = $(this).val().replace(/[^0-9A-Za-z]/g, '');
            $(this).val(valor.toUpperCase());
            
            const tipoCliente = $('input[name="tipo_cliente"]:checked').val();
            let esValido = false;
            
            if (tipoCliente === 'natural') {
                esValido = /^[0-9]{8}$/.test(valor) || /^[A-Z0-9]{9,12}$/.test(valor);
            } else {
                esValido = /^[0-9]{11}$/.test(valor);
            }
            
            toggleValidationClass(this, esValido && valor.length > 0);
        });
        
        $('#nombres, #apellido_paterno, #apellido_materno, #razon_social').off('input').on('input', function() {
            let valor = $(this).val().replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
            valor = valor.replace(/\b\w+/g, function(txt) {
                return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
            });
            $(this).val(valor);
            
            const esRequerido = $(this).prop('required');
            const esValido = !esRequerido || (valor.trim().length >= 2);
            toggleValidationClass(this, esValido);
        });
        
        $('#telefono').off('input').on('input', function() {
            let valor = $(this).val().replace(/[^0-9]/g, '');
            
            if (valor.length > 0) {
                if (valor.length <= 3) {
                    valor = valor;
                } else if (valor.length <= 6) {
                    valor = valor.substring(0, 3) + ' ' + valor.substring(3);
                } else {
                    valor = valor.substring(0, 3) + ' ' + valor.substring(3, 6) + ' ' + valor.substring(6, 9);
                }
            }
            
            $(this).val(valor);
            
            const numeroLimpio = valor.replace(/\s/g, '');
            const esValido = numeroLimpio.length === 0 || (numeroLimpio.length === 9 && /^9/.test(numeroLimpio));
            toggleValidationClass(this, esValido);
        });
        
        $('#correo').off('input').on('input', function() {
            const valor = $(this).val().toLowerCase();
            $(this).val(valor);
            
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            const esValido = valor.length === 0 || emailRegex.test(valor);
            toggleValidationClass(this, esValido);
        });
    }
    
    function toggleValidationClass(elemento, esValido) {
        const $elemento = $(elemento);
        
        if (esValido) {
            $elemento.removeClass('is-invalid').addClass('is-valid');
        } else {
            $elemento.removeClass('is-valid').addClass('is-invalid');
        }
    }
    
    function validarFormularioCompleto() {
        let esValido = true;
        const tipoCliente = $('input[name="tipo_cliente"]:checked').val();
        
        const documento = $('#documento_identidad').val().trim();
        if (!documento) {
            toggleValidationClass('#documento_identidad', false);
            esValido = false;
        }
        
        if (tipoCliente === 'natural') {
            const nombres = $('#nombres').val().trim();
            const apellidoPaterno = $('#apellido_paterno').val().trim();
            
            if (!nombres || nombres.length < 2) {
                toggleValidationClass('#nombres', false);
                esValido = false;
            }
            
            if (!apellidoPaterno || apellidoPaterno.length < 2) {
                toggleValidationClass('#apellido_paterno', false);
                esValido = false;
            }
        } else {
            const razonSocial = $('#razon_social').val().trim();
            
            if (!razonSocial || razonSocial.length < 3) {
                toggleValidationClass('#razon_social', false);
                esValido = false;
            }
        }
        
        return esValido;
    }
    
    // =============================================
    // FUNCIONES DE CONFIGURACIÓN
    // =============================================
    
    function toggleGenerarRequerimiento() {
        generarRequerimiento = $(this).is(':checked');
        mostrarNotificacion(
            generarRequerimiento ? 
            'Venta sin stock habilitada - Se generarán requerimientos automáticos' : 
            'Venta sin stock deshabilitada',
            'info'
        );
    }
    
    function actualizarPorcentajeAbono() {
        porcentajeAbono = parseInt($(this).val());
        $('#porcentaje-abono-valor').text(porcentajeAbono + '%');
        calcularTotales();
    }
    
    // =============================================
    // FUNCIONES DE PROCESAMIENTO
    // =============================================
    
    function cancelarVenta() {
        if (itemsSeleccionados.length > 0 || $('#cliente-id').val()) {
            if (confirm('¿Está seguro de cancelar la venta? Se perderán todos los datos registrados.')) {
                resetearVenta();
            }
        } else {
            resetearVenta();
        }
    }
    
    function procesarVenta() {
        if (!validarDatosVenta()) {
            return;
        }
        
        if (confirm('¿Está seguro de procesar esta venta?')) {
            enviarVenta();
        }
    }
    
    function validarDatosVenta() {
        if (!$('#cliente-id').val()) {
            mostrarNotificacion('Debe seleccionar un cliente para la venta', 'error');
            return false;
        }
        
        if (itemsSeleccionados.length === 0) {
            mostrarNotificacion('Debe agregar al menos un ítem a la venta', 'error');
            return false;
        }
        
        return true;
    }
    
    function enviarVenta() {
        const $btnProcesar = $('#btn-procesar');
        const textoOriginal = $btnProcesar.html();
        
        $btnProcesar.prop('disabled', true)
                    .html('<i class="fas fa-spinner fa-spin me-2"></i>Procesando...');
        
        // Simulación de envío
        setTimeout(() => {
            const ventaId = Date.now();
            const codigoCotizacion = `COT-${String(ventaId).slice(-6)}`;
            
            mostrarModalExito({
                success: true,
                id: ventaId,
                codigo: codigoCotizacion,
                requerimientos: generarRequerimiento ? [
                    { descripcion: 'Repuesto ABC', cantidad: 2 }
                ] : []
            });
            
            $btnProcesar.prop('disabled', false).html(textoOriginal);
        }, 3000);
    }
    
    function mostrarModalExito(response) {
        $('#cotizacion-codigo').text(response.codigo || 'N/A');
        
        if (response.id) {
            $('#btn-ver-cotizacion').attr('href', `/admin/ventas/cotizaciones/${response.id}`);
        }
        
        if (response.requerimientos && response.requerimientos.length > 0) {
            let requerimientosHTML = `
                <div class="alert alert-warning mt-3">
                    <h6><i class="fas fa-exclamation-triangle me-2"></i>Requerimientos Generados</h6>
                    <p class="mb-2">Se generaron los siguientes requerimientos automáticos:</p>
                    <ul class="mb-0">
            `;
            
            response.requerimientos.forEach(req => {
                requerimientosHTML += `<li>${req.descripcion} - Cantidad: ${req.cantidad}</li>`;
            });
            
            requerimientosHTML += '</ul></div>';
            $('#requerimientos-info').html(requerimientosHTML);
        } else {
            $('#requerimientos-info').empty();
        }
        
        $('#successModal').modal('show');
    }
    
    function resetearVenta() {
        $('#cliente-id').val('');
        $('#cliente-seleccionado').addClass('d-none');
        $('#cliente-placeholder').removeClass('d-none');
        
        itemsSeleccionados = [];
        actualizarListaItems();
        calcularTotales();
        verificarEstadoProcesar();
        
        $('#search-items').val('');
        mostrarMensajeInicial();
        
        $('#almacen').val($('#almacen option:first').val());
        $('#moneda').val('Soles');
        $('#condicion').val('Nuevo');
        $('#forma-pago').val('Contado');
        $('#generar-requerimiento').prop('checked', false);
        $('#porcentaje-abono').val(100);
        $('#porcentaje-abono-valor').text('100%');
        
        generarRequerimiento = false;
        porcentajeAbono = 100;
        selectedCategoriaParteId = '';
        selectedCategoriaServicioId = '';
        
        mostrarNotificacion('Venta cancelada', 'info');
    }
    
    // =============================================
    // FUNCIONES DE ITEMS POPULARES
    // =============================================
    
    function cargarItemsPopulares() {
        // Simulación de items populares
        const itemsDemo = [
            {
                id: 'pop-1',
                tipo: 'parte',
                nombre: 'Filtro de Aceite',
                codigo: 'FLT-001',
                precio: 25.50,
                moneda: 'SOL'
            },
            {
                id: 'pop-2',
                tipo: 'parte',
                nombre: 'Pastillas de Freno',
                codigo: 'PAD-002',
                precio: 85.00,
                moneda: 'SOL'
            },
            {
                id: 'pop-3',
                tipo: 'servicio',
                nombre: 'Cambio de Aceite',
                codigo: 'SRV-001',
                precio: 45.00,
                moneda: 'SOL'
            },
            {
                id: 'pop-4',
                tipo: 'servicio',
                nombre: 'Revisión General',
                codigo: 'SRV-002',
                precio: 150.00,
                moneda: 'SOL'
            }
        ];
        
        mostrarItemsPopulares(itemsDemo);
    }
    
    function mostrarItemsPopulares(items) {
        let html = '';
        
        items.slice(0, 8).forEach(item => {
            const iconoTipo = item.tipo === 'parte' ? 'fas fa-cog' : 'fas fa-tools';
            const colorIcono = item.tipo === 'parte' ? 'text-info' : 'text-success';
            const simboloMoneda = obtenerSimboloMoneda(item.moneda);
            const precio = parseFloat(item.precio || 0).toFixed(2);
            
            html += `
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm popular-item cursor-pointer" 
                         data-id="${item.id}" 
                         data-tipo="${item.tipo}" 
                         data-nombre="${item.nombre}" 
                         data-codigo="${item.codigo}" 
                         data-precio="${item.precio}"
                         data-moneda="${item.moneda}" 
                         data-unidad="UND">
                        <div class="card-body text-center p-3">
                            <div class="mb-3">
                                <i class="${iconoTipo} fa-2x ${colorIcono}"></i>
                            </div>
                            <h6 class="card-title mb-2" style="font-size: 0.9rem;">${item.nombre}</h6>
                            <p class="card-text text-primary fw-bold mb-1">${simboloMoneda}${precio}</p>
                            <small class="text-muted">Cód: ${item.codigo}</small>
                        </div>
                    </div>
                </div>
            `;
        });
        
        $('#popular-items').html(html);
    }
    
    // =============================================
    // FUNCIONES AUXILIARES
    // =============================================
    
    function obtenerSimboloMoneda(moneda) {
        if (!moneda || moneda === 'SOL' || moneda === 'Soles') {
            return 'S/';
        } else if (moneda === 'USD' || moneda === 'Dólares') {
            return 'US{{-- resources/views/admin/ventas/pos/partials/scripts.blade.php --}}
<script>
/**
 * Sistema de Punto de Venta - JavaScript Principal
 * Archivo separado para facilitar el mantenimiento
 */

// Incluir meta token CSRF si no existe
if (!$('meta[name="csrf-token"]').length) {
    $('head').append('<meta name="csrf-token" content="{{ csrf_token() }}">');
}

$(document).ready(function() {
    // Configuración global
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    // Variables globales
    let selectedCategoriaParteId = '';
    let selectedCategoriaServicioId = '';
    let itemsSeleccionados = [];
    let tipoActivo = 'todo';
    let generarRequerimiento = false;
    let porcentajeAbono = 100;
    let searchTimeout;
    let clienteSearchTimeout;
    
    const SEARCH_DELAY = 300;
    
    // Inicialización
    init();
    
    function init() {
        configurarEventos();
        cargarItemsPopulares();
        actualizarReloj();
        setInterval(actualizarReloj, 60000);
        
        // Mostrar mensaje inicial
        mostrarMensajeInicial();
    }
    
    function mostrarMensajeInicial() {
        $('#search-results').html(`
            <div class="d-flex justify-content-center align-items-center" style="min-height: 300px;">
                <div class="text-center text-muted">
                    <i class="fas fa-search fa-4x mb-3 text-primary opacity-50"></i>
                    <h5>Busque productos o servicios</h5>
                    <p>Use la barra de búsqueda para encontrar items o navegue por categorías</p>
                </div>
            </div>
        `);
    }
    
    function configurarEventos() {
        // Eventos de filtro por tipo
        $('#btn-todo, #btn-partes, #btn-servicios').off('click').on('click', cambiarTipoFiltro);
        
        // Eventos de búsqueda
        $('#search-items').off('input').on('input', manejarBusquedaEnTiempoReal);
        $('#search-items').off('keypress').on('keypress', manejarEnterBusqueda);
        $('#btn-search').off('click').on('click', ejecutarBusqueda);
        
        // Eventos de configuración
        $('#generar-requerimiento').off('change').on('change', toggleGenerarRequerimiento);
        $('#porcentaje-abono').off('input').on('input', actualizarPorcentajeAbono);
        $('#almacen, #moneda').off('change').on('change', function() {
            calcularTotales();
            cargarItemsPopulares();
        });
        
        // Botones de acción
        $('#btn-cancelar').off('click').on('click', cancelarVenta);
        $('#btn-procesar').off('click').on('click', procesarVenta);
        
        // Eventos de cliente
        configur;
        }
        return 'S/';
    }
    
    function obtenerSimboloMonedaActual() {
        const monedaSeleccionada = $('#moneda').val();
        return obtenerSimboloMoneda(monedaSeleccionada);
    }
    
    function verificarEstadoProcesar() {
        const tieneCliente = $('#cliente-id').val() !== '';
        const tieneItems = itemsSeleccionados && itemsSeleccionados.length > 0;
        
        $('#btn-procesar').prop('disabled', !(tieneCliente && tieneItems));
    }
    
    function mostrarNotificacion(mensaje, tipo = 'info') {
        const toastId = 'toast-' + Date.now();
        const iconos = {
            'success': 'fas fa-check-circle',
            'error': 'fas fa-exclamation-circle',
            'warning': 'fas fa-exclamation-triangle',
            'info': 'fas fa-info-circle'
        };
        
        const colores = {
            'success': 'success',
            'error': 'danger',
            'warning': 'warning',
            'info': 'info'
        };
        
        const toastHtml = `
            <div id="${toastId}" class="toast align-items-center text-white bg-${colores[tipo]} border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="${iconos[tipo]} me-2"></i>
                        ${mensaje}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        `;
        
        if ($('#toast-container').length === 0) {
            $('body').append('<div id="toast-container" class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1060;"></div>');
        }
        
        $('#toast-container').append(toastHtml);
        
        const toastElement = document.getElementById(toastId);
        const toast = new bootstrap.Toast(toastElement, {
            autohide: true,
            delay: tipo === 'error' ? 8000 : 5000
        });
        toast.show();
        
        toastElement.addEventListener('hidden.bs.toast', function() {
            $(this).remove();
        });
    }
    
    function actualizarReloj() {
        const ahora = new Date();
        const tiempo = ahora.toLocaleTimeString('es-PE', {
            hour: '2-digit',
            minute: '2-digit'
        });
        if ($('#current-time').length) {
            $('#current-time').text(tiempo);
        }
    }
    
    // Función global para actualizar el resumen del modal
    window.actualizarResumenModal = function() {
        const cantidad = parseInt($('#item-cantidad').val()) || 1;
        const precio = parseFloat($('#item-precio').val()) || 0;
        const descuento = parseFloat($('#item-descuento').val()) || 0;
        
        const subtotal = cantidad * precio;
        const descuentoMonto = subtotal * (descuento / 100);
        const total = subtotal - descuentoMonto;
        
        const moneda = $('#span-moneda').text();
        
        $('#modal-subtotal').text(`${moneda} ${subtotal.toFixed(2)}`);
        $('#modal-descuento').text(`${moneda} ${descuentoMonto.toFixed(2)}`);
        $('#modal-total').text(`${moneda} ${total.toFixed(2)}`);
        $('#descuento-valor').text(`${descuento}%`);
    };
    
    // Función global para cambiar cantidad desde botones
    window.cambiarCantidad = function(delta) {
        const cantidadInput = $('#item-cantidad');
        let cantidad = parseInt(cantidadInput.val()) || 1;
        cantidad = Math.max(1, cantidad + delta);
        
        // Validar stock para partes
        const tipo = $('#item-tipo').val();
        if (tipo === 'parte' && !generarRequerimiento) {
            const stock = parseInt($('#item-stock').val()) || 0;
            if (cantidad > stock) {
                cantidad = stock;
                mostrarNotificacion('Cantidad ajustada al stock disponible', 'warning');
            }
        }
        
        cantidadInput.val(cantidad);
        actualizarResumenModal();
    };
    
    // Función global para cargar items populares desde HTML
    window.cargarItemsPopulares = function() {
        cargarItemsPopulares();
    };
});
</script>{{-- resources/views/admin/ventas/pos/partials/scripts.blade.php --}}
<script>
/**
 * Sistema de Punto de Venta - JavaScript Principal
 * Archivo separado para facilitar el mantenimiento
 */

// Incluir meta token CSRF si no existe
if (!$('meta[name="csrf-token"]').length) {
    $('head').append('<meta name="csrf-token" content="{{ csrf_token() }}">');
}

$(document).ready(function() {
    // Configuración global
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    // Variables globales
    let selectedCategoriaParteId = '';
    let selectedCategoriaServicioId = '';
    let itemsSeleccionados = [];
    let tipoActivo = 'todo';
    let generarRequerimiento = false;
    let porcentajeAbono = 100;
    let searchTimeout;
    let clienteSearchTimeout;
    
    const SEARCH_DELAY = 300;
    
    // Inicialización
    init();
    
    function init() {
        configurarEventos();
        cargarItemsPopulares();
        actualizarReloj();
        setInterval(actualizarReloj, 60000);
        
        // Mostrar mensaje inicial
        mostrarMensajeInicial();
    }
    
    function mostrarMensajeInicial() {
        $('#search-results').html(`
            <div class="d-flex justify-content-center align-items-center" style="min-height: 300px;">
                <div class="text-center text-muted">
                    <i class="fas fa-search fa-4x mb-3 text-primary opacity-50"></i>
                    <h5>Busque productos o servicios</h5>
                    <p>Use la barra de búsqueda para encontrar items o navegue por categorías</p>
                </div>
            </div>
        `);
    }
    
function configurarEventos() {
    // Eventos de filtro por tipo
    $('#btn-todo, #btn-partes, #btn-servicios').off('click').on('click', cambiarTipoFiltro);
    
    // Eventos de búsqueda
    $('#search-items').off('input').on('input', manejarBusquedaEnTiempoReal);
    $('#search-items').off('keypress').on('keypress', manejarEnterBusqueda);
    $('#btn-search').off('click').on('click', ejecutarBusqueda);
    
    // Eventos de configuración
    $('#generar-requerimiento').off('change').on('change', toggleGenerarRequerimiento);
    $('#porcentaje-abono').off('input').on('input', actualizarPorcentajeAbono);
    $('#almacen, #moneda').off('change').on('change', function() {
        calcularTotales();
        cargarItemsPopulares();
    });
    
    // Botones de acción
    $('#btn-cancelar').off('click').on('click', cancelarVenta);
    $('#btn-procesar').off('click').on('click', procesarVenta);
    
    // Eventos de cliente
    configurarEventosCliente();
    
    // Eventos dinámicos
    configurarEventosDinamicos();
    
    // Eventos del modal de item
    configurarEventosModalItem();
}

function configurarEventosDinamicos() {
    $(document).off('click', '.item-card').on('click', '.item-card', seleccionarItem);
    $(document).off('click', '.popular-item').on('click', '.popular-item', seleccionarItem);
    $(document).off('click', '.btn-edit-item').on('click', '.btn-edit-item', editarItem);
    $(document).off('click', '.btn-remove-item').on('click', '.btn-remove-item', removerItem);
    $(document).off('click', '.btn-select-cliente').on('click', '.btn-select-cliente', seleccionarCliente);
    $(document).off('click', '.categoria-parte').on('click', '.categoria-parte', filtrarPorCategoriaParte);
    $(document).off('click', '.categoria-servicio').on('click', '.categoria-servicio', filtrarPorCategoriaServicio);
    $(document).off('click', '#btn-nueva-venta').on('click', '#btn-nueva-venta', function() {
        location.reload();
    });
}

// =============================================
// FUNCIONES DE BÚSQUEDA
// =============================================

function cambiarTipoFiltro() {
    $('#btn-todo, #btn-partes, #btn-servicios').removeClass('active');
    $(this).addClass('active');
    
    tipoActivo = $(this).attr('id').replace('btn-', '');
    mostrarFiltrosSegunTipo();
    
    const searchText = $('#search-items').val().trim();
    if (searchText) {
        ejecutarBusqueda();
    } else {
        mostrarMensajeInicial();
    }
}

function mostrarFiltrosSegunTipo() {
    if (tipoActivo === 'todo') {
        $('#filter-categorias-partes, #filter-categorias-servicios').show();
    } else if (tipoActivo === 'partes') {
        $('#filter-categorias-partes').show();
        $('#filter-categorias-servicios').hide();
    } else if (tipoActivo === 'servicios') {
        $('#filter-categorias-partes').hide();
        $('#filter-categorias-servicios').show();
    }
}

function manejarBusquedaEnTiempoReal() {
    const query = $(this).val().trim();
    clearTimeout(searchTimeout);
    
    if (query.length >= 2) {
        searchTimeout = setTimeout(() => {
            ejecutarBusqueda();
        }, SEARCH_DELAY);
    } else if (query.length === 0) {
        mostrarMensajeInicial();
    }
}

function manejarEnterBusqueda(e) {
    if (e.which === 13) {
        e.preventDefault();
        ejecutarBusqueda();
    }
}

function ejecutarBusqueda() {
    const query = $('#search-items').val().trim();
    
    if (!query) {
        mostrarMensajeInicial();
        return;
    }
    
    mostrarCargandoResultados();
    realizarBusqueda(query);
}

function mostrarCargandoResultados() {
    $('#search-results').html(`
        <div class="d-flex justify-content-center align-items-center" style="min-height: 300px;">
            <div class="text-center">
                <div class="spinner-border text-primary mb-3" role="status">
                    <span class="visually-hidden">Buscando...</span>
                </div>
                <h5>Buscando productos...</h5>
                <p class="text-muted">Por favor espere</p>
            </div>
        </div>
    `);
}

function realizarBusqueda(query) {
    let resultados = [];
    let solicitudesCompletadas = 0;
    let totalSolicitudes = 0;
    
    // Determinar qué tipos buscar
    const buscarPartes = tipoActivo === 'todo' || tipoActivo === 'partes';
    const buscarServicios = tipoActivo === 'todo' || tipoActivo === 'servicios';
    
    if (buscarPartes) totalSolicitudes++;
    if (buscarServicios) totalSolicitudes++;
    
    function verificarFinalizacion() {
        solicitudesCompletadas++;
        if (solicitudesCompletadas >= totalSolicitudes) {
            mostrarResultadosBusqueda(resultados, query);
        }
    }
    
    // Buscar partes
    if (buscarPartes) {
        $.ajax({
            url: '/admin/ventas/pos/buscar-partes',
            method: 'GET',
            data: {
                query: query,
                categoria_id: selectedCategoriaParteId,
                almacen_id: $('#almacen').val()
            },
            timeout: 10000,
            success: function(response) {
                if (response && Array.isArray(response)) {
                    const partes = response.map(item => ({
                        ...item,
                        tipo: 'parte'
                    }));
                    resultados = resultados.concat(partes);
                }
                verificarFinalizacion();
            },
            error: function(xhr, status, error) {
                console.error("Error al buscar partes:", error);
                verificarFinalizacion();
            }
        });
    }
    
    // Buscar servicios
    if (buscarServicios) {
        $.ajax({
            url: '/admin/ventas/pos/buscar-servicios',
            method: 'GET',
            data: {
                query: query,
                categoria_id: selectedCategoriaServicioId
            },
            timeout: 10000,
            success: function(response) {
                if (response && Array.isArray(response)) {
                    const servicios = response.map(item => ({
                        ...item,
                        tipo: 'servicio'
                    }));
                    resultados = resultados.concat(servicios);
                }
                verificarFinalizacion();
            },
            error: function(xhr, status, error) {
                console.error("Error al buscar servicios:", error);
                verificarFinalizacion();
            }
        });
    }
}

function mostrarResultadosBusqueda(items, query = '') {
    let html = '';
    
    if (!items || items.length === 0) {
        html = mostrarMensajeSinResultados(query);
    } else {
        html = generarHTMLResultados(items);
    }
    
    $('#search-results').html(html);
}

function mostrarMensajeSinResultados(query) {
    const mensaje = query ? 
        `No se encontraron resultados para "${query}"` : 
        'No hay productos disponibles';
        
    return `
        <div class="text-center text-muted p-5">
            <i class="fas fa-box-open fa-4x mb-3 opacity-50"></i>
            <h5>${mensaje}</h5>
            <p>Intente con otros términos de búsqueda o verifique los filtros aplicados</p>
            ${query ? '<button class="btn btn-outline-primary btn-sm" onclick="$(\'#search-items\').val(\'\').trigger(\'input\')">Limpiar búsqueda</button>' : ''}
        </div>
    `;
}

function generarHTMLResultados(items) {
    let html = '';
    
    if (tipoActivo === 'todo') {
        // Separar por tipo
        const partes = items.filter(item => item.tipo === 'parte');
        const servicios = items.filter(item => item.tipo === 'servicio');
        
        if (partes.length > 0) {
            html += '<h6 class="mb-3"><i class="fas fa-cogs me-2 text-info"></i>Partes y Repuestos</h6>';
            html += '<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3 mb-4">';
            partes.forEach(item => {
                html += generarCardItem(item);
            });
            html += '</div>';
        }
        
        if (servicios.length > 0) {
            html += '<h6 class="mb-3"><i class="fas fa-tools me-2 text-success"></i>Servicios</h6>';
            html += '<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">';
            servicios.forEach(item => {
                html += generarCardItem(item);
            });
            html += '</div>';
        }
    } else {
        html += '<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">';
        items.forEach(item => {
            html += generarCardItem(item);
        });
        html += '</div>';
    }
    
    return html;
}

function generarCardItem(item) {
    const badgeClass = item.tipo === 'parte' ? 'bg-info' : 'bg-success';
    const badgeText = item.tipo === 'parte' ? 'Parte' : 'Servicio';
    const iconoTipo = item.tipo === 'parte' ? 'fas fa-cog' : 'fas fa-tools';
    const simboloMoneda = obtenerSimboloMoneda(item.moneda);
    const precio = parseFloat(item.precio || 0).toFixed(2);
    
    return `
        <div class="col">
            <div class="card h-100 shadow-sm item-card cursor-pointer" 
                 data-id="${item.id}" 
                 data-tipo="${item.tipo}" 
                 data-nombre="${item.nombre || ''}" 
                 data-codigo="${item.codigo || ''}" 
                 data-precio="${item.precio || 0}"
                 data-moneda="${item.moneda || 'SOL'}" 
                 data-unidad="${item.unidad || 'UND'}"
                 data-categoria="${item.categoria || ''}">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h6 class="card-title mb-0 flex-grow-1">${item.nombre || 'Sin nombre'}</h6>
                        <span class="badge ${badgeClass} ms-2">${badgeText}</span>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <i class="${iconoTipo} text-primary me-2"></i>
                        <span class="price-badge">${simboloMoneda}${precio}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            <i class="fas fa-barcode me-1"></i>${item.codigo || 'Sin código'}
                        </small>
                        ${item.unidad ? `<small class="text-muted">${item.unidad}</small>` : ''}
                    </div>
                    ${item.categoria ? `<div class="mt-2"><span class="category-badge">${item.categoria}</span></div>` : ''}
                    ${item.tipo === 'parte' && item.stock !== undefined ? 
                        `<div class="mt-2">
                            <small class="badge badge-stock ${item.stock > 0 ? 'bg-success' : 'bg-danger'}">
                                Stock: ${item.stock}
                            </small>
                        </div>` : ''}
                </div>
            </div>
        </div>
    `;
}

function filtrarPorCategoriaParte() {
    selectedCategoriaParteId = $(this).data('id') || '';
    const categoriaTexto = $(this).text();
    $('#filter-categorias-partes .dropdown-toggle').html(`<i class="fas fa-filter me-1"></i>${categoriaTexto}`);
    
    const query = $('#search-items').val().trim();
    if (query) {
        ejecutarBusqueda();
    }
    mostrarFiltrosActivos();
}

function filtrarPorCategoriaServicio() {
    selectedCategoriaServicioId = $(this).data('id') || '';
    const categoriaTexto = $(this).text();
    $('#filter-categorias-servicios .dropdown-toggle').html(`<i class="fas fa-filter me-1"></i>${categoriaTexto}`);
    
    const query = $('#search-items').val().trim();
    if (query) {
        ejecutarBusqueda();
    }
    mostrarFiltrosActivos();
}

function mostrarFiltrosActivos() {
    const hayFiltros = selectedCategoriaParteId || selectedCategoriaServicioId;
    $('#active-filters').toggleClass('d-none', !hayFiltros);
}

// =============================================
// FUNCIONES DE ITEMS
// =============================================

function seleccionarItem() {
    const $card = $(this);
    const itemData = {
        id: $card.data('id') || 'demo-' + Date.now(),
        tipo: $card.data('tipo') || 'parte',
        nombre: $card.data('nombre') || $card.find('.card-title').text() || 'Producto Demo',
        codigo: $card.data('codigo') || 'DEMO-001',
        precio: parseFloat($card.data('precio')) || 100.00,
        moneda: $card.data('moneda') || 'SOL',
        unidad: $card.data('unidad') || 'UND'
    };
    
    abrirModalAgregarItem(itemData);
}

function abrirModalAgregarItem(itemData) {
    if (!itemData.id) {
        mostrarNotificacion('Error: Datos del item incompletos', 'error');
        return;
    }
    
    // Llenar campos del modal
    $('#item-id').val(itemData.id);
    $('#item-tipo').val(itemData.tipo);
    $('#item-nombre').val(itemData.nombre);
    $('#item-codigo').val(itemData.codigo);
    $('#item-precio').val(itemData.precio.toFixed(2));
    
    // Actualizar título del modal
    const titulo = itemData.tipo === 'parte' ? 'Agregar Parte' : 'Agregar Servicio';
    $('#modal-item-title').html(`<i class="fas fa-plus me-2"></i>${titulo}`);
    
    // Configurar símbolo de moneda
    const simboloMoneda = obtenerSimboloMoneda(itemData.moneda);
    $('#span-moneda').text(simboloMoneda);
    
    // Manejar stock para partes
    if (itemData.tipo === 'parte') {
        $('#stock-container').show();
        obtenerStockParte(itemData.id);
    } else {
        $('#stock-container').hide();
    }
    
    // Reiniciar valores
    $('#item-cantidad').val(1);
    $('#item-descuento').val(0);
    $('#descuento-valor').text('0%');
    
    // Calcular resumen inicial
    actualizarResumenModal();
    
    // Mostrar modal
    $('#agregarItemModal').modal('show');
}

function obtenerStockParte(parteId) {
    $('#item-stock').val('Cargando...');
    
    $.ajax({
        url: '/admin/ventas/pos/get-stock-parte',
        method: 'GET',
        data: {
            parte_id: parteId,
            almacen_id: $('#almacen').val()
        },
        success: function(response) {
            const stock = response.stock || 0;
            $('#item-stock').val(stock);
            
            // Validar cantidad según stock
            const cantidad = parseInt($('#item-cantidad').val());
            if (cantidad > stock) {
                $('#item-cantidad').val(Math.max(1, stock));
                actualizarResumenModal();
            }
        },
        error: function(xhr, status, error) {
            console.error("Error al obtener stock:", error);
            $('#item-stock').val('No disponible');
        }
    });
}

function configurarEventosModalItem() {
    $('#form-agregar-item').off('submit').on('submit', agregarItemAVenta);
    $('#item-cantidad, #item-precio, #item-descuento').off('input').on('input', actualizarResumenModal);
    
    $('#agregarItemModal').on('shown.bs.modal', function() {
        actualizarResumenModal();
    });
    
    // Validación de cantidad
    $('#item-cantidad').on('input', function() {
        let cantidad = parseInt($(this).val()) || 1;
        
        // Validar mínimo
        if (cantidad < 1) {
            cantidad = 1;
            $(this).val(cantidad);
        }
        
        // Validar stock para partes
        const tipo = $('#item-tipo').val();
        if (tipo === 'parte') {
            const stock = parseInt($('#item-stock').val()) || 0;
            if (cantidad > stock && !generarRequerimiento) {
                cantidad = stock;
                $(this).val(cantidad);
                mostrarNotificacion('Cantidad ajustada al stock disponible', 'warning');
            }
        }
        
        actualizarResumenModal();
    });
    
    // Validación de precio
    $('#item-precio').on('input', function() {
        let precio = parseFloat($(this).val()) || 0;
        if (precio < 0) {
            precio = 0;
            $(this).val(precio.toFixed(2));
        }
        actualizarResumenModal();
    });
    
    // Actualización de descuento
    $('#item-descuento').on('input', function() {
        const descuento = $(this).val();
        $('#descuento-valor').text(descuento + '%');
        actualizarResumenModal();
    });
}

function agregarItemAVenta(e) {
    e.preventDefault();
    
    const itemData = {
        id: $('#item-id').val(),
        tipo: $('#item-tipo').val(),
        nombre: $('#item-nombre').val(),
        codigo: $('#item-codigo').val(),
        cantidad: parseInt($('#item-cantidad').val()) || 1,
        precio: parseFloat($('#item-precio').val()) || 0,
        descuento: parseFloat($('#item-descuento').val()) || 0
    };
    
    // Validaciones
    if (!validarItemParaAgregar(itemData)) {
        return;
    }
    
    // Verificar si el item ya existe en la venta
    const existeIndex = itemsSeleccionados.findIndex(item => 
        item.id === itemData.id && item.tipo === itemData.tipo
    );
    
    if (existeIndex >= 0) {
        // Actualizar item existente
        itemsSeleccionados[existeIndex].cantidad += itemData.cantidad;
        itemsSeleccionados[existeIndex].total = calcularTotalItem(itemsSeleccionados[existeIndex]);
        mostrarNotificacion(`Cantidad actualizada para "${itemData.nombre}"`, 'success');
    } else {
        // Agregar nuevo item
        itemData.total = calcularTotalItem(itemData);
        itemsSeleccionados.push(itemData);
        mostrarNotificacion(`"${itemData.nombre}" agregado al carrito`, 'success');
    }
    
    // Actualizar UI
    actualizarListaItems();
    calcularTotales();
    verificarEstadoProcesar();
    
    // Cerrar modal
    $('#agregarItemModal').modal('hide');
}

function validarItemParaAgregar(itemData) {
    if (!itemData.id || !itemData.nombre) {
        mostrarNotificacion('Error: Datos del item incompletos', 'error');
        return false;
    }
    
    if (itemData.cantidad <= 0) {
        mostrarNotificacion('La cantidad debe ser mayor a 0', 'error');
        return false;
    }
    
    if (itemData.precio <= 0) {
        mostrarNotificacion('El precio debe ser mayor a 0', 'error');
        return false;
    }
    
    // Validar stock para partes
    if (itemData.tipo === 'parte' && !generarRequerimiento) {
        const stock = parseInt($('#item-stock').val()) || 0;
        if (itemData.cantidad > stock) {
            mostrarNotificacion('La cantidad supera el stock disponible', 'error');
            return false;
        }
    }
    
    return true;
}

function calcularTotalItem(item) {
    const subtotal = item.cantidad * item.precio;
    const descuentoMonto = subtotal * (item.descuento / 100);
    return subtotal - descuentoMonto;
}

function actualizarListaItems() {
    if (itemsSeleccionados.length === 0) {
        $('#items-placeholder').removeClass('d-none');
        $('#items-list').addClass('d-none');
        $('#item-count').text('0');
        return;
    }
    
    $('#items-placeholder').addClass('d-none');
    $('#items-list').removeClass('d-none');
    $('#item-count').text(itemsSeleccionados.length);
    
    let html = '';
    const simboloMoneda = obtenerSimboloMonedaActual();
    
    itemsSeleccionados.forEach((item, index) => {
        html += generarHTMLItemVenta(item, index, simboloMoneda);
    });
    
    $('#items-list').html(html);
}

function generarHTMLItemVenta(item, index, simboloMoneda) {
    const iconoTipo = item.tipo === 'parte' ? 'fas fa-cog text-info' : 'fas fa-tools text-success';
    const subtotal = item.cantidad * item.precio;
    const descuentoMonto = subtotal * (item.descuento / 100);
    
    return `
        <div class="item-row p-3 mb-2 border rounded">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div class="flex-grow-1">
                    <div class="d-flex align-items-center mb-1">
                        <i class="${iconoTipo} me-2"></i>
                        <h6 class="mb-0">${item.nombre}</h6>
                    </div>
                    <small class="text-muted">Código: ${item.codigo}</small>
                </div>
                <div class="d-flex">
                    <button type="button" class="btn btn-sm btn-outline-primary btn-edit-item me-1" 
                            data-index="${index}" title="Editar">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-danger btn-remove-item" 
                            data-index="${index}" title="Eliminar">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
            
            <div class="row g-2 small">
                <div class="col-4">
                    <span class="text-muted d-block">Cantidad</span>
                    <span class="fw-bold">${item.cantidad}</span>
                </div>
                <div class="col-4">
                    <span class="text-muted d-block">Precio Unit.</span>
                    <span>${simboloMoneda}${item.precio.toFixed(2)}</span>
                </div>
                <div class="col-4">
                    <span class="text-muted d-block">Total</span>
                    <span class="fw-bold text-primary">${simboloMoneda}${item.total.toFixed(2)}</span>
                </div>
            </div>
            
            ${item.descuento > 0 ? `
                <div class="mt-2">
                    <small class="text-success">
                        <i class="fas fa-tag me-1"></i>
                        Descuento: ${item.descuento}% (-${simboloMoneda}${descuentoMonto.toFixed(2)})
                    </small>
                </div>
            ` : ''}
        </div>
    `;
}

function editarItem() {
    const index = $(this).data('index');
    const item = itemsSeleccionados[index];
    
    if (!item) {
        mostrarNotificacion('Error: Item no encontrado', 'error');
        return;
    }
    
    // Llenar modal con datos del item
    $('#item-id').val(item.id);
    $('#item-tipo').val(item.tipo);
    $('#item-nombre').val(item.nombre);
    $('#item-codigo').val(item.codigo);
    $('#item-cantidad').val(item.cantidad);
    $('#item-precio').val(item.precio.toFixed(2));
    $('#item-descuento').val(item.descuento);
    $('#descuento-valor').text(item.descuento + '%');
    
    // Actualizar título del modal
    const titulo = item.tipo === 'parte' ? 'Editar Parte' : 'Editar Servicio';
    $('#modal-item-title').html(`<i class="fas fa-edit me-2"></i>${titulo}`);
    
    // Configurar moneda
    const simboloMoneda = obtenerSimboloMonedaActual();
    $('#span-moneda').text(simboloMoneda);
    
    // Manejar stock para partes
    if (item.tipo === 'parte') {
        $('#stock-container').show();
        obtenerStockParte(item.id);
    } else {
        $('#stock-container').hide();
    }
    
    // Remover item de la lista temporalmente
    itemsSeleccionados.splice(index, 1);
    actualizarListaItems();
    calcularTotales();
    verificarEstadoProcesar();
    
    // Calcular resumen
    actualizarResumenModal();
    
    // Mostrar modal
    $('#agregarItemModal').modal('show');
}

function removerItem() {
    const index = $(this).data('index');
    const item = itemsSeleccionados[index];
    
    if (!item) {
        mostrarNotificacion('Error: Item no encontrado', 'error');
        return;
    }
    
    if (confirm(`¿Está seguro de eliminar "${item.nombre}" del carrito?`)) {
        itemsSeleccionados.splice(index, 1);
        actualizarListaItems();
        calcularTotales();
        verificarEstadoProcesar();
        mostrarNotificacion('Item eliminado del carrito', 'info');
    }
}

function calcularTotales() {
    if (itemsSeleccionados.length === 0) {
        const simboloMoneda = obtenerSimboloMonedaActual();
        $('#subtotal').text(`${simboloMoneda} 0.00`);
        $('#igv').text(`${simboloMoneda} 0.00`);
        $('#total').text(`${simboloMoneda} 0.00`);
        $('#abono-info').addClass('d-none');
        return;
    }
    
    let subtotal = 0;
    itemsSeleccionados.forEach(item => {
        subtotal += item.total;
    });
    
    const igv = subtotal * 0.18;
    const total = subtotal + igv;
    
    const simboloMoneda = obtenerSimboloMonedaActual();
    $('#subtotal').text(`${simboloMoneda} ${subtotal.toFixed(2)}`);
    $('#igv').text(`${simboloMoneda} ${igv.toFixed(2)}`);
    $('#total').text(`${simboloMoneda} ${total.toFixed(2)}`);
    
    // Calcular información de abono si aplica
    calcularInfoAbono(total, simboloMoneda);
}

function calcularInfoAbono(total, simboloMoneda) {
    if (porcentajeAbono < 100) {
        const abonoMonto = total * (porcentajeAbono / 100);
        const saldoPendiente = total - abonoMonto;
        
        $('#abono-monto').text(`${simboloMoneda} ${abonoMonto.toFixed(2)}`);
        $('#saldo-pendiente').text(`${simboloMoneda} ${saldoPendiente.toFixed(2)}`);
        $('#abono-info').removeClass('d-none');
    } else {
        $('#abono-info').addClass('d-none');
    }
}

// =============================================
// FUNCIONES DE ITEMS POPULARES
// =============================================

function cargarItemsPopulares() {
    $.ajax({
        url: '/admin/ventas/pos/items-populares',
        method: 'GET',
        data: {
            almacen_id: $('#almacen').val()
        },
        success: function(response) {
            if (response && Array.isArray(response) && response.length > 0) {
                mostrarItemsPopulares(response);
            } else {
                mostrarItemsPopularesPorDefecto();
            }
        },
        error: function(xhr, status, error) {
            console.error("Error al cargar items populares:", error);
            mostrarItemsPopularesPorDefecto();
        }
    });
}

function mostrarItemsPopulares(items) {
    let html = '';
    
    items.slice(0, 8).forEach(item => {
        const iconoTipo = item.tipo === 'parte' ? 'fas fa-cog' : 'fas fa-tools';
        const colorIcono = item.tipo === 'parte' ? 'text-info' : 'text-success';
        const simboloMoneda = obtenerSimboloMoneda(item.moneda);
        const precio = parseFloat(item.precio || 0).toFixed(2);
        
        html += `
            <div class="col">
                <div class="card h-100 border-0 shadow-sm popular-item cursor-pointer" 
                     data-id="${item.id}" 
                     data-tipo="${item.tipo}" 
                     data-nombre="${item.nombre}" 
                     data-codigo="${item.codigo}" 
                     data-precio="${item.precio}"
                     data-moneda="${item.moneda}" 
                     data-unidad="${item.unidad || 'UND'}">
                    <div class="card-body text-center p-3">
                        <div class="mb-3">
                            <i class="${iconoTipo} fa-2x ${colorIcono}"></i>
                        </div>
                        <h6 class="card-title mb-2" style="font-size: 0.9rem;">${item.nombre}</h6>
                        <p class="card-text text-primary fw-bold mb-1">${simboloMoneda}${precio}</p>
                        <small class="text-muted">Cód: ${item.codigo}</small>
                    </div>
                </div>
            </div>
        `;
    });
    
    $('#popular-items').html(html);
}

function mostrarItemsPopularesPorDefecto() {
    // Items demo cuando no hay conexión con el backend
    const itemsDemo = [
        {
            id: 'pop-1',
            tipo: 'parte',
            nombre: 'Filtro de Aceite',
            codigo: 'FLT-001',
            precio: 25.50,
            moneda: 'SOL'
        },
        {
            id: 'pop-2',
            tipo: 'parte',
            nombre: 'Pastillas de Freno',
            codigo: 'PAD-002',
            precio: 85.00,
            moneda: 'SOL'
        },
        {
            id: 'pop-3',
            tipo: 'servicio',
            nombre: 'Cambio de Aceite',
            codigo: 'SRV-001',
            precio: 45.00,
            moneda: 'SOL'
        },
        {
            id: 'pop-4',
            tipo: 'servicio',
            nombre: 'Revisión General',
            codigo: 'SRV-002',
            precio: 150.00,
            moneda: 'SOL'
        }
    ];
    
    mostrarItemsPopulares(itemsDemo);
}

// =============================================
// FUNCIONES AUXILIARES
// =============================================

function obtenerSimboloMoneda(moneda) {
    if (!moneda || moneda === 'SOL' || moneda === 'Soles') {
        return 'S/';
    } else if (moneda === 'USD' || moneda === 'Dólares') {
        return 'US$';
    }
    return 'S/';
}

function obtenerSimboloMonedaActual() {
    const monedaSeleccionada = $('#moneda').val();
    return obtenerSimboloMoneda(monedaSeleccionada);
}

function calcularSubtotal() {
    return itemsSeleccionados.reduce((sum, item) => sum + item.total, 0);
}

function calcularIGV() {
    return calcularSubtotal() * 0.18;
}

function calcularTotalVenta() {
    return calcularSubtotal() + calcularIGV();
}

function verificarEstadoProcesar() {
    const tieneCliente = $('#cliente-id').val() !== '';
    const tieneItems = itemsSeleccionados && itemsSeleccionados.length > 0;
    
    $('#btn-procesar').prop('disabled', !(tieneCliente && tieneItems));
}

function mostrarNotificacion(mensaje, tipo = 'info') {
    const toastId = 'toast-' + Date.now();
    const iconos = {
        'success': 'fas fa-check-circle',
        'error': 'fas fa-exclamation-circle',
        'warning': 'fas fa-exclamation-triangle',
        'info': 'fas fa-info-circle'
    };
    
    const colores = {
        'success': 'success',
        'error': 'danger',
        'warning': 'warning',
        'info': 'info'
    };
    
    const toastHtml = `
        <div id="${toastId}" class="toast align-items-center text-white bg-${colores[tipo]} border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="${iconos[tipo]} me-2"></i>
                    ${mensaje}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    `;
    
    if ($('#toast-container').length === 0) {
        $('body').append('<div id="toast-container" class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1060;"></div>');
    }
    
    $('#toast-container').append(toastHtml);
    
    const toastElement = document.getElementById(toastId);
    const toast = new bootstrap.Toast(toastElement, {
        autohide: true,
        delay: tipo === 'error' ? 8000 : 5000
    });
    toast.show();
    
    toastElement.addEventListener('hidden.bs.toast', function() {
        $(this).remove();
    });
}

function actualizarReloj() {
    const ahora = new Date();
    const tiempo = ahora.toLocaleTimeString('es-PE', {
        hour: '2-digit',
        minute: '2-digit'
    });
    if ($('#current-time').length) {
        $('#current-time').text(tiempo);
    }
}

function mostrarMensajeInicial() {
    $('#search-results').html(`
        <div class="d-flex justify-content-center align-items-center" style="min-height: 300px;">
            <div class="text-center text-muted">
                <i class="fas fa-search fa-4x mb-3 text-primary opacity-50"></i>
                <h5>Busque productos o servicios</h5>
                <p>Use la barra de búsqueda para encontrar items o navegue por categorías</p>
            </div>
        </div>
    `);
}

// =============================================
// FUNCIONES GLOBALES EXPUESTAS
// =============================================

// Función global para actualizar el resumen del modal
window.actualizarResumenModal = function() {
    const cantidad = parseInt($('#item-cantidad').val()) || 1;
    const precio = parseFloat($('#item-precio').val()) || 0;
    const descuento = parseFloat($('#item-descuento').val()) || 0;
    
    const subtotal = cantidad * precio;
    const descuentoMonto = subtotal * (descuento / 100);
    const total = subtotal - descuentoMonto;
    
    const moneda = $('#span-moneda').text();
    
    $('#modal-subtotal').text(`${moneda} ${subtotal.toFixed(2)}`);
    $('#modal-descuento').text(`${moneda} ${descuentoMonto.toFixed(2)}`);
    $('#modal-total').text(`${moneda} ${total.toFixed(2)}`);
    $('#descuento-valor').text(`${descuento}%`);
};

// Función global para cambiar cantidad desde botones
window.cambiarCantidad = function(delta) {
    const cantidadInput = $('#item-cantidad');
    let cantidad = parseInt(cantidadInput.val()) || 1;
    cantidad = Math.max(1, cantidad + delta);
    
    // Validar stock para partes
    const tipo = $('#item-tipo').val();
    if (tipo === 'parte' && !generarRequerimiento) {
        const stock = parseInt($('#item-stock').val()) || 0;
        if (cantidad > stock) {
            cantidad = stock;
            mostrarNotificacion('Cantidad ajustada al stock disponible', 'warning');
        }
    }
    
    cantidadInput.val(cantidad);
    actualizarResumenModal();
};

// Función global para cargar items populares desde HTML
window.cargarItemsPopulares = function() {
    cargarItemsPopulares();
};

// Función global para recargar clientes recientes
window.cargarClientesRecientes = function() {
    cargarClientesRecientes();
};

// Funciones globales para limpieza
window.limpiarBusqueda = function() {
    $('#search-items').val('').trigger('input');
};

window.aplicarFiltroRapido = function(filtro) {
    $('#search-items').val(filtro).trigger('input');
};

window.mostrarTodosLosProductos = function() {
    $('#search-items').val('');
    $('#btn-todo').trigger('click');
};

// =============================================
// CONFIGURACIÓN FINAL Y VALIDACIONES
// =============================================

// Configurar eventos adicionales cuando el DOM esté listo
$(function() {
    // Eventos para el modal de agregar item
    if ($('#item-cantidad').length) {
        $('#item-cantidad').on('input change', function() {
            actualizarResumenModal();
        });
    }
    
    if ($('#item-precio').length) {
        $('#item-precio').on('input change', function() {
            actualizarResumenModal();
        });
    }
    
    if ($('#item-descuento').length) {
        $('#item-descuento').on('input change', function() {
            actualizarResumenModal();
        });
    }
    
    // Actualizar resumen cuando se muestre el modal
    $('#agregarItemModal').on('shown.bs.modal', function() {
        setTimeout(actualizarResumenModal, 100);
    });
    
    // Configurar eventos para limpiar modal al cerrarlo
    $('#agregarItemModal').on('hidden.bs.modal', function() {
        $(this).find('form')[0]?.reset();
        $('#descuento-valor').text('0%');
    });
    
    // Eventos para el modal de cliente
    $('#clienteModal').on('hidden.bs.modal', function() {
        limpiarFormularioCliente();
    });
    
    // Focus automático en búsqueda de clientes
    $('#clienteModal').on('shown.bs.modal', function() {
        setTimeout(() => {
            $('#cliente-search').focus();
        }, 300);
    });
    
    // Validar estado del botón procesar al cambiar configuración
    $('#almacen, #moneda, #condicion, #forma-pago').on('change', function() {
        verificarEstadoProcesar();
    });
    
    // Evento para limpiar filtros
    $(document).on('click', '.limpiar-filtros', function() {
        selectedCategoriaParteId = '';
        selectedCategoriaServicioId = '';
        $('#filter-categorias-partes .dropdown-toggle').html('<i class="fas fa-filter me-1"></i>Categorías de Partes');
        $('#filter-categorias-servicios .dropdown-toggle').html('<i class="fas fa-filter me-1"></i>Categorías de Servicios');
        $('#active-filters').addClass('d-none');
        
        const query = $('#search-items').val().trim();
        if (query) {
            ejecutarBusqueda();
        }
    });
    
    // Prevenir envío de formularios con Enter accidental
    $('form').on('keypress', function(e) {
        if (e.which === 13 && e.target.type !== 'submit' && e.target.type !== 'textarea') {
            e.preventDefault();
        }
    });
    
    // Confirmar antes de salir si hay datos sin guardar
    window.addEventListener('beforeunload', function(e) {
        if (itemsSeleccionados.length > 0 || $('#cliente-id').val()) {
            e.preventDefault();
            e.returnValue = '¿Está seguro de salir? Se perderán los datos no guardados.';
            return e.returnValue;
        }
    });
    
    // Restaurar estado del botón procesar después de errores
    $(document).ajaxError(function(event, jqXHR, ajaxSettings, thrownError) {
        if (ajaxSettings.url && ajaxSettings.url.includes('/procesar')) {
            $('#btn-procesar').prop('disabled', false)
                              .html('<i class="fas fa-check-circle me-2"></i>Procesar Venta');
        }
    });
});

// =============================================
// LOGGING Y DEBUG (Solo en desarrollo)
// =============================================

// Función para debugging (remover en producción)
window.debugPOS = function() {
    return {
        itemsSeleccionados: itemsSeleccionados,
        tipoActivo: tipoActivo,
        generarRequerimiento: generarRequerimiento,
        porcentajeAbono: porcentajeAbono,
        selectedCategoriaParteId: selectedCategoriaParteId,
        selectedCategoriaServicioId: selectedCategoriaServicioId,
        clienteId: $('#cliente-id').val(),
        almacenId: $('#almacen').val(),
        moneda: $('#moneda').val()
    };
};

// Validación final del sistema
console.log('POS System: JavaScript cargado correctamente');

// Verificar elementos críticos
const elementosCriticos = [
    '#search-items',
    '#btn-search',
    '#items-container',
    '#cliente-id',
    '#btn-procesar',
    '#popular-items',
    '#almacen',
    '#moneda'
];

elementosCriticos.forEach(selector => {
    if ($(selector).length === 0) {
        console.warn(`POS System: Elemento no encontrado: ${selector}`);
    }
});

// Mensaje de estado del sistema
if (typeof $ !== 'undefined' && typeof bootstrap !== 'undefined') {
    console.log('POS System: Todas las dependencias cargadas correctamente');
} else {
    console.error('POS System: Faltan dependencias (jQuery o Bootstrap)');
}
</script>