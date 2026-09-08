<?php

namespace App\Services;

use App\Models\Project;

class ProjectHealthCalculator
{
    public function calculate(Project $project): string
    {
        // Completed projects always show Good
        if (strtolower($project->status) === 'completed') {
            return 'Good';
        }

        $overdueCount = $project->tasks()
            ->where('due_date', '<', now()->toDateString())
            ->where('status', '!=', 'completed')
            ->count();

        if ($overdueCount >= 3) {
            return 'Critical';
        }

        if ($overdueCount >= 1) {
            return 'Needs Attention';
        }

        return 'Good';
    }

    public function overdueCount(Project $project): int
    {
        if (strtolower($project->status) === 'completed') {
            return 0;
        }

        return $project->tasks()
            ->where('due_date', '<', now()->toDateString())
            ->where('status', '!=', 'completed')
            ->count();
    }
}
