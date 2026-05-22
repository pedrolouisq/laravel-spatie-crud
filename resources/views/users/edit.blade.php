@extends('layouts.app')

@section('title', 'Editar Usuario')
@section('page-title', 'Editar Usuario')
@section('page-subtitle', 'Modifica la información básica o redefine los roles del usuario')

@section('content')
<div class="card" style="max-width: 800px; margin: 0 auto;">
    <div class="card-header">
        <h2 class="card-title">👤 Configurar Cuenta: {{ $user->name }}</h2>
        <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm">Volver</a>
    </div>
    <div class="card-body">
        <form action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <!-- Name -->
                <div class="form-group">
                    <label for="name">Nombre Completo</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Nombre completo" value="{{ old('name', $user->name) }}" required>
                    @error('name')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Correo electrónico" value="{{ old('email', $user->email) }}" required {{ $user->email === 'admin@example.com' ? 'readonly' : '' }}>
                    @if ($user->email === 'admin@example.com')
                        <span class="form-text" style="color: var(--warning)">El correo del administrador principal no puede ser modificado.</span>
                    @endif
                    @error('email')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Password -->
            <div class="form-group" style="margin-top: 1rem;">
                <label for="password">Contraseña (Dejar en blanco para mantener la actual)</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Nueva contraseña de al menos 6 caracteres">
                @error('password')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <!-- Roles assignment -->
            <div class="form-group" style="margin-top: 2rem;">
                <label>Roles Asignados</label>
                <p style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 0.75rem;">Modifica los roles de acceso para este usuario en el sistema.</p>
                
                <div class="checkbox-grid">
                    @foreach ($roles as $role)
                        <label class="checkbox-item">
                            <input type="checkbox" name="roles[]" value="{{ $role->name }}"
                                {{ in_array($role->name, $userRoles) ? 'checked' : '' }}
                                {{ $user->email === 'admin@example.com' && $role->name === 'admin' ? 'disabled' : '' }}>
                            <span>{{ $role->name }}</span>
                        </label>
                    @endforeach
                </div>
                @if ($user->email === 'admin@example.com')
                    <input type="hidden" name="roles[]" value="admin">
                    <span class="form-text" style="color: var(--info)">El rol del administrador principal no puede ser revocado.</span>
                @endif
                @error('roles')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <!-- Form Actions -->
            <div style="display: flex; gap: 1rem; margin-top: 2.5rem; justify-content: flex-end;">
                <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            </div>
        </form>
    </div>
</div>
@endsection
