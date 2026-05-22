@extends('layouts.app')

@section('title', 'Detalles de la Tarea')
@section('page-title', 'Detalles de la Tarea')
@section('page-subtitle', 'Consulta la ficha completa de la tarea y sus datos de seguimiento')

@section('content')
<div class="card" style="max-width: 800px; margin: 0 auto;">
    <div class="card-header">
        <h2 class="card-title">📝 Tarea #{{ $task->id }}</h2>
        <div style="display: flex; gap: 0.5rem; align-items: center;">
            <a href="{{ route('tasks.index') }}" class="btn btn-secondary btn-sm">Volver al listado</a>
            @can('edit tasks')
                <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-primary btn-sm">Editar Tarea</a>
            @endcan
        </div>
    </div>
    <div class="card-body" style="padding: 2.5rem;">
        <!-- Title -->
        <h1 style="font-size: 1.85rem; font-weight: 700; margin-bottom: 1.5rem; color: var(--text-main); letter-spacing: -0.5px;">
            {{ $task->title }}
        </h1>

        <!-- Status & Assigned User Meta Row -->
        <div style="display: flex; flex-wrap: wrap; gap: 2rem; border-top: 1px solid var(--border-color); border-bottom: 1px solid var(--border-color); padding: 1.25rem 0; margin-bottom: 2rem;">
            <div>
                <span style="display: block; font-size: 0.8rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; margin-bottom: 0.25rem;">Estado actual</span>
                @if ($task->status === 'completed')
                    <span class="badge badge-success" style="font-size: 0.85rem; padding: 0.35rem 0.85rem;">Completado</span>
                @elseif ($task->status === 'in_progress')
                    <span class="badge badge-info" style="font-size: 0.85rem; padding: 0.35rem 0.85rem;">En Progreso</span>
                @else
                    <span class="badge badge-warning" style="font-size: 0.85rem; padding: 0.35rem 0.85rem;">Pendiente</span>
                @endif
            </div>

            <div>
                <span style="display: block; font-size: 0.8rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; margin-bottom: 0.25rem;">Usuario Asignado</span>
                @if ($task->assignedUser)
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <div class="user-avatar" style="width: 26px; height: 26px; font-size: 0.75rem; background-color: var(--primary-light); color: var(--primary);">
                            {{ strtoupper(substr($task->assignedUser->name, 0, 1)) }}
                        </div>
                        <span style="font-weight: 600; font-size: 0.95rem;">{{ $task->assignedUser->name }}</span>
                    </div>
                @else
                    <span style="color: var(--text-muted); font-size: 0.95rem; font-style: italic;">Sin asignar</span>
                @endif
            </div>

            <div>
                <span style="display: block; font-size: 0.8rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; margin-bottom: 0.25rem;">Creada el</span>
                <span style="font-weight: 500; font-size: 0.95rem; color: var(--text-main);">
                    {{ $task->created_at->format('d \d\e F \d\e Y, H:i') }}
                </span>
            </div>
        </div>

        <!-- Description -->
        <div>
            <span style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; margin-bottom: 0.75rem;">Descripción de la tarea</span>
            <div style="background-color: #fafbfd; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 1.5rem; color: var(--text-main); font-size: 1rem; line-height: 1.6; white-space: pre-line;">
                {{ $task->description ?: 'No se ha proporcionado ninguna descripción para esta tarea.' }}
            </div>
        </div>

        <!-- Actions footer -->
        @can('delete tasks')
            <div style="display: flex; justify-content: flex-end; margin-top: 3rem; border-top: 1px solid var(--border-color); padding-top: 1.5rem;">
                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" onsubmit="return confirm('¿Seguro que desea eliminar esta tarea permanentemente?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        ❌ Eliminar Tarea
                    </button>
                </form>
            </div>
        @endcan
    </div>
</div>
@endsection
