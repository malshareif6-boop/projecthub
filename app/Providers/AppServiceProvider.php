<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\TaskFile;
use App\Models\TaskFeedback;
use App\Policies\TaskFilePolicy;
use App\Policies\TaskFeedbackPolicy;
use App\Models\Conversation;
use App\Policies\ConversationPolicy;
use Illuminate\Support\Facades\Broadcast;
use App\Http\Responses\FortifyLoginResponse;
use Laravel\Fortify\Contracts\LoginResponse;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(LoginResponse::class, FortifyLoginResponse::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(TaskFile::class, TaskFilePolicy::class);
        Gate::policy(TaskFeedback::class, TaskFeedbackPolicy::class);
        Gate::policy(Conversation::class, ConversationPolicy::class);

        Broadcast::routes(['middleware' => ['web', 'auth']]);

        $this->app->singleton(LoginResponse::class, FortifyLoginResponse::class);
    }
}
