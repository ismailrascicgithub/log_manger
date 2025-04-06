<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LogStoreRequest;
use App\Models\Log;
use App\Models\Project;
use App\Repositories\Interfaces\LogRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class LogApiController extends Controller
{
    protected LogRepositoryInterface $logRepository;

    public function __construct(LogRepositoryInterface $logRepository)
    {
        $this->logRepository = $logRepository;
    }

    public function store(LogStoreRequest $request): JsonResponse
    {
        $user = Auth::user();
        $validatedData = $request->validated();
        $projectId = $validatedData['project_id'];

        $this->authorize('create', [Log::class, $projectId]);

        if (!isset($validatedData['user_id'])) {
            $validatedData['user_id'] = $user->id;
        }

        $log = $this->logRepository->store($validatedData);

        return response()->json([
            'message' => 'Log je uspješno kreiran.',
            'data' => $log->load(['user', 'project'])
        ], 201);
    }
}