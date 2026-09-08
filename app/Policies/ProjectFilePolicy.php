<?php

namespace App\Policies;

use App\Models\ProjectFile;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProjectFilePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ProjectFile $projectFile): bool
    {
        $project = $projectFile->project;

        if ($user->role === 'admin') {
            return true;
        }

        if ($user->role === 'supervisor' && $project->supervisor_id === $user->id) {
            return true;
        }

        return $project->members()->where('user_id', $user->id)->exists();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ProjectFile $projectFile): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ProjectFile $projectFile): bool
    {
        $project = $projectFile->project;

        if ($user->role === 'admin') {
            return true;
        }

        // Uploader or project owner
        return $user->id === $projectFile->uploaded_by
            || $user->id === $project->owner_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ProjectFile $projectFile): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ProjectFile $projectFile): bool
    {
        return false;
    }
}
