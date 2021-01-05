<?php

namespace App\Jobs;

use App\Mail\EmailSemAnexo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class MaturidadeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $receiver;
    public $subject;
    public $content;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($dest, $subject, $content)
    {
        $this->receiver = $dest;
        $this->subject = $subject;
        $this->content = $content;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->receiver)
            ->send(new EmailSemAnexo($this->subject, $this->content));
    }
}
