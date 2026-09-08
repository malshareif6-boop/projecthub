<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskFeedbackRequest extends FormRequest
{
    public function authorize(): bool
    {
        $task = $this->route('task');

        return $this->user()->can('create', [\App\Models\TaskFeedback::class, $task]);
    }

    public function rules(): array
    {
        return [
            'message' => ['required', 'string', 'min:3', 'max:2000'],
        ];
    }

    public function messages(): array
    {
        return [
            'message.required' => 'Please write a feedback message.',
            'message.min'      => 'Feedback must be at least 3 characters.',
            'message.max'      => 'Feedback may not be greater than 2000 characters.',
        ];
    }
}
