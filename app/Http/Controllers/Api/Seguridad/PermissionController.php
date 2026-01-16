<?php

namespace App\Http\Controllers\Api\Seguridad;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Validation\ValidationException;

class PermissionController extends Controller
{
    public function index()
    {
        // Listar todos los permisos
        $permissions = Permission::all();

        return response()->json($permissions);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|unique:permissions,name',
                'description' => 'nullable|string',
            ]);

            $permission = Permission::create([
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,
                'guard_name' => 'web', // asegúrate que tu app use este guard
            ]);

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
            $permission = Permission::findOrFail($id);
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

            $permission = Permission::findOrFail($id);
            $permission->update([
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,
            ]);

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
            $permission = Permission::findOrFail($id);
            $permission->delete();

            return response()->json(['message' => 'Permiso eliminado']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar el permiso',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
