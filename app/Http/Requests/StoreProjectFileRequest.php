<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectFileRequest extends FormRequest
{
    public function authorize(): bool
    {
        $project = $this->route('project');
        $user = $this->user();

        if ($user->role === 'admin') {
            return true;
        }

        if ($user->role === 'supervisor' && $project->supervisor_id === $user->id) {
            return true;
        }

        return $project->members()->where('user_id', $user->id)->exists();
    }

    public function rules(): array
    {
        return [
            'file' => [
                'required',
                'file',
                'max:10240',
                'mimes:pdf,doc,docx,jpg,jpeg,png',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'file.required' => 'Please select a file.',
            'file.max' => 'File size must not exceed 10 MB.',
            'file.mimes' => 'Allowed types: PDF, DOC, DOCX, md, JPG, JPEG, PNG.',
        ];
    }
}
