@extends('layouts.app')

@section('title', 'Registrar Usuario')
@section('page-title', 'Registrar Usuario')
@section('page-subtitle', 'Crea una nueva cuenta de usuario y define sus roles de acceso')

@section('content')
<div class="card" style="max-width: 800px; margin: 0 auto;">
    <div class="card-header">
        <h2 class="card-title">👤 Datos del Nuevo Usuario</h2>
        <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm">Volver</a>
    </div>
    <div class="card-body">
        <form action="{{ route('users.store') }}" method="POST">
            @csrf

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <!-- Name -->
                <div class="form-group">
                    <label for="name">Nombre Completo</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Ej. Juan Pérez" value="{{ old('name') }}" required>
                    @error('name')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="juan@ejemplo.com" value="{{ old('email') }}" required>
                    @error('email')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Password -->
            <div class="form-group" style="margin-top: 1rem;">
                <label for="password">Contraseña Temporal</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Contraseña de al menos 6 caracteres" required>
                @error('password')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <!-- Roles assignment -->
            <div class="form-group" style="margin-top: 2rem;">
                <label>Asignación de Roles</label>
                <p style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 0.75rem;">Selecciona los roles de acceso que tendrá este usuario en el sistema. Los permisos asociados se heredarán automáticamente.</p>
                
                <div class="checkbox-grid">
                    @foreach ($roles as $role)
                        <label class="checkbox-item">
                            <input type="checkbox" name="roles[]" value="{{ $role->name }}"
                                {{ is_array(old('roles')) && in_array($role->name, old('roles')) ? 'checked' : '' }}>
                            <span>{{ $role->name }}</span>
                        </label>
                    @endforeach
                </div>
                @error('roles')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <!-- Form Actions -->
            <div style="display: flex; gap: 1rem; margin-top: 2.5rem; justify-content: flex-end;">
                <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Registrar Usuario</button>
            </div>
        </form>
    </div>
</div>
@endsection
