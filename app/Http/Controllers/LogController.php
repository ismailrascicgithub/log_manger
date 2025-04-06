<?php

namespace App\Http\Controllers;

use App\Enums\SeverityLevel;
use App\Http\Requests\LogFilterRequest;
use App\Models\Log;
use App\Models\User;
use App\Repositories\Interfaces\LogRepositoryInterface;
use App\Repositories\Interfaces\ProjectRepositoryInterface;
use App\Services\LogExportService;
use App\Services\LogStatsService;
use Illuminate\Support\Facades\Auth;
use Inertia\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class LogController extends Controller
{
    public function __construct(
        private readonly LogRepositoryInterface $logRepository,
        private readonly ProjectRepositoryInterface $projectRepository,
        private readonly LogStatsService $statsService,
        private readonly LogExportService $exportService

    ) {
        $this->middleware(['auth', 'verified']);
    }
    public function index(LogFilterRequest $request)
    {
        return inertia('Log/Index', [
            'logs' => $this->logRepository->getLogs($request->validated()),
            'filters' => $request->validated(),
            'severities' => SeverityLevel::asSelectArray(),
            'projects' => $this->projectRepository->getAllProjects(),
            'users' => $request->user()->isAdmin() ? User::all() : [],
            "isAdmin" => Auth::user()->isAdmin(),
        ]);
    }

    public function show(Log $log): Response
    {
        $this->authorize('view', $log);
        return inertia('Log/Show', [
            'log' => $log->loadMissing('project.user:id,name')
        ]);
    }

    public function export(LogFilterRequest $request): BinaryFileResponse
    {
        $this->authorize('viewAny', Log::class);
        return $this->exportService->exportLogs($request->validated());
    }

    public function stats(): Response
    {
        $this->authorize('viewAny', Log::class);
        return inertia('Log/Stats', [
            'stats' => $this->statsService->getStats(),
        ]);
    }
}