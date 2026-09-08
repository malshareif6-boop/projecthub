<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class StoreProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Student can only create if they don't already belong to any project
        $alreadyInProject = DB::table('project_members')
            ->where('user_id', $this->user()->id)
            ->exists();

        return $this->user()->role === 'student' && !$alreadyInProject;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Project title is required.',
        ];
    }
}
