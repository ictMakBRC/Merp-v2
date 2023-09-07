<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ProcessDispatchMails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $mail;

    protected $notifiable;

    /**
     * Create a new job instance.
     */
    public function __construct(Mailable $mail, User $notifiable)
    {
        $this->mail = $mail;
        $this->notifiable = $notifiable;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Mail::to($this->notifiable)->send($this->mail);
        } catch (\Throwable $th) {
            //throw $th;
            Log::error("Send Mail Error: ".$th->getMessage());

        }
    }
}
