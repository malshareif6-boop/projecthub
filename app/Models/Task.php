<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\TaskFile;
use App\Models\TaskFeedback;

class Task extends Model
{
    protected $fillable = [
        'project_id',
        'assigned_to',
        'title',
        'description',
        'status',
        'due_date',
    ];

    protected $casts = [
        'due_date' => 'date',
    ];
    protected static function booted(): void
    {
        static::deleting(function (Task $task) {
            foreach ($task->files as $file) {
                \Illuminate\Support\Facades\Storage::disk('local')->delete($file->stored_path);
            }
        });
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function files(): HasMany
    {
        return $this->hasMany(TaskFile::class);
    }

    public function feedbacks(): HasMany
    {
        return $this->hasMany(TaskFeedback::class);
    }
}
