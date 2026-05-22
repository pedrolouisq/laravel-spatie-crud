@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Resumen general y estadísticas del sistema')

@section('content')
<!-- Statistics Cards Grid -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon primary">📝</div>
        <div class="stat-info">
            <span class="stat-value">{{ $taskCount }}</span>
            <span class="stat-label">Tareas Totales</span>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon info">👤</div>
        <div class="stat-info">
            <span class="stat-value">{{ $userCount }}</span>
            <span class="stat-label">Usuarios Registrados</span>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon warning">🔑</div>
        <div class="stat-info">
            <span class="stat-value">{{ $roleCount }}</span>
            <span class="stat-label">Roles</span>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon success">🛡️</div>
        <div class="stat-info">
            <span class="stat-value">{{ $permissionCount }}</span>
            <span class="stat-label">Permisos</span>
        </div>
    </div>
</div>

<!-- Dashboard Grid (Main & Sidebar Columns) -->
<div class="dashboard-grid">
    <!-- Column 1: Recent Tasks -->
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">📝 Tareas Recientes en el Sistema</h2>
            @can('view tasks')
                <a href="{{ route('tasks.index') }}" class="btn btn-secondary btn-sm">Ver todas las tareas</a>
            @endcan
        </div>
        <div class="card-body">
            @if ($recentTasks->isEmpty())
                <p style="color: var(--text-muted); text-align: center; padding: 2rem 0;">No hay tareas registradas en el sistema.</p>
            @else
                <div class="recent-tasks-list">
                    @foreach ($recentTasks as $task)
                        <div class="recent-task-item">
                            <div class="recent-task-info">
                                <span class="recent-task-title">{{ $task->title }}</span>
                                <span class="recent-task-desc">
                                    Asignada a: 
                                    <strong>{{ $task->assignedUser->name ?? 'Sin asignar' }}</strong>
                                </span>
                            </div>
                            <div>
                                @if ($task->status === 'completed')
                                    <span class="badge badge-success">Completado</span>
                                @elseif ($task->status === 'in_progress')
                                    <span class="badge badge-info">En Progreso</span>
                                @else
                                    <span class="badge badge-warning">Pendiente</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Column 2: Status Distribution Chart -->
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">📊 Estado de Tareas</h2>
        </div>
        <div class="card-body" style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
            <div class="chart-placeholder-card" style="width: 100%; border: none; padding: 0; min-height: auto;">
                <div class="chart-visual-row">
                    @php
                        $maxCount = max(array_values($tasksByStatus)) ?: 1;
                        $pendingHeight = ($tasksByStatus['pending'] / $maxCount) * 100;
                        $progressHeight = ($tasksByStatus['in_progress'] / $maxCount) * 100;
                        $completedHeight = ($tasksByStatus['completed'] / $maxCount) * 100;
                    @endphp
                    
                    <div class="chart-bar-group">
                        <div class="chart-bar pending" style="height: {{ max($pendingHeight, 15) }}px;" title="{{ $tasksByStatus['pending'] }} pendientes"></div>
                        <span class="chart-label">Pend: {{ $tasksByStatus['pending'] }}</span>
                    </div>

                    <div class="chart-bar-group">
                        <div class="chart-bar in-progress" style="height: {{ max($progressHeight, 15) }}px;" title="{{ $tasksByStatus['in_progress'] }} en progreso"></div>
                        <span class="chart-label">Prog: {{ $tasksByStatus['in_progress'] }}</span>
                    </div>

                    <div class="chart-bar-group">
                        <div class="chart-bar completed" style="height: {{ max($completedHeight, 15) }}px;" title="{{ $tasksByStatus['completed'] }} completadas"></div>
                        <span class="chart-label">Compl: {{ $tasksByStatus['completed'] }}</span>
                    </div>
                </div>
                <p style="font-size: 0.85rem; color: var(--text-muted); text-align: center; margin-top: 1rem;">
                    Distribución porcentual según las tareas registradas en la base de datos local.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
