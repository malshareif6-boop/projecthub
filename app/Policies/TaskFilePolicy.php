<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\TaskFile;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TaskFilePolicy
{



    private function canAccessTask(User $user, Task $task): bool
    {
        if ($user->role === 'admin') {
            return true;
        }

        $project = $task->project;

        if ($user->role === 'supervisor' && $project->supervisor_id === $user->id) {
            return true;
        }

        return $project->members()->where('user_id', $user->id)->exists()
            || $project->owner_id === $user->id;
    }
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
    public function view(User $user, TaskFile $file): bool
    {
        return $this->canAccessTask($user, $file->task);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Task $task): bool
    {
        return $this->canAccessTask($user, $task);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TaskFile $taskFile): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TaskFile $file): bool
    {
        if ($user->role === 'admin') {
            return true;
        }

        $project = $file->task->project;

        return $file->uploaded_by === $user->id
            || $project->owner_id === $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, TaskFile $taskFile): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, TaskFile $taskFile): bool
    {
        return false;
    }
}
