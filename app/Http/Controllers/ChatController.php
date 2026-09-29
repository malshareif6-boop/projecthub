<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Project;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function show(Request $request, Project $project, string $type)
    {
        if (! in_array($type, ['team', 'supervisor'], true)) {
            abort(404);
        }

        $conversation = $project->conversations()
            ->where('type', $type)
            ->firstOrFail();

        $this->authorize('view', $conversation);

        $messages = $conversation->messages()
            ->with('user:id,name')
            ->orderBy('created_at')
            ->get();

        // optional: mark as read
        $conversation->reads()->updateOrCreate(
            ['user_id' => $request->user()->id],
            ['last_read_at' => now()]
        );

        $messages = $conversation->messages()
            ->with('user:id,name')
            ->orderBy('created_at')
            ->get();

        $messagesJson = $messages->map(function ($m) {
            return [
                'id'         => $m->id,
                'body'       => $m->body,
                'user_id'    => $m->user_id,
                'user_name'  => $m->user->name ?? 'User',
                'created_at' => $m->created_at->toIso8601String(),
            ];
        })->values();

        return view('projects.chat', compact('project', 'conversation', 'messages', 'messagesJson', 'type'));
    }
}
