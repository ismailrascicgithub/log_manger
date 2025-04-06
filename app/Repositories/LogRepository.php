<?php

namespace App\Repositories;

use App\Models\Log;
use App\Policies\LogPolicy;
use App\Repositories\Interfaces\LogRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class LogRepository implements LogRepositoryInterface
{
    public function __construct(
        private LogPolicy $logPolicy
    ) {
    }

    public function store(array $logData): Log
    {
        return Log::create($logData);
    }

    public function getLogs(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        $query = Log::with([
            'user' => fn($q) => $q->select('id', 'name'),
            'project' => fn($q) => $q->select('id', 'name', 'user_id'),
            'project.user' => fn($q) => $q->select('id', 'name')
        ]);

        $this->applyScopeAndFilters($query, $filters);

        return $query->paginate($perPage)->withQueryString();
    }

    public function find(int $id): ?Log
    {
        return Log::with(['project.user'])->find($id) ?? null;
    }

    public function getLogsForExport(array $filters = []): Collection
    {
        $query = Log::query();
        $this->applyScopeAndFilters($query, $filters);
        return $query->get();
    }

    private function applyScopeAndFilters(Builder $query, array $filters): void
    {
        $user = Auth::user();

        if (!$user instanceof \App\Models\User) {
            throw new \RuntimeException('Authenticated user not found');
        }

        $this->logPolicy->scope($user, $query);

        $query->filter($filters);

        $sortColumn = $this->validateSortColumn($filters['sort_by'] ?? 'created_at');
        $sortOrder = $this->validateSortOrder($filters['sort_order'] ?? 'desc');

        $query->orderBy($sortColumn, $sortOrder);
    }

    private function validateSortColumn(string $column): string
    {
        $allowedColumns = ['created_at', 'severity_level'];
        return in_array($column, $allowedColumns, true) ? $column : 'created_at';
    }

    private function validateSortOrder(string $order): string
    {
        return in_array(strtolower($order), ['asc', 'desc'], true) ? $order : 'desc';
    }
}