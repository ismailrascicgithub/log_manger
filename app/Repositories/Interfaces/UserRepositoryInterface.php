<?php

namespace App\Repositories\Interfaces;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface UserRepositoryInterface
{
    public function getAllUsers(int $perPage = 10): LengthAwarePaginator;
    public function createUser(array $data): User;
    public function getUserById(int $id): User;
    public function updateUser(User $user, array $data): User;
    public function deleteUser(User $user): bool;
    public function restoreUser(User $user): bool;
    public function forceDeleteUser(User $user): bool;
}