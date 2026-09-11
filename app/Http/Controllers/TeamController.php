<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddTeamMemberRequest;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeamController extends Controller
{
    public function store(AddTeamMemberRequest $request, Project $project)
    {
        $student = User::where('email', $request->email)->firstOrFail();

        // Re check

        DB::transaction(function () use ($project, $student) {

            $alreadyInAnyProject = DB::table('project_members')
                ->where('user_id', $student->id)
                ->exists();

            if ($alreadyInAnyProject) {
                abort(422, 'This student already belongs to another project.');
            }


            if ($project->members()->count() >= 5) {
                abort(422, 'The team has reached the maximum of 5 members.');
            }

            $project->members()->attach($student->id);
        });

        return back()->with('success', $student->name . ' has been added to the team.');
    }

    public function destroy(Project $project, User $user)
    {
        // Only owner can remove members
        if (auth()->id() !== $project->owner_id) {
            abort(403);
        }

        // Cannot remove the owner
        if ($user->id === $project->owner_id) {
            return back()->withErrors(['team' => 'You cannot remove the project owner.']);
        }

        $project->members()->detach($user->id);

        return back()->with('success', $user->name . ' has been removed from the team.');
    }
}
