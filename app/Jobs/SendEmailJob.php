<?php

namespace App\Jobs;

use App\Mail\SendMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

/*
    this page SendEmailJob handle email in the queue
*/

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $data;
    protected $attachment;
    /**
     * Create a new job instance.
     */
    public function __construct($data, $attachment)
    {
        $this->data = $data;
        $this->attachment = $attachment;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $mailable = new SendMail($this->data, $this->attachment);
        Mail::to($this->data['email'])->send($mailable);
    }
}
