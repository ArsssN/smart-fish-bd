<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use function Symfony\Component\Translation\t;

class InviteeOTPNotification extends Notification
{
    use Queueable;

    private        $invitation;
    private string $url;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($invitation, $url)
    {
        $this->invitation = $invitation;
        $this->url        = $url;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(t('Invitee OTP for event: ' . $this->invitation->event->title))
            ->line(t('Your OTP is: ' . $this->invitation->invitationOtp->otp))
            ->action('Verify', $this->url)
            ->line('Thank you for using our application!');
    }

    /*
     * toSMS
     */
    public function toSMS($notifiable)
    {
        return (new SMSMessage)
            ->content('Your OTP is: ' . $this->invitation->invitationOtp->otp);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
