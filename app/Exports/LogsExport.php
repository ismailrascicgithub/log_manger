<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class LogsExport implements FromCollection, WithHeadings
{
    protected $logs;

    public function __construct(Collection $logs)
    {
        $this->logs = $logs;
    }

    public function collection()
    {
        return $this->logs->map(function ($log) {
            return [
                'ID' => $log->id,
                'Project' => $log->project->name ?? 'N/A',
                'Severity' => $log->severity_name,
                'Message' => $log->message,
                'User Info' => $log->user->name,
                'Created At' => $log->created_at->format('Y-m-d H:i:s'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Project',
            'Severity Level',
            'Message',
            'User Info',
            'Created At'
        ];
    }
}