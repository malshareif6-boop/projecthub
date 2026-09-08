<?php

use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskFileController;
use App\Http\Controllers\TaskFeedbackController;

Route::get('/', function () {
    return view('welcome');
});


/////////


///contact
Route::post('/contact', [App\Http\Controllers\ContactController::class, 'store'])
    ->name('contact.store');
Route::get('/contacts', [App\Http\Controllers\Admin\ContactController::class, 'index'])
    ->name('admin.contacts.index');

Route::patch('/contacts/{contact}/read', [App\Http\Controllers\Admin\ContactController::class, 'markRead'])
    ->name('admin.contacts.read');

Route::delete('/contacts/{contact}', [App\Http\Controllers\Admin\ContactController::class, 'destroy'])
    ->name('admin.contacts.destroy');


/////
Route::get('/auth/{provider}/redirect', [SocialAuthController::class, 'redirect'])
    ->name('social.redirect');

Route::get('/auth/{provider}/callback', [SocialAuthController::class, 'callback'])
    ->name('social.callback');
///////////
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Projects
Route::middleware(['auth'])->group(function () {


    Route::middleware(['role:student'])->group(function () {
        Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
        Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
        Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
        Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
        // Team Management (Owner only)
        Route::post('/projects/{project}/members', [App\Http\Controllers\TeamController::class, 'store'])
            ->name('projects.members.store');
        Route::delete('/projects/{project}/members/{user}', [App\Http\Controllers\TeamController::class, 'destroy'])
            ->name('projects.members.destroy');
    });

    ////////////////////
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
    Route::patch('/projects/{project}/status', [ProjectController::class, 'updateStatus'])->name('projects.status.update');

    // Tasks
    Route::post('/projects/{project}/tasks', [App\Http\Controllers\TaskController::class, 'store'])
        ->name('projects.tasks.store');

    Route::put('/tasks/{task}', [App\Http\Controllers\TaskController::class, 'update'])
        ->name('tasks.update');

    Route::delete('/tasks/{task}', [App\Http\Controllers\TaskController::class, 'destroy'])
        ->name('tasks.destroy');

    // Milestones
    Route::put('/milestones/{milestone}', [App\Http\Controllers\MilestoneController::class, 'update'])
        ->name('milestones.update');

    // Project Files
    Route::post('/projects/{project}/files', [App\Http\Controllers\ProjectFileController::class, 'store'])
        ->name('projects.files.store');

    Route::get('/files/{file}/download', [App\Http\Controllers\ProjectFileController::class, 'download'])
        ->name('files.download');

    Route::delete('/files/{file}', [App\Http\Controllers\ProjectFileController::class, 'destroy'])
        ->name('files.destroy');

    ////
    Route::patch('/projects/{project}/assign-supervisor', [App\Http\Controllers\ProjectController::class, 'assignSupervisor'])
        ->name('projects.assign-supervisor');

    // Feedback
    Route::post('/projects/{project}/feedback', [App\Http\Controllers\FeedbackController::class, 'store'])
        ->name('projects.feedback.store');

    // Evaluation
    Route::post('/projects/{project}/evaluation', [App\Http\Controllers\EvaluationController::class, 'store'])
        ->name('projects.evaluation.store');

    // Task Files
    Route::post('/tasks/{task}/files', [TaskFileController::class, 'store'])
        ->name('tasks.files.store');

    Route::get('/task-files/{file}/download', [TaskFileController::class, 'download'])
        ->name('task-files.download');

    Route::delete('/task-files/{file}', [TaskFileController::class, 'destroy'])
        ->name('task-files.destroy');

    // Task Feedbacks
    Route::post('/tasks/{task}/feedbacks', [TaskFeedbackController::class, 'store'])
        ->name('tasks.feedbacks.store');

    Route::delete('/task-feedbacks/{feedback}', [TaskFeedbackController::class, 'destroy'])
        ->name('task-feedbacks.destroy');
});

// Student Dashboard
Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

//  Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        $stats = [
            'students'    => \App\Models\User::where('role', 'student')->count(),
            'supervisors' => \App\Models\User::where('role', 'supervisor')->count(),
            'projects'    => \App\Models\Project::count(),
            'completed'   => \App\Models\Project::where('status', 'completed')->count(),
        ];

        $recentProjects = \App\Models\Project::with(['owner', 'supervisor'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentProjects'));
    })->name('admin.dashboard');

    Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'index'])
        ->name('admin.users.index');
    Route::get('/users/create', [App\Http\Controllers\Admin\UserController::class, 'create'])
        ->name('admin.users.create');
    Route::post('/users', [App\Http\Controllers\Admin\UserController::class, 'store'])
        ->name('admin.users.store');
    Route::patch('/users/{user}/toggle-active', [App\Http\Controllers\Admin\UserController::class, 'toggleActive'])
        ->name('admin.users.toggle-active');

    Route::get('/projects', function () {
        $projects = \App\Models\Project::with(['owner', 'supervisor', 'members'])
            ->latest()
            ->get();

        return view('admin.projects.index', compact('projects'));
    })->name('admin.projects.index');
});

//  Supervisor
Route::middleware(['auth', 'role:supervisor'])->prefix('supervisor')->group(function () {
    Route::get('/dashboard', function () {
        $projects = \App\Models\Project::with(['owner', 'members'])
            ->where('supervisor_id', auth()->id())
            ->latest()
            ->get();

        return view('supervisor.dashboard', compact('projects'));
    })->name('supervisor.dashboard');
});

require __DIR__ . '/auth.php';
