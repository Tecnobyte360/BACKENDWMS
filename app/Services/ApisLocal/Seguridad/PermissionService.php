<?php

namespace App\Services\ApisLolocal\Seguridad;

use Spatie\Permission\Models\Permission;
use Illuminate\Support\Collection;

class PermissionService
{
    public function getAll(): Collection
    {
        return Permission::with('roles')->get();
    }

    public function getById(int $id): Permission
    {
        return Permission::with('roles')->findOrFail($id);
    }

    public function create(array $data): Permission
    {
        return Permission::create([
            'name' => $data['name'],
            'guard_name' => 'web',
            'description' => $data['description'] ?? null,
        ]);
    }

    public function update(int $id, array $data): Permission
    {
        $permission = Permission::findOrFail($id);

        $permission->update([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
        ]);

        return $permission;
    }

    public function delete(int $id): void
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();
    }
}
