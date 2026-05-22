@extends('layouts.app')

@section('title', 'Gestionar Tareas')
@section('page-title', 'Tareas Registradas')
@section('page-subtitle', 'Lista de tareas activas en el sistema de control')

@section('content')
<div class="card">
    <div class="card-header">
        <h2 class="card-title">📋 Panel de Tareas</h2>
        @can('create tasks')
            <a href="{{ route('tasks.create') }}" class="btn btn-primary btn-sm">
                <span>➕</span> Crear Nueva Tarea
            </a>
        @else
            <span style="font-size: 0.85rem; color: var(--text-muted); font-style: italic;">Modo lectura activa</span>
        @endcan
    </div>
    <div class="card-body">
        @if ($tasks->isEmpty())
            <p style="color: var(--text-muted); text-align: center; padding: 3rem 0;">No hay tareas registradas en la base de datos.</p>
        @else
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 80px;">ID</th>
                            <th>Título de la Tarea</th>
                            <th>Usuario Asignado</th>
                            <th style="width: 150px;">Estado</th>
                            <th>Fecha Registro</th>
                            <th style="width: 220px; text-align: right;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tasks as $task)
                            <tr>
                                <td><strong>#{{ $task->id }}</strong></td>
                                <td style="font-weight: 600;">
                                    <a href="{{ route('tasks.show', $task->id) }}" style="color: var(--text-main); hover:color: var(--primary);">
                                        {{ $task->title }}
                                    </a>
                                </td>
                                <td>
                                    @if ($task->assignedUser)
                                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                                            <div class="user-avatar" style="width: 28px; height: 28px; font-size: 0.75rem; background-color: var(--primary-light); color: var(--primary);">
                                                {{ strtoupper(substr($task->assignedUser->name, 0, 1)) }}
                                            </div>
                                            <span>{{ $task->assignedUser->name }}</span>
                                        </div>
                                    @else
                                        <span style="color: var(--text-muted); font-style: italic;">Sin asignar</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($task->status === 'completed')
                                        <span class="badge badge-success">Completado</span>
                                    @elseif ($task->status === 'in_progress')
                                        <span class="badge badge-info">En Progreso</span>
                                    @else
                                        <span class="badge badge-warning">Pendiente</span>
                                    @endif
                                </td>
                                <td style="font-size: 0.85rem; color: var(--text-muted);">
                                    {{ $task->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td style="text-align: right;">
                                    <div class="actions-cell" style="justify-content: flex-end;">
                                        <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-secondary btn-sm" style="padding: 0.4rem 0.6rem;" title="Ver Detalles">
                                            👁️
                                        </a>

                                        @can('edit tasks')
                                            <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-secondary btn-sm">
                                                Editar
                                            </a>
                                        @endcan

                                        @can('delete tasks')
                                            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" onsubmit="return confirm('¿Seguro que desea eliminar la tarea &quot;{{ $task->title }}&quot;?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    Eliminar
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
