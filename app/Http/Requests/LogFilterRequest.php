<?php

namespace App\Http\Requests;

use App\Enums\SeverityLevel;
use Illuminate\Foundation\Http\FormRequest;

class LogFilterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'severity' => 'nullable|integer|in:'.implode(',', SeverityLevel::values()),
            'project_id' => 'nullable|integer|exists:projects,id',
            'user_id' => 'nullable|integer|exists:users,id', 
            'search' => 'nullable|string|max:255',
            'sort_by' => 'nullable|string|in:created_at,severity_level',
            'sort_order' => 'nullable|string|in:asc,desc',
        ];
    }

    public function messages(): array
    {
        return [
            'severity.in' => 'Invalid severity level selected',
            'project_id.exists' => 'Selected project does not exist',
            'user_id.exists' => 'Selected user does not exist',
            'sort_by.in' => 'Invalid sort column selected',
            'sort_order.in' => 'Invalid sort direction selected',
        ];
    }
}