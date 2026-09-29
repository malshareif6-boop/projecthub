<?php

use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Auth\EmailOtpController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\MilestoneController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectFileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskFeedbackController;
use App\Http\Controllers\TaskFileController;
use App\Http\Controllers\TeamController;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Route;

///////////////////////
//test reverb
Route::get('/broadcast-test', function () {
    return view('broadcast-test');
})->middleware('auth');
/*
////////////////////////////////
| Public
///////////////////*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('/contact', [ContactController::class, 'store'])
    ->name('contact.store');
/////////////////////////




Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/projects/{project}/chat/{type}', [ChatController::class, 'show'])
        ->name('projects.chat');

    Route::post('/conversations/{conversation}/messages', [MessageController::class, 'store'])
        ->name('messages.store');
});
////////////////////////////////////////

Route::middleware('auth')->group(function () {
    Route::get('/email/otp', [EmailOtpController::class, 'show'])->name('verification.otp');
    Route::post('/email/otp', [EmailOtpController::class, 'verify'])->name('verification.otp.verify');
    Route::post('/email/otp/resend', [EmailOtpController::class, 'resend'])->name('verification.otp.resend');
});



/*
//////////////////////////////
| Social auth
|////////////////////
*/

Route::get('/auth/{provider}/redirect', [SocialAuthController::class, 'redirect'])
    ->name('social.redirect');

Route::get('/auth/{provider}/callback', [SocialAuthController::class, 'callback'])
    ->name('social.callback');

/*
|///////////////////////////////
| Authenticated  profile
|///////////////////////
*/

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|///////////////////////////////////////////////////////////////////
| Authenticated  projects
|/////////////////////////////////////
*/

Route::middleware(['auth', 'verified'])->group(function () {



    // Student only
    Route::middleware(['role:student'])->group(function () {
        Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
        Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
        Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
        Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');

        Route::post('/projects/{project}/members', [TeamController::class, 'store'])
            ->name('projects.members.store');
        Route::delete('/projects/{project}/members/{user}', [TeamController::class, 'destroy'])
            ->name('projects.members.destroy');
    });

    // Projects
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
    Route::patch('/projects/{project}/status', [ProjectController::class, 'updateStatus'])->name('projects.status.update');
    Route::patch('/projects/{project}/assign-supervisor', [ProjectController::class, 'assignSupervisor'])->name('projects.assign-supervisor');

    // Tasks
    Route::post('/projects/{project}/tasks', [TaskController::class, 'store'])->name('projects.tasks.store');
    Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');

    // Task files
    Route::post('/tasks/{task}/files', [TaskFileController::class, 'store'])->name('tasks.files.store');
    Route::get('/task-files/{file}/download', [TaskFileController::class, 'download'])->name('task-files.download');
    Route::delete('/task-files/{file}', [TaskFileController::class, 'destroy'])->name('task-files.destroy');

    // Task feedback
    Route::post('/tasks/{task}/feedbacks', [TaskFeedbackController::class, 'store'])->name('tasks.feedbacks.store');
    Route::delete('/task-feedbacks/{feedback}', [TaskFeedbackController::class, 'destroy'])->name('task-feedbacks.destroy');

    // Milestones
    Route::put('/milestones/{milestone}', [MilestoneController::class, 'update'])->name('milestones.update');

    // Project files
    Route::post('/projects/{project}/files', [ProjectFileController::class, 'store'])->name('projects.files.store');
    Route::get('/files/{file}/download', [ProjectFileController::class, 'download'])->name('files.download');
    Route::delete('/files/{file}', [ProjectFileController::class, 'destroy'])->name('files.destroy');

    // Feedback
    Route::post('/projects/{project}/feedback', [FeedbackController::class, 'store'])->name('projects.feedback.store');
    Route::delete('/feedbacks/{feedback}', [FeedbackController::class, 'destroy'])
        ->name('feedbacks.destroy');
    // Evaluation
    Route::post('/projects/{project}/evaluation', [EvaluationController::class, 'store'])->name('projects.evaluation.store');
});

/*
|////////////////////////////////////////
| Student dashboard
|/////////////////////////////
*/

Route::middleware(['auth', 'role:student', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

/*
|///////////////////////////////////////////
| Admin
|////////////////////////////
*/

Route::middleware(['auth', 'role:admin', 'verified'])->prefix('admin')->group(function () {

    Route::get('/dashboard', function () {
        $stats = [
            'students'    => User::where('role', 'student')->count(),
            'supervisors' => User::where('role', 'supervisor')->count(),
            'projects'    => Project::count(),
            'completed'   => Project::where('status', 'completed')->count(),
        ];

        $recentProjects = Project::with(['owner', 'supervisor'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentProjects'));
    })->name('admin.dashboard');

    Route::get('/projects', function () {
        $projects = Project::with(['owner', 'supervisor', 'members'])
            ->latest()
            ->get();

        return view('admin.projects.index', compact('projects'));
    })->name('admin.projects.index');

    // Users
    Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::get('/users/create', [AdminUserController::class, 'create'])->name('admin.users.create');
    Route::post('/users', [AdminUserController::class, 'store'])->name('admin.users.store');
    Route::patch('/users/{user}/toggle-active', [AdminUserController::class, 'toggleActive'])->name('admin.users.toggle-active');

    //contact
    Route::get('/contacts', [AdminContactController::class, 'index'])
        ->name('admin.contacts.index');

    Route::patch('/contacts/{contact}/read', [AdminContactController::class, 'markRead'])
        ->name('admin.contacts.read');

    Route::delete('/contacts/{contact}', [AdminContactController::class, 'destroy'])
        ->name('admin.contacts.destroy');
});

/*
|/////////////////////////////////////////////////
|// Supervisor
|/////////////////////////////////////////
*/

Route::middleware(['auth', 'role:supervisor', 'verified'])->prefix('supervisor')->group(function () {
    Route::get('/dashboard', function () {
        $projects = Project::with(['owner', 'members'])
            ->where('supervisor_id', auth()->id())
            ->latest()
            ->get();

        return view('supervisor.dashboard', compact('projects'));
    })->name('supervisor.dashboard');
});

require __DIR__ . '/auth.php';
