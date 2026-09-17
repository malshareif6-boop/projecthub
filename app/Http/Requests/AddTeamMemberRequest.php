<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Validator;

class AddTeamMemberRequest extends FormRequest
{
    public function authorize(): bool
    {
        $project = $this->route('project');
        return $this->user()->id === $project->owner_id;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'exists:users,email'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            $email = $this->input('email');
            $project = $this->route('project');

            $student = User::where('email', $email)->first();

            if (!$student) {
                return;
            }

            // must be a student
            if ($student->role !== 'student') {
                $validator->errors()->add('email', 'Only students can be added to a project.');
                return;
            }

            // Already a member of this project?
            if ($project->members()->where('user_id', $student->id)->exists()) {
                $validator->errors()->add('email', 'This student is already a member of this project.');
                return;
            }

            // Already belongs to ANY project
            $alreadyInAnyProject = DB::table('project_members')
                ->where('user_id', $student->id)
                ->exists();

            if ($alreadyInAnyProject) {
                $validator->errors()->add('email', 'This student already belongs to another project.');
                return;
            }

            // Max 5 members
            if ($project->members()->count() >= 5) {
                $validator->errors()->add('email', 'The team has reached the maximum of 5 members.');
            }
        });
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Email is required.',
            'email.exists' => 'No user found with this email.',
        ];
    }
}
