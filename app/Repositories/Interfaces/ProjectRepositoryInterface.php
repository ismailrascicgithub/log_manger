<?php

namespace App\Repositories\Interfaces;

use App\Models\Project;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface ProjectRepositoryInterface
{
    public function store(Project $project): Project;
    public function getProjects(array $filters, int $perPage = 10): LengthAwarePaginator;
    public function getAllProjects(array $filters = []): Collection;
    public function getDeletedProjects(array $filters = []): Collection;
    public function find(int $id): ?Project;
    public function update(Project $project, array $data): Project;
    public function delete(Project $project): bool;
    public function restore(Project $project): bool;
    public function forceDelete(Project $project): bool;
}