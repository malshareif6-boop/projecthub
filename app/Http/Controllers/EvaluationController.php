<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEvaluationRequest;
use App\Models\Project;

class EvaluationController extends Controller
{
    public function store(StoreEvaluationRequest $request, Project $project)
    {
        $project->evaluation()->updateOrCreate(
            ['project_id' => $project->id],
            [
                'supervisor_id' => $request->user()->id,
                'score' => $request->score,
                'comment' => $request->comment,
            ]
        );

        return back()->with('success', 'Evaluation saved successfully.');
    }
}
