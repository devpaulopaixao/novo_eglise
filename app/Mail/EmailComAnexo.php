<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailComAnexo extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $subject;
    public $content;
    public $filename;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $content, $attachment)
    {
        $this->subject = $subject;
        $this->content = $content;
        $this->filename = (string)$attachment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $file = public_path() . '/mailfolder/' .  $this->filename;

        $email = $this->markdown('email.template')
            ->from(env('MAIL_FROM_ADDRESS'))
            ->subject($this->subject)
            ->with('content', $this->content)
            ->attach($file,[
                'as'=> 'diagnostico.pdf',
                'mime'=> 'application/pdf'
            ]);
        return $email;
    }
}
