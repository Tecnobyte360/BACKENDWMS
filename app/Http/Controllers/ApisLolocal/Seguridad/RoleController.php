<?php

namespace App\Http\Controllers\ApisLolocal\Seguridad;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ApisLolocal\Seguridad\RoleService;
use Illuminate\Validation\ValidationException;

class RoleController extends Controller
{
    protected RoleService $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function index()
    {
        return response()->json($this->roleService->getAllRoles());
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|unique:roles,name',
                'description' => 'nullable|string',
                'permissions' => 'nullable|array'
            ]);

            $role = $this->roleService->createRole($validated);

            return response()->json(['message' => 'Rol creado', 'role' => $role], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al crear el rol',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $role = $this->roleService->getRoleById((int) $id);
            return response()->json($role);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener el rol',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|unique:roles,name,' . $id,
                'description' => 'nullable|string',
                'permissions' => 'nullable|array'
            ]);

            $role = $this->roleService->updateRole((int) $id, $validated);

            return response()->json(['message' => 'Rol actualizado', 'role' => $role]);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar el rol',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->roleService->deleteRole((int) $id);
            return response()->json(['message' => 'Rol eliminado']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar el rol',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
