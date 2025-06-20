<?php

use App\Http\Controllers\ApisLolocal\Autenticacion\LoginSanctumController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ApisLolocal\Autenticacion\Usuarioscontroller;


Route::post('/login', [LoginSanctumController::class, 'login']);
Route::post('/logout', [LoginSanctumController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', fn(Request $request) => $request->user());

    Route::get('/usuarios', [Usuarioscontroller::class, 'index']);
    Route::post('/usuarios', [Usuarioscontroller::class, 'store']);
    Route::put('/usuarios/{id}', [Usuarioscontroller::class, 'update']);
    Route::patch('/usuarios/{id}/password', [Usuarioscontroller::class, 'updatePassword']);
    Route::patch('/usuarios/{id}/estado', [Usuarioscontroller::class, 'toggleEstado']);
});
