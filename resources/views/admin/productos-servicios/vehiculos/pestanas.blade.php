@extends('admin.layouts.app')

@section('title', 'Catálogo de Vehículos')

@section('header', 'Catálogo de Vehículos')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <h2 class="h4 fw-bold mb-4" :class="darkMode ? 'text-light' : 'text-dark'">
                    Gestión del Catálogo de Vehículos
                </h2>

                <!-- Pestañas -->
                <ul class="nav nav-tabs mb-4" id="vehiculosTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="vehiculoscat-tab" data-bs-toggle="tab" data-bs-target="#vehiculoscat" 
                           href="{{ route('admin.productos-servicios.vehiculos.caracteristicas.vehiculo.index') }}" type="button" role="tab" 
                           aria-controls="vehiculoscat" aria-selected="true">Vehículos Catálogo</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="marcas-tab" data-bs-toggle="tab" data-bs-target="#marcas" 
                           href="{{ route('admin.productos-servicios.vehiculos.caracteristicas.marcas.index') }}" type="button" role="tab" 
                           aria-controls="marcas" aria-selected="false">Marcas</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="modelos-tab" data-bs-toggle="tab" data-bs-target="#modelos" 
                           href="{{ route('admin.productos-servicios.vehiculos.caracteristicas.modelos.index') }}" type="button" role="tab" 
                           aria-controls="modelos" aria-selected="false">Modelos</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="versiones-tab" data-bs-toggle="tab" data-bs-target="#versiones" 
                           href="{{ route('admin.productos-servicios.vehiculos.caracteristicas.versiones.index') }}" type="button" role="tab" 
                           aria-controls="versiones" aria-selected="false">Versiones</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="anios-modelo-tab" data-bs-toggle="tab" data-bs-target="#anios-modelo" 
                           href="{{ route('admin.productos-servicios.vehiculos.caracteristicas.anios-modelo.index') }}" type="button" role="tab" 
                           aria-controls="anios-modelo" aria-selected="false">Años de Modelo</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="colores-tab" data-bs-toggle="tab" data-bs-target="#colores" 
                           href="{{ route('admin.productos-servicios.vehiculos.caracteristicas.colores.index') }}" type="button" role="tab" 
                           aria-controls="colores" aria-selected="false">Colores</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="importar-tab" data-bs-toggle="tab" data-bs-target="#importar" 
                           href="{{ route('admin.productos-servicios.vehiculos.import.form') }}" type="button" role="tab" 
                           aria-controls="importar" aria-selected="false">Importar Excel</a>
                    </li>
                </ul>

                <!-- Contenido de las Pestañas -->
                <div class="tab-content" id="vehiculosTabContent">
                    <!-- Vehículos Catálogo -->
                    <div class="tab-pane fade show active" id="vehiculoscat" role="tabpanel" aria-labelledby="vehiculoscat-tab">
                        <div id="vehiculoscat-content"></div>
                    </div>
                    <!-- Marcas -->
                    <div class="tab-pane fade" id="marcas" role="tabpanel" aria-labelledby="marcas-tab">
                        <div id="marcas-content"></div>
                    </div>
                    <!-- Modelos -->
                    <div class="tab-pane fade" id="modelos" role="tabpanel" aria-labelledby="modelos-tab">
                        <div id="modelos-content"></div>
                    </div>
                    <!-- Versiones -->
                    <div class="tab-pane fade" id="versiones" role="tabpanel" aria-labelledby="versiones-tab">
                        <div id="versiones-content"></div>
                    </div>
                    <!-- Años de Modelo -->
                    <div class="tab-pane fade" id="anios-modelo" role="tabpanel" aria-labelledby="anios-modelo-tab">
                        <div id="anios-modelo-content"></div>
                    </div>
                    <!-- Colores -->
                    <div class="tab-pane fade" id="colores" role="tabpanel" aria-labelledby="colores-tab">
                        <div id="colores-content"></div>
                    </div>
                    <!-- Importar Excel -->
                    <div class="tab-pane fade" id="importar" role="tabpanel" aria-labelledby="importar-tab">
                        <div id="importar-content">
                            @if (session('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('success') }}
                                </div>
                            @endif
                            @if (session('error'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('error') }}
                                </div>
                            @endif
                            <form action="{{ route('admin.productos-servicios.vehiculos.import') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md">
                                @csrf
                                <div class="mb-4">
                                    <label for="file" class="block text-sm font-medium text-gray-700">Seleccionar archivo Excel</label>
                                    <input type="file" name="file" id="file" accept=".xlsx,.xls" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    @error('file')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Importar
                                </button>
                            </form>
                            <div class="mt-6">
                                <h2 class="text-lg font-semibold">Formato del archivo Excel</h2>
                                <p class="text-gray-600">El archivo Excel debe tener las siguientes columnas:</p>
                                <ul class="list-disc pl-5 mt-2">
                                    <li><strong>Fecha de compra</strong>: Formato YYYY-MM-DD (ej. 2025-05-21)</li>
                                    <li><strong>Precio compra</strong>: Número (ej. 25000.50)</li>
                                    <li><strong>Nro de factura</strong>: Texto (ej. INV-12345)</li>
                                    <li><strong>Marca</strong>: Nombre de la marca (ej. Toyota)</li>
                                    <li><strong>Modelo</strong>: Nombre del modelo (ej. Corolla)</li>
                                    <li><strong>Version</strong>: Nombre de la versión (ej. GLi)</li>
                                    <li><strong>Año</strong>: Año del modelo (ej. 2023)</li>
                                    <li><strong>Serie VIN</strong>: Número VIN (ej. 1HGCM82633A004352)</li>
                                    <li><strong>Color</strong>: Nombre del color (ej. Rojo)</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Cargar contenido de la pestaña activa por defecto
    loadTabContent('vehiculoscat');
    
    // Manejar clics en las pestañas
    document.querySelectorAll('#vehiculosTab a').forEach(function(tab) {
        tab.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Desactivar todas las pestañas
            document.querySelectorAll('#vehiculosTab a').forEach(function(t) {
                t.classList.remove('active');
                let tabPanel = document.querySelector(t.getAttribute('data-bs-target'));
                if (tabPanel) {
                    tabPanel.classList.remove('show', 'active');
                }
            });
            
            // Activar esta pestaña
            this.classList.add('active');
            let targetPanel = document.querySelector(this.getAttribute('data-bs-target'));
            if (targetPanel) {
                targetPanel.classList.add('show', 'active');
            }
            
            // Obtener el ID del tab
            let tabId = this.getAttribute('id').replace('-tab', '');
            
            // No cargar contenido para la pestaña de importar, ya que está renderizada directamente
            if (tabId !== 'importar') {
                loadTabContent(tabId);
            }
        });
    });
    
    function loadTabContent(tabId) {
        let url = document.getElementById(tabId + '-tab').getAttribute('href');
        
        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.text();
            })
            .then(html => {
                let tempDiv = document.createElement('div');
                tempDiv.innerHTML = html;
                
                let content = null;
                let mainContent = tempDiv.querySelector('.card-body');
                if (mainContent) {
                    content = mainContent.innerHTML;
                } else if (tempDiv.querySelector('#app')) {
                    let appContent = tempDiv.querySelector('#app').querySelector('.container');
                    if (appContent) {
                        content = appContent.innerHTML;
                    }
                } else if (tempDiv.querySelector('.container')) {
                    content = tempDiv.querySelector('.container').innerHTML;
                } else {
                    let scripts = tempDiv.querySelectorAll('script');
                    scripts.forEach(s => s.remove());
                    let head = tempDiv.querySelector('head');
                    if (head) head.remove();
                    content = tempDiv.innerHTML;
                }
                
                document.getElementById(tabId + '-content').innerHTML = content;
                
                if (typeof bootstrap !== 'undefined') {
                    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                    tooltipTriggerList.map(function (tooltipTriggerEl) {
                        return new bootstrap.Tooltip(tooltipTriggerEl);
                    });
                }
            })
            .catch(error => {
                console.error('Error al cargar el contenido:', error);
                document.getElementById(tabId + '-content').innerHTML = 
                    '<div class="alert alert-danger">Error al cargar el contenido: ' + error.message + '</div>';
            });
    }
});
</script>
@endpush
@endsection