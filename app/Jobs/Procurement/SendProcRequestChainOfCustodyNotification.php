<?php

namespace App\Jobs\Procurement;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use App\Notifications\Procurement\ProcRequestChainOfCustodyNotification;

class SendProcRequestChainOfCustodyNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $users;
    private $reference_no;
    private $from;
    /**
     * Create a new job instance.
     */
    public function __construct($from, $reference_no, Collection $users)
    {
        $this->users = $users;
        $this->reference_no = $reference_no;
        $this->from = $from;
    }

    public function handle()
    {
        foreach ($this->users as $user) {

            $user->notify(new ProcRequestChainOfCustodyNotification($this->from, $this->reference_no));
        }
    }

    public function failed(Exception $exception)
    {
        Log::error('Failed to send chain of custody notification email: '.'. Error message: '.$exception->getMessage());
    }
}
