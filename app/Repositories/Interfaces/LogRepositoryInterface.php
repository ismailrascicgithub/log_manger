<?php

namespace App\Repositories\Interfaces;

use App\Models\Log;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface LogRepositoryInterface
{
    public function store(array $logData): Log;
    public function getLogs(array $filters = [], int $perPage = 10): LengthAwarePaginator;
    public function find(int $id): ?Log;
    public function getLogsForExport(array $filters = []): Collection;
}