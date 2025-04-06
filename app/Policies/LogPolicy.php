<?php

namespace App\Policies;

use App\Models\Log;
use App\Models\Project;
use App\Models\User;

class LogPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Log $log): bool
    {
        return $user->isAdmin() || $log->project->user_id === $user->id;
    }

    public function create(User $user, $projectId): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        $project = Project::findOrFail($projectId);
        return $project->user_id === $user->id;
    }

    public function scope(User $user, $query): void
    {
        if (!$user->isAdmin()) {
            $query->whereHas('project', fn($q) => $q->where('user_id', $user->id));
        }
    }
}