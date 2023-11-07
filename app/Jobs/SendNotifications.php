<?php

namespace App\Jobs;

use Throwable;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\Finance\SendNotificationEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SendNotifications implements ShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $details;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($notification)
    {
        $this->details = $notification;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Notification::route('mail', $this->details['to'])->notify(new StatusNotification($this->details));
        // WhatAppMessageService::sendReferralMessage($this->details);
        try {
            Mail::to($this->details['to'])->send(new SendNotificationEmail($this->details));
        } catch (Throwable $error) {
            Log::error('Failed to send referral status email. Error message: '.$error->getMessage());
        }
    }

    public function failed(\Exception $exception)
    {
        Log::error('Failed to send referral status email. Error message: '.$exception->getMessage());
    }
}
