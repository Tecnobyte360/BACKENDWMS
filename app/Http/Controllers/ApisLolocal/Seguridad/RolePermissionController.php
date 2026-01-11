<?php

namespace App\Http\Controllers\ApisLolocal\Seguridad;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ApisLolocal\Seguridad\RolePermissionService;
use Illuminate\Validation\ValidationException;

class RolePermissionController extends Controller
{
    protected RolePermissionService $service;

    public function __construct(RolePermissionService $service)
    {
        $this->service = $service;
    }

    // Obtener permisos de un rol
    public function index($roleId)
    {
        try {
            $permissions = $this->service->getPermissions((int) $roleId);
            return response()->json($permissions);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener permisos del rol',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    // Asignar múltiples permisos a un rol (reemplaza los actuales)
    public function update(Request $request, $roleId)
    {
        try {
            $validated = $request->validate([
                'permissions' => 'required|array',
                'permissions.*' => 'exists:permissions,id'
            ]);

            $role = $this->service->syncPermissions((int) $roleId, $validated['permissions']);

            return response()->json([
                'message' => 'Permisos actualizados correctamente',
                'role' => $role
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al asignar permisos al rol',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Quitar un permiso específico de un rol
    public function destroy($roleId, $permissionId)
    {
        try {
            $role = $this->service->removePermission((int) $roleId, (int) $permissionId);

            return response()->json([
                'message' => 'Permiso revocado del rol',
                'role' => $role
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al revocar permiso',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
