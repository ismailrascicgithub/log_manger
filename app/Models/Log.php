<?php

namespace App\Models;

use App\Services\LogStatsService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\SeverityLevel;

class Log extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'user_id',
        'severity_level',
        'message'
    ];

    protected $casts = [
        'severity_level' => SeverityLevel::class,
        'created_at' => 'datetime:Y-m-d H:i:s'
    ];

    protected static function booted()
    {
        static::created(function (Log $log) {
            app(LogStatsService::class)->clearCache();
        });

        static::updated(function (Log $log) {
            app(LogStatsService::class)->clearCache();
        });

        static::deleted(function (Log $log) {
            app(LogStatsService::class)->clearCache();
        });
    }

    public function project()
    {
        return $this->belongsTo(Project::class)->withDefault([
            'name' => 'N/A',
            'user_id' => null
        ]);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'Unknown User'
        ]);
    }

    public function scopeFilter($query, array $filters)
    {
        return $query
            ->when(isset($filters['severity']), function ($q) use ($filters) {
                return $q->where('severity_level', $filters['severity']);
            })
            ->when(isset($filters['project_id']), function ($q) use ($filters) {
                return $q->where('project_id', $filters['project_id']);
            })
            ->when(isset($filters['search']), function ($q) use ($filters) {
                return $q->where('message', 'like', '%'.$filters['search'].'%');
            })
            ->when(isset($filters['user_id']), function ($q) use ($filters) {
                return $q->whereHas('project', function ($subQuery) use ($filters) {
                    $subQuery->where('user_id', $filters['user_id']);
                });
            });
    }
}