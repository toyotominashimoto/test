<?php

namespace App\Jobs;

use App\Mail\SendMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class QueueSenderEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $mess;
    public $to;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($view, $mess, $to, $data)
    {
        $this->view = $view;
        $this->mess = $mess;
        $this->to = $to;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $mm = new SendMail($this->view, $this->mess, $this->data);
        Mail::to($this->to)->send($mm);
    }
}
