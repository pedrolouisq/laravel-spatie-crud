<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Spatie CRUD') - Sistema de Gestión de Roles</title>
    <!-- Google Fonts Outfit & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- App CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('styles')
</head>
<body>
    <div class="app-container">
        <!-- Sidebar Navigation -->
        <aside class="sidebar">
            <div class="sidebar-logo">
                <div class="sidebar-logo-icon">S</div>
                <div class="sidebar-logo-text">SpatieCRUD</div>
            </div>

            <ul class="sidebar-menu">
                <li class="sidebar-item {{ Request::is('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}">
                        <span>📊</span> Dashboard
                    </a>
                </li>

                @can('view tasks')
                <li class="sidebar-item {{ Request::is('tasks*') ? 'active' : '' }}">
                    <a href="{{ route('tasks.index') }}">
                        <span>📝</span> Tareas
                    </a>
                </li>
                @endcan

                @can('manage users')
                <li class="sidebar-item {{ Request::is('users*') ? 'active' : '' }}">
                    <a href="{{ route('users.index') }}">
                        <span>👤</span> Usuarios
                    </a>
                </li>
                @endcan

                @can('manage roles')
                <li class="sidebar-item {{ Request::is('roles*') ? 'active' : '' }}">
                    <a href="{{ route('roles.index') }}">
                        <span>🔑</span> Roles
                    </a>
                </li>
                @endcan

                @can('manage permissions')
                <li class="sidebar-item {{ Request::is('permissions*') ? 'active' : '' }}">
                    <a href="{{ route('permissions.index') }}">
                        <span>🛡️</span> Permisos
                    </a>
                </li>
                @endcan
            </ul>

            <!-- Sidebar User Meta & Logout -->
            <div class="sidebar-user">
                <div class="user-info">
                    <div class="user-avatar">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="user-details">
                        <span class="user-name" title="{{ auth()->user()->name }}">{{ auth()->user()->name }}</span>
                        <span class="user-role" title="{{ auth()->user()->roles->pluck('name')->implode(', ') }}">
                            {{ auth()->user()->roles->pluck('name')->first() ?? 'Sin Rol' }}
                        </span>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('¿Seguro que desea cerrar sesión?');">
                    @csrf
                    <button type="submit" class="btn-logout">
                        <span>🚪</span> Cerrar Sesión
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="main-content">
            <!-- Top Header -->
            <header class="top-header">
                <div class="page-title-group">
                    <h1>@yield('page-title', 'Dashboard')</h1>
                    <p>@yield('page-subtitle', 'Resumen general y estadísticas')</p>
                </div>
                <div class="header-actions">
                    <div class="profile-meta-badge">
                        <span>🔑 Permisos Activos:</span>
                        <span class="profile-meta-role">
                            {{ auth()->user()->getAllPermissions()->count() }} asignados
                        </span>
                    </div>
                </div>
            </header>

            <!-- Page Body Content -->
            <div class="page-body">
                <!-- Notifications -->
                @if (session('success'))
                    <div class="alert alert-success" id="success-alert">
                        <span>✅ {{ session('success') }}</span>
                        <button onclick="document.getElementById('success-alert').style.display='none'" style="background:none;border:none;cursor:pointer;font-size:1.1rem;color:#065f46;font-weight:bold;">&times;</button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger" id="error-alert">
                        <span>❌ {{ session('error') }}</span>
                        <button onclick="document.getElementById('error-alert').style.display='none'" style="background:none;border:none;cursor:pointer;font-size:1.1rem;color:#991b1b;font-weight:bold;">&times;</button>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    @yield('scripts')
</body>
</html>
