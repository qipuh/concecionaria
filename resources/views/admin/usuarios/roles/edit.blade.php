@extends('admin.layouts.app')

@section('title', 'Nuevo Rol')

@section('header', 'Nuevo Rol')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>Editar Rol: {{ $rol->name }}</h3>
                </div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.usuarios.roles.update', $rol) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $rol->name) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Descripción (opcional)</label>
                            <textarea name="description" id="description" class="form-control">{{ old('description', $rol->description) }}</textarea>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Actualizar Rol</button>
                            <a href="{{ route('admin.usuarios.roles.index') }}" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection