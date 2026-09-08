<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFeedbackRequest;
use App\Models\Project;

class FeedbackController extends Controller
{
    public function store(StoreFeedbackRequest $request, Project $project)
    {
        $project->feedbacks()->create([
            'supervisor_id' => $request->user()->id,
            'message' => $request->message,
        ]);

        return back()->with('success', 'Feedback added successfully.');
    }
}
