@extends('layouts.app')

@section('title', 'Gestionar Roles')
@section('page-title', 'Roles de Usuario')
@section('page-subtitle', 'Administra los roles del sistema y sus respectivos permisos')

@section('content')
<div class="card">
    <div class="card-header">
        <h2 class="card-title">🔑 Lista de Roles</h2>
        <a href="{{ route('roles.create') }}" class="btn btn-primary btn-sm">
            <span>➕</span> Crear Nuevo Rol
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 80px;">ID</th>
                        <th style="width: 200px;">Nombre del Rol</th>
                        <th>Permisos Asignados</th>
                        <th style="width: 180px; text-align: right;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $role)
                        <tr>
                            <td><strong>#{{ $role->id }}</strong></td>
                            <td>
                                <span class="badge badge-primary" style="font-size: 0.85rem; padding: 0.4rem 0.8rem;">
                                    {{ $role->name }}
                                </span>
                            </td>
                            <td>
                                <div style="display: flex; flex-wrap: wrap; gap: 0.35rem;">
                                    @forelse ($role->permissions as $permission)
                                        <span class="badge badge-secondary" style="font-size: 0.7rem; text-transform: none;">
                                            {{ $permission->name }}
                                        </span>
                                    @empty
                                        <span style="color: var(--text-muted); font-size: 0.85rem; font-style: italic;">Sin permisos asignados</span>
                                    @endforelse
                                </div>
                            </td>
                            <td style="text-align: right;">
                                <div class="actions-cell" style="justify-content: flex-end;">
                                    <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-secondary btn-sm">
                                        Editar
                                    </a>
                                    @if ($role->name !== 'admin')
                                        <form action="{{ route('roles.destroy', $role->id) }}" method="POST" onsubmit="return confirm('¿Seguro que desea eliminar el rol &quot;{{ $role->name }}&quot;? Esto puede desasignar a los usuarios asociados.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                Eliminar
                                            </button>
                                        </form>
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
