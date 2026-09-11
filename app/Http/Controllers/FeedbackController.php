<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFeedbackRequest;
use App\Models\Project;
use App\Models\Feedback;

class FeedbackController extends Controller
{
    public function store(StoreFeedbackRequest $request, Project $project)
    {
        $this->authorize('create', [Feedback::class, $project]);
        $project->feedbacks()->create([
            'supervisor_id' => $request->user()->id,
            'message' => $request->message,
        ]);

        return back()->with('success', 'Feedback added successfully.');
    }
    public function destroy(Feedback $feedback)
    {
        // $user = Auth()->user();


        // $allowed = $user->role === 'admin'
        //     || $feedback->supervisor_id === $user->id;

        // if (!$allowed) {
        //     abort(403);
        // }
        $this->authorize('delete', $feedback);

        $feedback->delete();

        return back()->with('success', 'Feedback deleted successfully.');
    }
}
