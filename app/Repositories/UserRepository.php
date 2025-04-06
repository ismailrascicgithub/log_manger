<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserRepository implements UserRepositoryInterface
{
    public function getAllUsers(int $perPage = 10): LengthAwarePaginator
    {
        return User::withTrashed()->paginate($perPage);
    }

    public function createUser(array $data): User
    {
        return User::create($data);
    }

    public function getUserById(int $id): User
    {
        return User::withTrashed()->findOrFail($id);
    }

    public function updateUser(User $user, array $data): User
    {
        $user->update($data);
        return $user;
    }

    public function deleteUser(User $user): bool
    {
        return $user->delete();
    }

    public function restoreUser(User $user): bool
    {
        return $user->restore();
    }

    public function forceDeleteUser(User $user): bool
    {
        return $user->forceDelete();
    }
}