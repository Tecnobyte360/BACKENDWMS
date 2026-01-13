<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckHttpPermission
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'No autenticado'], 401);
        }

        if ($user->hasRole('Administrador')) {
            return $next($request);
        }

        $methodPermissionMap = [
            'GET'    => 'visualizar',
            'POST'   => 'crear',
            'PUT'    => 'editar',
            'PATCH'  => 'editar',
            'DELETE' => 'eliminar',
        ];

        $method = $request->method();

        if (!isset($methodPermissionMap[$method])) {
            return $next($request);
        }

        $requiredPermission = $methodPermissionMap[$method];

        if (!$user->can($requiredPermission)) {
            return response()->json([
                'message' => 'No tienes permiso para realizar esta acción',
                'required_permission' => $requiredPermission,
            ], 403);
        }

        return $next($request);
    }
}
