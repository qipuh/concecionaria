<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Definición granular de permisos del sistema completo.
        // Estructura por módulo > submódulo > acciones
        $catalog = [
            // ============ SISTEMA ============
            'sistema' => [
                'label' => 'Sistema',
                'submodules' => [
                    'dashboard'  => ['label' => 'Dashboard',       'actions' => ['ver']],
                    'reportes'   => ['label' => 'Reportes',        'actions' => ['ver', 'ventas', 'compras', 'inventario', 'mantenimiento', 'exportar']],
                ],
            ],

            // ============ USUARIOS Y ROLES ============
            'usuarios' => [
                'label' => 'Usuarios y Roles',
                'submodules' => [
                    'usuarios' => ['label' => 'Usuarios',          'actions' => ['ver', 'crear', 'editar', 'eliminar']],
                    'roles'    => ['label' => 'Roles y Permisos',  'actions' => ['ver', 'crear', 'editar', 'eliminar']],
                ],
            ],

            // ============ VENTAS ============
            'ventas' => [
                'label' => 'Ventas',
                'submodules' => [
                    'dashboard'                 => ['label' => 'Dashboard de Ventas',           'actions' => ['ver']],
                    'cotizaciones'              => ['label' => 'Cotizaciones',                  'actions' => ['ver', 'crear', 'editar', 'eliminar', 'gestionar', 'cambiar-estado', 'generar-requerimiento']],
                    'cotizaciones-seguimientos' => ['label' => 'Cotizaciones - Seguimientos',   'actions' => ['ver', 'crear', 'eliminar', 'toggle-realizado', 'comentar', 'eliminar-comentario']],
                    'cotizaciones-pagos'        => ['label' => 'Cotizaciones - Pagos',          'actions' => ['ver', 'crear', 'editar', 'eliminar']],
                    'cotizaciones-comprobantes' => ['label' => 'Cotizaciones - Comprobantes',   'actions' => ['ver', 'crear', 'editar', 'eliminar']],
                    'cotizaciones-nota-pedido'  => ['label' => 'Cotizaciones - Nota de Pedido', 'actions' => ['ver', 'crear', 'editar', 'eliminar', 'pdf']],
                    'cotizaciones-ot'           => ['label' => 'Cotizaciones - Orden de Trabajo','actions' => ['ver', 'crear', 'editar']],
                    'cotizaciones-acta'         => ['label' => 'Cotizaciones - Acta de Entrega','actions' => ['ver', 'crear', 'editar', 'pdf']],
                    'cotizaciones-sunarp'       => ['label' => 'Cotizaciones - SUNARP',         'actions' => ['ver', 'crear', 'editar', 'eliminar']],
                    'cotizaciones-placas'       => ['label' => 'Cotizaciones - Placas',         'actions' => ['ver', 'crear', 'editar', 'eliminar', 'documentos', 'comentarios']],
                    'cotizaciones-documentos'   => ['label' => 'Cotizaciones - Documentos',     'actions' => ['ver', 'crear', 'editar', 'eliminar']],
                    'oportunidades'             => ['label' => 'Oportunidades',                 'actions' => ['ver', 'crear', 'editar', 'eliminar', 'seguimiento']],
                    'pos'                       => ['label' => 'POS - Punto de Venta',          'actions' => ['ver', 'vender', 'procesar', 'crear-cliente']],
                    'ventas-gestion'            => ['label' => 'Gestión de Ventas',             'actions' => ['ver', 'listar', 'marcar-lista-entrega', 'marcar-despachada', 'imprimir', 'exportar']],
                    'ventas-pagos'              => ['label' => 'Pagos de Ventas',               'actions' => ['ver', 'registrar', 'validar', 'eliminar']],
                    'cuentas-por-cobrar'        => ['label' => 'Cuentas por Cobrar',            'actions' => ['ver']],
                    'guias-entrega'             => ['label' => 'Guías de Entrega (Ventas)',     'actions' => ['ver', 'crear', 'editar', 'eliminar']],
                    'vales-devolucion'          => ['label' => 'Vales de Devolución (Ventas)',  'actions' => ['ver', 'crear', 'editar', 'eliminar']],
                    'recepcion'                 => ['label' => 'Recepción (Ventas)',            'actions' => ['ver', 'crear', 'editar', 'eliminar']],
                    'inventarios'               => ['label' => 'Inventarios (Ventas)',          'actions' => ['ver', 'crear', 'editar', 'eliminar']],
                ],
            ],

            // ============ CLIENTES ============
            'clientes' => [
                'label' => 'Clientes',
                'submodules' => [
                    'clientes'   => ['label' => 'Clientes',            'actions' => ['ver', 'crear', 'editar', 'eliminar', 'validar-documento']],
                    'categorias' => ['label' => 'Categorías Cliente',  'actions' => ['ver', 'crear', 'editar', 'eliminar']],
                ],
            ],

            // ============ COMPRAS ============
            'compras' => [
                'label' => 'Compras',
                'submodules' => [
                    'proveedores'              => ['label' => 'Proveedores',                'actions' => ['ver', 'crear', 'editar', 'eliminar', 'validar-documento']],
                    'proveedores-cuentas'      => ['label' => 'Proveedores - Cuentas',      'actions' => ['ver', 'crear', 'editar', 'eliminar']],
                    'categorias-proveedor'     => ['label' => 'Categorías de Proveedor',    'actions' => ['ver', 'crear', 'editar', 'eliminar']],
                    'requerimientos'           => ['label' => 'Requerimientos de Compra',   'actions' => ['ver', 'crear', 'editar', 'eliminar']],
                    'ordenes'                  => ['label' => 'Órdenes de Compra',          'actions' => ['ver', 'crear', 'editar', 'eliminar', 'aprobar', 'rechazar']],
                    'recepcion'                => ['label' => 'Recepción de OC',            'actions' => ['ver', 'recibir', 'devolver', 'completar-faltantes', 'historial', 'detalle']],
                    'guias-entrega'            => ['label' => 'Guías de Entrega (Compras)', 'actions' => ['ver', 'crear', 'editar', 'eliminar']],
                    'devoluciones'             => ['label' => 'Devoluciones (Compras)',     'actions' => ['ver', 'crear', 'editar', 'eliminar']],
                    'documentos-guias'         => ['label' => 'Documentos - Guías Entrega', 'actions' => ['ver', 'crear', 'editar', 'eliminar']],
                    'documentos-vales'         => ['label' => 'Documentos - Vales Devol.',  'actions' => ['ver', 'crear', 'editar', 'eliminar']],
                    'documentos-recepcion'     => ['label' => 'Documentos - Recepción',     'actions' => ['ver', 'crear', 'editar', 'eliminar']],
                ],
            ],

            // ============ ALMACENES ============
            'almacenes' => [
                'label' => 'Almacenes',
                'submodules' => [
                    'almacenes'         => ['label' => 'Almacenes',              'actions' => ['ver', 'crear', 'editar', 'eliminar']],
                    'partes'            => ['label' => 'Partes / Repuestos',     'actions' => ['ver', 'crear', 'editar', 'eliminar']],
                    'partes-categorias' => ['label' => 'Categorías de Partes',   'actions' => ['ver', 'crear', 'editar', 'eliminar']],
                    'servicios-terceros'=> ['label' => 'Servicios Tercerizados', 'actions' => ['ver', 'crear', 'editar', 'eliminar']],
                    'inventario-alm'    => ['label' => 'Inventario de Almacén',  'actions' => ['ver', 'kardex']],
                ],
            ],

            // ============ INVENTARIO ============
            'inventario' => [
                'label' => 'Inventario',
                'submodules' => [
                    'inventario'           => ['label' => 'Inventario General',       'actions' => ['ver', 'reporte']],
                    'movimientos'          => ['label' => 'Movimientos',              'actions' => ['ver', 'crear', 'editar', 'eliminar']],
                    'traslados'            => ['label' => 'Traslados',                'actions' => ['ver', 'crear', 'editar', 'cambiar-estado']],
                    'kardex'               => ['label' => 'Kardex',                   'actions' => ['ver', 'reporte', 'consulta', 'movimientos']],
                    'devolucion-proveedor' => ['label' => 'Devolución a Proveedor',   'actions' => ['ver', 'crear', 'editar', 'eliminar', 'confirmar']],
                ],
            ],

            // ============ MANTENIMIENTO ============
            'mantenimiento' => [
                'label' => 'Mantenimiento',
                'submodules' => [
                    'dashboard'           => ['label' => 'Dashboard Mantenimiento',   'actions' => ['ver']],
                    'citas'               => ['label' => 'Citas de Mantenimiento',    'actions' => ['ver', 'crear', 'editar', 'eliminar', 'confirmar', 'adelanto']],
                    'ordenes'             => ['label' => 'Órdenes de Trabajo',        'actions' => ['ver', 'crear', 'editar', 'eliminar', 'diagnosticar', 'aprobar', 'finalizar', 'facturar', 'registrar-pago', 'imprimir']],
                    'ordenes-repuestos'   => ['label' => 'OT - Repuestos',            'actions' => ['agregar', 'eliminar']],
                    'ordenes-servicios'   => ['label' => 'OT - Servicios',            'actions' => ['agregar', 'eliminar']],
                    'ordenes-seguim'      => ['label' => 'OT - Seguimientos',         'actions' => ['ver', 'crear', 'eliminar', 'toggle-realizado', 'comentar', 'eliminar-comentario']],
                    'tecnicos'            => ['label' => 'Técnicos',                  'actions' => ['ver', 'crear', 'editar', 'eliminar']],
                    'planes'              => ['label' => 'Planes de Mantenimiento',   'actions' => ['ver', 'crear', 'editar', 'eliminar', 'toggle-status', 'duplicar']],
                    'factura'             => ['label' => 'Facturas',                  'actions' => ['ver', 'generar']],
                ],
            ],

            // ============ PRODUCTOS Y SERVICIOS ============
            'productos-servicios' => [
                'label' => 'Productos y Servicios',
                'submodules' => [
                    'vehiculos'                => ['label' => 'Vehículos',                'actions' => ['ver', 'crear', 'editar', 'eliminar', 'importar']],
                    'vehiculos-caract'         => ['label' => 'Vehículos - Catálogo',     'actions' => ['ver', 'crear', 'editar', 'eliminar']],
                    'vehiculos-marcas'         => ['label' => 'Vehículos - Marcas',       'actions' => ['ver', 'crear', 'editar', 'eliminar']],
                    'vehiculos-modelos'        => ['label' => 'Vehículos - Modelos',      'actions' => ['ver', 'crear', 'editar', 'eliminar']],
                    'vehiculos-versiones'      => ['label' => 'Vehículos - Versiones',    'actions' => ['ver', 'crear', 'editar', 'eliminar']],
                    'vehiculos-anios'          => ['label' => 'Vehículos - Años Modelo',  'actions' => ['ver', 'crear', 'editar', 'eliminar']],
                    'vehiculos-colores'        => ['label' => 'Vehículos - Colores',      'actions' => ['ver', 'crear', 'editar', 'eliminar']],
                    'servicios'                => ['label' => 'Servicios',                'actions' => ['ver', 'crear', 'editar', 'eliminar']],
                    'servicios-categorias'     => ['label' => 'Categorías de Servicios',  'actions' => ['ver', 'crear', 'editar', 'eliminar']],
                ],
            ],

            // ============ CONFIGURACIÓN ============
            'configuracion' => [
                'label' => 'Configuración',
                'submodules' => [
                    'maestros-fabricantes'  => ['label' => 'Maestros - Fabricantes',          'actions' => ['ver', 'crear', 'editar', 'eliminar']],
                    'maestros-estandar'     => ['label' => 'Maestros - Estándar de Mant.',   'actions' => ['ver', 'crear', 'editar', 'eliminar']],
                    'maestros-cargos'       => ['label' => 'Maestros - Cargos',              'actions' => ['ver', 'crear', 'editar', 'eliminar']],
                    'maestros-bancos'       => ['label' => 'Maestros - Bancos',              'actions' => ['ver', 'crear', 'editar', 'eliminar']],
                    'centros-costos'        => ['label' => 'Centros de Costos',              'actions' => ['ver', 'crear', 'editar', 'eliminar']],
                    'unidades'              => ['label' => 'Unidades',                       'actions' => ['ver', 'crear', 'editar', 'eliminar']],
                    'reglas-vencimiento'    => ['label' => 'Reglas de Vencimiento Cotiz.',   'actions' => ['ver', 'crear', 'editar', 'eliminar', 'toggle-activo']],
                    'tipos-cambio'          => ['label' => 'Tipos de Cambio',                'actions' => ['ver', 'crear', 'editar', 'eliminar', 'sunat', 'toggle']],
                ],
            ],

            // ============ ESTABLECIMIENTOS ============
            'establecimientos' => [
                'label' => 'Establecimientos',
                'submodules' => [
                    'establecimientos' => ['label' => 'Establecimientos', 'actions' => ['ver', 'crear', 'editar', 'eliminar']],
                ],
            ],

            // ============ TALLERES ============
            'talleres' => [
                'label' => 'Talleres',
                'submodules' => [
                    'talleres' => ['label' => 'Talleres', 'actions' => ['ver', 'crear', 'editar', 'eliminar']],
                ],
            ],
        ];

        $actionLabels = [
            'ver' => 'Ver',
            'crear' => 'Crear',
            'editar' => 'Editar',
            'eliminar' => 'Eliminar',
            'aprobar' => 'Aprobar',
            'rechazar' => 'Rechazar',
            'confirmar' => 'Confirmar',
            'cambiar-estado' => 'Cambiar Estado',
            'toggle-realizado' => 'Marcar Realizado',
            'toggle-activo' => 'Activar/Desactivar',
            'toggle-status' => 'Activar/Desactivar',
            'toggle' => 'Activar/Desactivar',
            'comentar' => 'Comentar',
            'eliminar-comentario' => 'Eliminar Comentario',
            'pdf' => 'Generar PDF',
            'imprimir' => 'Imprimir',
            'exportar' => 'Exportar',
            'importar' => 'Importar',
            'duplicar' => 'Duplicar',
            'diagnosticar' => 'Registrar Diagnóstico',
            'finalizar' => 'Finalizar',
            'facturar' => 'Generar Factura',
            'registrar-pago' => 'Registrar Pago',
            'registrar' => 'Registrar',
            'validar' => 'Validar',
            'validar-documento' => 'Validar Documento',
            'agregar' => 'Agregar',
            'gestionar' => 'Gestionar',
            'generar-requerimiento' => 'Generar Requerimiento',
            'vender' => 'Vender',
            'procesar' => 'Procesar Venta',
            'crear-cliente' => 'Crear Cliente Rápido',
            'listar' => 'Listar',
            'marcar-lista-entrega' => 'Marcar Lista para Entrega',
            'marcar-despachada' => 'Marcar Despachada',
            'seguimiento' => 'Seguimiento',
            'recibir' => 'Recibir',
            'devolver' => 'Devolver',
            'completar-faltantes' => 'Completar Faltantes',
            'historial' => 'Ver Historial',
            'detalle' => 'Ver Detalle',
            'kardex' => 'Ver Kardex',
            'reporte' => 'Ver Reporte',
            'consulta' => 'Consultar',
            'movimientos' => 'Ver Movimientos',
            'ventas' => 'Reporte de Ventas',
            'compras' => 'Reporte de Compras',
            'inventario' => 'Reporte de Inventario',
            'mantenimiento' => 'Reporte de Mantenimiento',
            'sunat' => 'Sincronizar SUNAT',
            'generar' => 'Generar',
            'documentos' => 'Gestionar Documentos',
            'comentarios' => 'Gestionar Comentarios',
        ];

        // Limpiar permisos antiguos para reemplazar por el catálogo nuevo
        DB::table('role_permission')->delete();
        Permission::query()->delete();

        // Crear permisos
        foreach ($catalog as $moduleKey => $moduleData) {
            foreach ($moduleData['submodules'] as $subKey => $subData) {
                foreach ($subData['actions'] as $action) {
                    $name = $moduleKey . '.' . $subKey . '.' . $action;
                    $actionLabel = $actionLabels[$action] ?? ucfirst(str_replace('-', ' ', $action));
                    Permission::create([
                        'name' => $name,
                        'display_name' => $actionLabel,
                        'module' => $moduleKey,
                        'module_label' => $moduleData['label'],
                        'submodule' => $subKey,
                        'submodule_label' => $subData['label'],
                    ]);
                }
            }
        }

        // ============ ROLES ============
        $roles = [
            'admin' => [
                'description' => 'Administrador del sistema - Acceso total',
                'permissions' => '*',
            ],
            'vendedor' => [
                'description' => 'Vendedor - Acceso a ventas y clientes',
                'permissions' => ['sistema.dashboard.%', 'ventas.%', 'clientes.%'],
            ],
            'almacenero' => [
                'description' => 'Almacenero - Acceso a almacenes e inventario',
                'permissions' => ['sistema.dashboard.%', 'almacenes.%', 'inventario.%'],
            ],
            'tecnico' => [
                'description' => 'Técnico - Acceso a mantenimiento',
                'permissions' => ['sistema.dashboard.%', 'mantenimiento.%'],
            ],
            'compras' => [
                'description' => 'Compras - Acceso a compras y almacenes',
                'permissions' => ['sistema.dashboard.%', 'compras.%', 'almacenes.%'],
            ],
            'cliente' => [
                'description' => 'Cliente - Sin acceso al admin',
                'permissions' => [],
            ],
        ];

        foreach ($roles as $name => $data) {
            $role = Role::firstOrCreate(['name' => $name], ['description' => $data['description']]);
            $role->update(['description' => $data['description']]);

            if ($data['permissions'] === '*') {
                $role->permissions()->sync(Permission::pluck('id')->toArray());
                continue;
            }

            $ids = collect();
            foreach ($data['permissions'] as $pattern) {
                $ids = $ids->merge(Permission::where('name', 'like', str_replace('%', '%', $pattern))->pluck('id'));
            }
            $role->permissions()->sync($ids->unique()->values()->toArray());
        }
    }
}
