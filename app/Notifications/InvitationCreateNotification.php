<?php

namespace App\Notifications;

use App\Models\Event;
use App\Models\Invitation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InvitationCreateNotification extends Notification
{
    use Queueable;

    private Invitation|Model $invitation;
    private string           $url;
    private Event|Model      $event;

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
        $this->event = $this->invitation->event;

        return (new MailMessage)
            ->greeting('Hello ' . $this->invitation->invitee->name . '!')
            ->subject('Event invitation for "' . $this->event->title . '"')
            ->line('You have been invited to an event on ' . $this->event->start_date->format('d/m/Y') . '. Please click the button below to view the invitation.')
            ->action('Check Invitation', url($this->url))
            ->line('If you have any questions, please contact us.')
            ->line('Just ignore this email if you are not interested in this event.')
            ->line('Thanks!');
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
