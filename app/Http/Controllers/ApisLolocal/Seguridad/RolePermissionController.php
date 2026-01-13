<?php

namespace App\Http\Controllers\ApisLolocal\Seguridad;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionController extends Controller
{
   // Mostrar permisos asignados y todos los disponibles
    public function index($roleId)
    {
        $role = Role::findOrFail($roleId);

        $allPermissions = \Spatie\Permission\Models\Permission::all(['id', 'name', 'description']);

        // Solo los IDs de los permisos asignados a este rol
        $assigned = $role->permissions()->pluck('permissions.id')->toArray();

        return response()->json([
            'all_permissions' => $allPermissions,
            'assigned_permissions' => $assigned
        ]);
    }


    public function update(Request $request, $roleId)
    {
        $request->validate([
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role = Role::findOrFail($roleId);

        // Sincroniza (quita los que no estén y agrega los nuevos)
        $role->syncPermissions($request->permissions);

        return response()->json([
            'message' => 'Permisos actualizados correctamente',
            'role_id' => $role->id,
            'permissions' => $role->permissions,
        ]);
    }

    public function destroy($roleId, $permissionId)
    {
        $role = Role::findOrFail($roleId);
        $permission = Permission::findOrFail($permissionId);

        if (! $role->hasPermissionTo($permission)) {
            return response()->json([
                'message' => 'El rol no tiene este permiso asignado',
            ], 400);
        }

        $role->revokePermissionTo($permission);

        return response()->json([
            'message' => 'Permiso removido del rol correctamente',
        ]);
    }
}
