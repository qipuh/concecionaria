@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('header')
    <h1 class="text-2xl font-bold text-gray-800 dark:text-white">MSA Automotriz</h1>
@endsection

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Widget: Total de Usuarios -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Total de Usuarios</h2>
            <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ $totalUsuarios }}</p>
        </div>

        <!-- Widget: Ventas del Mes -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Ventas del Mes</h2>
            <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">3000</p>
        </div>

        <!-- Widget: Órdenes Pendientes -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Órdenes Pendientes</h2>
            <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">400</p>
        </div>
    </div>
@endsection