<?php

namespace App\Http\Controllers\ApisLolocal\Seguridad;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ApisLolocal\Seguridad\PermissionService;
use Illuminate\Validation\ValidationException;

class PermissionController extends Controller
{
    protected PermissionService $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    public function index()
    {
        return response()->json($this->permissionService->getAll());
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|unique:permissions,name',
                'description' => 'nullable|string',
            ]);

            $permission = $this->permissionService->create($validated);

            return response()->json([
                'message' => 'Permiso creado',
                'permission' => $permission
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al crear el permiso',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $permission = $this->permissionService->getById((int) $id);
            return response()->json($permission);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Permiso no encontrado',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|unique:permissions,name,' . $id,
                'description' => 'nullable|string',
            ]);

            $permission = $this->permissionService->update((int) $id, $validated);

            return response()->json([
                'message' => 'Permiso actualizado',
                'permission' => $permission
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar el permiso',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->permissionService->delete((int) $id);

            return response()->json(['message' => 'Permiso eliminado']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar el permiso',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
