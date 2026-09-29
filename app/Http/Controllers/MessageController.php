<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Events\MessageSent as EventsMessageSent;
use App\Http\Requests\StoreMessageRequest;
use App\Http\Requests\StoreMessageRequest as RequestsStoreMessageRequest;
use App\Models\Conversation;
use App\Models\Message;

class MessageController extends Controller
{
    public function store(StoreMessageRequest $request, Conversation $conversation)
    {
        $this->authorize('sendMessage', $conversation);

        $message = $conversation->messages()->create([
            'user_id' => $request->user()->id,
            'body'    => $request->body,
        ]);

        $message->load('user:id,name');

        try {
            broadcast(new MessageSent($message))->toOthers();
        } catch (\Throwable $e) {
            report($e); // يسجّل الخطأ بدون ما يفشل الطلب
        }

        return response()->json([
            'id'         => $message->id,
            'body'       => $message->body,
            'user_id'    => $message->user_id,
            'user_name'  => $message->user->name ?? $request->user()->name,
            'created_at' => $message->created_at->toIso8601String(),
        ], 201);
    }
}
