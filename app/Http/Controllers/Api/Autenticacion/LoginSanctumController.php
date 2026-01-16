<?php

namespace App\Http\Controllers\Api\Autenticacion;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginSanctumController extends Controller
{
    public function login(LoginRequest $request)
    {
        try {
            $credentials = $request->only('email', 'password');

            if (!Auth::attempt($credentials)) {
                return ResponseHelper::error('Credenciales inválidas.', null, 401);
            }

            $user = $request->user();
            $token = $user->createToken('lolocal-token')->plainTextToken;
            $expiration = config('sanctum.expiration');

            $data = [
                'token' => $token,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'roles' => $user->getRoleNames()->toArray(),
                    'permissions' => $user->getAllPermissions()->pluck('name')->toArray(),
                ],
                'expires_in' => $expiration ? $expiration * 60 : null,
                'expires_at' => $expiration ? now()->addMinutes($expiration)->toIso8601String() : null
            ];

            return ResponseHelper::success($data, 'Autenticación exitosa.');

        } catch (\Exception $e) {
            return ResponseHelper::error('Ocurrió un error durante el inicio de sesión.', $e->getMessage(), 401);
        }
    }

    public function logout(Request $request)
    {
        try {
            $user = $request->user();

            if (!$user || !$user->currentAccessToken()) {
                return ResponseHelper::error('No se encontró un token activo para cerrar sesión.', null, 401);
            }

            $user->currentAccessToken()->delete();

            return ResponseHelper::success([], 'Sesión cerrada correctamente.');
        } catch (\Exception $e) {
            return ResponseHelper::error('Ocurrió un error al cerrar la sesión.', $e->getMessage(), 500);
        }
    }
}
