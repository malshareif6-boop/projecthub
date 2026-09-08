<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskFeedbackRequest;
use App\Models\Task;
use App\Models\TaskFeedback;

class TaskFeedbackController extends Controller
{
    public function store(StoreTaskFeedbackRequest $request, Task $task)
    {
        $this->authorize('create', [TaskFeedback::class, $task]);

        TaskFeedback::create([
            'task_id' => $task->id,
            'user_id' => $request->user()->id,
            'message' => $request->validated('message'),
        ]);

        return back()->with('success', 'Feedback added to task successfully.');
    }

    public function destroy(TaskFeedback $feedback)
    {
        $this->authorize('delete', $feedback);

        $feedback->delete();

        return back()->with('success', 'Task feedback deleted successfully.');
    }
}
