<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Task;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        $admin = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Administrador Sistema',
                'password' => Hash::make('password'),
            ]
        );
        $admin->assignRole('admin');

        // Create Manager User
        $manager = User::updateOrCreate(
            ['email' => 'manager@example.com'],
            [
                'name' => 'Gerente de Proyectos',
                'password' => Hash::make('password'),
            ]
        );
        $manager->assignRole('manager');

        // Create Viewer User
        $viewer = User::updateOrCreate(
            ['email' => 'viewer@example.com'],
            [
                'name' => 'Lector / Consultor',
                'password' => Hash::make('password'),
            ]
        );
        $viewer->assignRole('viewer');

        // Create some sample tasks
        Task::create([
            'title' => 'Diseñar interfaz base del Dashboard',
            'description' => 'Crear plantilla responsiva con diseño premium en CSS puro, incluyendo transiciones y barra lateral.',
            'status' => 'completed',
            'assigned_to' => $manager->id,
        ]);

        Task::create([
            'title' => 'Implementar control de acceso Spatie',
            'description' => 'Configurar los roles de administrador, gerente y lector, y validar mediante middleware y directivas Blade.',
            'status' => 'in_progress',
            'assigned_to' => $admin->id,
        ]);

        Task::create([
            'title' => 'Pruebas de despliegue en servidor',
            'description' => 'Verificar la conectividad de la base de datos SQLite y configurar el preview en Firebase Studio (Project IDX).',
            'status' => 'pending',
            'assigned_to' => $viewer->id,
        ]);

        Task::create([
            'title' => 'Optimizar rendimiento CSS',
            'description' => 'Revisar las animaciones de los botones y la compatibilidad móvil del sidebar principal.',
            'status' => 'pending',
            'assigned_to' => null,
        ]);
    }
}
