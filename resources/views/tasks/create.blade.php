@extends('layouts.app')

@section('title', 'Crear Tarea')
@section('page-title', 'Crear Nueva Tarea')
@section('page-subtitle', 'Define una nueva asignación de trabajo en la plataforma')

@section('content')
<div class="card" style="max-width: 800px; margin: 0 auto;">
    <div class="card-header">
        <h2 class="card-title">📝 Ficha de la Tarea</h2>
        <a href="{{ route('tasks.index') }}" class="btn btn-secondary btn-sm">Volver</a>
    </div>
    <div class="card-body">
        <form action="{{ route('tasks.store') }}" method="POST">
            @csrf

            <!-- Title -->
            <div class="form-group">
                <label for="title">Título de la Tarea</label>
                <input type="text" name="title" id="title" class="form-control" placeholder="Ej. Redactar manual de usuario, corregir bug de login" value="{{ old('title') }}" required autofocus>
                @error('title')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <!-- Description -->
            <div class="form-group">
                <label for="description">Descripción Detallada</label>
                <textarea name="description" id="description" rows="5" class="form-control" placeholder="Describe los requisitos, pasos y resultados esperados para esta tarea...">{{ old('description') }}</textarea>
                @error('description')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-top: 1rem;">
                <!-- Status -->
                <div class="form-group">
                    <label for="status">Estado Inicial</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="pending" {{ old('status') === 'pending' ? 'selected' : '' }}>Pendiente</option>
                        <option value="in_progress" {{ old('status') === 'in_progress' ? 'selected' : '' }}>En Progreso</option>
                        <option value="completed" {{ old('status') === 'completed' ? 'selected' : '' }}>Completada</option>
                    </select>
                    @error('status')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Assigned To -->
                <div class="form-group">
                    <label for="assigned_to">Asignar a Usuario</label>
                    <select name="assigned_to" id="assigned_to" class="form-control">
                        <option value="">-- Sin asignar --</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ old('assigned_to') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('assigned_to')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Form Actions -->
            <div style="display: flex; gap: 1rem; margin-top: 2.5rem; justify-content: flex-end;">
                <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Registrar Tarea</button>
            </div>
        </form>
    </div>
</div>
@endsection
