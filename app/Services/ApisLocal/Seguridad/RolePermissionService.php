<?php

namespace App\Services\ApisLolocal\Seguridad;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Eloquent\Collection;

class RolePermissionService
{
    public function getPermissions(int $roleId): Collection
    {
        $role = Role::with('permissions')->findOrFail($roleId);
        return $role->permissions;
    }

    public function syncPermissions(int $roleId, array $permissionIds): Role
    {
        $role = Role::findOrFail($roleId);
        $role->syncPermissions($permissionIds);
        return $role->load('permissions');
    }

    public function removePermission(int $roleId, int $permissionId): Role
    {
        $role = Role::findOrFail($roleId);
        $permission = Permission::findOrFail($permissionId);

        $role->revokePermissionTo($permission);

        return $role->load('permissions');
    }
}
