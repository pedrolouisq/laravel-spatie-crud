@extends('layouts.app')

@section('title', 'Crear Rol')
@section('page-title', 'Crear Rol')
@section('page-subtitle', 'Agrega un nuevo rol al sistema y define sus permisos asociados')

@section('content')
<div class="card" style="max-width: 800px; margin: 0 auto;">
    <div class="card-header">
        <h2 class="card-title">🔑 Configurar Nuevo Rol</h2>
        <a href="{{ route('roles.index') }}" class="btn btn-secondary btn-sm">Volver</a>
    </div>
    <div class="card-body">
        <form action="{{ route('roles.store') }}" method="POST">
            @csrf

            <!-- Role Name -->
            <div class="form-group">
                <label for="name">Nombre del Rol</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Ej. moderador, auditor, soporte" value="{{ old('name') }}" required>
                @error('name')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <!-- Permissions selection -->
            <div class="form-group" style="margin-top: 2rem;">
                <label>Selecciona los Permisos para este Rol</label>
                <p style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 0.75rem;">Los usuarios asignados a este rol heredarán todos los permisos seleccionados a continuación.</p>
                
                <div class="checkbox-grid">
                    @foreach ($permissions as $permission)
                        <label class="checkbox-item">
                            <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                {{ is_array(old('permissions')) && in_array($permission->name, old('permissions')) ? 'checked' : '' }}>
                            <span>{{ $permission->name }}</span>
                        </label>
                    @endforeach
                </div>
                @error('permissions')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <!-- Form Actions -->
            <div style="display: flex; gap: 1rem; margin-top: 2.5rem; justify-content: flex-end;">
                <a href="{{ route('roles.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Crear Rol</button>
            </div>
        </form>
    </div>
</div>
@endsection
