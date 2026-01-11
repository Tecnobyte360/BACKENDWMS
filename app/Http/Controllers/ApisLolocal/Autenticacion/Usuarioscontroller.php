<?php

namespace App\Http\Controllers\ApisLolocal\Autenticacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ApisLolocal\Autenticacion\UserService;
use Illuminate\Validation\ValidationException;

class Usuarioscontroller extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        try {
            $usuarios = $this->userService->getAllUsers();

            if ($usuarios->isEmpty()) {
                return response()->json([
                    'message' => 'No hay usuarios registrados en el sistema.'
                ], 404);
            }

            return response()->json([
                'message' => 'Usuarios obtenidos correctamente.',
                'data' => $usuarios
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocurrió un error al obtener los usuarios.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name'         => 'required|string|max:255',
                'email'        => 'required|email|unique:users,email',
                'password'     => 'required|string|min:6|max:255',
                'selectedRole' => 'required|exists:roles,id',
            ]);

            $user = $this->userService->createUser($validated);

            return response()->json([
                'message' => 'Usuario creado correctamente',
                'user' => $user
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocurrió un error al crear el usuario.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'name'         => 'required|string|max:255',
                'email'        => "required|email|unique:users,email,{$id}",
                'selectedRole' => 'required|exists:roles,id',
            ]);

            $user = $this->userService->updateUser((int) $id, $validated);

            return response()->json([
                'message' => 'Usuario actualizado correctamente.',
                'user' => $user
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocurrió un error al actualizar el usuario.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function updatePassword(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'password' => 'required|string|min:8|confirmed',
            ]);

            $this->userService->updatePassword((int) $id, $validated['password']);

            return response()->json([
                'message' => 'Contraseña actualizada correctamente.'
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocurrió un error al actualizar la contraseña.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function toggleEstado($id)
    {
        try {
            $user = $this->userService->toggleEstado((int) $id);

            return response()->json([
                'message' => 'Estado actualizado correctamente.',
                'estado'  => $user->activo ? 'Activo' : 'Inactivo',
                'activo'  => $user->activo
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocurrió un error al actualizar el estado del usuario.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
