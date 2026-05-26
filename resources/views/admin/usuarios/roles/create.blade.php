@extends('admin.layouts.app')

@section('title', 'Nuevo Rol')

@section('header', 'Nuevo Rol')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-xxl-10">
            <div class="card shadow-sm">
                <div class="card-header d-flex align-items-center bg-primary text-white">
                    <h3 class="mb-0"><i class="fas fa-user-shield me-2"></i> Crear Rol</h3>
                </div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.usuarios.roles.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Nombre del Rol <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name') }}" required>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="description" class="form-label">Descripción (opcional)</label>
                                <input type="text" name="description" id="description"
                                       class="form-control @error('description') is-invalid @enderror"
                                       value="{{ old('description') }}">
                                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label"><strong>Permisos del Sistema</strong></label>
                            <p class="text-muted small mb-3">
                                Asigna permisos de forma granular: marca módulo completo, submódulo o acciones específicas (Ver, Crear, Editar, Eliminar, etc.).
                            </p>

                            @include('admin.usuarios.roles.partials.permissions-tree', [
                                'permissions' => $permissions,
                                'assignedIds' => [],
                            ])

                            @error('permissions') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2 border-top pt-3">
                            <a href="{{ route('admin.usuarios.roles.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Crear Rol
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
