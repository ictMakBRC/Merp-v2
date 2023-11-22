<?php

namespace App\Mail\Procurement;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class RfqEmail extends Notification
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
                    ->subject('Procurement Request for Quotation')
                    ->greeting('Hello '.$this->details['provider_name'].'.')
                    ->line('I am writing to request a quotation for the items contained in the attachment on this email:')
                    ->line('Please also include in your quotation the the delivery timeline and the payment terms')
                    ->line('We would appreciate it if you could submit your quotation by '.$this->details['return_deadline'].'.')
                    ->line('Please only send the quotation to the specified email in the attachment.')
                    ->line('Thank you for your time and consideration.')
                    ->attach($this->details['rfq_path'], [
                        'as' => 'RFQ.pdf',
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
