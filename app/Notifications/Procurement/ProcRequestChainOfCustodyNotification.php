<?php

namespace App\Notifications\Procurement;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProcRequestChainOfCustodyNotification extends Notification
{
    // use Queueable;

    private $reference_no;
    private $from;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($from,$reference_no)
    {
        $this->reference_no = $reference_no;
        $this->from = $from;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
        ->subject('Procurement Request #'.$this->reference_no.' Notification')
        ->greeting('Hello '.$notifiable->name)
        ->line('We would like to inform you that a procurement request #'.$this->reference_no.' forwarded from ['.$this->from.'] requires your attention.')
        ->action('Click to Login', url('/'))
        ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
