<?php

namespace App\Jobs;

use App\Mail\EmailComAnexo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ResultadoComAnexo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    //public $tries = 3;
    public $receiver;
    public $subject;
    public $content;
    public $filename;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($dest, $subject, $content, $attachment)
    {
        $this->receiver = $dest;
        $this->subject = $subject;
        $this->content = $content;
        $this->filename = (string) $attachment;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->receiver)
            ->send(new EmailComAnexo($this->subject, $this->content, $this->filename));
    }
}
