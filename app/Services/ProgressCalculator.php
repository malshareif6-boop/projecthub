<?php

namespace App\Services;

use App\Models\Project;

class ProgressCalculator
{
    public function calculate(Project $project): int
    {
        $totalTasks = $project->tasks()->count();

        if ($totalTasks === 0) {
            return 0;
        }

        $completedTasks = $project->tasks()
            ->where('status', 'completed')
            ->count();

        return (int) round(($completedTasks / $totalTasks) * 100);
    }
}
