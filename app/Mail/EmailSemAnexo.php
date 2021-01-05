<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailSemAnexo extends Mailable
{
    use Queueable, SerializesModels;
    public $subject;
    public $content;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $content)
    {
        $this->subject = $subject;
        $this->content = $content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = $this->markdown('email.template')
            ->from(env('MAIL_FROM_ADDRESS'))
            ->subject($this->subject)
            ->with('content', $this->content);

        return $email;
    }
}
