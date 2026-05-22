@extends('layouts.app')

@section('title', 'Crear Permiso')
@section('page-title', 'Crear Permiso')
@section('page-subtitle', 'Agrega un nuevo permiso individual que pueda ser asignado a roles')

@section('content')
<div class="card" style="max-width: 600px; margin: 0 auto;">
    <div class="card-header">
        <h2 class="card-title">🛡️ Configurar Nuevo Permiso</h2>
        <a href="{{ route('permissions.index') }}" class="btn btn-secondary btn-sm">Volver</a>
    </div>
    <div class="card-body">
        <form action="{{ route('permissions.store') }}" method="POST">
            @csrf

            <!-- Permission Name -->
            <div class="form-group">
                <label for="name">Nombre del Permiso</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Ej. publicar posts, exportar reportes" value="{{ old('name') }}" required autofocus>
                <span class="form-text">Usa minúsculas y espacios o guiones bajos para seguir el estándar (Ej: <code>crear reportes</code> o <code>crear_reportes</code>).</span>
                @error('name')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <!-- Form Actions -->
            <div style="display: flex; gap: 1rem; margin-top: 2.5rem; justify-content: flex-end;">
                <a href="{{ route('permissions.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Crear Permiso</button>
            </div>
        </form>
    </div>
</div>
@endsection
