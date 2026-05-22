@extends('layouts.app')

@section('title', 'Editar Rol')
@section('page-title', 'Editar Rol')
@section('page-subtitle', 'Modifica el nombre del rol o redefine sus permisos asociados')

@section('content')
<div class="card" style="max-width: 800px; margin: 0 auto;">
    <div class="card-header">
        <h2 class="card-title">🔑 Configurar Rol: {{ $role->name }}</h2>
        <a href="{{ route('roles.index') }}" class="btn btn-secondary btn-sm">Volver</a>
    </div>
    <div class="card-body">
        <form action="{{ route('roles.update', $role->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Role Name -->
            <div class="form-group">
                <label for="name">Nombre del Rol</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Nombre del rol" value="{{ old('name', $role->name) }}" required {{ $role->name === 'admin' ? 'readonly' : '' }}>
                @if ($role->name === 'admin')
                    <span class="form-text" style="color: var(--warning)">El nombre del rol de administrador principal no se puede modificar.</span>
                @endif
                @error('name')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <!-- Permissions selection -->
            <div class="form-group" style="margin-top: 2rem;">
                <label>Asignación de Permisos</label>
                <p style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 0.75rem;">Selecciona los permisos válidos para este rol en el sistema.</p>
                
                <div class="checkbox-grid">
                    @foreach ($permissions as $permission)
                        <label class="checkbox-item">
                            <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                {{ in_array($permission->name, $rolePermissions) ? 'checked' : '' }}
                                {{ $role->name === 'admin' ? 'disabled' : '' }}>
                            <span>{{ $permission->name }}</span>
                        </label>
                    @endforeach
                </div>
                @if ($role->name === 'admin')
                    <input type="hidden" name="permissions[]" value="manage roles">
                    <input type="hidden" name="permissions[]" value="manage permissions">
                    <input type="hidden" name="permissions[]" value="manage users">
                    <input type="hidden" name="permissions[]" value="view tasks">
                    <input type="hidden" name="permissions[]" value="create tasks">
                    <input type="hidden" name="permissions[]" value="edit tasks">
                    <input type="hidden" name="permissions[]" value="delete tasks">
                    <span class="form-text" style="color: var(--info)">El rol de administrador tiene todos los permisos asignados por defecto de forma permanente.</span>
                @endif
                @error('permissions')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <!-- Form Actions -->
            <div style="display: flex; gap: 1rem; margin-top: 2.5rem; justify-content: flex-end;">
                <a href="{{ route('roles.index') }}" class="btn btn-secondary">Cancelar</a>
                @if ($role->name !== 'admin')
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                @endif
            </div>
        </form>
    </div>
</div>
@endsection
