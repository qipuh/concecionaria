@extends('admin.layouts.app')

@section('title', 'Crear Técnico')

@section('header', 'Nuevo Técnico')

@section('content')
<div class="dashboard-hero" style="padding: 2rem 2rem; border-radius: 0 0 1.5rem 1.5rem; margin-bottom: 2.5rem;">
    <div class="hero-glow-alt" style="top: -50px; right: 0; filter: blur(60px); opacity: 0.2;"></div>
    <div class="container-fluid position-relative z-1">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center">
            <div class="mb-3 mb-lg-0">
                <div class="d-inline-flex align-items-center px-3 py-1 bg-white bg-opacity-10 rounded-pill fs-6 mb-3 border border-white border-opacity-25">
                    <i class="fas fa-tools text-warning me-2"></i> Mantenimiento
                </div>
                <h2 class="fw-bold mb-1 tracking-tight text-white display-6 text-shadow-sm">Registrar Nuevo Técnico</h2>
                <p class="text-white-50 mb-0">Agrega un técnico al equipo del taller</p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('admin.mantenimiento.tecnicos.index') }}" class="btn bg-white text-dark rounded-pill px-4 py-2 fw-bold shadow-sm border-0">
                    <i class="fas fa-arrow-left me-2"></i> Volver
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid px-3 px-lg-4 position-relative" style="top: -3.5rem; z-index: 10;">
    <form action="{{ route('admin.mantenimiento.tecnicos.store') }}" method="POST">
        @csrf

        <!-- Información de Usuario -->
        <div class="card dashboard-card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                <h6 class="fw-bold mb-0"><i class="fas fa-user me-2 text-primary"></i> Información de Usuario</h6>
            </div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label fw-semibold small text-uppercase text-muted">Nombre Completo <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                               id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="form-label fw-semibold small text-uppercase text-muted">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                               id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="password" class="form-label fw-semibold small text-uppercase text-muted">Contraseña <span class="text-danger">*</span></label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                               id="password" name="password" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="password_confirmation" class="form-label fw-semibold small text-uppercase text-muted">Confirmar Contraseña <span class="text-danger">*</span></label>
                        <input type="password" class="form-control"
                               id="password_confirmation" name="password_confirmation" required>
                    </div>
                </div>
            </div>
        </div>

        <!-- Información Profesional -->
        <div class="card dashboard-card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                <h6 class="fw-bold mb-0"><i class="fas fa-tools me-2 text-primary"></i> Información Profesional</h6>
            </div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="codigo" class="form-label fw-semibold small text-uppercase text-muted">Código <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('codigo') is-invalid @enderror"
                               id="codigo" name="codigo" value="{{ old('codigo') }}" required>
                        @error('codigo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="especialidad" class="form-label fw-semibold small text-uppercase text-muted">Especialidad</label>
                        <input type="text" class="form-control @error('especialidad') is-invalid @enderror"
                               id="especialidad" name="especialidad" value="{{ old('especialidad') }}"
                               placeholder="Ej: Mecánica, Electricidad, Pintura">
                        @error('especialidad')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="cedula_profesional" class="form-label fw-semibold small text-uppercase text-muted">Cédula Profesional</label>
                        <input type="text" class="form-control @error('cedula_profesional') is-invalid @enderror"
                               id="cedula_profesional" name="cedula_profesional" value="{{ old('cedula_profesional') }}">
                        @error('cedula_profesional')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="telefono" class="form-label fw-semibold small text-uppercase text-muted">Teléfono</label>
                        <input type="text" class="form-control @error('telefono') is-invalid @enderror"
                               id="telefono" name="telefono" value="{{ old('telefono') }}">
                        @error('telefono')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="telefono_emergencia" class="form-label fw-semibold small text-uppercase text-muted">Teléfono de Emergencia</label>
                        <input type="text" class="form-control @error('telefono_emergencia') is-invalid @enderror"
                               id="telefono_emergencia" name="telefono_emergencia" value="{{ old('telefono_emergencia') }}">
                        @error('telefono_emergencia')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="fecha_ingreso" class="form-label fw-semibold small text-uppercase text-muted">Fecha de Ingreso</label>
                        <input type="date" class="form-control @error('fecha_ingreso') is-invalid @enderror"
                               id="fecha_ingreso" name="fecha_ingreso" value="{{ old('fecha_ingreso', date('Y-m-d')) }}">
                        @error('fecha_ingreso')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <label for="estado" class="form-label fw-semibold small text-uppercase text-muted">Estado <span class="text-danger">*</span></label>
                        <select class="form-select @error('estado') is-invalid @enderror"
                                id="estado" name="estado" required>
                            <option value="activo" {{ old('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
                            <option value="inactivo" {{ old('estado') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                            <option value="vacaciones" {{ old('estado') == 'vacaciones' ? 'selected' : '' }}>Vacaciones</option>
                            <option value="licencia" {{ old('estado') == 'licencia' ? 'selected' : '' }}>Licencia</option>
                        </select>
                        @error('estado')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="certificaciones" class="form-label fw-semibold small text-uppercase text-muted">Certificaciones</label>
                        <textarea class="form-control @error('certificaciones') is-invalid @enderror"
                                  id="certificaciones" name="certificaciones" rows="3"
                                  placeholder="Lista las certificaciones del técnico">{{ old('certificaciones') }}</textarea>
                        @error('certificaciones')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="habilidades" class="form-label fw-semibold small text-uppercase text-muted">Habilidades</label>
                        <textarea class="form-control @error('habilidades') is-invalid @enderror"
                                  id="habilidades" name="habilidades" rows="3"
                                  placeholder="Lista las habilidades técnicas">{{ old('habilidades') }}</textarea>
                        @error('habilidades')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <label for="notas" class="form-label fw-semibold small text-uppercase text-muted">Notas Adicionales</label>
                        <textarea class="form-control @error('notas') is-invalid @enderror"
                                  id="notas" name="notas" rows="3"
                                  placeholder="Notas adicionales sobre el técnico">{{ old('notas') }}</textarea>
                        @error('notas')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('admin.mantenimiento.tecnicos.index') }}" class="btn btn-outline-secondary rounded-pill px-4 py-2 fw-bold border-0">
                        <i class="fas fa-times me-1"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow-sm border-0">
                        <i class="fas fa-save me-1"></i> Guardar Técnico
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
