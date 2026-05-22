@extends('layouts.app')

@section('title', 'Editar Permiso')
@section('page-title', 'Editar Permiso')
@section('page-subtitle', 'Modifica el nombre identificador del permiso')

@section('content')
<div class="card" style="max-width: 600px; margin: 0 auto;">
    <div class="card-header">
        <h2 class="card-title">🛡️ Editar Permiso #{{ $permission->id }}</h2>
        <a href="{{ route('permissions.index') }}" class="btn btn-secondary btn-sm">Volver</a>
    </div>
    <div class="card-body">
        <form action="{{ route('permissions.update', $permission->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Permission Name -->
            <div class="form-group">
                <label for="name">Nombre del Permiso</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Nombre del permiso" value="{{ old('name', $permission->name) }}" required autofocus>
                @error('name')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <!-- Form Actions -->
            <div style="display: flex; gap: 1rem; margin-top: 2.5rem; justify-content: flex-end;">
                <a href="{{ route('permissions.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            </div>
        </form>
    </div>
</div>
@endsection
