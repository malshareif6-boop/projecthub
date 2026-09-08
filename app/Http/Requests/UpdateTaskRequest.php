<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        $task = $this->route('task');
        $project = $task->project;

        // Owner can update anything, assignee can only update status
        return $this->user()->id === $project->owner_id
            || $this->user()->id === $task->assigned_to;
    }

    public function rules(): array
    {
        $task = $this->route('task');
        $project = $task->project;
        $isOwner = $this->user()->id === $project->owner_id;

        if ($isOwner) {
            return [
                'title' => ['required', 'string', 'max:150'],
                'description' => ['nullable', 'string'],
                'assigned_to' => [
                    'required',
                    'exists:users,id',
                    Rule::exists('project_members', 'user_id')->where('project_id', $project->id),
                ],
                'status' => ['required', 'in:pending,in_progress,completed'],
                'due_date' => ['required', 'date'],
            ];
        }

        // Assignee can only change status
        return [
            'status' => ['required', 'in:pending,in_progress,completed'],
        ];
    }
}
