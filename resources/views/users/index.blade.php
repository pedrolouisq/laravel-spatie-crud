@extends('layouts.app')

@section('title', 'Gestionar Usuarios')
@section('page-title', 'Usuarios del Sistema')
@section('page-subtitle', 'Administra las cuentas de usuario y la asignación de roles')

@section('content')
<div class="card">
    <div class="card-header">
        <h2 class="card-title">👤 Lista de Usuarios</h2>
        <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">
            <span>➕</span> Registrar Usuario
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 80px;">ID</th>
                        <th>Nombre</th>
                        <th>Correo Electrónico</th>
                        <th>Roles Asignados</th>
                        <th style="width: 180px; text-align: right;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td><strong>#{{ $user->id }}</strong></td>
                            <td style="font-weight: 600; color: var(--text-main);">{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <div style="display: flex; flex-wrap: wrap; gap: 0.35rem;">
                                    @forelse ($user->roles as $role)
                                        <span class="badge badge-primary" style="font-size: 0.75rem;">
                                            {{ $role->name }}
                                        </span>
                                    @empty
                                        <span class="badge badge-secondary" style="font-size: 0.75rem;">Sin Rol</span>
                                    @endforelse
                                </div>
                            </td>
                            <td style="text-align: right;">
                                <div class="actions-cell" style="justify-content: flex-end;">
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-secondary btn-sm">
                                        Editar
                                    </a>
                                    
                                    @if ($user->id !== auth()->id() && $user->email !== 'admin@example.com')
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('¿Seguro que desea eliminar al usuario &quot;{{ $user->name }}&quot;?');">
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
