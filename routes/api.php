<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\Autenticacion\{Usuarioscontroller, LoginSanctumController};
use App\Http\Controllers\Api\Seguridad\{RoleController, PermissionController, RolePermissionController};


Route::post('/login', [LoginSanctumController::class, 'login']);
Route::post('/logout', [LoginSanctumController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware(['auth:sanctum','http.permission'])->group(function () {
    Route::get('/user', fn(Request $request) => $request->user());

    Route::get('/usuarios', [Usuarioscontroller::class, 'index']);
    Route::post('/usuarios', [Usuarioscontroller::class, 'store']);
    Route::put('/usuarios/{id}', [Usuarioscontroller::class, 'update']);
    Route::patch('/usuarios/{id}/password', [Usuarioscontroller::class, 'updatePassword']);
    Route::patch('/usuarios/{id}/estado', [Usuarioscontroller::class, 'toggleEstado']);
});

Route::middleware(['auth:sanctum','http.permission'])->prefix('roles')->group(function () {
    Route::get('/', [RoleController::class, 'index']);
    Route::post('/', [RoleController::class, 'store']);
    Route::get('/{id}', [RoleController::class, 'show']);
    Route::put('/{id}', [RoleController::class, 'update']);
    Route::delete('/{id}', [RoleController::class, 'destroy']);
});


Route::middleware(['auth:sanctum','http.permission'])->prefix('permisos')->group(function () {
    Route::get('/', [PermissionController::class, 'index']);
    Route::post('/', [PermissionController::class, 'store']);
    Route::get('/{id}', [PermissionController::class, 'show']);
    Route::put('/{id}', [PermissionController::class, 'update']);
    Route::delete('/{id}', [PermissionController::class, 'destroy']);
});

Route::middleware(['auth:sanctum','http.permission'])->prefix('roles/{roleId}/permisos')->group(function () {
    Route::get('/', [RolePermissionController::class, 'index']);
    Route::put('/', [RolePermissionController::class, 'update']);
    Route::delete('/{permissionId}', [RolePermissionController::class, 'destroy']);
});