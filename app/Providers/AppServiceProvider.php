<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\TaskFile;
use App\Models\TaskFeedback;
use App\Policies\TaskFilePolicy;
use App\Policies\TaskFeedbackPolicy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(TaskFile::class, TaskFilePolicy::class);
        Gate::policy(TaskFeedback::class, TaskFeedbackPolicy::class);
    }
}
