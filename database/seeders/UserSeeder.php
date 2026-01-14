<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Usar el rol "Administrador" existente
        $adminRole = Role::firstOrCreate(
            ['name' => 'Administrador'],
            [
                'guard_name' => 'web',
            ]
        );

        // Asignar TODOS los permisos al rol de administrador
        $allPermissions = Permission::all();
        $adminRole->syncPermissions($allPermissions);

        // Crear el usuario de prueba
        $user = User::firstOrCreate(
            ['email' => 'test@doblamos.com'],
            [
                'name' => 'Usuario Prueba',
                'password' => Hash::make('password123'),
                'activo' => true,
            ]
        );

        // Asignar el rol de administrador al usuario
        $user->syncRoles([$adminRole]);

        $this->command->info('✓ Usuario administrador creado: test@doblamos.com / password123');
        $this->command->info('✓ Rol: Administrador');
        $this->command->info('✓ Permisos asignados: ' . $allPermissions->count());
    }
}
