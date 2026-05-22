<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Sistema de Gestión de Roles</title>
    <!-- Google Fonts Outfit & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="auth-page">
    <div class="auth-card">
        <div class="auth-header">
            <div class="auth-logo">S</div>
            <h1 class="auth-title">Bienvenido</h1>
            <p class="auth-subtitle">Inicia sesión para gestionar el sistema</p>
        </div>

        <form action="{{ route('login') }}" method="POST">
            @csrf

            <!-- Email Address -->
            <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="correo@ejemplo.com">
                @error('email')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div class="form-group" style="margin-bottom: 1rem;">
                <label for="password">Contraseña</label>
                <input id="password" class="form-control" type="password" name="password" required placeholder="••••••••">
                @error('password')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <!-- Remember Me -->
            <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1.5rem;">
                <input id="remember_me" type="checkbox" name="remember" style="width:16px; height:16px; accent-color: var(--primary); cursor:pointer;">
                <label for="remember_me" style="font-size: 0.85rem; cursor:pointer; color:#94a3b8; user-select:none;">Recordar mi sesión</label>
            </div>

            <div>
                <button type="submit" class="btn btn-primary">
                    Iniciar Sesión
                </button>
            </div>
        </form>

        <!-- Credentials Helper Hint -->
        <div class="auth-credentials-hint">
            <p>🔑 Usuarios Demo Sembrados (Seeders):</p>
            
            <div class="auth-credentials-hint-item">
                <span>Administrador (Todo)</span>
                <span>admin@example.com</span>
            </div>
            
            <div class="auth-credentials-hint-item">
                <span>Gerente (Ver/Crear/Edit Tareas)</span>
                <span>manager@example.com</span>
            </div>
            
            <div class="auth-credentials-hint-item">
                <span>Lector (Solo Ver Tareas)</span>
                <span>viewer@example.com</span>
            </div>

            <div class="auth-credentials-hint-item" style="margin-top: 0.5rem; border-top: 1px dashed rgba(255,255,255,0.08); padding-top:0.5rem;">
                <span>Contraseña común:</span>
                <span>password</span>
            </div>
        </div>
    </div>
</body>
</html>
