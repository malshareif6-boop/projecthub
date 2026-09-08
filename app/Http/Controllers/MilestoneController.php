<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateMilestoneRequest;
use App\Models\Milestone;

class MilestoneController extends Controller
{
    public function update(UpdateMilestoneRequest $request, Milestone $milestone)
    {
        $milestone->update($request->validated());

        return back()->with('success', 'Milestone updated successfully.');
    }
}
