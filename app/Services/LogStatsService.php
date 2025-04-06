<?php

namespace App\Services;

use App\Enums\SeverityLevel;
use App\Models\Log;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class LogStatsService
{
    private const CACHE_TTL = 1800;
    private const CACHE_PREFIX = 'logs_stats_';

    public function getStats(): array
    {
        return Cache::remember($this->cacheKey(), self::CACHE_TTL, function () {
            return [
                'total' => Log::count(),
                'lastHour' => Log::where('created_at', '>=', now()->subHour())->count(),
                'last24h' => Log::where('created_at', '>=', now()->subDay())->count(),
                'severities' => $this->severityStats(),
                'projects' => $this->projectStats()
            ];
        });
    }

    private function severityStats(): array
    {
        return Log::selectRaw('severity_level, count(*) as count')
            ->groupBy('severity_level')
            ->get()
            ->mapWithKeys(fn($item) => [
                ucfirst(strtolower($item->severity_level->name)) => $item->count
            ])
            ->toArray();
    }

    private function projectStats(): array
    {
        return Log::selectRaw('project_id, count(*) as log_count, MAX(created_at) as latest_log')
            ->with('project:id,name')
            ->groupBy('project_id')
            ->get()
            ->map(fn($item) => [
                'project' => $item->project->name,
                'count' => $item->log_count,
                'latest_log' => Carbon::parse($item->latest_log)->toDateTimeString()
            ])
            ->toArray();
    }

    private function cacheKey(): string
    {
        return self::CACHE_PREFIX . date('YmdH');
    }

    public function clearCache(): void
    {
        Cache::forget($this->cacheKey());
    }
}