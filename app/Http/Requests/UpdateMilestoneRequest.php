<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMilestoneRequest extends FormRequest
{
    public function authorize(): bool
    {
        $milestone = $this->route('milestone');
        return $this->user()->id === $milestone->project->owner_id;
    }

    public function rules(): array
    {
        return [
            'status' => ['required', 'in:pending,in_progress,completed'],
            'deadline' => ['required', 'date'],
        ];
    }
}
