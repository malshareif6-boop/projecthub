<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Milestone;
use App\Models\Project;
use App\Services\ProgressCalculator;
use App\Services\ProjectHealthCalculator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Mail\SupervisorAssignedMail;
use Illuminate\Support\Facades\Mail;


class ProjectController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            $projects = Project::with(['owner', 'supervisor'])->latest()->get();
        } elseif ($user->role === 'supervisor') {
            $projects = Project::where('supervisor_id', $user->id)->with(['owner'])->latest()->get();
        } else {
            $projects = $user->projects()->with(['supervisor'])->latest()->get();
        }

        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(StoreProjectRequest $request)
    {
        $project = DB::transaction(function () use ($request) {
            $project = Project::create([
                'title' => $request->title,
                'description' => $request->description,
                'status' => 'planning',
                'owner_id' => $request->user()->id,
            ]);

            // add owner as member
            $project->members()->attach($request->user()->id);

            $project->conversations()->create(['type' => 'team']);

            // create default milestones
            $defaultMilestones = [
                'Idea',
                'Proposal',
                'Analysis',
                'Development',
                'Testing',
                'Final Submission',
            ];

            foreach ($defaultMilestones as $title) {
                Milestone::create([
                    'project_id' => $project->id,
                    'title' => $title,
                    'deadline' => now()->addMonths(1),
                    'status' => 'pending',
                ]);
            }

            return $project;
        });

        return redirect()->route('projects.show', $project)
            ->with('success', 'Project created successfully.');
    }

    public function show(Project $project)
    {
        $this->authorize('view', $project);

        $project->load([
            'owner',
            'supervisor',
            'members',
            'milestones',
            'tasks.assignee',
            'files.uploader',
            'feedbacks.supervisor',
            'evaluation.supervisor',
            'tasks.files.uploader',
            'tasks.feedbacks.user',
            'tasks.assignee',
            'conversations'
        ]);

        $progress = (new ProgressCalculator())->calculate($project);
        ////
        $healthCalculator = new ProjectHealthCalculator();
        $health = $healthCalculator->calculate($project);
        $overdueCount = $healthCalculator->overdueCount($project);

        return view('projects.show', compact('project', 'progress', 'health', 'overdueCount'));
    }

    public function edit(Project $project)
    {
        $this->authorize('update', $project);

        return view('projects.edit', compact('project'));
    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        $project->update($request->validated());

        return redirect()->route('projects.show', $project)
            ->with('success', 'Project updated successfully.');
    }
    public function updateStatus(Request $request, Project $project)
    {
        $this->authorize('changeStatus', $project);

        $request->validate([
            'status' => ['required', 'in:planning,analysis,development,testing,completed'],
        ]);

        $newStatus = $request->status;

        if (!$project->canTransitionTo($newStatus)) {
            return back()->withErrors(['status' => 'Invalid status transition.']);
        }

        $project->update(['status' => $newStatus]);

        return back()->with('success', 'Project status updated successfully.');
    }

    ///////
    public function assignSupervisor(Request $request, Project $project)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'supervisor_id' => ['required', 'exists:users,id'],
        ]);

        $supervisor = \App\Models\User::findOrFail($request->supervisor_id);

        if ($supervisor->role !== 'supervisor') {
            return back()->withErrors(['supervisor_id' => 'Selected user is not a supervisor.']);
        }

        $project->update([
            'supervisor_id' => $supervisor->id,
        ]);
        $project->conversations()->firstOrCreate(['type' => 'supervisor']);

        $project->load('supervisor', 'owner');
        if ($project->supervisor_id) {
            Mail::to($project->supervisor)
                ->queue(new SupervisorAssignedMail($project->supervisor, $project));
        }

        return back()->with('success', 'Supervisor assigned successfully.');
    }
}
