<?php

namespace App\Http\Requests;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LogStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    // The logic of adding logs through api is that editor can only add logs for their own projects, while admin can add log, on all project in your or peojcect owner name
    public function rules(): array
    {
        $user = $this->user();
        $projectId = $this->input('project_id');

        $userIdRules = ['nullable', 'integer'];

        if ($user->isAdmin()) {
            $project = Project::findOrFail($projectId);
            $allowedUserIds = [$user->id, $project->user_id];

            $userIdRules[] = Rule::exists('users', 'id')->whereIn('id', $allowedUserIds);
        } else {
            $userIdRules[] = Rule::exists('users', 'id')->where(function ($query) use ($projectId) {
                $query->whereExists(function ($subQuery) use ($projectId) {
                    $subQuery->select('id')
                        ->from('projects')
                        ->whereColumn('projects.user_id', 'users.id')
                        ->where('projects.id', $projectId);
                });
            });
        }

        return [
            'project_id' => 'required|exists:projects,id',
            'severity_level' => 'required|integer',
            'message' => 'required|string|max:1000',
            'user_id' => $userIdRules,
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.exists' => 'The selected user must be admin or the project owner'
        ];
    }

    protected function prepareForValidation()
    {
        $user = $this->user();
        
        if (!$this->has('user_id')) {
            $this->merge(['user_id' => $user->id]);
        }
    }
}