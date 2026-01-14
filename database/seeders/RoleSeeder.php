<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $admin = Role::firstOrCreate(
            ['name' => 'Administrador'],
            ['guard_name' => 'web']
        );
        $allPermissions = Permission::pluck('name')->toArray();
        $admin->syncPermissions($allPermissions);

        $this->command->info('✓ Rol Administrador creado/actualizado');
        $this->command->info('✓ Permisos asignados: ' . count($allPermissions));
    }
}