<?php

namespace App\Mail\Procurement;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class LpoEmail extends Notification
{
    use Queueable;

    private $details;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Local Purchase Order')
                    ->greeting('Hello '.$this->details['provider_name'].'.')
                    ->line('We are pleased to inform you that you have been selected as the best bidder for the local purchase order (LPO) #'.$this->details['lpo_no'].'.')
                    ->line('Please find attached the LPO for your reference and processing')
                    ->line('We look forward to working with you to fulfill this LPO.')
                    ->attach($this->details['lpo_path'], [
                        'as' => 'LPO.pdf',
                        'mime' => 'application/pdf',
                    ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
