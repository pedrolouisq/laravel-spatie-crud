@extends('layouts.app')

@section('title', 'Gestionar Permisos')
@section('page-title', 'Permisos del Sistema')
@section('page-subtitle', 'Administra los permisos individuales definidos en la aplicación')

@section('content')
<div class="card" style="max-width: 900px; margin: 0 auto;">
    <div class="card-header">
        <h2 class="card-title">🛡️ Lista de Permisos</h2>
        <a href="{{ route('permissions.create') }}" class="btn btn-primary btn-sm">
            <span>➕</span> Crear Nuevo Permiso
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 100px;">ID</th>
                        <th>Nombre del Permiso</th>
                        <th style="width: 180px; text-align: right;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($permissions as $permission)
                        <tr>
                            <td><strong>#{{ $permission->id }}</strong></td>
                            <td>
                                <code style="font-family: monospace; font-size: 0.95rem; background-color: #f1f5f9; padding: 0.25rem 0.5rem; border-radius: var(--radius-sm); color: #0f172a; border: 1px solid var(--border-color);">
                                    {{ $permission->name }}
                                </code>
                            </td>
                            <td style="text-align: right;">
                                @php
                                    $protected = ['manage roles', 'manage permissions', 'manage users', 'view tasks', 'create tasks', 'edit tasks', 'delete tasks'];
                                @endphp
                                <div class="actions-cell" style="justify-content: flex-end;">
                                    @if (!in_array($permission->name, $protected))
                                        <a href="{{ route('permissions.edit', $permission->id) }}" class="btn btn-secondary btn-sm">
                                            Editar
                                        </a>
                                        <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" onsubmit="return confirm('¿Seguro que desea eliminar el permiso &quot;{{ $permission->name }}&quot;? Esto lo desasociará de todos los roles.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                Eliminar
                                            </button>
                                        </form>
                                    @else
                                        <span class="badge badge-info" style="font-size: 0.75rem; text-transform: none;">Protegido</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
