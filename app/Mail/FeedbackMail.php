<?php

namespace App\Mail;

use App\Feedback;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class FeedbackMail extends Mailable
{
    use Queueable, SerializesModels;

    private $feedback;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Feedback $feedback)
    {
        $this->feedback = $feedback;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = config('app.name').". {$this->feedback->categoria->descripcion}. #{$this->feedback->id}";
        return $this->subject($subject)
                    // ->from($this->feedback->user->email)
                    ->view('feedback.email')
                    ->text('feedback.email_plain')
                    ->with('feedback', $this->feedback);
    }
}
