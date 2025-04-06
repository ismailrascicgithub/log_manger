<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;

class ProjectPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Project $project): bool
    {
        return $this->isAdminOrOwner($user, $project);
    }

    public function create(User $user): bool
    {
        return $user->isEditor()|| $user->isAdmin();
    }

    public function update(User $user, Project $project): bool
    {
        return $this->isAdminOrOwner($user, $project);
    }

    public function delete(User $user, Project $project): bool
    {
        return $this->isAdminOrOwner($user, $project);
    }

    public function restore(User $user, Project $project): bool
    {
        return $this->isAdminOrOwner($user, $project);
    }

    public function forceDelete(User $user, Project $project): bool
    {
        return $user->isAdmin();
    }

    private function isAdminOrOwner(User $user, Project $project): bool
    {
        return $user->isAdmin() || $project->user_id === $user->id;
    }
}