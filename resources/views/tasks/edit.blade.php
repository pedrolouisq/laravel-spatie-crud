@extends('layouts.app')

@section('title', 'Editar Tarea')
@section('page-title', 'Editar Tarea')
@section('page-subtitle', 'Modifica los parámetros de la tarea seleccionada')

@section('content')
<div class="card" style="max-width: 800px; margin: 0 auto;">
    <div class="card-header">
        <h2 class="card-title">📝 Editar Tarea #{{ $task->id }}</h2>
        <a href="{{ route('tasks.index') }}" class="btn btn-secondary btn-sm">Volver</a>
    </div>
    <div class="card-body">
        <form action="{{ route('tasks.update', $task->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Title -->
            <div class="form-group">
                <label for="title">Título de la Tarea</label>
                <input type="text" name="title" id="title" class="form-control" placeholder="Título de la tarea" value="{{ old('title', $task->title) }}" required autofocus>
                @error('title')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <!-- Description -->
            <div class="form-group">
                <label for="description">Descripción Detallada</label>
                <textarea name="description" id="description" rows="5" class="form-control" placeholder="Descripción de la tarea...">{{ old('description', $task->description) }}</textarea>
                @error('description')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-top: 1rem;">
                <!-- Status -->
                <div class="form-group">
                    <label for="status">Estado de la Tarea</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="pending" {{ old('status', $task->status) === 'pending' ? 'selected' : '' }}>Pendiente</option>
                        <option value="in_progress" {{ old('status', $task->status) === 'in_progress' ? 'selected' : '' }}>En Progreso</option>
                        <option value="completed" {{ old('status', $task->status) === 'completed' ? 'selected' : '' }}>Completada</option>
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
                            <option value="{{ $user->id }}" {{ old('assigned_to', $task->assigned_to) == $user->id ? 'selected' : '' }}>
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
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            </div>
        </form>
    </div>
</div>
@endsection
