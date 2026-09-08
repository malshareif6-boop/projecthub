<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\TaskFeedback;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TaskFeedbackPolicy
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
    public function view(User $user, TaskFeedback $feedback): bool
    {
        return $this->canAccessTask($user, $feedback->task);
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
    public function update(User $user, TaskFeedback $taskFeedback): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TaskFeedback $feedback): bool
    {
        if ($user->role === 'admin') {
            return true;
        }

        $project = $feedback->task->project;


        return $feedback->user_id === $user->id
            || $project->owner_id === $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, TaskFeedback $taskFeedback): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, TaskFeedback $taskFeedback): bool
    {
        return false;
    }
}
