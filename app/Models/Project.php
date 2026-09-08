<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Feedback;
use App\Models\Evaluation;

class Project extends Model
{
    protected $fillable = [
        'title',
        'description',
        'status',
        'owner_id',
        'supervisor_id',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function supervisor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'project_members')->withTimestamps();
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function milestones(): HasMany
    {
        return $this->hasMany(Milestone::class);
    }

    public function files(): HasMany
    {
        return $this->hasMany(ProjectFile::class);
    }

    public function feedbacks(): HasMany
    {
        return $this->hasMany(Feedback::class);
    }

    public function evaluation(): HasOne
    {
        return $this->hasOne(Evaluation::class);
    }

    //  allowed status transitions
    public static function allowedTransitions(): array
    {
        return [
            'planning'     => ['analysis'],
            'analysis'     => ['development', 'planning'],
            'development'  => ['testing', 'analysis'],
            'testing'      => ['completed', 'development'],
            'completed'    => ['testing'],
        ];
    }

    public function canTransitionTo(string $newStatus): bool
    {
        $allowed = self::allowedTransitions()[$this->status] ?? [];
        return in_array($newStatus, $allowed);
    }
}
