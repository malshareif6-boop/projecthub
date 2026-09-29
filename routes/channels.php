<?php

// use Illuminate\Support\Facades\Broadcast;

// Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });



use App\Models\Conversation;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

// Broadcast::channel('conversation.{conversationId}', function (User $user, int $conversationId) {
//     $conversation = Conversation::find($conversationId);

//     if (!$conversation) {
//         return false;
//     }

//     // Same rule as ConversationPolicy::view
//     if ($user->role === 'admin') {
//         return true;
//     }

//     return $conversation->hasParticipant($user);
// });

Broadcast::channel('conversation.{conversationId}', function ($user, $conversationId) {
    $conversation = \App\Models\Conversation::find($conversationId);
    if (!$conversation) {
        return false;
    }
    if ($user->role === 'admin') {
        return true;
    }
    return $conversation->hasParticipant($user);
});
