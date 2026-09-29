<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class Conversation extends Model
{
    protected $fillable = ['project_id', 'type'];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function reads(): HasMany
    {
        return $this->hasMany(ConversationRead::class);
    }

    /** Participants derived from project — single source of truth */
    public function participants(): Collection
    {
        $this->loadMissing('project.members', 'project.owner', 'project.supervisor');

        if ($this->type === 'team') {
            return $this->project->members;
        }

        // supervisor chat = owner + supervisor only
        return collect([
            $this->project->owner,
            $this->project->supervisor,
        ])->filter()->unique('id')->values();
    }

    public function hasParticipant(User $user): bool
    {
        return $this->participants()->contains('id', $user->id);
    }
}
