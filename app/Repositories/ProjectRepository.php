<?php

namespace App\Repositories;

use App\Enums\UserRole;
use App\Models\Project;
use App\Repositories\Interfaces\ProjectRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class ProjectRepository implements ProjectRepositoryInterface
{
    public function store(Project $project): Project
    {
        $project->save();
        return $project;
    }

    public function getProjects(array $filters, int $perPage = 10): LengthAwarePaginator
    {
        return $this->applyFilters(Project::query(), $filters)
            ->withTrashed()
            ->paginate($perPage);
    }

    public function getAllProjects(array $filters = []): Collection
    {
        return $this->applyFilters(Project::query(), $filters)
            ->get();
    }

    public function getDeletedProjects(array $filters = []): Collection
    {
        return $this->applyFilters(Project::query(), $filters)
            ->onlyTrashed()
            ->get();
    }

    public function find(int $id): ?Project
    {
        return Project::withTrashed()->find($id);
    }

    public function update(Project $project, array $data): Project
    {
        $project->update($data);
        return $project;
    }

    public function delete(Project $project): bool
    {
        return $project->delete();
    }

    public function restore(Project $project): bool
    {
        return $project->restore();
    }

    public function forceDelete(Project $project): bool
    {
        return $project->forceDelete();
    }

    private function applyFilters(Builder $query, array $filters): Builder
    {
        if (Auth::user()->isEditor()) {
            $query->where('user_id', Auth::id());
        }

        if (!empty($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }

        return $query->with('user');
    }
}