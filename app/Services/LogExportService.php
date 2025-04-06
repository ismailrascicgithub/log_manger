<?php

namespace App\Services;

use App\Exports\LogsExport;
use App\Repositories\Interfaces\LogRepositoryInterface;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class LogExportService
{
    public function __construct(
        private readonly LogRepositoryInterface $logRepository
    ) {}

    public function exportLogs(array $filters): BinaryFileResponse
    {
        $logs = $this->logRepository->getLogsForExport($filters);
        return Excel::download(
            new LogsExport($logs), 
            $this->generateFileName(), 
            \Maatwebsite\Excel\Excel::XLSX
        );
    }

    private function generateFileName(): string
    {
        return 'logs_export_' . now()->format('Y_m_d_His') . '.xlsx';
    }
}