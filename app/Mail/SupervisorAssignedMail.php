<?php

namespace App\Mail;

use App\Models\Project;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SupervisorAssignedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $supervisor,
        public Project $project,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'You were assigned to a project — ' . $this->project->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.supervisor-assigned',
        );
    }
}
