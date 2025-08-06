<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" 
x-data="{
          darkMode: localStorage.getItem('darkMode') === 'true',
          sidebarOpen: false,
          collapsed: false,
          activeMenu: null,
          isActive(route) {
              const currentPath = window.location.pathname;
              
              // Caso especial para dashboard de cotizaciones
              if (route === 'admin/ventas/cotizaciones/dashboard') {
                  return currentPath === '/admin/ventas/cotizaciones/dashboard';
              }
              
              // Caso especial para cotizaciones (evita marcar como activo cuando estamos en dashboard)
              if (route === 'admin/ventas/cotizaciones') {
                  return currentPath.includes(route) && 
                         !currentPath.includes('/admin/ventas/cotizaciones/dashboard');
              }
              
              // Para otras rutas mantener comportamiento normal
              return currentPath.includes(route);
          },
          shouldBeOpen(routes) {
              return routes.some(route => window.location.pathname.includes(route));
          },
          // Función auxiliar para verificar rutas exactas
          isExactActive(path) {
              return window.location.pathname === `/${path}`;
          },
          // Función auxiliar para verificar múltiples rutas
          isAnyActive(paths) {
              return paths.some(path => window.location.pathname.startsWith(`/${path}`));
          }
      }"
      x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val));
        activeMenu = shouldBeOpen(['admin/ventas']) ? 'ventas' :
            shouldBeOpen(['admin/clientes']) ? 'clientes' :
            shouldBeOpen(['admin/compras']) ? 'compras' :
            shouldBeOpen(['admin/almacenes/partes', 'admin/productos-servicios/servicios', 'admin/productos-servicios/vehiculos', 'admin/estrategia']) ? 'productos-servicios' :
            shouldBeOpen(['admin/inventario', 'admin/inventario/traslados', 'admin/inventario/movimientos', 'admin/kardex']) ? 'inventario' :
            shouldBeOpen(['admin/mantenimiento']) ? 'mantenimiento' :
            shouldBeOpen(['admin/usuarios']) ? 'usuarios' :
            shouldBeOpen(['admin/configuracion']) ? 'configuracion' : null"
      :class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'MSA Automotriz') }} - @yield('title', 'Dashboard')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    
    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    
    <!-- Toastr -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Styles -->
    @livewireStyles
    
    <style>
        [x-cloak] { display: none !important; }
        .sidebar-height {
            height: 100vh;
        }
        .notification-width {
            width: 300px;
        }
        
        /* Estilo para tema oscuro */
        .dark {
            --bs-body-color: #f8f9fa;
            --bs-body-bg: #1a202c;
        }
        
        .dark .bg-dark-custom {
            background-color: #2d3748;
        }
        
        .dark .text-dark-custom {
            color: #f8f9fa;
        }
        
        .dark .border-dark-custom {
            border-color: #4a5568;
        }
        
        .sidebar {
            transition: all 0.3s ease-in-out;
        }
        
        /* Estilos para el menú de usuario */
        .user-dropdown {
            position: absolute;
            bottom: 100%;
            left: 0;
            z-index: 1000;
            margin-bottom: 0.5rem;
        }

        /* Sin bordes para botones de toggle */
        .btn-no-border {
            border: none;
            box-shadow: none;
        }
        
        .btn-no-border:focus, .btn-no-border:active {
            box-shadow: none;
            outline: none;
        }
        
        /* Hover para elementos de menú */
        .nav-link:hover, .dropdown-item:hover {
            background-color: rgba(0,0,0,0.05);
        }
        
        .dark .nav-link:hover, .dark .dropdown-item:hover {
            background-color: rgba(255,255,255,0.05);
        }

        /* Ajuste para el logo */
        .logo-img {
            height: auto;
            width: 4rem;
        }
        a{
            text-decoration:none;
        }
        /* Estilo para ítem de menú activo */
        .menu-active {
            background-color: #f8f9fa !important;
            font-weight: 500 !important;
        }
        
        .dark .menu-active {
            background-color: #384152 !important;
        }
        
        /* Estilos para icono activo (fondo rojo circular con icono blanco) */
        .menu-icon-container {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 2rem;
            height: 2rem;
            transition: all 0.3s ease;
        }
        
        .icon-active {
            background-color: #dc3545;
            border-radius: 50%;
            color: white !important;
        }
        
        .icon-active svg, .icon-active i {
            color: white !important;
        }
        
        /* Estilo para submenú activo */
        .submenu-active {
            font-weight: 500 !important;
            color: #dc3545 !important;
        }
        
        .dark .submenu-active {
            color: #ff6b6b !important;
        }

        /* Utilidades adicionales */
        .smaller {
            font-size: 0.8rem;
        }

        .text-light-50 {
            color: rgba(248, 249, 250, 0.8);
        }

        .rotate-180 {
            transform: rotate(180deg);
        }

        .transition {
            transition: all 0.3s ease;
        }

        .hover-light:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .hover-dark:hover {
            background-color: rgba(255, 255, 255, 0.05);
        }
    </style>
</head>
<body class="min-vh-100 transition bg-light" :class="darkMode ? 'dark bg-dark text-light' : 'bg-light'">
    <div class="d-flex min-vh-100">
        <!-- Sidebar -->
        <div class="sidebar position-fixed top-0 bottom-0 start-0 bg-white shadow-lg transition" 
             :class="{ 
                 'translate-x-100': !sidebarOpen, 
                 'translate-x-0': sidebarOpen, 
                 'w-64': !collapsed, 
                 'w-20': collapsed && !sidebarOpen,
                 'bg-dark-custom': darkMode
             }"
             style="width: 16rem;"
             :style="collapsed && !sidebarOpen ? 'width: 5rem;' : 'width: 16rem;'">
            <div class="d-flex flex-column sidebar-height">
                <!-- Sidebar Header -->
                <div class="d-flex align-items-center justify-content-between p-3 border-bottom" :class="darkMode ? 'border-dark-custom' : ''">
                    <div class="d-flex align-items-center">
                        <img :class="{ 'me-3': !collapsed }" class="logo-img" src="{{ asset('img/logo-MSA.png') }}" alt="MSA Automotriz">
                    </div>
                    <button @click="collapsed = !collapsed" class="btn btn-sm btn-no-border d-none d-md-block" :class="darkMode ? 'text-light' : 'text-secondary'">
                        <svg xmlns="http://www.w3.org/2000/svg" :class="{ 'rotate-180': !collapsed }" class="h-6 w-6 transition" style="height: 1.5rem; width: 1.5rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                        </svg>
                    </button>
                </div>
                
                <!-- Navigation Links -->
                <div class="flex-grow-1 overflow-auto py-3">
                    <ul class="nav flex-column px-2">
                        <!-- Dashboard -->
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}" 
                            class="nav-link d-flex align-items-center px-3 py-2 mb-1 rounded" 
                            :class="[
                                darkMode ? 'text-light hover-dark' : 'text-dark hover-light',
                                isActive('admin/dashboard') ? 'menu-active' : ''
                            ]">
                                <div class="menu-icon-container me-2" :class="isActive('admin/dashboard') ? 'icon-active' : ''">
                                    <svg xmlns="http://www.w3.org/2000/svg" style="height: 1.25rem; width: 1.25rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                    </svg>
                                </div>
                                <span x-show="!collapsed">Dashboard</span>
                            </a>
                        </li>

                        <!-- Ventas -->
                        <li class="nav-item">
                            <button @click="activeMenu = (activeMenu === 'ventas') ? null : 'ventas'" 
                                    class="nav-link d-flex align-items-center justify-content-between w-100 px-3 py-2 mb-1 rounded text-start btn-no-border"
                                    :class="[
                                        darkMode ? 'text-light hover-dark' : 'text-dark hover-light',
                                        isActive('admin/ventas') ? 'menu-active' : ''
                                    ]">
                                <div class="d-flex align-items-center">
                                    <div class="menu-icon-container me-2" :class="isActive('admin/ventas') ? 'icon-active' : ''">
                                        <svg xmlns="http://www.w3.org/2000/svg" style="height: 1.25rem; width: 1.25rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <span x-show="!collapsed">Ventas</span>
                                </div>
                                <svg x-show="!collapsed" :class="{ 'rotate-180': activeMenu === 'ventas' }" class="ms-2" style="height: 1rem; width: 1rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-show="activeMenu === 'ventas' && !collapsed" class="ms-4 my-1">
                                <a href="{{ route('admin.ventas.cotizaciones.index') }}" 
                                class="nav-link d-block py-2 px-3 rounded small"
                                :class="[
                                    darkMode ? 'text-light-50 hover-dark' : 'text-secondary hover-light',
                                    isActive('admin/ventas/cotizaciones') ? 'submenu-active' : ''
                                ]">
                                    Cotizaciones
                                </a>

<a href="{{ route('admin.ventas.pos.index') }}" class="nav-link d-block py-2 px-3 rounded small position-relative" :class="darkMode ? 'text-light-50 hover-dark' : 'text-secondary hover-light'" title="Terminal POS">
    <i class="fas fa-cash-register me-2"></i> Terminal POS
</a>

<a href="{{ route('admin.ventas.index') }}" class="nav-link d-block py-2 px-3 rounded small position-relative" :class="darkMode ? 'text-light-50 hover-dark' : 'text-secondary hover-light'" title="Gestión de Ventas">
    <i class="fas fa-list-alt me-2"></i> Gestión de Ventas
</a>
                                <div x-data="{ openSub: shouldBeOpen(['admin/ventas/ventas']) }" x-init="openSub = shouldBeOpen(['admin/ventas/ventas'])">
                                    <button @click="openSub = !openSub" 
                                            class="nav-link d-flex align-items-center justify-content-between w-100 px-3 py-2 rounded text-start small btn-no-border" 
                                            :class="[
                                                darkMode ? 'text-light-50 hover-dark' : 'text-secondary hover-light',
                                                isActive('admin/ventas/ventas') ? 'submenu-active' : ''
                                            ]">
                                        <span>Ventas</span>
                                        <svg :class="{ 'rotate-180': openSub }" class="ms-2" style="height: 0.75rem; width: 0.75rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>
                                    <div x-show="openSub" class="ps-4">
                                        <a href="#" class="nav-link d-block py-2 px-3 rounded small position-relative" :class="darkMode ? 'text-light-50 hover-dark' : 'text-secondary hover-light'">
                                            Guías de entrega
                                            <small class="ms-2 d-inline-flex align-items-center">
                                                <span class="badge bg-danger bg-opacity-75 px-2 py-1 rounded-pill" style="font-size: 0.6rem; font-weight: 400;">Prox</span>
                                            </small>
                                        </a>
                                        <a href="#" class="nav-link d-block py-2 px-3 rounded small position-relative" :class="darkMode ? 'text-light-50 hover-dark' : 'text-secondary hover-light'">
                                            Vales de devolución
                                            <small class="ms-2 d-inline-flex align-items-center">
                                                <span class="badge bg-danger bg-opacity-75 px-2 py-1 rounded-pill" style="font-size: 0.6rem; font-weight: 400;">Prox</span>
                                            </small>
                                        </a>
                                        <a href="#" class="nav-link d-block py-2 px-3 rounded small position-relative" :class="darkMode ? 'text-light-50 hover-dark' : 'text-secondary hover-light'">
                                            Recepción
                                            <small class="ms-2 d-inline-flex align-items-center">
                                                <span class="badge bg-danger bg-opacity-75 px-2 py-1 rounded-pill" style="font-size: 0.6rem; font-weight: 400;">Prox</span>
                                            </small>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <!-- Clientes -->
                        <li class="nav-item">
                            <button @click="activeMenu = (activeMenu === 'clientes') ? null : 'clientes'" 
                                    class="nav-link d-flex align-items-center justify-content-between w-100 px-3 py-2 mb-1 rounded text-start btn-no-border"
                                    :class="[
                                        darkMode ? 'text-light hover-dark' : 'text-dark hover-light',
                                        isActive('admin/clientes') ? 'menu-active' : ''
                                    ]">
                                <div class="d-flex align-items-center">
                                    <div class="menu-icon-container me-2" :class="isActive('admin/clientes') ? 'icon-active' : ''">
                                        <svg xmlns="http://www.w3.org/2000/svg" style="height: 1.25rem; width: 1.25rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </div>
                                    <span x-show="!collapsed">Clientes</span>
                                </div>
                                <svg x-show="!collapsed" :class="{ 'rotate-180': activeMenu === 'clientes' }" class="ms-2" style="height: 1rem; width: 1rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-show="activeMenu === 'clientes' && !collapsed" class="ms-4 my-1">
                                <a href="{{ route('admin.clientes.index') }}" 
                                class="nav-link d-block py-2 px-3 rounded small"
                                :class="[
                                    darkMode ? 'text-light-50 hover-dark' : 'text-secondary hover-light',
                                    isActive('admin/clientes') && !isActive('admin/clientes/categorias') ? 'submenu-active' : ''
                                ]">
                                    Clientes
                                </a>
                                <a href="{{ route('admin.clientes.categorias.index') }}" 
                                class="nav-link d-block py-2 px-3 rounded small"
                                :class="[
                                    darkMode ? 'text-light-50 hover-dark' : 'text-secondary hover-light',
                                    isActive('admin/clientes/categorias') ? 'submenu-active' : ''
                                ]">
                                    Categorías de Clientes
                                </a>
                            </div>
                        </li>
                        
                        <!-- Compras -->
                        <li class="nav-item">
                            <button @click="activeMenu = (activeMenu === 'compras') ? null : 'compras'" 
                                    class="nav-link d-flex align-items-center justify-content-between w-100 px-3 py-2 mb-1 rounded text-start btn-no-border"
                                    :class="[
                                        darkMode ? 'text-light hover-dark' : 'text-dark hover-light',
                                        isActive('admin/compras') ? 'menu-active' : ''
                                    ]">
                                <div class="d-flex align-items-center">
                                    <div class="menu-icon-container me-2" :class="isActive('admin/compras') ? 'icon-active' : ''">
                                        <svg xmlns="http://www.w3.org/2000/svg" style="height: 1.25rem; width: 1.25rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                        </svg>
                                    </div>
                                    <span x-show="!collapsed">Compras</span>
                                </div>
                                <svg x-show="!collapsed" :class="{ 'rotate-180': activeMenu === 'compras' }" class="ms-2" style="height: 1rem; width: 1rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-show="activeMenu === 'compras' && !collapsed" class="ms-4 my-1">
                                <a href="{{ route('admin.compras.requerimientos.index') }}" 
                                class="nav-link d-block py-2 px-3 rounded small"
                                :class="[
                                    darkMode ? 'text-light-50 hover-dark' : 'text-secondary hover-light',
                                    isActive('admin/compras/requerimientos') ? 'submenu-active' : ''
                                ]">Requerimientos</a>
                                <a href="{{ route('admin.compras.ordenes.index') }}" 
                                class="nav-link d-block py-2 px-3 rounded small"
                                :class="[
                                    darkMode ? 'text-light-50 hover-dark' : 'text-secondary hover-light',
                                    isActive('admin/compras/ordenes') ? 'submenu-active' : ''
                                ]">Órdenes de compra</a>

                                <div x-data="{ openSub: shouldBeOpen(['admin/compras/documentos']) }" x-init="openSub = shouldBeOpen(['admin/compras/documentos'])">
                                    <button @click="openSub = !openSub" 
                                            class="nav-link d-flex align-items-center justify-content-between w-100 px-3 py-2 rounded text-start small btn-no-border position-relative" 
                                            :class="[
                                                darkMode ? 'text-light-50 hover-dark' : 'text-secondary hover-light',
                                                isActive('admin/compras/documentos') ? 'submenu-active' : ''
                                            ]">
                                        <span>Documentos</span>
                                        <svg :class="{ 'rotate-180': openSub }" class="ms-2" style="height: 0.75rem; width: 0.75rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>
                                    <div x-show="openSub" class="ps-4">
                                        <a href="{{ route('admin.recepcion.index') }}" class="nav-link d-block py-2 px-3 rounded small position-relative" :class="darkMode ? 'text-light-50 hover-dark' : 'text-secondary hover-light'">
                                            Recepción
                                        </a>
                                        <a href="{{ route('admin.guias.index') }}" class="nav-link d-block py-2 px-3 rounded small position-relative" :class="darkMode ? 'text-light-50 hover-dark' : 'text-secondary hover-light'">
                                            Guías de entrega
                                        </a>
                                        <a href="{{ route('admin.devoluciones.index') }}" class="nav-link d-block py-2 px-3 rounded small position-relative" :class="darkMode ? 'text-light-50 hover-dark' : 'text-secondary hover-light'">
                                            Vales de devolución
                                        </a>
                                    </div>
                                </div>
                                <div x-data="{ openSub: shouldBeOpen(['admin/compras/proveedores']) }" x-init="openSub = shouldBeOpen(['admin/compras/proveedores'])">
                                    <button @click="openSub = !openSub"
                                            class="nav-link d-flex align-items-center justify-content-between w-100 px-3 py-2 rounded text-start small btn-no-border"
                                            :class="[
                                                darkMode ? 'text-light-50 hover-dark' : 'text-secondary hover-light',
                                                isActive('admin/compras/proveedores') ? 'submenu-active' : ''
                                            ]">
                                        <span>Proveedores</span>
                                        <svg :class="{ 'rotate-180': openSub }" class="ms-2" style="height: 0.75rem; width: 0.75rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>
                                    <div x-show="openSub" class="ps-4">
                                        <a href="{{ route('admin.compras.proveedores.index') }}"
                                        class="nav-link d-block py-2 px-3 rounded small"
                                        :class="[
                                            darkMode ? 'text-light-50 hover-dark' : 'text-secondary hover-light',
                                            window.location.pathname === '/admin/compras/proveedores' || window.location.pathname.startsWith('/admin/compras/proveedores/') && !window.location.pathname.includes('/categorias') ? 'submenu-active' : ''
                                        ]">Proveedores</a>
                                        <a href="{{ route('admin.compras.proveedores.categorias.index') }}"
                                        class="nav-link d-block py-2 px-3 rounded small"
                                        :class="[
                                            darkMode ? 'text-light-50 hover-dark' : 'text-secondary hover-light',
                                            window.location.pathname.includes('/admin/compras/proveedores/categorias') ? 'submenu-active' : ''
                                        ]">Categorías</a>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <!-- Productos/Servicios (antes Catálogos) -->
                        <li class="nav-item">
                            <button @click="activeMenu = (activeMenu === 'productos-servicios') ? null : 'productos-servicios'" 
                                class="nav-link d-flex align-items-center justify-content-between w-100 px-3 py-2 mb-1 rounded text-start btn-no-border"
                                :class="[
                                    darkMode ? 'text-light hover-dark' : 'text-dark hover-light',
                                    isActive('admin/almacenes/partes') || isActive('admin/productos-servicios/servicios') || isActive('admin/productos-servicios/vehiculos') || isActive('admin/estrategia') ? 'menu-active' : ''
                                ]">
                                <div class="d-flex align-items-center">
                                    <div class="menu-icon-container me-2" :class="isActive('admin/almacenes/partes') || isActive('admin/productos-servicios/servicios') || isActive('admin/productos-servicios/vehiculos') || isActive('admin/estrategia') ? 'icon-active' : ''">
                                        <svg xmlns="http://www.w3.org/2000/svg" style="height: 1.25rem; width: 1.25rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                        </svg>
                                    </div>
                                    <span x-show="!collapsed">Productos/Servicios</span>
                                </div>
                                <svg x-show="!collapsed" :class="{ 'rotate-180': activeMenu === 'productos-servicios' }" class="ms-2" style="height: 1rem; width: 1rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-show="activeMenu === 'productos-servicios' && !collapsed" class="ms-4 my-1">
                                <div x-data="{ openSub: shouldBeOpen(['admin/almacenes/partes']) }" x-init="openSub = shouldBeOpen(['admin/almacenes/partes'])">
                                    <button @click="openSub = !openSub" 
                                            class="nav-link d-flex align-items-center justify-content-between w-100 px-3 py-2 rounded text-start small btn-no-border" 
                                            :class="[
                                                darkMode ? 'text-light-50 hover-dark' : 'text-secondary hover-light',
                                                isActive('admin/almacenes/partes') ? 'submenu-active' : ''
                                            ]">
                                        <span>Partes / Repuestos</span>
                                        <svg :class="{ 'rotate-180': openSub }" class="ms-2" style="height: 0.75rem; width: 0.75rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>
                                    <div x-show="openSub" class="ps-4">
                                        <a href="{{ route('admin.almacenes.partes.index') }}" 
                                        class="nav-link d-block py-2 px-3 rounded small" 
                                        :class="[
                                            darkMode ? 'text-light-50 hover-dark' : 'text-secondary hover-light',
                                            isActive('admin/almacenes/partes') && !isActive('admin/almacenes/partes/categorias') ? 'submenu-active' : ''
                                        ]">Items</a>
                                        <a href="{{ route('admin.almacenes.partes.categorias.index') }}" 
                                        class="nav-link d-block py-2 px-3 rounded small" 
                                        :class="[
                                            darkMode ? 'text-light-50 hover-dark' : 'text-secondary hover-light',
                                            isActive('admin/almacenes/partes/categorias') ? 'submenu-active' : ''
                                        ]">Categorías</a>
                                    </div>
                                </div>
                                
                                <div x-data="{ openSub: shouldBeOpen(['admin/productos-servicios/servicios']) }" x-init="openSub = shouldBeOpen(['admin/productos-servicios/servicios'])">
                                    <button @click="openSub = !openSub" 
                                            class="nav-link d-flex align-items-center justify-content-between w-100 px-3 py-2 rounded text-start small btn-no-border" 
                                            :class="[
                                                darkMode ? 'text-light-50 hover-dark' : 'text-secondary hover-light',
                                                isActive('admin/productos-servicios/servicios') ? 'submenu-active' : ''
                                            ]">
                                        <span>Servicios</span>
                                        <svg :class="{ 'rotate-180': openSub }" class="ms-2" style="height: 0.75rem; width: 0.75rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>

                                    <div x-show="openSub" class="ps-4">
                                        <a href="{{ route('admin.productos-servicios.servicios.index') }}"
                                        class="nav-link d-block py-2 px-3 rounded small"
                                        :class="[
                                            darkMode ? 'text-light-50 hover-dark' : 'text-secondary hover-light',
                                            isActive('admin/productos-servicios/servicios') && !isActive('admin/productos-servicios/servicios/categorias') ? 'submenu-active' : ''
                                        ]">
                                        Items
                                        </a>

                                        <a href="{{ route('admin.productos-servicios.servicios.categorias.index') }}"
                                        class="nav-link d-block py-2 px-3 rounded small"
                                        :class="[
                                            darkMode ? 'text-light-50 hover-dark' : 'text-secondary hover-light',
                                            isActive('admin/productos-servicios/servicios/categorias') ? 'submenu-active' : ''
                                        ]">
                                        Categorías
                                        </a>
                                    </div>
                                </div>

                                <a href="{{ route('admin.productos-servicios.vehiculos.index') }}"
                                class="nav-link d-block py-2 px-3 rounded small"
                                :class="[
                                    darkMode ? 'text-light-50 hover-dark' : 'text-secondary hover-light',
                                    isActive('admin/productos-servicios/vehiculos') ? 'submenu-active' : ''
                                ]">Vehículos</a>
                            </div>
                        </li>

                        <!-- Inventario -->
                        <li class="nav-item">
                            <button @click="activeMenu = (activeMenu === 'inventario') ? null : 'inventario'"
                                class="nav-link d-flex align-items-center justify-content-between w-100 px-3 py-2 mb-1 rounded text-start btn-no-border"
                                :class="[
                                    darkMode ? 'text-light hover-dark' : 'text-dark hover-light',
                                    activeMenu === 'inventario' || isAnyActive([
                                        'admin/inventario',
                                        'admin/inventario/traslados',
                                        'admin/inventario/movimientos',
                                        'admin/inventario/devoluciones',
                                        'admin/inventario/kardex'
                                    ]) ? 'menu-active' : ''
                                ]">
                                <div class="d-flex align-items-center">
                                    <div class="menu-icon-container me-2"
                                        :class="(activeMenu === 'inventario' || isAnyActive([
                                            'admin/inventario',
                                            'admin/inventario/traslados',
                                            'admin/inventario/movimientos',
                                            'admin/inventario/devoluciones',
                                            'admin/inventario/kardex'
                                        ])) ? 'icon-active' : ''">
                                        <svg xmlns="http://www.w3.org/2000/svg" style="height: 1.25rem; width: 1.25rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                    </div>
                                    <span x-show="!collapsed">Inventario</span>
                                </div>
                                <svg x-show="!collapsed" :class="{ 'rotate-180': activeMenu === 'inventario' }" class="ms-2"
                                    style="height: 1rem; width: 1rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <div x-show="activeMenu === 'inventario' && !collapsed" class="ms-4 my-1">
                                <a href="{{ route('admin.inventario.index') }}"
                                    class="nav-link d-block py-2 px-3 rounded small"
                                    :class="[
                                        darkMode ? 'text-light-50 hover-dark' : 'text-secondary hover-light',
                                        isExactActive('admin/inventario') ? 'submenu-active' : ''
                                    ]">
                                    Reporte Inventario
                                </a>

                                <a href="{{ route('admin.inventario.movimientos.index') }}"
                                    class="nav-link d-block py-2 px-3 rounded small"
                                    :class="[
                                        darkMode ? 'text-light-50 hover-dark' : 'text-secondary hover-light',
                                        isExactActive('admin/inventario/movimientos') ? 'submenu-active' : ''
                                    ]">
                                    Movimientos
                                </a>

                                <a href="{{ route('admin.inventario.traslados.index') }}"
                                    class="nav-link d-block py-2 px-3 rounded small"
                                    :class="[
                                        darkMode ? 'text-light-50 hover-dark' : 'text-secondary hover-light',
                                        isExactActive('admin/inventario/traslados') ? 'submenu-active' : ''
                                    ]">
                                    Traslados
                                </a>

                                <a href="{{ route('admin.inventario.devoluciones.index') }}"
                                    class="nav-link d-block py-2 px-3 rounded small"
                                    :class="[
                                        darkMode ? 'text-light-50 hover-dark' : 'text-secondary hover-light',
                                        isExactActive('admin/inventario/devoluciones') ? 'submenu-active' : ''
                                    ]">
                                    Devolución a proveedor
                                </a>

                                <a href="{{ route('admin.inventario.kardex.form') }}"
                                    class="nav-link d-block py-2 px-3 rounded small"
                                    :class="[
                                        darkMode ? 'text-light-50 hover-dark' : 'text-secondary hover-light',
                                        isExactActive('admin/inventario/kardex') ? 'submenu-active' : ''
                                    ]">
                                    Reporte Kardex
                                </a>
                            </div>
                        </li>

                        <!-- Mantenimiento -->
                        <li class="nav-item">
                            <button @click="activeMenu = (activeMenu === 'mantenimiento') ? null : 'mantenimiento'"
                                    class="nav-link d-flex align-items-center justify-content-between w-100 px-3 py-2 mb-1 rounded text-start btn-no-border"
                                    :class="[
                                        darkMode ? 'text-light hover-dark' : 'text-dark hover-light',
                                        isActive('admin/mantenimiento') ? 'menu-active' : ''
                                    ]">
                                <div class="d-flex align-items-center">
                                    <div class="menu-icon-container me-2" :class="isActive('admin/mantenimiento') ? 'icon-active' : ''">
                                        <i class="fas fa-tools"></i>
                                    </div>
                                    <span x-show="!collapsed">Mantenimiento</span>
                                </div>
                                <svg x-show="!collapsed" :class="{ 'rotate-180': activeMenu === 'mantenimiento' }" class="ms-2" style="height: 1rem; width: 1rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            
                            <div x-show="activeMenu === 'mantenimiento' && !collapsed" class="ms-4 my-1">
                                <!-- Dashboard -->
                                <a href="{{ route('admin.mantenimiento.dashboard') }}"
                                class="nav-link d-block py-2 px-3 rounded small"
                                :class="[
                                    darkMode ? 'text-light-50 hover-dark' : 'text-secondary hover-light',
                                    isActive('admin/mantenimiento/dashboard') ? 'submenu-active' : ''
                                ]">
                                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                                </a>
                                
                                <!-- Citas -->
                                <a href="{{ route('admin.mantenimiento.citas.index') }}"
                                class="nav-link d-block py-2 px-3 rounded small"
                                :class="[
                                    darkMode ? 'text-light-50 hover-dark' : 'text-secondary hover-light',
                                    isActive('admin/mantenimiento/citas') ? 'submenu-active' : ''
                                ]">
                                    <i class="fas fa-calendar-alt me-2"></i>Citas
                                </a>
                                
                                <!-- Órdenes de Trabajo -->
                                <a href="{{ route('admin.mantenimiento.ordenes.index') }}"
                                class="nav-link d-block py-2 px-3 rounded small"
                                :class="[
                                    darkMode ? 'text-light-50 hover-dark' : 'text-secondary hover-light',
                                    isActive('admin/mantenimiento/ordenes') ? 'submenu-active' : ''
                                ]">
                                    <i class="fas fa-tools me-2"></i>Órdenes de Trabajo
                                </a>
                                
                                <!-- Reportes -->
                                <div x-data="{ open: false }">
                                    <button @click="open = !open"
                                            class="nav-link d-flex align-items-center justify-content-between w-100 py-2 px-3 rounded small btn-no-border"
                                            :class="[
                                                darkMode ? 'text-light-50 hover-dark' : 'text-secondary hover-light',
                                                isActive('admin/mantenimiento/reportes') ? 'submenu-active' : ''
                                            ]">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-chart-bar me-2"></i>Reportes
                                        </div>
                                        <svg :class="{ 'rotate-180': open }" style="height: 1rem; width: 1rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>

                                    <div x-show="open" class="ms-3">
                                        <a href="#"
                                        class="nav-link d-block py-2 px-3 rounded smaller"
                                        :class="darkMode ? 'text-light-50 hover-dark' : 'text-secondary hover-light'">
                                            <i class="fas fa-chart-line me-2"></i>Ventas
                                        </a>
                                        <a href="#"
                                        class="nav-link d-block py-2 px-3 rounded smaller"
                                        :class="darkMode ? 'text-light-50 hover-dark' : 'text-secondary hover-light'">
                                            <i class="fas fa-users me-2"></i>Clientes
                                        </a>
                                        <a href="#"
                                        class="nav-link d-block py-2 px-3 rounded smaller"
                                        :class="darkMode ? 'text-light-50 hover-dark' : 'text-secondary hover-light'">
                                            <i class="fas fa-cogs me-2"></i>Servicios
                                        </a>
                                    </div>
                                </div>

                                <!-- Configuración -->
                                <div x-data="{ open: false }">
                                    <button @click="open = !open"
                                            class="nav-link d-flex align-items-center justify-content-between w-100 py-2 px-3 rounded small btn-no-border"
                                            :class="[
                                                darkMode ? 'text-light-50 hover-dark' : 'text-secondary hover-light',
                                                isActive('admin/mantenimiento/configuracion') ? 'submenu-active' : ''
                                            ]">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-cog me-2"></i>Configuración
                                        </div>
                                        <svg :class="{ 'rotate-180': open }" style="height: 1rem; width: 1rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>

                                    <div x-show="open" class="ms-3">
                                        <a href="#"
                                        class="nav-link d-block py-2 px-3 rounded smaller"
                                        :class="darkMode ? 'text-light-50 hover-dark' : 'text-secondary hover-light'">
                                            <i class="fas fa-tags me-2"></i>Servicios
                                        </a>
                                        <a href="#"
                                        class="nav-link d-block py-2 px-3 rounded smaller"
                                        :class="darkMode ? 'text-light-50 hover-dark' : 'text-secondary hover-light'">
                                            <i class="fas fa-boxes me-2"></i>Repuestos
                                        </a>
                                        <a href="#"
                                        class="nav-link d-block py-2 px-3 rounded smaller"
                                        :class="darkMode ? 'text-light-50 hover-dark' : 'text-secondary hover-light'">
                                            <i class="fas fa-user-cog me-2"></i>Técnicos
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <!-- Almacenes -->
                        <li class="nav-item">
                            <a href="{{ route('admin.almacenes.index') }}"
                            class="nav-link d-flex align-items-center px-3 py-2 mb-1 rounded"
                            :class="[
                                darkMode ? 'text-light hover-dark' : 'text-dark hover-light',
                                isActive('admin/almacenes') && !isActive('admin/almacenes/partes') && !isActive('admin/productos-servicios/servicios') && !isActive('admin/almacenes/vehiculos') && !isActive('admin/inventario/movimientos') ? 'menu-active' : ''
                            ]">
                                <div class="menu-icon-container me-2" :class="isActive('admin/almacenes') && !isActive('admin/almacenes/partes') && !isActive('admin/productos-servicios/servicios') && !isActive('admin/almacenes/vehiculos') && !isActive('admin/inventario/movimientos') ? 'icon-active' : ''">
                                    <svg xmlns="http://www.w3.org/2000/svg" style="height: 1.25rem; width: 1.25rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <span x-show="!collapsed">Almacenes</span>
                            </a>
                        </li>
                        
                        <!-- Establecimientos -->
                        <li class="nav-item">
                            <a href="{{ route('admin.establecimientos.index') }}"
                            class="nav-link d-flex align-items-center px-3 py-2 mb-1 rounded"
                            :class="[
                                darkMode ? 'text-light hover-dark' : 'text-dark hover-light',
                                isActive('admin/establecimientos') ? 'menu-active' : ''
                            ]">
                                <div class="menu-icon-container me-2" :class="isActive('admin/establecimientos') ? 'icon-active' : ''">
                                    <svg xmlns="http://www.w3.org/2000/svg" style="height: 1.25rem; width: 1.25rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                                <span x-show="!collapsed">Establecimientos</span>
                            </a>
                        </li>
                        
                        <!-- Talleres -->
                        <li class="nav-item">
                            <a href="{{ route('admin.talleres.index') }}" 
                            class="nav-link d-flex align-items-center px-3 py-2 mb-1 rounded" 
                            :class="[
                                darkMode ? 'text-light hover-dark' : 'text-dark hover-light',
                                isActive('admin/talleres') ? 'menu-active' : ''
                            ]">
                                <div class="menu-icon-container me-2" :class="isActive('admin/talleres') ? 'icon-active' : ''">
                                    <svg xmlns="http://www.w3.org/2000/svg" style="height: 1.25rem; width: 1.25rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                </div>
                                <span x-show="!collapsed">Talleres</span>
                            </a>
                        </li>
                        
                        <!-- Reportes -->
                        <li class="nav-item">
                            <a href="#" 
                            class="nav-link d-flex align-items-center px-3 py-2 mb-1 rounded position-relative" 
                            :class="[
                                darkMode ? 'text-light hover-dark' : 'text-dark hover-light',
                                isActive('admin/reportes') ? 'menu-active' : ''
                            ]">
                                <div class="menu-icon-container me-2" :class="isActive('admin/reportes') ? 'icon-active' : ''">
                                    <svg xmlns="http://www.w3.org/2000/svg" style="height: 1.25rem; width: 1.25rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <span x-show="!collapsed">Reportes</span>
                                <small class="ms-2 d-inline-flex align-items-center">
                                    <span class="badge bg-danger bg-opacity-75 px-2 py-1 rounded-pill" style="font-size: 0.6rem; font-weight: 400;">Prox</span>
                                </small>
                            </a>
                        </li>
                        
                        <!-- Usuarios -->
                        <li class="nav-item">
                            <button @click="activeMenu = (activeMenu === 'usuarios') ? null : 'usuarios'"
                                    class="nav-link d-flex align-items-center justify-content-between w-100 px-3 py-2 mb-1 rounded text-start btn-no-border"
                                    :class="[
                                        darkMode ? 'text-light hover-dark' : 'text-dark hover-light',
                                        isActive('admin/usuarios') ? 'menu-active' : ''
                                    ]">
                                <div class="d-flex align-items-center">
                                    <div class="menu-icon-container me-2" :class="isActive('admin/usuarios') ? 'icon-active' : ''">
                                        <svg xmlns="http://www.w3.org/2000/svg" style="height: 1.25rem; width: 1.25rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <span x-show="!collapsed">Usuarios</span>
                                </div>
                                <svg x-show="!collapsed" :class="{ 'rotate-180': activeMenu === 'usuarios' }" class="ms-2" style="height: 1rem; width: 1rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-show="activeMenu === 'usuarios' && !collapsed" class="ms-4 my-1">
                                <a href="{{ route('admin.usuarios.usuarios.index') }}"
                                class="nav-link d-block py-2 px-3 rounded small position-relative"
                                :class="[
                                    darkMode ? 'text-light-50 hover-dark' : 'text-secondary hover-light',
                                    isActive('admin/usuarios/usuarios') ? 'submenu-active' : ''
                                ]">
                                    Usuarios
                                </a>
                                <a href="{{ route('admin.usuarios.roles.index') }}"
                                class="nav-link d-block py-2 px-3 rounded small position-relative"
                                :class="[
                                    darkMode ? 'text-light-50 hover-dark' : 'text-secondary hover-light',
                                    isActive('admin/usuarios/roles') ? 'submenu-active' : ''
                                ]">
                                    Roles
                                </a>
                            </div>
                        </li>
                        
                        <!-- Configuración -->
                        <li class="nav-item">
                            <button @click="activeMenu = (activeMenu === 'configuracion') ? null : 'configuracion'"
                                    class="nav-link d-flex align-items-center justify-content-between w-100 px-3 py-2 mb-1 rounded text-start btn-no-border"
                                    :class="[
                                        darkMode ? 'text-light hover-dark' : 'text-dark hover-light',
                                        isActive('admin/configuracion') ? 'menu-active' : ''
                                    ]">
                                <div class="d-flex align-items-center">
                                    <div class="menu-icon-container me-2" :class="isActive('admin/configuracion') ? 'icon-active' : ''">
                                        <svg xmlns="http://www.w3.org/2000/svg" style="height: 1.25rem; width: 1.25rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543 .94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543 .826-3.31 2.37-2.37 1 .608 2.296 .07 2.572-1.065z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <span x-show="!collapsed">Configuración</span>
                                </div>
                                <svg x-show="!collapsed" :class="{ 'rotate-180': activeMenu === 'configuracion' }" class="ms-2" style="height: 1rem; width: 1rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-show="activeMenu === 'configuracion' && !collapsed" class="ms-4 my-1">
                                <a href="{{ route('admin.configuracion.maestros.fabricantes.index') }}" 
                                class="nav-link d-block py-2 px-3 rounded small"
                                :class="[
                                    darkMode ? 'text-light-50 hover-dark' : 'text-secondary hover-light',
                                    isActive('admin/configuracion/maestros/fabricantes') ? 'submenu-active' : ''
                                ]">Fabricantes</a>
                                <a href="{{ route('admin.configuracion.maestros.estandar_mantenimiento.index') }}" 
                                class="nav-link d-block py-2 px-3 rounded small"
                                :class="[
                                    darkMode ? 'text-light-50 hover-dark' : 'text-secondary hover-light',
                                    isActive('admin/configuracion/maestros/estandar_mantenimiento') ? 'submenu-active' : ''
                                ]">Estándares de Mantenimiento</a>
                                <a href="{{ route('admin.configuracion.centros_costos.index') }}" 
                                class="nav-link d-block py-2 px-3 rounded small"
                                :class="[
                                    darkMode ? 'text-light-50 hover-dark' : 'text-secondary hover-light',
                                    isActive('admin/configuracion/centros_costos') ? 'submenu-active' : ''
                                ]">Centros de Costos</a>
                                <a href="{{ route('admin.configuracion.maestros.cargos.index') }}" 
                                class="nav-link d-block py-2 px-3 rounded small"
                                :class="[
                                    darkMode ? 'text-light-50 hover-dark' : 'text-secondary hover-light',
                                    isActive('admin/configuracion/maestros/cargos') ? 'submenu-active' : ''
                                ]">Cargos</a>
                                <a href="{{ route('admin.configuracion.maestros.bancos.index') }}" 
                                class="nav-link d-block py-2 px-3 rounded small"
                                :class="[
                                    darkMode ? 'text-light-50 hover-dark' : 'text-secondary hover-light',
                                    isActive('admin/configuracion/maestros/bancos') ? 'submenu-active' : ''
                                ]">Bancos</a>
                                <a href="{{ route('admin.configuracion.unidades.index') }}" 
                                class="nav-link d-block py-2 px-3 rounded small"
                                :class="[
                                    darkMode ? 'text-light-50 hover-dark' : 'text-secondary hover-light',
                                    isActive('admin/configuracion/unidades') ? 'submenu-active' : ''
                                ]">Unidades</a>
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- User Info -->
                <div class="border-top" :class="darkMode ? 'border-dark-custom' : ''">
                    <div class="p-2">
                        <!-- Componente con estado userDropdown -->
                        <div x-data="{ userDropdown: false }" class="position-relative">
                            <!-- Botón para alternar el dropdown -->
                            <button @click="userDropdown = !userDropdown" 
                                    class="btn btn-no-border d-flex align-items-center w-100 text-start p-2 rounded">
                                <img class="rounded-circle me-2" 
                                     style="height: 1.5rem; width: 1.5rem; object-fit: cover;" 
                                     src="{{ Auth::user()->profile_photo_url }}" 
                                     alt="{{ Auth::user()->name }}">
                                <div x-show="!collapsed" class="flex-grow-1 overflow-hidden">
                                    <p class="mb-0 small fw-medium text-truncate" 
                                       :class="darkMode ? 'text-light' : 'text-dark'">
                                        {{ Auth::user()->name }}
                                    </p>
                                    <p class="mb-0 small text-muted text-truncate">
                                        {{ Auth::user()->email }}
                                    </p>
                                </div>
                                <svg x-show="!collapsed" 
                                     xmlns="http://www.w3.org/2000/svg" 
                                     class="ms-2" 
                                     :class="{ 'rotate-180': userDropdown }" 
                                     style="height: 1.25rem; width: 1.25rem;" 
                                     fill="none" 
                                     viewBox="0 0 24 24" 
                                     stroke="currentColor">
                                    <path stroke-linecap="round" 
                                          stroke-linejoin="round" 
                                          stroke-width="2" 
                                          d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <!-- Dropdown del usuario -->
                            <div x-show="userDropdown" 
                                 @click.away="userDropdown = false" 
                                 class="position-absolute bottom-100 start-0 mb-2 bg-white rounded shadow-lg" 
                                 style="width: 14rem; z-index: 1080;" 
                                 :class="darkMode ? 'bg-dark-custom' : ''">
                                <!-- Cerrar sidebar para móviles -->
                                <button @click="sidebarOpen = false; userDropdown = false" 
                                        class="dropdown-item d-md-none d-flex align-items-center py-2 px-3" 
                                        :class="darkMode ? 'text-light hover-dark' : ''">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="me-2" style="height: 1rem; width: 1rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    <span>Cerrar Sidebar</span>
                                </button>

                                <!-- Colapsar/Expandir sidebar -->
                                <button @click="collapsed = !collapsed; userDropdown = false" 
                                        class="dropdown-item d-none d-md-flex align-items-center py-2 px-3" 
                                        :class="darkMode ? 'text-light hover-dark' : ''">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="me-2" style="height: 1rem; width: 1rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                                    </svg>
                                    <span x-text="collapsed ? 'Expandir Sidebar' : 'Contraer Sidebar'"></span>
                                </button>

                                <div class="dropdown-divider my-1" :class="darkMode ? 'border-dark-custom' : ''"></div>

                                <!-- Enlace a perfil -->
                                <a href="{{ route('profile.show') }}" 
                                   class="dropdown-item d-flex align-items-center py-2 px-3" 
                                   :class="darkMode ? 'text-light hover-dark' : ''">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="me-2" style="height: 1rem; width: 1rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <span>Mi Perfil</span>
                                </a>

                                <!-- Alternar modo oscuro -->
                                <button @click="darkMode = !darkMode" 
                                        class="dropdown-item d-flex align-items-center py-2 px-3" 
                                        :class="darkMode ? 'text-light hover-dark' : ''">
                                    <template x-if="darkMode">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="me-2" style="height: 1rem; width: 1rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                    </template>
                                    <template x-if="!darkMode">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="me-2" style="height: 1rem; width: 1rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                                        </svg>
                                    </template>
                                    <span x-text="darkMode ? 'Modo Claro' : 'Modo Oscuro'"></span>
                                </button>

                                <div class="dropdown-divider mt-1" :class="darkMode ? 'border-dark-custom' : ''"></div>

                                <!-- Formulario de logout -->
                                <form method="POST" action="{{ route('logout') }}" x-data>
                                    @csrf
                                    <button type="submit" @click.prevent="$root.submit();" 
                                            class="dropdown-item d-flex align-items-center py-2 px-3 text-danger">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="me-2" style="height: 1rem; width: 1rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        <span>Cerrar Sesión</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="flex-grow-1 overflow-hidden transition-all"
             :class="{ 'ms-0': sidebarOpen && window.innerWidth < 768 }"
             style="transition: margin-left 0.3s ease-in-out;"
             :style="window.innerWidth >= 768 ? (!collapsed ? 'margin-left: 16rem;' : 'margin-left: 5rem;') : (sidebarOpen ? 'margin-left: 0;' : 'margin-left: 0;')">
            <!-- Main Content -->
            <main class="bg-light overflow-auto p-4 w-100" style="min-height: 100vh;" :class="darkMode ? 'bg-dark' : 'bg-light'">
                @if (isset($header))
                    <div class="container-fluid mb-4">{{ $header }}</div>
                @endif
                <div class="container-fluid">@yield('content')</div>
            </main>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Scripts para funcionalidad del sidebar -->
    <script>
        // Script para mantener submenús abiertos según la ruta actual
        document.addEventListener('alpine:init', () => {
            Alpine.data('activeRouteTracker', () => ({
                init() {
                    // Configuración inicial para rutas y submenús
                    const currentPath = window.location.pathname;
                    
                    // Verificar si estamos en una ruta específica
                    this.isInRoute = (path) => {
                        return currentPath.includes(path);
                    };
                    
                    // Determinar qué menús deberían estar abiertos
                    this.shouldOpenMenu = (menuPaths) => {
                        return menuPaths.some(path => currentPath.includes(path));
                    };
                }
            }));
        });

        // Funcionalidad de navegación
        document.addEventListener('alpine:init', () => {
            Alpine.data('navigation', () => ({
                activeSubMenu: '',
                toggleSubMenu(menu) {
                    this.activeSubMenu = this.activeSubMenu === menu ? '' : menu;
                }
            }))
        });

        // Función global para el sidebar de comentarios (si es necesaria)
        window.abrirSidebarComentarios = function(seguimientoId) {
            console.log('Abriendo sidebar para seguimiento:', seguimientoId);
            
            // Si el sidebar no existe, creamos uno simple
            let sidebarComentarios = document.getElementById('sidebarComentarios');
            
            if (!sidebarComentarios) {
                // Crear un sidebar básico
                const sidebarHTML = `
                <div class="offcanvas offcanvas-end" tabindex="-1" id="sidebarComentarios" aria-labelledby="sidebarComentariosLabel">
                    <div class="offcanvas-header border-bottom py-3">
                        <div>
                            <h5 class="offcanvas-title mb-0 d-flex align-items-center" id="sidebarComentariosLabel">
                                <i class="fas fa-comment-dots me-2"></i>
                                Comentarios del seguimiento #${seguimientoId}
                            </h5>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    
                    <div class="offcanvas-body d-flex flex-column p-0">
                        <div class="text-center py-3">
                            <div class="spinner-border text-primary" role="status"></div>
                            <p class="mt-2">Cargando comentarios...</p>
                        </div>
                    </div>
                </div>`;
                
                // Añadir al DOM
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = sidebarHTML;
                document.body.appendChild(tempDiv.firstElementChild);
                
                // Obtener referencia
                sidebarComentarios = document.getElementById('sidebarComentarios');
            }
            
            // Almacenar ID en variable global
            window.seguimientoActual = seguimientoId;
            
            // Inicializar el offcanvas con Bootstrap
            try {
                const bsOffcanvas = new bootstrap.Offcanvas(sidebarComentarios);
                bsOffcanvas.show();
            } catch (error) {
                console.error('Error al inicializar sidebar:', error);
                alert('Error al mostrar la ventana de comentarios. Intente actualizar la página.');
            }
        };
    </script>

    @stack('modals')
    @livewireScripts
    
    <!-- Script de la aplicación -->
    <script src="{{ asset('js/app.js') }}"></script>
    
    @stack('scripts')
</body>
</html>