<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Permisos de acceso a módulos (con acceso completo CRUD)
        $modulePermissions = [
            ['name' => 'acceder_dashboard', 'description' => 'Acceso completo al Dashboard'],
            ['name' => 'acceder_recepcion', 'description' => 'Acceso completo a Recepción'],
            ['name' => 'acceder_inventario', 'description' => 'Acceso completo a Inventario'],
            ['name' => 'acceder_despacho', 'description' => 'Acceso completo a Despacho'],
            ['name' => 'acceder_obras', 'description' => 'Acceso completo a Obras'],
            ['name' => 'acceder_rutas', 'description' => 'Acceso completo a Rutas'],
            ['name' => 'acceder_ubicaciones', 'description' => 'Acceso completo a Ubicaciones'],
            ['name' => 'acceder_auditoria', 'description' => 'Acceso completo a Auditoría'],
            ['name' => 'acceder_reportes', 'description' => 'Acceso completo a Reportes'],
            ['name' => 'acceder_usuarios', 'description' => 'Acceso completo a Usuarios'],
            ['name' => 'acceder_vehiculos', 'description' => 'Acceso completo a Vehículos'],
            ['name' => 'acceder_conductores', 'description' => 'Acceso completo a Conductores'],
        ];

        foreach ($modulePermissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission['name']],
                [
                    'guard_name' => 'web',
                    'description' => $permission['description']
                ]
            );
        }

        $this->command->info('✓ Permisos de módulos creados: ' . count($modulePermissions));
        $this->command->info('✓ Cada permiso otorga acceso completo (crear, editar, eliminar, visualizar)');
    }
}
