<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        $project = $this->route('project');
        return $this->user()->id === $project->owner_id;
    }

    public function rules(): array
    {
        $project = $this->route('project');

        return [
            'title' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string'],
            'assigned_to' => [
                'required',
                'exists:users,id',
                Rule::exists('project_members', 'user_id')->where('project_id', $project->id),
            ],
            'due_date' => ['required', 'date', 'after_or_equal:today'],
        ];
    }

    public function messages(): array
    {
        return [
            'assigned_to.exists' => 'The selected user is not a member of this project.',
            'due_date.after_or_equal' => 'Due date must be today or a future date.',
        ];
    }
}
