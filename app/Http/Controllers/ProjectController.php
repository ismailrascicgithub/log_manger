<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use App\Http\Requests\ProjectRequest;
use App\Repositories\Interfaces\ProjectRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class ProjectController extends Controller
{
    public function __construct(
        protected ProjectRepositoryInterface $projectRepository
    ) {
        $this->middleware(['auth', 'verified']);
    }

    public function index(): Response
    {
        $projects = $this->projectRepository->getProjects([]);
        return Inertia::render('Project/Index', [
            'projects' => $projects,
        ]);
    }

    public function create(): Response
    {
        $this->authorize('create', Project::class);
        
        return Inertia::render('Project/Create', [
            'users' => User::select('id', 'name')->get(),
            "isAdmin" => Auth::user()->isAdmin(),

        ]);
    }

    public function store(ProjectRequest $request): RedirectResponse
    {
        $this->authorize('create', Project::class);

        $data = $request->validated();
        if (!auth()->user()->is_admin) {
            $data['user_id'] = auth()->id();
        }

        $project = new Project($data);
        $this->projectRepository->store($project);

        return redirect()->route('projects.index')
            ->with('success', 'Project created successfully!');
    }

    public function show(Project $project): Response
    {
        $this->authorize('view', $project);
        return Inertia::render('Project/Show', [
            'project' => $project->load('user'),
            'canEdit' => auth()->user()->can('update', $project)
        ]);
    }

    public function edit(Project $project): Response
    {
        $this->authorize('update', $project);
        
        return Inertia::render('Project/Edit', [
            'project' => $project->load('user'),
            'users' => User::select('id', 'name')->get(),
            "isAdmin" => Auth::user()->isAdmin(),

        ]);
    }

    public function update(ProjectRequest $request, Project $project): RedirectResponse
    {
        $this->authorize('update', $project);

        $data = $request->validated();
        if (!auth()->user()->is_admin) {
            $data['user_id'] = $project->user_id;
        }

        $this->projectRepository->update($project, $data);

        return redirect()->route('projects.show', $project)
            ->with('success', 'Project updated successfully!');
    }

    public function destroy(Project $project): RedirectResponse
    {
        $this->authorize('delete', $project);
        $this->projectRepository->delete($project);
        return redirect()->route('projects.index')
            ->with('success', 'Project deactivated successfully!');
    }

    // Example of implementing full soft delete options
    public function restore($projectId): RedirectResponse
    {
        $project = $this->projectRepository->find($projectId);
        $this->authorize('restore', $project);
        $this->projectRepository->restore($project);
        return redirect()->back()
            ->with('success', 'Project restored successfully!');
    }

    public function forceDelete($projectId): RedirectResponse
    {
        $project = $this->projectRepository->find($projectId);
        $this->authorize('forceDelete', $project);
        $this->projectRepository->forceDelete($project);
        return redirect()->route('projects.index')
            ->with('success', 'Project permanently deleted!');
    }
}