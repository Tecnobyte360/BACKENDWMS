<?php

namespace App\Services\ApisLolocal\Autenticacion;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserService
{
    public function getAllUsers(): Collection
    {
        return User::with('roles')->get();
    }

    public function createUser(array $data): User
    {
        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'activo'   => true,
        ]);

        $user->assignRole((int) $data['selectedRole']);

        return $user->load('roles');
    }

    public function updateUser(int $id, array $data): User
    {
        $user = User::findOrFail($id);
        $rol  = Role::findOrFail((int) $data['selectedRole']);

        $user->update([
            'name'  => $data['name'],
            'email' => $data['email'],
        ]);

        $user->syncRoles([$rol->id]);

        return $user->load('roles');
    }

    public function updatePassword(int $id, string $password): void
    {
        $user = User::findOrFail($id);
        $user->update([
            'password' => Hash::make($password),
        ]);
    }

    public function toggleEstado(int $id): User
    {
        $user = User::findOrFail($id);
        $user->activo = !$user->activo;
        $user->save();

        return $user;
    }
}
