<?php

namespace App\Policies;

use App\Models\Conversation;
use App\Models\User;

class ConversationPolicy
{
    public function view(User $user, Conversation $conversation): bool
    {
        if ($user->role === 'admin') {
            return true;
        }

        return $conversation->hasParticipant($user);
    }

    public function sendMessage(User $user, Conversation $conversation): bool
    {
        // Admin can view but not post (per plan)
        if ($user->role === 'admin') {
            return false;
        }

        return $conversation->hasParticipant($user);
    }
}
